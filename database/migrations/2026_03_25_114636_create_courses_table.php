<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('courses', function (Blueprint $table) {
            $table->id();

            //foreign keys
            $table->foreignId('category_id')->constrained('categories')->cascadeOnDelete();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();

            //course details
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('details');

            //media
            $table->string('thumbnail')->nullable();

            //pricing
            $table->double('price',10,2);

            //status and level
            $table->enum('status', ['archived', 'published', 'draft'])->default('draft');
            $table->enum('level', ['beginner', 'intermediate', 'advanced'])->nullable();
            $table->string('language')->nullable();

            //duration and validity
            $table->integer('total_duration')->default(0); //durations in the seconds
            $table->integer('validity_in_days')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('courses');
    }
};
