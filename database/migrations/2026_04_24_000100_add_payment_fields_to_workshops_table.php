<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('workshops', function (Blueprint $table) {
            $table->decimal('price', 10, 2)->default(0)->after('seats');
            $table->string('currency', 10)->default('INR')->after('price');
            $table->boolean('payment_enabled')->default(false)->after('currency');
            $table->string('payment_qr_code')->nullable()->after('payment_enabled');
            $table->text('payment_instructions')->nullable()->after('payment_qr_code');
        });
    }

    public function down(): void
    {
        Schema::table('workshops', function (Blueprint $table) {
            $table->dropColumn([
                'price',
                'currency',
                'payment_enabled',
                'payment_qr_code',
                'payment_instructions',
            ]);
        });
    }
};
