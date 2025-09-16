<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    public function edit()
    {
        $user = Auth::user();
        return view('profile.edit', compact('user'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        // Validate – email unique except me; password optional but must be confirmed when provided.
        $data = $request->validate([
            'name'              => ['required','string','max:255'],
            'email'             => ['required','email', Rule::unique('users','email')->ignore($user->id)],
            'current_password'  => ['nullable','min:6'],
            'password'          => ['nullable','confirmed','min:6'],
        ]);

        // If user is trying to change password, verify current_password first (optional but safer)
        if ($data['password'] ?? false) {
            if (empty($data['current_password']) || ! Hash::check($data['current_password'], $user->password)) {
                return back()
                    ->withErrors(['current_password' => 'Current password is incorrect.'])
                    ->withInput();
            }
        }

        // Update name & email
        $user->name  = $data['name'];
        $user->email = $data['email'];

        // Update password if provided
        if (! empty($data['password'])) {
            $user->password = Hash::make($data['password']);
        }

        $user->save();

        return redirect()->route('profile.edit')->with('success','Profile updated successfully.');
    }
}
