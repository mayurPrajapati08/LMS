<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('home_founder_media', function (Blueprint $table) {
            $table->string('video_provider', 20)->default('url')->after('badge');
            $table->string('poster_provider', 20)->default('url')->after('video_url');
        });
    }

    public function down(): void
    {
        Schema::table('home_founder_media', function (Blueprint $table) {
            $table->dropColumn(['video_provider', 'poster_provider']);
        });
    }
};
