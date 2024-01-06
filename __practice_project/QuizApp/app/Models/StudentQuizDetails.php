<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StudentQuizDetails extends Model
{
    use HasFactory;

    protected $fillable = [
        'quiz_id',
        'user_id',
        'score',
        'started_at',
        'completed_at',
        'hours',
        'minutes',
        'seconds',
        'attempts',
        'is_passed',
        'review_status',
        'last_question_id',
        'duration',
    ];

    public function quiz() : BelongsTo
    {
        return $this->belongsTo(Quiz::class);
    }
}
