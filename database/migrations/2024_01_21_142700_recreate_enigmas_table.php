<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::dropIfExists('user_progress');
        Schema::dropIfExists('enigmas');

        Schema::create('enigmas', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description');
            $table->text('content');
            $table->string('answer');
            $table->text('hint1')->nullable();
            $table->text('hint2')->nullable();
            $table->text('hint3')->nullable();
            $table->string('fragment')->nullable();
            $table->integer('points')->default(100);
            $table->integer('difficulty')->default(1);
            $table->string('image_path')->nullable();
            $table->integer('order')->default(0);
            $table->foreignId('chapter_id')->nullable()->constrained()->onDelete('cascade');
            $table->timestamps();
        });

        Schema::create('user_progress', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('enigma_id')->constrained()->onDelete('cascade');
            $table->boolean('completed')->default(false);
            $table->integer('hints_used')->default(0);
            $table->timestamp('completed_at')->nullable();
            $table->timestamps();
            
            $table->unique(['user_id', 'enigma_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('user_progress');
        Schema::dropIfExists('enigmas');
    }
};
