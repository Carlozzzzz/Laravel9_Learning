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
        Schema::create('student_quiz_answers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')
                ->constrained()
                ->onUpdate('cascade')
            ->onDelete('cascade');
            $table->foreignId('question_id')
                ->constrained('questions')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->foreignId('choice_id')
                ->nullable()
                ->constrained()
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->string('answer')->nullable(); // ** for input answers
            $table->integer('point')->nullable();
            $table->integer('is_correct')->nullable();
            $table->integer('is_answered')->nullable();
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
        Schema::dropIfExists('student_quiz_anwers');
    }
};
