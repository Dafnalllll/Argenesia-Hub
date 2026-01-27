<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\TipeCuti;
use App\Models\PengajuanCuti;
use App\Models\AktivitasAdmin; // Tambahkan di atas

class AturTipeCuti extends Component
{
    public $nama_cuti;
    public $maksimal_hari;
    public $filterKategori = '';

    public function simpan()
    {
        $this->validate([
            'nama_cuti' => 'required|string|max:100',
            'maksimal_hari' => 'required|integer|min:1',
        ]);

        TipeCuti::create([
            'nama_cuti' => $this->nama_cuti,
            'maksimal_hari' => $this->maksimal_hari,
        ]);

        AktivitasAdmin::create([
            'tanggal' => now(),
            'aktivitas' => 'Tambah Tipe Cuti',
            'keterangan' => 'Menambahkan tipe cuti: ' . $this->nama_cuti,
        ]);

        $this->reset(['nama_cuti', 'maksimal_hari']);
        session()->flash('success', 'Tipe cuti berhasil ditambahkan!');

        // Ganti emit dengan dispatch
        $this->dispatch('aktivitasAdminUpdated');
    }

    public function incrementHari()
    {
        $this->maksimal_hari = ($this->maksimal_hari ?? 0) + 1;
    }

    public function decrementHari()
    {
        $this->maksimal_hari = max(1, ($this->maksimal_hari ?? 1) - 1);
    }

    public function render()
    {
        $kategoriList = TipeCuti::pluck('nama_cuti')->toArray();

        $query = PengajuanCuti::query();
        if ($this->filterKategori) {
            $query->where('kategori', $this->filterKategori);
        }
        // ...filter lain...

        return view('livewire.admin.manajemen-cuti.atur-tipe-cuti', [
            'riwayatCuti' => $query->latest()->get(),
            'kategoriList' => $kategoriList,
            'filterKategori' => $this->filterKategori,
            // ...filter lain...
        ]);
    }
}
