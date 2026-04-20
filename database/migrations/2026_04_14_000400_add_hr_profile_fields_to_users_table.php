<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->boolean('show_on_homepage')->default(false)->after('two_factor_enabled');
            $table->unsignedInteger('faculty_sort_order')->default(0)->after('show_on_homepage');
            $table->string('faculty_headline')->nullable()->after('faculty_sort_order');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['show_on_homepage', 'faculty_sort_order', 'faculty_headline']);
        });
    }
};
