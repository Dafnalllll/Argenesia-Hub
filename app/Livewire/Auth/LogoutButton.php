<?php

namespace App\Livewire\Auth;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use App\Models\Aktivitas;
use App\Models\AktivitasAdmin;
use App\Models\AktivitasHR;

class LogoutButton extends Component
{
    public function logout()
    {
        Aktivitas::create([
            'user_id' => Auth::id(),
            'tanggal' => now(),
            'aktivitas' => 'Logout',
            'keterangan' => 'User logout',
        ]);

        AktivitasAdmin::create([
            'tanggal' => now(),
            'aktivitas' => 'Logout',
            'keterangan' => 'Admin logout',
        ]);

        AktivitasHR::create([
            'tanggal' => now(),
            'aktivitas' => 'Logout',
            'keterangan' => 'HR logout',
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
