<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? config('app.name', 'Argenesia Hub') }}</title>
    <link rel="icon" type="image/webp" href="{{ asset('argenesiahub.webp') }}">
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

    <!-- AOS CSS -->
    <link href="https://unpkg.com/aos@2.3.4/dist/aos.css" rel="stylesheet">

    <!-- Styles / Scripts -->
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @else
        <style>
            /* ...existing code... */
        </style>
    @endif
</head>
<body class="bg-linear-to-r from-[#F53003] to-[#0074D9] min-h-screen flex items-center justify-center px-2">
    <div
        class="bg-white/30 backdrop-blur-lg border border-white/30 rounded-lg shadow-lg p-6 sm:p-8 md:p-12 w-full max-w-xs sm:max-w-md text-center"
        data-aos="fade-up"
        data-aos-duration="1200"
    >
        <div data-aos="zoom-in" data-aos-delay="300">
            <img src="{{ asset('argenesiahub.webp') }}" alt="Logo" class="mx-auto mb-4 w-20 h-20 sm:w-24 sm:h-24 hover:scale-105 transition-transform cursor-pointer" />
        </div>
        <h1 class="text-2xl sm:text-3xl font-bold mb-2 text-[#1b1b18]" data-aos="fade-right" data-aos-delay="600">
            Selamat Datang di Argenesia Hub
        </h1>
        <div data-aos="flip-left" data-aos-delay="900">
            <a href="{{ route('login') }}"
            class="inline-block px-5 py-2 sm:px-6 bg-linear-to-r from-[#F53003] to-[#0074D9] text-white rounded-full font-medium hover:from-[#d42a02] hover:to-[#005fa3] transition-all hover:scale-105 text-base sm:text-lg">
                Masuk
            </a>
        </div>
    </div>

    <!-- AOS JS -->
    <script src="https://unpkg.com/aos@2.3.4/dist/aos.js"></script>
    <script>
        AOS.init();
    </script>
</body>
</html>
