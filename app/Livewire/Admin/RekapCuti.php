<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\TipeCuti;
use App\Models\PengajuanCuti;
use App\Exports\RekapCutiExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Response;
use Barryvdh\DomPDF\Facade\Pdf;

class RekapCuti extends Component
{
    public function render()
    {
        return view('livewire.admin.manajemen-cuti.rekap-cuti', [
            'cutis' => PengajuanCuti::with(['karyawan.user', 'tipeCuti'])->get(),
            'tipeCutis' => TipeCuti::all(),
            'statusList' => ['Menunggu', 'Disetujui', 'Ditolak'],
        ]);
    }

    public function exportExcel()
    {
        return Excel::download(
            new RekapCutiExport($this->filterBulan, $this->filterTahun),
            'rekap-cuti.xlsx'
        );
    }

    public function exportPdf()
    {
        $query = PengajuanCuti::with(['karyawan.user', 'tipeCuti']);
        if ($this->filterTahun) {
            $query->whereYear('created_at', $this->filterTahun);
        }
        if ($this->filterBulan) {
            $query->whereMonth('created_at', $this->filterBulan);
        }
        $cutis = $query->get();

        $pdf = Pdf::loadView('exports.rekap-cuti-pdf', compact('cutis'));
        return response()->streamDownload(
            fn () => print($pdf->stream()),
            'rekap-cuti.pdf'
        );
    }

    public $filterBulan = '';
    public $filterTahun = '';
}
