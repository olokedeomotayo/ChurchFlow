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
        Schema::table('incomes', function (Blueprint $table) {
            $table->foreignId('financial_account_id')
                ->nullable()
                ->after('church_id')
                ->constrained('financial_accounts')
                ->nullOnDelete();

            $table->index(
                ['church_id', 'financial_account_id'],
                'incomes_church_financial_account_index'
            );
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('incomes', function (Blueprint $table) {
            $table->dropForeign(['financial_account_id']);

            $table->dropIndex(
                'incomes_church_financial_account_index'
            );

            $table->dropColumn('financial_account_id');
        });
    }
};