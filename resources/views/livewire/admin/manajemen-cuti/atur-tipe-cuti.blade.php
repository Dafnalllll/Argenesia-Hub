@section('title', 'Atur Tipe Cuti || Argenesia Hub')

<div class="relative w-full max-w-5xl mx-auto bg-white/60 backdrop-blur-2xl rounded-3xl shadow-2xl p-10 mt-16 border border-white/40 overflow-hidden px-4 md:px-12">
    <div class="relative z-10">
        <div class="flex items-center gap-4 mb-10">
            <img src="{{ asset('img/cuti/pengajuan.webp') }}" alt="Atur Tipe Cuti" class="w-12 h-12 drop-shadow" />
            <h2 class="text-3xl font-extrabold bg-linear-to-r from-[#0074D9] to-[#F53003] bg-clip-text text-transparent drop-shadow tracking-wide uppercase">
                Atur Tipe Cuti
            </h2>
        </div>
        <!-- Notifikasi -->
        @if (session()->has('success'))
            <div class="mb-4 px-4 py-3 rounded bg-green-100 text-green-800 font-semibold">
                {{ session('success') }}
            </div>
        @endif
        <!-- Form tambah tipe cuti -->
        <form wire:submit.prevent="simpan" class="space-y-8">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="relative group mb-6">
                    <label class="flex items-center gap-2 font-bold text-lg text-[#0074D9] mb-2">
                        <img src="{{ asset('img/cuti/kategori.webp') }}" alt="Kategori" class="w-6 h-6" />
                        Nama Tipe Cuti
                    </label>
                    <input type="text" wire:model="nama_cuti" required
                        class="w-full px-4 py-3 rounded-xl border-2 border-[#0074D9]/30 bg-white/90 text-gray-700 font-semibold
                        transition-all duration-300
                        focus:border-[#F53003] outline-none focus:scale-105 focus:shadow-xl
                        hover:border-[#F53003] hover:shadow-md"
                        placeholder="Contoh: Cuti Tahunan">
                    @error('nama_cuti') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>
                <div class="relative group mb-6">
                    <label class="flex items-center gap-2 font-bold text-lg text-[#0074D9] mb-2">
                        <img src="{{ asset('img/cuti/tanggal.webp') }}" alt="Jumlah Hari" class="w-6 h-6" />
                        Jumlah Hari
                    </label>
                    <div class="flex items-center gap-2">
                        <input type="number" wire:model="maksimal_hari" required min="1"
                            class="w-full px-4 py-3 rounded-xl border-2 border-[#0074D9] focus:border-[#F53003] bg-white/90 text-gray-700 font-semibold text-lg text-center transition-all duration-300 outline-none  focus:scale-105 focus:shadow-xl
                        hover:border-[#F53003] hover:shadow-md"
                            placeholder="Contoh: 12">
                    </div>
                    @error('maksimal_hari') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>
            </div>
            <div class="flex justify-end gap-4">
                <button type="reset" wire:click="$set('nama_cuti', ''); $set('maksimal_hari', '');" class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-8 py-3 rounded-xl font-bold shadow transition-all duration-200 text-lg tracking-wide flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                    Reset
                </button>
                <button type="submit" class="bg-linear-to-r from-[#0074D9] to-[#F53003] text-white px-10 py-3 rounded-xl font-bold shadow-lg hover:scale-105 hover:shadow-2xl transition-all duration-200 text-lg tracking-wide flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                    </svg>
                    Simpan
                </button>
            </div>
        </form>
    </div>
</div>

