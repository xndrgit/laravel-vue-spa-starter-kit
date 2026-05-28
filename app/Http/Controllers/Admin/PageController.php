<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\View\View;

class PageController extends Controller
{
    public function users(): View
    {
        return view('admin.pages.users');
    }

    public function settings(): View
    {
        return view('admin.pages.settings');
    }

    public function system(): View
    {
        return view('admin.pages.system');
    }
}
