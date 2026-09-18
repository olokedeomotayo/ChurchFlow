<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

#[Fillable([
    'church_id',
    'member_id',
    'first_name',
    'last_name',
    'middle_name',
    'email',
    'phone',
    'address',
    'date_of_birth',
    'gender',
    'marital_status',
    'joined_at',
    'membership_status',
    'membership_type',
    'emergency_contact_name',
    'emergency_contact_phone',
    'emergency_contact_relationship',
    'notes',
])]
class Member extends Model
{
    /**
     * Church this member belongs to.
     */
    public function church(): BelongsTo
    {
        return $this->belongsTo(Church::class);
    }

    /**
     * Attribute casting.
     */
    protected function casts(): array
    {
        return [
            'date_of_birth' => 'date',
            'joined_at' => 'date',
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
        ];
    }

    /**
     * Get the member's full name.
     */
    public function getFullNameAttribute(): string
    {
        return trim(
            collect([
                $this->first_name,
                $this->middle_name,
                $this->last_name,
            ])
                ->filter()
                ->implode(' ')
        );
    }

    public function groups(): BelongsToMany
    {
        return $this->belongsToMany(
            Group::class,
            'group_members',
            'member_id',
            'group_id'
        )->withTimestamps();
    }
}