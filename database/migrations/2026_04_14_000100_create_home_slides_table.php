<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('home_slides', function (Blueprint $table) {
            $table->id();
            $table->string('eyebrow')->nullable();
            $table->string('title');
            $table->string('highlight')->nullable();
            $table->text('description')->nullable();
            $table->string('badge')->nullable();
            $table->string('accent')->nullable();
            $table->string('stat_label')->nullable();
            $table->string('stat_value')->nullable();
            $table->string('image')->nullable();
            $table->string('primary_url')->nullable();
            $table->string('primary_label')->nullable();
            $table->string('secondary_url')->nullable();
            $table->string('secondary_label')->nullable();
            $table->boolean('is_active')->default(true);
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('home_slides');
    }
};
