<?php

namespace App\Http\Controllers;

use App\Support\CloudflareR2Storage;
use App\Support\PlatformSettings;
use Illuminate\Filesystem\FilesystemAdapter;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules\Password;
use Illuminate\View\View;
use RuntimeException;

class StudentSettingsController extends Controller
{
    public function settings(Request $request): View
    {
        $student = $request->user();

        $learningStats = [
            'courses' => $student->enrollments()->count(),
            'completed' => $student->certificates()->count(),
        ];

        return view('student.seeting', [
            'student' => $student,
            'profileAvatar' => $student->avatarUrl(160),
            'learningStats' => $learningStats,
        ]);
    }

    public function updateProfile(Request $request): RedirectResponse
    {
        $student = $request->user();
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email,'.$student->id],
            'bio' => ['nullable', 'string', 'max:1000'],
            'avatar' => ['nullable', 'image', 'max:5120'],
            'two_factor_enabled' => ['nullable', 'boolean'],
        ]);

        $payload = [
            'name' => $validated['name'],
            'email' => $validated['email'],
            'bio' => $validated['bio'] ?? null,
            'two_factor_enabled' => $request->boolean('two_factor_enabled'),
        ];

        if ($request->hasFile('avatar')) {
            try {
                $payload['avatar_path'] = $this->uploadAvatarByConfiguredProvider(
                    $request->file('avatar'),
                    $student->id,
                    $validated['name']
                );
            } catch (RuntimeException $exception) {
                return back()
                    ->withErrors(['avatar' => $exception->getMessage()])
                    ->withInput();
            }
        }

        $student->update($payload);

        Log::info('Student profile updated', [
            'student_id' => $student->id,
            'student_email' => $student->email,
            'two_factor_enabled' => $payload['two_factor_enabled'],
        ]);

        return redirect()
            ->route('student.settings')
            ->with('status', 'Profile updated successfully.');
    }

    public function updatePassword(Request $request): RedirectResponse
    {
        $student = $request->user();
        $validated = $request->validate([
            'current_password' => ['required'],
            'password' => ['required', 'confirmed', $this->passwordRule()],
        ]);

        if (! Hash::check($validated['current_password'], $student->password)) {
            return back()->withErrors([
                'current_password' => 'The current password is incorrect.',
            ])->withInput();
        }

        $student->update([
            'password' => $validated['password'],
        ]);

        Log::warning('Student password updated', [
            'student_id' => $student->id,
            'student_email' => $student->email,
        ]);

        return redirect()
            ->route('student.settings')
            ->with('status', 'Password updated successfully.');
    }

    private function passwordRule(): Password
    {
        return Password::min(10)
            ->mixedCase()
            ->numbers()
            ->symbols();
    }

    private function uploadAvatarByConfiguredProvider(UploadedFile $file, int $userId, string $name): string
    {
        $provider = $this->normalizeAvatarProvider(
            PlatformSettings::string('student_avatar_upload_provider', 'cloudinary')
        );

        return match ($provider) {
            'local' => $this->uploadAvatarToLocal($file, $userId, $name),
            'cloudinary' => $this->uploadAvatarToCloudinary($file, $userId, $name),
            default => $this->uploadAvatarToR2($file, $userId, $name),
        };
    }

    private function uploadAvatarToR2(UploadedFile $file, int $userId, string $name): string
    {
        $folder = trim((string) config('services.cloudflare_r2.avatar_folder', 'lms/avatars'), '/');
        $extension = strtolower((string) ($file->getClientOriginalExtension() ?: $file->extension() ?: 'jpg'));
        $path = $folder.'/student-'.Str::slug($name !== '' ? $name : 'user').'-'.$userId.'-avatar.'.$extension;

        return CloudflareR2Storage::uploadPublicFile($file, $path, [
            'allowed_extensions' => ['jpg', 'jpeg', 'png', 'webp', 'gif'],
            'allowed_mime_types' => ['image/jpeg', 'image/png', 'image/webp', 'image/gif'],
            'max_bytes' => 5 * 1024 * 1024,
        ]);
    }

    private function uploadAvatarToLocal(UploadedFile $file, int $userId, string $name): string
    {
        $folder = trim((string) config('services.cloudflare_r2.avatar_folder', 'lms/avatars'), '/');
        $extension = strtolower((string) ($file->getClientOriginalExtension() ?: $file->extension() ?: 'jpg'));
        $filename = 'student-'.Str::slug($name !== '' ? $name : 'user').'-'.$userId.'-avatar.'.$extension;

        /** @var FilesystemAdapter $publicDisk */
        $publicDisk = Storage::disk('public');
        $stored = $publicDisk->putFileAs($folder, $file, $filename, ['visibility' => 'public']);

        if (! $stored) {
            throw new RuntimeException('Local upload failed. Please try again.');
        }

        return $publicDisk->url($stored);
    }

    private function uploadAvatarToCloudinary(UploadedFile $file, int $userId, string $name): string
    {
        $cloudName = (string) config('services.cloudinary.cloud_name');
        $apiKey = (string) config('services.cloudinary.api_key');
        $apiSecret = (string) config('services.cloudinary.api_secret');

        if ($cloudName === '' || $apiKey === '' || $apiSecret === '') {
            throw new RuntimeException('Cloudinary is not configured. Add CLOUDINARY_CLOUD_NAME, CLOUDINARY_API_KEY, and CLOUDINARY_API_SECRET first.');
        }

        $baseFolder = trim((string) config('services.cloudinary.folder', 'lms/media'), '/');
        $targetFolder = trim($baseFolder.'/avatars', '/');
        $publicId = 'student-'.Str::slug($name !== '' ? $name : 'user').'-'.$userId.'-avatar-'.Str::lower(Str::random(8));
        $timestamp = time();

        $signaturePayload = [
            'folder' => $targetFolder,
            'public_id' => $publicId,
            'timestamp' => $timestamp,
        ];
        ksort($signaturePayload);

        $signature = sha1(collect($signaturePayload)
            ->map(fn ($value, $key) => $key.'='.$value)
            ->implode('&').$apiSecret);

        $response = Http::asMultipart()
            ->attach('file', fopen($file->getRealPath(), 'r'), $file->getClientOriginalName())
            ->post('https://api.cloudinary.com/v1_1/'.$cloudName.'/image/upload', [
                'api_key' => $apiKey,
                'timestamp' => $timestamp,
                'folder' => $targetFolder,
                'public_id' => $publicId,
                'signature' => $signature,
            ]);

        if ($response->failed()) {
            throw new RuntimeException($response->json('error.message') ?: 'Cloudinary upload failed. Please try again.');
        }

        return (string) ($response->json('secure_url') ?: $response->json('url') ?: '');
    }

    private function normalizeAvatarProvider(string $provider): string
    {
        return match (strtolower(trim($provider))) {
            'cloudinary' => 'cloudinary',
            'local' => 'local',
            'cloudflare', 'cloud' => 'cloudflare',
            default => 'cloudinary',
        };
    }
}
