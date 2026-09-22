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
        Schema::table('expenses', function (Blueprint $table) {
            $table->foreignId('financial_account_id')
                ->nullable()
                ->after('church_id')
                ->constrained('financial_accounts')
                ->nullOnDelete();

            $table->index(
                ['church_id', 'financial_account_id'],
                'expenses_church_financial_account_index'
            );
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('expenses', function (Blueprint $table) {
            $table->dropForeign(['financial_account_id']);

            $table->dropIndex(
                'expenses_church_financial_account_index'
            );

            $table->dropColumn('financial_account_id');
        });
    }
};