<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'totp_secret', // Ajout du champ pour le secret TOTP
    ];

    protected $hidden = [
        'password',
        'remember_token',
        'totp_secret', // Cache le secret TOTP
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    /**
     * Vérifie si l'utilisateur est un modérateur.
     *
     * @return bool
     */
    public function isModerator()
    {
        return $this->role === 'moderator'; // Assurez-vous que le rôle 'moderator' est correct
    }
}
