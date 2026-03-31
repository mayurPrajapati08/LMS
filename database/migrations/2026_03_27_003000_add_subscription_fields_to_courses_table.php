<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('courses', function (Blueprint $table) {
            $table->string('pricing_model')->default('one_time')->after('price');
            $table->string('subscription_cycle')->nullable()->after('pricing_model');
            $table->string('promotional_note')->nullable()->after('subscription_cycle');
        });
    }

    public function down(): void
    {
        Schema::table('courses', function (Blueprint $table) {
            $table->dropColumn([
                'pricing_model',
                'subscription_cycle',
                'promotional_note',
            ]);
        });
    }
};
