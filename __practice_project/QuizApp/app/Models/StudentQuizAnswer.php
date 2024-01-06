<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StudentQuizAnswer extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'question_id',
        'choice_id',
        'answer',
        'point',
        'is_correct',
        'is_answered'
    ];

    public function question() : BelongsTo
    {
        return $this->belongsTo(Question::class);
    }

    
    public function choice() : BelongsTo
    {
        return $this->belongsTo(Choice::class);
    }
}
