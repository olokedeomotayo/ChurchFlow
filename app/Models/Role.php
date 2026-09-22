<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Permission\Models\Role as SpatieRole;

class Role extends SpatieRole
{
    protected $fillable = [
        'name',
        'guard_name',
        'church_id',
    ];

    protected function casts(): array
    {
        return [
            'church_id' => 'integer',
        ];
    }

    public function church(): BelongsTo
    {
        return $this->belongsTo(Church::class);
    }

    public function isPlatformRole(): bool
    {
        return is_null($this->church_id);
    }

    public function isChurchRole(): bool
    {
        return ! is_null($this->church_id);
    }
}