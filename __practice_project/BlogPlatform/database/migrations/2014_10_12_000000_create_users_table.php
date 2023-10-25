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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('user_image')->nullable();
            $table->string('user_cover_image')->nullable();
            $table->string('name');
            $table->string('gender')->nullable();
            $table->string('email')->unique();
            $table->bigInteger('contact_number')->nullable();
            $table->integer('age')->nullable();
            $table->string('industry')->nullable();
            $table->string('occupation')->nullable();
            $table->string('country')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
};
