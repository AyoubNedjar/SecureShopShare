<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Crypt;

class Article extends Model
{
    // Déclaration des attributs remplissables
    protected $fillable = [
        'title', 
        'description', 
        'price', 
        'user_id', 
        'image_path', 
        'encrypted_image', 
        'boutique_id'
    ];

    // Accesseur pour le titre
    public function getTitleAttribute($value)
    {
        return Crypt::decryptString($value);
    }

    // Mutateur pour le titre
    public function setTitleAttribute($value)
    {
        $this->attributes['title'] = Crypt::encryptString($value);
    }

    // Accesseur pour la description
    public function getDescriptionAttribute($value)
    {
        return Crypt::decryptString($value);
    }

    // Mutateur pour la description
    public function setDescriptionAttribute($value)
    {
        $this->attributes['description'] = Crypt::encryptString($value);
    }

    // Accesseur pour le prix
    public function getPriceAttribute($value)
    {
        return Crypt::decryptString($value);
    }

    // Mutateur pour le prix
    public function setPriceAttribute($value)
    {
        $this->attributes['price'] = Crypt::encryptString($value);
    }

    // Accesseur pour l'image cryptée
    public function getEncryptedImageAttribute($value)
    {
        return Crypt::decryptString($value);
    }

    // Mutateur pour l'image cryptée
    public function setEncryptedImageAttribute($value)
    {
        $this->attributes['encrypted_image'] = Crypt::encryptString($value);
    }

    // Déclaration de la relation avec Boutique
    public function boutique(): BelongsTo
    {
        return $this->belongsTo(Boutique::class);
    }

    // Déclaration de la relation avec User
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
