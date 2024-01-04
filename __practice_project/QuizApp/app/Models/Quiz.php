<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

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

}
