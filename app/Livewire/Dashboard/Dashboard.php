<?php

namespace App\Livewire\Dashboard;

use Livewire\Component;
use App\Models\PengajuanCuti;
use Illuminate\Support\Facades\Auth;
use App\Models\Aktivitas as AktivitasModel; // Tambahkan di atas jika belum

class Dashboard extends Component
{
    public function render()
    {
        $user = Auth::user();
        $karyawan = $user->karyawan;

        $totalPengajuan = PengajuanCuti::where('user_id', $user->id)->count();

        $pengajuanTerbaru = PengajuanCuti::where('user_id', $user->id)
            ->orderByDesc('created_at')
            ->with('tipeCuti')
            ->limit(5)
            ->get();

        $jumlahCutiDisetujui = PengajuanCuti::where('user_id', $user->id)
            ->where('status', 'Disetujui')
            ->count();

        // Saldo cuti hanya berlaku jika status_karyawan 'Aktif'
        $saldoCuti = ($karyawan && $karyawan->status_karyawan === 'Aktif') ? $karyawan->saldo_cuti : 0;

        // Sisa cuti juga hanya berlaku jika aktif
        $sisaCuti = ($karyawan && $karyawan->status_karyawan === 'Aktif')
            ? ($saldoCuti - $jumlahCutiDisetujui)
            : 0;

        return view('livewire.karyawan.dashboard.dashboard', [
            'totalPengajuan' => $totalPengajuan,
            'pengajuanTerbaru' => $pengajuanTerbaru,
            'jumlahCutiDisetujui' => $jumlahCutiDisetujui,
            'sisaCuti' => $sisaCuti,
        ]);
    }

    public $showDeleteModal = false;
    public $deleteId = null;

    public function confirmDelete($id)
    {
        $this->deleteId = $id;
        $this->showDeleteModal = true;
    }

    public function deletePengajuan()
    {
        if ($this->deleteId) {
            $pengajuan = PengajuanCuti::find($this->deleteId);
            if ($pengajuan && $pengajuan->user_id == Auth::id()) {
                $pengajuan->delete();

                // Catat aktivitas hapus pengajuan cuti
                AktivitasModel::create([
                    'user_id' => Auth::id(),
                    'tanggal' => now(),
                    'aktivitas' => 'Hapus Pengajuan Cuti',
                    'keterangan' => 'Menghapus pengajuan cuti tipe: ' . ($pengajuan->tipeCuti->nama_cuti ?? '-'),
                ]);

                session()->flash('success', 'Pengajuan cuti berhasil dihapus!');
            }
        }
        $this->showDeleteModal = false;
        $this->deleteId = null;
    }
}
