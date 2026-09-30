<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>ChurchFlow — Church Management Made Simple</title>

    <meta
        name="description"
        content="ChurchFlow helps churches manage members, attendance, finances, reports and administration from one simple platform."
    >

    @vite([
        'resources/css/app.css',
        'resources/js/app.js'
    ])
</head>

<body class="bg-[#f4f1f7] text-[#211b30] antialiased">

    {{-- Header --}}
    @include('landing.sections.header')

    <main>

        {{-- Hero --}}
        @include('landing.sections.hero')

        {{-- Product & Features --}}
        @include('landing.sections.problem')

        {{-- Dashboard Showcase --}}
        @include('landing.sections.showcase')

        {{-- How ChurchFlow Works --}}
        @include('landing.sections.how-it-works')

        {{-- Trust & Security --}}
        @include('landing.sections.testimonials')

        {{-- FAQ --}}
        @include('landing.sections.faq')

        {{-- Final CTA + Contact --}}
        @include('landing.sections.cta')

    </main>

    {{-- Footer --}}
    @include('landing.sections.footer')

    {{-- Landing Page Interactions --}}
    <script>
        document.addEventListener('DOMContentLoaded', function () {

            const mobileMenu = document.getElementById('mobile-menu');

            document.querySelectorAll('a[href^="#"]').forEach(function (link) {

                link.addEventListener('click', function (event) {

                    const targetId = this.getAttribute('href');

                    if (!targetId || targetId === '#') {
                        return;
                    }

                    const target = document.querySelector(targetId);

                    if (!target) {
                        return;
                    }

                    event.preventDefault();

                    const header = document.querySelector('header');
                    const headerHeight = header ? header.offsetHeight : 0;

                    const targetPosition =
                        target.getBoundingClientRect().top +
                        window.pageYOffset -
                        headerHeight -
                        20;

                    window.scrollTo({
                        top: targetPosition,
                        behavior: 'smooth'
                    });

                    if (
                        mobileMenu &&
                        !mobileMenu.classList.contains('hidden')
                    ) {
                        mobileMenu.classList.add('hidden');
                    }

                });

            });

        });
    </script>

</body>

</html>