<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class TipeCuti extends Model
{
    use HasFactory;
    protected $table = 'tipe_cutis';

    protected $fillable = [
        'nama_cuti',
        'maksimal_hari',
    ];
}
