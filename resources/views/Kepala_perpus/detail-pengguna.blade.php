@extends('layouts.index')

@section('halaman')
    Detail Pengguna - {{ $User->username }}
@endsection

@section('main')
    <section class="mt-20">
        {{-- Header --}}
        <div class="flex flex-col mb-5">
            @if ($User->role === 'anggota')
                <span
                    class="font-medium text-[#35094D] text-[24px] capitalize">{{ $User->username }}({{ $User->Anggota->nomer_induk ?? 'Nomer Induk Belum Di Atur.' }})</span>
                <span class="text-gray-400 text-[20px]">{{ $User->role }}#{{ $User->id }}</span>
            @endif
            @if ($User->role === 'petugas')
                <span
                    class="font-medium text-[#35094D] text-[24px] capitalize">{{ $User->username }}({{ $User->Petugas->nomer_induk ?? $User->petugas->nomer_induk ?? 'Nomer Induk Belum Di Atur.' }})</span>
                <span class="text-gray-400 text-[20px]">{{ $User->role }}#{{ $User->id }}</span>
            @endif
            @if ($User->role === 'kepala_perpus')
                <span
                    class="font-medium text-[#35094D] text-[24px] capitalize">{{ $User->username }}({{ $User->kepalaPerpus->nomer_induk ?? 'Nomer Induk Belum Di Atur.' }})</span>
                <span class="text-gray-400 text-[20px]">{{ $User->role }}#{{ $User->id }}</span>
            @endif
        </div>
        {{-- Kontn utama detail pengguna --}}
        <div class="flex gap-10">
            <img class="photoPreview w-80 h-80 object-cover border border-gray-200 p-1" id=""
                src="{{ $User->profile_photo ? asset('storage/' . $User->profile_photo) : asset('icons/default-avatar.png') }}"
                alt="">
            <div class="flex gap-40">
                {{-- Basic Data --}}
                <div>
                    <div class="mb-4">
                        <span class="text-[20px] text-[#35094D] font-medium">Username: </span>
                        <span class="block text-[18px] text-gray-400 capitalize">{{ $User->username }}</span>
                    </div>
                    <div class="mb-4">
                        <span class="text-[20px] text-[#35094D] font-medium">Email: </span>
                        <span class="block text-[18px] text-gray-400">{{ $User->email }}</span>
                    </div>
                    <div class="mb-4">
                        <span class="text-[20px] text-[#35094D] font-medium">No Telp: </span>
                        <span class="block text-[18px] text-gray-400">{{ $User->no_telepon }}</span>
                    </div>
                    <div class="mb-4">
                        <span class="text-[20px] text-[#35094D] font-medium">Role: </span>
                        <span class="block text-[18px] text-gray-400">{{ $User->role }}</span>
                    </div>
                    <div class="mb-4">
                        <span class="text-[20px] text-[#35094D] font-medium">Bergabung Pada: </span>
                        <span
                            class="block text-[18px] text-gray-400">{{ $User->created_at->translatedFormat('l, d F Y') }}</span>
                    </div>
                </div>
                {{-- Data Lainya --}}
                <div>
                    <div class="mb-4">
                        <span class="text-[20px] text-[#35094D] font-medium">Nomor Induk: </span>
                        {{-- Anggota - Nomer Induk --}}
                        @if ($User->role === 'anggota')
                            <span class="block text-[18px] text-gray-400">{{ $User->anggota->nomer_induk ?? 'N/A' }}</span>
                        @endif
                        {{-- Petugas - Nomor Induk --}}
                        @if ($User->role === 'petugas')
                            <span class="block text-[18px] text-gray-400">{{ $User->petugas->nomer_induk ?? 'N/A' }}</span>
                        @endif
                        {{-- Kepala Perpus - Nomer Induk --}}
                        @if ($User->role === 'kepala_perpus')
                            <span
                                class="block text-[18px] text-gray-400">{{ $User->KepalaPerpus->nomer_induk ?? 'N/A' }}</span>
                        @endif
                    </div>
                    <div class="mb-4">
                        <span class="text-[20px] text-[#35094D] font-medium">Nama Lengkap: </span>
                        {{-- Anggota - Nama Lengkap --}}
                        @if ($User->role === 'anggota')
                            <span
                                class="block text-[18px] text-gray-400">{{ $User->anggota->nama_lengkap ?? 'N/A' }}</span>
                        @endif
                        {{-- Petugas - Nama Lengkap --}}
                        @if ($User->role === 'petugas')
                            <span
                                class="block text-[18px] text-gray-400">{{ $User->petugas->nama_lengkap ?? 'N/A' }}</span>
                        @endif
                        {{-- Kepala Perpus - Nama Lengkap --}}
                        @if ($User->role === 'kepala_perpus')
                            <span
                                class="block text-[18px] text-gray-400">{{ $User->KepalaPerpus->nama_lengkap ?? 'N/A' }}</span>
                        @endif
                    </div>
                    <div class="mb-4">
                        <span class="text-[20px] text-[#35094D] font-medium">Jenis Kelamin: </span>
                        {{-- Anggota - Jenis Kelamin --}}
                        @if ($User->role === 'anggota')
                            <span
                                class="block text-[18px] text-gray-400">{{ $User->anggota->jenis_kelamin ?? 'N/A' }}</span>
                        @endif
                        {{-- Petugas - Jenis Kelamin --}}
                        @if ($User->role === 'petugas')
                            <span
                                class="block text-[18px] text-gray-400">{{ $User->petugas->jenis_kelamin ?? 'N/A' }}</span>
                        @endif
                        {{-- Kepala Perpus - Jenis Kelamin --}}
                        @if ($User->role === 'kepala_perpus')
                            <span
                                class="block text-[18px] text-gray-400">{{ $User->KepalaPerpus->jenis_kelamin ?? 'N/A' }}</span>
                        @endif
                    </div>
                    <div class="mb-4">
                        <span class="text-[20px] text-[#35094D] font-medium">Tanggal Lahir: </span>
                        {{-- Anggota - Tgl Lahir --}}
                        @if ($User->role === 'anggota')
                            <span
                                class="block text-[18px] text-gray-400">{{ $User->anggota->tanggal_lahir ?? 'N/A' }}</span>
                        @endif
                        {{-- Petugas - Tgl Lahir --}}
                        @if ($User->role === 'petugas')
                            <span
                                class="block text-[18px] text-gray-400">{{ $User->petugas->tanggal_lahir ?? 'N/A' }}</span>
                        @endif
                        {{-- kepala Perpus - Tgl Lahir --}}
                        @if ($User->role === 'kepala_perpus')
                            <span
                                class="block text-[18px] text-gray-400">{{ $User->KepalaPerpus->tanggal_lahir ?? 'N/A' }}</span>
                        @endif
                    </div>
                    <div class="mb-4">
                        <span class="text-[20px] text-[#35094D] font-medium">Alamat Lengkap: </span>
                        {{-- Anggota - Alamat --}}
                        @if ($User->role === 'anggota')
                            <span class="block text-[18px] text-gray-400">{{ $User->anggota->alamat ?? 'N/A' }}</span>
                        @endif
                        {{-- Petugas - Alamat --}}
                        @if ($User->role === 'petugas')
                            <span class="block text-[18px] text-gray-400">{{ $User->petugas->alamat ?? 'N/A' }}</span>
                        @endif
                        {{-- Petugas - Alamat --}}
                        @if ($User->role === 'kepala_perpus')
                            <span class="block text-[18px] text-gray-400">{{ $User->KepalaPerpus->alamat ?? 'N/A' }}</span>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <div class="flex justify-between mt-6">
            <button onclick="window.history.back()"
                class="bg-[#000080] font-medium px-8 py-3 cursor-pointer rounded-lg">Kembali</button>
            <div>
                <button data-user-id="{{ $User->id }}"
                    class="btn_open_delete bg-[#FFC5C5] text-white font-medium px-10 py-3 cursor-pointer rounded-lg">Hapus
                    Akun</button>
                <button onclick="window.location=`/daftar-pengguna/edit/pengguna_perpustakaan={{ $User->id }}`"
                    class="bg-[#F99D2282] text-white font-medium px-10 py-3 cursor-pointer rounded-lg">Edit
                    Akun</button>
            </div>
        </div>
    </section>

    {{-- Modal Delete Pengguna --}}
    <section
        class="open_modal_delete_pengguna hidden fixed inset-0 bg-black/40 backdrop-blur-sm flex justify-center items-center z-50">
        <div class="bg-white p-8 w-full max-w-[32rem] rounded-xl">
            <div class="flex flex-col items-center gap-4">
                <img class="w-36" src="{{ asset('icons/svg/delete-icon.svg') }}" alt="">
                <span class="text-[#35094D] font-bold text-center">
                    Yakin ingin Hapus pengguna ini? <br>
                    <span class="font-normal text-[14px]">Tindakan Ini Akan Hapus Data Secara Permanen.</span>
                </span>
            </div>
            <div class="flex justify-center gap-4 my-6">
                <button
                    class="btn_close_delete_pengguna border border-gray-200 text-[#35094D] px-10 py-2 rounded-full cursor-pointer">
                    Batal
                </button>
                <form class="delete_form_pengguna" action="" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                        class="btn_delete_pengguna bg-[#35094D] text-white px-10 py-2 rounded-full flex items-center justify-center gap-2 min-w-[140px]">
                        <span class="text_close_delete_pengguna">Ya, Hapus</span>
                        <svg class="spinner_delete hidden animate-spin h-5 w-5 text-white"
                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z">
                            </path>
                        </svg>
                    </button>
                </form>
            </div>
        </div>
    </section>

    @if (session('error'))
        <section class="success_modal fixed inset-0 bg-black/40 backdrop-blur-sm flex justify-center items-center z-50">
            <div class="bg-white p-6 w-full max-w-[30rem] rounded-xl">

                {{-- Keterangan Modal --}}
                <div class="flex flex-col items-center gap-4">
                    <img class="w-52 -ml-20" src="{{ asset('icons/svg/oops.svg') }}" alt="">
                    <span class="text-[#35094D] font-bold text-center">
                        {!! session('error') !!}
                    </span>
                </div>

                {{-- Action Buttons --}}
                <div class="flex justify-end my-6">
                    <button class="close_modal_success bg-[#35094D] text-white px-10 py-2 rounded-full cursor-pointer">
                        Kembali
                    </button>
                </div>
            </div>
        </section>
        <script>
            document.querySelector('.close_modal_success')?.addEventListener('click', function() {
                document.querySelector('.success_modal').remove();
                location.reload();
            });
        </script>
    @endif
@endsection
