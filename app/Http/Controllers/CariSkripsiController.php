<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Skripsi;
use Illuminate\Http\Request;

class CariSkripsiController extends Controller
{
   public function index(Request $request)
    {
        $cari = $request->get('cari');
        $skripsis = Skripsi::when($cari, function ($query) use ($cari) {
            return $query->where('judul_skripsi', 'like', "%{$cari}%")
                         ->orWhere('nama_penulis', 'like', "%{$cari}%")
                         ->orWhere('npm', 'like', "%{$cari}%");
        })->latest()->paginate(10)->withQueryString();
        return view('Anggota.cari-skripsi', compact('skripsis'));
    }
}
