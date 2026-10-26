<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\Penerbit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BukuController extends Controller
{
    public function index(Request $request)
    {
        $cari = $request->input('cari');
        $kategori = $request->input('kategori');

        $Bukus = Buku::where(function ($query) use ($cari) {
            $query->where('kode_buku', 'like', "%{$cari}%")
                ->orWhere('judul_buku', 'like', "%{$cari}%");
        })
        ->when($kategori, function ($query) use ($kategori) {
            $query->where('kategori', $kategori);
        })
        ->paginate(10)->withQueryString();

        $kategoris = Buku::whereNotNull('kategori')
            ->where('kategori', '!=', '')
            ->distinct()
            ->orderBy('kategori')
            ->pluck('kategori');

        return view('kelola-buku.index', compact('Bukus', 'kategoris'));
    }

    public function tambah_buku()
    {
        $penerbits = Penerbit::orderBy('nama_penerbit')->get();
        return view('kelola-buku.tambah-buku', compact('penerbits'));
    }

    public function store_buku(Request $request)
    {
        $validasiBuku = $request->validate([
            "kode_buku"     => "required|unique:buku,kode_buku",
            "judul_buku"    => "required|max:50",
            "penulis"       => "required|max:50",
            "tahun_terbit"  => "required|date",
            "kategori"      => "nullable|in:Buku Teks,Novel,Fiksi,Non-Fiksi,Ilmu Pengetahuan,Teknologi & Komputer,Ekonomi & Bisnis,Hukum,Kesehatan & Kedokteran,Pendidikan,Agama & Spiritualitas,Sejarah,Biografi,Seni & Budaya,Majalah,Koran,Komik & Manga,Anak-anak,Referensi & Kamus,Lainnya",
            "penerbit"      => "nullable|string|max:50",
            "sinopsis"      => "nullable|min:20",
            "stok_buku"     => "required|integer|min:0|max:300",
            "cover_buku"    => "nullable|mimes:png,jpg,jpeg,webp|max:2048"
        ], [
            "kode_buku.required"   => "Kode buku harus di isi.",
            "kode_buku.unique"     => "Kode buku sudah di gunakan.",
            "judul_buku.required"  => "Judul buku harus di isi.",
            "judul_buku.max"       => "Judul buku maksimal 50 karakter.",
            "penulis.required"     => "Penulis harus di isi.",
            "penulis.max"          => "Penulis maksimal 50 karakter.",
            "tahun_terbit.required"=> "Tahun terbit harus di isi.",
            "tahun_terbit.date"    => "Tahun terbit harus berupa tanggal.",
            "sinopsis.min"         => "Sinopsis minimal 20 kata.",
            "stok_buku.required"   => "Stok buku harus di isi",
            "stok_buku.min"        => "Stok buku tidak valid!",
            "stok_buku.max"        => "Stok buku maksimal 300 Buku!",
            "cover_buku.mimes"     => "Cover buku harus berupa png,jpg,jpeg dan webp.",
            "cover_buku.max"       => "Cover buku maskimal berukuran 2mb.",
            "kategori.in"          => "Kategori yang dipilih tidak valid.",
        ]);

        // Simpan penerbit_id dan sinkronkan nama penerbit dari relasi
        if ($request->penerbit_id) {
            $validasiBuku['penerbit_id'] = $request->penerbit_id;
            $penerbitObj = Penerbit::find($request->penerbit_id);
            if ($penerbitObj) {
                $validasiBuku['penerbit'] = $penerbitObj->nama_penerbit;
            }
        } else {
            $validasiBuku['penerbit_id'] = null;
        }

        // Gabungkan rak_baris + rak_tinggi → kolom rak
        if ($request->rak_baris && $request->rak_tinggi) {
            $validasiBuku['rak'] = $request->rak_baris . $request->rak_tinggi;
        } else {
            $validasiBuku['rak'] = null;
        }

        if ($request->hasFile('cover_buku')) {
            $validasiBuku['cover_buku'] = $request->file('cover_buku')->store('cover_bukus', 'public');
        }

        Buku::create($validasiBuku);

        return redirect('/kelola-buku')->with('success', 'Buku Berhasil Ditambahkan.');
    }

    public function edit_buku(Buku $buku)
    {
        $penerbits = Penerbit::orderBy('nama_penerbit')->get();
        return view('kelola-buku.edit-buku', [
            "buku"      => $buku,
            "penerbits" => $penerbits,
        ]);
    }

    public function update_buku(Request $request, Buku $buku)
    {
        $validasiBuku = $request->validate([
            'kode_buku'     => 'required|unique:buku,kode_buku,' . $buku->id,
            "judul_buku"    => "required|max:50",
            "penulis"       => "required|max:50",
            "tahun_terbit"  => "required|date",
            "kategori"      => "nullable|in:Buku Teks,Novel,Fiksi,Non-Fiksi,Ilmu Pengetahuan,Teknologi & Komputer,Ekonomi & Bisnis,Hukum,Kesehatan & Kedokteran,Pendidikan,Agama & Spiritualitas,Sejarah,Biografi,Seni & Budaya,Majalah,Koran,Komik & Manga,Anak-anak,Referensi & Kamus,Lainnya",
            "penerbit"      => "nullable|string|max:50",
            "sinopsis"      => "nullable|min:20",
            "stok_buku"     => "required|integer|min:0|max:300",
            "cover_buku"    => "nullable|mimes:png,jpg,jpeg,webp|max:2048"
        ], [
            "kode_buku.required"   => "Kode buku harus di isi.",
            "kode_buku.unique"     => "Kode buku sudah di gunakan.",
            "judul_buku.required"  => "Judul buku harus di isi.",
            "judul_buku.max"       => "Judul buku maksimal 50 karakter.",
            "penulis.required"     => "Penulis harus di isi.",
            "penulis.max"          => "Penulis maksimal 50 karakter.",
            "tahun_terbit.required"=> "Tahun terbit harus di isi.",
            "tahun_terbit.date"    => "Tahun terbit harus berupa tanggal.",
            "sinopsis.min"         => "Sinopsis minimal 20 kata.",
            "stok_buku.required"   => "Stok buku harus di isi",
            "stok_buku.min"        => "Stok buku tidak valid!",
            "stok_buku.max"        => "Stok buku maksimal 300 Buku!",
            "cover_buku.mimes"     => "Cover buku harus berupa png,jpg,jpeg dan webp.",
            "cover_buku.max"       => "Cover buku maskimal berukuran 2mb.",
            "kategori.in"          => "Kategori yang dipilih tidak valid.",
        ]);

        // Simpan penerbit_id dan sinkronkan nama penerbit dari relasi
        if ($request->penerbit_id) {
            $validasiBuku['penerbit_id'] = $request->penerbit_id;
            $penerbitObj = Penerbit::find($request->penerbit_id);
            if ($penerbitObj) {
                $validasiBuku['penerbit'] = $penerbitObj->nama_penerbit;
            }
        } else {
            $validasiBuku['penerbit_id'] = null;
        }

        // Gabungkan rak_baris + rak_tinggi → kolom rak
        if ($request->rak_baris && $request->rak_tinggi) {
            $validasiBuku['rak'] = $request->rak_baris . $request->rak_tinggi;
        } else {
            $validasiBuku['rak'] = null;
        }

        if ($request->hasFile('cover_buku')) {
            if ($buku->cover_buku && Storage::disk('public')->exists($buku->cover_buku)) {
                Storage::disk('public')->delete($buku->cover_buku);
            }
            $validasiBuku['cover_buku'] = $request->file('cover_buku')->store('cover_bukus', 'public');
        }

        $buku->update($validasiBuku);
        return back()->with('success', 'Buku Berhasil DiPembaharui.');
    }

    public function delete_buku(Buku $buku)
    {
        if ($buku->cover_buku && Storage::disk('public')->exists($buku->cover_buku)) {
            Storage::disk('public')->delete($buku->cover_buku);
        }
        $buku->delete();
        return back()->with('success', 'Buku Berhasil dihapus.');
    }
}