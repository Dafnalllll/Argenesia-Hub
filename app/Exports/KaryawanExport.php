<?php

namespace App\Exports;

use App\Models\Karyawan;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class KaryawanExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Karyawan::with(['user.role'])
            ->where('status_karyawan', 'Aktif') // hanya yang Aktif
            ->get()
            ->map(function ($karyawan, $i) {
                return [
                    $i+1,
                    $karyawan->user->name ?? '-',
                    $karyawan->user->email ?? '-',
                    $karyawan->user->role->name ?? '-',
                    $karyawan->kode_karyawan,
                    $karyawan->status_karyawan,
                    $karyawan->tanggal_masuk,
                    $karyawan->alamat,
                ];
            });
    }

    public function headings(): array
    {
        return [
            'No', 'Nama', 'Email', 'Role', 'Kode Karyawan', 'Status', 'Tanggal Masuk', 'Alamat'
        ];
    }
}
