<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Skripsi;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class SkripsiController extends Controller
{
    public function index(Request $request)
    {
        $cari = $request->get('cari');

        $skripsis = Skripsi::when($cari, function ($query) use ($cari) {
            return $query->where('judul_skripsi', 'like', "%{$cari}%")
                         ->orWhere('nama_penulis', 'like', "%{$cari}%")
                         ->orWhere('npm', 'like', "%{$cari}%");
        })->latest()->paginate(10)->withQueryString();

        return view('Kepala_perpus.skripsi', compact('skripsis'));
    }

    public function indexByRole(Request $request)
    {
        $role = Auth::user()->role;

        if ($role === 'kepala_perpus') {
            return $this->index($request);
        } elseif ($role === 'petugas') {
            return $this->indexPetugas($request);
        }

        abort(403);
    }

    public function indexPetugas(Request $request)
    {
        $cari = $request->get('cari');

        $skripsis = Skripsi::when($cari, function ($query) use ($cari) {
            return $query->where('judul_skripsi', 'like', "%{$cari}%")
                        ->orWhere('nama_penulis', 'like', "%{$cari}%")
                        ->orWhere('npm', 'like', "%{$cari}%");
        })->latest()->paginate(10)->withQueryString();

        return view('petugas.skripsi', compact('skripsis'));
    }

    public function edit($id)
    {
        $skripsi = Skripsi::findOrFail($id);
        return view('Kepala_perpus.edit-skripsi', compact('skripsi'));
    }

    public function create()
    {
        return view('Kepala_perpus.tambah-skripsi');
    }

    public function update(Request $request, $id)
    {
        $skripsi = Skripsi::findOrFail($id);

        $data = $request->validate([
            'judul_skripsi' => 'required|string',
            'gambar'        => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'nama_penulis'  => 'required|string',
            'npm'           => 'required|string',
            'program_studi' => 'required|string',
            'tahun_lulus'   => 'nullable|string',
            'nomor_rak'     => 'nullable|string',
            'nomor_baris'   => 'nullable|string',
            'abstrak'       => 'required|string',
        ]);

        $data['is_cd_artikel'] = $request->has('is_cd_artikel');

        if ($request->hasFile('gambar')) {
            if ($skripsi->gambar && Storage::disk('public')->exists($skripsi->gambar)) {
                Storage::disk('public')->delete($skripsi->gambar);
            }
            $data['gambar'] = $request->file('gambar')->store('skripsi_covers', 'public');
        }

        $skripsi->update($data);

        return redirect('/koleksi-skripsi')->with('sukses', 'Skripsi berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $skripsi = Skripsi::findOrFail($id);
        if ($skripsi->gambar && Storage::disk('public')->exists($skripsi->gambar)) {
            Storage::disk('public')->delete($skripsi->gambar);
        }
        $skripsi->delete();
        return back()->with('sukses', 'Skripsi berhasil dihapus!');
    }


    public function store(Request $request)
    {
        $data = $request->validate([
            'judul_skripsi' => 'required|string',
            'gambar'        => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'nama_penulis'  => 'required|string',
            'npm'           => 'required|string',
            'program_studi' => 'required|string',
            'tahun_lulus'   => 'nullable|string',
            'nomor_rak'     => 'nullable|string',
            'nomor_baris'   => 'nullable|string',
            'abstrak'       => 'required|string',
        ]);

        $data['is_cd_artikel'] = $request->has('is_cd_artikel');

        if ($request->hasFile('gambar')) {
            $data['gambar'] = $request->file('gambar')->store('skripsi_covers', 'public');
        }

        Skripsi::create($data);

        return redirect('/koleksi-skripsi')->with('sukses', 'Skripsi berhasil ditambahkan!');
    }
}
