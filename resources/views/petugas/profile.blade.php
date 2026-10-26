@extends('layouts.index')

@section('halaman', 'Profil Pustakawan')

@section('main')
    <section class="mt-8 max-w-4xl">
        {{-- Card Profil Container --}}
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6 sm:p-8">
            <form class="all_form space-y-8" action="/profile-petugas" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                {{-- Header Foto Profil --}}
                <div class="flex flex-col sm:flex-row items-center sm:items-start gap-6 pb-8 border-b border-slate-100">
                    <div class="relative group">
                        <img class="photoPreview w-24 h-24 rounded-2xl object-cover border-2 border-slate-200 shadow-sm"
                            src="{{ Auth::user()->profile_photo ? asset('storage/' . Auth::user()->profile_photo) : asset('icons/default-avatar.png') }}"
                            alt="Foto {{ Auth::user()->username }}">
                        <input type="file" class="photoInput" name="profile_photo" hidden accept="image/*">
                    </div>

                    <div class="flex flex-col items-center sm:items-start text-center sm:text-left flex-1">
                        <h3 class="text-xl font-bold text-slate-800 capitalize">{{ Auth::user()->username }}</h3>
                        <p class="text-xs text-slate-500 mt-0.5">Petugas / Pustakawan • ID: #{{ Auth::user()->id }}</p>

                        @error('profile_photo')
                            <div class="text-rose-500 text-xs mt-1.5 font-medium">{{ $message }}</div>
                        @enderror

                        <div class="flex items-center gap-3 mt-4">
                            <button type="button" class="uploadBtn bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-xl text-xs font-semibold cursor-pointer transition shadow-sm flex items-center gap-1.5">
                                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                                <span>Ganti Foto</span>
                            </button>
                            <button form="deleteProfilePicture" type="submit"
                                class="bg-slate-100 hover:bg-rose-50 hover:text-rose-600 text-slate-600 border border-slate-200 cursor-pointer px-4 py-2 rounded-xl text-xs font-semibold transition">
                                Hapus Foto
                            </button>
                        </div>
                    </div>
                </div>

                {{-- Form Fields (2 Kolom) --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    {{-- Username --}}
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-2">Username <span class="text-rose-500">*</span></label>
                        <input type="text" name="username"
                            class="w-full border border-slate-200 rounded-xl px-4 py-2.5 bg-slate-50 text-slate-800 text-sm focus:bg-white focus:border-blue-500 focus:ring-2 focus:ring-blue-100 transition outline-none"
                            value="{{ old('username', Auth::user()->username) }}" required>
                        @error('username')
                            <p class="text-rose-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Nama Lengkap --}}
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-2">Nama Lengkap <span class="text-rose-500">*</span></label>
                        <input type="text" name="nama_lengkap"
                            class="w-full border border-slate-200 rounded-xl px-4 py-2.5 bg-slate-50 text-slate-800 text-sm focus:bg-white focus:border-blue-500 focus:ring-2 focus:ring-blue-100 transition outline-none"
                            placeholder="Masukkan nama lengkap Anda"
                            value="{{ old('nama_lengkap', Auth::user()->petugas->nama_lengkap ?? '') }}" required>
                        @error('nama_lengkap')
                            <p class="text-rose-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Email --}}
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-2">Email <span class="text-rose-500">*</span></label>
                        <input type="email" name="email"
                            class="w-full border border-slate-200 rounded-xl px-4 py-2.5 bg-slate-50 text-slate-800 text-sm focus:bg-white focus:border-blue-500 focus:ring-2 focus:ring-blue-100 transition outline-none"
                            value="{{ old('email', Auth::user()->email) }}" required>
                        @error('email')
                            <p class="text-rose-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- NIK / NIS --}}
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-2">Nomor Induk Petugas / NIK <span class="text-rose-500">*</span></label>
                        <input type="text" name="nomer_induk"
                            class="w-full border border-slate-200 rounded-xl px-4 py-2.5 bg-slate-50 text-slate-800 text-sm font-mono focus:bg-white focus:border-blue-500 focus:ring-2 focus:ring-blue-100 transition outline-none"
                            placeholder="Contoh: 198701012015011001"
                            value="{{ old('nomer_induk', Auth::user()->petugas->nomer_induk ?? '') }}" required>
                        @error('nomer_induk')
                            <p class="text-rose-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- No Telepon --}}
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-2">Nomor Telepon / WhatsApp <span class="text-rose-500">*</span></label>
                        <input type="text" name="no_telepon"
                            class="w-full border border-slate-200 rounded-xl px-4 py-2.5 bg-slate-50 text-slate-800 text-sm focus:bg-white focus:border-blue-500 focus:ring-2 focus:ring-blue-100 transition outline-none"
                            placeholder="Contoh: 081234567890"
                            value="{{ old('no_telepon', Auth::user()->no_telepon) }}" required>
                        @error('no_telepon')
                            <p class="text-rose-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Jenis Kelamin --}}
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-2">Jenis Kelamin <span class="text-rose-500">*</span></label>
                        <select name="jenis_kelamin"
                            class="w-full border border-slate-200 rounded-xl px-4 py-2.5 bg-slate-50 text-slate-800 text-sm focus:bg-white focus:border-blue-500 focus:ring-2 focus:ring-blue-100 transition outline-none cursor-pointer" required>
                            <option value="" disabled {{ old('jenis_kelamin', Auth::user()->petugas->jenis_kelamin ?? '') == '' ? 'selected' : '' }}>
                                Pilih Jenis Kelamin
                            </option>
                            <option value="Laki-laki" {{ old('jenis_kelamin', Auth::user()->petugas->jenis_kelamin ?? '') == 'Laki-laki' ? 'selected' : '' }}>
                                Laki-laki
                            </option>
                            <option value="Perempuan" {{ old('jenis_kelamin', Auth::user()->petugas->jenis_kelamin ?? '') == 'Perempuan' ? 'selected' : '' }}>
                                Perempuan
                            </option>
                        </select>
                        @error('jenis_kelamin')
                            <p class="text-rose-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Tanggal Lahir --}}
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-2">Tanggal Lahir <span class="text-rose-500">*</span></label>
                        <input type="date" name="tanggal_lahir"
                            class="w-full border border-slate-200 rounded-xl px-4 py-2.5 bg-slate-50 text-slate-800 text-sm focus:bg-white focus:border-blue-500 focus:ring-2 focus:ring-blue-100 transition outline-none"
                            value="{{ old('tanggal_lahir', Auth::user()->petugas->tanggal_lahir ?? '') }}">
                        @error('tanggal_lahir')
                            <p class="text-rose-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Alamat --}}
                    <div class="md:col-span-2">
                        <label class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-2">Alamat Domisili <span class="text-rose-500">*</span></label>
                        <textarea name="alamat" rows="3"
                            class="w-full border border-slate-200 rounded-xl px-4 py-2.5 bg-slate-50 text-slate-800 text-sm focus:bg-white focus:border-blue-500 focus:ring-2 focus:ring-blue-100 transition outline-none resize-none leading-relaxed"
                            placeholder="Masukkan alamat domisili lengkap...">{{ old('alamat', Auth::user()->petugas->alamat ?? '') }}</textarea>
                        @error('alamat')
                            <p class="text-rose-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                {{-- Submit Action --}}
                <div class="flex items-center justify-end pt-4 border-t border-slate-100">
                    <button type="submit"
                        class="btn_simpan_perubahan bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2.5 px-6 rounded-xl transition cursor-pointer flex items-center gap-2 shadow-sm text-sm">
                        <svg class="spinner_load hidden animate-spin h-4 w-4 text-white"
                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        <span class="text_simpan">Simpan Perubahan</span>
                    </button>
                </div>
            </form>

            {{-- Form Hapus Foto Profile --}}
            <form class="hidden" id="deleteProfilePicture" action="/foto-profile/{{ Auth::user()->id }}" method="POST">
                @csrf
                @method('DELETE')
            </form>
        </div>
    </section>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const uploadBtn = document.querySelector('.uploadBtn');
            const photoInput = document.querySelector('.photoInput');
            const photoPreview = document.querySelector('.photoPreview');

            if (uploadBtn && photoInput) {
                uploadBtn.addEventListener('click', () => photoInput.click());
                photoInput.addEventListener('change', function() {
                    if (this.files && this.files[0]) {
                        const reader = new FileReader();
                        reader.onload = e => {
                            if (photoPreview) photoPreview.src = e.target.result;
                        };
                        reader.readAsDataURL(this.files[0]);
                    }
                });
            }
        });
    </script>
@endsection
