<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>

    <meta charset="utf-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1"
    >

    <meta
        name="csrf-token"
        content="{{ csrf_token() }}"
    >

    <title>
        @yield('title', 'Dashboard') - ChurchFlow
    </title>

    @vite([
        'resources/css/app.css',
        'resources/js/app.js'
    ])

</head>


<body class="min-h-screen bg-slate-100 text-slate-900">

    @php
        $churchUser = auth()->user();
        $church = $churchUser?->church;
    @endphp


    <div class="min-h-screen">

        {{-- =====================================================
             SIDEBAR
        ====================================================== --}}

        @include('layouts.church.partials.sidebar', [
            'user' => $churchUser,
            'church' => $church,
        ])


        {{-- =====================================================
             MAIN APPLICATION
        ====================================================== --}}

        <div class="min-h-screen lg:pl-64">


            {{-- Header --}}

            @include('layouts.church.partials.header', [
                'user' => $churchUser,
                'church' => $church,
            ])


            {{-- =================================================
                 PAGE CONTENT
            ================================================== --}}

            <main class="px-4 py-6 sm:px-6 lg:px-8">


                {{-- Success Message --}}

                @if(session('success'))

                    <div class="mb-6 rounded-lg border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-700">

                        {{ session('success') }}

                    </div>

                @endif


                {{-- Error Message --}}

                @if(session('error'))

                    <div class="mb-6 rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">

                        {{ session('error') }}

                    </div>

                @endif


                {{-- Validation Errors --}}

                @if($errors->any())

                    <div class="mb-6 rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">

                        <p class="font-semibold">
                            Please correct the following errors:
                        </p>

                        <ul class="mt-2 list-disc pl-5">

                            @foreach($errors->all() as $error)

                                <li>
                                    {{ $error }}
                                </li>

                            @endforeach

                        </ul>

                    </div>

                @endif


                @yield('content')

            </main>


            {{-- =================================================
                 FOOTER
            ================================================== --}}

            @include('layouts.church.partials.footer', [
                'church' => $church,
            ])

        </div>

    </div>

</body>

</html>