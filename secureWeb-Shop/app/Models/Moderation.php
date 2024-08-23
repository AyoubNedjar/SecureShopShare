<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Moderation extends Model
{
    use HasFactory;

    /**
     * Les attributs qui peuvent être assignés en masse.
     *
     * @var array
     */
    protected $fillable = [
        'item_type',  // Le type d'élément (e.g., 'article', 'boutique')
        'item_id',    // L'ID de l'élément associé
        'status',     // Le statut de la modération (e.g., 'pending', 'approved', 'rejected')
        'moderator_id', // ID de l'utilisateur qui modère l'élément
    ];

    /**
     * Relation polymorphe vers les différents éléments pouvant être modérés.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function item()
    {
        return $this->morphTo();
    }

    /**
     * L'utilisateur qui est le modérateur de cet élément.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function moderator()
    {
        return $this->belongsTo(User::class, 'moderator_id');
    }
}
