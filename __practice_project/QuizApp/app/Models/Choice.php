<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Choice extends Model
{
    use HasFactory;

    protected $fillable = [
        "question_id",
        "choice",
    ];

    public function answers(): HasMany
    {
        return $this->hasMany(Answer::class);
    }
}
