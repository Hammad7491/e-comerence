<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    /** Show the profile edit form (name/email, etc.) */
    public function edit(Request $request)
    {
        $user = $request->user();
        return view('profile.edit', compact('user')); // resources/views/profile/edit.blade.php
    }

    /** Update profile (name/email); password is NOT handled here */
    public function update(Request $request)
    {
        $user = $request->user();

        $validated = $request->validate([
            'name'  => ['required', 'string', 'max:255'],
            'email' => ['required', 'email:rfc,dns', Rule::unique('users', 'email')->ignore($user->id)],
        ]);

        $user->name  = $validated['name'];
        $user->email = $validated['email'];
        $user->save();

        return back()->with('success', 'Profile updated successfully.');
    }

    /** Show only the change-password form */
    public function showChangePasswordForm()
    {
        // Make sure the blade file below exists
        return view('frontend.changepsd'); // resources/views/profile/change-password.blade.php
    }

    /** Update password ONLY (current + new) */
    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password'      => ['required', 'string', 'min:6'],
            'password'              => ['required', 'string', 'min:6', 'confirmed'],
            'password_confirmation' => ['required', 'string', 'min:6'],
        ]);

        $user = $request->user();

        if (! Hash::check($request->current_password, $user->password)) {
            return back()
                ->withErrors(['current_password' => 'Current password is incorrect.'])
                ->withInput();
        }

        $user->password = Hash::make($request->password);
        $user->save();

        return back()->with('success', 'Password updated successfully.');
    }
}
