<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Karyawan extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'kode_karyawan',
        'nomor_telepon',
        'status_karyawan',
        'tanggal_masuk',
        'foto',
        'alamat',
        'saldo_cuti',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
