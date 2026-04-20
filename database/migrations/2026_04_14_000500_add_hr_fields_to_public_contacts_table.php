<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('public_contacts', function (Blueprint $table) {
            $table->string('topic')->default('general')->after('message');
            $table->string('subject')->nullable()->after('topic');
            $table->string('status')->default('new')->after('subject');
            $table->string('source_page')->nullable()->after('status');
            $table->json('details')->nullable()->after('source_page');
            $table->foreignId('assigned_to')->nullable()->after('details')->constrained('users')->nullOnDelete();
            $table->timestamp('contacted_at')->nullable()->after('assigned_to');
            $table->timestamp('follow_up_at')->nullable()->after('contacted_at');
            $table->text('internal_notes')->nullable()->after('follow_up_at');
        });
    }

    public function down(): void
    {
        Schema::table('public_contacts', function (Blueprint $table) {
            $table->dropConstrainedForeignId('assigned_to');
            $table->dropColumn([
                'topic',
                'subject',
                'status',
                'source_page',
                'details',
                'contacted_at',
                'follow_up_at',
                'internal_notes',
            ]);
        });
    }
};
