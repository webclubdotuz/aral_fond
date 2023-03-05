<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
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
        Schema::create('roles', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('slug')->unique();
            $table->string('description')->nullable();
        });

        Schema::create('role_user', function (Blueprint $table) {
            $table->id();
            $table->foreignId('role_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
        });

        $roles = [
            [
                'name' => 'Admin',
                'slug' => 'admin',
                'description' => 'Admin',
            ],
            [
                'name' => 'Эксперт фото',
                'slug' => 'expert-photo',
                'description' => 'Эксперт фото',
            ],
            [
                'name' => 'Эксперт текст',
                'slug' => 'expert-text',
                'description' => 'Эксперт текст',
            ],
        ];

        foreach ($roles as $role) {
            DB::table('roles')->insert([
                'name' => $role['name'],
                'slug' => $role['slug'],
                'description' => $role['description'],
            ]);
        }

        DB::table('role_user')->insert([
            'role_id' => 1,
            'user_id' => 1,
        ]);

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('roles');
    }
};
