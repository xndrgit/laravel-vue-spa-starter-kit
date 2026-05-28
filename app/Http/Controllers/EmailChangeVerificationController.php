<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class EmailChangeVerificationController extends Controller
{
    public function __invoke(Request $request, User $user, string $token): RedirectResponse
    {
        if (
            $user->pending_email === null ||
            $user->pending_email_token === null ||
            ! Hash::check($token, $user->pending_email_token)
        ) {
            abort(403);
        }

        $user->forceFill([
            'email' => $user->pending_email,
            'email_verified_at' => now(),
            'pending_email' => null,
            'pending_email_token' => null,
            'pending_email_requested_at' => null,
            'remember_token' => str()->random(60),
        ])->save();

        return redirect('/settings/security?email=verified');
    }
}
