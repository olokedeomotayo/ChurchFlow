<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;



#[Fillable([
    'code',
    'name',
    'slug',
    'email',
    'phone',
    'address',
    'city',
    'state',
    'country',
    'timezone',
    'status',
    'trial_started_at',
    'trial_ends_at',
])]
class Church extends Model
{
    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }

    public function subscriptions(): HasMany
    {
        return $this->hasMany(Subscription::class);
    }

    protected function casts(): array
    {
        return [
            'trial_started_at' => 'datetime',
            'trial_ends_at' => 'datetime',
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
        ];
    }

    /**
     * Payments made by this church.
     */
    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class);
    }

    /**
     * Members belonging to this church.
     */
    public function members(): HasMany
    {
        return $this->hasMany(Member::class);
    }

    public function groups(): HasMany
{
    return $this->hasMany(Group::class);
}
}