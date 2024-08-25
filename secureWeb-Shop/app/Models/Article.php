<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    // Ajoutez les nouvelles colonnes au tableau $fillable
    protected $fillable = [
        'title',
        'description',
        'price',
        'boutique_id',
        'share_type',
        'shared_with_user_id',
    ];

    // Relations
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function boutique()
    {
        return $this->belongsTo(Boutique::class);
    }

    // Relation pour l'utilisateur avec lequel l'article est partagé
    public function sharedWithUser()
    {
        return $this->belongsTo(User::class, 'shared_with_user_id');
    }

    // Accessor pour obtenir le type de partage
    public function getShareTypeAttribute($value)
    {
        return ucfirst($value);
    }
}
