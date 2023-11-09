<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('quizzes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained();
            $table->string('quiz_img')->nullable();
            $table->string('title')->nullable();
            $table->string('instruction')->nullable();
            $table->integer('check_points_per_item')->nullable();
            $table->string('points')->nullable();
            $table->string('attempts')->nullable();
            $table->integer('time_limit_hr')->nullable();
            $table->integer('time_limit_mm')->nullable();
            $table->integer('time_limit_sec')->nullable();
            $table->dateTime('start_date')->nullable();
            $table->dateTime('end_date')->nullable();
            $table->string('feedback_timing')->nullable();
            $table->integer('allow_answer_review')->nullable();
            $table->integer('show_result_after_submission')->nullable();
            $table->integer('randomize_choices')->nullable();
            $table->integer('randomize_question')->nullable();
            $table->integer('is_published')->nullable();
            $table->integer('is_completed')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('quizzes');
    }
};
