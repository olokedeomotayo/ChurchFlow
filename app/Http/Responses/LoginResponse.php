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
        | Church Users
        |--------------------------------------------------------------------------
        */

        if ($user->hasRole('church_owner')) {
            return redirect()->route('church.dashboard');
        }

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
        | Unauthorized Users
        |--------------------------------------------------------------------------
        */

        abort(403, 'You do not have permission to access ChurchFlow.');
    }
}