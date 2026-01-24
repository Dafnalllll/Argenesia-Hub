<!-- filepath: d:\Dafa Code\projek-pkl\resources\views\livewire\auth\register.blade.php -->
@section('title', 'Register || Argenesia Hub')
<div class="min-h-screen flex items-center justify-center">
    <div class="flex flex-col md:flex-row bg-white/30 backdrop-blur-lg border border-white/30 rounded-lg shadow-lg max-w-3xl w-full p-0 md:p-8">
        <!-- Logo (Mobile: Atas, Desktop: Kiri) -->
        <div class="flex-1 flex items-center justify-center p-8 border-b md:border-b-0 md:border-r border-white/30 order-1">
            <div>
                <img src="{{ asset('argenesiahub.webp') }}" alt="Logo" class="w-32 h-32 md:w-56 md:h-56 mx-auto md:mr-4 cursor-pointer hover:scale-105 transition-transform" />
            </div>
        </div>
        <!-- Form Register (Mobile: Bawah, Desktop: Kanan) -->
        <form wire:submit.prevent="register"
            class="flex-1 space-y-4 w-full md:w-1/2 p-8 order-2"
        >
            <h2 class="text-2xl font-bold text-center mb-6 bg-linear-to-r from-[#F53003] to-[#0074D9] text-transparent bg-clip-text">
                Register
            </h2>
            <!-- Nama -->
            <div class="relative mb-6">
                <span class="absolute inset-y-0 left-3 flex items-center">
                    <img src="{{ asset('img/auth/username.webp') }}" alt="Nama" class="w-6 h-6 opacity-70" />
                </span>
                <input type="text" wire:model="name" placeholder="Nama"
                    class="w-full border rounded pl-12 pr-3 py-2 focus:outline-none focus:ring-2 focus:ring-[#F53003] transition" />
                @error('name')
                    <span class="absolute left-0 -bottom-5 text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <!-- Email -->
            <div class="relative mb-6">
                <span class="absolute inset-y-0 left-3 flex items-center">
                    <img src="{{ asset('img/auth/email.webp') }}" alt="Email" class="w-6 h-6 opacity-70" />
                </span>
                <input type="email" wire:model="email" placeholder="Email"
                    class="w-full border rounded pl-12 pr-3 py-2 focus:outline-none focus:ring-2 focus:ring-[#0074D9] transition" />
                @error('email')
                    <span class="absolute left-0 -bottom-5 text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <!-- Password -->
            <div class="relative mb-6">
                <span class="absolute inset-y-0 left-3 flex items-center">
                    <img src="{{ asset('img/auth/password.webp') }}" alt="Password" class="w-6 h-6 opacity-70" />
                </span>
                <input type="{{ $showPassword ? 'text' : 'password' }}" wire:model="password" placeholder="Password"
                    class="w-full border rounded pl-12 pr-10 py-2 focus:outline-none focus:ring-2 focus:ring-[#F53003] transition" />
                <span class="absolute inset-y-0 right-3 flex items-center cursor-pointer"
                    wire:click="$toggle('showPassword')">
                    <div class="relative w-6 h-6">
                        <img src="{{ asset('img/auth/eye.webp') }}" alt="Show Password" class="w-6 h-6 opacity-70 hover:opacity-100 transition" />
                        @if(!$showPassword)
                            <svg class="absolute inset-0 w-6 h-6 pointer-events-none" viewBox="0 0 24 24">
                                <line x1="4" y1="20" x2="20" y2="4" stroke="#e53e3e" stroke-width="2" stroke-linecap="round"/>
                            </svg>
                        @endif
                    </div>
                </span>
                @error('password')
                    <span class="absolute left-0 -bottom-5 text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <!-- Konfirmasi Password -->
            <div class="relative mb-1">
                <span class="absolute inset-y-0 left-3 flex items-center">
                    <img src="{{ asset('img/auth/password.webp') }}" alt="Konfirmasi Password" class="w-6 h-6 opacity-70" />
                </span>
                <input type="{{ $showPasswordConfirm ? 'text' : 'password' }}" wire:model="password_confirmation" placeholder="Konfirmasi Password"
                    class="w-full border rounded pl-12 pr-10 py-2 focus:outline-none focus:ring-2 focus:ring-[#0074D9] transition" />
                <span class="absolute inset-y-0 right-3 flex items-center cursor-pointer"
                    wire:click="$toggle('showPasswordConfirm')">
                    <div class="relative w-6 h-6">
                        <img src="{{ asset('img/auth/eye.webp') }}" alt="Show Password" class="w-6 h-6 opacity-70 hover:opacity-100 transition" />
                        @if(!$showPasswordConfirm)
                            <svg class="absolute inset-0 w-6 h-6 pointer-events-none" viewBox="0 0 24 24">
                                <line x1="4" y1="20" x2="20" y2="4" stroke="#e53e3e" stroke-width="2" stroke-linecap="round"/>
                            </svg>
                        @endif
                    </div>
                </span>
            </div>
        @error('password_confirmation')
            <span class="block mt-2 text-red-500 text-sm">{{ $message }}</span>
        @enderror

            <div class="mt-4">
                <button type="submit"
                    class="w-full bg-linear-to-r from-[#F53003] to-[#0074D9] text-white py-2 rounded-full hover:scale-105 hover:from-[#d42a02] hover:to-[#005fa3] transition-all cursor-pointer flex items-center justify-center relative"
                    wire:loading.attr="disabled">
                    <span wire:loading.remove>
                        Register
                    </span>
                    <span wire:loading>
                        <svg class="animate-spin h-5 w-5 mr-2 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
                        </svg>
                    </span>
                </button>
            </div>
            <div class="text-center mt-2">
                <a href="{{ route('login') }}" class="text-[#0074D9] hover:underline hover:decoration-[#F53003] decoration-2 transition">
                    Sudah punya akun? Login
                </a>
            </div>
        </form>
    </div>
</div>
