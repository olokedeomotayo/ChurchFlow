<?php

namespace App\Http\Responses;

use Laravel\Fortify\Contracts\LoginResponse as LoginResponseContract;

class LoginResponse implements LoginResponseContract
{
    /**
     * Handle the authenticated user's redirect.
     */
    public function toResponse($request)
    {
        $user = $request->user();

        /*
        |--------------------------------------------------------------------------
        | Platform Administrators
        |--------------------------------------------------------------------------
        */

        if ($user->hasRole('platform_admin')) {
            return redirect()->route('dashboard');
        }

        /*
        |--------------------------------------------------------------------------
        | Church Users
        |--------------------------------------------------------------------------
        |
        | Any authenticated user belonging to a church is a church user.
        | Their specific role controls what they are allowed to access.
        |
        */

        if ($user->church_id !== null) {
            return redirect()->route('church.dashboard');
        }

        /*
        |--------------------------------------------------------------------------
        | Unauthorized Users
        |--------------------------------------------------------------------------
        */

        abort(403, 'You do not have permission to access ChurchFlow.');
    }
}