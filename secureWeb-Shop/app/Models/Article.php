<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    use HasFactory;
    protected $table = 'articles';

    // Définition des champs qui peuvent être massivement assignés
    protected $fillable = [
        'title',
        'description',
        'price',
        'boutique_id',
        'status', // Ajout d'un champ de statut pour la modération (e.g., 'pending', 'approved', 'rejected')
    ];

    // Relation entre un article et sa boutique (un article appartient à une boutique)
    public function boutique()
    {
        return $this->belongsTo(Boutique::class);
    }
}
