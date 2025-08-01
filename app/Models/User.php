<?php

namespace App\Models;

// Añade la importación del contrato

use App\Notifications\VerifyEmailNotification;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

// Implementa el contrato en la declaración de la clase
class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'identification',
        'email',
        'password',
        'address',
        'profile_photo',
        'service',
        'state_id',
        'role_id',
        'remember_token',
        'city_id',
        'municipality_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function sendEmailVerificationNotification()
    {
        $this->notify(new VerifyEmailNotification);
    }

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function documents()
    {
        return $this->hasMany(Document::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function state()
    {
        return $this->belongsTo(State::class);
    }

    public function services()
    {
        return $this->belongsToMany(Service::class, 'service_user')
                    ->withPivot('start_date', 'end_date', 'status')
                    ->withTimestamps();
    }
}