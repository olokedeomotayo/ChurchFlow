<?php

namespace App\Http\Controllers\Church;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\Plan;
use App\Models\Subscription;
use App\Services\ActivityLogService;
use App\Services\PaystackService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\View\View;
use RuntimeException;

class PaymentController extends Controller
{
    /**
     * Display available subscription plans.
     */
    public function index(Request $request): View
    {
        $church = $request->user()->church;

        $plans = Plan::query()
            ->where('is_active', true)
            ->orderBy('monthly_price')
            ->get();

        return view(
            'church.payments.index',
            compact('church', 'plans')
        );
    }

    /**
     * Initialize a Paystack payment.
     */
    public function initialize(
        Request $request,
        Plan $plan,
        PaystackService $paystack,
        ActivityLogService $activityLog
    ): RedirectResponse {
        $user = $request->user();
        $church = $user->church;

        /*
        |--------------------------------------------------------------------------
        | Validate Billing Cycle
        |--------------------------------------------------------------------------
        */

        $validated = $request->validate([
            'billing_cycle' => [
                'required',
                'in:monthly,annual',
            ],
        ]);

        $billingCycle = $validated['billing_cycle'];

        /*
        |--------------------------------------------------------------------------
        | Validate Church
        |--------------------------------------------------------------------------
        */

        if (! $church) {
            return back()->with(
                'error',
                'Church account could not be found.'
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Validate Plan
        |--------------------------------------------------------------------------
        */

        if (! $plan->is_active) {
            return back()->with(
                'error',
                'This subscription plan is currently unavailable.'
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Determine Price
        |--------------------------------------------------------------------------
        */

        $price = $billingCycle === 'annual'
            ? $plan->annual_price
            : $plan->monthly_price;

        /*
        |--------------------------------------------------------------------------
        | Validate Price
        |--------------------------------------------------------------------------
        */

        if ((float) $price <= 0) {
            return back()->with(
                'error',
                'The selected billing option is not currently available for this plan.'
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Generate Payment Reference
        |--------------------------------------------------------------------------
        */

        $reference = 'CF-' . strtoupper(
            Str::random(12)
        );

        /*
        |--------------------------------------------------------------------------
        | Convert Amount to Kobo
        |--------------------------------------------------------------------------
        */

        $amount = (int) round(
            ((float) $price) * 100
        );

        /*
        |--------------------------------------------------------------------------
        | Create Payment Record
        |--------------------------------------------------------------------------
        */

        $payment = Payment::create([
            'church_id' => $church->id,
            'subscription_id' => null,
            'plan_id' => $plan->id,
            'reference' => $reference,
            'gateway' => 'paystack',
            'amount' => $price,
            'currency' => config(
                'app.currency',
                'NGN'
            ),
            'status' => 'pending',
            'metadata' => [
                'church_id' => $church->id,
                'church_name' => $church->name,
                'user_id' => $user->id,
                'user_email' => $user->email,
                'plan_id' => $plan->id,
                'plan_name' => $plan->name,
                'billing_cycle' => $billingCycle,
                'billing_cycle_label' => $billingCycle === 'annual'
                    ? 'Annual'
                    : 'Monthly',
                'amount' => $price,
            ],
        ]);

        /*
        |--------------------------------------------------------------------------
        | Initialize Paystack Transaction
        |--------------------------------------------------------------------------
        */

        try {
            $transaction = $paystack->initializeTransaction(
                email: $user->email,
                amount: $amount,
                reference: $reference,
                callbackUrl: route(
                    'church.payments.callback'
                ),
                metadata: [
                    'payment_id' => $payment->id,
                    'church_id' => $church->id,
                    'plan_id' => $plan->id,
                    'billing_cycle' => $billingCycle,
                ]
            );
        } catch (RuntimeException $exception) {
            $payment->update([
                'status' => 'failed',
            ]);

            $activityLog->record(
                action: 'payment_failed',
                subject: $payment,
                description: sprintf(
                    'Paystack payment initialization failed for %s plan (%s).',
                    $plan->name,
                    $billingCycle
                )
            );

            return back()->with(
                'error',
                $exception->getMessage()
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Audit Log
        |--------------------------------------------------------------------------
        */

        $activityLog->record(
            action: 'payment_initialized',
            subject: $payment,
            description: sprintf(
                'Payment initialized for %s %s subscription: ₦%s.',
                $plan->name,
                $billingCycle,
                number_format((float) $price, 2)
            )
        );

        /*
        |--------------------------------------------------------------------------
        | Redirect to Paystack
        |--------------------------------------------------------------------------
        */

        return redirect()->away(
            $transaction['authorization_url']
        );
    }

    /**
     * Handle Paystack callback.
     */
    public function callback(
        Request $request,
        PaystackService $paystack,
        ActivityLogService $activityLog
    ): RedirectResponse {
        $reference = $request->query('reference');

        /*
        |--------------------------------------------------------------------------
        | Validate Reference
        |--------------------------------------------------------------------------
        */

        if (! $reference) {
            return redirect()
                ->route('church.dashboard')
                ->with(
                    'error',
                    'Payment reference was not provided.'
                );
        }

        /*
        |--------------------------------------------------------------------------
        | Find Payment
        |--------------------------------------------------------------------------
        */

        $payment = Payment::query()
            ->where('reference', $reference)
            ->first();

        if (! $payment) {
            return redirect()
                ->route('church.dashboard')
                ->with(
                    'error',
                    'Payment record could not be found.'
                );
        }

        /*
        |--------------------------------------------------------------------------
        | Prevent Duplicate Processing
        |--------------------------------------------------------------------------
        */

        if ($payment->status === 'success') {
            return redirect()
                ->route('church.dashboard')
                ->with(
                    'success',
                    'This payment has already been processed.'
                );
        }

        /*
        |--------------------------------------------------------------------------
        | Verify Payment
        |--------------------------------------------------------------------------
        */

        try {
            $transaction = $paystack->verifyTransaction(
                $reference
            );
        } catch (RuntimeException $exception) {
            $activityLog->record(
                action: 'payment_failed',
                subject: $payment,
                description: sprintf(
                    'Payment verification failed for reference %s.',
                    $reference
                )
            );

            return redirect()
                ->route('church.dashboard')
                ->with(
                    'error',
                    $exception->getMessage()
                );
        }

        /*
        |--------------------------------------------------------------------------
        | Payment Failed
        |--------------------------------------------------------------------------
        */

        if (($transaction['status'] ?? null) !== 'success') {
            $payment->update([
                'status' => 'failed',
                'gateway_transaction_id' =>
                    $transaction['id'] ?? null,
                'gateway_response' =>
                    $transaction,
            ]);

            $activityLog->record(
                action: 'payment_failed',
                subject: $payment,
                description: sprintf(
                    'Payment failed for reference %s.',
                    $reference
                )
            );

            return redirect()
                ->route('church.dashboard')
                ->with(
                    'error',
                    'Payment was not successful.'
                );
        }

        /*
        |--------------------------------------------------------------------------
        | Retrieve Billing Cycle
        |--------------------------------------------------------------------------
        */

        $billingCycle = data_get(
            $payment->metadata,
            'billing_cycle'
        ) ?? 'monthly';

        /*
        |--------------------------------------------------------------------------
        | Activate Subscription
        |--------------------------------------------------------------------------
        */

        try {
            $subscription = DB::transaction(
                function () use (
                    $payment,
                    $billingCycle,
                    $transaction
                ) {
                    /*
                    |--------------------------------------------------------------------------
                    | Update Payment
                    |--------------------------------------------------------------------------
                    */

                    $payment->update([
                        'status' => 'success',
                        'gateway_transaction_id' =>
                            $transaction['id'] ?? null,
                        'payment_method' =>
                            $transaction['channel'] ?? null,
                        'paid_at' => now(),
                        'gateway_response' =>
                            $transaction,
                    ]);

                    /*
                    |--------------------------------------------------------------------------
                    | Cancel Existing Active Subscriptions
                    |--------------------------------------------------------------------------
                    */

                    Subscription::query()
                        ->where('church_id', $payment->church_id)
                        ->whereIn('status', [
                            'active',
                            'trial',
                        ])
                        ->update([
                            'status' => 'cancelled',
                            'cancelled_at' => now(),
                        ]);

                    /*
                    |--------------------------------------------------------------------------
                    | Calculate Subscription Dates
                    |--------------------------------------------------------------------------
                    */

                    $startsAt = now();

                    $endsAt = $billingCycle === 'annual'
                        ? $startsAt->copy()->addYear()
                        : $startsAt->copy()->addMonth();

                    /*
                    |--------------------------------------------------------------------------
                    | Create Active Subscription
                    |--------------------------------------------------------------------------
                    */

                    $subscription = Subscription::create([
                        'church_id' => $payment->church_id,
                        'plan_id' => $payment->plan_id,
                        'status' => 'active',
                        'billing_cycle' => $billingCycle,
                        'starts_at' => $startsAt,
                        'ends_at' => $endsAt,
                        'trial_ends_at' => null,
                        'cancelled_at' => null,
                    ]);

                    /*
                    |--------------------------------------------------------------------------
                    | Link Payment to Subscription
                    |--------------------------------------------------------------------------
                    */

                    $payment->update([
                        'subscription_id' =>
                            $subscription->id,
                    ]);

                    return $subscription;
                }
            );
        } catch (\Throwable $exception) {
            report($exception);

            return redirect()
                ->route('church.dashboard')
                ->with(
                    'error',
                    'Payment was received, but we could not activate your subscription. Please contact support.'
                );
        }

        /*
        |--------------------------------------------------------------------------
        | Audit Successful Payment
        |--------------------------------------------------------------------------
        */

        $activityLog->record(
            action: 'payment_completed',
            subject: $payment,
            description: sprintf(
                'Payment completed successfully: ₦%s via Paystack.',
                number_format((float) $payment->amount, 2)
            )
        );

        /*
        |--------------------------------------------------------------------------
        | Audit Subscription Activation
        |--------------------------------------------------------------------------
        */

        $plan = $payment->plan;

        $activityLog->record(
            action: 'subscription_activated',
            subject: $subscription,
            description: sprintf(
                '%s %s subscription activated for %s.',
                $plan?->name ?? 'Subscription',
                $billingCycle,
                $payment->church_id
            )
        );

        /*
        |--------------------------------------------------------------------------
        | Success
        |--------------------------------------------------------------------------
        */

        $billingLabel = $billingCycle === 'annual'
            ? 'annual'
            : 'monthly';

        return redirect()
            ->route('church.dashboard')
            ->with(
                'success',
                "Payment completed successfully. Your {$billingLabel} subscription is now active."
            );
    }
}