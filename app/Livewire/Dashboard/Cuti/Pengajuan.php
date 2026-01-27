<?php

namespace App\Livewire\Dashboard\Cuti;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\TipeCuti;
use App\Models\PengajuanCuti;
use App\Models\Aktivitas as AktivitasModel; // Tambahkan di atas
use Illuminate\Support\Facades\Auth;

class Pengajuan extends Component
{
    use WithFileUploads;

    public $tipeCutis = [];
    public $tipe_cuti_id = '';
    public $tanggal_mulai;
    public $tanggal_selesai;
    public $keterangan;
    public $maksimal_hari = null;
    public $file_upload;

    public function mount()
    {
        $this->tipeCutis = TipeCuti::all();
    }

    public function updatedTipeCutiId()
    {
        $tipe = TipeCuti::find($this->tipe_cuti_id);
        $this->maksimal_hari = $tipe ? $tipe->maksimal_hari : null;
        $this->hitungTanggalSelesai();
    }

    public function updatedTanggalMulai()
    {
        $this->hitungTanggalSelesai();
    }

    public function hitungTanggalSelesai()
    {
        if ($this->maksimal_hari && $this->tanggal_mulai) {
            $tanggalMulai = $this->tanggal_mulai;

            // Jika format dd/mm/yyyy, konversi ke yyyy-mm-dd
            if (preg_match('/^\d{2}\/\d{2}\/\d{4}$/', $tanggalMulai)) {
                [$d, $m, $y] = explode('/', $tanggalMulai);
                $tanggalMulai = "$y-$m-$d";
            }

            $this->tanggal_selesai = date('Y-m-d', strtotime($tanggalMulai . ' + ' . ($this->maksimal_hari - 1) . ' days'));
        } else {
            $this->tanggal_selesai = null;
        }
    }

    public function updatedFileUpload()
    {
        $this->validate([
            'file_upload' => 'nullable|file|mimes:pdf|max:5120', // 5MB = 5120KB
        ]);
    }

    public function simpan()
    {
        $user = Auth::user();
        $karyawan = $user->karyawan;

        if (!$karyawan || $karyawan->status_karyawan !== 'Aktif') {
            $this->js('window.dispatchEvent(new CustomEvent("cuti-nonaktif"))');
            return;
        }

        $this->validate([
            'tipe_cuti_id' => 'required|exists:tipe_cutis,id',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
            'keterangan' => 'required|string|max:255',
            'file_upload' => 'required|file|mimes:pdf|max:5120',
        ]);

        if (!$this->tanggal_selesai) {
            $this->hitungTanggalSelesai();
        }

        if (!$this->tanggal_selesai) {
            session()->flash('error', 'Tanggal selesai tidak boleh kosong!');
            return;
        }

        $filePath = null;
        if ($this->file_upload) {
            $filePath = $this->file_upload->store('pengajuan_cuti_files', 'public');
        }

        PengajuanCuti::create([
            'user_id' => Auth::id(),
            'tipe_cuti_id' => $this->tipe_cuti_id,
            'tanggal_mulai' => $this->tanggal_mulai,
            'tanggal_selesai' => $this->tanggal_selesai,
            'keterangan' => $this->keterangan,
            'status' => 'Menunggu',
            'file_pengajuan' => $filePath, // simpan path file di sini
        ]);

        // Tambahkan aktivitas
        AktivitasModel::create([
            'user_id' => Auth::id(),
            'tanggal' => now(),
            'aktivitas' => 'Pengajuan Cuti',
            'keterangan' => 'Berhasil mengajukan cuti: ' . TipeCuti::find($this->tipe_cuti_id)?->nama_cuti,
        ]);

        $this->reset(['tipe_cuti_id', 'tanggal_mulai', 'tanggal_selesai', 'keterangan', 'file_upload']);
        session()->flash('success', 'Pengajuan cuti berhasil disimpan!');
    }

    public function resetForm()
    {
        $this->reset(['tipe_cuti_id', 'tanggal_mulai', 'tanggal_selesai', 'keterangan']);
    }

    public function render()
    {
        return view('livewire.karyawan.dashboard.cuti.pengajuan', [
            'tipeCutis' => $this->tipeCutis
        ]);
    }
}

