<?php

namespace App\Livewire\Auth;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use App\Models\Aktivitas;

class LogoutButton extends Component
{
    public function logout()
    {
        Aktivitas::create([
            'tanggal' => now()->toDateString(),
            'aktivitas' => 'Logout',
            'keterangan' => 'User logout pada ' . now()->format('H:i:s'),
        ]);

        Auth::logout();
        session()->invalidate();
        session()->regenerateToken();

        // Livewire v3: gunakan dispatch, bukan dispatchBrowserEvent
        $this->dispatch('redirectToLogin');
    }

    public function render()
    {
        return view('livewire.auth.logout-button');
    }
}
