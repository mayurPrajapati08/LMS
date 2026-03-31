<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('email_verification_otps', function (Blueprint $table) {
            $table->string('purpose')->default('email_verification')->after('user_id');
        });
    }

    public function down(): void
    {
        Schema::table('email_verification_otps', function (Blueprint $table) {
            $table->dropColumn('purpose');
        });
    }
};
