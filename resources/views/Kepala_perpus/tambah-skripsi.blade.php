@extends('layouts.index')
@section('halaman', 'Koleksi Skripsi')
@section('main')

<section class="bg-white mt-10 p-10 rounded-2xl border border-slate-700/60 shadow-xl">
    <form action="/koleksi-skripsi/simpan" method="POST" class="all_form flex flex-col md:flex-row gap-12" enctype="multipart/form-data">
        @csrf

        {{-- Sisi Kiri: Upload Sampul / Cover --}}
        <div class="w-full md:w-1/2 flex justify-center items-start pt-4">
            <div class="w-[350px] flex flex-col items-center text-center">
                <div class="relative group cursor-pointer mb-3">
                    <div class="w-28 h-36 rounded-2xl bg-slate-900/60 border-2 border-dashed border-slate-700 group-hover:border-cyan-500/50 flex items-center justify-center overflow-hidden shadow-lg transition-all p-2">
                        <img src="{{ asset('icons/svg/skripsi-aktif.svg') }}" class="photoPreview w-14 h-14 object-contain" alt="Sampul Skripsi">
                    </div>
                    <button type="button" class="uploadBtn mt-3 inline-flex items-center gap-1.5 px-4 py-2 rounded-xl text-xs font-semibold bg-cyan-500/15 text-cyan-400 border border-cyan-500/30 hover:bg-cyan-500/30 transition-all cursor-pointer">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                        </svg>
                        <span>Pilih Sampul (Opsional)</span>
                    </button>
                    <input type="file" name="gambar" class="photoInput hidden" accept="image/*">
                </div>
                <p class="text-white font-bold text-lg mt-2">Input Skripsi</p>
                <p class="text-slate-400 text-xs mt-0.5">Tugas Akhir / Skripsi Mahasiswa</p>

                <div class="mt-6 w-full text-left space-y-2 bg-slate-900/40 border border-slate-800 rounded-xl p-4">
                    <p class="text-xs text-cyan-400 font-semibold uppercase tracking-wider">Panduan Pengisian</p>
                    <p class="text-xs text-slate-400">• Judul, penulis, NPM, prodi wajib diisi</p>
                    <p class="text-xs text-slate-400">• Foto/sampul bersifat opsional (PNG, JPG max 2MB)</p>
                    <p class="text-xs text-slate-400">• Nomor rak & baris sesuai lokasi fisik</p>
                    <p class="text-xs text-slate-400">• Centang CD jika ada artikel ilmiah</p>
                    <p class="text-xs text-slate-400">• Abstrak minimal menjelaskan isi skripsi</p>
                </div>
            </div>
        </div>

        {{-- Sisi Kanan: Form Fields --}}
        <div class="w-full md:w-1/2 space-y-4">

            <div>
                <label class="text-slate-300 text-sm font-semibold">Judul Skripsi *</label>
                @error('judul_skripsi') <div class="text-rose-400 text-xs mt-1">{{ $message }}</div> @enderror
                <input type="text" name="judul_skripsi" placeholder="Judul skripsi / tugas akhir"
                    class="w-full border rounded-xl px-4 py-2.5 mt-1 border-slate-700 bg-slate-900/50 text-white"
                    value="{{ old('judul_skripsi') }}" required>
            </div>

            <div>
                <label class="text-slate-300 text-sm font-semibold">Nama Penulis *</label>
                @error('nama_penulis') <div class="text-rose-400 text-xs mt-1">{{ $message }}</div> @enderror
                <input type="text" name="nama_penulis" placeholder="Nama lengkap penulis"
                    class="w-full border rounded-xl px-4 py-2.5 mt-1 border-slate-700 bg-slate-900/50 text-white"
                    value="{{ old('nama_penulis') }}" required>
            </div>

            <div class="flex gap-4">
                <div class="w-1/2">
                    <label class="text-slate-300 text-sm font-semibold">NPM *</label>
                    @error('npm') <div class="text-rose-400 text-xs mt-1">{{ $message }}</div> @enderror
                    <input type="text" name="npm" placeholder="NPM penulis"
                        class="w-full border rounded-xl px-4 py-2.5 mt-1 border-slate-700 bg-slate-900/50 text-white"
                        value="{{ old('npm') }}" required>
                </div>
                <div class="w-1/2">
                    <label class="text-slate-300 text-sm font-semibold">Tahun Lulus</label>
                    <input type="text" name="tahun_lulus" placeholder="Contoh: 2024"
                        class="w-full border rounded-xl px-4 py-2.5 mt-1 border-slate-700 bg-slate-900/50 text-white"
                        value="{{ old('tahun_lulus') }}">
                </div>
            </div>

            <div>
                <label class="text-slate-300 text-sm font-semibold">Program Studi *</label>
                @error('program_studi') <div class="text-rose-400 text-xs mt-1">{{ $message }}</div> @enderror
                <input type="text" name="program_studi" placeholder="Contoh: Ilmu Komputer"
                    class="w-full border rounded-xl px-4 py-2.5 mt-1 border-slate-700 bg-slate-900/50 text-white"
                    value="{{ old('program_studi') }}" required>
            </div>

            {{-- Nomor Rak --}}
            <div>
                <label class="block text-sm font-semibold text-slate-300 mb-1">Lokasi Rak Fisik</label>
                <div class="flex gap-3">
                    <div class="flex flex-col gap-1 w-1/2">
                        <label class="text-xs text-slate-400">Rak (A–Z)</label>
                        <select name="nomor_rak"
                            class="w-full border border-slate-700 rounded-xl px-4 py-2.5 bg-slate-900/50 text-white outline-none focus:border-cyan-500 transition-colors">
                            <option value="">-- Pilih --</option>
                            @foreach(range('A', 'Z') as $huruf)
                                <option value="{{ $huruf }}" {{ old('nomor_rak') == $huruf ? 'selected' : '' }}>
                                    Rak {{ $huruf }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="flex flex-col gap-1 w-1/2">
                        <label class="text-xs text-slate-400">Baris (1–4)</label>
                        <select name="nomor_baris"
                            class="w-full border border-slate-700 rounded-xl px-4 py-2.5 bg-slate-900/50 text-white outline-none focus:border-cyan-500 transition-colors">
                            <option value="">-- Pilih --</option>
                            @foreach(range(1, 4) as $angka)
                                <option value="{{ $angka }}" {{ old('nomor_baris') == $angka ? 'selected' : '' }}>
                                    Baris {{ $angka }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            <div>
                <label class="text-slate-300 text-sm font-semibold">Abstrak *</label>
                @error('abstrak') <div class="text-rose-400 text-xs mt-1">{{ $message }}</div> @enderror
                <textarea name="abstrak" rows="4" placeholder="Ringkasan isi skripsi..."
                    class="w-full border rounded-xl px-4 py-2.5 mt-1 border-slate-700 bg-slate-900/50 text-white" required>{{ old('abstrak') }}</textarea>
            </div>

            <div class="pt-1">
                <label class="flex items-center gap-2.5 cursor-pointer select-none text-sm font-medium text-slate-300">
                    <input type="checkbox" name="is_cd_artikel" value="1"
                        {{ old('is_cd_artikel') ? 'checked' : '' }}
                        class="w-4 h-4 rounded border-slate-700 bg-slate-900 text-cyan-500 focus:ring-cyan-500">
                    <span>Disertai CD Artikel Ilmiah</span>
                </label>
            </div>

            <div class="flex gap-4 pt-4">
                <button type="button" onclick="window.location='/koleksi-skripsi'"
                    class="px-6 py-2.5 border border-slate-700 text-slate-300 hover:bg-slate-800 rounded-xl font-medium text-sm transition-all cursor-pointer">
                    Kembali
                </button>
                <button type="submit"
                    class="btn_simpan_perubahan bg-gradient-to-r from-cyan-600 to-cyan-500 hover:from-cyan-500 hover:to-cyan-400 text-white py-2.5 px-8 cursor-pointer rounded-xl font-semibold text-sm shadow-lg shadow-cyan-900/30 flex items-center gap-2 transition-all">
                    <svg class="spinner_load hidden animate-spin h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    <span class="text_simpan">Simpan Skripsi</span>
                </button>
            </div>
        </div>
    </form>
</section>
@endsection
