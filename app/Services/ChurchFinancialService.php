<?php

namespace App\Services;

use App\Models\Church;
use App\Models\Expense;
use App\Models\Income;

class ChurchFinancialService
{
    /**
     * Calculate the church's current financial balance.
     *
     * Formula:
     *
     * Opening Balance
     * + Income on/after opening balance date
     * - Expenses on/after opening balance date
     */
    public function currentBalance(Church $church): float
    {
        $openingBalance = $this->openingBalance($church);
        $openingBalanceDate = $this->openingBalanceDate($church);

        if (! $openingBalanceDate) {
            return $openingBalance;
        }

        $income = $this->incomeSinceOpeningBalance($church);
        $expenses = $this->expensesSinceOpeningBalance($church);

        return $openingBalance + $income - $expenses;
    }

    /**
     * Get the church's opening balance.
     */
    public function openingBalance(Church $church): float
    {
        return (float) (
            $church->financialSetting?->opening_balance ?? 0
        );
    }

    /**
     * Get the church's opening balance date.
     */
    public function openingBalanceDate(Church $church)
    {
        return $church->financialSetting?->opening_balance_date;
    }

    /**
     * Get total income on or after the opening balance date.
     */
    public function incomeSinceOpeningBalance(Church $church): float
    {
        $openingBalanceDate = $this->openingBalanceDate($church);

        if (! $openingBalanceDate) {
            return 0;
        }

        return (float) Income::query()
            ->where('church_id', $church->id)
            ->whereDate('income_date', '>=', $openingBalanceDate)
            ->sum('amount');
    }

    /**
     * Get total expenses on or after the opening balance date.
     */
    public function expensesSinceOpeningBalance(Church $church): float
    {
        $openingBalanceDate = $this->openingBalanceDate($church);

        if (! $openingBalanceDate) {
            return 0;
        }

        return (float) Expense::query()
            ->where('church_id', $church->id)
            ->whereDate('expense_date', '>=', $openingBalanceDate)
            ->sum('amount');
    }
}