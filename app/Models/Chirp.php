<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Chirp extends Model
{
    use HasFactory;

    protected $fillable = [
        'message'
    ];

    public function user(): BelongsTo {
        //cada chirp pertenece a un usuario
        return $this->belongsTo(User::class);
    }
}
