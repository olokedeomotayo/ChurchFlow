<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Church Flow — Manage Your Church With Confidence</title>

    <meta
        name="description"
        content="Manage your church finances, members, giving, check-ins and operations from one simple platform."
    >

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body>

    @include('landing.sections.header')

    <main>
        @include('landing.sections.hero')
        @include('landing.sections.trust')
        @include('landing.sections.problem')
        @include('landing.sections.about')
        @include('landing.sections.features')
        @include('landing.sections.benefits')
        @include('landing.sections.how-it-works')
        @include('landing.sections.showcase')
        @include('landing.sections.pricing')
        @include('landing.sections.testimonials')
        @include('landing.sections.security')
        @include('landing.sections.faq')
        @include('landing.sections.cta')
        @include('landing.sections.contact')
    </main>

    @include('landing.sections.footer')

</body>
</html>