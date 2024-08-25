<?php
namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;
use phpseclib3\Crypt\RSA;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'totp_secret',
        'public_key',  // Ajout du champ public_key
        'private_key', // Ajout du champ private_key
    ];

    protected $hidden = [
        'password',
        'remember_token',
        'totp_secret',
        'private_key',  // Cache le private_key pour plus de sécurité
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function isModerator()
    {
        return $this->role === 'moderator';
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($user) {
            $user->uid = Str::uuid()->toString();

            // Génération des clés RSA lors de la création de l'utilisateur
            $rsa = RSA::createKey(2048);
            $user->public_key = $rsa->getPublicKey()->toString('PKCS8');
            $user->private_key = encrypt($rsa->toString('PKCS8'));
        });
    }
}

