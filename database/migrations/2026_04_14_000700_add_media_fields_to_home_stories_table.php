<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('home_stories', function (Blueprint $table) {
            $table->string('media_type', 20)->default('image')->after('avatar');
            $table->string('media_provider', 20)->default('url')->after('media_type');
        });
    }

    public function down(): void
    {
        Schema::table('home_stories', function (Blueprint $table) {
            $table->dropColumn(['media_type', 'media_provider']);
        });
    }
};
