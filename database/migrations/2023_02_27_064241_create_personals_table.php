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
        Schema::create('personals', function (Blueprint $table) {
            $table->id();
            $table->string('chat_id');
            $table->string('fullname')->nullable();
            // +99899 123 45 67
            $table->string('phone', 13)->nullable();
            $table->date('birthday')->nullable();
            $table->string('rayon')->nullable();
            $table->string('school')->nullable();
            $table->string('class')->nullable();
            $table->string('map')->default('0');
            $table->string('is_active')->default('0');
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
        Schema::dropIfExists('personals');
    }
};
