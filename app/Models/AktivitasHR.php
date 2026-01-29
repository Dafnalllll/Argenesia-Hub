<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AktivitasHR extends Model
{
    // Nama tabel (jika tidak mengikuti konvensi jamak)
    protected $table = 'aktivitas_hr';

    // Kolom yang boleh diisi massal
    protected $fillable = [
        'tanggal',
        'aktivitas',
        'keterangan',
    ];

    // (Opsional) Jika ingin tanggal otomatis jadi Carbon instance
    protected $dates = [
        'tanggal',
        'created_at',
        'updated_at',
    ];
}
