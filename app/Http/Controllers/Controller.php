<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

abstract class Controller
{
    protected function logoutWebSession(Request $request): void
    {
        Auth::guard('web')->logout();
        Auth::forgetGuards();

        $request->session()->invalidate();
        $request->session()->regenerateToken();
    }
}
