<!-- Modal Nonaktif -->
<div x-show="showNotif" x-transition.opacity.duration.300ms class="fixed inset-0 z-50 flex items-center justify-center bg-black/40">
    <div x-transition.scale.duration.300ms class="bg-linear-to-r from-[#F53003] to-[#0074D9] rounded-2xl p-7 w-80 max-w-full text-center relative">
        <!-- Icon Notif Nonaktif -->
        <div class="flex justify-center mb-3">
            <div class="bg-blue-100 rounded-full p-3 shadow animate-pulse">
                <img src="{{ asset('img/notif.webp') }}" alt="Notif" class="w-8 h-8" />
            </div>
        </div>
        <h2 class="text-xl font-extrabold mb-2 text-white tracking-wide">Anda Belum Aktif !</h2>
        <p class="mb-5 text-gray-900">Isi Data Lebih Lengkap di Profil dan Tunggu Admin Untuk Mengaktifkan Status Anda.</p>
        <a href="{{ route('profil') }}"
            class="inline-block px-5 py-2 rounded-lg bg-linear-to-r from-blue-500 to-blue-700 text-white font-bold shadow hover:from-blue-600 hover:to-blue-800 transition-all hover:scale-105 mb-2">
            Profil
        </a>
        <button @click="showNotif = false"
            class="absolute top-2 right-2 text-gray-400 hover:text-red-500 text-2xl font-bold transition cursor-pointer"
            aria-label="Tutup">&times;</button>
    </div>
</div>

<!-- Modal Aktif -->
<div x-show="showNotifAktif" x-transition.opacity.duration.300ms class="fixed inset-0 z-50 flex items-center justify-center bg-black/40">
    <div x-transition.scale.duration.300ms class="bg-linear-to-r from-green-400 to-blue-500 rounded-2xl p-7 w-80 max-w-full text-center relative">
        <!-- Icon Notif Aktif -->
        <div class="flex justify-center mb-3">
            <div class="bg-green-100 rounded-full p-3 shadow animate-pulse">
                <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                </svg>
            </div>
        </div>
        <h2 class="text-xl font-extrabold mb-2 text-white tracking-wide">Anda Sudah Aktif !</h2>
        <p class="mb-5 text-white">Selamat, Data Profil Anda Sudah Lengkap dan Status Anda Sekarang Aktif.</p>
        <button @click="showNotifAktif = false"
            class="absolute top-2 right-2 text-gray-200 hover:text-red-500 text-2xl font-bold transition cursor-pointer"
            aria-label="Tutup">&times;</button>
    </div>
</div>
