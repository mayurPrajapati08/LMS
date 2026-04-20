<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('home_stories', function (Blueprint $table) {
            if (! Schema::hasColumn('home_stories', 'show_in_placement_hero')) {
                $table->boolean('show_in_placement_hero')->default(false)->after('is_active');
            }
        });

        Schema::table('public_contacts', function (Blueprint $table) {
            if (! Schema::hasColumn('public_contacts', 'access_context')) {
                $table->string('access_context')->nullable()->after('source_page');
            }

            if (! Schema::hasColumn('public_contacts', 'access_granted_at')) {
                $table->timestamp('access_granted_at')->nullable()->after('access_context');
            }
        });
    }

    public function down(): void
    {
        Schema::table('public_contacts', function (Blueprint $table) {
            if (Schema::hasColumn('public_contacts', 'access_granted_at')) {
                $table->dropColumn('access_granted_at');
            }

            if (Schema::hasColumn('public_contacts', 'access_context')) {
                $table->dropColumn('access_context');
            }
        });

        Schema::table('home_stories', function (Blueprint $table) {
            if (Schema::hasColumn('home_stories', 'show_in_placement_hero')) {
                $table->dropColumn('show_in_placement_hero');
            }
        });
    }
};
