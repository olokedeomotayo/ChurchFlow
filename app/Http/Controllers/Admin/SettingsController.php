<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SettingsController extends Controller
{
    /**
     * Display the system settings page.
     */
    public function index(): View
    {
        return view('admin.settings.index');
    }


    /*
    |--------------------------------------------------------------------------
    | Platform Settings
    |--------------------------------------------------------------------------
    */

    /**
     * Display platform settings.
     */
    public function platform(): View
    {
        $settings = Setting::query()
            ->pluck('value', 'key');

        return view(
            'admin.settings.platform',
            compact('settings')
        );
    }


    /**
     * Update platform settings.
     */
    public function updatePlatform(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'platform_name' => [
                'required',
                'string',
                'max:255',
            ],

            'support_email' => [
                'required',
                'email',
                'max:255',
            ],

            'support_phone' => [
                'nullable',
                'string',
                'max:50',
            ],

            'platform_description' => [
                'nullable',
                'string',
                'max:1000',
            ],

            'currency' => [
                'required',
                'string',
                'max:10',
            ],

            'timezone' => [
                'required',
                'string',
                'max:100',
            ],
        ]);

        foreach ($validated as $key => $value) {
            Setting::updateOrCreate(
                ['key' => $key],
                ['value' => $value]
            );
        }

        return redirect()
            ->route('admin.settings.platform')
            ->with(
                'success',
                'Platform settings updated successfully.'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | Payment Settings
    |--------------------------------------------------------------------------
    */

    /**
     * Display payment settings.
     */
    public function payment(): View
    {
        $settings = Setting::query()
            ->pluck('value', 'key');

        return view(
            'admin.settings.payment',
            compact('settings')
        );
    }


    /**
     * Update payment settings.
     */
    public function updatePayment(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'paystack_public_key' => [
                'nullable',
                'string',
                'max:255',
            ],

            'paystack_secret_key' => [
                'nullable',
                'string',
                'max:255',
            ],

            'payment_currency' => [
                'required',
                'string',
                'max:10',
            ],
        ]);

        $validated['automatic_subscription_activation'] =
            $request->boolean('automatic_subscription_activation')
                ? '1'
                : '0';

        foreach ($validated as $key => $value) {
            Setting::updateOrCreate(
                ['key' => $key],
                ['value' => $value]
            );
        }

        return redirect()
            ->route('admin.settings.payment')
            ->with(
                'success',
                'Payment settings updated successfully.'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | Email Settings
    |--------------------------------------------------------------------------
    */

    /**
     * Display email settings.
     */
    public function email(): View
    {
        $settings = Setting::query()
            ->pluck('value', 'key');

        return view(
            'admin.settings.email',
            compact('settings')
        );
    }


    /**
     * Update email settings.
     */
    public function updateEmail(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'mail_from_name' => [
                'required',
                'string',
                'max:255',
            ],

            'mail_from_address' => [
                'required',
                'email',
                'max:255',
            ],
        ]);

        foreach ($validated as $key => $value) {
            Setting::updateOrCreate(
                ['key' => $key],
                ['value' => $value]
            );
        }

        return redirect()
            ->route('admin.settings.email')
            ->with(
                'success',
                'Email settings updated successfully.'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | Security Settings
    |--------------------------------------------------------------------------
    */

    /**
     * Display security settings.
     */
    public function security(): View
    {
        $settings = Setting::query()
            ->pluck('value', 'key');

        return view(
            'admin.settings.security',
            compact('settings')
        );
    }


    /**
     * Update security settings.
     */
    public function updateSecurity(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'session_timeout' => [
                'required',
                'integer',
                'min:30',
                'max:480',
            ],

            'minimum_password_length' => [
                'required',
                'integer',
                'min:6',
                'max:32',
            ],
        ]);

        $validated['two_factor_authentication'] =
            $request->boolean('two_factor_authentication')
                ? '1'
                : '0';

        $validated['login_protection'] =
            $request->boolean('login_protection')
                ? '1'
                : '0';

        $validated['force_password_reset'] =
            $request->boolean('force_password_reset')
                ? '1'
                : '0';

        foreach ($validated as $key => $value) {
            Setting::updateOrCreate(
                ['key' => $key],
                ['value' => $value]
            );
        }

        return redirect()
            ->route('admin.settings.security')
            ->with(
                'success',
                'Security settings updated successfully.'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | Subscription Settings
    |--------------------------------------------------------------------------
    */

    /**
     * Display subscription settings.
     */
    public function subscription(): View
    {
        $settings = Setting::query()
            ->pluck('value', 'key');

        return view(
            'admin.settings.subscription',
            compact('settings')
        );
    }


    /**
     * Update subscription settings.
     */
    public function updateSubscription(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'trial_period' => [
                'required',
                'integer',
                'min:0',
                'max:365',
            ],

            'grace_period' => [
                'required',
                'integer',
                'min:0',
                'max:90',
            ],
        ]);

        $validated['automatic_renewal'] =
            $request->boolean('automatic_renewal')
                ? '1'
                : '0';

        foreach ($validated as $key => $value) {
            Setting::updateOrCreate(
                ['key' => $key],
                ['value' => $value]
            );
        }

        return redirect()
            ->route('admin.settings.subscription')
            ->with(
                'success',
                'Subscription settings updated successfully.'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | System Information
    |--------------------------------------------------------------------------
    */

    /**
     * Display system information.
     */
    public function systemInformation(): View
    {
        $settings = Setting::query()
            ->pluck('value', 'key');

        return view(
            'admin.settings.system-information',
            compact('settings')
        );
    }
}