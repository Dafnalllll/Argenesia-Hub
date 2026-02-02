<div class="p-4 mt-14"
    x-data="{
        search: '',
        filterRole: '',
        filterStatus: '',
        users: @js($users),
        currentPage: 1,
        perPage: 8,
        get filteredUsers() {
            return this.users.filter(u => {
                const matchSearch = !this.search
                    || (u.name ?? '').toLowerCase().includes(this.search.toLowerCase())
                    || (u.email ?? '').toLowerCase().includes(this.search.toLowerCase());
                const matchRole = !this.filterRole || (u.role?.name === this.filterRole);
                const matchStatus = !this.filterStatus || (u.status?.toLowerCase() === this.filterStatus.toLowerCase());
                return matchSearch && matchRole && matchStatus;
            });
        },
        get paginatedUsers() {
            const start = (this.currentPage - 1) * this.perPage;
            return this.filteredUsers.slice(start, start + this.perPage);
        },
        get totalPages() {
            return Math.ceil(this.filteredUsers.length / this.perPage) || 1;
        },
        goToPage(page) {
            if (page < 1) page = 1;
            if (page > this.totalPages) page = this.totalPages;
            this.currentPage = page;
        },
        showDeleteModal: false,
        deleteId: null,
        showDetailModal: false,
        selectedUser: null,
        detail: @js($users->keyBy('id'))
    }"
>
    {{-- ALERT SUCCESS --}}
    @if (session()->has('success'))
    <div
        x-data="{ show: true }"
        x-init="setTimeout(() => show = false, 2000)"
        x-show="show"
        x-transition
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

    <h1 class="text-xl font-bold mb-4 text-white tracking-wide flex items-center justify-center gap-3">
        <img src="{{ asset('img/sidebar/profil.webp') }}" alt="Admin" class="w-8 h-8" />
        Manajemen User
    </h1>
    <div class="bg-white/70 backdrop-blur-md border border-white/30 rounded-xl shadow-lg p-4">
        <!-- Search & Filter -->
        <div class="flex flex-col gap-3 mb-4">
            <!-- Search -->
        <div class="relative w-full group">
            <input
                type="text"
                x-model="search"
                @input="currentPage = 1"
                placeholder="Cari user..."
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
                <!-- Filter Role Custom Dropdown -->
                <div x-data="{ open: false }" class="relative group w-full">
                    <img src="{{ asset('img/filter/role.webp') }}"
                        alt="Role"
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
                            <template x-if="filterRole === 'Admin'"><span class="text-blue-700 font-semibold">Admin</span></template>
                            <template x-if="filterRole === 'HR'"><span class="text-purple-700 font-semibold">HR</span></template>
                            <template x-if="filterRole === 'Employee'"><span class="text-green-700 font-semibold">Employee</span></template>
                            <template x-if="!filterRole"><span class="text-gray-700 font-semibold">Role</span></template>
                        </span>
                        <span
                            :class="open ? 'rotate-180' : ''"
                            class="pointer-events-none absolute right-3 top-3 text-gray-400 transition-transform duration-300 group-hover:scale-125 group-focus-within:scale-125 group-hover:text-blue-500 group-focus-within:text-blue-500 z-20"
                        >
                            <svg class="w-4 h-4 " fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path d="M19 9l-7 7-7-7"/>
                            </svg>
                        </span>
                    </button>
                    <div x-show="open" x-transition class="absolute z-30 mt-2 w-50 bg-white rounded-lg shadow-lg border border-gray-200">
                        <ul>
                            <li>
                                <button @click="filterRole = ''; open = false"
                                    class="cursor-pointer flex items-center w-full px-4 py-2 hover:bg-blue-50 rounded-lg transition text-gray-700 font-semibold">
                                    <span class="mr-2">👥</span> Semua Role
                                </button>
                            </li>
                            <li>
                                <button @click="filterRole = 'Admin'; open = false"
                                    class="cursor-pointer flex items-center w-full px-4 py-2 hover:bg-blue-50 rounded-lg transition text-blue-700 font-semibold">
                                    <span class="mr-2">🛡️</span> Admin
                                </button>
                            </li>
                            <li>
                                <button @click="filterRole = 'HR'; open = false"
                                    class="cursor-pointer flex items-center w-full px-4 py-2 hover:bg-purple-50 rounded-lg transition text-purple-700 font-semibold">
                                    <span class="mr-2">📋</span> HR
                                </button>
                            </li>
                            <li>
                                <button @click="filterRole = 'Employee'; open = false"
                                    class="cursor-pointer flex items-center w-full px-4 py-2 hover:bg-green-50 rounded-lg transition text-green-700 font-semibold">
                                    <span class="mr-2">👔</span> Employee
                                </button>
                            </li>
                        </ul>
                    </div>
                </div>
                <!-- Filter Status Custom Dropdown -->
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
                        class="appearance-none pl-10 pr-6 py-2 rounded-lg border border-gray-300 bg-transparent font-semibold text-base text-gray-700 shadow w-full flex items-center justify-between focus:outline-none focus:ring-2 focus:ring-blue-400 transition-all duration-300 hover:scale-105 hover:border-blue-400 hover:shadow-lg relative z-20 cursor-pointer"
                    >
                        <span>
                            <template x-if="filterStatus === 'aktif'"><span class="text-green-700 font-semibold">Aktif</span></template>
                            <template x-if="filterStatus === 'nonaktif'"><span class="text-red-700 font-semibold">Nonaktif</span></template>
                            <template x-if="!filterStatus"><span class="text-gray-700 font-semibold">Status</span></template>
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
                    <div x-show="open" x-transition class="absolute z-30 mt-2 w-50 bg-white rounded-lg shadow-lg border border-gray-200">
                        <ul>
                            <li>
                                <button @click="filterStatus = ''; open = false"
                                    class="cursor-pointer flex items-center w-full px-4 py-2 hover:bg-blue-50 rounded-lg transition text-gray-700 font-semibold">
                                    <span class="mr-2">👥</span> Semua Status
                                </button>
                            </li>
                            <li>
                                <button @click="filterStatus = 'aktif'; open = false"
                                    class="cursor-pointer flex items-center w-full px-4 py-2 hover:bg-green-50 rounded-lg transition text-green-700 font-semibold">
                                    <span class="mr-2">✅</span> Aktif
                                </button>
                            </li>
                            <li>
                                <button @click="filterStatus = 'nonaktif'; open = false"
                                    class="cursor-pointer flex items-center w-full px-4 py-2 hover:bg-red-50 rounded-lg transition text-red-700 font-semibold">
                                    <span class="mr-2">❌</span> Nonaktif
                                </button>
                            </li>
                        </ul>
                    </div>
                </div>
                <!-- Reset Filters Button -->
                <div class="shrink-0">
                    <button
                        @click="filterRole=''; filterStatus=''; search=''; currentPage=1"
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
        <!-- User Table (Mobile) -->
    <div class="overflow-x-auto w-90">
        <table class="min-w-125 w-full text-sm text-gray-700 rounded-2xl shadow-lg border-separate border-spacing-0">
            <thead>
                <tr class="bg-linear-to-r from-[#F53003] to-[#0074D9] text-white sticky top-0 z-10">
                    <th class="py-4 px-4 rounded-tl-2xl text-left">No</th>
                    <th class="py-4 px-4 text-left">Nama</th>
                    <th class="py-4 px-4 text-left">Email</th>
                    <th class="py-4 px-4 text-left">Role</th>
                    <th class="py-4 px-4 text-left">Status</th>
                    <th class="py-4 px-4 text-left">Tanggal Dibuat</th>
                    <th class="py-4 px-4 text-center">Detail</th>
                    <th class="py-4 px-4 rounded-tr-2xl text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <template x-for="(user, i) in paginatedUsers" :key="user.id">
                    <tr class="hover:bg-blue-50 transition border-b border-blue-100">
                        <td class="py-3 px-4 font-bold" x-text="(currentPage-1)*perPage + i + 1"></td>
                        <td class="py-3 px-4" x-text="user.name"></td>
                        <td class="py-3 px-4" x-text="user.email"></td>
                        <td class="py-3 px-4">
                            <span
                                class="inline-block px-3 py-1 rounded-full text-xs font-semibold"
                                :class="{
                                    'bg-blue-100 text-blue-700': user.role?.name === 'Admin',
                                    'bg-purple-100 text-purple-700': user.role?.name === 'HR',
                                    'bg-yellow-100 text-yellow-700': user.role?.name === 'Employee',
                                    'bg-gray-100 text-gray-700': !['Admin','HR','Employee'].includes(user.role?.name)
                                }"
                                x-text="user.role?.name ?? '-'"
                            ></span>
                        </td>
                        <td class="py-3 px-4">
                            <template x-if="!['Admin','HR'].includes(user.role?.name)">
                                <div x-data="{ open: false }" class="relative">
                                    <!-- Trigger Button -->
                                    <button
                                        @click="open = !open"
                                        @click.away="open = false"
                                        type="button"
                                        class="rounded-full px-3 py-1 text-xs font-bold flex items-center gap-1.5 cursor-pointer
                                            shadow border-2 border-transparent hover:border-gray-300 transition-all duration-200"
                                        :class="{
                                            'bg-green-50 text-green-700 border-green-400': user.status === 'Aktif',
                                            'bg-red-50 text-red-700 border-red-400': user.status === 'Nonaktif'
                                        }"
                                    >
                                        <span class="mr-1">
                                            <template x-if="user.status === 'Aktif'">
                                                <svg class="inline w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10" class="text-green-400" fill="currentColor"/><path d="M9 12l2 2l4 -4" stroke="white" stroke-width="2" fill="none"/></svg>
                                            </template>
                                            <template x-if="user.status !== 'Aktif'">
                                                <svg class="inline w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10" class="text-red-400" fill="currentColor"/><path d="M9 9l6 6M15 9l-6 6" stroke="white" stroke-width="2" fill="none"/></svg>
                                            </template>
                                        </span>
                                        <span x-text="user.status"></span>
                                        <svg :class="open ? 'rotate-180' : ''" class="w-4 h-4 ml-2 transition-transform cursor-pointer" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                            <path d="M19 9l-7 7-7-7"/>
                                        </svg>
                                    </button>
                                    <!-- Dropdown Menu -->
                                    <div
                                        x-show="open"
                                        x-transition
                                        class="absolute left-0 bottom-full mb-2 w-28 rounded-xl shadow-lg border border-gray-200 z-50 bg-white overflow-hidden"
                                    >
                                        <ul>
                                            <li>
                                                <button
                                                    @click="
                                                            $wire.changeStatus(user.id, 'Aktif').then(res => {
                                                                if(res?.status) {
                                                                    user.status = res.status;
                                                                    if(detail[user.id]) detail[user.id].status = res.status;
                                                                }
                                                            });
                                                            open = false
                                                        "
                                                        class="flex items-center gap-2 w-full px-3 py-1.5 text-left text-xs font-bold cursor-pointer hover:bg-green-50 text-green-700 transition-all"
                                                    >
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10" class="text-green-400" fill="currentColor"/><path d="M9 12l2 2l4 -4" stroke="white" stroke-width="2" fill="none"/></svg>
                                                    Aktif
                                                </button>
                                            </li>
                                            <li>
                                                <button
                                                    @click="
                                                    $wire.changeStatus(user.id, 'Nonaktif').then(res => {
                                                        if(res?.status) {
                                                            user.status = res.status;
                                                            if(detail[user.id]) detail[user.id].status = res.status;
                                                        }
                                                    });
                                                    open = false
                                                "
                                                class="flex items-center gap-2 w-full px-3 py-1.5 text-left text-xs font-bold cursor-pointer hover:bg-red-50 text-red-700 transition-all"
                                            >
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10" class="text-red-400" fill="currentColor"/><path d="M9 9l6 6M15 9l-6 6" stroke="white" stroke-width="2" fill="none"/></svg>
                                                    Nonaktif
                                                </button>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </template>
                            <template x-if="['Admin','HR'].includes(user.role?.name)">
                                <span class="text-gray-800 text-base pl-8">-</span>
                            </template>
                        </td>
                        <td class="py-3 px-4"
                            x-text="(() => {
                                const d = new Date(user.created_at);
                                const pad = n => n.toString().padStart(2, '0');
                                return `${d.getFullYear()}-${pad(d.getMonth()+1)}-${pad(d.getDate())}, ${pad(d.getHours())}:${pad(d.getMinutes())}:${pad(d.getSeconds())}`;
                            })()"
                        ></td>
                        <td class="py-3 px-4 flex justify-center gap-2">
                            <template x-if="user.role?.name === 'Employee'">
                                <button
                                    @click="selectedUser = user.id; showDetailModal = true"
                                    class="rounded-lg p-1 transition"
                                    title="Detail"
                                    type="button"
                                >
                                    <img src="{{ asset('img/action/detail.webp') }}" alt="Detail" class="w-5 h-5 object-contain hover:scale-110 transition-transform cursor-pointer "/>
                                </button>
                            </template>
                            <template x-if="user.role?.name !== 'Employee'">
                                <span class="text-gray-800 text-base mt-5">-</span>
                            </template>
                        </td>
                        <td class="py-3 px-4 justify-center gap-2">
                            <template x-if="!['Admin','HR'].includes(user.role?.name)">
                                <div class="inline">
                                    <button
                                        @click="showDeleteModal = true; deleteId = user.id"
                                        title="Hapus"
                                        class="rounded-lg transition p-1"
                                    >
                                        <img src="{{ asset('img/action/delete.webp') }}" alt="Hapus" class="w-5 h-5 object-contain hover:scale-110 transition-transform cursor-pointer ml-2"/>
                                    </button>
                                </div>
                            </template>
                            <template x-if="['Admin','HR'].includes(user.role?.name)">
                                <span class="text-gray-800 text-base pl-4">-</span>
                            </template>
                        </td>
                    </tr>
                </template>
                <template x-if="paginatedUsers.length === 0">
                    <tr>
                        <td colspan="8" class="py-6 text-center text-gray-700">Tidak ada user ditemukan.</td>
                    </tr>
                </template>
            </tbody>
        </table>
    </div>
        <!-- Pagination -->
        <div class="flex justify-center items-center gap-2 mt-4" x-show="totalPages > 1">
            <button
                @click="goToPage(currentPage-1)"
                :disabled="currentPage === 1"
                class="px-3 py-1 rounded bg-gray-200 text-gray-700 font-semibold disabled:opacity-50"
            >&laquo;</button>
            <template x-for="page in totalPages" :key="page">
                <button
                    @click="goToPage(page)"
                    :class="page === currentPage ? 'bg-blue-600 text-white' : 'bg-gray-100 text-gray-700'"
                    class="mx-1 px-3 py-1 rounded font-semibold"
                    x-text="page"
                ></button>
            </template>
            <button
                @click="goToPage(currentPage+1)"
                :disabled="currentPage === totalPages"
                class="px-3 py-1 rounded bg-gray-200 text-gray-700 font-semibold disabled:opacity-50"
            >&raquo;</button>
        </div>
    </div>

    <!-- Modal Konfirmasi Hapus User -->
    <div
        x-show="showDeleteModal"
        x-transition
        class="fixed inset-0 z-50 flex items-center justify-center bg-black/40"
        style="display: none;"
    >
        <div class="bg-white rounded-xl p-6 shadow-lg w-full max-w-xs relative">
            <button @click="showDeleteModal = false" class="absolute top-2 right-2 text-gray-400 hover:text-red-500 text-xl">&times;</button>
            <div class="flex items-center gap-3 mb-3">
                <svg class="w-8 h-8 text-red-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <circle cx="12" cy="12" r="10" class="text-red-100" fill="currentColor"/>
                    <path d="M9 9l6 6M15 9l-6 6" stroke="red" stroke-width="2" fill="none"/>
                </svg>
                <h2 class="text-lg font-bold text-gray-800">Konfirmasi Hapus</h2>
            </div>
            <p class="mb-4 text-gray-700 text-sm">
                Yakin ingin menghapus user ini? Data yang dihapus <b>tidak dapat dikembalikan</b>.
            </p>
            <div class="flex justify-end gap-2">
                <button @click="showDeleteModal = false" class="px-3 py-1 rounded bg-gray-200 text-gray-700 font-semibold">Batal</button>
                <button
                    @click="$wire.deleteUserById(deleteId); showDeleteModal = false"
                    class="px-3 py-1 rounded bg-red-600 text-white font-semibold"
                >Hapus</button>
            </div>
        </div>
    </div>

    <!-- Modal Detail Profil User (Mobile) -->
<div
    x-show="showDetailModal"
    x-transition
    class="fixed inset-0 z-50 flex items-center justify-center bg-black/40"
    style="display: none;"
>
    <div class="bg-linear-to-r from-[#F53003] to-[#0074D9] rounded-xl p-8 shadow-lg w-full max-w-xs relative">
        <button @click="showDetailModal = false" class="absolute top-2 right-2 text-gray-400 hover:text-red-500 text-2xl cursor-pointer">&times;</button>
        <template x-if="selectedUser && detail[selectedUser]">
            <div>
                <div class="flex items-center gap-4 mb-4">
                    <template x-if="detail[selectedUser].karyawan?.foto">
                        <img :src="'/' + detail[selectedUser].karyawan.foto" class="w-16 h-16 rounded-full object-cover border" alt="Foto">
                    </template>
                    <template x-if="!detail[selectedUser].karyawan?.foto">
                        <span class="inline-block w-16 h-16 rounded-full bg-gray-200 items-center justify-center text-gray-400 text-2xl">-</span>
                    </template>
                    <div>
                        <div class="font-bold text-lg" x-text="detail[selectedUser].name ?? '-'"></div>
                        <div class="text-sm text-gray-800" x-text="detail[selectedUser].email ?? '-'"></div>
                    </div>
                </div>
                <div class="mb-2"><b>Nomor Telepon:</b>
                    <span x-text="detail[selectedUser].karyawan?.nomor_telepon ?? 'Belum diisi'"></span>
                </div>
                <div class="mb-2"><b>Status:</b>
                    <span x-text="detail[selectedUser].karyawan?.status_karyawan ?? detail[selectedUser].status ?? '-'"></span>
                </div>
                <div class="mb-2"><b>Alamat:</b>
                    <span x-text="detail[selectedUser].karyawan?.alamat ?? 'Belum diisi'"></span>
                </div>
            </div>
        </template>
    </div>
</div>
</div>
