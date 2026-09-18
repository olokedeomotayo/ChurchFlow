<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

#[Fillable([
    'church_id',
    'name',
    'description',
    'type',
    'status',
    'leader_id',
])]
class Group extends Model
{
    /**
     * The church this group belongs to.
     */
    public function church(): BelongsTo
    {
        return $this->belongsTo(Church::class);
    }

    /**
     * The leader of this group or department.
     */
    public function leader(): BelongsTo
    {
        return $this->belongsTo(Member::class, 'leader_id');
    }

    /**
     * Members belonging to this group.
     */
    public function members(): BelongsToMany
    {
        return $this->belongsToMany(
            Member::class,
            'group_members',
            'group_id',
            'member_id'
        )->withTimestamps();
    }

    /**
     * Attribute helper.
     */
    public function isDepartment(): bool
    {
        return $this->type === 'department';
    }

    /**
     * Attribute helper.
     */
    public function isGroup(): bool
    {
        return $this->type === 'group';
    }

    /**
     * Attribute helper.
     */
    public function isActive(): bool
    {
        return $this->status === 'active';
    }

    /**
     * Model casts.
     */
    protected function casts(): array
    {
        return [
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
        ];
    }
}