<?php

namespace App\Http\Controllers;

use App\Models\Inquiry;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Illuminate\View\View;
use RuntimeException;

class InstructorCommunicationController extends Controller
{
    public function messages(Request $request): View
    {
        $instructor = $request->user();
        $courseIds = $instructor->courses()->pluck('id');

        $inquiries = Inquiry::query()
            ->whereIn('course_id', $courseIds)
            ->with(['course:id,title', 'user:id,name,email'])
            ->latest()
            ->get();

        $activeInquiry = $inquiries->firstWhere('id', $request->integer('inquiry'));

        if (! $activeInquiry) {
            $activeInquiry = $inquiries->first();
        }

        return view('instructor.messages', [
            'inquiries' => $inquiries,
            'activeInquiry' => $activeInquiry,
            'profileAvatar' => $instructor->avatarUrl(96),
            'instructorName' => $instructor->name,
            'openCount' => $inquiries->where('status', 'pending')->count(),
            'resolvedCount' => $inquiries->where('status', 'resolved')->count(),
        ]);
    }

    public function reply(Request $request, Inquiry $inquiry): RedirectResponse
    {
        abort_unless($request->user()->courses()->where('courses.id', $inquiry->course_id)->exists(), 403);

        $validated = $request->validate([
            'admin_reply' => ['required', 'string', 'max:5000'],
            'status' => ['nullable', 'in:pending,resolved'],
        ]);

        $inquiry->update([
            'admin_reply' => $validated['admin_reply'],
            'status' => $validated['status'] ?? 'resolved',
        ]);

        return redirect()
            ->route('instructor.messages', ['inquiry' => $inquiry->id])
            ->with('status', 'Reply sent successfully.');
    }

    public function settings(Request $request): View
    {
        $instructor = $request->user();

        return view('instructor.settings', [
            'instructor' => $instructor,
            'profileAvatar' => $instructor->avatarUrl(160),
        ]);
    }

    public function updateProfile(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email,'.$request->user()->id],
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
                $payload['avatar_path'] = $this->uploadAvatarToCloudinary(
                    $request->file('avatar'),
                    $request->user()->id,
                    $validated['name']
                );
            } catch (RuntimeException $exception) {
                return back()
                    ->withErrors(['avatar' => $exception->getMessage()])
                    ->withInput();
            }
        }

        $request->user()->update($payload);

        return redirect()
            ->route('instructor.settings')
            ->with('status', 'Profile and security preferences updated successfully.');
    }

    public function updatePassword(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'current_password' => ['required'],
            'password' => ['required', 'confirmed', 'min:8'],
        ]);

        if (! Hash::check($validated['current_password'], $request->user()->password)) {
            return back()->withErrors([
                'current_password' => 'The current password is incorrect.',
            ])->withInput();
        }

        $request->user()->update([
            'password' => $validated['password'],
        ]);

        return redirect()
            ->route('instructor.settings')
            ->with('status', 'Password updated successfully.');
    }

    private function uploadAvatarToCloudinary($file, int $userId, string $name): string
    {
        $cloudName = (string) config('services.cloudinary.cloud_name');
        $apiKey = (string) config('services.cloudinary.api_key');
        $apiSecret = (string) config('services.cloudinary.api_secret');
        $folder = (string) config('services.cloudinary.avatar_folder', 'lms/instructor-avatars');

        if ($cloudName === '' || $apiKey === '' || $apiSecret === '') {
            throw new RuntimeException('Cloudinary is not configured. Add Cloudinary credentials to continue.');
        }

        $timestamp = time();
        $publicId = 'instructor-'.Str::slug($name !== '' ? $name : 'user').'-'.$userId.'-avatar';
        $signature = sha1("folder={$folder}&public_id={$publicId}&timestamp={$timestamp}{$apiSecret}");

        $response = Http::timeout(60)
            ->attach(
                'file',
                file_get_contents($file->getRealPath()),
                $file->getClientOriginalName()
            )
            ->post("https://api.cloudinary.com/v1_1/{$cloudName}/image/upload", [
                'api_key' => $apiKey,
                'timestamp' => $timestamp,
                'folder' => $folder,
                'public_id' => $publicId,
                'signature' => $signature,
            ]);

        if (! $response->successful()) {
            throw new RuntimeException('Avatar upload failed. Please try again.');
        }

        $secureUrl = $response->json('secure_url');

        if (! is_string($secureUrl) || $secureUrl === '') {
            throw new RuntimeException('Cloudinary did not return a valid avatar URL.');
        }

        return $secureUrl;
    }
}

