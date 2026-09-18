<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable([
    'church_id',
    'subscription_id',
    'plan_id',
    'reference',
    'gateway',
    'gateway_transaction_id',
    'amount',
    'currency',
    'status',
    'payment_method',
    'paid_at',
    'gateway_response',
    'metadata',
])]
class Payment extends Model
{
    /**
     * Church that made the payment.
     */
    public function church(): BelongsTo
    {
        return $this->belongsTo(Church::class);
    }

    /**
     * Subscription associated with the payment.
     */
    public function subscription(): BelongsTo
    {
        return $this->belongsTo(Subscription::class);
    }

    /**
     * Plan associated with the payment.
     */
    public function plan(): BelongsTo
    {
        return $this->belongsTo(Plan::class);
    }

    /**
     * Attribute casting.
     */
    protected function casts(): array
    {
        return [
            'amount' => 'decimal:2',
            'paid_at' => 'datetime',
            'gateway_response' => 'array',
            'metadata' => 'array',
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
        ];
    }
}