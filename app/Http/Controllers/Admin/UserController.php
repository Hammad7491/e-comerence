<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();
        return view('admin.users.index', compact('users'));
    }

    public function create()
    {
        return view('admin.users.create', [
            'userRoles' => [],
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'     => 'required|string|max:255|unique:users,name',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|confirmed|min:6',
            'role'     => 'required|in:admin,manager,user',
        ]);

        User::create([
            'name'     => $data['name'],
            'email'    => $data['email'],
            'password' => Hash::make($data['password']),
            'role'     => $data['role'],
        ]);

        return redirect()->route('admin.users.index')
                         ->with('success','User created.');
    }

    public function edit(User $user)
    {
        return view('admin.users.create', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $data = $request->validate([
            'name'     => 'required|string|max:255|unique:users,name,'.$user->id,
            'email'    => 'required|email|unique:users,email,'.$user->id,
            'password' => 'nullable|confirmed|min:6',
            'role'     => 'required|in:admin,manager,user',
        ]);

        $user->name  = $data['name'];
        $user->email = $data['email'];
        $user->role  = $data['role'];

        if (! empty($data['password'])) {
            $user->password = Hash::make($data['password']);
        }

        $user->save();

        return redirect()->route('admin.users.index')
                         ->with('success','User updated.');
    }

    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('admin.users.index')
                         ->with('success','User deleted.');
    }
}
