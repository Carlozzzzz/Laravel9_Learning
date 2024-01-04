<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StudentQuestionSortOrder extends Model
{
    use HasFactory;

    protected $fillable = [
        'question_id',
        'quiz_id',
        'user_id',
        'question_order'
    ];

    public function question() : BelongsTo
    {
        return $this->belongsTo(Question::class);
    }
}
