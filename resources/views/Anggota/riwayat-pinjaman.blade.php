@extends('layouts.index')

@section('halaman', 'Buku Pinjaman Saya')

@section('main')
    {{-- Header Section --}}
    <section class="mb-6">
        <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-4">
            <div>
                <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">Buku Pinjaman Saya</h1>
                <p class="text-slate-500 text-xs sm:text-sm mt-1">Pantau status pengajuan buku, batas pengembalian, dan riwayat yang telah selesai.</p>
            </div>
            <a href="/daftar-buku" class="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl bg-blue-600 hover:bg-blue-700 text-white text-xs font-semibold shadow-xs transition self-start sm:self-auto">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                </svg>
                <span>Pinjam Buku Baru</span>
            </a>
        </div>
    </section>

    {{-- Tabs Nav --}}
    <section class="mb-6">
        <div class="flex items-center gap-2 border-b border-slate-200">
            <button type="button" id="tabBtnAktif" onclick="switchTab('aktif')"
                class="tab-btn px-4 py-3 text-sm font-bold text-blue-600 border-b-2 border-blue-600 transition flex items-center gap-2 cursor-pointer">
                <span>Sedang Dipinjam & Menunggu</span>
                <span class="bg-blue-100 text-blue-700 text-xs font-bold px-2 py-0.5 rounded-full">
                    {{ $pengajuans->total() }}
                </span>
            </button>
            <button type="button" id="tabBtnSelesai" onclick="switchTab('selesai')"
                class="tab-btn px-4 py-3 text-sm font-semibold text-slate-500 hover:text-slate-800 border-b-2 border-transparent transition flex items-center gap-2 cursor-pointer">
                <span>Riwayat Selesai Dikembalikan</span>
                <span class="bg-slate-100 text-slate-600 text-xs font-bold px-2 py-0.5 rounded-full">
                    {{ $pengembalians->total() }}
                </span>
            </button>
        </div>
    </section>

    {{-- TAB 1: PINJAMAN AKTIF & MENUNGGU --}}
    <section id="panelAktif" class="tab-panel mb-12">
        <div class="bg-white rounded-2xl border border-slate-200 shadow-xs overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm">
                    <thead>
                        <tr class="bg-slate-50/80 border-b border-slate-200 text-slate-500 text-xs uppercase tracking-wider font-semibold">
                            <th class="py-3.5 px-4 text-center">Buku</th>
                            <th class="py-3.5 px-4 text-center">Tanggal Pinjam</th>
                            <th class="py-3.5 px-4 text-center">Jatuh Tempo</th>
                            <th class="py-3.5 px-4 text-center">Status Peminjaman</th>
                            <th class="py-3.5 px-4 text-center">Status Pengembalian</th>
                            <th class="py-3.5 px-4 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse ($pengajuans as $pengajuan)
                            <tr class="hover:bg-slate-50/70 transition-colors">
                                {{-- Info Buku --}}
                                <td class="py-4 px-4 text-center">
                                    <span class="inline-block font-mono text-[11px] font-bold text-blue-700 bg-blue-50 border border-blue-200 px-2.5 py-0.5 rounded-md mb-1">
                                        {{ $pengajuan->buku->kode_buku ?? 'KODE-N/A' }}
                                    </span>
                                    <h3 class="font-bold text-slate-800 text-xs max-w-[220px] mx-auto truncate" title="{{ $pengajuan->buku->judul_buku ?? 'N/A' }}">
                                        {{ $pengajuan->buku->judul_buku ?? 'Buku Tidak Diketahui' }}
                                    </h3>
                                    <p class="text-[11px] text-slate-400">
                                        {{ $pengajuan->buku->penulis ?? '-' }}
                                    </p>
                                </td>

                                {{-- Tanggal Pinjam --}}
                                <td class="py-4 px-4 text-center text-xs text-slate-700 font-medium">
                                    {{ $pengajuan->tanggal_pinjam ? \Carbon\Carbon::parse($pengajuan->tanggal_pinjam)->translatedFormat('d M Y') : '-' }}
                                </td>

                                {{-- Tanggal Jatuh Tempo & Late Badge --}}
                                <td class="py-4 px-4 text-center">
                                    @if ($pengajuan->status === 'menunggu')
                                        <span class="text-xs text-slate-400 italic">Menunggu disetujui</span>
                                    @else
                                        @php
                                            $isTerlambat = $pengajuan->tanggal_jatuh_tempo && now()->toDateString() > \Carbon\Carbon::parse($pengajuan->tanggal_jatuh_tempo)->toDateString();
                                        @endphp
                                        <span class="text-xs font-semibold {{ $isTerlambat ? 'text-rose-600 font-bold' : 'text-slate-800' }}">
                                            {{ $pengajuan->tanggal_jatuh_tempo ? \Carbon\Carbon::parse($pengajuan->tanggal_jatuh_tempo)->translatedFormat('d M Y') : '-' }}
                                        </span>
                                        @if($isTerlambat)
                                            <span class="block text-[10px] text-rose-500 font-bold mt-0.5">Sudah Terlambat</span>
                                        @endif
                                    @endif
                                </td>

                                {{-- Status Peminjaman --}}
                                <td class="py-4 px-4 text-center">
                                    @if ($pengajuan->status === 'menunggu')
                                        <span class="inline-flex items-center gap-1.5 bg-amber-50 text-amber-700 border border-amber-200 text-xs font-semibold px-3 py-1 rounded-full">
                                            <span class="w-1.5 h-1.5 rounded-full bg-amber-500 animate-pulse"></span>
                                            Menunggu Konfirmasi
                                        </span>
                                    @elseif ($pengajuan->status === 'dipinjam')
                                        <span class="inline-flex items-center gap-1.5 bg-blue-50 text-blue-700 border border-blue-200 text-xs font-semibold px-3 py-1 rounded-full">
                                            <span class="w-1.5 h-1.5 rounded-full bg-blue-500"></span>
                                            Sedang Dipinjam
                                        </span>
                                    @else
                                        <span class="bg-slate-100 text-slate-600 text-xs font-semibold px-3 py-1 rounded-full">
                                            {{ ucfirst($pengajuan->status) }}
                                        </span>
                                    @endif
                                </td>

                                {{-- Status Pengembalian --}}
                                <td class="py-4 px-4 text-center">
                                    @if (optional($pengajuan->pengembalian)->status === 'menunggu')
                                        <span class="inline-flex items-center gap-1.5 bg-amber-50 text-amber-700 border border-amber-200 text-xs font-semibold px-3 py-1 rounded-full">
                                            <span class="w-1.5 h-1.5 rounded-full bg-amber-500 animate-pulse"></span>
                                            Menunggu Verifikasi
                                        </span>
                                    @else
                                        <span class="text-slate-400 text-xs">-</span>
                                    @endif
                                </td>

                                {{-- Aksi --}}
                                <td class="py-4 px-4 text-center">
                                    <div class="flex items-center justify-center gap-1.5">
                                        {{-- Detail Button --}}
                                        <button class="openModalDetailPengajuan bg-slate-100 hover:bg-slate-200 text-slate-700 px-2.5 py-1.5 rounded-lg text-xs font-medium transition cursor-pointer flex items-center gap-1"
                                            data-id="{{ $pengajuan->id }}"
                                            data-nomer_induk="{{ $pengajuan->anggota->nomer_induk ?? '' }}"
                                            data-nama="{{ $pengajuan->anggota->nama_lengkap ?? '' }}"
                                            data-jk="{{ $pengajuan->anggota->jenis_kelamin ?? '' }}"
                                            data-alamat="{{ $pengajuan->anggota->alamat ?? '' }}"
                                            data-tgl_pinjam="{{ $pengajuan->tanggal_pinjam ?? '' }}"
                                            data-tgl_tempo="{{ $pengajuan->tanggal_jatuh_tempo ?? '' }}"
                                            data-status="{{ $pengajuan->status }}"
                                            data-kode_buku="{{ $pengajuan->buku->kode_buku ?? '' }}"
                                            data-judul_buku="{{ $pengajuan->buku->judul_buku ?? '' }}"
                                            data-penulis="{{ $pengajuan->buku->penulis ?? '' }}"
                                            data-thn_terbit="{{ $pengajuan->buku->tahun_terbit ?? '' }}"
                                            type="button" title="Detail">
                                            <svg class="w-3.5 h-3.5 text-slate-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                            </svg>
                                            <span>Detail</span>
                                        </button>

                                        {{-- Tombol Kembalikan --}}
                                        @if ($pengajuan->status === 'menunggu')
                                            <span class="text-xs text-slate-400 italic">Menunggu</span>
                                        @elseif (optional($pengajuan->pengembalian)->status === 'menunggu')
                                            <span class="text-xs text-amber-700 bg-amber-50 px-2 py-1 rounded-lg border border-amber-200 font-medium">Proses Kembali</span>
                                        @else
                                            <button type="button" data-id="{{ $pengajuan->id }}"
                                                class="btn_open_modal_kembalikan bg-emerald-600 hover:bg-emerald-700 text-white px-3 py-1.5 rounded-lg text-xs font-semibold shadow-xs transition cursor-pointer flex items-center gap-1">
                                                <svg class="w-3.5 h-3.5 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6" />
                                                </svg>
                                                <span>Kembalikan</span>
                                            </button>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-12">
                                    <div class="flex flex-col items-center justify-center">
                                        <div class="w-12 h-12 rounded-full bg-slate-100 text-slate-400 mx-auto flex items-center justify-center mb-2">
                                            <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                            </svg>
                                        </div>
                                        <h3 class="text-sm font-bold text-slate-700">Tidak ada pinjaman aktif</h3>
                                        <p class="text-xs text-slate-400 mt-0.5">Semua buku telah dikembalikan atau belum ada pengajuan baru.</p>
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

    {{-- TAB 2: RIWAYAT PENGEMBALIAN (SELESAI) --}}
    <section id="panelSelesai" class="tab-panel hidden mb-12">
        <div class="bg-white rounded-2xl border border-slate-200 shadow-xs overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm">
                    <thead>
                        <tr class="bg-slate-50/80 border-b border-slate-200 text-slate-500 text-xs uppercase tracking-wider font-semibold">
                            <th class="py-3.5 px-4 text-center">Buku</th>
                            <th class="py-3.5 px-4 text-center">Tgl Pinjam</th>
                            <th class="py-3.5 px-4 text-center">Tgl Dikembalikan</th>
                            <th class="py-3.5 px-4 text-center">Status</th>
                            <th class="py-3.5 px-4 text-center">Detail</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse ($pengembalians as $pengembalian)
                            <tr class="hover:bg-slate-50/70 transition-colors">
                                <td class="py-4 px-4 text-center">
                                    <span class="inline-block font-mono text-[11px] font-bold text-blue-700 bg-blue-50 border border-blue-200 px-2.5 py-0.5 rounded-md mb-1">
                                        {{ $pengembalian->peminjaman->buku->kode_buku ?? 'KODE-N/A' }}
                                    </span>
                                    <h3 class="font-bold text-slate-800 text-xs max-w-[220px] mx-auto truncate" title="{{ $pengembalian->peminjaman->buku->judul_buku ?? 'N/A' }}">
                                        {{ $pengembalian->peminjaman->buku->judul_buku ?? 'Buku' }}
                                    </h3>
                                </td>

                                <td class="py-4 px-4 text-center text-xs text-slate-700 font-medium">
                                    {{ $pengembalian->peminjaman->tanggal_pinjam ? \Carbon\Carbon::parse($pengembalian->peminjaman->tanggal_pinjam)->translatedFormat('d M Y') : '-' }}
                                </td>

                                <td class="py-4 px-4 text-center text-xs text-slate-700 font-medium">
                                    {{ $pengembalian->tanggal_kembalikan ? \Carbon\Carbon::parse($pengembalian->tanggal_kembalikan)->translatedFormat('d M Y') : '-' }}
                                </td>

                                <td class="py-4 px-4 text-center">
                                    <span class="inline-flex items-center gap-1.5 bg-emerald-50 text-emerald-700 border border-emerald-200 text-xs font-semibold px-3 py-1 rounded-full">
                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                        Selesai Dikembalikan
                                    </span>
                                </td>

                                <td class="py-4 px-4 text-center">
                                    <button class="openModalDetailPengembalian bg-slate-100 hover:bg-slate-200 text-slate-700 px-2.5 py-1.5 rounded-lg text-xs font-medium transition cursor-pointer inline-flex items-center gap-1"
                                        data-id="{{ $pengembalian->peminjaman->id ?? '' }}"
                                        data-nomer_induk="{{ $pengembalian->peminjaman->anggota->nomer_induk ?? '' }}"
                                        data-nama="{{ $pengembalian->peminjaman->anggota->nama_lengkap ?? '' }}"
                                        data-jk="{{ $pengembalian->peminjaman->anggota->jenis_kelamin ?? '' }}"
                                        data-alamat="{{ $pengembalian->peminjaman->anggota->alamat ?? '' }}"
                                        data-tgl_pinjam="{{ $pengembalian->peminjaman->tanggal_pinjam ?? '' }}"
                                        data-tgl_tempo="{{ $pengembalian->peminjaman->tanggal_jatuh_tempo ?? '' }}"
                                        data-tgl_kembalikan="{{ $pengembalian->tanggal_kembalikan ?? '' }}"
                                        data-total_hari_telat="{{ $pengembalian->total_hari_terlambat ?? 0 }}"
                                        data-status_pinjaman="{{ $pengembalian->peminjaman->status ?? '' }}"
                                        data-status_kembalikan="{{ $pengembalian->status ?? '' }}"
                                        data-kode_buku="{{ $pengembalian->peminjaman->buku->kode_buku ?? '' }}"
                                        data-judul_buku="{{ $pengembalian->peminjaman->buku->judul_buku ?? '' }}"
                                        data-penulis="{{ $pengembalian->peminjaman->buku->penulis ?? '' }}"
                                        data-thn_terbit="{{ $pengembalian->peminjaman->buku->tahun_terbit ?? '' }}"
                                        type="button" title="Detail">
                                        <svg class="w-3.5 h-3.5 text-slate-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                        </svg>
                                        <span>Detail</span>
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-12 text-slate-400 text-xs">
                                    Belum ada riwayat buku yang selesai dikembalikan.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if ($pengembalians->hasPages())
                <div class="px-6 py-4 border-t border-slate-100 bg-slate-50/40">
                    {{ $pengembalians->links() }}
                </div>
            @endif
        </div>
    </section>

    {{-- Modal Kembalikan Buku --}}
    <section class="open_modal_kembalikan hidden fixed inset-0 bg-slate-900/50 backdrop-blur-sm flex justify-center items-center z-50 p-4 transition-all">
        <div class="bg-white w-full max-w-md rounded-2xl shadow-2xl border border-slate-100 overflow-hidden transform transition-all">
            <div class="p-6 text-center">
                <div class="w-12 h-12 bg-emerald-50 text-emerald-600 rounded-full flex items-center justify-center mx-auto mb-3">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6" />
                    </svg>
                </div>
                <h3 class="text-slate-800 text-lg font-bold">Kembalikan Buku Ini?</h3>
                <p class="text-slate-500 text-xs mt-1 mb-6 leading-relaxed">
                    Pastikan buku fisik diserahkan ke pustakawan di Meja Sirkulasi dalam keadaan baik dan utuh.
                </p>

                <div class="flex items-center gap-3">
                    <button type="button" class="btn_close_kembalikan flex-1 bg-slate-100 hover:bg-slate-200 text-slate-600 font-medium py-2.5 rounded-xl text-xs transition cursor-pointer">
                        Mungkin Nanti
                    </button>
                    <form class="all_form form_kembalikan flex-1" method="POST">
                        @csrf
                        <button type="submit" class="btn_simpan_perubahan w-full bg-emerald-600 hover:bg-emerald-700 text-white font-semibold py-2.5 rounded-xl text-xs shadow-sm transition flex items-center justify-center gap-1.5 cursor-pointer">
                            <svg class="spinner_load hidden animate-spin h-3.5 w-3.5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            <span class="text_simpan">Ya, Kembalikan</span>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </section>

    {{-- Modal Detail --}}
    @include('components.modal-detail-pengajuan')
    @include('components.modal-detail-pengembalian')

    <script>
        function switchTab(tab) {
            const panelAktif = document.getElementById('panelAktif');
            const panelSelesai = document.getElementById('panelSelesai');
            const btnAktif = document.getElementById('tabBtnAktif');
            const btnSelesai = document.getElementById('tabBtnSelesai');

            if (tab === 'aktif') {
                panelAktif.classList.remove('hidden');
                panelSelesai.classList.add('hidden');
                btnAktif.className = 'tab-btn px-4 py-3 text-sm font-bold text-blue-600 border-b-2 border-blue-600 transition flex items-center gap-2 cursor-pointer';
                btnSelesai.className = 'tab-btn px-4 py-3 text-sm font-semibold text-slate-500 hover:text-slate-800 border-b-2 border-transparent transition flex items-center gap-2 cursor-pointer';
            } else {
                panelAktif.classList.add('hidden');
                panelSelesai.classList.remove('hidden');
                btnAktif.className = 'tab-btn px-4 py-3 text-sm font-semibold text-slate-500 hover:text-slate-800 border-b-2 border-transparent transition flex items-center gap-2 cursor-pointer';
                btnSelesai.className = 'tab-btn px-4 py-3 text-sm font-bold text-blue-600 border-b-2 border-blue-600 transition flex items-center gap-2 cursor-pointer';
            }
        }

        document.addEventListener('DOMContentLoaded', function () {
            const openModalKembalikan = document.querySelectorAll('.btn_open_modal_kembalikan');
            const ModalKembalikan = document.querySelector('.open_modal_kembalikan');
            const CloseKembalikan = document.querySelector('.btn_close_kembalikan');
            const formKembalikan = document.querySelector('.form_kembalikan');

            if (openModalKembalikan && ModalKembalikan) {
                openModalKembalikan.forEach(btn => {
                    btn.addEventListener("click", function() {
                        const id = this.dataset.id;
                        ModalKembalikan.classList.remove('hidden');
                        formKembalikan.action = `/kembalikan-buku/${id}`;
                    });
                });
            }

            if (CloseKembalikan && ModalKembalikan) {
                CloseKembalikan.addEventListener("click", function() {
                    ModalKembalikan.classList.add('hidden');
                });
            }
        });
    </script>
@endsection
