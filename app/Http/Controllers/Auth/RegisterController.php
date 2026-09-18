<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Church;
use App\Models\Plan;
use App\Models\Setting;
use App\Models\Subscription;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class RegisterController extends Controller
{
    /**
     * Register a new church and church owner.
     */
    public function store(Request $request)
    {
        /*
        |--------------------------------------------------------------------------
        | Validate Registration Data
        |--------------------------------------------------------------------------
        */

        $validator = Validator::make($request->all(), [

            // Church Information
            'church_name' => [
                'required',
                'string',
                'max:255',
            ],

            'church_email' => [
                'nullable',
                'email',
                'max:255',
            ],

            'church_phone' => [
                'nullable',
                'string',
                'max:30',
            ],

            'address' => [
                'nullable',
                'string',
                'max:1000',
            ],

            'city' => [
                'nullable',
                'string',
                'max:100',
            ],

            'state' => [
                'nullable',
                'string',
                'max:100',
            ],

            'country' => [
                'required',
                'string',
                'max:100',
            ],

            'timezone' => [
                'required',
                'string',
                'max:100',
            ],

            // Church Owner
            'name' => [
                'required',
                'string',
                'max:255',
            ],

            'email' => [
                'required',
                'email',
                'max:255',
                'unique:users,email',
            ],

            'password' => [
                'required',
                'string',
                'min:8',
                'confirmed',
            ],

            // Terms
            'terms' => [
                'required',
                'accepted',
            ],
        ]);

        /*
        |--------------------------------------------------------------------------
        | Return Validation Errors
        |--------------------------------------------------------------------------
        */

        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput();
        }

        $data = $validator->validated();

        /*
        |--------------------------------------------------------------------------
        | Find Free Trial Plan
        |--------------------------------------------------------------------------
        */

        $plan = Plan::query()
            ->where('slug', 'free-trial')
            ->where('is_active', true)
            ->first();

        if (!$plan) {
            return back()
                ->withInput()
                ->withErrors([
                    'registration' => 'The Free Trial plan is currently unavailable.',
                ]);
        }

        /*
        |--------------------------------------------------------------------------
        | Get Admin-Configured Trial Period
        |--------------------------------------------------------------------------
        |
        | The Platform Admin controls the default trial duration from:
        |
        | Admin → Settings → Subscription Settings
        |
        | Example:
        | trial_period = 30
        |
        | The value is stored in the settings table.
        |
        */

        $trialPeriod = (int) (
            Setting::query()
                ->where('key', 'trial_period')
                ->value('value')
            ?? 30
        );

        /*
        |--------------------------------------------------------------------------
        | Create Church, Owner and Subscription
        |--------------------------------------------------------------------------
        */

        $result = DB::transaction(function () use (
            $data,
            $plan,
            $trialPeriod
        ) {

            /*
            |--------------------------------------------------------------------------
            | Calculate Trial Dates
            |--------------------------------------------------------------------------
            */

            $trialStartedAt = now();

            $trialEndsAt = $trialStartedAt
                ->copy()
                ->addDays($trialPeriod);

            /*
            |--------------------------------------------------------------------------
            | Create Church
            |--------------------------------------------------------------------------
            */

            $church = Church::create([

                'code' => 'CH-' . strtoupper(Str::random(8)),

                'name' => $data['church_name'],

                'slug' => Str::slug($data['church_name'])
                    . '-' . Str::lower(Str::random(6)),

                'email' => $data['church_email'] ?? null,

                'phone' => $data['church_phone'] ?? null,

                'address' => $data['address'] ?? null,

                'city' => $data['city'] ?? null,

                'state' => $data['state'] ?? null,

                'country' => $data['country'],

                'timezone' => $data['timezone'],

                'status' => 'trial',

                'trial_started_at' => $trialStartedAt,

                'trial_ends_at' => $trialEndsAt,
            ]);

            /*
            |--------------------------------------------------------------------------
            | Create Church Owner
            |--------------------------------------------------------------------------
            */

            $owner = User::create([

                'church_id' => $church->id,

                'name' => $data['name'],

                'email' => $data['email'],

                'password' => $data['password'],
            ]);

            /*
            |--------------------------------------------------------------------------
            | Assign Church Owner Role
            |--------------------------------------------------------------------------
            */

            $owner->assignRole('church_owner');

            /*
            |--------------------------------------------------------------------------
            | Create Trial Subscription
            |--------------------------------------------------------------------------
            */

            $subscription = Subscription::create([

                'church_id' => $church->id,

                'plan_id' => $plan->id,

                'status' => 'trial',

                'starts_at' => $trialStartedAt,

                'ends_at' => $trialEndsAt,

                'trial_ends_at' => $trialEndsAt,
            ]);

            return [
                'church' => $church,
                'owner' => $owner,
                'subscription' => $subscription,
            ];
        });

        /*
        |--------------------------------------------------------------------------
        | Log In Church Owner
        |--------------------------------------------------------------------------
        */

        Auth::login($result['owner']);

        /*
        |--------------------------------------------------------------------------
        | Regenerate Session
        |--------------------------------------------------------------------------
        */

        $request->session()->regenerate();

        /*
        |--------------------------------------------------------------------------
        | Redirect to Church Dashboard
        |--------------------------------------------------------------------------
        */

        return redirect()
            ->route('church.dashboard')
            ->with(
                'success',
                'Welcome to ChurchFlow! Your church account has been created successfully.'
            );
    }
}