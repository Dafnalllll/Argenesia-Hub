<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', config('app.name', 'Argenesia Hub'))</title>
    <link rel="icon" type="image/webp" href="{{ asset('argenesiahub.webp') }}">
    <!-- Tailwind CSS (via Vite/Laravel Mix) -->
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

    <!-- AOS CSS -->
    <link href="https://unpkg.com/aos@2.3.4/dist/aos.css" rel="stylesheet">
    @livewireStyles
</head>
<body>
    <div class="min-h-screen flex bg-linear-to-b from-[#0074D9] to-[#F53003]">
        @if (!in_array(Route::currentRouteName(), ['login', 'register']))
            @include('components.sidebar')
        @endif
        <div class="flex-1 flex items-start justify-center
            @if (!in_array(Route::currentRouteName(), ['login', 'register'])) ml-56 @endif">
            @hasSection('content')
                @yield('content')
            @else
                {{ $slot ?? '' }}
            @endif
        </div>
    </div>

    <!-- AOS JS -->
    <script src="https://unpkg.com/aos@2.3.4/dist/aos.js"></script>
    <script>
        AOS.init();
    </script>
    @livewireScripts
    <script>
        window.addEventListener('redirectToLogin', function () {
            window.location.href = '/login';
        });
    </script>
</body>
</html>
