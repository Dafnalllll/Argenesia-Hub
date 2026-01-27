@section('title', 'Riwayat Cuti || Argenesia Hub')

<div class="p-6">
    <h1 class="text-2xl font-bold mb-6 text-white tracking-wide">Riwayat Cuti</h1>
    <div class="w-287.5 max-w-8xl mx-auto bg-white/70 backdrop-blur-2xl rounded-3xl shadow-2xl p-8 mt-12 border border-white/40 overflow-x-auto">
        <div class="flex flex-col md:flex-row md:justify-between md:items-center mb-6 gap-4">
            <div class="flex flex-col md:flex-row gap-6 w-full md:w-auto">
                <!-- Filter Kategori -->
                <div x-data="{ open: false }" class="relative group w-full md:w-48">
                    <img src="{{ asset('img/filter/tipe.webp') }}"
                        alt="Kategori"
                        class="absolute left-3 top-2.5 w-5 h-5 opacity-80 pointer-events-none transition-all duration-300 origin-center z-10
                                group-hover:scale-110 group-focus-within:scale-110
                                group-hover:drop-shadow-[0_0_6px_#0074D9] group-focus-within:drop-shadow-[0_0_6px_#0074D9]
                                group-hover:saturate-200 group-focus-within:saturate-200"
                    />
                    <button
                        @click="open = !open"
                        @click.away="open = false"
                        type="button"
                        class="appearance-none pl-10 pr-6 py-2 rounded-lg border border-gray-300 bg-transparent font-semibold text-base text-gray-700 shadow w-full flex items-center justify-between focus:outline-none focus:ring-2 focus:ring-blue-400 transition-all duration-300 hover:scale-105 hover:border-blue-400 hover:shadow-lg relative z-20 cursor-pointer"
                    >
                        <span>
                            @if($filterKategori)
                                <span class="text-blue-700 font-semibold">{{ $filterKategori }}</span>
                            @else
                                <span class="text-gray-700 font-semibold">Semua Tipe</span>
                            @endif
                        </span>
                        <span
                            :class="open ? 'rotate-180' : ''"
                            class="pointer-events-none absolute right-3 top-3 text-gray-400 transition-transform duration-300 group-hover:scale-125 group-focus-within:scale-125 group-hover:text-blue-500 group-focus-within:text-blue-500 z-20"
                        >
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path d="M19 9l-7 7-7-7"/>
                            </svg>
                        </span>
                    </button>
                    <div x-show="open" x-transition class="absolute z-30 mt-2 w-full bg-white rounded-lg shadow-lg border border-gray-200">
                        <ul>
                            <li>
                                <button wire:click="$set('filterKategori', '')" @click="open = false"
                                    class="cursor-pointer flex items-center w-full px-4 py-2 hover:bg-blue-50 rounded-lg transition text-gray-700 font-semibold">
                                    <span class="mr-2">📂</span> Semua Tipe
                                </button>
                            </li>
                            @foreach($tipe_cutis as $kategori)
                            <li>
                                <button wire:click="$set('filterKategori', '{{ $kategori }}')" @click="open = false"
                                    class="cursor-pointer flex items-center w-full px-4 py-2 hover:bg-blue-50 rounded-lg transition text-blue-700 font-semibold">
                                    <span class="mr-2">📂</span> {{ $kategori }}
                                </button>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                <!-- Filter Status Custom Dropdown -->
                    <div x-data="{ open: false }" class="relative group w-full md:w-48">
                        <img src="{{ asset('img/filter/status.webp') }}"
                            alt="Status"
                            class="absolute left-2 top-2 w-4 h-4 opacity-80 pointer-events-none transition-all duration-300 origin-center z-10"
                        />
                        <button
                            @click="open = !open"
                            @click.away="open = false"
                            type="button"
                            class="appearance-none pl-8 pr-4 py-1.5 rounded-md border border-gray-300 bg-transparent font-semibold text-xl text-gray-700 shadow w-full flex items-center justify-between focus:outline-none focus:ring-2 focus:ring-blue-400 transition-all duration-300 hover:scale-105 hover:border-blue-400 hover:shadow-lg relative z-20 cursor-pointer"
                            style="min-height: 36px;"
                        >
                            <span>
                                @if($filterStatus === 'disetujui')
                                    <span class="text-green-700 font-semibold flex items-center gap-1 text-base">
                                        ✅ Disetujui
                                    </span>
                                @elseif($filterStatus === 'ditolak')
                                    <span class="text-red-700 font-semibold flex items-center gap-1 text-base">
                                        ❌ Ditolak
                                    </span>
                                @elseif($filterStatus === 'menunggu')
                                    <span class="text-yellow-700 font-semibold flex items-center gap-1 text-base">
                                        ⏳ Menunggu
                                    </span>
                                @else
                                    <span class="text-gray-700 font-semibold flex items-center gap-1 text-base">
                                        Semua Status
                                    </span>
                                @endif
                            </span>
                            <span
                                :class="open ? 'rotate-180' : ''"
                                class="pointer-events-none absolute right-2 top-3 text-gray-400 transition-transform duration-300 z-20"
                            >
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path d="M19 9l-7 7-7-7"/>
                                </svg>
                            </span>
                        </button>
                        <div x-show="open" x-transition class="absolute z-30 mt-2 w-full bg-white rounded-md shadow-lg border border-gray-200 text-sm">
                            <ul>
                                <li>
                                    <button wire:click="$set('filterStatus', '')" @click="open = false"
                                        class="cursor-pointer flex items-center w-full px-3 py-2 hover:bg-blue-50 rounded transition text-gray-700 font-semibold text-sm">
                                        <span class="mr-2">👥</span> Semua Status
                                    </button>
                                </li>
                                <li>
                                    <button wire:click="$set('filterStatus', 'disetujui')" @click="open = false"
                                        class="cursor-pointer flex items-center w-full px-3 py-2 hover:bg-green-50 rounded transition text-green-700 font-semibold text-sm">
                                        <span class="mr-2">✅</span> Disetujui
                                    </button>
                                </li>
                                <li>
                                    <button wire:click="$set('filterStatus', 'ditolak')" @click="open = false"
                                        class="cursor-pointer flex items-center w-full px-3 py-2 hover:bg-red-50 rounded transition text-red-700 font-semibold text-sm">
                                        <span class="mr-2">❌</span> Ditolak
                                    </button>
                                </li>
                                <li>
                                    <button wire:click="$set('filterStatus', 'menunggu')" @click="open = false"
                                        class="cursor-pointer flex items-center w-full px-3 py-2 hover:bg-yellow-50 rounded transition text-yellow-700 font-semibold text-sm">
                                        <span class="mr-2">⏳</span> Menunggu
                                    </button>
                                </li>
                            </ul>
                        </div>
                    </div>
            </div>
            <!-- Reset Filters Button -->
            <div class="shrink-0">
                <button
                    wire:click="resetFilter"
                    class="flex items-center gap-2 px-4 py-2 rounded-lg bg-gray-100 text-gray-700 font-semibold shadow-md transition-all duration-300 hover:bg-gray-200 cursor-pointer hover:scale-105 hover:shadow-lg"
                >
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M4 6h16M4 12h16m-7 6h7" stroke="currentColor" stroke-width="2" fill="none"/>
                    </svg>
                    Reset
                </button>
            </div>
        </div>
        <div class="overflow-x-auto rounded-2xl shadow">
            <table class="min-w-full text-sm text-left">
                <thead class="bg-linear-to-r from-[#0074D9]/80 to-[#F53003]/80 text-white uppercase">
                    <tr>
                        <th class="px-4 py-3">No</th>
                        <th class="px-4 py-3">Tanggal Pengajuan</th>
                        <th class="px-4 py-3">Tipe</th>
                        <th class="px-4 py-3">Tanggal Mulai</th>
                        <th class="px-4 py-3">Tanggal Selesai</th>
                        <th class="px-4 py-3">Status</th>
                        <th class="px-4 py-3">Keterangan</th>
                        <th class="px-4 py-3">File</th> <!-- Tambahkan ini -->
                    </tr>
                </thead>
                <tbody>
                    @forelse($riwayatCuti as $i => $cuti)
                    <tr class="odd:bg-white even:bg-[#f8fafc] hover:bg-[#e0f7fa]/60 transition">
                        <td class="px-4 py-3">{{ $i + 1 }}</td>
                        <td class="px-4 py-3">{{ $cuti->created_at->format('d M Y') }}</td>
                        <td class="px-4 py-3 capitalize">
                        {{ $cuti->tipeCuti?->nama_cuti ?? '-' }}
                    </td>
                        <td class="px-4 py-3">{{ $cuti->tanggal_mulai }}</td>
                        <td class="px-4 py-3">{{ $cuti->tanggal_selesai }}</td>
                        <td class="px-4 py-3">
                            @if($cuti->status == 'disetujui')
                                <span class="px-3 py-1 rounded-full bg-green-100 text-green-700 font-bold">Disetujui</span>
                            @elseif($cuti->status == 'ditolak')
                                <span class="px-3 py-1 rounded-full bg-red-100 text-red-700 font-bold">Ditolak</span>
                            @else
                                <span class="px-3 py-1 rounded-full bg-yellow-100 text-yellow-700 font-bold">Menunggu</span>
                            @endif
                        </td>
                        <td class="px-4 py-3">{{ $cuti->keterangan }}</td>
                        <td class="px-4 py-3 text-center">
                            @if($cuti->file_pengajuan)
                                <a href="{{ asset('storage/' . $cuti->file_pengajuan) }}" target="_blank"
                                    class="inline-flex items-center justify-center "
                                    title="Lihat File">
                                    <img src="{{ asset('img/action/file.webp') }}" alt="File" class="w-6 h-6 hover:scale-110 transition-all" />
                                </a>
                            @else
                                <span class="text-gray-300 flex items-center justify-center">
                                    <img src="{{ asset('img/action/file.webp') }}" alt="File" class="w-6 h-6 opacity-30" />
                                </span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center py-8 text-gray-400">Tidak ada data cuti.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
