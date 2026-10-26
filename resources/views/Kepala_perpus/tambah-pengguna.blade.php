@extends('layouts.index')

@section('halaman', 'Tambah Pengguna')

@section('main')

    <section class="mt-10">
        <form class="all_form" action="/daftar-pengguna/tambah-pengguna" method="POST" enctype="multipart/form-data">
            @csrf
            {{-- POTO Profile --}}
            <div class="">
                <img class="photoPreview w-32 h-32 object-cover border border-gray-200 p-1" id=""
                    src="{{ asset('icons/default-avatar.png') }}" alt="">
                <input type="file" class="photoInput" name="profile_photo" hidden>

                <button class="uploadBtn bg-[#35094D] text-white px-5 py-1 rounded-sm cursor-pointer" type="button"
                    id="">Upload File</button>
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
                        <input type="text" name="username" id="usernameInput"
                            class="mt-1 block w-full border border-gray-200 rounded-md bg-white p-2 text-gray-400"
                            value="{{ old('username') }}" placeholder="Masukan Username">
                    </div>

                    {{-- Email --}}
                    <div class="my-5">
                        <label for="email" class="block text-sm font-medium text-gray-700">Email*</label>
                        @error('email')
                            <div class="text-red-500 text-[14px]">{{ $message }}</div>
                        @enderror
                        <div class="relative">
                            <input type="email" name="email" id="emailInput"
                                class="mt-1 block w-full border border-gray-200 rounded-md bg-white p-2 text-gray-400"
                                value="{{ old('email') }}" placeholder="Masukan Email">
                            <span id="emailDomainBadge" class="hidden absolute right-3 top-1/2 -translate-y-1/2 text-xs font-semibold text-cyan-400 bg-cyan-500/10 border border-cyan-500/30 px-2 py-0.5 rounded-lg pointer-events-none">
                                @mylibrary.com
                            </span>
                        </div>
                        <p id="emailAutoHint" class="hidden text-xs text-cyan-400 mt-1">✦ Email otomatis dibuat dari username</p>
                    </div>

                    {{-- No telp --}}
                    <div class="my-5">
                        <label for="no_telp" class="block text-sm font-medium text-gray-700">No Telepon*</label>
                        @error('no_telepon')
                            <div class="text-red-500 text-[14px]">{{ $message }}</div>
                        @enderror
                        <input type="text" name="no_telepon"
                            class="mt-1 block w-full border border-gray-200 rounded-md bg-white p-2 text-gray-400"
                            value="{{ old('no_telepon') }}" placeholder="Masukan No Telp">
                    </div>

                    {{-- Password --}}
                    <div class="my-5">
                        <label for="password" class="block text-sm font-medium text-gray-700">Password*</label>
                        @error('password')
                            <div class="text-red-500 text-[14px]">{{ $message }}</div>
                        @enderror
                        <div class="flex items-center relative">
                            <input
                                class="password mt-1 block w-full border border-gray-200 rounded-md bg-white p-2 text-gray-400"
                                type="password" name="password" id="" placeholder="Password" />

                            <button type="button" onclick="togglePassword()"
                                class="absolute right-3 text-gray-500 focus:outline-none">
                                <!-- Eye Open -->
                                <svg id="" xmlns="http://www.w3.org/2000/svg" class="eye-open h-5 w-5"
                                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5
                                                c4.477 0 8.268 2.943 9.542 7
                                                -1.274 4.057-5.065 7-9.542 7
                                                -4.477 0-8.268-2.943-9.542-7z" />
                                </svg>

                                <!-- Eye Closed -->
                                <svg id="" xmlns="http://www.w3.org/2000/svg" class="eye-close h-5 w-5 hidden"
                                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19
                                                c-4.478 0-8.268-2.943-9.543-7
                                                a9.956 9.956 0 012.223-3.592M6.18 6.18
                                                A9.956 9.956 0 0112 5
                                                c4.478 0 8.268 2.943 9.543 7
                                                a9.96 9.96 0 01-4.043 4.568M6.18 6.18L4 4
                                                m2.18 2.18l11.64 11.64" />
                                </svg>
                            </button>
                        </div>
                    </div>

                    {{-- Jenis Kelamin --}}
                    <div class="my-5">
                        <label class="block text-sm font-medium text-gray-700">Pilih Role*</label>
                        @error('role')
                            <div class="text-red-500 text-[14px]">{{ $message }}</div>
                        @enderror
                        <select name="role" id="roleSelect"
                            class="mt-1 block w-full border border-gray-200 text-gray-400 rounded-md bg-white p-2">
                            <option value="" disabled {{ old('role') ? '' : 'selected' }}>
                                Pilih Role
                            </option>

                            <option value="anggota" {{ old('role') == 'anggota' ? 'selected' : '' }}>
                                Anggota
                            </option>

                            <option value="petugas" {{ old('role') == 'petugas' ? 'selected' : '' }}>
                                Petugas
                            </option>

                            <option value="kepala_perpus" {{ old('role') == 'kepala_perpus' ? 'selected' : '' }}>
                                Kepala Perpustakaan
                            </option>
                        </select>
                    </div>

                </div>

                {{-- data lainya --}}
                <div class="w-1/2">
                    {{-- Nama Lengkap --}}
                    <div class="my-5">
                        <label for="nama" class="block text-sm font-medium text-gray-700">Nama Lengkap*</label>
                        @error('nama_lengkap')
                            <div class="text-red-500 text-[14px]">{{ $message }}</div>
                        @enderror
                        <input type="text" name="nama_lengkap"
                            class="mt-1 block w-full border border-gray-200 rounded-md bg-white p-2 text-gray-400"
                            placeholder="Masukan Nama Lengkap" value="{{ old('nama_lengkap') }}">
                    </div>

                    {{-- Nomer Induk --}}
                    <div class="my-5">
                        <label for="nomer_induk" class="block text-sm font-medium text-gray-700">Nomer Induk*</label>
                        @error('nomer_induk')
                            <div class="text-red-500 text-[14px]">{{ $message }}</div>
                        @enderror
                        <input type="text" name="nomer_induk"
                            class="mt-1 block w-full border border-gray-200 rounded-md bg-white p-2 text-gray-400"
                            placeholder="Masukan NIS/NIK" value="{{ old('nomer_induk') }}">
                    </div>

                    {{-- Jenis Kelamin --}}
                    <div class="my-5">
                        <label class="block text-sm font-medium text-gray-700">Jenis Kelamin*</label>
                        @error('jenis_kelamin')
                            <div class="text-red-500 text-[14px]">{{ $message }}</div>
                        @enderror
                        <select name="jenis_kelamin"
                            class="mt-1 block w-full border border-gray-200 text-gray-400 rounded-md bg-white p-2">
                            <option value="" disabled {{ old('jenis_kelamin') ? '' : 'selected' }}>
                                Pilih Jenis Kelamin
                            </option>

                            <option value="Laki-laki" {{ old('jenis_kelamin') == 'Laki-laki' ? 'selected' : '' }}>
                                Laki-Laki
                            </option>

                            <option value="Perempuan" {{ old('jenis_kelamin') == 'Perempuan' ? 'selected' : '' }}>
                                Perempuan
                            </option>
                        </select>
                    </div>

                    {{-- Tanggal Lahir --}}
                    <div class="my-5">
                        <label for="tanggal_lahir" class="block text-sm font-medium text-gray-700">Tanggal Lahir*</label>
                        @error('tanggal_lahir')
                            <div class="text-red-500 text-[14px]">{{ $message }}</div>
                        @enderror
                        <input type="date" name="tanggal_lahir"
                            class="mt-1 block w-full border border-gray-200 rounded-md bg-white p-2 text-gray-400"
                            value="{{ old('tanggal_lahir') }}">
                    </div>

                    {{-- Alamat --}}
                    <div class="my-5">
                        <label for="alamat" class="block text-sm font-medium text-gray-700">Alamat*</label>
                        @error('alamat')
                            <div class="text-red-500 text-[14px]">{{ $message }}</div>
                        @enderror
                        <textarea type="text" name="alamat"
                            class="mt-1 block w-full border border-gray-200 rounded-md bg-white p-2 text-gray-400"
                            placeholder="Masukan Alamat">{{ old('alamat') }}</textarea>
                    </div>
                </div>
            </div>

            {{-- Action --}}
            <div class="flex justify-between">
                {{-- Kembali --}}
                <button type="button" onclick="window.history.back()"
                    class="bg-[#000080] font-medium px-10 py-2 cursor-pointer rounded-lg">Kembali</button>

                {{-- Btn Simpan Perubahan --}}
                <button id="" type="submit"
                    class="btn_simpan_perubahan bg-[#35094D] text-white py-2 px-10 cursor-pointer rounded mt-5 flex items-center gap-2">
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
        </form>
    </section>

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const usernameInput = document.getElementById('usernameInput');
        const emailInput = document.getElementById('emailInput');
        const roleSelect = document.getElementById('roleSelect');
        const emailDomainBadge = document.getElementById('emailDomainBadge');
        const emailAutoHint = document.getElementById('emailAutoHint');

        let emailManuallyEdited = false;

        function sanitizeForEmail(username) {
            return username
                .toLowerCase()
                .trim()
                .replace(/[^a-z0-9\s._-]/g, '') // hapus karakter spesial
                .replace(/\s+/g, '.')             // spasi jadi titik
                .replace(/\.{2,}/g, '.')           // hapus titik ganda
                .replace(/^\.+|\.+$/g, '');        // hapus titik awal/akhir
        }

        function isStaffRole() {
            return roleSelect.value === 'petugas' || roleSelect.value === 'kepala_perpus';
        }

        function generateEmail() {
            if (!isStaffRole() || emailManuallyEdited) return;

            const username = usernameInput.value;
            if (username.trim() === '') {
                emailInput.value = '';
                return;
            }

            const sanitized = sanitizeForEmail(username);
            if (sanitized) {
                emailInput.value = sanitized + '@mylibrary.com';
            }
        }

        function updateUIState() {
            if (isStaffRole()) {
                emailDomainBadge.classList.remove('hidden');
                emailAutoHint.classList.remove('hidden');
                emailInput.placeholder = 'Otomatis dari username';
                emailManuallyEdited = false;
                generateEmail();
            } else {
                emailDomainBadge.classList.add('hidden');
                emailAutoHint.classList.add('hidden');
                emailInput.placeholder = 'Masukan Email';
                // Kosongkan jika masih @mylibrary.com
                if (emailInput.value.endsWith('@mylibrary.com')) {
                    emailInput.value = '';
                }
            }
        }

        // Event listeners
        roleSelect.addEventListener('change', updateUIState);

        usernameInput.addEventListener('input', function() {
            if (isStaffRole() && !emailManuallyEdited) {
                generateEmail();
            }
        });

        // Deteksi jika admin sengaja mengedit email secara manual
        emailInput.addEventListener('input', function() {
            if (isStaffRole()) {
                const username = usernameInput.value;
                const expected = sanitizeForEmail(username) + '@mylibrary.com';
                // Jika user mengetik sesuatu yang berbeda dari auto-generated, tandai manual
                emailManuallyEdited = (emailInput.value !== expected && emailInput.value !== '');
            }
        });

        // Inisialisasi saat load (untuk kasus old() values)
        if (roleSelect.value) {
            updateUIState();
        }
    });
</script>
@endsection
@endsection
