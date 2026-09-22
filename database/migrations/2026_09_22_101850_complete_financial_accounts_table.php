<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Complete the financial_accounts table structure.
     */
    public function up(): void
    {
        Schema::table('financial_accounts', function (Blueprint $table) {
            $table->foreignId('church_id')
                ->after('id')
                ->constrained('churches')
                ->cascadeOnDelete();

            $table->string('name')->after('church_id');

            $table->string('type', 30)
                ->default('bank')
                ->after('name');

            $table->string('provider_name')
                ->nullable()
                ->after('type');

            $table->string('account_number')
                ->nullable()
                ->after('provider_name');

            $table->decimal('opening_balance', 15, 2)
                ->default(0)
                ->after('account_number');

            $table->date('opening_balance_date')
                ->nullable()
                ->after('opening_balance');

            $table->string('currency', 3)
                ->default('NGN')
                ->after('opening_balance_date');

            $table->boolean('is_default')
                ->default(false)
                ->after('currency');

            $table->boolean('is_active')
                ->default(true)
                ->after('is_default');

            $table->text('notes')
                ->nullable()
                ->after('is_active');

            $table->index(
                ['church_id', 'is_active'],
                'financial_accounts_church_active_index'
            );

            $table->index(
                ['church_id', 'is_default'],
                'financial_accounts_church_default_index'
            );

            $table->unique(
                ['church_id', 'name'],
                'financial_accounts_church_name_unique'
            );
        });
    }

    /**
     * Reverse the migration.
     */
    public function down(): void
    {
        Schema::table('financial_accounts', function (Blueprint $table) {
            $table->dropForeign(['church_id']);

            $table->dropUnique(
                'financial_accounts_church_name_unique'
            );

            $table->dropIndex(
                'financial_accounts_church_active_index'
            );

            $table->dropIndex(
                'financial_accounts_church_default_index'
            );

            $table->dropColumn([
                'church_id',
                'name',
                'type',
                'provider_name',
                'account_number',
                'opening_balance',
                'opening_balance_date',
                'currency',
                'is_default',
                'is_active',
                'notes',
            ]);
        });
    }
};