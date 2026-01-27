<?php

namespace App\Livewire\Dashboard;

use Livewire\Component;
use App\Models\Aktivitas as AktivitasModel;
use Illuminate\Support\Facades\Auth;

class AktivitasTable extends Component
{
    public function render()
    {
        $aktivitas = AktivitasModel::where('user_id', Auth::id())
            ->orderBy('tanggal', 'desc')
            ->limit(5)
            ->get();
        return view('livewire.Karyawan.aktivitas-table', compact('aktivitas'));
    }
}
