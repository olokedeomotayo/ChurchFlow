<?php

namespace App\Services;

use App\Models\ActivityLog;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class ActivityLogService
{
    /**
     * Record an activity in the audit log.
     */
    public function record(
        string $action,
        ?Model $subject = null,
        ?string $description = null
    ): ActivityLog {
        $user = Auth::user();

        return ActivityLog::create([
            'church_id' => $user?->church_id,
            'user_id' => $user?->id,
            'action' => $action,
            'subject_type' => $subject
                ? $subject::class
                : null,
            'subject_id' => $subject?->getKey(),
            'description' => $description,
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);
    }
}