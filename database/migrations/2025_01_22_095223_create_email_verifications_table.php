<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // Créer la table pour les codes de vérification
        Schema::create('email_verifications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('code', 6); // Code à 6 chiffres
            $table->timestamp('expires_at'); // Date d'expiration du code
            $table->timestamps();
        });

        // Ajouter email_verified_at à la table users si pas déjà présent
        if (!Schema::hasColumn('users', 'email_verified_at')) {
            Schema::table('users', function (Blueprint $table) {
                $table->timestamp('email_verified_at')->nullable();
            });
        }
    }

    public function down()
    {
        // Supprimer la table en cas de rollback
        Schema::dropIfExists('email_verifications');

        // Supprimer la colonne email_verified_at si elle existe
        if (Schema::hasColumn('users', 'email_verified_at')) {
            Schema::table('users', function (Blueprint $table) {
                $table->dropColumn('email_verified_at');
            });
        }
    }
};
