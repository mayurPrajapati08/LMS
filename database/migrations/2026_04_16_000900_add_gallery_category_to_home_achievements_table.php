<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('home_achievements', function (Blueprint $table) {
            $table->string('gallery_category')->nullable()->after('kind');
            $table->index(['kind', 'gallery_category'], 'home_achievements_kind_category_idx');
        });
    }

    public function down(): void
    {
        Schema::table('home_achievements', function (Blueprint $table) {
            $table->dropIndex('home_achievements_kind_category_idx');
            $table->dropColumn('gallery_category');
        });
    }
};
