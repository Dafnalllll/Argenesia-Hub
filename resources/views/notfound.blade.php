<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>404 Not Found || Argenesia Hub</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
            /* ...optional fallback style... */
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
        <h1 class="text-4xl sm:text-5xl font-extrabold mb-2 text-[#F53003]" data-aos="fade-right" data-aos-delay="600">
            404
        </h1>
        <h2 class="text-xl sm:text-2xl font-semibold mb-2 text-[#1b1b18]" data-aos="fade-left" data-aos-delay="700">
            Halaman Tidak Ditemukan
        </h2>
        <p class="mb-6 opacity-80 text-[#1b1b18]" data-aos="fade-up" data-aos-delay="800">
            Maaf, halaman yang kamu cari tidak tersedia atau sudah dipindahkan.
        </p>
        <div data-aos="flip-left" data-aos-delay="900">
            @if(auth()->check())
                @php
                    $user = auth()->user();
                    if (isset($user->role) && $user->role->name === 'Admin') {
                        $dashboardUrl = url('/dashboard/admin');
                    } else {
                        $dashboardUrl = url('/dashboard');
                    }
                @endphp
                <a href="{{ $dashboardUrl }}"
                    class="inline-block px-5 py-2 sm:px-6 bg-linear-to-r from-[#F53003] to-[#0074D9] text-white rounded-full font-medium hover:from-[#d42a02] hover:to-[#005fa3] transition-all hover:scale-105 text-base sm:text-lg">
                    Kembali ke Beranda
                </a>
            @else
                <a href="{{ url('/') }}"
                    class="inline-block px-5 py-2 sm:px-6 bg-linear-to-r from-[#F53003] to-[#0074D9] text-white rounded-full font-medium hover:from-[#d42a02] hover:to-[#005fa3] transition-all hover:scale-105 text-base sm:text-lg">
                    Kembali ke Beranda
                </a>
            @endif
        </div>
    </div>

    <!-- AOS JS -->
    <script src="https://unpkg.com/aos@2.3.4/dist/aos.js"></script>
    <script>
        AOS.init();
    </script>
</body>
</html>
