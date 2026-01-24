<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\Karyawan;

class ManajemenKaryawan extends Component
{
    public function render()
    {
        // Ambil data karyawan beserta user (nama & email)
        $karyawans = Karyawan::with('user')->get();

        return view('livewire.admin.manajemen-karyawan.manajemen-karyawan', [
            'karyawans' => $karyawans
        ]);
    }
}
