<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('pages', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique();
            $table->string('title');
            $table->longText('content')->nullable();
            $table->boolean('is_published')->default(true);
            $table->timestamps();
        });

        // Insérer les pages CGU et CGV par défaut
        DB::table('pages')->insert([
            [
                'slug' => 'cgu',
                'title' => 'Conditions Générales d\'Utilisation',
                'content' => '<h1>Conditions Générales d\'Utilisation</h1><p>Contenu par défaut des CGU. À modifier dans l\'administration.</p>',
                'is_published' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'slug' => 'cgv',
                'title' => 'Conditions Générales de Vente',
                'content' => '<h1>Conditions Générales de Vente</h1><p>Contenu par défaut des CGV. À modifier dans l\'administration.</p>',
                'is_published' => true,
                'created_at' => now(),
                'updated_at' => now()
            ]
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pages');
    }
};
