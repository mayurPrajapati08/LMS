<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('course_progress', function (Blueprint $table) {
            $table->unsignedInteger('last_watched_seconds')->default(0)->after('watched_durations');
        });
    }

    public function down(): void
    {
        Schema::table('course_progress', function (Blueprint $table) {
            $table->dropColumn('last_watched_seconds');
        });
    }
};
