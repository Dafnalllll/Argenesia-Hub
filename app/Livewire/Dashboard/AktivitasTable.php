<?php

namespace App\Livewire\Dashboard;

use Livewire\Component;
use App\Models\Aktivitas as AktivitasModel;

class AktivitasTable extends Component
{
    public function render()
    {
        $aktivitas = AktivitasModel::orderBy('tanggal', 'desc')->limit(5)->get();
        return view('livewire.Karyawan.aktivitas-table', compact('aktivitas'));
    }
}
