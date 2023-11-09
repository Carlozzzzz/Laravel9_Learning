<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Quiz>
 */
class QuizFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $start_date = fake()->dateTimeThisMonth();
        $end_date = fake()->dateTimeBetween($start_date, '+30 days');
        $feedback_timing = fake()->randomElement(['immediately', 'afterCompletion']);

        return [
            'user_id' => fake()->randomElement(User::where('user_type', 'teacher')->pluck('id')),
            'title' => fake()->text(rand(15, 30)),
            'instruction' => fake()->text(rand(20, 50)),
            'check_points_per_item' => 0,
            'points' => "",
            'attempts' => rand(1, 3),
            'time_limit_hr' => rand(1, 24),
            'time_limit_mm' => rand(1, 60),
            'time_limit_sec' => rand(1, 60),
            'start_date' => $start_date,
            'end_date' => $end_date,
            'feedback_timing'=> $feedback_timing,
            'allow_answer_review' => 0,
            'show_result_after_submission' => 0,
            'randomize_choices' => 1,
            'randomize_question' => 1,
            'is_published' => 0,
            'is_completed' => 0,
        ];
    }
}
