<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('offline_courses', function (Blueprint $table) {
            $table->string('validity_label')->nullable()->after('duration_label');
            $table->string('delivery_mode')->nullable()->after('validity_label');
            $table->string('placement_label')->nullable()->after('delivery_mode');
            $table->string('audience')->nullable()->after('placement_label');
            $table->json('curriculum_modules')->nullable()->after('highlights');
            $table->json('additional_benefits')->nullable()->after('curriculum_modules');
            $table->text('learner_note')->nullable()->after('additional_benefits');
        });
    }

    public function down(): void
    {
        Schema::table('offline_courses', function (Blueprint $table) {
            $table->dropColumn([
                'validity_label',
                'delivery_mode',
                'placement_label',
                'audience',
                'curriculum_modules',
                'additional_benefits',
                'learner_note',
            ]);
        });
    }
};
