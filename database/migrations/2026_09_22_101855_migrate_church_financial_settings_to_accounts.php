<?php

use App\Models\ChurchFinancialSetting;
use App\Models\FinancialAccount;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Migrate existing church-wide opening balances
     * into the new financial accounts structure.
     */
    public function up(): void
    {
        ChurchFinancialSetting::query()
            ->orderBy('id')
            ->each(function (ChurchFinancialSetting $setting): void {
                // Do not create a duplicate account if the church
                // already has a financial account.
                if (
                    FinancialAccount::query()
                        ->where('church_id', $setting->church_id)
                        ->exists()
                ) {
                    return;
                }

                FinancialAccount::create([
                    'church_id' => $setting->church_id,
                    'name' => 'Main Account',
                    'type' => 'bank',
                    'provider_name' => null,
                    'account_number' => null,
                    'opening_balance' => $setting->opening_balance ?? 0,
                    'opening_balance_date' => $setting->opening_balance_date,
                    'currency' => 'NGN',
                    'is_default' => true,
                    'is_active' => true,
                    'notes' => 'Migrated from the previous church-wide financial settings.',
                ]);
            });
    }

    /**
     * Reverse the migration.
     */
    public function down(): void
    {
        FinancialAccount::query()
            ->where('name', 'Main Account')
            ->where('notes', 'Migrated from the previous church-wide financial settings.')
            ->delete();
    }
};