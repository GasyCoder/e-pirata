<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('enigmas', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description');
            $table->text('content');
            $table->string('answer');
            $table->string('hint1')->nullable();
            $table->string('hint2')->nullable();
            $table->string('hint3')->nullable();
            $table->string('fragment');
            $table->integer('points')->default(100);
            $table->integer('difficulty');
            $table->string('image_path')->nullable();
            $table->integer('order')->default(0);
            $table->foreignId('chapter_id')->nullable()->constrained()->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('enigmas');
    }
};
