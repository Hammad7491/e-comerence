<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    protected $fillable = ['name','email','password','role'];
    protected $hidden   = ['password','remember_token'];

    // optional helper
    public function isRole(string $role): bool
    {
        return strtolower((string) $this->role) === strtolower($role);
    }
}
