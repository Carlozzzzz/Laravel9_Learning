<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class StudentQuizDetails extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'quiz_id',
        'score',
        'started_at',
        'completed_at',
        'hours',
        'minutes',
        'seconds',
        'attempts',
        'score',
        'total_points',
        'is_passed',
        'review_status',
        'last_question_id',
    ];

    public function quiz() : BelongsTo
    {
        return $this->belongsTo(Quiz::class);
    }

    public function student_quiz_answer() : HasMany
    {
        return $this->hasMany(StudentQuizAnswer::class)->where("user_id", auth()->user()->id);
    }

   
}
