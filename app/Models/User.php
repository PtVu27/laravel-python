<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    protected $fillable = ['name', 'email', 'password', 'role', 'gender', 'birth_date'];

    protected $hidden = ['password'];

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    protected function casts(): array
    {
        return [
            'password' => 'hashed',
        ];
    }
}
