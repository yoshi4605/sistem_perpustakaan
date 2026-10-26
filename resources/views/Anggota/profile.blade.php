@extends('layouts.index')

@section('halaman', 'Profil Saya')

@section('main')
    {{-- Header Section --}}
    <section class="mb-6">
        <div class="flex flex-col md:flex-row md:items-end justify-between gap-4">
            <div>
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-blue-50 text-blue-700 text-xs font-semibold mb-2">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                    Manajemen Akun
                </div>
                <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">Profil & Biodata Anggota</h1>
                <p class="text-slate-500 text-xs sm:text-sm mt-1">Perbarui informasi identitas pribadi, kontak telepon, dan alamat tempat tinggal Anda.</p>
            </div>
            <div class="text-xs text-slate-500 bg-white px-3.5 py-1.5 rounded-full border border-slate-200 shadow-2xs self-start md:self-auto">
                Status: <span class="font-bold text-emerald-600">Anggota Aktif</span>
            </div>
        </div>
    </section>

    {{-- Main Profile Section --}}
    <section class="mb-14">
        <form class="all_form" action="/profile-anggota" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                
                {{-- Left Sidebar: Avatar & Identity Card --}}
                <div class="space-y-6">
                    
                    {{-- Avatar Card --}}
                    <div class="bg-white rounded-2xl border border-slate-200/80 p-6 shadow-xs text-center">
                        <div class="relative w-28 h-28 mx-auto mb-4">
                            <img class="photoPreview w-28 h-28 rounded-2xl object-cover border-2 border-slate-100 shadow-sm"
                                src="{{ Auth::user()->profile_photo ? asset('storage/' . Auth::user()->profile_photo) : asset('icons/default-avatar.png') }}"
                                alt="{{ Auth::user()->username }}">
                            <input type="file" class="photoInput" name="profile_photo" hidden accept="image/png,image/jpeg,image/jpg">
                        </div>

                        <h3 class="text-base font-bold text-slate-900 capitalize">{{ Auth::user()->Anggota->nama_lengkap ?? Auth::user()->username }}</h3>
                        <p class="text-xs text-slate-400 mt-0.5">{{ Auth::user()->email }}</p>

                        <div class="mt-2 inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-slate-100 text-slate-700 text-xs font-semibold">
                            <span>ID: {{ Auth::user()->Anggota->nomer_induk ?? ('ANGGOTA#' . Auth::user()->id) }}</span>
                        </div>

                        @error('profile_photo')
                            <div class="text-red-500 text-xs mt-2">{{ $message }}</div>
                        @enderror

                        <div class="mt-6 flex flex-col gap-2">
                            <button type="button" class="uploadBtn w-full py-2.5 px-4 bg-blue-600 hover:bg-blue-700 text-white rounded-xl text-xs font-semibold shadow-xs transition cursor-pointer">
                                Unggah Foto Baru
                            </button>
                            
                            @if(Auth::user()->profile_photo)
                                <button form="deleteProfilePicture" type="submit" onclick="return confirm('Apakah Anda yakin ingin menghapus foto profil ini?')"
                                    class="w-full py-2.5 px-4 border border-rose-200 text-rose-600 hover:bg-rose-50 rounded-xl text-xs font-semibold transition cursor-pointer">
                                    Hapus Foto Profil
                                </button>
                            @endif
                        </div>

                        <p class="text-2xs text-slate-400 mt-3">Format JPG/PNG, ukuran maks. 2MB</p>
                    </div>

                    {{-- Info Box --}}
                    <div class="bg-blue-50/70 border border-blue-200/70 rounded-2xl p-5 text-blue-900 text-xs">
                        <div class="flex items-center gap-2 font-bold mb-1.5">
                            <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            Penting Untuk Peminjaman
                        </div>
                        <p class="text-slate-600 leading-relaxed">
                            Pastikan data <strong>Nama Lengkap</strong> dan <strong>Nomor Induk (NIS/NPM)</strong> sesuai dengan kartu identitas resmi untuk kelancaran verifikasi peminjaman fisik oleh staf perpustakaan.
                        </p>
                    </div>

                </div>

                {{-- Right Main Form: Personal & Account Details --}}
                <div class="lg:col-span-2 space-y-6">
                    
                    {{-- Section 1: Biodata Anggota --}}
                    <div class="bg-white rounded-2xl border border-slate-200/80 p-6 sm:p-7 shadow-xs">
                        <h2 class="text-base font-bold text-slate-900 mb-1 flex items-center gap-2">
                            <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2" />
                            </svg>
                            Identitas Anggota
                        </h2>
                        <p class="text-xs text-slate-400 mb-5">Data resmi keanggotaan perpustakaan.</p>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            {{-- Nama Lengkap --}}
                            <div>
                                <label class="block text-xs font-semibold text-slate-700 mb-1.5">Nama Lengkap*</label>
                                <input type="text" name="nama_lengkap"
                                    class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2.5 text-sm text-slate-800 placeholder:text-slate-400 focus:bg-white focus:border-blue-500 focus:ring-2 focus:ring-blue-100 transition outline-none"
                                    placeholder="Contoh: Budi Santoso"
                                    value="{{ old('nama_lengkap', Auth::user()->Anggota->nama_lengkap ?? '') }}">
                                @error('nama_lengkap')
                                    <div class="text-red-500 text-xs mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Nomor Induk --}}
                            <div>
                                <label class="block text-xs font-semibold text-slate-700 mb-1.5">Nomor Induk (NIS / NPM / NIK)*</label>
                                <input type="text" name="nomer_induk"
                                    class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2.5 text-sm text-slate-800 placeholder:text-slate-400 focus:bg-white focus:border-blue-500 focus:ring-2 focus:ring-blue-100 transition outline-none"
                                    placeholder="Contoh: 202143500123"
                                    value="{{ old('nomer_induk', Auth::user()->Anggota->nomer_induk ?? '') }}">
                                @error('nomer_induk')
                                    <div class="text-red-500 text-xs mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Tanggal Lahir --}}
                            <div>
                                <label class="block text-xs font-semibold text-slate-700 mb-1.5">Tanggal Lahir*</label>
                                <input type="date" name="tanggal_lahir"
                                    class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2.5 text-sm text-slate-800 focus:bg-white focus:border-blue-500 focus:ring-2 focus:ring-blue-100 transition outline-none cursor-pointer"
                                    value="{{ old('tanggal_lahir', Auth::user()->Anggota->tanggal_lahir ?? '') }}">
                                @error('tanggal_lahir')
                                    <div class="text-red-500 text-xs mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Jenis Kelamin --}}
                            <div>
                                <label class="block text-xs font-semibold text-slate-700 mb-1.5">Jenis Kelamin*</label>
                                <select name="jenis_kelamin"
                                    class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2.5 text-sm text-slate-800 focus:bg-white focus:border-blue-500 focus:ring-2 focus:ring-blue-100 transition outline-none cursor-pointer">
                                    <option value="" disabled {{ old('jenis_kelamin', Auth::user()->Anggota->jenis_kelamin ?? '') == '' ? 'selected' : '' }}>
                                        Pilih Jenis Kelamin
                                    </option>
                                    <option value="Laki-laki" {{ old('jenis_kelamin', Auth::user()->Anggota->jenis_kelamin ?? '') == 'Laki-laki' ? 'selected' : '' }}>
                                        Laki-laki
                                    </option>
                                    <option value="Perempuan" {{ old('jenis_kelamin', Auth::user()->Anggota->jenis_kelamin ?? '') == 'Perempuan' ? 'selected' : '' }}>
                                        Perempuan
                                    </option>
                                </select>
                                @error('jenis_kelamin')
                                    <div class="text-red-500 text-xs mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    {{-- Section 2: Akun & Kontak --}}
                    <div class="bg-white rounded-2xl border border-slate-200/80 p-6 sm:p-7 shadow-xs">
                        <h2 class="text-base font-bold text-slate-900 mb-1 flex items-center gap-2">
                            <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                            Akun & Kontak
                        </h2>
                        <p class="text-xs text-slate-400 mb-5">Informasi akun login dan nomor kontak aktif Anda.</p>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            {{-- Username --}}
                            <div>
                                <label class="block text-xs font-semibold text-slate-700 mb-1.5">Username Login*</label>
                                <input type="text" name="username"
                                    class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2.5 text-sm text-slate-800 focus:bg-white focus:border-blue-500 focus:ring-2 focus:ring-blue-100 transition outline-none"
                                    value="{{ old('username', Auth::user()->username) }}">
                                @error('username')
                                    <div class="text-red-500 text-xs mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Email --}}
                            <div>
                                <label class="block text-xs font-semibold text-slate-700 mb-1.5">Alamat Email*</label>
                                <input type="email" name="email"
                                    class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2.5 text-sm text-slate-800 focus:bg-white focus:border-blue-500 focus:ring-2 focus:ring-blue-100 transition outline-none"
                                    value="{{ old('email', Auth::user()->email) }}">
                                @error('email')
                                    <div class="text-red-500 text-xs mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- No Telepon --}}
                            <div class="sm:col-span-2">
                                <label class="block text-xs font-semibold text-slate-700 mb-1.5">Nomor WhatsApp / HP*</label>
                                <input type="text" name="no_telepon"
                                    class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2.5 text-sm text-slate-800 placeholder:text-slate-400 focus:bg-white focus:border-blue-500 focus:ring-2 focus:ring-blue-100 transition outline-none"
                                    placeholder="Contoh: 081234567890"
                                    value="{{ old('no_telepon', Auth::user()->no_telepon) }}">
                                @error('no_telepon')
                                    <div class="text-red-500 text-xs mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    {{-- Section 3: Alamat --}}
                    <div class="bg-white rounded-2xl border border-slate-200/80 p-6 sm:p-7 shadow-xs">
                        <h2 class="text-base font-bold text-slate-900 mb-1 flex items-center gap-2">
                            <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                            Alamat Tempat Tinggal
                        </h2>
                        <p class="text-xs text-slate-400 mb-5">Alamat domisili saat ini untuk keperluan data keanggotaan.</p>

                        <div>
                            <label class="block text-xs font-semibold text-slate-700 mb-1.5">Alamat Lengkap*</label>
                            <textarea name="alamat" rows="3"
                                class="w-full bg-slate-50 border border-slate-200 rounded-xl p-3.5 text-sm text-slate-800 placeholder:text-slate-400 focus:bg-white focus:border-blue-500 focus:ring-2 focus:ring-blue-100 transition outline-none leading-relaxed"
                                placeholder="Tuliskan nama jalan, RT/RW, kelurahan, kecamatan, dan kota domisili Anda">{{ old('alamat', Auth::user()->Anggota->alamat ?? '') }}</textarea>
                            @error('alamat')
                                <div class="text-red-500 text-xs mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    {{-- Save Action Button Bar --}}
                    <div class="flex items-center justify-end gap-3 pt-2">
                        <button type="submit"
                            class="btn_simpan_perubahan px-8 py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-xl text-sm font-semibold shadow-xs transition flex items-center gap-2 cursor-pointer">
                            <svg class="spinner_load hidden animate-spin h-4 w-4 text-white"
                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor"
                                    d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                </path>
                            </svg>
                            <span class="text_simpan">Simpan Perubahan</span>
                        </button>
                    </div>

                </div>

            </div>
        </form>

        {{-- Hidden Form Delete Profile Picture --}}
        <form class="hidden" id="deleteProfilePicture" action="/foto-profile/{{ Auth::user()->id }}" method="POST">
            @csrf
            @method('DELETE')
        </form>
    </section>
@endsection
