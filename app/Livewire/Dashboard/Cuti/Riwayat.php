<?php

namespace App\Livewire\Dashboard\Cuti;

use Livewire\Component;
use App\Models\PengajuanCuti;
use App\Models\TipeCuti;



class Riwayat extends Component
{
    public $filterStatus = '';
    public $filterKategori = '';

    public function resetFilter()
    {
        $this->filterStatus = '';
        $this->filterKategori = '';
    }

    public function render()
    {
        $tipe_cutis = TipeCuti::pluck('nama_cuti')->toArray();

        $query = PengajuanCuti::query(); // Ganti dari Cuti::query()

        if ($this->filterStatus) {
            $query->where('status', $this->filterStatus);
        }
        if ($this->filterKategori) {
            $query->whereHas('tipeCuti', function($q) {
                $q->where('nama_cuti', $this->filterKategori);
            });
        }

        return view('livewire.karyawan.dashboard.cuti.riwayat', [
            'riwayatCuti' => $query->latest()->with('tipeCuti')->get(),
            'tipe_cutis' => $tipe_cutis,
        ]);
    }
}
