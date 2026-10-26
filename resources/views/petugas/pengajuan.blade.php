@extends('layouts.index')

@section('halaman', 'Daftar Pengajuan Pinjaman')

@section('main')
    {{-- Header & Search Bar --}}
    <section class="mt-8 flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center font-bold">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                    </svg>
                </div>
                <div>
                    <h2 class="text-xl font-bold text-slate-800">Antrean Pengajuan</h2>
                    <p class="text-xs text-slate-500 mt-0.5">Verifikasi dan proses permintaan peminjaman buku dari anggota perpustakaan</p>
                </div>
            </div>
        </div>

        {{-- Form Cari --}}
        <form action="/pengajuan" method="GET" class="flex items-center gap-2">
            <div class="relative w-full sm:w-80">
                <div class="absolute inset-y-0 left-3.5 flex items-center pointer-events-none text-slate-400">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </div>
                <input name="cari" type="text" placeholder="Cari nama anggota atau NIS/NIK..."
                    class="bg-white w-full pl-10 pr-4 py-2.5 rounded-xl placeholder:text-slate-400 border border-slate-200 text-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-100 transition-all outline-none"
                    value="{{ request('cari') }}">
            </div>
            <button type="submit"
                class="bg-blue-600 text-white px-5 py-2.5 rounded-xl hover:bg-blue-700 transition font-medium text-sm cursor-pointer shadow-sm flex items-center gap-1.5">
                <span>Cari</span>
            </button>
            @if(request('cari'))
                <a href="/pengajuan" class="bg-slate-100 hover:bg-slate-200 text-slate-600 px-3.5 py-2.5 rounded-xl text-sm transition font-medium">
                    Reset
                </a>
            @endif
        </form>
    </section>

    {{-- Table Section --}}
    <section class="mt-6">
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
            <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between bg-slate-50/60">
                <div class="flex items-center gap-2">
                    <span class="w-2.5 h-2.5 rounded-full bg-amber-500 animate-pulse"></span>
                    <span class="text-sm font-semibold text-slate-700">Daftar Pengajuan Menunggu Konfirmasi</span>
                </div>
                <span class="text-xs text-slate-500 bg-white px-3 py-1 rounded-full border border-slate-200">
                    Total: {{ $pengajuans->total() }} Pengajuan
                </span>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm">
                    <thead>
                        <tr class="bg-slate-50/80 border-b border-slate-200 text-slate-500 text-xs uppercase tracking-wider font-semibold">
                            <th class="py-3.5 px-4 text-center">Buku</th>
                            <th class="py-3.5 px-4">Peminjam</th>
                            <th class="py-3.5 px-4 text-center">Tgl Pinjam</th>
                            <th class="py-3.5 px-4 text-center">Jatuh Tempo</th>
                            <th class="py-3.5 px-4 text-center">Status</th>
                            <th class="py-3.5 px-4 text-center">Aksi Petugas</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse ($pengajuans as $pengajuan)
                            <tr class="hover:bg-slate-50/80 transition-colors">
                                {{-- Info Buku --}}
                                <td class="py-4 px-4 text-center">
                                    <span class="inline-block font-mono text-[11px] font-bold text-blue-700 bg-blue-50 border border-blue-200 px-2.5 py-0.5 rounded-md mb-1">
                                        {{ $pengajuan->buku->kode_buku ?? 'KODE-N/A' }}
                                    </span>
                                    <p class="font-semibold text-slate-800 text-sm max-w-[220px] mx-auto truncate" title="{{ $pengajuan->buku->judul_buku ?? 'N/A' }}">
                                        {{ $pengajuan->buku->judul_buku ?? 'Buku Tidak Diketahui' }}
                                    </p>
                                    <p class="text-xs text-slate-400">
                                        {{ $pengajuan->buku->penulis ?? '-' }}
                                    </p>
                                </td>

                                {{-- Info Peminjam --}}
                                <td class="py-4 px-4">
                                    <p class="font-semibold text-slate-800">
                                        {{ $pengajuan->anggota->nama_lengkap ?? 'Anggota Tidak Diketahui' }}
                                    </p>
                                    <p class="text-xs font-mono text-slate-500 mt-0.5">
                                        NIK/NIS: {{ $pengajuan->anggota->nomer_induk ?? '-' }}
                                    </p>
                                    <p class="text-[11px] text-slate-400 capitalize">
                                        {{ $pengajuan->anggota->jenis_kelamin ?? '-' }}
                                    </p>
                                </td>

                                {{-- Tanggal Pinjam --}}
                                <td class="py-4 px-4 text-center text-slate-700 font-medium">
                                    {{ $pengajuan->tanggal_pinjam ? \Carbon\Carbon::parse($pengajuan->tanggal_pinjam)->translatedFormat('d M Y') : 'Hari ini' }}
                                </td>

                                {{-- Tanggal Jatuh Tempo --}}
                                <td class="py-4 px-4 text-center">
                                    @if($pengajuan->tanggal_jatuh_tempo)
                                        <span class="text-slate-800 font-semibold">
                                            {{ \Carbon\Carbon::parse($pengajuan->tanggal_jatuh_tempo)->translatedFormat('d M Y') }}
                                        </span>
                                    @else
                                        <span class="text-slate-500 font-medium text-xs bg-slate-100 px-2 py-1 rounded-md" title="Estimasi 7 hari kalender">
                                            {{ \Carbon\Carbon::now()->addDays(7)->translatedFormat('d M Y') }} <span class="text-[10px] text-slate-400">(Est)</span>
                                        </span>
                                    @endif
                                </td>

                                {{-- Status --}}
                                <td class="py-4 px-4 text-center">
                                    <span class="inline-flex items-center gap-1.5 bg-amber-50 text-amber-700 border border-amber-200 px-3 py-1 rounded-full text-xs font-semibold">
                                        <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span>
                                        {{ ucfirst($pengajuan->status ?? 'menunggu') }}
                                    </span>
                                </td>

                                {{-- Aksi --}}
                                <td class="py-4 px-4 text-center">
                                    <div class="flex items-center justify-center gap-1.5">
                                        {{-- Detail --}}
                                        <button class="openModalDetailPengajuan bg-slate-100 hover:bg-slate-200 text-slate-700 px-2.5 py-1.5 rounded-lg text-xs font-medium transition cursor-pointer flex items-center gap-1"
                                            data-id="{{ $pengajuan->id }}"
                                            data-nomer_induk="{{ $pengajuan->anggota->nomer_induk }}"
                                            data-nama="{{ $pengajuan->anggota->nama_lengkap }}"
                                            data-jk="{{ $pengajuan->anggota->jenis_kelamin }}"
                                            data-alamat="{{ $pengajuan->anggota->alamat }}"
                                            data-tgl_pinjam="{{ $pengajuan->tanggal_pinjam }}"
                                            data-tgl_tempo="{{ $pengajuan->tanggal_jatuh_tempo ?? \Carbon\Carbon::now()->addDays(7)->format('Y-m-d') }}"
                                            data-status="{{ $pengajuan->status }}"
                                            data-kode_buku="{{ $pengajuan->buku->kode_buku }}"
                                            data-judul_buku="{{ $pengajuan->buku->judul_buku }}"
                                            data-penulis="{{ $pengajuan->buku->penulis }}"
                                            data-thn_terbit="{{ $pengajuan->buku->tahun_terbit }}"
                                            type="button"
                                            title="Lihat Detail Pengajuan">
                                            <svg class="w-3.5 h-3.5 text-slate-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                            </svg>
                                            <span>Detail</span>
                                        </button>

                                        {{-- Tolak --}}
                                        <button data-id="{{ $pengajuan->id }}"
                                            data-buku="{{ $pengajuan->buku->judul_buku ?? 'Buku' }}"
                                            data-tgl_pinjam="{{ $pengajuan->tanggal_pinjam }}"
                                            class="btn_open_modal_tolak_ajukan bg-rose-50 hover:bg-rose-100 text-rose-700 border border-rose-200 px-2.5 py-1.5 rounded-lg text-xs font-medium transition cursor-pointer flex items-center gap-1"
                                            title="Tolak Pengajuan">
                                            <svg class="w-3.5 h-3.5 text-rose-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                            </svg>
                                            <span>Tolak</span>
                                        </button>

                                        {{-- Konfirmasi --}}
                                        <button data-id="{{ $pengajuan->id }}"
                                            data-nama_peminjam="{{ $pengajuan->anggota->nama_lengkap ?? 'Anggota' }}"
                                            data-judul_buku="{{ $pengajuan->buku->judul_buku ?? 'Buku' }}"
                                            data-tgl_pinjam="{{ $pengajuan->tanggal_pinjam ?? \Carbon\Carbon::now()->format('Y-m-d') }}"
                                            data-tgl_tempo="{{ $pengajuan->tanggal_jatuh_tempo ?? \Carbon\Carbon::now()->addDays(7)->format('Y-m-d') }}"
                                            class="btn_open_modal_konir_ajukan bg-emerald-600 hover:bg-emerald-700 text-white px-3 py-1.5 rounded-lg text-xs font-semibold transition cursor-pointer shadow-sm flex items-center gap-1"
                                            title="Setujui Pinjaman">
                                            <svg class="w-3.5 h-3.5 text-white" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                                            </svg>
                                            <span>Setujui</span>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-12">
                                    <div class="flex flex-col items-center justify-center">
                                        <div class="w-12 h-12 rounded-full bg-slate-100 flex items-center justify-center text-slate-400 mb-2">
                                            <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                            </svg>
                                        </div>
                                        <p class="text-sm font-medium text-slate-700">Tidak ada pengajuan pinjaman yang pending.</p>
                                        <p class="text-xs text-slate-400 mt-0.5">Semua permohonan telah selesai diproses.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if ($pengajuans->hasPages())
                <div class="px-6 py-4 border-t border-slate-100 bg-slate-50/40">
                    {{ $pengajuans->links() }}
                </div>
            @endif
        </div>
    </section>

    {{-- Modal Konfirmasi Pinjaman --}}
    <section id="open_modal_konfir_ajukan"
        class="hidden fixed inset-0 bg-slate-900/50 backdrop-blur-sm flex justify-center items-center z-50 transition-opacity p-4">
        <div class="bg-white w-full max-w-md rounded-2xl shadow-xl border border-slate-100 overflow-hidden">
            <div class="p-6 border-b border-slate-100 bg-slate-50/60">
                <div class="w-10 h-10 rounded-full bg-emerald-100 text-emerald-600 flex items-center justify-center mb-3">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                    </svg>
                </div>
                <h3 class="text-slate-800 text-lg font-bold">Konfirmasi Pinjaman</h3>
                <p class="text-slate-500 text-xs mt-1">Buku akan diserahkan kepada peminjam dan status diubah menjadi Dipinjam.</p>
            </div>

            <form id="form_konfir_ajukanKonfirmasi" action="" method="POST" class="all_form p-6">
                @csrf
                <div class="space-y-3 mb-6">
                    <div class="bg-slate-50 p-3.5 rounded-xl border border-slate-200/80">
                        <p class="text-[11px] text-slate-400 font-semibold uppercase tracking-wider">Nama Peminjam</p>
                        <p class="textNamaPeminjam font-bold text-slate-800 text-sm mt-0.5"></p>
                    </div>
                    <div class="grid grid-cols-2 gap-3">
                        <div class="bg-slate-50 p-3.5 rounded-xl border border-slate-200/80">
                            <p class="text-[11px] text-slate-400 font-semibold uppercase tracking-wider">Tgl Pinjam</p>
                            <p class="textTanggalPinjam font-semibold text-slate-700 text-sm mt-0.5"></p>
                        </div>
                        <div class="bg-slate-50 p-3.5 rounded-xl border border-slate-200/80">
                            <p class="text-[11px] text-slate-400 font-semibold uppercase tracking-wider">Jatuh Tempo</p>
                            <p class="textTanggalJatuhTempo font-semibold text-blue-600 text-sm mt-0.5"></p>
                        </div>
                    </div>
                </div>

                {{-- Action Buttons --}}
                <div class="flex items-center justify-end gap-3">
                    <button type="button"
                        class="btn_close_konfir_ajukan bg-slate-100 hover:bg-slate-200 text-slate-600 font-medium px-4 py-2.5 rounded-xl text-sm transition cursor-pointer">
                        Batal
                    </button>
                    <button type="submit"
                        class="btn_simpan_perubahan bg-emerald-600 hover:bg-emerald-700 text-white font-medium px-5 py-2.5 rounded-xl text-sm transition cursor-pointer flex items-center gap-2 shadow-sm">
                        <svg class="spinner_load hidden animate-spin h-4 w-4 text-white"
                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        <span class="text_simpan">Ya, Setujui Pinjaman</span>
                    </button>
                </div>
            </form>
        </div>
    </section>

    {{-- Modal Tolak Pengajuan --}}
    <section id="modalTolak"
        class="hidden fixed inset-0 bg-slate-900/50 backdrop-blur-sm flex justify-center items-center z-50 transition-opacity p-4">
        <div class="bg-white w-full max-w-md rounded-2xl shadow-xl border border-slate-100 overflow-hidden">
            <div class="p-6 border-b border-slate-100 bg-rose-50/40">
                <div class="w-10 h-10 rounded-full bg-rose-100 text-rose-600 flex items-center justify-center mb-3">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </div>
                <h3 class="text-slate-800 text-lg font-bold">Tolak Pengajuan Pinjaman</h3>
                <p class="text-slate-500 text-xs mt-1">Berikan alasan yang jelas agar peminjam dapat memahami penolakan ini.</p>
            </div>

            <form id="formTolak" action="" method="POST" class="all_form p-6">
                @csrf

                <div class="mb-4">
                    <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">
                        Pilih Template Alasan Cepat
                    </label>
                    <div class="flex flex-wrap gap-2">
                        <button type="button" onclick="setTemplate('stok')"
                            class="border border-slate-200 text-xs font-medium px-3 py-1.5 rounded-lg text-slate-600 hover:border-blue-400 hover:text-blue-600 hover:bg-blue-50 transition">
                            Stok Habis
                        </button>
                        <button type="button" onclick="setTemplate('batas')"
                            class="border border-slate-200 text-xs font-medium px-3 py-1.5 rounded-lg text-slate-600 hover:border-blue-400 hover:text-blue-600 hover:bg-blue-50 transition">
                            Batas Pinjam Tercapai
                        </button>
                        <button type="button" onclick="setTemplate('data')"
                            class="border border-slate-200 text-xs font-medium px-3 py-1.5 rounded-lg text-slate-600 hover:border-blue-400 hover:text-blue-600 hover:bg-blue-50 transition">
                            Data Anggota Tidak Valid
                        </button>
                    </div>
                </div>

                <div class="mb-6">
                    <label class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-2" for="alasanTolak">
                        Rincian Alasan Penolakan <span class="text-rose-500">*</span>
                    </label>
                    <textarea id="alasanTolak" name="alasan" rows="4" required
                        class="w-full border border-slate-200 focus:border-rose-500 focus:ring-2 focus:ring-rose-100 outline-none px-3.5 py-2.5 rounded-xl text-slate-700 transition resize-none placeholder:text-slate-400 text-sm"
                        placeholder="Ketikkan alasan penolakan..."></textarea>
                </div>

                <div class="flex items-center justify-end gap-3">
                    <button type="button"
                        class="close_modal_tolak_ajukan bg-slate-100 hover:bg-slate-200 text-slate-600 font-medium px-4 py-2.5 rounded-xl text-sm transition cursor-pointer">
                        Batalkan
                    </button>
                    <button type="submit"
                        class="btn_simpan_perubahan bg-rose-600 hover:bg-rose-700 text-white font-medium px-5 py-2.5 rounded-xl text-sm transition cursor-pointer flex items-center gap-2 shadow-sm">
                        <svg class="spinner_load hidden animate-spin h-4 w-4 text-white"
                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        <span class="text_simpan">Ya, Tolak Pengajuan</span>
                    </button>
                </div>
            </form>
        </div>
    </section>

    {{-- Modal Detail --}}
    @include('components.modal-detail-pengajuan')

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Script Konfirmasi Peminjaman Buku
            const modal_konfir_ajukan = document.getElementById('open_modal_konfir_ajukan');
            const form_konfir_ajukan = document.getElementById('form_konfir_ajukanKonfirmasi');
            const openButtons = document.querySelectorAll('.btn_open_modal_konir_ajukan');
            const closeButtons = document.querySelectorAll('.btn_close_konfir_ajukan');

            const textNamaPeminjam = modal_konfir_ajukan.querySelector('.textNamaPeminjam');
            const textTanggalPinjam = modal_konfir_ajukan.querySelector('.textTanggalPinjam');
            const textTanggalJatuhTempo = modal_konfir_ajukan.querySelector('.textTanggalJatuhTempo');

            // Fungsi Membuka Modal
            openButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const id = this.getAttribute('data-id');
                    const namaPeminjam = this.getAttribute('data-nama_peminjam');
                    const tglPinjam = this.getAttribute('data-tgl_pinjam');
                    const tglTempo = this.getAttribute('data-tgl_tempo');

                    form_konfir_ajukan.action = `/pengajuan/konfirmasi/${id}`;

                    // Munculkan modal
                    modal_konfir_ajukan.classList.remove('hidden');

                    // Set data ke dalam modal
                    textNamaPeminjam.textContent = namaPeminjam;
                    textTanggalPinjam.textContent = tglPinjam;
                    textTanggalJatuhTempo.textContent = tglTempo;

                    modal_konfir_ajukan.classList.add('flex');
                });
            });

            // Fungsi Menutup Modal
            closeButtons.forEach(button => {
                button.addEventListener('click', function() {
                    modal_konfir_ajukan.classList.add('hidden');
                    modal_konfir_ajukan.classList.remove('flex');
                });
            });

            // Script Tolak Ajukan Buku
            const modal = document.getElementById('modalTolak');
            const textarea = document.getElementById('alasanTolak');
            const form = document.getElementById('formTolak');
            const openModalTolakAjukan = document.querySelectorAll('.btn_open_modal_tolak_ajukan');

            let currentBuku = '';
            let currentTanggal = '';

            openModalTolakAjukan.forEach(btn => {
                btn.addEventListener('click', function() {
                    const id = this.dataset.id;
                    currentBuku = this.dataset.buku;
                    currentTanggal = this.dataset.tgl_pinjam;

                    form.action = `/pengajuan/tolak/${id}`;
                    modal.classList.remove('hidden');
                    modal.classList.add('flex');
                    textarea.value = '';
                });
            });

            document.querySelectorAll('.close_modal_tolak_ajukan').forEach(btn => {
                btn.addEventListener('click', function() {
                    modal.classList.add('hidden');
                    modal.classList.remove('flex');
                });
            });

            window.setTemplate = function(type) {
                let template = '';
                if (type === 'stok') {
                    template = `Permintaan peminjaman buku tidak dapat disetujui karena stok fisik buku sedang tidak tersedia di rak perpustakaan.\n\nJudul: ${currentBuku}`;
                } else if (type === 'batas') {
                    template = `Permintaan peminjaman tidak dapat diproses karena Anda telah mencapai batas maksimal kuota peminjaman aktif. Silakan kembalikan buku sebelumnya terlebih dahulu.`;
                } else if (type === 'data') {
                    template = `Permintaan peminjaman ditolak karena verifikasi data keanggotaan belum lengkap atau kartu anggota belum aktif. Silakan hubungi meja sirkulasi.`;
                }
                textarea.value = template;
            };
        });
    </script>
@endsection
