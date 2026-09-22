<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable([
    'church_id',
    'service_id',
    'attendance_date',
    'men',
    'women',
    'teenagers',
    'children',
    'guests',
    'notes',
])]
class Attendance extends Model
{
    protected $table = 'attendance';

    public function church(): BelongsTo
    {
        return $this->belongsTo(Church::class);
    }

    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class);
    }

    /**
     * Get the total attendance.
     */
    public function getTotalAttribute(): int
    {
        return (int) $this->men
            + (int) $this->women
            + (int) $this->teenagers
            + (int) $this->children
            + (int) $this->guests;
    }

    protected function casts(): array
    {
        return [
            'attendance_date' => 'date',
            'men' => 'integer',
            'women' => 'integer',
            'teenagers' => 'integer',
            'children' => 'integer',
            'guests' => 'integer',
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
        ];
    }
}