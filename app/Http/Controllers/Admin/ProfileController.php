<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Show admin profile edit form.
     */
    public function showProfile(Request $request): View
    {
        return view('admin.profile.index', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update admin profile details.
     */
    public function updateProfile(Request $request): RedirectResponse
    {
        $user = $request->user();

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore($user->id),
            ],
        ]);

        $user->update($validated);

        return redirect()
            ->route('admin.profile')
            ->with('success', 'Profile details updated successfully.');
    }

    /**
     * Show change password form.
     */
    public function showPassword(Request $request): View
    {
        return view('admin.profile.password', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update admin password.
     */
    public function updatePassword(Request $request): RedirectResponse
    {
        $user = $request->user();

        $validated = $request->validate([
            'current_password' => ['required', 'string', 'current_password'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $user->update([
            'password' => Hash::make($validated['password']),
        ]);

        return redirect()
            ->route('admin.password')
            ->with('success', 'Password updated successfully.');
    }
}
