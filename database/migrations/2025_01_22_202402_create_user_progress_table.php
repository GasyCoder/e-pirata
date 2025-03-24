<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::dropIfExists('user_progress');
        
        Schema::create('user_progress', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('enigma_id')->constrained()->onDelete('cascade');
            $table->boolean('completed')->default(false);
            $table->boolean('is_winner')->default(false);
            $table->string('user_answer')->nullable();
            $table->integer('attempts')->default(0);
            $table->integer('hints_used')->default(0);
            $table->timestamp('completed_at')->nullable();
            $table->timestamp('winner_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_progress');
    }
};
