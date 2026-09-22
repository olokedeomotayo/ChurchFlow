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
        Schema::table('roles', function (Blueprint $table) {
            $table->foreignId('church_id')
                ->nullable()
                ->after('guard_name')
                ->constrained('churches')
                ->nullOnDelete();

            $table->index(['church_id', 'name']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('roles', function (Blueprint $table) {
            $table->dropForeign(['church_id']);
            $table->dropIndex(['church_id', 'name']);
            $table->dropColumn('church_id');
        });
    }
};