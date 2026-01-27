<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\Karyawan;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\KaryawanExport;

class ManajemenKaryawan extends Component
{
    public $search = '';

    public function render()
    {
        $karyawans = $this->getKaryawansProperty();

        return view('livewire.admin.manajemen-karyawan.manajemen-karyawan', [
            'karyawans' => $karyawans
        ]);
    }

    public function getKaryawansProperty()
    {
        return Karyawan::with(['user.role'])
            ->where('status_karyawan', 'Aktif') // hanya yang aktif
            ->when($this->search, function ($query) {
                $query->whereHas('user', function ($q) {
                    $q->where('name', 'like', "%{$this->search}%")
                    ->orWhere('email', 'like', "%{$this->search}%");
                });
            })
            ->get();
    }
    public function resetSearch()
    {
        $this->search = '';
    }
    public function exportCsv() { /* ... */ }
    public function exportPdf()
    {
        $karyawans = $this->getKaryawansProperty();
        $pdf = Pdf::loadView('exports.karyawan-pdf', ['karyawans' => $karyawans]);
        return response()->streamDownload(
            fn () => print($pdf->output()),
            'karyawan.pdf'
        );
    }

    public function exportExcel()
    {
        return Excel::download(new KaryawanExport, 'karyawan.xlsx');
    }
}
