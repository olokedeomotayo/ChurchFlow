<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable([
    'name',
    'slug',
    'description',
    'monthly_price',
    'annual_price',
    'member_limit',
    'is_active',
])]
class Plan extends Model
{
    /**
     * Get subscriptions belonging to this plan.
     */
    public function subscriptions(): HasMany
    {
        return $this->hasMany(Subscription::class);
    }

    /**
     * Cast plan attributes.
     */
    protected function casts(): array
    {
        return [
            'monthly_price' => 'decimal:2',
            'annual_price' => 'decimal:2',
            'member_limit' => 'integer',
            'is_active' => 'boolean',
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
        ];
    }
}