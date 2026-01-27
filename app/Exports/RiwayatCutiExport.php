<?php

namespace App\Exports;

use App\Models\PengajuanCuti; 
use Maatwebsite\Excel\Concerns\FromCollection;

class RiwayatExport implements FromCollection
{
    protected $status, $kategori;

    public function __construct($status = null, $kategori = null)
    {
        $this->status = $status;
        $this->kategori = $kategori;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $query = PengajuanCuti::query(); // Ganti dari Cuti::query()
        if ($this->status) $query->where('status', $this->status);
        if ($this->kategori) $query->where('kategori', $this->kategori);
        return $query->latest()->get();
    }
}
