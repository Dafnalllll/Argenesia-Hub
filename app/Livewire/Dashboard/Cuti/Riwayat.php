<?php

namespace App\Livewire\Dashboard\Cuti;

use Livewire\Component;
use App\Models\Cuti;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\RiwayatCutiExport;

class Riwayat extends Component
{
    public $filterStatus = '';
    public $filterKategori = '';

    public function render()
    {
        $query = Cuti::query();

        if ($this->filterStatus) {
            $query->where('status', $this->filterStatus);
        }
        if ($this->filterKategori) {
            $query->where('kategori', $this->filterKategori);
        }

        return view('livewire.karyawan.dashboard.cuti.riwayat', [
            'riwayatCuti' => $query->latest()->get(),
        ]);
    }

    public function exportExcel()
    {
        return Excel::download(new RiwayatCutiExport($this->filterStatus, $this->filterKategori), 'riwayat-cuti.xlsx');
    }
}
