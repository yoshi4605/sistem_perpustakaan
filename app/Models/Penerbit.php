<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Penerbit extends Model
{
    use HasFactory;

    protected $fillable = ['nama_penerbit', 'logo', 'alamat', 'email', 'telepon', 'website'];
    public function bukus()
    {
        return $this->hasMany(Buku::class, 'penerbit_id', 'id');
    }
}