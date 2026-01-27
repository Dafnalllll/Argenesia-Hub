@section('title', 'Pengajuan Cuti || Argenesia Hub')

<div class="relative w-full max-w-5xl mx-auto bg-white/60 backdrop-blur-2xl rounded-3xl shadow-2xl p-10 mt-16 mb-16 pb-10 border border-white/40 overflow-hidden px-4 md:px-16">
        <!-- Modal Notif Nonaktif -->
    <div
        x-data="{ show: false }"
        x-show="show"
        x-on:cuti-nonaktif.window="show = true; setTimeout(() => show = false, 3000)"
        style="display: none;"
        class="fixed inset-0 flex items-center justify-center z-50"
    >
        <div class="bg-white border border-red-400 rounded-xl shadow-xl px-8 py-6 text-center">
            <div class="text-red-600 text-2xl font-bold mb-2">Pengajuan Gagal</div>
            <div class="text-gray-700 mb-2">Status karyawan Anda masih <b>Nonaktif</b>.<br>Silakan hubungi admin untuk aktivasi.</div>
            <button @click="show = false" class="mt-3 px-4 py-2 bg-red-500 text-white rounded-lg font-semibold hover:bg-red-600">Tutup</button>
        </div>
    </div>
    <!-- Decorative Gradient Blobs -->
    <div class="absolute -top-20 -left-20 w-60 h-60 bg-linear-to-br from-[#0074D9]/30 to-[#F53003]/20 rounded-full blur-2xl opacity-60 z-0"></div>
    <div class="absolute -bottom-24 -right-24 w-72 h-72 bg-linear-to-tr from-[#F53003]/30 to-[#0074D9]/20 rounded-full blur-2xl opacity-60 z-0"></div>
    <div class="relative z-10">
        <div class="flex items-center gap-4 mb-10">
            <img src="{{ asset('img/cuti/pengajuan.webp') }}" alt="Pengajuan" class="w-12 h-12 drop-shadow" />
            <h2 class="text-3xl font-extrabold bg-linear-to-r from-[#0074D9] to-[#F53003] bg-clip-text text-transparent drop-shadow tracking-wide uppercase">
                Pengajuan Cuti
            </h2>
        </div>
        @if (session()->has('success'))
            <div class="mb-4 px-4 py-3 rounded bg-green-100 text-green-800 font-semibold">
                {{ session('success') }}
            </div>
        @endif
        <form
            wire:submit.prevent="simpan"
            x-data="{
                tipeCutis: {{ Js::from($tipeCutis->map(fn($t) => ['id' => $t->id, 'maksimal_hari' => $t->maksimal_hari])) }},
                tipe_cuti_id: @entangle('tipe_cuti_id'),
                tanggal_mulai: @entangle('tanggal_mulai'),
                tanggal_selesai: @entangle('tanggal_selesai').defer,
                hitungTanggalSelesai() {
                    let tipe = this.tipeCutis.find(t => t.id == this.tipe_cuti_id);
                    if (tipe && this.tanggal_mulai) {
                        let tgl = new Date(this.tanggal_mulai);
                        tgl.setDate(tgl.getDate() + (parseInt(tipe.maksimal_hari) - 1));
                        this.tanggal_selesai = tgl.toISOString().slice(0, 10);
                    } else {
                        this.tanggal_selesai = '';
                    }
                }
            }"
            x-effect="hitungTanggalSelesai()"
            class="space-y-8"
        >
            <!-- Tipe Cuti -->
            <div class="relative md:w-1/2 mb-6 group">
                <label class="flex items-center gap-2 font-bold text-lg text-[#0074D9] mb-2 transition-all duration-300 group-focus-within:text-[#F53003]">
                    <img src="{{ asset('img/cuti/kategori.webp') }}" alt="Kategori" class="w-6 h-6 transition-transform duration-300 group-hover:rotate-12 group-focus-within:rotate-45" />
                    Tipe Cuti
                </label>
            <div class="relative">
                <select wire:model="tipe_cuti_id" x-model="tipe_cuti_id" required
                    class="w-full px-4 py-3 rounded-xl border-2 border-[#0074D9]/30 bg-white/90 text-gray-700 font-semibold appearance-none
                    transition-all duration-300 ease-in-out
                    focus:border-[#F53003] focus:bg-[#fff7f3] focus:shadow-xl focus:scale-105
                    hover:shadow-lg hover:scale-105 pr-12">
                    <option value="" disabled selected hidden>Pilih Jenis Cuti</option>
                    @foreach($tipeCutis as $tipe)
                        <option value="{{ $tipe->id }}">{{ $tipe->nama_cuti }}</option>
                    @endforeach
                </select>
                @if($maksimal_hari)
                    <div class="text-xs text-gray-500 mt-1">Maksimal hari: {{ $maksimal_hari }}</div>
                @endif
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
                    Tanggal Mulai
                </label>
                <input type="date" wire:model="tanggal_mulai" x-model="tanggal_mulai" required
                    class="w-full px-4 py-3 rounded-xl border-2 border-[#0074D9]/30 bg-white/90 text-gray-700 font-semibold
                    transition-all duration-300
                    focus:border-[#F53003] focus:scale-105 focus:shadow-xl
                    hover:border-[#F53003] hover:shadow-md"
                    placeholder=" ">
            </div>
            <!-- Tanggal Selesai (readonly) -->
            <div class="relative group mb-6">
                <label class="flex items-center gap-2 font-bold text-base text-[#0074D9] mb-2 transition-all duration-300 group-focus-within:text-[#F53003]">
                    <img src="{{ asset('img/cuti/tanggal.webp') }}"
                        alt="Tanggal"
                        class="w-5 h-5 inline-block mr-1 -mt-1 opacity-70 group-focus-within:opacity-100 group-focus-within:scale-110 transition-all duration-300" />
                    Tanggal Selesai
                </label>
                <input type="date" wire:model="tanggal_selesai" x-model="tanggal_selesai" readonly
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
                <textarea wire:model="keterangan" name="keterangan" rows="3" required
                    class="w-full px-4 py-3 rounded-xl border-2 border-[#0074D9]/30 bg-white/90 text-gray-700 font-semibold resize-none
                    transition-all duration-300
                    focus:border-[#F53003] focus:scale-105 focus:shadow-xl
                    hover:border-[#F53003] hover:shadow-md"
                    placeholder=" "></textarea>
            </div>
            <!-- Upload File PDF -->
            <div class="relative group mb-6">
                <label class="flex items-center gap-2 font-bold text-base mb-2
                    {{ $errors->has('file_upload') ? 'text-[#F53003]' : 'text-[#0074D9]' }}">
                    <img src="{{ asset('img/export/pdf.webp') }}"
                        alt="Upload"
                        class="w-5 h-5 inline-block mr-1 -mt-1 opacity-70" />
                    Upload File (PDF, maks 5 MB)
                    <span class="text-red-500 ml-2">*</span>
                </label>
                <div class="relative">
                    <input type="file"
                        wire:model="file_upload"
                        accept="application/pdf"
                        required
                        class="w-full px-4 py-3 rounded-xl border-2 bg-white/90 text-gray-700 font-semibold pr-12
                            transition-all duration-300
                            focus:border-[#F53003] focus:scale-105 focus:shadow-xl
                            hover:border-[#F53003] hover:shadow-md
                            {{ $errors->has('file_upload') ? 'border-[#F53003]' : 'border-[#0074D9]/30' }}"
                    >
                    <!-- Ikon upload di dalam input -->
                    <div class="pointer-events-none absolute inset-y-0 right-4 flex items-center">
                        <svg class="w-6 h-6 text-[#0074D9] opacity-70" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 16v2a2 2 0 002 2h12a2 2 0 002-2v-2M7 10l5 5 5-5M12 4v12"/>
                        </svg>
                    </div>
                </div>
                @error('file_upload')
                    <div class="text-red-600 text-xs mt-2">{{ $message }}</div>
                @enderror
            </div>
            <div class="flex justify-end gap-3">
                <button type="button"
                    wire:click="resetForm"
                    class="bg-gray-200 text-gray-700 px-8 py-3 rounded-xl font-bold shadow hover:bg-gray-300 hover:scale-105 transition-all duration-200 text-lg tracking-wide flex items-center gap-2 cursor-pointer">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                    Reset
                </button>
                    <a href="{{ route('cuti.download-template') }}"
                        class="inline-flex items-center gap-2 px-6 py-3 rounded-xl bg-[#0074D9] text-white font-bold shadow hover:bg-[#005fa3] transition-all hover:scale-105 duration-200 cursor-pointer">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 16v2a2 2 0 002 2h12a2 2 0 002-2v-2M7 10l5 5 5-5M12 4v12"/>
                        </svg>
                        Download Template Surat Cuti
                    </a>
                <button type="submit"
                    class="bg-linear-to-r from-[#0074D9] to-[#F53003] text-white px-10 py-3 rounded-xl font-bold shadow-lg hover:scale-105 hover:shadow-2xl transition-all duration-200 text-lg tracking-wide flex items-center gap-2 cursor-pointer">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
                    </svg>
                    Ajukan Cuti
                </button>
            </div>
        </form>
    </div>
</div>

