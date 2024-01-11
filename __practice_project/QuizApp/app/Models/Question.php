<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Question extends Model
{
    use HasFactory;

    protected $fillable = [
        "quiz_id",
        "question",
        "category"
    ];

    public function quiz(): BelongsTo
    {
        return $this->belongsTo(Quiz::class);
    }

    public function choices(): HasMany
    {
        return $this->hasMany(Choice::class);
    }

    public function answers(): HasMany
    {
        return $this->hasMany(Answer::class);
    }

    public function student_question_sort_order() : HasOne
    {
        return $this->HasOne(StudentQuestionSortOrder::class);
    }

    public function student_quiz_answers() : HasOne
    {
        return $this->HasOne(StudentQuizAnswer::class)
            ->where("user_id", auth()->user()->id);
    }
   

}
