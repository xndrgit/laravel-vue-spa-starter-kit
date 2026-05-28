<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Notifications\VerifyPendingEmail;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Notification;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class UserAccountController extends Controller
{
    public function updateProfile(Request $request): JsonResponse
    {
        $user = $request->user();

        $request->merge([
            'name' => trim((string) $request->input('name')),
        ]);

        $data = $request->validate([
            'name' => ['required', 'string', 'min:2', 'max:80', 'not_regex:/[<>]/', 'not_regex:/\p{C}/u'],
        ]);

        $user->update($data);

        return response()->json([
            'user' => UserResource::make($user->fresh()),
        ]);
    }

    public function updateEmail(Request $request): JsonResponse
    {
        $user = $request->user();

        $request->merge([
            'email' => str()->lower(trim((string) $request->input('email'))),
        ]);

        $data = $request->validate([
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore($user->id),
                Rule::unique('users', 'pending_email')->ignore($user->id),
            ],
            'current_password' => ['required', 'current_password:web'],
        ]);

        if ($user->email === $data['email']) {
            return response()->json([
                'user' => UserResource::make($user->fresh()),
                'message' => 'Email address unchanged.',
            ]);
        }

        $token = str()->random(64);

        $user->forceFill([
            'pending_email' => $data['email'],
            'pending_email_token' => Hash::make($token),
            'pending_email_requested_at' => now(),
            'remember_token' => str()->random(60),
        ])->save();

        Notification::route('mail', $data['email'])
            ->notify(new VerifyPendingEmail($user->fresh(), $token));

        $request->session()->regenerate();

        return response()->json([
            'user' => UserResource::make($user->fresh()),
            'message' => 'Verification link sent to the new email address.',
        ]);
    }

    public function updatePassword(Request $request): JsonResponse
    {
        $data = $request->validate([
            'current_password' => ['required', 'current_password:web'],
            'password' => ['required', 'confirmed', Password::defaults()],
        ]);

        $request->user()->forceFill([
            'password' => Hash::make($data['password']),
            'remember_token' => str()->random(60),
        ])->save();

        $request->session()->regenerate();

        return response()->json([
            'message' => 'Password updated.',
        ]);
    }
}
