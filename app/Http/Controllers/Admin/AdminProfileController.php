<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class AdminProfileController extends Controller
{
    /**
     * Tampilkan halaman edit profil admin.
     */
    public function edit(): View
    {
        return view('admin.profile.edit');
    }

    /**
     * Update profil admin.
     */
    public function update(): RedirectResponse
    {
        return redirect()->route('dashboard');
    }
}
