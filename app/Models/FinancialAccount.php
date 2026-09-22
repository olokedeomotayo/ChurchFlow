<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable([
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
])]
class FinancialAccount extends Model
{
    protected $table = 'financial_accounts';

    /**
     * The church that owns this financial account.
     */
    public function church(): BelongsTo
    {
        return $this->belongsTo(Church::class);
    }

    /**
     * Calculate the current balance for this account.
     *
     * Opening Balance
     * + Income
     * - Expenses
     */
    public function getCurrentBalanceAttribute(): float
    {
        $openingBalance = (float) $this->opening_balance;

        $income = Income::query()
            ->where('church_id', $this->church_id)
            ->where('financial_account_id', $this->id)
            ->when(
                $this->opening_balance_date,
                fn ($query) => $query->whereDate(
                    'income_date',
                    '>=',
                    $this->opening_balance_date
                )
            )
            ->sum('amount');

        $expenses = Expense::query()
            ->where('church_id', $this->church_id)
            ->where('financial_account_id', $this->id)
            ->when(
                $this->opening_balance_date,
                fn ($query) => $query->whereDate(
                    'expense_date',
                    '>=',
                    $this->opening_balance_date
                )
            )
            ->sum('amount');

        return $openingBalance + (float) $income - (float) $expenses;
    }

    /**
     * Attribute casting.
     */
    protected function casts(): array
    {
        return [
            'opening_balance' => 'decimal:2',
            'opening_balance_date' => 'date',
            'is_default' => 'boolean',
            'is_active' => 'boolean',
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
        ];
    }
}