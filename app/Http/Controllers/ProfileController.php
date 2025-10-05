<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    /** Show the profile edit form */
    public function edit(Request $request)
    {
        $user = $request->user();
        return view('profile.edit', compact('user'));   // <-- matches resources/views/profile/edit.blade.php
    }

    /** Update name/email and optionally password */
    public function update(Request $request)
    {
        $user = $request->user();

        $rules = [
            'name'  => ['required', 'string', 'max:255'],
            'email' => ['required', 'email:rfc,dns', Rule::unique('users', 'email')->ignore($user->id)],
        ];

        // Only validate password fields if user is changing password
        if ($request->filled('password') || $request->filled('current_password')) {
            $rules += [
                'current_password'      => ['required', 'string', 'min:6'],
                'password'              => ['required', 'string', 'min:6', 'confirmed'],
                'password_confirmation' => ['required', 'string', 'min:6'],
            ];
        }

        $validated = $request->validate($rules);

        // Update base fields
        $user->name  = $validated['name'];
        $user->email = $validated['email'];

        // Update password if provided
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
}
