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
        Schema::create('course_inquiries', function (Blueprint $table) {
            $table->id();

            //foriegn key
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('course_id')->constrained('courses')->cascadeOnDelete();

            //user info
            $table->string('name');
            $table->string('email');
            $table->string('phone')->nullable();

            //message
            $table->text('message')->nullable();

            //status
            $table->enum('status', ['pending', 'resolved'])->default('pending');

            //admin reply
            $table->text('admin_reply')->nullable();
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('course_inquiries');
    }
};
