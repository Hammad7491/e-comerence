<?php

namespace App\Http\Controllers;

use App\Models\User;
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
     * Handle registration (manual).
     */
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'     => 'required|string|max:255|unique:users,name',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|confirmed|min:6',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        // default role: user
        User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'role'     => 'user',
        ]);

        return redirect()->route('loginform')->with('success', 'Registration successful');
    }

    /**
     * Handle login and redirect based on roles.
     */
    public function login(Request $request)
    {
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

        // Admin -> admin dashboard
        if ($user->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }

        // Everyone else (user, etc.) -> home page
        return redirect()->route('home');
    }
}
