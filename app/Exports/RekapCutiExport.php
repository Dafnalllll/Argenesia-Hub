<?php
namespace App\Exports;

use App\Models\PengajuanCuti;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class RekapCutiExport implements FromCollection, WithHeadings
{
    protected $filterBulan, $filterTahun;

    public function __construct($filterBulan = '', $filterTahun = '')
    {
        $this->filterBulan = $filterBulan;
        $this->filterTahun = $filterTahun;
    }

    public function collection()
    {
        $query = PengajuanCuti::with(['karyawan.user', 'tipeCuti']);
        if ($this->filterTahun) {
            $query->whereYear('created_at', $this->filterTahun);
        }
        if ($this->filterBulan) {
            $query->whereMonth('created_at', $this->filterBulan);
        }
        return $query->get()->map(function ($item) {
            return [
                'Nama Karyawan' => $item->karyawan->user->name ?? '-',
                'Tipe' => $item->tipeCuti->nama_cuti ?? '-',
                'Tanggal Pengajuan' => $item->created_at->format('Y-m-d'),
                'Tanggal Mulai' => $item->tanggal_mulai,
                'Tanggal Selesai' => $item->tanggal_selesai,
                'Status' => $item->status,
            ];
        });
    }

    public function headings(): array
    {
        return [
            'Nama Karyawan',
            'Tipe',
            'Tanggal Pengajuan',
            'Tanggal Mulai',
            'Tanggal Selesai',
            'Status',
        ];
    }
}
