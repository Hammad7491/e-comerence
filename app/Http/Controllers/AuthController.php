<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function logout()
    {
        Auth::logout();
        return redirect()->route('loginform');
    }

    public function loginform()
    {
        return view('auth.login');
    }

    public function registerform()
    {
        return view('auth.register');
    }

    public function error403()
    {
        return view('auth.errors.error403');
    }

    /**
     * Handle registration (manual or social data).
     */
    public function register(Request $request)
    {
        // Manual registration only (simplified, no Spatie)
        $validator = Validator::make($request->all(), [
            'name'     => 'required|string|max:255|unique:users,name',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|confirmed|min:6',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        // create & assign default role = user
        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'role'     => 'user', // default role
        ]);

        return redirect()->route('loginform')->with('success', 'Registration successful');
    }

    /**
     * Handle login and redirect based on roles (using `role` column).
     */
    public function login(Request $request)
    {
        // validate credentials
        $credentials = $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        if (! Auth::attempt($credentials, $request->filled('remember'))) {
            return back()
                ->withErrors(['email' => 'Invalid credentials.'])
                ->withInput();
        }

        $user = Auth::user();

        // redirection based on role
        if ($user->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }

        // you can add more granular redirects here:
        // if ($user->role === 'manager') { ... }

        // default logged-in landing
        return redirect()->route('user.dashboard');
    }
}
