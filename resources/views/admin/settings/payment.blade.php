@extends('layouts.admin')

@section('title', 'Payment Settings')

@section('page_title', 'Payment Settings')

@section('page_description', 'Configure payment and subscription settings for ChurchFlow.')

@section('content')

    <div class="w-full space-y-6">

        {{-- Success Message --}}

        @if (session('success'))

            <div class="rounded-lg border border-green-200 bg-green-50 px-4 py-3 text-sm font-medium text-green-700">
                {{ session('success') }}
            </div>

        @endif


        {{-- Validation Errors --}}

        @if ($errors->any())

            <div class="rounded-lg border border-red-200 bg-red-50 px-4 py-3">

                <p class="text-sm font-semibold text-red-700">
                    Please correct the following errors:
                </p>

                <ul class="mt-2 list-disc space-y-1 pl-5 text-sm text-red-600">

                    @foreach ($errors->all() as $error)

                        <li>
                            {{ $error }}
                        </li>

                    @endforeach

                </ul>

            </div>

        @endif


        {{-- Page Header --}}

        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

            <div>

                <h2 class="text-xl font-bold text-slate-900">
                    Payment Settings
                </h2>

                <p class="mt-1 text-sm text-slate-500">
                    Configure how ChurchFlow handles payments and subscriptions.
                </p>

            </div>


            <a
                href="{{ route('admin.settings.index') }}"
                class="inline-flex w-fit cursor-pointer items-center rounded-lg border border-slate-300 bg-white px-4 py-2.5 text-sm font-semibold text-slate-700 shadow-sm transition hover:bg-slate-50"
            >
                ← Back to Settings
            </a>

        </div>


        {{-- Payment Provider --}}

        <div class="w-full overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm">

            <div class="border-b border-slate-200 px-6 py-5">

                <h3 class="text-base font-bold text-slate-900">
                    Payment Provider
                </h3>

                <p class="mt-1 text-sm text-slate-500">
                    Configure the payment provider used to process ChurchFlow subscriptions.
                </p>

            </div>


            <form
                method="POST"
                action="{{ route('admin.settings.payment.update') }}"
                class="space-y-6 p-6"
            >

                @csrf


                {{-- Paystack --}}

                <div class="rounded-xl border border-purple-200 bg-purple-50 p-5">

                    <div class="flex items-start gap-4">

                        <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-purple-600 text-sm font-bold text-white">
                            P
                        </div>


                        <div class="flex-1">

                            <div class="flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between">

                                <div>

                                    <h4 class="font-semibold text-slate-900">
                                        Paystack
                                    </h4>

                                    <p class="mt-1 text-sm text-slate-500">
                                        Accept card, bank transfer and other supported payment methods.
                                    </p>

                                </div>


                                <span class="inline-flex w-fit rounded-full bg-green-100 px-3 py-1 text-xs font-semibold text-green-700">
                                    Recommended
                                </span>

                            </div>

                        </div>

                    </div>

                </div>


                {{-- Public Key --}}

                <div>

                    <label
                        for="paystack_public_key"
                        class="mb-2 block text-sm font-semibold text-slate-700"
                    >
                        Paystack Public Key
                    </label>

                    <input
                        type="text"
                        id="paystack_public_key"
                        name="paystack_public_key"
                        value="{{ old('paystack_public_key', $settings['paystack_public_key'] ?? '') }}"
                        class="w-full rounded-lg border border-slate-300 px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-purple-500 focus:ring-2 focus:ring-purple-500/20"
                        placeholder="pk_test_xxxxxxxxxxxxxxxxx"
                    >

                    <p class="mt-1.5 text-xs text-slate-500">
                        Your Paystack public key used for payment initialization.
                    </p>

                </div>


                {{-- Secret Key --}}

                <div>

                    <label
                        for="paystack_secret_key"
                        class="mb-2 block text-sm font-semibold text-slate-700"
                    >
                        Paystack Secret Key
                    </label>

                    <input
                        type="password"
                        id="paystack_secret_key"
                        name="paystack_secret_key"
                        value="{{ old('paystack_secret_key', $settings['paystack_secret_key'] ?? '') }}"
                        class="w-full rounded-lg border border-slate-300 px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-purple-500 focus:ring-2 focus:ring-purple-500/20"
                        placeholder="sk_test_xxxxxxxxxxxxxxxxx"
                    >

                    <p class="mt-1.5 text-xs text-slate-500">
                        Keep your Paystack secret key private and secure.
                    </p>

                </div>


                {{-- Payment Currency --}}

                <div>

                    <label
                        for="payment_currency"
                        class="mb-2 block text-sm font-semibold text-slate-700"
                    >
                        Payment Currency
                    </label>

                    <select
                        id="payment_currency"
                        name="payment_currency"
                        class="w-full cursor-pointer rounded-lg border border-slate-300 bg-white px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-purple-500 focus:ring-2 focus:ring-purple-500/20"
                    >

                        <option
                            value="NGN"
                            {{ old('payment_currency', $settings['payment_currency'] ?? 'NGN') === 'NGN' ? 'selected' : '' }}
                        >
                            NGN — Nigerian Naira
                        </option>

                        <option
                            value="USD"
                            {{ old('payment_currency', $settings['payment_currency'] ?? 'NGN') === 'USD' ? 'selected' : '' }}
                        >
                            USD — US Dollar
                        </option>

                        <option
                            value="GBP"
                            {{ old('payment_currency', $settings['payment_currency'] ?? 'NGN') === 'GBP' ? 'selected' : '' }}
                        >
                            GBP — British Pound
                        </option>

                    </select>

                    <p class="mt-1.5 text-xs text-slate-500">
                        Currency used when processing ChurchFlow subscription payments.
                    </p>

                </div>


                {{-- Automatic Subscription Activation --}}

                <div class="rounded-lg border border-slate-200 bg-slate-50 p-5">

                    <div class="flex items-start gap-4">

                        <div class="pt-0.5">

                            <input
                                type="checkbox"
                                id="automatic_subscription_activation"
                                name="automatic_subscription_activation"
                                value="1"
                                {{ old(
                                    'automatic_subscription_activation',
                                    $settings['automatic_subscription_activation'] ?? '1'
                                ) == '1' ? 'checked' : '' }}
                                class="h-4 w-4 cursor-pointer rounded border-slate-300 text-purple-600 focus:ring-purple-500"
                            >

                        </div>


                        <div>

                            <label
                                for="automatic_subscription_activation"
                                class="cursor-pointer text-sm font-semibold text-slate-900"
                            >
                                Automatically activate subscriptions
                            </label>

                            <p class="mt-1 text-xs leading-5 text-slate-500">
                                Automatically activate a church subscription after a successful Paystack payment.
                            </p>

                        </div>

                    </div>

                </div>


                {{-- Save Button --}}

                <div class="flex items-center justify-end border-t border-slate-200 pt-6">

                    <button
                        type="submit"
                        class="inline-flex cursor-pointer items-center rounded-lg bg-purple-600 px-5 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-2"
                    >
                        Save Payment Settings
                    </button>

                </div>

            </form>

        </div>

    </div>

@endsection