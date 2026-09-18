<?php

namespace App\Providers;

use App\Actions\Fortify\CreateNewUser;
use App\Actions\Fortify\ResetUserPassword;
use App\Actions\Fortify\UpdateUserPassword;
use App\Actions\Fortify\UpdateUserProfileInformation;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Support\ServiceProvider;
use Laravel\Fortify\Actions\RedirectIfTwoFactorAuthenticatable;
use Laravel\Fortify\Fortify;
use App\Http\Responses\LoginResponse;
use Laravel\Fortify\Contracts\LoginResponse as LoginResponseContract;

class FortifyServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(
            LoginResponseContract::class,
            LoginResponse::class
        );
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        /*
        |--------------------------------------------------------------------------
        | Authentication Views
        |--------------------------------------------------------------------------
        */

        Fortify::registerView(function () {
            return view('auth.register');
        });

        Fortify::loginView(function () {
            return view('auth.login');
        });


        /*
        |--------------------------------------------------------------------------
        | Fortify Actions
        |--------------------------------------------------------------------------
        */

        Fortify::createUsersUsing(
            CreateNewUser::class
        );

        Fortify::updateUserProfileInformationUsing(
            UpdateUserProfileInformation::class
        );

        Fortify::updateUserPasswordsUsing(
            UpdateUserPassword::class
        );

        Fortify::resetUserPasswordsUsing(
            ResetUserPassword::class
        );

        Fortify::redirectUserForTwoFactorAuthenticationUsing(
            RedirectIfTwoFactorAuthenticatable::class
        );


        /*
        |--------------------------------------------------------------------------
        | Login Rate Limiting
        |--------------------------------------------------------------------------
        */

        RateLimiter::for('login', function (Request $request) {

            $throttleKey = Str::transliterate(
                Str::lower(
                    $request->input(
                        Fortify::username()
                    )
                ) . '|' . $request->ip()
            );

            return Limit::perMinute(5)
                ->by($throttleKey);
        });


        /*
        |--------------------------------------------------------------------------
        | Two-Factor Authentication Rate Limiting
        |--------------------------------------------------------------------------
        */

        RateLimiter::for('two-factor', function (Request $request) {

            return Limit::perMinute(5)
                ->by(
                    $request->session()->get('login.id')
                );
        });


        /*
        |--------------------------------------------------------------------------
        | Passkey Rate Limiting
        |--------------------------------------------------------------------------
        */

        RateLimiter::for('passkeys', function (Request $request) {

            $credentialId = $request->input(
                'credential.id'
            );

            $throttleKey =
                ($credentialId
                    ?: $request->session()->getId())
                . '|' .
                $request->ip();

            return Limit::perMinute(10)
                ->by($throttleKey);
        });
    }
}