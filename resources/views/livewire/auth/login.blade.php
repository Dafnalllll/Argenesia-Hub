<!-- filepath: d:\Dafa Code\projek-pkl\resources\views\livewire\auth\login.blade.php -->
@section('title', 'Login || Argenesia Hub')
<div class="min-h-screen flex items-center justify-center">
    <div class="flex flex-col md:flex-row bg-white/30 backdrop-blur-lg border border-white/30 rounded-lg shadow-lg max-w-3xl w-full p-0 md:p-8">
        <!-- Logo (Mobile: Atas, Desktop: Kanan) -->
        <div class="flex-1 flex items-center justify-center p-8 border-b md:border-b-0 md:border-l border-white/30 order-1 md:order-2">
            <div>
                <img src="{{ asset('argenesiahub.webp') }}" alt="Logo" class="w-32 h-32 md:w-56 md:h-56 mx-auto md:ml-12 cursor-pointer hover:scale-105 transition-transform" />
            </div>
        </div>
        <!-- Form Login (Mobile: Bawah, Desktop: Kiri) -->
        <form wire:submit.prevent="login"
            class="flex-1 space-y-4 w-full md:w-1/2 p-8 order-2 md:order-1 mx-auto"
        >
            <h2 class="text-2xl font-bold text-center mb-6 bg-linear-to-r from-[#F53003] to-[#0074D9] text-transparent bg-clip-text">
                Login
            </h2>

            <!-- Email/Username Input -->
            <div class="relative mb-6">
                <span class="absolute inset-y-0 left-3 flex items-center">
                    <img src="{{ asset('img/auth/email.webp') }}" alt="Email" class="w-6 h-6 opacity-70" />
                </span>
                <input type="email" wire:model="email" placeholder="Email"
                    class="w-full border rounded pl-12 pr-3 py-2 focus:outline-none focus:ring-2 focus:ring-[#F53003] transition" />
                @error('email')
                    <span class="absolute left-0 -bottom-5 text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <!-- Password Input -->
            <div class="relative mb-6">
                <span class="absolute inset-y-0 left-3 flex items-center">
                    <img src="{{ asset('img/auth/password.webp') }}" alt="Password" class="w-6 h-6 opacity-70" />
                </span>
                <input type="{{ $showPassword ? 'text' : 'password' }}" wire:model="password" placeholder="Password"
                    class="w-full border rounded pl-12 pr-10 py-2 focus:outline-none focus:ring-2 focus:ring-[#0074D9] transition" />
                <span class="absolute inset-y-0 right-3 flex items-center cursor-pointer"
                    wire:click="$toggle('showPassword')">
                    <div class="relative w-6 h-6">
                        <img src="{{ asset('img/auth/eye.webp') }}" alt="Show Password" class="w-6 h-6 opacity-70 hover:opacity-100 transition" />
                        @if(!$showPassword)
                            <!-- Garis diagonal di atas ikon eye -->
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

            <label class="inline-flex items-center">
                <input type="checkbox" wire:model="remember" class="mr-2"> Remember me
            </label>

            <div>
                <button type="submit"
                    class="w-full bg-linear-to-r from-[#F53003] to-[#0074D9] text-white py-2 rounded-full hover:scale-105 hover:from-[#d42a02] hover:to-[#005fa3] transition-all cursor-pointer flex items-center justify-center relative"
                    wire:loading.attr="disabled">
                    <span wire:loading.remove>
                        Login
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
                <a href="{{ route('register') }}"
                    class="text-[#F53003] hover:underline hover:decoration-[#0074D9] decoration-2 transition">
                    Belum punya akun? Register
                </a>
            </div>
        </form>
    </div>
</div>
