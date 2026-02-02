{{-- filepath: resources/views/livewire/Karyawan/dashboard/cuti/pengajuan.blade.php --}}
@section('title', 'Pengajuan Cuti || Argenesia Hub')

<div class="relative w-full max-w-sm md:max-w-5xl mx-auto bg-white/60 backdrop-blur-2xl rounded-3xl shadow-2xl
    p-4 pt-8 pb-10 mt-24 mb-8 border border-white/40 overflow-hidden
    md:p-10 md:pt-10 md:mt-16 md:mb-16 md:px-16">

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
            <button @click="show = false" class="mt-3 px-4 py-2 bg-red-500 text-white rounded-lg font-semibold hover:bg-red-600 hover:scale-105 cursor-pointer transition-all">Tutup</button>
        </div>
    </div>
    <!-- Decorative Gradient Blobs -->
    <div class="absolute -top-20 -left-20 w-60 h-60 bg-linear-to-br from-[#0074D9]/30 to-[#F53003]/20 rounded-full blur-2xl opacity-60 z-0"></div>
    <div class="absolute -bottom-24 -right-24 w-72 h-72 bg-linear-to-tr from-[#F53003]/30 to-[#0074D9]/20 rounded-full blur-2xl opacity-60 z-0"></div>
    <div class="relative z-10">
        <div class="flex  items-center gap-4 mb-10 justify-center md:justify-start">
            <img src="{{ asset('img/cuti/pengajuan.webp') }}" alt="Pengajuan" class="w-12 h-12 drop-shadow" />
            <h2 class="text-2xl md:text-3xl font-extrabold bg-linear-to-r from-[#0074D9] to-[#F53003] bg-clip-text text-transparent drop-shadow tracking-wide uppercase text-center md:text-left">
                Pengajuan Cuti
            </h2>
        </div>

        {{-- Tampilkan error validasi backend --}}
        @if ($errors->any())
            <div class="mb-4 px-4 py-3 rounded bg-red-100 text-red-800 font-semibold">
                <ul class="list-disc pl-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        @if (session()->has('error'))
            <div class="mb-4 px-4 py-3 rounded bg-red-100 text-red-800 font-semibold">
                {{ session('error') }}
            </div>
        @endif
        @if (session()->has('success'))
            <div class="mb-4 px-4 py-3 rounded bg-green-100 text-green-800 font-semibold">
                {{ session('success') }}
            </div>
        @endif

        <form
            x-data="{
                tipeCutis: {{ Js::from($tipeCutis->map(fn($t) => ['id' => $t->id, 'nama' => $t->nama_cuti, 'maksimal_hari' => $t->maksimal_hari])) }},
                tipe_cuti_id: @entangle('tipe_cuti_id'),
                tanggal_mulai: @entangle('tanggal_mulai'),
                tanggal_selesai: @entangle('tanggal_selesai'),
                keterangan: @entangle('keterangan'),
                fileName: '',
                open: false,
                hitungTanggalSelesai() {
                    let tipe = this.tipeCutis.find(t => t.id == this.tipe_cuti_id);
                    if (tipe && this.tanggal_mulai) {
                        let tgl = new Date(this.tanggal_mulai);
                        tgl.setDate(tgl.getDate() + (parseInt(tipe.maksimal_hari) - 1));
                        this.tanggal_selesai = tgl.toISOString().slice(0, 10);
                    } else {
                        this.tanggal_selesai = '';
                    }
                },
                clearFile() {
                    this.$refs.fileInput.value = '';
                    this.fileName = '';
                    $wire.set('file_upload', null);
                }
            }"
            @change="hitungTanggalSelesai()"
            @reset-cuti-form.window="
                tipe_cuti_id = null;
                tanggal_mulai = '';
                tanggal_selesai = '';
                fileName = '';
                keterangan = '';
                if ($refs.fileInput) $refs.fileInput.value = '';
            "
            @submit.prevent="
                if (!tipe_cuti_id) {
                    Swal.fire({icon:'warning', title:'Tipe Cuti wajib dipilih!', confirmButtonColor:'#0074D9'});
                    return false;
                }
                if (!tanggal_mulai) {
                    Swal.fire({icon:'warning', title:'Tanggal Mulai wajib diisi!', confirmButtonColor:'#0074D9'});
                    return false;
                }
                if (!keterangan) {
                    Swal.fire({icon:'warning', title:'Keterangan wajib diisi!', confirmButtonColor:'#0074D9'});
                    return false;
                }
                if (!$refs.fileInput.value) {
                    Swal.fire({icon:'warning', title:'File wajib diupload!', confirmButtonColor:'#0074D9'});
                    return false;
                }
                $wire.simpan();
            "
            class="space-y-6 md:space-y-8"
            novalidate
        >
            <!-- Tipe Cuti -->
            <div class="relative w-full">
                <label class="flex items-center gap-2 font-bold text-lg text-[#0074D9] mb-2">
                    <img src="{{ asset('img/cuti/kategori.webp') }}" alt="Kategori" class="w-6 h-6" />
                    Tipe Cuti
                </label>
                <button type="button"
                    @click="open = !open"
                    class="w-full px-4 py-3 rounded-xl border-2 border-[#0074D9]/30 bg-white/90 text-gray-700 font-semibold flex justify-between items-center transition-all duration-300 focus:border-[#F53003] focus:bg-[#fff7f3] focus:shadow-xl focus:scale-105 hover:shadow-lg hover:scale-105 cursor-pointer"
                >
                    <span x-text="tipeCutis.find(o => o.id == tipe_cuti_id)?.nama || 'Pilih Jenis Cuti'"></span>
                    <svg :class="{'rotate-180': open}" class="w-6 h-6 text-[#0074D9] transition-transform duration-300" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
                    </svg>
                </button>
                <ul x-show="open" @click.away="open = false" x-transition
                    class="absolute z-20 w-full mt-2 bg-white rounded-xl shadow-lg border border-[#0074D9]/30 overflow-hidden">
                    <template x-for="option in tipeCutis" :key="option.id">
                        <li @click="tipe_cuti_id = option.id; open = false; hitungTanggalSelesai()"
                            :class="{
                                'bg-[#0074D9] text-white': tipe_cuti_id == option.id,
                                'hover:bg-[#F53003]/10 text-[#0074D9]': tipe_cuti_id != option.id
                            }"
                            class="px-4 py-2 cursor-pointer font-semibold transition-all"
                        >
                            <span x-text="option.nama"></span>
                        </li>
                    </template>
                </ul>
                <!-- Hidden input untuk Livewire -->
                <input type="hidden" name="tipe_cuti_id" :value="tipe_cuti_id" wire:model.defer="tipe_cuti_id">
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 md:gap-6">
                <!-- Tanggal Mulai -->
                <div class="relative group mb-6">
                    <label class="flex items-center gap-2 font-bold text-base text-[#0074D9] mb-2 transition-all duration-300 group-focus-within:text-[#F53003]">
                        <img src="{{ asset('img/cuti/tanggal.webp') }}"
                            alt="Tanggal"
                            class="w-5 h-5 inline-block mr-1 -mt-1 opacity-70 group-focus-within:opacity-100 group-focus-within:scale-110 transition-all duration-300" />
                        Tanggal Mulai
                    </label>
                    <input type="date" x-model="tanggal_mulai" @change="hitungTanggalSelesai()"
                        class="w-full px-4 py-3 rounded-xl border-2 border-[#0074D9]/30 bg-white/90 text-gray-700 font-semibold cursor-pointer
                        transition-all duration-300
                        focus:border-[#F53003] focus:scale-105 focus:shadow-xl
                        hover:border-[#F53003] hover:shadow-md"
                        placeholder=" ">
                    <input type="hidden" name="tanggal_mulai" :value="tanggal_mulai" wire:model.defer="tanggal_mulai">
                </div>
                <!-- Tanggal Selesai (readonly) -->
                <div class="relative group mb-6">
                    <label class="flex items-center gap-2 font-bold text-base text-[#0074D9] mb-2 transition-all duration-300 group-focus-within:text-[#F53003]">
                        <img src="{{ asset('img/cuti/tanggal.webp') }}"
                            alt="Tanggal"
                            class="w-5 h-5 inline-block mr-1 -mt-1 opacity-70 group-focus-within:opacity-100 group-focus-within:scale-110 transition-all duration-300" />
                        Tanggal Selesai
                    </label>
                    <input type="date" x-model="tanggal_selesai" readonly
                        class="w-full px-4 py-3 rounded-xl border-2 border-[#0074D9]/30 bg-white/90 text-gray-700 font-semibold cursor-pointer
                        transition-all duration-300
                        focus:border-[#F53003] focus:scale-105 focus:shadow-xl
                        hover:border-[#F53003] hover:shadow-md"
                        placeholder=" ">
                    <input type="hidden" name="tanggal_selesai" :value="tanggal_selesai" wire:model.defer="tanggal_selesai">
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
                <textarea x-model="keterangan" wire:model="keterangan" name="keterangan" rows="3"
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
                </label>
                <div class="relative flex items-center ">
                    <input type="file"
                        x-ref="fileInput"
                        wire:model="file_upload"
                        accept="application/pdf"
                        class="hidden"
                        @change="fileName = $refs.fileInput.files.length ? $refs.fileInput.files[0].name : ''"
                    >
                    <button type="button"
                        @click="$refs.fileInput.click()"
                        class="w-full px-4 py-3 rounded-xl border-2 bg-white/90 text-gray-700 font-semibold pr-12 text-left cursor-pointer
                            transition-all duration-300
                            focus:border-[#F53003] focus:scale-105 focus:shadow-xl
                            hover:border-[#F53003] hover:shadow-md
                            {{ $errors->has('file_upload') ? 'border-[#F53003]' : 'border-[#0074D9]/30' }}">
                        <span x-show="fileName" x-text="fileName" class="wrap-break-words whitespace-normal block"></span>
                        <span x-show="!fileName" class="text-gray-400">Belum ada file dipilih</span>
                    </button>
                    <button type="button"
                        x-show="fileName"
                        @click="clearFile()"
                        class="absolute right-12 top-1/2 -translate-y-1/2 text-red-500 hover:text-red-700 cursor-pointer"
                        title="Hapus File">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
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
            <div class="flex flex-col md:flex-row gap-3 justify-center md:justify-end">
                <button type="button"
                    wire:click="resetForm"
                    @click="window.dispatchEvent(new CustomEvent('reset-cuti-form'))"
                    class="bg-gray-200 text-gray-700 px-8 py-3 rounded-xl font-bold shadow hover:bg-gray-300 hover:scale-105 transition-all duration-200 text-lg tracking-wide flex items-center justify-center gap-2 cursor-pointer">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                    Reset
                </button>
                <a href="{{ route('cuti.download-template') }}"
                    class="inline-flex items-center justify-center gap-2 px-6 py-3 rounded-xl bg-[#0074D9] text-white font-bold shadow hover:bg-[#005fa3] transition-all hover:scale-105 duration-200 cursor-pointer">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 16v2a2 2 0 002 2h12a2 2 0 002-2v-2M7 10l5 5 5-5M12 4v12"/>
                    </svg>
                    Download Template Surat Cuti
                </a>
                <button type="submit"
                    class="bg-linear-to-r from-[#0074D9] to-[#F53003] text-white px-10 py-3 rounded-xl font-bold shadow-lg hover:scale-105 hover:shadow-2xl transition-all duration-200 text-lg tracking-wide flex items-center justify-center gap-2 cursor-pointer">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
                    </svg>
                    Ajukan Cuti
                </button>
            </div>
        </form>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

{{-- Tampilkan error backend dengan SweetAlert2 --}}
@if ($errors->any())
<script>
    Swal.fire({
        icon: 'error',
        title: 'Gagal!',
        html: `{!! implode('<br>', $errors->all()) !!}`,
        confirmButtonColor: '#F53003'
    });
</script>
@endif
@if (session('error'))
<script>
    Swal.fire({
        icon: 'error',
        title: 'Gagal!',
        text: '{{ session('error') }}',
        confirmButtonColor: '#F53003'
    });
</script>
@endif
