<?php

namespace App\Livewire\HR\ManajemenCuti;

use Livewire\Component;
use App\Models\TipeCuti;
use App\Models\PengajuanCuti;
use Illuminate\Support\Facades\Response;


class RekapCuti extends Component
{
    public $filterBulan = '';
    public $filterTahun = '';

    public function render()
    {
        return view('livewire.hr.manajemen-cuti.rekap-cuti', [
            'cutis' => PengajuanCuti::with(['karyawan.user', 'tipeCuti'])->get(),
            'tipeCutis' => TipeCuti::all(),
            'statusList' => ['Menunggu', 'Disetujui', 'Ditolak'],
        ]);
    }
}
