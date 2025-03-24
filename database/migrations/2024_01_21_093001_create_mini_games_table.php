<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('mini_games', function (Blueprint $table) {
            $table->id();
            $table->foreignId('chapter_id')->constrained()->onDelete('cascade');
            $table->string('type'); // 'memory', 'puzzle', 'decode', 'navigation'
            $table->string('title');
            $table->text('description');
            $table->json('game_data');
            $table->integer('points_reward');
            $table->json('unlock_condition')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('mini_games');
    }
};
