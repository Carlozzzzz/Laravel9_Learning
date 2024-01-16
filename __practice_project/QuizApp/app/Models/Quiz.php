<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Quiz extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'quiz_img',
        'title',
        'instruction',
        'check_points_per_item',
        'points',
        'attempts',
        'time_limit_hr',
        'time_limit_mm',
        'time_limit_sec',
        'start_date',
        'end_date',
        'feedback_timing',
        'allow_answer_review',
        'allow_late',
        'show_result_after_submission',
        'randomize_choices',
        'randomize_question',
        'is_published',
        'is_completed', //validation if quiz creation is done
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    public function questions(): HasMany
    {
        return $this->hasMany(Question::class);
    }

    // FIX ME ****
    public function student_quiz_details(): HasMany
    {
        return $this->hasMany(StudentQuizDetails::class)->where('user_id' , auth()->user()->id);
    }

    // FIX ME ****
    public function latest_student_quiz_details() : hasOne
    {
        return $this->hasOne(StudentQuizDetails::class)->where('user_id' , auth()->user()->id)->latest()->take(1);
    }

}
