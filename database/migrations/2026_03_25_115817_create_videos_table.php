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
        Schema::create('videos', function (Blueprint $table) {
            $table->id();

            //foreign keys
            $table->foreignId('section_id')->constrained('sections')->cascadeOnDelete();
            $table->foreignId('upload_by')->constrained('users')->cascadeOnDelete();

            //video info
            $table->string('title');
            $table->string('thumbnail_url')->nullable();
            $table->string('video_url');

            //order & durations
            $table->integer('order_number');
            $table->integer('duration')->nullable(); //duration in seconds

            //demo video flag
            $table->boolean('is_preview')->default(false); 
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('videos');
    }
};
