<?php

namespace App\Http\Controllers\Church;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuditLogController extends Controller
{
    /**
     * Display the church audit logs.
     */
    public function index(Request $request): View
    {
        $user = Auth::user();
        $church = $user?->church;

        abort_unless($church, 403);

        $query = ActivityLog::query()
            ->where('church_id', $church->id)
            ->with('user')
            ->latest('created_at');

        /*
        |--------------------------------------------------------------------------
        | Search
        |--------------------------------------------------------------------------
        */

        if ($request->filled('search')) {
            $search = trim($request->input('search'));

            $query->where(function ($q) use ($search) {
                $q->where('description', 'like', "%{$search}%")
                    ->orWhere('action', 'like', "%{$search}%")
                    ->orWhere('subject_type', 'like', "%{$search}%")
                    ->orWhere('ip_address', 'like', "%{$search}%");
            });
        }

        /*
        |--------------------------------------------------------------------------
        | Action Filter
        |--------------------------------------------------------------------------
        */

        if ($request->filled('action')) {
            $query->where('action', $request->input('action'));
        }

        /*
        |--------------------------------------------------------------------------
        | Date Filter
        |--------------------------------------------------------------------------
        */

        if ($request->filled('date')) {
            $query->whereDate(
                'created_at',
                $request->input('date')
            );
        }

        $logs = $query
            ->paginate(25)
            ->withQueryString();

        $actions = ActivityLog::query()
            ->where('church_id', $church->id)
            ->whereNotNull('action')
            ->distinct()
            ->orderBy('action')
            ->pluck('action');

        return view('church.audit-logs.index', [
            'user' => $user,
            'church' => $church,
            'logs' => $logs,
            'actions' => $actions,
        ]);
    }
}