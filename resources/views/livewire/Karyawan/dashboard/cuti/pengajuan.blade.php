@extends('components.layouts.app')

@section('title', 'Pengajuan Cuti || Argenesia Hub')

@section('content')
<div class="relative w-full max-w-5xl mx-auto bg-white/60 backdrop-blur-2xl rounded-3xl shadow-2xl p-10 mt-16 border border-white/40 overflow-hidden px-4 md:px-12">
    <!-- Decorative Gradient Blobs -->
    <div class="absolute -top-20 -left-20 w-60 h-60 bg-gradient-to-br from-[#0074D9]/30 to-[#F53003]/20 rounded-full blur-2xl opacity-60 z-0"></div>
    <div class="absolute -bottom-24 -right-24 w-72 h-72 bg-gradient-to-tr from-[#F53003]/30 to-[#0074D9]/20 rounded-full blur-2xl opacity-60 z-0"></div>
    <div class="relative z-10">
        <div class="flex items-center gap-4 mb-10">
            <img src="{{ asset('img/cuti/pengajuan.webp') }}" alt="Pengajuan" class="w-12 h-12 drop-shadow" />
            <h2 class="text-3xl font-extrabold bg-gradient-to-r from-[#0074D9] to-[#F53003] bg-clip-text text-transparent drop-shadow tracking-wide uppercase">
                Pengajuan Cuti
            </h2>
        </div>
        <form method="POST" action="#" class="space-y-8">
            @csrf
            <!-- Jenis Cuti -->
            <div class="relative md:w-1/2 mb-6 group">
                <label class="flex items-center gap-2 font-bold text-lg text-[#0074D9] mb-2 transition-all duration-300 group-focus-within:text-[#F53003]">
                    <img src="{{ asset('img/cuti/kategori.webp') }}" alt="Kategori" class="w-6 h-6 transition-transform duration-300 group-hover:rotate-12 group-focus-within:rotate-45" />
                    Jenis Cuti
                </label>
            <div class="relative">
                <select name="jenis_cuti" required
                    class="w-full px-4 py-3 rounded-xl border-2 border-[#0074D9]/30 bg-white/90 text-gray-700 font-semibold appearance-none
                    transition-all duration-300 ease-in-out
                    focus:border-[#F53003] focus:bg-[#fff7f3] focus:shadow-xl focus:scale-105
                    hover:shadow-lg hover:scale-105 pr-12">
                    <option value="" disabled selected hidden>Pilih Jenis Cuti</option>
                    <option value="tahunan">Tahunan</option>
                    <option value="sakit">Sakit</option>
                    <option value="izin">Izin</option>
                    <option value="lainnya">Lainnya</option>
                </select>
                <!-- Panah Dropdown -->
                <div class="pointer-events-none absolute inset-y-0 right-4 flex items-center">
                    <svg class="w-6 h-6 text-[#0074D9] transition-transform duration-300 group-focus-within:rotate-180" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
                    </svg>
                </div>
            </div>
        </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Tanggal Mulai -->
            <div class="relative group mb-6">
                <label class="flex items-center gap-2 font-bold text-base text-[#0074D9] mb-2 transition-all duration-300 group-focus-within:text-[#F53003]">
                    <img src="{{ asset('img/cuti/tanggal.webp') }}"
                        alt="Tanggal"
                        class="w-5 h-5 inline-block mr-1 -mt-1 opacity-70 group-focus-within:opacity-100 group-focus-within:scale-110 transition-all duration-300" />
                    Tanggal Selesai
                </label>
                <input type="date" name="tanggal_selesai" required
                    class="w-full px-4 py-3 rounded-xl border-2 border-[#0074D9]/30 bg-white/90 text-gray-700 font-semibold
                    transition-all duration-300
                    focus:border-[#F53003] focus:scale-105 focus:shadow-xl
                    hover:border-[#F53003] hover:shadow-md"
                    placeholder=" ">
            </div>
            <!-- Tanggal Selesai -->
            <div class="relative group mb-6">
                <label class="flex items-center gap-2 font-bold text-base text-[#0074D9] mb-2 transition-all duration-300 group-focus-within:text-[#F53003]">
                    <img src="{{ asset('img/cuti/tanggal.webp') }}"
                        alt="Tanggal"
                        class="w-5 h-5 inline-block mr-1 -mt-1 opacity-70 group-focus-within:opacity-100 group-focus-within:scale-110 transition-all duration-300" />
                    Tanggal Selesai
                </label>
                <input type="date" name="tanggal_selesai" required
                    class="w-full px-4 py-3 rounded-xl border-2 border-[#0074D9]/30 bg-white/90 text-gray-700 font-semibold
                    transition-all duration-300
                    focus:border-[#F53003] focus:scale-105 focus:shadow-xl
                    hover:border-[#F53003] hover:shadow-md"
                    placeholder=" ">
            </div>
        </div>
            <!-- Keterangan -->
            <div class="relative group mb-6">
                <label class="flex items-center gap-2 font-bold text-base text-[#0074D9] mb-2 transition-all duration-300 group-focus-within:text-[#F53003]">
                    <img src="{{ asset('img/cuti/alasan.webp') }}"
                        alt="Alasan"
                        class="w-5 h-5 inline-block mr-1 -mt-1 opacity-70 group-focus-within:opacity-100 group-focus-within:rotate-12 group-focus-within:scale-110 transition-all duration-300" />
                    Keterangan
                </label>
                <textarea name="keterangan" rows="3" required
                    class="w-full px-4 py-3 rounded-xl border-2 border-[#0074D9]/30 bg-white/90 text-gray-700 font-semibold resize-none
                    transition-all duration-300
                    focus:border-[#F53003] focus:scale-105 focus:shadow-xl
                    hover:border-[#F53003] hover:shadow-md"
                    placeholder=" "></textarea>
            </div>
            <div class="flex justify-end">
                <button type="submit" class="bg-gradient-to-r from-[#0074D9] to-[#F53003] text-white px-10 py-3 rounded-xl font-bold shadow-lg hover:scale-105 hover:shadow-2xl transition-all duration-200 text-lg tracking-wide flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
                    </svg>
                    Ajukan Cuti
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
