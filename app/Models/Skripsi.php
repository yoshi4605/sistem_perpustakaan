<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Skripsi extends Model
{
   use HasFactory;

    protected $table = 'skripsis';

    protected $fillable = [
        'judul_skripsi',
        'gambar',
        'nama_penulis',
        'npm',
        'program_studi',
        'tahun_lulus',
        'nomor_rak',
        'nomor_baris',
        'is_cd_artikel',
        'abstrak',
    ];
}
