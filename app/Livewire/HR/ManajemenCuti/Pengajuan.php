<?php

namespace App\Livewire\HR\ManajemenCuti;

use Livewire\Component;
use App\Models\PengajuanCuti;
use App\Models\AktivitasHR;

class Pengajuan extends Component
{
    public function render()
    {
        $cutis = PengajuanCuti::with(['karyawan.user', 'tipeCuti'])->get();
        $tipeCutis = \App\Models\TipeCuti::all(); // jika view butuh tipe cuti

        return view('livewire.hr.manajemen-cuti.pengajuan-cuti', [
            'cutis' => $cutis,
            'tipeCutis' => $tipeCutis,
        ]);
    }

    public function changeStatus($id, $status)
    {
        $cuti = PengajuanCuti::findOrFail($id);
        $cuti->status = $status;
        $cuti->save();

        // Catat aktivitas HR
        AktivitasHR::create([
            'tanggal' => now(),
            'aktivitas' => 'Update Status',
            'keterangan' => 'Status pengajuan cuti ' . ($cuti->karyawan->user->name ?? '-') . ' diubah menjadi ' . $status,
        ]);

        // Beri notifikasi sukses
        session()->flash('success', 'Status pengajuan cuti berhasil diubah menjadi ' . $status);

        // Refresh tabel aktivitas HR jika pakai Livewire event
        $this->dispatch('aktivitasHRUpdated');

        return ['status' => $cuti->status];
    }
}
