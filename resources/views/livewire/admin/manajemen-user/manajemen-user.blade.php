@section('title', 'Manajemen User || Argenesia Hub')

<div class="p-6">
    <h1 class="text-2xl font-bold mb-6 text-white tracking-wide">Manajemen User</h1>
    <div class="bg-white/40 backdrop-blur-md border border-white/30 rounded-2xl shadow-2xl p-6">
        <div class="flex flex-col md:flex-row md:justify-between md:items-center mb-6 gap-4">
            <div class="flex flex-col md:flex-row gap-6 w-full md:w-auto">
                <!-- Search -->
                <div class="relative w-full md:w-72 group">
                    <input
                        type="text"
                        wire:model.debounce.500ms="search"
                        placeholder="Cari user..."
                        class="pl-10 pr-4 py-2 rounded-lg border border-gray-800 focus:outline-none w-full shadow transition-all duration-300
                            group-hover:scale-105 group-focus-within:scale-105 group-hover:shadow-lg group-focus-within:shadow-lg group-hover:border-[#F53003]  "
                    />
                    <span class="absolute left-3 top-2.5 text-gray-700 transition-all duration-300 group-hover:scale-110 group-focus-within:scale-110 group-hover:text-[#F53003]  group-focus-within:text-[#F53003]  ">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><path d="M21 21l-4.35-4.35"/></svg>
                    </span>
                </div>
                <!-- Filter Role Custom Dropdown -->
                <div x-data="{ open: false }" class="relative group w-full md:w-48">
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
                            @if($filterRole === 'Admin')
                                <span class="text-blue-700 font-semibold ">Admin</span>
                            @elseif($filterRole === 'HR')
                                <span class="text-purple-700 font-semibold">HR</span>
                            @elseif($filterRole === 'Employee')
                                <span class="text-green-700 font-semibold">Employee</span>
                            @else
                                <span class="text-gray-700 font-semibold">Semua Role</span>
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
                                <button wire:click="$set('filterRole', '')" @click="open = false"
                                    class="cursor-pointer flex items-center w-full px-4 py-2 hover:bg-blue-50 rounded-lg transition text-gray-700 font-semibold">
                                    <span class="mr-2">👥</span> Semua Role
                                </button>
                            </li>
                            <li>
                                <button wire:click="$set('filterRole', 'Admin')" @click="open = false"
                                    class="cursor-pointer flex items-center w-full px-4 py-2 hover:bg-blue-50 rounded-lg transition text-blue-700 font-semibold">
                                    <span class="mr-2">🛡️</span> Admin
                                </button>
                            </li>
                            <li>
                                <button wire:click="$set('filterRole', 'HR')" @click="open = false"
                                    class="cursor-pointer flex items-center w-full px-4 py-2 hover:bg-purple-50 rounded-lg transition text-purple-700 font-semibold">
                                    <span class="mr-2">📋</span> HR
                                </button>
                            </li>
                            <li>
                                <button wire:click="$set('filterRole', 'Employee')" @click="open = false"
                                    class="cursor-pointer flex items-center w-full px-4 py-2 hover:bg-green-50 rounded-lg transition text-green-700 font-semibold">
                                    <span class="mr-2">👔</span> Employee
                                </button>
                            </li>
                        </ul>
                    </div>
                </div>
                <!-- Filter Status Custom Dropdown -->
                <div x-data="{ open: false }" class="relative group w-full md:w-48 ">
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
                            @if($filterStatus === 'aktif')
                                <span class="text-green-700 font-semibold">Aktif</span>
                            @elseif($filterStatus === 'nonaktif')
                                <span class="text-red-700 font-semibold">Nonaktif</span>
                            @else
                                <span class="text-gray-700 font-semibold">Semua Status</span>
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
                                <button wire:click="$set('filterStatus', '')" @click="open = false" class="cursor-pointer flex items-center w-full px-4 py-2 hover:bg-blue-50 rounded-lg transition text-gray-700 font-semibold">
                                    <span class="mr-2">🔎</span> Semua Status
                                </button>
                            </li>
                            <li>
                                <button wire:click="$set('filterStatus', 'aktif')" @click="open = false" class="cursor-pointer flex items-center w-full px-4 py-2 hover:bg-green-50 rounded-lg transition text-green-700 font-semibold">
                                    <span class="mr-2">🟢</span> Aktif
                                </button>
                            </li>
                            <li>
                                <button wire:click="$set('filterStatus', 'nonaktif')" @click="open = false" class="cursor-pointer flex items-center w-full px-4 py-2 hover:bg-red-50 rounded-lg transition text-red-700 font-semibold">
                                    <span class="mr-2">🔴</span> Nonaktif
                                </button>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <button
                wire:click="resetFilter"
                class="px-4 py-2 rounded-lg bg-gray-200 hover:bg-gray-300 text-gray-700 font-semibold shadow hover:scale-105 transition-all cursor-pointer"
            >
                Reset
            </button>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-275 w-full text-sm text-gray-700 rounded-2xl shadow-lg border-separate border-spacing-0">
                <thead>
                    <tr class="bg-linear-to-r from-[#F53003] to-[#0074D9] text-white sticky top-0 z-10">
                        <th class="py-4 px-6 rounded-tl-2xl text-left">No</th>
                        <th class="py-4 px-6 text-left">Nama</th>
                        <th class="py-4 px-6 text-left">Email</th>
                        <th class="py-4 px-6 text-left">Role</th>
                        <th class="py-4 px-6 text-left">Status</th>
                        <th class="py-4 px-6 text-left">Tanggal Dibuat</th>
                        <th class="py-4 px-6 rounded-tr-2xl text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $i => $user)
                        <tr class="hover:bg-blue-50 transition border-b border-blue-100">
                            <td class="py-3 px-6 font-bold">{{ $i+1 }}</td>
                            <td class="py-3 px-6">{{ $user->name }}</td>
                            <td class="py-3 px-6">{{ $user->email }}</td>
                            <td class="py-3 px-6">
                                @php
                                    $role = $user->role->name ?? '-';
                                    $roleColor = match($role) {
                                        'Admin' => 'bg-blue-100 text-blue-700',
                                        'HR' => 'bg-purple-100 text-purple-700',
                                        'Employee' => 'bg-yellow-100 text-yellow-700',
                                        default => 'bg-gray-100 text-gray-700',
                                    };
                                @endphp
                                <span class="inline-block px-3 py-1 rounded-full {{ $roleColor }} text-xs font-semibold">
                                    {{ $role }}
                                </span>
                            </td>
                            <td class="py-3 px-6">
                            @if(in_array($user->role->name ?? '', ['Admin', 'HR']))
                                <span class="text-gray-800 text-base">-</span>
                            @elseif($user->status === 'Aktif')
                                <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full bg-green-100 text-green-700 text-xs font-semibold shadow-sm">
                                    <svg class="w-4 h-4 text-green-500" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24"><path d="M5 13l4 4L19 7"/></svg>
                                    Aktif
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full bg-red-100 text-red-700 text-xs
                                    <svg class="w-4 h-4 text-red-500" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24"><path d="M6 18L18 6M6 6l12 12"/></svg>
                                    Nonaktif
                                </span>
                            @endif
                            </td>
                            <td class="py-3 px-6">
                                {{ \Carbon\Carbon::parse($user->created_at)->format('d M Y H:i') }}
                            </td>
                            <td class="py-3 px-6 flex justify-center gap-2">
                            @if(in_array($user->role->name ?? '', ['Admin', 'HR']))
                                <span class="text-gray-800 text-base">-</span>
                            @else
                                <a href="#" title="Edit"
                                class="rounded-lg transition p-1"
                                >
                                    <img src="{{ asset('img/action/edit.webp') }}" alt="Edit" class="w-5 h-5 object-contain hover:scale-105 transition-transform"/>
                                </a>
                                <a href="#" title="Hapus"
                                class="rounded-lg transition p-1"
                                >
                                    <img src="{{ asset('img/action/delete.webp') }}" alt="Hapus" class="w-5 h-5 object-contain hover:scale-105 transition-transform"/>
                                </a>
                            @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="py-6 text-center text-gray-800">Tidak ada user ditemukan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
