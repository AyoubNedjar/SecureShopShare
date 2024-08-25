<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Boutique extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'user_id',
        'status',
        'share_type',
        'shared_with_user_id',
    ];

    public function getNameAttribute($value)
    {
        return decrypt($value);
    }

    public function setNameAttribute($value)
    {
        $this->attributes['name'] = encrypt($value);
    }

    public function getDescriptionAttribute($value)
    {
        return decrypt($value);
    }

    public function setDescriptionAttribute($value)
    {
        $this->attributes['description'] = encrypt($value);
    }

    public function articles()
    {
        return $this->hasMany(Article::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}

