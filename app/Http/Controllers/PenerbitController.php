<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Penerbit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PenerbitController extends Controller
{
    public function show($id)
    {
        $penerbit = Penerbit::withCount('bukus')->findOrFail($id);
        $bukus = $penerbit->bukus()->orderBy('judul_buku')->get();
        return view('Kepala_perpus.detail-penerbit', compact('penerbit', 'bukus'));
    }

    public function showPetugas($id)
    {
        $penerbit = Penerbit::withCount('bukus')->findOrFail($id);
        $bukus = $penerbit->bukus()->orderBy('judul_buku')->get();
        return view('petugas.detail-penerbit', compact('penerbit', 'bukus'));
    }

    public function index()
    {
        $penerbits = Penerbit::withCount('bukus')->latest()->get();
        return view('Kepala_perpus.tambah-penerbit', compact('penerbits'));
    }

    public function indexPetugas()
    {
        $penerbits = Penerbit::withCount('bukus')->latest()->get();
        return view('petugas.daftar-penerbit', compact('penerbits'));
    }

    public function create()
    {
        return view('Kepala_perpus.tambah-penerbit-form');
    }

    public function editPage($id)
    {
        $penerbit = Penerbit::findOrFail($id);
        return view('Kepala_perpus.edit-penerbit', compact('penerbit'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nama_penerbit' => 'required|string|max:255',
            'logo'          => 'nullable|image|mimes:jpeg,png,jpg,webp,svg|max:2048',
            'alamat'        => 'nullable|string',
            'email'         => 'nullable|email',
            'telepon'       => 'nullable|string',
            'website'       => 'nullable|string',
        ]);

        if ($request->hasFile('logo')) {
            $data['logo'] = $request->file('logo')->store('penerbit_logos', 'public');
        }

        Penerbit::create($data);

        return redirect('/daftar-penerbit')->with('sukses', 'Penerbit berhasil ditambahkan!');
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'nama_penerbit' => 'required|string|max:255',
            'logo'          => 'nullable|image|mimes:jpeg,png,jpg,webp,svg|max:2048',
            'alamat'        => 'nullable|string',
            'email'         => 'nullable|string',
            'telepon'       => 'nullable|string',
            'website'       => 'nullable|string',
        ]);

        $penerbit = Penerbit::findOrFail($id);

        if ($request->hasFile('logo')) {
            if ($penerbit->logo && Storage::disk('public')->exists($penerbit->logo)) {
                Storage::disk('public')->delete($penerbit->logo);
            }
            $data['logo'] = $request->file('logo')->store('penerbit_logos', 'public');
        }

        $penerbit->update($data);

        return redirect('/daftar-penerbit')->with('sukses', 'Data penerbit berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $penerbit = Penerbit::findOrFail($id);
        if ($penerbit->logo && Storage::disk('public')->exists($penerbit->logo)) {
            Storage::disk('public')->delete($penerbit->logo);
        }
        $penerbit->delete();

        return redirect('/daftar-penerbit')->with('sukses', 'Penerbit berhasil dihapus!');
    }
}