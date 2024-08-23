<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Boutique extends Model
{
    use HasFactory;
    protected $table = 'boutiques';

    // Définition des champs qui peuvent être massivement assignés
    protected $fillable = [
        'name',
        'description',
        'user_id',
        'status', // Ajout d'un champ de statut pour la modération (e.g., 'pending', 'approved', 'rejected')
    ];

    // Relation entre une boutique et ses articles (une boutique a plusieurs articles)
    public function articles()
    {
        return $this->hasMany(Article::class);
    }
}
