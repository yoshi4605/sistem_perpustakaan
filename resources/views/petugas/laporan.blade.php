@extends('layouts.index')

@section('halaman', 'Kelola Laporan Petugas')

@section('main')
    {{-- Header & Action Bar --}}
    <section class="mt-8 flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center font-bold">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
            </div>
            <div>
                <h2 class="text-xl font-bold text-slate-800">Arsip Laporan Petugas</h2>
                <p class="text-xs text-slate-500 mt-0.5">Kelola berkas laporan sirkulasi dan dokumen pertanggungjawaban</p>
            </div>
        </div>

        <div class="flex items-center gap-3">
            {{-- Filter Tanggal --}}
            <form action="/laporan" method="GET" class="flex items-center gap-2">
                <input name="cari" type="date"
                    class="bg-white px-3 py-2.5 rounded-xl border border-slate-200 text-slate-700 text-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-100 transition outline-none"
                    value="{{ request('cari') }}">
                <button type="submit"
                    class="bg-blue-600 text-white px-4 py-2.5 rounded-xl hover:bg-blue-700 transition font-medium text-sm cursor-pointer shadow-sm flex items-center gap-1.5">
                    <span>Cari</span>
                </button>
            </form>

            {{-- Tombol Upload --}}
            <button type="button" id="openUploadLaporan"
                class="flex items-center gap-2 bg-slate-900 hover:bg-slate-800 rounded-xl text-white font-medium text-sm cursor-pointer px-4 py-2.5 shadow-sm transition">
                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" />
                </svg>
                <span>Upload Laporan</span>
            </button>
        </div>
    </section>

    {{-- Table Section --}}
    <section class="mt-6">
        <div class="bg-white w-full rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
            <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between bg-slate-50/60">
                <div class="flex items-center gap-2">
                    <span class="w-2.5 h-2.5 rounded-full bg-blue-500"></span>
                    <span class="text-sm font-semibold text-slate-700">Daftar Dokumen Laporan</span>
                </div>
                <span class="text-xs text-slate-500 bg-white px-3 py-1 rounded-full border border-slate-200">
                    Total: {{ count($laporans) }} Dokumen
                </span>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm">
                    <thead>
                        <tr class="bg-slate-50/80 border-b border-slate-200 text-slate-500 text-xs uppercase tracking-wider font-semibold">
                            <th class="py-3.5 px-4">Tipe Laporan</th>
                            <th class="py-3.5 px-4 text-center">Petugas Pengunggah</th>
                            <th class="py-3.5 px-4 text-center">Tanggal Upload</th>
                            <th class="py-3.5 px-4 text-center">Status</th>
                            <th class="py-3.5 px-4 text-center">Berkas</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse ($laporans as $laporan)
                            <tr class="hover:bg-slate-50/80 transition-colors">
                                <td class="py-4 px-4 font-semibold text-slate-800">
                                    {{ $laporan->tipe_laporan ?? 'Laporan Umum' }}
                                </td>
                                <td class="py-4 px-4 text-center text-slate-700 font-medium">
                                    {{ $laporan->petugas->nama_lengkap ?? $laporan->petugas->username ?? '-' }}
                                </td>
                                <td class="py-4 px-4 text-center text-slate-500 font-mono text-xs">
                                    {{ $laporan->created_at ? $laporan->created_at->translatedFormat('d M Y, H:i') : '-' }}
                                </td>
                                <td class="py-4 px-4 text-center">
                                    <span class="inline-flex items-center gap-1.5 bg-blue-50 text-blue-700 border border-blue-200 px-3 py-0.5 rounded-full text-xs font-semibold">
                                        <span class="w-1.5 h-1.5 rounded-full bg-blue-500"></span>
                                        {{ $laporan->status ?? 'Terkirim' }}
                                    </span>
                                </td>
                                <td class="py-4 px-4 text-center">
                                    <a href="{{ asset('storage/' . $laporan->file) }}" target="_blank"
                                        class="inline-flex items-center gap-1.5 text-xs font-semibold text-blue-600 bg-blue-50 hover:bg-blue-100 border border-blue-200 px-3 py-1.5 rounded-lg transition">
                                        <svg class="w-3.5 h-3.5 text-blue-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                        </svg>
                                        <span>Buka PDF</span>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-12">
                                    <div class="flex flex-col items-center justify-center">
                                        <div class="w-12 h-12 rounded-full bg-slate-100 flex items-center justify-center text-slate-400 mb-2">
                                            <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                            </svg>
                                        </div>
                                        <p class="text-sm font-medium text-slate-700">Belum ada file laporan yang diunggah.</p>
                                        <p class="text-xs text-slate-400 mt-0.5">Gunakan tombol "Upload Laporan" di atas untuk menambahkan laporan baru.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </section>

    {{-- Modal Upload File --}}
    <section class="modal_upload_laporan hidden fixed inset-0 z-50 flex items-center justify-center p-4">
        <div class="fixed inset-0 bg-slate-900/50 backdrop-blur-sm transition-opacity" onclick="toggleModal()"></div>

        <div
            class="relative bg-white w-full max-w-md rounded-2xl shadow-2xl overflow-hidden transform transition-all border border-slate-100">
            {{-- Header --}}
            <div class="px-6 py-4 border-b border-slate-100 flex justify-between items-center bg-slate-50/70">
                <div class="flex items-center gap-2.5">
                    <div class="w-8 h-8 rounded-lg bg-blue-50 text-blue-600 flex items-center justify-center">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-base font-bold text-slate-800">Upload Laporan</h3>
                        <p class="text-xs text-slate-400">Pastikan berkas bertipe PDF</p>
                    </div>
                </div>
                <button type="button" class="closeModalUpload w-8 h-8 rounded-lg bg-slate-100 hover:bg-slate-200 text-slate-500 hover:text-slate-800 flex items-center justify-center transition cursor-pointer text-sm font-semibold">
                    ✕
                </button>
            </div>

            <div class="p-6">
                <form action="/laporan" method="POST" enctype="multipart/form-data" class="all_form space-y-4">
                    @csrf

                    <div>
                        <label class="block text-xs font-semibold text-slate-600 mb-1.5 uppercase tracking-wider">
                            Tipe Laporan <span class="text-rose-500">*</span>
                        </label>
                        <select name="tipe_laporan" required
                            class="w-full bg-white border border-slate-200 rounded-xl px-3.5 py-2.5 text-sm outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-100 transition cursor-pointer text-slate-700">
                            <option value="" disabled selected>Pilih tipe laporan</option>
                            <option value="Konfirmasi Pengajuan">Laporan Konfirmasi Pengajuan</option>
                            <option value="Konfirmasi Pengembalian">Laporan Konfirmasi Pengembalian</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-600 mb-1.5 uppercase tracking-wider">
                            Berkas Laporan (PDF) <span class="text-rose-500">*</span>
                        </label>
                        <label for="file_upload"
                            class="group relative flex flex-col items-center justify-center w-full h-28 border-2 border-dashed border-slate-200 rounded-2xl hover:border-blue-500 hover:bg-blue-50/40 transition-all cursor-pointer bg-slate-50/50">
                            <div class="flex flex-col items-center justify-center p-3 text-center">
                                <svg class="w-7 h-7 text-slate-400 group-hover:text-blue-500 transition mb-1" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                                </svg>
                                <p class="text-xs text-slate-600 font-medium group-hover:text-blue-600 transition" id="file_name_display">
                                    Pilih file PDF dari komputer
                                </p>
                                <p class="text-[10px] text-slate-400 mt-0.5">Maksimal 10 MB</p>
                            </div>
                            <input id="file_upload" name="file" type="file" accept=".pdf" class="hidden" required />
                        </label>
                    </div>

                    <div class="flex items-center gap-3 pt-3 border-t border-slate-100">
                        <button type="button"
                            class="closeModalUpload bg-slate-100 hover:bg-slate-200 text-slate-600 font-medium px-4 py-2.5 rounded-xl text-sm transition cursor-pointer flex-1 text-center">
                            Batalkan
                        </button>
                        <button type="submit"
                            class="btn_simpan_perubahan flex-1 bg-blue-600 hover:bg-blue-700 text-white font-medium py-2.5 px-4 rounded-xl transition cursor-pointer flex items-center justify-center gap-2 shadow-sm text-sm">
                            <svg class="spinner_load hidden animate-spin h-4 w-4 text-white"
                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            <span class="text_simpan">Upload Berkas</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </section>

    <script>
        const openUploadLaporan = document.getElementById('openUploadLaporan');
        const modalUploadLaporan = document.querySelector('.modal_upload_laporan');
        const closeModalUploadBtns = document.querySelectorAll('.closeModalUpload');
        const fileName = document.getElementById('file_upload');
        const fileNameDisplay = document.getElementById('file_name_display');

        openUploadLaporan.addEventListener('click', () => {
            modalUploadLaporan.classList.remove('hidden');
        });

        fileName.addEventListener('change', () => {
            if (fileName.files.length > 0) {
                fileNameDisplay.textContent = fileName.files[0].name;
                fileNameDisplay.classList.add('font-bold', 'text-blue-600');
            } else {
                fileNameDisplay.textContent = 'Pilih file PDF dari komputer';
                fileNameDisplay.classList.remove('font-bold', 'text-blue-600');
            }
        });

        closeModalUploadBtns.forEach(btn => {
            btn.addEventListener('click', () => {
                modalUploadLaporan.classList.add('hidden');
            });
        });

        function toggleModal() {
            modalUploadLaporan.classList.toggle('hidden');
        }
    </script>
@endsection
