<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FavoriteCharacter extends Model
{
    use HasFactory;

    protected $table = 'favorite_characters';

    protected $fillable = [
        'user_id',
        'character_id',
    ];

    protected $hidden = [
        'id',
        'user_id',
        'created_at',
        'updated_at',
    ];

    
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
