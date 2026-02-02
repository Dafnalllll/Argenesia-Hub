{{-- filepath: resources/views/livewire/HR/manajemen-cuti/pengajuan-cuti.blade.php --}}
@section('title', 'Pengajuan Cuti || Argenesia Hub')

<div class="p-6 md:p-6 mt-12"
    x-data="{
    search: '',
    filterStatus: '',
    filterTipe: '',
    cutis: @js($cutis),
    currentPage: 1,
    perPage: 10,
    get filteredCutis() {
        return this.cutis.filter(c => {
            let matchSearch = !this.search
                || (c.karyawan?.user?.name ?? '').toLowerCase().includes(this.search.toLowerCase())
                || (c.tipe_cuti?.nama_cuti ?? '').toLowerCase().includes(this.search.toLowerCase());
            let matchStatus = !this.filterStatus || c.status === this.filterStatus;
            let matchTipe = !this.filterTipe || (c.tipe_cuti?.nama_cuti === this.filterTipe);

            // Filter bulan & tahun dari created_at
            let date = new Date(c.created_at);


            return matchSearch && matchStatus && matchTipe;
        });
    },
    get paginatedCutis() {
        const start = (this.currentPage - 1) * this.perPage;
        return this.filteredCutis.slice(start, start + this.perPage);
    },
    get totalPages() {
        return Math.ceil(this.filteredCutis.length / this.perPage) || 1;
    },
    goToPage(page) {
        if (page < 1) page = 1;
        if (page > this.totalPages) page = this.totalPages;
        this.currentPage = page;
    }
}"
>

    {{-- ALERT SUCCESS --}}
        @if (session()->has('success'))
        <div
            x-data="{ show: true }"
            x-init="setTimeout(() => show = false, 2000)"
            x-show="show"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 -translate-y-2"
            x-transition:enter-end="opacity-100 translate-y-0"
            x-transition:leave="transition ease-in duration-300"
            x-transition:leave-start="opacity-100 translate-y-0"
            x-transition:leave-end="opacity-0 -translate-y-2"
            class="mb-4 flex items-center gap-2 px-4 py-2 rounded-lg bg-green-100 text-green-800 font-semibold shadow-lg"
            style="position: relative; z-index: 100;"
        >
            <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <circle cx="12" cy="12" r="10" class="text-green-200" fill="currentColor"/>
                <path d="M9 12l2 2l4 -4" stroke="green" stroke-width="2" fill="none"/>
            </svg>
            {{ session('success') }}
        </div>
        @endif

    <h1 class="text-3xl font-bold mb-8 text-white tracking-wide flex items-center gap-4
        justify-center md:justify-start text-center md:text-left">
        <img src="{{ asset('img/cuti/pengajuan.webp') }}" alt="Cuti" class="w-10 h-10" />
        Pengajuan Cuti
    </h1>
    <div class="bg-white/40 backdrop-blur-md border border-white/30 rounded-2xl shadow-2xl p-8">
        <div class="flex flex-col gap-2 w-full md:w-auto mb-6">
            <!-- Baris 1: Search, Status, Tipe, Reset -->
            <div class="flex flex-col md:flex-row md:items-center gap-4">
                <!-- Search -->
                <div class="relative w-78 md:w-72 group">
                    <input
                        type="text"
                        x-model="search"
                        @input="currentPage = 1"
                        placeholder="Cari karyawan atau tipe cuti..."
                        class="pl-10 pr-10 py-2 rounded-lg border border-gray-800 focus:outline-none w-full shadow transition-all duration-300
                            group-hover:scale-105 group-focus-within:scale-105 group-hover:shadow-lg group-focus-within:shadow-lg group-hover:border-[#F53003]"
                    />
                    <!-- Ikon search -->
                    <span class="absolute left-3 top-2.5 text-gray-700 transition-all duration-300 group-hover:scale-110 group-focus-within:scale-110 group-hover:text-[#F53003] group-focus-within:text-[#F53003]">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><path d="M21 21l-4.35-4.35"/></svg>
                    </span>
                    <!-- Ikon silang/reset -->
                    <button
                        type="button"
                        x-show="search"
                        @click="search = ''"
                        class="absolute right-3 top-2.5 text-gray-800 hover:text-red-500 transition-all duration-200 cursor-pointer"
                        style="display: none;"
                        tabindex="-1"
                    >
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>
                <!-- Filter Status Custom Dropdown -->
                <div x-data="{ open: false }" class="relative group w-78 md:w-48">
                    <img src="{{ asset('img/filter/status.webp') }}"
                        alt="Status"
                        class="absolute left-3 top-2.5 w-5 h-5 opacity-80 pointer-events-none transition-all duration-300 origin-center z-10
                            group-hover:scale-110 group-focus-within:scale-110
                            group-hover:drop-shadow-[0_0_6px_#F53003] group-focus-within:drop-shadow-[0_0_6px_#F53003]
                            group-hover:saturate-200 group-focus-within:saturate-200"
                    />
                    <button
                        @click="open = !open"
                        @click.away="open = false"
                        type="button"
                        class="appearance-none pl-10 pr-6 py-2 rounded-lg border border-gray-300 bg-transparent font-semibold text-base text-gray-700 shadow w-full flex items-center justify-between focus:outline-none focus:ring-2 focus:ring-blue-400 transition-all duration-300 hover:scale-105 hover:border-blue-400 hover:shadow-lg relative z-20 cursor-pointer"
                    >
                        <span>
                            <template x-if="!filterStatus"><span class="text-gray-700 font-semibold">Semua Status</span></template>
                            <template x-if="filterStatus"><span x-text="filterStatus" class="font-semibold"></span></template>
                        </span>
                        <span
                            :class="open ? 'rotate-180' : ''"
                            class="pointer-events-none absolute right-3 top-3 text-gray-700 transition-transform duration-300 group-hover:scale-125 group-focus-within:scale-125 group-hover:text-blue-500 group-focus-within:text-blue-500 z-20"
                        >
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path d="M19 9l-7 7-7-7"/>
                            </svg>
                        </span>
                    </button>
                    <div x-show="open" x-transition class="absolute z-30 mt-2 w-full bg-white rounded-lg shadow-lg border border-gray-200">
                        <ul>
                            <li>
                                <button @click="filterStatus = ''; open = false"
                                    class="cursor-pointer flex items-center w-full px-4 py-2 hover:bg-blue-50 rounded-lg transition text-gray-700 font-semibold">
                                    <span class="mr-2">👥</span> Semua Status
                                </button>
                            </li>
                            <li>
                                <button @click="filterStatus = 'Menunggu'; open = false"
                                    class="cursor-pointer flex items-center w-full px-4 py-2 hover:bg-yellow-50 rounded-lg transition text-yellow-700 font-semibold">
                                    <span class="mr-2">⏳</span> Menunggu
                                </button>
                            </li>
                            <li>
                                <button @click="filterStatus = 'Disetujui'; open = false"
                                    class="cursor-pointer flex items-center w-full px-4 py-2 hover:bg-green-50 rounded-lg transition text-green-700 font-semibold">
                                    <span class="mr-2">✅</span> Disetujui
                                </button>
                            </li>
                            <li>
                                <button @click="filterStatus = 'Ditolak'; open = false"
                                    class="cursor-pointer flex items-center w-full px-4 py-2 hover:bg-red-50 rounded-lg transition text-red-700 font-semibold">
                                    <span class="mr-2">❌</span> Ditolak
                                </button>
                            </li>
                        </ul>
                    </div>
                </div>
                <!-- Filter Tipe Cuti Custom Dropdown -->
                <div x-data="{ open: false }" class="relative group w-78 md:w-48">
                    <img src="{{ asset('img/filter/tipe.webp') }}"
                        alt="Tipe"
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
                            <template x-if="!filterTipe"><span class="text-gray-700 font-semibold">Semua Tipe</span></template>
                            <template x-if="filterTipe"><span x-text="filterTipe" class="font-semibold"></span></template>
                        </span>
                        <span
                            :class="open ? 'rotate-180' : ''"
                            class="pointer-events-none absolute right-3 top-3 text-gray-700 transition-transform duration-300 group-hover:scale-125 group-focus-within:scale-125 group-hover:text-blue-500 group-focus-within:text-blue-500 z-20"
                        >
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path d="M19 9l-7 7-7-7"/>
                            </svg>
                        </span>
                    </button>
                    <div x-show="open" x-transition class="absolute z-30 mt-2 w-full bg-white rounded-lg shadow-lg border border-gray-200">
                        <ul>
                            <li>
                                <button @click="filterTipe = ''; open = false"
                                    class="cursor-pointer flex items-center w-full px-4 py-2 hover:bg-blue-50 rounded-lg transition text-gray-700 font-semibold">
                                    <span class="mr-2">📋</span> Semua Tipe
                                </button>
                            </li>
                            @foreach($tipeCutis as $tipe)
                            <li>
                                <button @click="filterTipe = '{{ $tipe->nama_cuti }}'; open = false"
                                    class="cursor-pointer flex items-center w-full px-4 py-2 hover:bg-blue-50 rounded-lg transition text-blue-700 font-semibold">
                                    <span class="mr-2">📄</span> {{ $tipe->nama_cuti }}
                                </button>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                <!-- Reset Filters Button -->
                <div class="w-full flex justify-start md:block md:pl-72 md:w-auto">
                    <button
                        @click="filterStatus = ''; filterTipe = ''; search = ''; currentPage = 1"
                        class="flex items-center gap-2 px-4 py-2 rounded-lg bg-gray-100 text-gray-700 font-semibold shadow-md transition-all duration-300 hover:bg-gray-200 cursor-pointer hover:scale-105 hover:shadow-lg"
                    >
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path d="M4 6h16M4 12h16m-7 6h7" stroke="currentColor" stroke-width="2" fill="none"/>
                        </svg>
                        Reset
                    </button>
                </div>
            </div>
        </div>
        <div class="overflow-x-auto w-75 md:w-full">
            <table class="min-w-275 w-full text-sm text-gray-700 rounded-2xl shadow-lg border-separate border-spacing-0">
                    <tr class="bg-linear-to-r from-[#F53003] to-[#0074D9] text-white sticky top-0 z-10">
                        <th class="py-4 px-6 rounded-tl-2xl text-left">No</th>
                        <th class="py-4 px-6 text-left">Nama Karyawan</th>
                        <th class="py-4 px-6 text-left">Tipe</th>
                        <th class="py-4 px-6 text-left">Tanggal Pengajuan</th>
                        <th class="py-4 px-6 text-left">Tanggal Mulai</th>
                        <th class="py-4 px-6 text-left">Tanggal Selesai</th>
                        <th class="py-4 px-6 text-left">Keterangan</th>
                        <th class="py-4 px-6 text-left">Status</th>
                        <th class="py-4 px-6 rounded-tr-2xl text-center">File</th>
                    </tr>
                </thead>
                <tbody>
                    <template x-for="(cuti, i) in paginatedCutis" :key="cuti.id">
                        <tr class="hover:bg-blue-50 transition border-b border-blue-100">
                            <td class="py-3 px-6 font-bold" x-text="(currentPage-1)*perPage + i + 1"></td>
                            <td class="py-3 px-6" x-text="cuti.karyawan?.user?.name ?? '-'"></td>
                            <td class="py-3 px-6" x-text="cuti.tipe_cuti?.nama_cuti ?? '-'"></td>
                            <td class="py-3 px-6" x-text="cuti.created_at.substring(0, 10)"></td>
                            <td class="py-3 px-6" x-text="cuti.tanggal_mulai"></td>
                            <td class="py-3 px-6" x-text="cuti.tanggal_selesai"></td>
                            <td class="py-3 px-6" x-text="cuti.keterangan"></td>
                            <td class="py-3 px-6">
                                <div x-data="{ open: false }" class="relative">
                                    <!-- Trigger Button -->
                                    <button
                                        @click="open = !open"
                                        @click.away="open = false"
                                        type="button"
                                        class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs font-semibold border-2 border-transparent shadow transition-all duration-200 cursor-pointer"
                                        :class="{
                                            'bg-green-100 text-green-700 border-green-400': cuti.status === 'Disetujui',
                                            'bg-yellow-100 text-yellow-700 border-yellow-400': cuti.status === 'Menunggu',
                                            'bg-red-100 text-red-700 border-red-400': cuti.status === 'Ditolak'
                                        }"
                                    >
                                        <span x-text="cuti.status"></span>
                                        <svg :class="open ? 'rotate-180' : ''" class="w-4 h-4 ml-1 transition-transform" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                            <path d="M19 9l-7 7-7-7"/>
                                        </svg>
                                    </button>
                                    <!-- Dropdown Menu -->
                                    <div
                                        x-show="open"
                                        x-transition
                                        class="absolute left-0 bottom-full -mb-9 w-32 rounded-xl shadow-lg border border-gray-200 z-10 bg-white overflow-visible"
                                    >
                                        <ul>
                                            <li>
                                                <button
                                                    @click="
                                                        $wire.changeStatus(cuti.id, 'Disetujui').then(res => {
                                                            if(res?.status) cuti.status = res.status;
                                                        });
                                                        open = false
                                                    "
                                                    class="flex items-center gap-2 w-full px-3 py-1.5 text-left text-xs font-bold cursor-pointer hover:bg-green-50 text-green-700 transition-all"
                                                >
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10" class="text-green-400" fill="currentColor"/><path d="M9 12l2 2l4 -4" stroke="white" stroke-width="2" fill="none"/></svg>
                                                    Disetujui
                                                </button>
                                            </li>
                                            <li>
                                                <button
                                                    @click="
                                                        $wire.changeStatus(cuti.id, 'Menunggu').then(res => {
                                                            if(res?.status) cuti.status = res.status;
                                                        });
                                                        open = false
                                                    "
                                                    class="flex items-center gap-2 w-full px-3 py-1.5 text-left text-xs font-bold cursor-pointer hover:bg-yellow-50 text-yellow-700 transition-all"
                                                >
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10" class="text-yellow-400" fill="currentColor"/><path d="M9 12l2 2l4 -4" stroke="white" stroke-width="2" fill="none"/></svg>
                                                    Menunggu
                                                </button>
                                            </li>
                                            <li>
                                                <button
                                                    @click="
                                                        $wire.changeStatus(cuti.id, 'Ditolak').then(res => {
                                                            if(res?.status) cuti.status = res.status;
                                                        });
                                                        open = false
                                                    "
                                                    class="flex items-center gap-2 w-full px-3 py-1.5 text-left text-xs font-bold cursor-pointer hover:bg-red-50 text-red-700 transition-all"
                                                >
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10" class="text-red-400" fill="currentColor"/><path d="M9 9l6 6M15 9l-6 6" stroke="white" stroke-width="2" fill="none"/></svg>
                                                    Ditolak
                                                </button>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </td>
                            <td class="py-3 px-6 text-center">
                                <template x-if="cuti.file_pengajuan">
                                    <a :href="'/storage/' + cuti.file_pengajuan" target="_blank" title="Lihat File">
                                        <img src="{{ asset('img/action/file.webp') }}" alt="File" class="w-6 h-6 inline-block hover:scale-110 transition-transform" />
                                    </a>
                                </template>
                                <template x-if="!cuti.file_pengajuan">
                                    <span class="text-gray-400">-</span>
                                </template>
                            </td>
                        </tr>
                    </template>
                    <template x-if="paginatedCutis.length === 0">
                        <tr>
                            <td colspan="8" class="py-6 text-center text-gray-700">Tidak ada data cuti ditemukan.</td>
                        </tr>
                    </template>
                </tbody>
            </table>
        </div>
        <!-- Pagination -->
        <div class="mt-4">
            <template x-if="totalPages > 1">
                <div class="flex justify-between items-center">
                    <div class="text-sm text-gray-700">
                        Menampilkan <span x-text="(currentPage - 1) * perPage + 1"></span> - <span x-text="Math.min(currentPage * perPage, filteredCutis.length)"></span> dari <span x-text="filteredCutis.length"></span> data
                    </div>
                    <div class="flex gap-2">
                        <button
                            @click="goToPage(currentPage - 1)"
                            :disabled="currentPage === 1"
                            class="px-4 py-2 rounded-lg bg-blue-600 hover:bg-blue-700 text-white font-semibold transition-all duration-300 disabled:opacity-50 disabled:cursor-not-allowed"
                        >
                            Sebelumnya
                        </button>
                        <template x-for="page in totalPages" :key="page">
                            <button
                                @click="goToPage(page)"
                                x-text="page"
                                :class="{
                                    'bg-blue-600 text-white font-semibold': currentPage === page,
                                    'bg-gray-200 text-gray-700 hover:bg-blue-100': currentPage !== page
                                }"
                                class="px-4 py-2 rounded-lg transition-all duration-300"
                            ></button>
                        </template>
                        <button
                            @click="goToPage(currentPage + 1)"
                            :disabled="currentPage === totalPages"
                            class="px-4 py-2 rounded-lg bg-blue-600 hover:bg-blue-700 text-white font-semibold transition-all duration-300 disabled:opacity-50 disabled:cursor-not-allowed"
                        >
                            Selanjutnya
                        </button>
                    </div>
                </div>
            </template>
        </div>
</div>
