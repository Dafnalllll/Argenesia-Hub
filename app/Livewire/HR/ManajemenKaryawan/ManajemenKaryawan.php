<?php

namespace App\Livewire\HR\ManajemenKaryawan;

use Livewire\Component;
use App\Models\Karyawan; // pastikan modelnya benar

class ManajemenKaryawan extends Component
{
    public function render()
    {
        $karyawans = Karyawan::with(['user', 'user.role'])->get();

        return view('livewire.hr.manajemen-karyawan.manajemen-karyawan', [
            'karyawans' => $karyawans
        ]);
    }
}
