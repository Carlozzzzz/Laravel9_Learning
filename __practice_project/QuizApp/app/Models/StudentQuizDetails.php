<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
}
