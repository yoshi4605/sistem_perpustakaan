<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Buku extends Model
{
    protected $table = 'buku';
    protected $guarded = [];

    public function penerbitRelasi()
    {
        return $this->belongsTo(Penerbit::class, 'penerbit_id', 'id');
    }
}