<?php

namespace App\Livewire\Dashboard\Cuti;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\TipeCuti;
use App\Models\PengajuanCuti;
use App\Models\Aktivitas as AktivitasModel;
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

    // Tambahan untuk edit
    public $isEdit = false;
    public $editId = null;
    public $file_pengajuan_lama = null;

    public $initialData = [];

    // Terima $id dari route jika edit
    public function mount($id = null)
    {
        $this->tipeCutis = TipeCuti::all();

        if ($id) {
            $this->isEdit = true;
            $this->editId = $id;
            $pengajuan = PengajuanCuti::findOrFail($id);

            $this->tipe_cuti_id = $pengajuan->tipe_cuti_id;
            $this->tanggal_mulai = $pengajuan->tanggal_mulai;
            $this->tanggal_selesai = $pengajuan->tanggal_selesai;
            $this->keterangan = $pengajuan->keterangan;
            $this->maksimal_hari = $pengajuan->tipeCuti->maksimal_hari ?? null;
            $this->file_pengajuan_lama = $pengajuan->file_pengajuan;

            // Simpan data awal
            $this->initialData = [
                'tipe_cuti_id' => $pengajuan->tipe_cuti_id,
                'tanggal_mulai' => $pengajuan->tanggal_mulai,
                'tanggal_selesai' => $pengajuan->tanggal_selesai,
                'keterangan' => $pengajuan->keterangan,
                'file_pengajuan_lama' => $pengajuan->file_pengajuan,
            ];
        }
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

        // Validasi dinamis
        if ($this->isEdit) {
            $rules = [
                'tipe_cuti_id' => 'nullable|exists:tipe_cutis,id',
                'tanggal_mulai' => 'nullable|date',
                'tanggal_selesai' => 'nullable|date|after_or_equal:tanggal_mulai',
                'keterangan' => 'nullable|string|max:255',
                'file_upload' => 'nullable|file|mimes:pdf|max:5120',
            ];
        } else {
            $rules = [
                'tipe_cuti_id' => 'required|exists:tipe_cutis,id',
                'tanggal_mulai' => 'required|date',
                'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
                'keterangan' => 'required|string|max:255',
                'file_upload' => 'required|file|mimes:pdf|max:5120',
            ];
        }

        $this->validate($rules);

        // Ambil data lama jika field kosong saat edit
        if ($this->isEdit && $this->editId) {
            $pengajuan = PengajuanCuti::findOrFail($this->editId);

            $pengajuan->update([
                'tipe_cuti_id' => $this->tipe_cuti_id ?: $pengajuan->tipe_cuti_id,
                'tanggal_mulai' => $this->tanggal_mulai ?: $pengajuan->tanggal_mulai,
                'tanggal_selesai' => $this->tanggal_selesai ?: $pengajuan->tanggal_selesai,
                'keterangan' => $this->keterangan ?: $pengajuan->keterangan,
                'file_pengajuan' => $this->file_upload
                    ? $this->file_upload->store('pengajuan_cuti_files', 'public')
                    : $pengajuan->file_pengajuan,
            ]);

            AktivitasModel::create([
                'user_id' => Auth::id(),
                'tanggal' => now(),
                'aktivitas' => 'Update Pengajuan Cuti',
                'keterangan' => 'Update cuti: ' . TipeCuti::find($pengajuan->tipe_cuti_id)?->nama_cuti,
            ]);

            session()->flash('success', 'Pengajuan cuti berhasil diperbarui!');
        } else {
            PengajuanCuti::create([
                'user_id' => Auth::id(),
                'karyawan_id' => $karyawan->id,
                'tipe_cuti_id' => $this->tipe_cuti_id,
                'tanggal_mulai' => $this->tanggal_mulai,
                'tanggal_selesai' => $this->tanggal_selesai,
                'keterangan' => $this->keterangan,
                'status' => 'Menunggu',
                'file_pengajuan' => $this->file_upload
                    ? $this->file_upload->store('pengajuan_cuti_files', 'public')
                    : null,
            ]);

            AktivitasModel::create([
                'user_id' => Auth::id(),
                'tanggal' => now(),
                'aktivitas' => 'Pengajuan Cuti',
                'keterangan' => 'Berhasil mengajukan cuti: ' . TipeCuti::find($this->tipe_cuti_id)?->nama_cuti,
            ]);

            session()->flash('success', 'Pengajuan cuti berhasil diajukan!');
        }

        if ($this->isEdit && $this->editId) {
            // JANGAN RESET FORM DI SINI!
            // $this->reset([...]);
        } else {
            $this->reset(['tipe_cuti_id', 'tanggal_mulai', 'tanggal_selesai', 'keterangan', 'file_upload', 'file_pengajuan_lama', 'isEdit', 'editId']);
        }
    }

    public function resetForm()
    {
        if ($this->isEdit && $this->editId) {
            // Ambil data terbaru dari database
            $pengajuan = PengajuanCuti::find($this->editId);
            if ($pengajuan) {
                $this->tipe_cuti_id = $pengajuan->tipe_cuti_id;
                $this->tanggal_mulai = $pengajuan->tanggal_mulai;
                $this->tanggal_selesai = $pengajuan->tanggal_selesai;
                $this->keterangan = $pengajuan->keterangan;
                $this->file_upload = null;
                $this->file_pengajuan_lama = $pengajuan->file_pengajuan;
            }
        } else {
            // Reset ke kosong (mode tambah)
            $this->tipe_cuti_id = '';
            $this->tanggal_mulai = '';
            $this->tanggal_selesai = '';
            $this->keterangan = '';
            $this->file_upload = null;
            $this->file_pengajuan_lama = null;
        }
    }

    public function render()
    {
        return view('livewire.karyawan.dashboard.cuti.pengajuan', [
            'tipeCutis' => $this->tipeCutis,
            'isEdit' => $this->isEdit,
            'file_pengajuan_lama' => $this->file_pengajuan_lama,
        ]);
    }
}

