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
        Schema::create('user_fragments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('enigma_id')->constrained()->onDelete('cascade');
            $table->string('fragment', 10);
            $table->integer('fragment_order');
            $table->timestamps();

            // Unicité: un utilisateur ne peut avoir qu'un fragment par énigme
            $table->unique(['user_id', 'enigma_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_fragments');
    }
};
