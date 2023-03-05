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
        Schema::create('jobs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users');
            // $table->string('personal_id');
            $table->foreignId('personal_id')->constrained('personals')->nullable();
            $table->string('file_path')->nullable();
            $table->text('description')->nullable();
            $table->enum('status', ['passive', 'active', 'done'])->default('passive');
            $table->enum('type', ['text', 'photo']);

            $table->double('ball')->nullable();
            $table->date('ball_date')->nullable();

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
        Schema::dropIfExists('jobs');
    }
};
