@extends('layouts.index')

@section('halaman', 'Kelola Buku')

@section('main')

    <section class="bg-white mt-10 p-10 rounded-lg">
        <form action="/kelola-buku/{{ $buku->id }}" method="POST" class="all_form flex gap-12"
            enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="w-1/2 flex justify-center items-center">
                <div class="w-[350px] flex flex-col items-center text-center relative">

                    <div class="mb-6">
                        <img id="previewImage"
                            src="{{ $buku->cover_buku ? asset('storage/' . $buku->cover_buku) : asset('icons/no-image.jpg') }}"
                            class="photoPreview w-[120px] h-auto shadow-lg rounded-sm object-cover" alt="Cover Buku">
                    </div>
                    <input name="cover_buku" type="file" id="imageInput" class="photoInput hidden">

                    <button type="button"
                        class="uploadBtn bg-[#35094D] hover:bg-[#4a0d6b] text-white px-8 py-2 rounded-md cursor-pointer text-sm font-semibold transition-colors duration-200">
                        Edit Cover
                    </button>

                    <p class="text-xs mt-6 text-gray-400 font-medium @error('cover_buku') text-red-500 @enderror">
                        Hanya Mendukung File Berbentuk <br>
                        Png, Jpg, Jpeg
                    </p>
                </div>
            </div>

            <!-- Form -->
            <div class="w-1/2 space-y-4">
                <div>
                    <label class="text-gray-600 text-sm font-semibold">Kode Buku*</label>
                    @error('kode_buku')
                        <div class="text-red-500 text-[14px]">{{ $message }}</div>
                    @enderror
                    <input type="text" placeholder="Kode buku" name="kode_buku"
                        class="w-full border rounded-md px-4 py-2 mt-1 border-gray-300 text-gray-400"
                        value="{{ $buku->kode_buku }}">
                </div>

                <div>
                    <label class="text-gray-600 text-sm font-semibold">Judul Buku*</label>
                    @error('judul_buku')
                        <div class="text-red-500 text-[14px]">{{ $message }}</div>
                    @enderror
                    <input type="text" placeholder="Judul Buku" name="judul_buku"
                        class="w-full border rounded-md px-4 py-2 mt-1 border-gray-300 text-gray-400"
                        value="{{ $buku->judul_buku }}">
                </div>

                <div>
                    <label class="text-gray-600 text-sm font-semibold">Penulis*</label>
                    @error('penulis')
                        <div class="text-red-500 text-[14px]">{{ $message }}</div>
                    @enderror
                    <input type="text" placeholder="Penulis" name="penulis"
                        class="w-full border rounded-md px-4 py-2 mt-1 border-gray-300 text-gray-400"
                        value="{{ $buku->penulis }}">
                </div>

                {{-- Input Kategori --}}
                <div class="mb-4">
                    <label for="kategori" class="block text-sm font-medium text-gray-700 mb-1">Kategori</label>
                    <select id="kategori" name="kategori"
                        class="w-full border border-gray-300 rounded-md px-4 py-2 outline-none focus:border-[#35094D] transition-colors @error('kategori') border-red-500 @enderror">
                        <option value="">-- Pilih Kategori --</option>
                        @php
                            $kategoriList = [
                                'Buku Teks',
                                'Novel',
                                'Fiksi',
                                'Non-Fiksi',
                                'Ilmu Pengetahuan',
                                'Teknologi & Komputer',
                                'Ekonomi & Bisnis',
                                'Hukum',
                                'Kesehatan & Kedokteran',
                                'Pendidikan',
                                'Agama & Spiritualitas',
                                'Sejarah',
                                'Biografi',
                                'Seni & Budaya',
                                'Majalah',
                                'Koran',
                                'Komik & Manga',
                                'Anak-anak',
                                'Referensi & Kamus',
                                'Lainnya',
                            ];
                        @endphp
                        @foreach($kategoriList as $k)
                            <option value="{{ $k }}" {{ old('kategori', $buku->kategori) == $k ? 'selected' : '' }}>
                                {{ $k }}
                            </option>
                        @endforeach
                    </select>
                    @error('kategori')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Input Penerbit --}}
                <div class="mb-4">
                    <label for="penerbit_id" class="block text-sm font-medium text-gray-700 mb-1">Penerbit</label>
                    <select id="penerbit_id" name="penerbit_id"
                        class="w-full border border-gray-300 rounded-md px-4 py-2 outline-none focus:border-[#35094D] transition-colors @error('penerbit_id') border-red-500 @enderror">
                        <option value="">-- Pilih Penerbit --</option>
                        @foreach ($penerbits as $p)
                            <option value="{{ $p->id }}"
                                {{ old('penerbit_id', $buku->penerbit_id) == $p->id ? 'selected' : '' }}>
                                {{ $p->nama_penerbit }}
                            </option>
                        @endforeach
                    </select>
                    @error('penerbit_id')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                {{-- Input Rak --}}
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nomor Rak</label>
                    <div class="flex gap-3">
                        <div class="flex flex-col gap-1 w-1/2">
                            <label class="text-xs text-gray-400">Baris (A–Z)</label>
                            <select name="rak_baris"
                                class="w-full border border-gray-300 rounded-md px-4 py-2 outline-none focus:border-[#35094D] transition-colors">
                                <option value="">-- Pilih --</option>
                                @foreach(range('A', 'Z') as $huruf)
                                    <option value="{{ $huruf }}"
                                        {{ old('rak_baris', substr($buku->rak ?? '', 0, 1)) == $huruf ? 'selected' : '' }}>
                                        Baris {{ $huruf }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="flex flex-col gap-1 w-1/2">
                            <label class="text-xs text-gray-400">Tinggi (1–4)</label>
                            <select name="rak_tinggi"
                                class="w-full border border-gray-300 rounded-md px-4 py-2 outline-none focus:border-[#35094D] transition-colors">
                                <option value="">-- Pilih --</option>
                                @foreach(range(1, 4) as $angka)
                                    <option value="{{ $angka }}"
                                        {{ old('rak_tinggi', substr($buku->rak ?? '', 1, 1)) == $angka ? 'selected' : '' }}>
                                        Tinggi {{ $angka }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <p class="text-xs text-gray-400 mt-1">Contoh: Baris A + Tinggi 2 = Rak <strong>A2</strong></p>
                </div>

                <div>
                    <label class="text-gray-600 text-sm font-semibold">Sinopsis*</label>
                    @error('sinopsis')
                        <div class="text-red-500 text-[14px]">{{ $message }}</div>
                    @enderror
                    <textarea placeholder="sinopsis" name="sinopsis"
                        class="w-full border rounded-md px-4 py-2 mt-1 border-gray-300 text-gray-400">{{ $buku->sinopsis ?? 'Tidak Ada Sinopsis' }}</textarea>
                </div>

                <div>
                    <label class="text-gray-600 text-sm font-semibold">Tahun terbit*</label>
                    @error('tahun_terbit')
                        <div class="text-red-500 text-[14px]">{{ $message }}</div>
                    @enderror
                    <input name="tahun_terbit" type="date"
                        class="w-full border rounded-md px-4 py-2 mt-1 border-gray-300 text-gray-400"
                        value="{{ $buku->tahun_terbit }}">
                </div>


                <div>
                    <label class="text-gray-600 text-sm font-semibold">Stok Buku*</label>
                    @error('stok_buku')
                        <div class="text-red-500 text-[14px]">{{ $message }}</div>
                    @enderror
                    <input type="number" placeholder="Stok Buku" name="stok_buku"
                        class="w-full border rounded-md px-4 py-2 mt-1 border-gray-300 text-gray-400"
                        value="{{ $buku->stok_buku }}">
                </div>

                <!-- Button -->
                <div class="flex gap-4 pt-4">
                    <button type="button" onclick="window.location='/kelola-buku'"
                        class="px-6 py-2.5 border border-slate-700 text-slate-300 hover:bg-slate-800 rounded-xl font-medium text-sm transition-all cursor-pointer">
                        Kembali
                    </button>

                    <button id="" type="submit"
                        class="btn_simpan_perubahan bg-gradient-to-r from-cyan-600 to-cyan-500 hover:from-cyan-500 hover:to-cyan-400 text-white py-2.5 px-10 cursor-pointer rounded-xl font-semibold text-sm shadow-lg shadow-cyan-900/30 flex items-center gap-2 transition-all">
                        <svg id="" class="spinner_load hidden animate-spin h-5 w-5 text-white"
                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                stroke-width="4">
                            </circle>
                            <path class="opacity-75" fill="currentColor"
                                d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                            </path>
                        </svg>
                        <span class="text_simpan">Simpan Perubahan</span>
                    </button>
                </div>
            </div>
        </form>
    </section>
@endsection