@extends('layouts.index')
@section('halaman', 'Daftar Penerbit')
@section('main')

<section class="bg-white mt-10 p-10 rounded-2xl border border-slate-700/60 shadow-xl">
    <form action="/daftar-penerbit/{{ $penerbit->id }}" method="POST" class="all_form flex flex-col md:flex-row gap-12" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        {{-- Sisi Kiri: Upload Logo --}}
        <div class="w-full md:w-1/2 flex justify-center items-start pt-4">
            <div class="w-[350px] flex flex-col items-center text-center">
                <div class="relative group cursor-pointer mb-3">
                    <div class="w-28 h-28 rounded-2xl bg-slate-900/60 border-2 border-dashed border-slate-700 group-hover:border-cyan-500/50 flex items-center justify-center overflow-hidden shadow-lg transition-all p-2">
                        <img src="{{ $penerbit->logo ? asset('storage/' . $penerbit->logo) : asset('icons/svg/penerbit-aktif.svg') }}"
                            class="photoPreview w-16 h-16 object-contain" alt="Logo Penerbit">
                    </div>
                    <button type="button" class="uploadBtn mt-3 inline-flex items-center gap-1.5 px-4 py-2 rounded-xl text-xs font-semibold bg-cyan-500/15 text-cyan-400 border border-cyan-500/30 hover:bg-cyan-500/30 transition-all cursor-pointer">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                        </svg>
                        <span>Ubah Logo (Opsional)</span>
                    </button>
                    <input type="file" name="logo" class="photoInput hidden" accept="image/*">
                </div>
                <p class="text-white font-bold text-lg mt-2">Edit Penerbit</p>
                <p class="text-slate-400 text-xs mt-0.5">Perbarui data supplier / mitra penerbit</p>

                <div class="mt-6 w-full bg-slate-900/40 border border-slate-800 rounded-xl p-4 text-left">
                    <p class="text-xs text-cyan-400 font-semibold uppercase tracking-wider mb-2">Data Saat Ini</p>
                    <p class="text-sm font-bold text-white">{{ $penerbit->nama_penerbit }}</p>
                    @if($penerbit->bukus_count ?? false)
                        <p class="text-xs text-slate-400 mt-1">{{ $penerbit->bukus_count }} judul buku terdaftar</p>
                    @endif
                </div>
            </div>
        </div>

        {{-- Sisi Kanan: Form Fields --}}
        <div class="w-full md:w-1/2 space-y-4">
            <div>
                <label class="text-slate-300 text-sm font-semibold">Nama Penerbit *</label>
                @error('nama_penerbit') <div class="text-rose-400 text-xs mt-1">{{ $message }}</div> @enderror
                <input type="text" name="nama_penerbit" placeholder="Contoh: Gramedia Pustaka Utama"
                    class="w-full border rounded-xl px-4 py-2.5 mt-1 border-slate-700 bg-slate-900/50 text-white"
                    value="{{ old('nama_penerbit', $penerbit->nama_penerbit) }}" required>
            </div>

            <div>
                <label class="text-slate-300 text-sm font-semibold">Alamat</label>
                <input type="text" name="alamat" placeholder="Alamat lengkap penerbit"
                    class="w-full border rounded-xl px-4 py-2.5 mt-1 border-slate-700 bg-slate-900/50 text-white"
                    value="{{ old('alamat', $penerbit->alamat) }}">
            </div>

            <div>
                <label class="text-slate-300 text-sm font-semibold">Email</label>
                <input type="email" name="email" placeholder="email@penerbit.com"
                    class="w-full border rounded-xl px-4 py-2.5 mt-1 border-slate-700 bg-slate-900/50 text-white"
                    value="{{ old('email', $penerbit->email) }}">
            </div>

            <div>
                <label class="text-slate-300 text-sm font-semibold">Telepon</label>
                <input type="text" name="telepon" placeholder="Contoh: 02155001234"
                    class="w-full border rounded-xl px-4 py-2.5 mt-1 border-slate-700 bg-slate-900/50 text-white"
                    value="{{ old('telepon', $penerbit->telepon) }}">
            </div>

            <div>
                <label class="text-slate-300 text-sm font-semibold">Website</label>
                <input type="text" name="website" placeholder="https://www.penerbit.com"
                    class="w-full border rounded-xl px-4 py-2.5 mt-1 border-slate-700 bg-slate-900/50 text-white"
                    value="{{ old('website', $penerbit->website) }}">
            </div>

            <div class="flex gap-4 pt-4">
                <button type="button" onclick="window.location='/daftar-penerbit'"
                    class="px-6 py-2.5 border border-slate-700 text-slate-300 hover:bg-slate-800 rounded-xl font-medium text-sm transition-all cursor-pointer">
                    Kembali
                </button>
                <button type="submit"
                    class="btn_simpan_perubahan bg-gradient-to-r from-cyan-600 to-cyan-500 hover:from-cyan-500 hover:to-cyan-400 text-white py-2.5 px-8 cursor-pointer rounded-xl font-semibold text-sm shadow-lg shadow-cyan-900/30 flex items-center gap-2 transition-all">
                    <svg class="spinner_load hidden animate-spin h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    <span class="text_simpan">Simpan Perubahan</span>
                </button>
            </div>
        </div>
    </form>
</section>
@endsection
