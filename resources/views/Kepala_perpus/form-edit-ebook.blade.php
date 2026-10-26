@extends('layouts.index')

@section('halaman', 'Edit E-Book')

@section('main')
<section class="mt-10">
    <form class="all_form" action="/update-ebook/{{ $ebook->id }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="flex gap-8 items-start">
            {{-- Kolom Kiri --}}
            <div class="w-1/2">
                <div class="my-5">
                    <label class="block text-sm font-medium text-gray-700">Judul E-Book*</label>
                    @error('judul_ebook')
                        <div class="text-red-500 text-[14px]">{{ $message }}</div>
                    @enderror
                    <input type="text" name="judul_ebook" value="{{ old('judul_ebook', $ebook->judul_ebook) }}"
                        class="mt-1 block w-full border border-gray-200 rounded-md bg-white p-2 text-gray-400"
                        placeholder="Masukkan judul e-book">
                </div>

                <div class="my-5">
                    <label class="block text-sm font-medium text-gray-700">Pengarang*</label>
                    @error('penulis')
                        <div class="text-red-500 text-[14px]">{{ $message }}</div>
                    @enderror
                    <input type="text" name="penulis" value="{{ old('penulis', $ebook->penulis) }}"
                        class="mt-1 block w-full border border-gray-200 rounded-md bg-white p-2 text-gray-400"
                        placeholder="Nama pengarang">
                </div>

                <div class="my-5">
                    <label class="block text-sm font-medium text-gray-700">Kategori*</label>
                    @error('kategori')
                        <div class="text-red-500 text-[14px]">{{ $message }}</div>
                    @enderror
                    <select name="kategori"
                        class="mt-1 block w-full border border-gray-200 text-gray-400 rounded-md bg-white p-2">
                        <option value="Teknologi" {{ old('kategori', $ebook->kategori) == 'Teknologi' ? 'selected' : '' }}>Teknologi</option>
                        <option value="Sains" {{ old('kategori', $ebook->kategori) == 'Sains' ? 'selected' : '' }}>Sains</option>
                        <option value="Humaniora" {{ old('kategori', $ebook->kategori) == 'Humaniora' ? 'selected' : '' }}>Humaniora</option>
                    </select>
                </div>

                <div class="my-5">
                    <label class="block text-sm font-medium text-gray-700">Sinopsis</label>
                    <textarea name="sinopsis" rows="4"
                        class="mt-1 block w-full border border-gray-200 rounded-md bg-white p-2 text-gray-400"
                        placeholder="Tulis sinopsis singkat...">{{ old('sinopsis', $ebook->sinopsis) }}</textarea>
                </div>
            </div>

            {{-- Kolom Kanan --}}
            <div class="w-1/2">
                <div class="my-5">
                    <label class="block text-sm font-medium text-gray-700">Tahun Terbit</label>
                    <input type="number" name="tahun_terbit" value="{{ old('tahun_terbit', $ebook->tahun_terbit) }}"
                        class="mt-1 block w-full border border-gray-200 rounded-md bg-white p-2 text-gray-400"
                        placeholder="Contoh: 2024">
                </div>

                <div class="my-5">
                    <label class="block text-sm font-medium text-gray-700">Ukuran File (MB)</label>
                    <input type="text" name="ukuran_file" value="{{ old('ukuran_file', $ebook->ukuran_file) }}"
                        class="mt-1 block w-full border border-gray-200 rounded-md bg-white p-2 text-gray-400"
                        placeholder="Contoh: 12.4 MB">
                </div>

                <div class="my-5">
                    <label class="block text-sm font-medium text-gray-700">Ganti File PDF</label>
                    <p class="text-xs text-gray-400 mb-1">File saat ini: <span class="font-medium text-[#35094D]">{{ $ebook->file_pdf }}</span></p>
                    <label class="flex items-center gap-2 border border-dashed border-gray-300 rounded-md bg-white p-2 text-gray-400 cursor-pointer hover:bg-gray-50 transition-colors">
                        <img src="https://api.iconify.design/ri:cloud-upload-line.svg?color=%239ca3af" class="w-4 h-4" alt="">
                        <span id="labelFileEdit">Opsional — biarkan kosong</span>
                        <input type="file" name="file_pdf" class="hidden" accept=".pdf"
                            onchange="document.getElementById('labelFileEdit').textContent = this.files[0]?.name ?? 'Opsional — biarkan kosong'">
                    </label>
                </div>
            </div>
        </div>

        {{-- Action --}}
        <div class="flex justify-between items-center mt-6 pt-2">
            <button type="button" onclick="window.location='/input-ebook'"
                class="px-8 py-2.5 border border-slate-700 text-slate-200 hover:text-white hover:border-cyan-500 hover:bg-slate-800 rounded-xl font-medium text-sm transition-all cursor-pointer">
                Kembali
            </button>

            <button type="submit"
                class="btn_simpan_perubahan bg-[#35094D] text-white py-2.5 px-10 cursor-pointer rounded-xl flex items-center gap-2">
                <svg class="spinner_load hidden animate-spin h-5 w-5 text-white"
                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor"
                        d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                    </path>
                </svg>
                <span class="text_simpan">Simpan Perubahan</span>
            </button>
        </div>
    </form>
</section>
@endsection
