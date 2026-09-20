<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable([
    'church_id',
    'name',
    'description',
    'service_date',
    'start_time',
    'end_time',
    'status',
])]
class Service extends Model
{
    public function church(): BelongsTo
    {
        return $this->belongsTo(Church::class);
    }

    public function attendances(): HasMany
    {
        return $this->hasMany(Attendance::class);
    }

    protected function casts(): array
    {
        return [
            'service_date' => 'date',
            'start_time' => 'datetime:H:i',
            'end_time' => 'datetime:H:i',
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
        ];
    }
}