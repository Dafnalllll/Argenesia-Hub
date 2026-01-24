<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AktivitasAdmin extends Model
{
    use HasFactory;

    protected $table = 'aktivitas_admin'; // Nama tabel
    protected $fillable = ['tanggal', 'aktivitas', 'keterangan']; // Kolom yang dapat diisi
}
