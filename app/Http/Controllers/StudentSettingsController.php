<?php

namespace App\Http\Controllers;

use App\Support\CloudflareR2Storage;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
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
                $payload['avatar_path'] = $this->uploadAvatarToR2(
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

    private function uploadAvatarToR2($file, int $userId, string $name): string
    {
        $folder = trim((string) config('services.cloudflare_r2.avatar_folder', 'lms/avatars'), '/');
        $extension = strtolower((string) ($file->getClientOriginalExtension() ?: 'jpg'));
        $path = $folder.'/student-'.Str::slug($name !== '' ? $name : 'user').'-'.$userId.'-avatar.'.$extension;

        return CloudflareR2Storage::uploadPublicFile($file, $path);
    }
}
