<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('home_achievements', function (Blueprint $table) {
            $table->id();
            $table->string('kind', 40);
            $table->string('eyebrow')->nullable();
            $table->string('title')->nullable();
            $table->text('copy')->nullable();
            $table->string('stat')->nullable();
            $table->string('icon', 100)->nullable();
            $table->json('points')->nullable();
            $table->string('media_url', 2000)->nullable();
            $table->string('media_type', 20)->default('image');
            $table->string('media_provider', 20)->default('url');
            $table->boolean('is_active')->default(true);
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();

            $table->index(['kind', 'is_active', 'sort_order'], 'home_achievements_kind_active_sort_idx');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('home_achievements');
    }
};
