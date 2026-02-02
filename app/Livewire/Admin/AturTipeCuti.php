<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\TipeCuti;
use App\Models\PengajuanCuti;
use App\Models\AktivitasAdmin;
use Illuminate\Support\Facades\Auth;

class AturTipeCuti extends Component
{
    public $editId = null;
    public $nama_cuti, $maksimal_hari;
    public $filterKategori = '';

    public function mount($id = null)
    {
        if ($id) {
            $tipe = TipeCuti::findOrFail($id);
            $this->nama_cuti = $tipe->nama_cuti;
            $this->maksimal_hari = $tipe->maksimal_hari;
            // Simpan id jika perlu update
            $this->editId = $id;
        }
    }

    public function edit($id)
    {
        $tipe = TipeCuti::findOrFail($id);
        $this->editId = $id;
        $this->nama_cuti = $tipe->nama_cuti;
        $this->maksimal_hari = $tipe->maksimal_hari;
    }

    public function simpan()
    {
        $this->validate([
            'nama_cuti' => 'required|string|max:100',
            'maksimal_hari' => 'required|integer|min:1',
        ]);

        if ($this->editId) {
            $tipe = TipeCuti::findOrFail($this->editId);
            $tipe->update([
                'nama_cuti' => $this->nama_cuti,
                'maksimal_hari' => $this->maksimal_hari,
            ]);
            session()->flash('success', 'Tipe cuti berhasil diperbarui!');

            // Catat aktivitas update
            AktivitasAdmin::create([
                'user_id' => Auth::id(),
                'tanggal' => now(),
                'aktivitas' => 'Update Tipe Cuti',
                'keterangan' => 'Memperbarui tipe cuti: ' . $this->nama_cuti,
            ]);
        } else {
            TipeCuti::create([
                'nama_cuti' => $this->nama_cuti,
                'maksimal_hari' => $this->maksimal_hari,
            ]);
            session()->flash('success', 'Tipe cuti berhasil ditambahkan!');

            // Catat aktivitas tambah
            AktivitasAdmin::create([
                'user_id' => Auth::id(),
                'tanggal' => now(),
                'aktivitas' => 'Tambah Tipe Cuti',
                'keterangan' => 'Menambah tipe cuti: ' . $this->nama_cuti,
            ]);

            $this->reset(['editId', 'nama_cuti', 'maksimal_hari']);
        }

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

    public function resetEdit()
    {
        if ($this->editId) {
            $tipe = TipeCuti::find($this->editId);
            if ($tipe) {
                $this->nama_cuti = $tipe->nama_cuti;
                $this->maksimal_hari = $tipe->maksimal_hari;
            }
        } else {
            $this->nama_cuti = '';
            $this->maksimal_hari = '';
        }
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
