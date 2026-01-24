<button type="button"
    wire:click="logout"
    class="w-full flex items-center px-3 py-2 rounded-lg text-white transition text-left relative cursor-pointer
    hover:bg-white group mt-4">
    <img src="{{ asset('img/auth/logout.webp') }}" alt="Logout" class="w-5 h-5" />
    <span class="ml-4 group-hover:bg-linear-to-r group-hover:from-[#F53003] group-hover:to-[#0074D9] group-hover:bg-clip-text group-hover:text-transparent transition">
        Logout
    </span>
</button>
