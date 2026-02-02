@section('title', 'Manajemen Cuti || Argenesia Hub')

<div>
    {{-- Mobile View --}}
    @include('livewire.HR.manajemen-cuti.manajemen-cuti-mobile')

    {{-- Desktop View --}}
    <div class="hidden md:block p-6">
        <h1 class="text-3xl font-bold mb-8 text-white tracking-wide animate-fade-in-down flex items-center gap-4">
            <img src="{{ asset('img/cuti/cuti.webp') }}" alt="Admin" class="w-10 h-10" />
            Manajemen Cuti
        </h1>
        <!-- Statistik Card -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div class="bg-white/40 backdrop-blur-md border border-white/30 rounded-2xl shadow-xl p-6 flex flex-col items-center hover:scale-105 transition-transform duration-300 cursor-pointer">
                <svg class="w-10 h-10 text-indigo-500 mb-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <rect x="6" y="4" width="12" height="16" rx="2" stroke="currentColor" stroke-width="2" fill="none"/>
                    <path d="M9 4V2h6v2" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
                <div class="text-3xl font-bold text-indigo-700 mb-1">{{ $totalPengajuan }}</div>
                <div class="text-base text-indigo-700 font-semibold">Total Pengajuan</div>
            </div>
            <div class="bg-white/40 backdrop-blur-md border border-white/30 rounded-2xl shadow-xl p-6 flex flex-col items-center hover:scale-105 transition-transform duration-300 cursor-pointer">
                <svg class="w-10 h-10 text-green-500 mb-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M5 13l4 4L19 7" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
                <div class="text-3xl font-bold text-green-700 mb-1">{{ $totalDisetujui }}</div>
                <div class="text-base text-green-700 font-semibold">Disetujui</div>
            </div>
            <div class="bg-white/40 backdrop-blur-md border border-white/30 rounded-2xl shadow-xl p-6 flex flex-col items-center hover:scale-105 transition-transform duration-300 cursor-pointer">
                <svg class="w-10 h-10 text-red-500 mb-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M6 18L18 6M6 6l12 12" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
                <div class="text-3xl font-bold text-red-700 mb-1">{{ $totalDitolak }}</div>
                <div class="text-base text-red-700 font-semibold">Ditolak</div>
            </div>
            <div class="bg-white/40 backdrop-blur-md border border-white/30 rounded-2xl shadow-xl p-6 flex flex-col items-center hover:scale-105 transition-transform duration-300 cursor-pointer">
                <svg class="w-10 h-10 text-yellow-500 mb-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="2" fill="none"/>
                    <path d="M12 6v6l4 2" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
                <div class="text-3xl font-bold text-yellow-700 mb-1">{{ $totalMenunggu }}</div>
                <div class="text-base text-yellow-700 font-semibold">Menunggu</div>
            </div>
        </div>
        <!-- Tabel Riwayat Pengajuan Cuti Singkat -->
        <div class="bg-white/40 backdrop-blur-md border border-white/30 rounded-2xl shadow-xl p-6">
            <h2 class="text-lg font-bold mb-4 text-gray-800">Riwayat Pengajuan Cuti Terbaru</h2>
            <div class="overflow-x-auto">
                <table class="min-w-275 w-full text-sm text-gray-700 rounded-2xl shadow-lg border-separate border-spacing-0">
                    <thead>
                        <tr class="bg-linear-to-r from-indigo-500 to-blue-500 text-white">
                            <th class="py-3 px-4 rounded-tl-2xl text-left">Nama</th>
                            <th class="py-3 px-4 text-center">Tanggal</th>
                            <th class="py-3 px-4 text-center">Tipe</th>
                            <th class="py-3 px-4 text-center">Status</th>
                            <th class="py-3 px-4 rounded-tr-2xl text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($pengajuanCuti as $item)
                            <tr class="hover:bg-blue-50 transition border-b border-blue-100">
                                <td class="py-3 px-4 font-medium">{{ $item->karyawan->user->name ?? '-' }}</td>
                                <td class="py-3 px-4 text-center">{{ \Carbon\Carbon::parse($item->tanggal_pengajuan)->format('Y-m-d') }}</td>
                                <td class="py-3 px-4 text-center">{{ $item->tipeCuti->nama_cuti ?? '-' }}</td>
                                <td class="py-3 px-4 text-center">
                                    @if($item->status === 'Disetujui')
                                        <span class="bg-green-100 text-green-700 px-2 py-1 rounded text-xs font-semibold">Disetujui</span>
                                    @elseif($item->status === 'Ditolak')
                                        <span class="bg-red-100 text-red-700 px-2 py-1 rounded text-xs font-semibold">Ditolak</span>
                                    @else
                                        <span class="bg-yellow-100 text-yellow-700 px-2 py-1 rounded text-xs font-semibold">Menunggu</span>
                                    @endif
                                </td>
                                <td class="py-3 px-4 text-center">
                                    <button wire:click="showDetail({{ $item->id }})" title="Detail" class="inline-flex items-center justify-center">
                                        <img src="{{ asset('img/action/detail.webp') }}" alt="Detail" class="w-6 h-6 hover:scale-110 transition-transform cursor-pointer" />
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="py-4 text-center text-gray-700">Tidak ada data cuti ditemukan.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="mt-6 flex justify-end">
                <a href="/hr/manajemen-cuti/rekap-cuti"
                    class="bg-indigo-500 text-white px-6 py-2 rounded-lg shadow hover:bg-indigo-600 transition font-semibold text-base flex items-center gap-2 group hover:scale-105 ">
                    <svg class="w-5 h-5 transition-transform duration-300 group-hover:translate-x-1 cursor-pointer" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M17 8l4 4m0 0l-4 4m4-4H3" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                Lihat Lebih Lengkap
            </a>
        </div>
    </div>

    {{-- Modal Detail Pengajuan Cuti --}}
    <div 
        x-data="{ show: @entangle('showDetailModal') }"
        x-show="show"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 scale-90"
        x-transition:enter-end="opacity-100 scale-100"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100 scale-100"
        x-transition:leave-end="opacity-0 scale-90"
        class="fixed inset-0 z-50 flex items-center justify-center bg-black/40"
        style="display: none;"
    >
        <div class="bg-linear-to-r from-[#F53003] to-[#0074D9] rounded-xl p-8 shadow-lg w-full max-w-md relative">
            <button @click="show = false; $wire.set('showDetailModal', false)" class="absolute top-2 right-2 text-gray-400 hover:text-red-500 text-2xl cursor-pointer">&times;</button>
            <h3 class="font-bold text-lg mb-4 text-white flex items-center gap-3">
                <img src="{{ asset('img/cuti/cuti.webp') }}" alt="Cuti" class="w-8 h-8" />
                Detail Pengajuan Cuti
            </h3>
            @if($selectedCuti)
                <div class="mb-2"><b>Nama:</b> <span>{{ $selectedCuti->karyawan->user->name ?? '-' }}</span></div>
                <div class="mb-2"><b>Tanggal Pengajuan:</b> <span>{{ \Carbon\Carbon::parse($selectedCuti->tanggal_pengajuan)->format('Y-m-d') }}</span></div>
                <div class="mb-2"><b>Tipe:</b> <span>{{ $selectedCuti->tipeCuti->nama_cuti ?? '-' }}</span></div>
                <div class="mb-2"><b>Status:</b> <span>{{ $selectedCuti->status }}</span></div>
                <div class="mb-2"><b>Tanggal Mulai:</b> <span>{{ \Carbon\Carbon::parse($selectedCuti->tanggal_mulai)->format('Y-m-d') }}</span></div>
                <div class="mb-2"><b>Tanggal Selesai:</b> <span>{{ \Carbon\Carbon::parse($selectedCuti->tanggal_selesai)->format('Y-m-d') }}</span></div>
                <div class="mb-2"><b>Keterangan:</b> <span>{{ $selectedCuti->keterangan }}</span></div>
                <div class="mb-2 flex items-center gap-2">
                    <b>File Pengajuan:</b>
                    @if($selectedCuti->file_pengajuan)
                        <a href="{{ asset('storage/' . $selectedCuti->file_pengajuan) }}" target="_blank"
                            class="inline-flex items-center px-3 py-1 rounded bg-indigo-500 text-white hover:bg-indigo-600 transition text-sm gap-2">
                            <img src="{{ asset('img/action/file.webp') }}" alt="File" class="w-5 h-5" />
                            Lihat File
                        </a>
                    @else
                        <span class="text-gray-700">Tidak ada file</span>
                    @endif
                </div>
            @else
                <div class="text-center text-white py-8">Data tidak ditemukan.</div>
            @endif
        </div>
    </div>
</div>
