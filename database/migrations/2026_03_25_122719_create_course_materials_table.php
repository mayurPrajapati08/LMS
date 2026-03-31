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
        Schema::create('course_materials', function (Blueprint $table) {
            $table->id();

            // Foreign key
            $table->foreignId('video_id')->constrained('videos')->cascadeOnDelete();

            //material details
            $table->string('title');
            $table->string('file_url')->nullable();

            $table->enum('type', ['pdf','zip','docx']);

            //control download
            $table->boolean('is_downloadable')->default(false);
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('course_materials');
    }
};
