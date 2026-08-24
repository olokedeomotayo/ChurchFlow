<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->foreignId('church_id')
                ->nullable()
                ->after('id')
                ->constrained('churches')
                ->nullOnDelete();

            $table->index('church_id');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['church_id']);
            $table->dropIndex(['church_id']);
            $table->dropColumn('church_id');
        });
    }
};