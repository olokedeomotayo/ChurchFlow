<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ChurchAccess
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        // User must be authenticated.
        if (!$user) {
            return redirect()->route('login');
        }

        // User must belong to a church.
        if (!$user->church_id) {
            abort(403, 'You do not belong to a church.');
        }

        // Any authenticated church user may access the church area.
        // Specific permissions are enforced by individual modules.
        return $next($request);
    }
}