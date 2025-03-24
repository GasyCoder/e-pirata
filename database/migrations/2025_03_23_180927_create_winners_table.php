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
        Schema::create('winners', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->unsignedBigInteger('treasure_hunt_id'); // ID de la chasse au trésor
            $table->timestamp('completed_at');
            $table->integer('rank')->default(1); // Position du joueur (1er, 2ème, etc.)
            $table->timestamps();

            // Un seul gagnant par rang par chasse au trésor
            $table->unique(['treasure_hunt_id', 'rank']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('winners');
    }
};
