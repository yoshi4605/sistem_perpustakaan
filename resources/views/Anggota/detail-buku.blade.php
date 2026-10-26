@extends('layouts.index')

@section('halaman', 'Detail Buku')

@section('main')
    {{-- Breadcrumb & Back Link --}}
    <section class="mb-6">
        <a href="/daftar-buku" class="inline-flex items-center gap-2 text-xs font-semibold text-slate-500 hover:text-blue-600 transition">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            <span>Kembali ke Katalog Buku</span>
        </a>
    </section>

    {{-- Detail Card Utama --}}
    <section class="mb-12">
        <div class="bg-white rounded-3xl border border-slate-200/80 shadow-sm p-6 sm:p-10 overflow-hidden">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-12">

                {{-- Kolom Kiri: Cover Buku (3-4 Kolom) --}}
                <div class="lg:col-span-4 flex flex-col items-center">
                    <div class="w-full max-w-[280px] aspect-[3/4] rounded-2xl overflow-hidden border border-slate-200 shadow-xl bg-slate-50 relative group">
                        <img class="w-full h-full object-cover"
                            src="{{ $buku->cover_buku ? asset('storage/' . $buku->cover_buku) : asset('icons/no-image.jpg') }}"
                            alt="{{ $buku->judul_buku ?? 'Cover Buku' }}">
                    </div>

                    {{-- Status Ketersediaan Stok --}}
                    <div class="w-full max-w-[280px] mt-4">
                        @if ($buku->stok_buku > 0)
                            <div class="p-3 bg-emerald-50 border border-emerald-200 rounded-xl text-center">
                                <span class="inline-flex items-center gap-1.5 text-xs font-bold text-emerald-700">
                                    <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                                    Tersedia {{ $buku->stok_buku }} Eksemplar
                                </span>
                            </div>
                        @else
                            <div class="p-3 bg-rose-50 border border-rose-200 rounded-xl text-center">
                                <span class="inline-flex items-center gap-1.5 text-xs font-bold text-rose-700">
                                    <span class="w-2 h-2 rounded-full bg-rose-500"></span>
                                    Stok Fisik Sedang Kosong
                                </span>
                            </div>
                        @endif
                    </div>
                </div>

                {{-- Kolom Kanan: Detail & Sinopsis (8 Kolom) --}}
                <div class="lg:col-span-8 flex flex-col justify-between">
                    <div>
                        {{-- Kategori & Kode --}}
                        <div class="flex items-center gap-2 mb-2">
                            <span class="text-xs font-bold text-blue-600 bg-blue-50 px-2.5 py-1 rounded-lg border border-blue-100 uppercase tracking-wider">
                                {{ $buku->kategori ?? 'Umum' }}
                            </span>
                            <span class="font-mono text-xs text-slate-400 bg-slate-100 px-2.5 py-1 rounded-lg">
                                Kode: {{ $buku->kode_buku ?? 'N/A' }}
                            </span>
                        </div>

                        {{-- Judul Buku --}}
                        <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight leading-tight mb-2">
                            {{ $buku->judul_buku ?? 'Tidak Ada Judul.' }}
                        </h1>

                        {{-- Penulis --}}
                        <p class="text-sm font-medium text-slate-500 mb-6">
                            Penulis: <span class="font-bold text-slate-800">{{ $buku->penulis ?? 'Penulis Anonim' }}</span>
                        </p>

                        {{-- Metadata Grid --}}
                        <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 mb-6">
                            <div class="bg-slate-50 border border-slate-200/80 p-3 rounded-xl">
                                <span class="text-[10px] font-semibold text-slate-400 uppercase tracking-wider block mb-0.5">Tahun Terbit</span>
                                <span class="text-xs font-bold text-slate-800 font-mono">{{ $buku->tahun_terbit ?? '-' }}</span>
                            </div>
                            <div class="bg-slate-50 border border-slate-200/80 p-3 rounded-xl">
                                <span class="text-[10px] font-semibold text-slate-400 uppercase tracking-wider block mb-0.5">Penerbit</span>
                                <span class="text-xs font-bold text-slate-800 truncate block" title="{{ $buku->penerbit ?? '-' }}">{{ $buku->penerbit ?? '-' }}</span>
                            </div>
                            <div class="bg-slate-50 border border-slate-200/80 p-3 rounded-xl">
                                <span class="text-[10px] font-semibold text-slate-400 uppercase tracking-wider block mb-0.5">Lokasi Rak</span>
                                <span class="text-xs font-bold text-blue-700">{{ $buku->rak ? 'Rak ' . $buku->rak : 'Lihat Petugas' }}</span>
                            </div>
                            <div class="bg-slate-50 border border-slate-200/80 p-3 rounded-xl">
                                <span class="text-[10px] font-semibold text-slate-400 uppercase tracking-wider block mb-0.5">Masa Pinjam</span>
                                <span class="text-xs font-bold text-slate-800">7 Hari Kalender</span>
                            </div>
                        </div>

                        {{-- Sinopsis Buku --}}
                        <div class="mb-8">
                            <h3 class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-2 flex items-center gap-1.5">
                                <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h7" />
                                </svg>
                                <span>Sinopsis & Deskripsi Buku</span>
                            </h3>
                            <div class="bg-slate-50/70 border border-slate-200/80 p-4 sm:p-5 rounded-2xl">
                                <p class="text-slate-700 text-xs sm:text-sm leading-relaxed text-justify">
                                    {{ $buku->sinopsis ?? 'Belum ada sinopsis untuk buku ini. Silakan hubungi pustakawan di meja sirkulasi untuk informasi lebih lanjut mengenai isi buku.' }}
                                </p>
                            </div>
                        </div>
                    </div>

                    {{-- Action CTA --}}
                    <div class="pt-4 border-t border-slate-100 flex flex-col sm:flex-row items-center gap-3">
                        @if ($pending)
                            <div class="w-full bg-amber-50 border border-amber-200 p-3.5 rounded-xl flex items-center justify-between text-xs font-semibold text-amber-800">
                                <div class="flex items-center gap-2">
                                    <span class="w-2 h-2 rounded-full bg-amber-500 animate-pulse"></span>
                                    <span>Pengajuan pinjaman Anda sedang menunggu persetujuan petugas.</span>
                                </div>
                                <a href="/riwayat-pinjaman" class="text-amber-900 underline hover:text-amber-700">Lihat Status</a>
                            </div>
                        @elseif ($buku->stok_buku <= 0)
                            <button type="button" disabled class="w-full py-3.5 px-6 rounded-xl bg-slate-100 text-slate-400 text-xs font-semibold cursor-not-allowed">
                                Stok Buku Sedang Kosong (Tidak dapat dipinjam saat ini)
                            </button>
                        @else
                            <button type="button" class="btn_open_modal_ajukan w-full sm:w-auto px-8 py-3.5 rounded-xl bg-blue-600 hover:bg-blue-700 text-white text-xs font-semibold shadow-sm transition cursor-pointer flex items-center justify-center gap-2">
                                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                                </svg>
                                <span>Ajukan Peminjaman Buku</span>
                            </button>
                            <span class="text-xs text-slate-400">
                                Setelah mengajukan, silakan ambil buku fisik di Meja Pustakawan.
                            </span>
                        @endif
                    </div>
                </div>

            </div>
        </div>
    </section>

    {{-- Modal Ajukan Peminjaman --}}
    <section class="open_modal_ajukan hidden fixed inset-0 bg-slate-900/50 backdrop-blur-sm flex justify-center items-center z-50 p-4 transition-all">
        <div class="bg-white w-full max-w-md rounded-2xl shadow-2xl border border-slate-100 overflow-hidden transform transition-all">
            <div class="p-6 text-center">
                <div class="w-12 h-12 bg-blue-50 text-blue-600 rounded-full flex items-center justify-center mx-auto mb-3">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                    </svg>
                </div>
                <h3 class="text-slate-800 text-lg font-bold">Konfirmasi Pinjaman</h3>
                <p class="text-slate-500 text-xs mt-1 mb-4 leading-relaxed">
                    Apakah kamu ingin mengajukan pinjaman untuk buku <span class="font-bold text-slate-800">"{{ $buku->judul_buku }}"</span>?
                </p>

                <div class="bg-slate-50 border border-slate-200/80 p-3 rounded-xl mb-6 text-left text-xs text-slate-600 space-y-1">
                    <p><span class="text-slate-400">Durasi:</span> Maksimal 7 hari pengembalian</p>
                    <p><span class="text-slate-400">Pengambilan:</span> Tunjukkan kartu/identitas anggota ke pustakawan</p>
                </div>

                <div class="flex items-center gap-3">
                    <button type="button" class="btn_close_ajukan flex-1 bg-slate-100 hover:bg-slate-200 text-slate-600 font-medium py-2.5 rounded-xl text-xs transition cursor-pointer">
                        Batalkan
                    </button>
                    <form class="all_form flex-1" action="/ajukan-buku" method="POST">
                        @csrf
                        <input type="hidden" name="buku_id" value="{{ $buku->id }}">
                        <button type="submit" class="btn_simpan_perubahan w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2.5 rounded-xl text-xs shadow-sm transition flex items-center justify-center gap-1.5 cursor-pointer">
                            <svg class="spinner_load hidden animate-spin h-3.5 w-3.5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            <span class="text_simpan">Ya, Pinjam</span>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const openModalBtn = document.querySelector('.btn_open_modal_ajukan');
            const modalAjukan = document.querySelector('.open_modal_ajukan');
            const closeModalBtn = document.querySelector('.btn_close_ajukan');

            if (openModalBtn && modalAjukan) {
                openModalBtn.addEventListener('click', () => {
                    modalAjukan.classList.remove('hidden');
                });
            }

            if (closeModalBtn && modalAjukan) {
                closeModalBtn.addEventListener('click', () => {
                    modalAjukan.classList.add('hidden');
                });
            }
        });
    </script>
@endsection
