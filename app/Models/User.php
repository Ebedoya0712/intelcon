<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable;

    protected $fillable = [
        'name',
        'surname',
        'email',
        'password',
        'cedula',
        'address',
        'photo',
        'service',
        'state_id',
        'role_id',
        'remember_token',
    ];

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function state()
    {
        return $this->belongsTo(State::class);
    }
}

