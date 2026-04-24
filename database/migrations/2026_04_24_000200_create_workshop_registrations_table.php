<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('workshop_registrations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('workshop_id')->constrained('workshops')->cascadeOnDelete();
            $table->string('name');
            $table->string('email');
            $table->string('phone')->nullable();
            $table->string('city')->nullable();
            $table->string('organization')->nullable();
            $table->string('learner_type')->nullable();
            $table->string('experience_level')->nullable();
            $table->string('attendance_mode')->nullable();
            $table->text('goals')->nullable();
            $table->text('questions')->nullable();
            $table->decimal('payment_amount', 10, 2)->default(0);
            $table->string('currency', 10)->default('INR');
            $table->string('payment_reference')->nullable();
            $table->string('payment_screenshot_path')->nullable();
            $table->enum('payment_status', ['not_required', 'pending', 'verified', 'rejected'])->default('pending');
            $table->enum('registration_status', ['pending', 'confirmed', 'rejected'])->default('pending');
            $table->foreignId('reviewed_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('reviewed_at')->nullable();
            $table->text('hr_notes')->nullable();
            $table->string('source')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('workshop_registrations');
    }
};
