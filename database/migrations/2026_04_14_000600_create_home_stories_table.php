<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('home_stories', function (Blueprint $table) {
            $table->id();
            $table->string('type', 40);
            $table->string('name');
            $table->string('course')->nullable();
            $table->text('comment');
            $table->string('avatar', 2000)->nullable();
            $table->unsignedTinyInteger('rating')->default(5);
            $table->string('company')->nullable();
            $table->string('role')->nullable();
            $table->string('package')->nullable();
            $table->date('shared_at')->nullable();
            $table->boolean('is_active')->default(true);
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();

            $table->index(['type', 'is_active', 'sort_order'], 'home_stories_type_active_sort_idx');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('home_stories');
    }
};
