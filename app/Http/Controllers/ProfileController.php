<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    /** Show the profile edit form (for admin or user) */
    public function edit(Request $request)
    {
        $user = $request->user();
        return view('profile.edit', compact('user')); // adjust if your blade lives elsewhere
    }

    /** Update profile (name/email) and optionally password */
    public function update(Request $request)
    {
        $user = $request->user();

        // Base validation
        $rules = [
            'name'  => ['required', 'string', 'max:255'],
            'email' => ['required', 'email:rfc,dns', Rule::unique('users', 'email')->ignore($user->id)],
        ];

        // Add password rules only if user tries to change it
        if ($request->filled('password') || $request->filled('current_password') || $request->filled('password_confirmation')) {
            $rules += [
                'current_password'      => ['required'], // no min rule here
                'password'              => ['required', 'string', 'min:6', 'confirmed'],
                'password_confirmation' => ['required', 'string', 'min:6'],
            ];
        }

        $validated = $request->validate($rules);

        // Update name/email
        $user->name  = $validated['name'];
        $user->email = $validated['email'];

        // Handle password update (only if provided)
        if ($request->filled('password')) {
            if (! Hash::check($request->current_password, $user->password)) {
                return back()
                    ->withErrors(['current_password' => 'Current password is incorrect.'])
                    ->withInput();
            }
            $user->password = Hash::make($validated['password']);
        }

        $user->save();

        return back()->with('success', 'Profile updated successfully.');
    }

    /** Show change password page (frontend user) */
    public function showChangePasswordForm()
    {
        return view('frontend.changepsd'); // resources/views/frontend/changepsd.blade.php
    }

    /** Update password from frontend change-password page */
    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password'      => ['required'], // no min rule here either
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
