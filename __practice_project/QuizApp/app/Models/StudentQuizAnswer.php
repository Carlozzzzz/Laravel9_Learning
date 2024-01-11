<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class StudentQuizAnswer extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_quiz_details_id',
        'user_id',
        'question_id',
        'choice_id',
        'answer',
        'point',
        'points_per_question',
        'is_correct',
        'is_answered'
    ];

    public function student_quiz_details() : BelongsTo
    {
        return $this->belongsTo(StudentQuizDetails::class);
    }

    public function latest_student_quiz_details() : BelongsTo
    {
        return $this->belongsTo(StudentQuizDetails::class)
            ->where("user_id", auth()->user()->id)
            ->latest()->take(1);
    }
    
    public function question() : BelongsTo
    {
        return $this->belongsTo(Question::class);
    }

    
    public function choice() : BelongsTo
    {
        return $this->belongsTo(Choice::class);
    }

    // public function questions(): HasOne 
    // {
    //     return $this->hasOne(Question::class);
    // }
    // public function choices() : HasOne
    // {
    //     return $this->hasOne(Choice::class);
    // }
}
