{{-- filepath: d:\Dafa Code\projek-pkl\resources\views\components\sidebar.blade.php --}}
<aside class="fixed top-0 left-0 sidebar-glass h-screen w-56 bg-linear-to-b from-[#F53003]/70 to-[#0074D9]/70 shadow-lg flex flex-col py-8 px-4 backdrop-blur-md bg-opacity-60 rounded-r-4xl">
    <div class="mb-10 text-center">
        <img src="{{ asset('argenesiahub.webp') }}" alt="Logo" class="mx-auto w-16 h-16 hover:scale-105 transition-all cursor-pointer" />
    </div>
    @php
        // Hitung jumlah user nonaktif untuk badge notifikasi
        $jumlahUserNonaktif = \App\Models\User::where('status', 'Nonaktif')->count();
    @endphp
    <nav class="flex-1">
        @if(strtolower(Auth::user()->role->name) == 'admin')
            {{-- Sidebar untuk Admin --}}
            <ul class="space-y-12">
                <li>
                    <a href="/dashboard/admin"
                        class="group flex items-center px-3 py-2 rounded-lg transition relative
                        {{ request()->is('dashboard/admin') ? 'bg-white text-[#F53003] shadow-md' : 'text-white hover:bg-white hover:text-[#F53003]' }}">
                        <img src="{{ asset('img/sidebar/dashboard.webp') }}" alt="Dashboard" class="w-5 h-5" />
                        <span class="ml-4">Dashboard</span>
                        @if(request()->is('dashboard/admin'))
                            <span class="absolute left-0 top-0 h-full w-1 bg-[#F53003] rounded-r-lg shadow-lg transition-all"></span>
                        @endif
                    </a>
                </li>
                <li>
                    <a href="/admin/manajemen-user"
                        class="group flex items-center px-3 py-2 rounded-lg transition relative
                        {{ request()->is('admin/manajemen-user') ? 'bg-white text-[#0074D9] shadow-md' : 'text-white hover:bg-white hover:text-[#0074D9]' }}">
                        <span class="relative">
                            <img src="{{ asset('img/sidebar/profil.webp') }}" alt="Kategori" class="w-5 h-5" />
                            @if($jumlahUserNonaktif > 0)
                                <span class="absolute -top-2 -right-2 inline-flex items-center justify-center px-1.5 py-0.5 rounded-full text-xs font-bold bg-red-500 text-white animate-bounce z-10">
                                    {{ $jumlahUserNonaktif }}
                                </span>
                            @endif
                        </span>
                        <span class="ml-4 flex items-center">
                            Manajemen <span class="text-blue-400 ml-1">User</span>
                        </span>
                        @if(request()->is('admin/manajemen-user'))
                            <span class="absolute left-0 top-0 h-full w-1 bg-[#0074D9] rounded-r-lg shadow-lg transition-all"></span>
                        @endif
                    </a>
                </li>
                <li>
                    <a href="/admin/manajemen-karyawan"
                        class="group flex items-center px-3 py-2 rounded-lg transition relative
                        {{ request()->is('admin/manajemen-karyawan') ? 'bg-white text-[#F53003] shadow-md' : 'text-white hover:bg-white hover:text-[#F53003]' }}">
                        <img src="{{ asset('img/sidebar/karyawan.webp') }}" alt="Kategori" class="w-5 h-5" />
                        <span class="ml-4 ">Manajemen Karyawan</span>
                        @if(request()->is('admin/manajemen-karyawan'))
                            <span class="absolute left-0 top-0 h-full w-1 bg-[#F53003] rounded-r-lg shadow-lg transition-all"></span>
                        @endif
                    </a>
                </li>
                <li>
                    <div class="flex items-center px-3 py-2 rounded-lg transition relative
                        {{ request()->is('admin/manajemen-cuti') ? 'bg-white text-[#0074D9] shadow-md' : 'text-white hover:bg-white hover:text-[#0074D9]' }}">
                        <img src="{{ asset('img/cuti/cuti.webp') }}" alt="Kategori" class="w-5 h-5" />
                        <a href="/admin/manajemen-cuti" class="flex items-center flex-1 focus:outline-none">
                            <span class="ml-4">Manajemen Cuti</span>
                        </a>
                        <button type="button"
                            onclick="document.getElementById('cuti-admin-dropdown').classList.toggle('hidden'); document.getElementById('cuti-admin-arrow').classList.toggle('rotate-180');"
                            class="ml-2 focus:outline-none cursor-pointer rounded-lg transition
                            {{ request()->is('admin/manajemen-cuti*') && !request()->is('admin/manajemen-cuti') ? 'bg-white' : '' }} hover:bg-white group flex items-center justify-center p-1">
                            <svg id="cuti-admin-arrow" class="w-4 h-4 transition-transform {{ request()->is('admin/manajemen-cuti*') && !request()->is('admin/manajemen-cuti') ? 'rotate-180' : '' }}" fill="none" stroke="#0074D9" stroke-width="2" viewBox="0 0 24 24"><path d="M19 9l-7 7-7-7"/></svg>
                        </button>
                        @if(request()->is('admin/manajemen-cuti') || request()->is('admin/manajemen-cuti/*'))
                            <span class="absolute left-0 top-0 h-full w-1 bg-[#0074D9] rounded-r-lg shadow-lg transition-all"></span>
                        @endif
                    </div>
                    <ul id="cuti-admin-dropdown" class="ml-8 mt-1 space-y-1 {{ request()->is('admin/manajemen-cuti*') && !request()->is('admin/manajemen-cuti') ? '' : 'hidden' }}">
                        <li>
                            <a href="/admin/manajemen-cuti/atur-tipe-cuti"
                                class="block px-3 py-2 rounded-lg transition
                                {{ request()->is('admin/manajemen-cuti/atur-tipe-cuti') ? 'bg-white text-[#F53003]' : 'text-white hover:bg-white hover:text-[#F53003]' }}">
                                <img src="{{ asset('img/cuti/kategori.webp') }}" alt="Kategori" class="w-5 h-5 inline mr-2" />
                                Atur Tipe Cuti
                            </a>
                        </li>
                        <li>
                            <a href="/admin/manajemen-cuti/rekap-cuti"
                                class="block px-3 py-2 rounded-lg transition
                                {{ request()->is('admin/manajemen-cuti/rekap-cuti') ? 'bg-white text-[#F53003]' : 'text-white hover:bg-white hover:text-[#F53003]' }}">
                                <img src="{{ asset('img/sidebar/rekap.webp') }}" alt="Rekap" class="w-5 h-5 inline mr-2" />
                                Rekap Cuti
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
        @else
            {{-- Sidebar untuk User/Employee --}}
            <ul class="space-y-12">
                <li>
                    <a href="/dashboard" class="group flex items-center px-3 py-2 rounded-lg transition relative
                        {{ request()->is('dashboard') ? 'bg-white text-[#F53003] shadow-md' : 'text-white hover:bg-white hover:text-[#F53003]' }}">
                        <img src="{{ asset('img/sidebar/dashboard.webp') }}" alt="Dashboard" class="w-5 h-5" />
                        <span class="ml-4">Dashboard</span>
                        @if(request()->is('dashboard'))
                            <span class="absolute left-0 top-0 h-full w-1 bg-[#F53003] rounded-r-lg shadow-lg transition-all"></span>
                        @endif
                    </a>
                </li>
                <li>
                    <a href="/profil" class="group flex items-center px-3 py-2 rounded-lg transition relative
                        {{ request()->is('profil') ? 'bg-white text-[#0074D9] shadow-md' : 'text-white hover:bg-white hover:text-[#0074D9]' }}">
                        <img src="{{ asset('img/sidebar/profil.webp') }}" alt="Profil" class="w-5 h-5" />
                        <span class="ml-4">Profil</span>
                        @if(request()->is('profil'))
                            <span class="absolute left-0 top-0 h-full w-1 bg-[#0074D9] rounded-r-lg shadow-lg transition-all"></span>
                        @endif
                    </a>
                </li>
                <li>
                    @php
                        $cutiActive = request()->is('cuti') || request()->is('cuti/*');
                    @endphp
                    <div class="flex items-center px-3 py-2 rounded-lg transition relative
                        {{ $cutiActive ? 'bg-white text-[#F53003] shadow-md' : 'text-white hover:bg-white hover:text-[#F53003]' }}">
                        <a href="/cuti" class="flex items-center flex-1 focus:outline-none">
                            <img src="{{ asset('img/cuti/cuti.webp') }}" alt="Cuti" class="w-6 h-6" />
                            <span class="ml-4">Cuti</span>
                        </a>
                        <button type="button"
                            onclick="document.getElementById('cuti-dropdown').classList.toggle('hidden'); document.getElementById('cuti-arrow').classList.toggle('rotate-180');"
                            class="ml-2 focus:outline-none cursor-pointer rounded-lg transition
                            {{ $cutiActive ? 'bg-white' : '' }} hover:bg-white group flex items-center justify-center p-1">
                            <svg id="cuti-arrow" class="w-4 h-4 transition-transform {{ request()->is('cuti*') && !request()->is('cuti') ? 'rotate-180' : '' }}" fill="none" stroke="#F53003" stroke-width="2" viewBox="0 0 24 24"><path d="M19 9l-7 7-7-7"/></svg>
                        </button>
                        @if($cutiActive)
                            <span class="absolute left-0 top-0 h-full w-1 bg-[#F53003] rounded-r-lg shadow-lg transition-all"></span>
                        @endif
                    </div>
                    <ul id="cuti-dropdown" class="ml-8 mt-1 space-y-1 {{ request()->is('cuti*') && !request()->is('cuti') ? '' : 'hidden' }}">
                        <li>
                            <a href="/cuti/pengajuan"
                                class="block px-3 py-2 rounded-lg transition
                                {{ request()->is('cuti/pengajuan') ? 'bg-white text-[#0074D9]' : 'text-white hover:bg-white hover:text-[#0074D9]' }}">
                                <img src="{{ asset('img/cuti/pengajuan.webp') }}" alt="Pengajuan" class="inline w-5 h-5 mr-2 align-middle"/>
                                Pengajuan
                            </a>
                        </li>
                        <li>
                            <a href="/cuti/riwayat"
                                class="block px-3 py-2 rounded-lg transition
                                {{ request()->is('cuti/riwayat') ? 'bg-white text-[#0074D9]' : 'text-white hover:bg-white hover:text-[#0074D9]' }}">
                                <img src="{{ asset('img/cuti/riwayat.webp') }}" alt="Riwayat" class="inline w-5 h-5 mr-2 align-middle"/>
                                Riwayat
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
        @endif
    </nav>
    {{-- Logout Button --}}
    @livewire('auth.logout-button')

    <div class="mt-8 text-center text-xs text-white opacity-70 select-none">
        &copy; {{ date('Y') }} Argenesia Hub. All rights reserved.
    </div>
</aside>

