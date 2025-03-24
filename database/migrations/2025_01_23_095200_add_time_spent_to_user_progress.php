<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('user_progress', function (Blueprint $table) {
            $table->integer('time_spent')->default(0)->after('attempts');
            $table->timestamp('first_viewed_at')->nullable()->after('time_spent');
        });
    }

    public function down()
    {
        Schema::table('user_progress', function (Blueprint $table) {
            $table->dropColumn(['time_spent', 'first_viewed_at']);
        });
    }
};
