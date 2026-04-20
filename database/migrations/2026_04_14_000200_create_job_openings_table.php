<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('job_openings', function (Blueprint $table) {
            $table->id();
            $table->string('badge')->nullable();
            $table->string('title');
            $table->string('employment_type')->nullable();
            $table->string('work_mode')->nullable();
            $table->string('location')->nullable();
            $table->string('experience')->nullable();
            $table->string('salary')->nullable();
            $table->text('summary')->nullable();
            $table->json('skills')->nullable();
            $table->string('color')->nullable();
            $table->boolean('is_active')->default(true);
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('job_openings');
    }
};
