<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('home_achievements', function (Blueprint $table) {
            $table->unsignedInteger('gallery_category_order')->default(0)->after('gallery_category');
            $table->index(['kind', 'gallery_category_order'], 'home_achievements_kind_category_order_idx');
        });
    }

    public function down(): void
    {
        Schema::table('home_achievements', function (Blueprint $table) {
            $table->dropIndex('home_achievements_kind_category_order_idx');
            $table->dropColumn('gallery_category_order');
        });
    }
};
