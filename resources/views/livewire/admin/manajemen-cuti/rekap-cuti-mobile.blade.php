{{-- Untuk import ke rekap-cuti.blade.php (tanpa section) --}}
<div class="px-2 py-4"
    x-data="{
        search: '',
        filterStatus: '',
        filterTipe: '',
        filterBulan: '',
        filterTahun: '',
        cutis: @js($cutis),
        currentPage: 1,
        perPage: 10,
        bulanList: [
            { value: '1', label: 'Januari' }, { value: '2', label: 'Februari' }, { value: '3', label: 'Maret' },
            { value: '4', label: 'April' }, { value: '5', label: 'Mei' }, { value: '6', label: 'Juni' },
            { value: '7', label: 'Juli' }, { value: '8', label: 'Agustus' }, { value: '9', label: 'September' },
            { value: '10', label: 'Oktober' }, { value: '11', label: 'November' }, { value: '12', label: 'Desember' },
        ],
        tahunList: Array.from({length: (new Date().getFullYear() - 2020 + 1)}, (_, i) => (new Date().getFullYear() - i).toString()),
        get filterBulanLabel() {
            const found = this.bulanList.find(b => b.value === this.filterBulan);
            return found ? found.label : '';
        },
        get filteredCutis() {
            return this.cutis.filter(c => {
                let matchSearch = !this.search
                    || (c.karyawan?.user?.name ?? '').toLowerCase().includes(this.search.toLowerCase())
                    || (c.tipe_cuti?.nama_cuti ?? '').toLowerCase().includes(this.search.toLowerCase());
                let matchStatus = !this.filterStatus || c.status === this.filterStatus;
                let matchTipe = !this.filterTipe || (c.tipe_cuti?.nama_cuti === this.filterTipe);
                let date = new Date(c.created_at);
                let matchBulan = !this.filterBulan || (date.getMonth() + 1) == this.filterBulan;
                let matchTahun = !this.filterTahun || date.getFullYear().toString() == this.filterTahun;
                return matchSearch && matchStatus && matchTipe && matchBulan && matchTahun;
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
    <h1 class="text-lg font-bold mb-4 text-white flex items-center justify-center gap-2">
        <img src="{{ asset('img/sidebar/rekap.webp') }}" alt="Cuti" class="w-8 h-8" />
        Rekap Cuti
    </h1>
    <!-- Filter Section -->
    <div class="bg-white/30 rounded-xl p-3 mb-4 flex flex-col gap-2 shadow w-full">
                <!-- Search -->
                <div class="relative w-full md:w-72 group">
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
        <div class="flex gap-2">
            <!-- Status: Ganti select dengan custom dropdown -->
            <div x-data="{ open: false }" class="relative group w-full">
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
                    class="appearance-none pl-10 pr-6 py-2 rounded-lg border border-gray-300  font-semibold text-sm text-gray-700 shadow w-full flex items-center justify-between focus:outline-none focus:ring-2 focus:ring-blue-400 transition-all duration-300 hover:scale-105 hover:border-blue-400 hover:shadow-lg relative z-20 cursor-pointer"
                >
                    <span>
                        <template x-if="!filterStatus"><span class="text-gray-700 font-semibold">Status</span></template>
                        <template x-if="filterStatus"><span x-text="filterStatus" class="font-semibold"></span></template>
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
                            <button @click="$parent.filterStatus = ''; open = false"
                                class="cursor-pointer flex items-center w-full px-4 py-2 hover:bg-blue-50 rounded-lg transition text-gray-700 font-semibold">
                                <span class="mr-2">👥</span> Semua Status
                            </button>
                        </li>
                        <li>
                            <button @click="$parent.filterStatus = 'Menunggu'; open = false"
                                class="cursor-pointer flex items-center w-full px-4 py-2 hover:bg-yellow-50 rounded-lg transition text-yellow-700 font-semibold">
                                <span class="mr-2">⏳</span> Menunggu
                            </button>
                        </li>
                        <li>
                            <button @click="$parent.filterStatus = 'Disetujui'; open = false"
                                class="cursor-pointer flex items-center w-full px-4 py-2 hover:bg-green-50 rounded-lg transition text-green-700 font-semibold">
                                <span class="mr-2">✅</span> Disetujui
                            </button>
                        </li>
                        <li>
                            <button @click="$parent.filterStatus = 'Ditolak'; open = false"
                                class="cursor-pointer flex items-center w-full px-4 py-2 hover:bg-red-50 rounded-lg transition text-red-700 font-semibold">
                                <span class="mr-2">❌</span> Ditolak
                            </button>
                        </li>
                    </ul>
                </div>
            </div>
            <!-- Filter Tipe Cuti Custom Dropdown -->
                <div x-data="{ open: false }" class="relative group w-full md:w-48">
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
                            <template x-if="!filterTipe"><span class="text-gray-700 font-semibold">Tipe</span></template>
                            <template x-if="filterTipe"><span x-text="filterTipe" class="font-semibold"></span></template>
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
        </div>
        <div class="flex gap-2">
            <!-- Filter Bulan Custom Dropdown -->
                <div x-data="{ open: false }" class="relative group w-full md:w-44">
                    <img src="{{ asset('img/filter/calendar.webp') }}"
                        alt="Bulan"
                        class="absolute left-3 top-2.5 w-5 h-5 opacity-80 pointer-events-none transition-all duration-300 origin-center z-10
                            group-hover:scale-110 group-focus-within:scale-110
                            group-hover:drop-shadow-[0_0_6px_#0074D9] group-focus-within:drop-shadow-[0_0_6px_#0074D9]
                            group-hover:saturate-200 group-focus-within:saturate-200"
                    />
                    <button
                        @click="open = !open"
                        @click.away="open = false"
                        type="button"
                        class="appearance-none pl-10 pr-6 py-2 rounded-lg border border-gray-300  font-semibold text-base text-gray-700 shadow w-full flex items-center justify-between focus:outline-none focus:ring-2 focus:ring-blue-400 transition-all duration-300 hover:scale-105 hover:border-blue-400 hover:shadow-lg relative z-20 cursor-pointer"
                    >
                        <span>
                            <template x-if="!filterBulan"><span class="text-gray-700 font-semibold whitespace-nowrap">Bulan</span></template>
                            <template x-if="filterBulan"><span x-text="filterBulanLabel" class="font-semibold"></span></template>
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
                            <li></li>
                                <button @click="$wire.set('filterBulan', ''); filterBulan = ''; open = false"
                                    class="cursor-pointer flex items-center w-full px-4 py-2 hover:bg-blue-50 rounded-lg transition text-gray-700 font-semibold">
                                    <span class="mr-2 whitespace-nowrap">📅</span> Semua Bulan
                                </button>
                            </li>
                            <template x-for="(bulan, idx) in bulanList" :key="idx">
                                <li>
                                    <button @click="$wire.set('filterBulan', bulan.value); filterBulan = bulan.value; open = false"
                                        class="cursor-pointer flex items-center w-full px-4 py-2 hover:bg-blue-50 rounded-lg transition text-blue-700 font-semibold">
                                        <span class="mr-2 whitespace-nowrap">🗓️</span> <span x-text="bulan.label"></span>
                                    </button>
                                </li>
                            </template>
                        </ul>
                    </div>
                </div>
            <!-- Filter Tahun Custom Dropdown -->
                <div x-data="{ open: false }" class="relative group w-full md:w-46">
                    <img src="{{ asset('img/filter/calendar.webp') }}"
                        alt="Tahun"
                        class="absolute left-3 top-2.5 w-5 h-5 opacity-80 pointer-events-none transition-all duration-300 origin-center z-10
                            group-hover:scale-110 group-focus-within:scale-110
                            group-hover:drop-shadow-[0_0_6px_#0074D9] group-focus-within:drop-shadow-[0_0_6px_#0074D9]
                            group-hover:saturate-200 group-focus-within:saturate-200"
                    />
                    <button
                        @click="open = !open"
                        @click.away="open = false"
                        type="button"
                        class="appearance-none pl-10 pr-6 py-2 rounded-lg border border-gray-300  font-semibold text-base text-gray-700 shadow w-full flex items-center justify-between focus:outline-none focus:ring-2 focus:ring-blue-400 transition-all duration-300 hover:scale-105 hover:border-blue-400 hover:shadow-lg relative z-20 cursor-pointer"
                    >
                        <span>
                            <template x-if="!filterTahun"><span class="text-gray-700 font-semibold whitespace-nowrap">Tahun</span></template>
                            <template x-if="filterTahun"><span x-text="filterTahun" class="font-semibold whitespace-nowrap"></span></template>
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
                                <button @click="$wire.set('filterTahun', ''); filterTahun = ''; open = false"
                                    class="cursor-pointer flex items-center w-full px-4 py-2 hover:bg-blue-50 rounded-lg transition text-gray-700 font-semibold">
                                    <span class="mr-2 whitespace-nowrap">📆</span> Semua Tahun
                                </button>
                            </li>
                            <template x-for="tahun in tahunList" :key="tahun">
                                <li>
                                    <button @click="$wire.set('filterTahun', tahun); filterTahun = tahun; open = false"
                                        class="cursor-pointer flex items-center w-full px-4 py-2 hover:bg-blue-50 rounded-lg transition text-blue-700 font-semibold">
                                        <span class="mr-2 whitespace-nowrap">🗓️</span> <span x-text="tahun"></span>
                                    </button>
                                </li>
                            </template>
                        </ul>
                    </div>
                </div>
        </div>
        <!-- Reset Filters Button -->
                <div class="shrink-0 ">
                    <button
                        @click="filterStatus = ''; filterTipe = ''; search = ''; filterBulan = ''; filterTahun = ''; currentPage = 1"
                        class="flex items-center gap-2 px-4 py-2 rounded-lg bg-gray-100 text-gray-700 font-semibold shadow-md transition-all duration-300 hover:bg-gray-200 cursor-pointer hover:scale-105 hover:shadow-lg"
                    >
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path d="M4 6h16M4 12h16m-7 6h7" stroke="currentColor" stroke-width="2" fill="none"/>
                        </svg>
                        Reset
                    </button>
                </div>

        <div class="overflow-x-auto w-75">
            <table class="min-w-150 w-full text-sm text-gray-700 rounded-2xl shadow-lg border-separate border-spacing-0">
                <thead>
                    <tr class="bg-linear-to-r from-[#F53003] to-[#0074D9] text-white sticky top-0 z-10">
                        <th class="py-4 px-6 rounded-tl-2xl text-left">No</th>
                        <th class="py-4 px-6 text-left">Nama Karyawan</th>
                        <th class="py-4 px-6 text-left">Tipe</th>
                        <th class="py-4 px-6 text-left">Tanggal Pengajuan</th>
                        <th class="py-4 px-6 text-left">Tanggal Mulai</th>
                        <th class="py-4 px-6 text-left">Tanggal Selesai</th>
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
                            <td class="py-3 px-6">
                                <span
                                    class="inline-block px-1.5 py-1 rounded-full text-xs font-semibold"
                                    :class="{
                                        'bg-green-100 text-green-700': cuti.status === 'Disetujui',
                                        'bg-yellow-100 text-yellow-700': cuti.status === 'Menunggu',
                                        'bg-red-100 text-red-700': cuti.status === 'Ditolak'
                                    }"
                                    x-text="cuti.status"
                                ></span>
                            </td>
                            <td class="py- px-1.5 text-center">
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
    </div>


    <!-- Pagination -->
    <div class="flex justify-center items-center gap-1 mt-4" x-show="totalPages > 1">
        <button @click="goToPage(currentPage-1)" :disabled="currentPage === 1"
            class="px-2 py-1 rounded bg-gray-200 text-xs"
            :class="{'opacity-50 cursor-not-allowed': currentPage === 1}">
            &lt;
        </button>
        <template x-for="page in totalPages" :key="page">
            <button @click="goToPage(page)"
                class="px-2 py-1 rounded text-xs"
                :class="currentPage === page ? 'bg-blue-600 text-white' : 'bg-gray-200'">
                <span x-text="page"></span>
            </button>
        </template>
        <button @click="goToPage(currentPage+1)" :disabled="currentPage === totalPages"
            class="px-2 py-1 rounded bg-gray-200 text-xs"
            :class="{'opacity-50 cursor-not-allowed': currentPage === totalPages}">
            &gt;
        </button>
    </div>
</div>
