<?php

namespace App\Models;

use App\Models\Karyawan;
use App\Models\TipeCuti;
use Illuminate\Database\Eloquent\Model;

class PengajuanCuti extends Model
{
    protected $fillable = [
        'user_id',
        'karyawan_id', // <-- tambahkan ini!
        'tipe_cuti_id',
        'tanggal_mulai',
        'tanggal_selesai',
        'keterangan',
        'status',
        'file_pengajuan',
    ];

    public function tipeCuti()
    {
        return $this->belongsTo(TipeCuti::class, 'tipe_cuti_id');
    }

    public function karyawan()
    {
        return $this->belongsTo(Karyawan::class, 'karyawan_id');
    }
}
