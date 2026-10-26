@extends('layouts.index')

@section('halaman', 'Profile')
@section('suffix', 'Anda!')

@section('main')

    {{-- FORM PROFILE --}}
    <section class="mt-20">
        <form class="all_form" action="/profile-kepala-perpus" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            {{-- POTO Profile --}}
            <div class="flex items-center gap-5">
                <img class="photoPreview w-20 h-20 object-cover rounded-2xl border border-cyan-500/30 p-1 bg-slate-900/60 shadow-lg" id="" src="{{ Auth::user()->profile_photo
        ? asset('storage/' . Auth::user()->profile_photo)
        : asset('icons/default-avatar.png') }}" alt="Profile Photo">
                <input type="file" class="photoInput" name="profile_photo" hidden>

                <div class="flex flex-col">
                    <span class="text-[20px] text-white font-bold capitalize">{{ Auth::user()->username }}</span>
                    <span class="text-cyan-400 text-xs font-semibold mt-0.5">Admin #{{ Auth::user()->id }}</span>
                    @error('profile_photo')
                        <div class="text-rose-400 text-xs mt-1">{{ $message }}</div>
                    @enderror
                </div>
                <div class="flex items-center gap-3 ml-8">
                    <button class="uploadBtn bg-gradient-to-r from-cyan-600 to-cyan-500 hover:from-cyan-500 hover:to-cyan-400 text-white px-5 py-2.5 rounded-xl font-medium text-sm transition-all shadow-md shadow-cyan-900/30 cursor-pointer" type="button"
                        id="">Upload Foto Baru</button>
                    <button form="deleteProfilePicture"
                        class="text-rose-400 border border-rose-500/40 hover:bg-rose-500/10 px-5 py-2.5 rounded-xl font-medium text-sm transition-all cursor-pointer"
                        type="submit">Hapus Foto</button>
                </div>
            </div>
            {{-- END PTO PROFILE --}}

            {{-- Input BioData --}}
            <div class="flex gap-8 items-start">
                {{-- Default Input Data --}}
                <div class="w-1/2">
                    {{-- Username --}}
                    <div class="my-5">
                        <label for="nama" class="block text-sm font-medium text-gray-700">Username*</label>
                        @error('username')
                            <div class="text-red-500 text-[14px]">{{ $message }}</div>
                        @enderror
                        <input type="text" name="username"
                            class="mt-1 block w-full border border-gray-200 rounded-md bg-white p-2 text-gray-400"
                            value="{{ Auth::user()->username }}">
                    </div>

                    {{-- Email --}}
                    <div class="my-5">
                        <label for="email" class="block text-sm font-medium text-gray-700">Email*</label>
                        @error('email')
                            <div class="text-red-500 text-[14px]">{{ $message }}</div>
                        @enderror
                        <input type="email" name="email"
                            class="mt-1 block w-full border border-gray-200 rounded-md bg-white p-2 text-gray-400"
                            value="{{ Auth::user()->email }}">
                    </div>

                    {{-- No telp --}}
                    <div class="my-5">
                        <label for="no_telp" class="block text-sm font-medium text-gray-700">No Telepon*</label>
                        @error('no_telepon')
                            <div class="text-red-500 text-[14px]">{{ $message }}</div>
                        @enderror
                        <input type="text" name="no_telepon"
                            class="mt-1 block w-full border border-gray-200 rounded-md bg-white p-2 text-gray-400"
                            value="{{ Auth::user()->no_telepon }}">
                    </div>

                    {{-- Tanggal Lahir --}}
                    <div class="my-5">
                        <label for="tanggal_lahir" class="block text-sm font-medium text-gray-700">Tanggal Lahir*</label>
                        @error('tanggal_lahir')
                            <div class="text-red-500 text-[14px]">{{ $message }}</div>
                        @enderror
                        <input type="date" name="tanggal_lahir"
                            class="mt-1 block w-full border border-gray-200 rounded-md bg-white p-2 text-gray-400"
                            value="{{ Auth::user()->KepalaPerpus->tanggal_lahir ?? '' }}">
                    </div>
                </div>

                {{-- data laina --}}
                <div class="w-1/2">
                    {{-- Nama Lengkap --}}
                    <div class="my-5">
                        <label for="nama" class="block text-sm font-medium text-gray-700">Nama Lengkap*</label>
                        @error('nama_lengkap')
                            <div class="text-red-500 text-[14px]">{{ $message }}</div>
                        @enderror
                        <input type="text" name="nama_lengkap"
                            class="mt-1 block w-full border border-gray-200 rounded-md bg-white p-2 text-gray-400"
                            placeholder="Masukan Nama Lengkap Anda"
                            value="{{ old('nama_lengkap', Auth::user()->KepalaPerpus->nama_lengkap ?? '') }}">
                    </div>

                    {{-- Nomer Induk --}}
                    <div class="my-5">
                        <label for="nomer_induk" class="block text-sm font-medium text-gray-700">Nomer Induk*</label>
                        @error('nomer_induk')
                            <div class="text-red-500 text-[14px]">{{ $message }}</div>
                        @enderror
                        <input type="text" name="nomer_induk"
                            class="mt-1 block w-full border border-gray-200 rounded-md bg-white p-2 text-gray-400"
                            placeholder="Masukan NIS/NIK Anda"
                            value="{{ old('nomer_induk', Auth::user()->KepalaPerpus->nomer_induk ?? '') }}">
                    </div>

                    {{-- Jenis Kelamin --}}
                    <div class="my-5">
                        <label class="block text-sm font-medium text-gray-700">Jenis Kelamin*</label>

                        <select name="jenis_kelamin"
                            class="mt-1 block w-full border border-gray-200 text-gray-400 rounded-md bg-white p-2">

                            <option value="" disabled {{ old('jenis_kelamin', Auth::user()->KepalaPerpus->jenis_kelamin ?? '') == '' ? 'selected' : '' }}>
                                Pilih Jenis Kelamin
                            </option>

                            <option value="Laki-laki" {{ old('jenis_kelamin', Auth::user()->KepalaPerpus->jenis_kelamin ?? '') == 'Laki-laki' ? 'selected' : '' }}>
                                Laki-laki
                            </option>

                            <option value="Perempuan" {{ old('jenis_kelamin', Auth::user()->KepalaPerpus->jenis_kelamin ?? '') == 'Perempuan' ? 'selected' : '' }}>
                                Perempuan
                            </option>

                        </select>
                    </div>

                    {{-- Alamat --}}
                    <div class="my-5">
                        <label for="alamat" class="block text-sm font-medium text-gray-700">Alamat*</label>
                        @error('alamat')
                            <div class="text-red-500 text-[14px]">{{ $message }}</div>
                        @enderror
                        <textarea type="text" name="alamat"
                            class="mt-1 block w-full border border-gray-200 rounded-md bg-white p-2 text-gray-400"
                            placeholder="Masukan Alamat Anda">{{ Auth::user()->KepalaPerpus->alamat ?? '' }}</textarea>
                    </div>
                </div>
            </div>

            {{-- Action --}}
            <div class="flex justify-end">
                <button id="" type="submit"
                    class="btn_simpan_perubahan bg-[#35094D] text-white py-2 px-10 cursor-pointer rounded mt-5 flex items-center gap-2">
                    <svg id="" class="spinner_load hidden animate-spin h-5 w-5 text-white"
                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4">
                        </circle>
                        <path class="opacity-75" fill="currentColor"
                            d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                        </path>
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

    </section>
@endsection