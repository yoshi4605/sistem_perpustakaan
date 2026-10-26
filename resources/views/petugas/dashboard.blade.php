@extends('layouts.index')

@section('halaman', 'Dashboard Petugas')
@section('suffix', '')

@section('main')
    {{-- Header Banner & Tanggal Operasional --}}
    <div class="mt-4 mb-6 flex flex-col md:flex-row md:items-center justify-between gap-4 bg-white p-6 rounded-2xl border border-slate-200/80 shadow-sm">
        <div>
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-blue-50 border border-blue-100 text-blue-700 text-xs font-semibold mb-2">
                <span class="w-2 h-2 rounded-full bg-blue-600 animate-pulse"></span>
                <span>Meja Sirkulasi Aktif</span>
            </div>
            <h2 class="text-2xl font-bold text-slate-900 tracking-tight">Selamat Bertugas, {{ Auth::user()->Petugas->nama_lengkap ?? Auth::user()->username }}!</h2>
            <p class="text-slate-500 text-sm mt-1">
                @if($Pengajuan > 0)
                    Ada <span class="font-bold text-amber-600">{{ $Pengajuan }} pengajuan peminjaman</span> yang menunggu konfirmasi Anda hari ini.
                @else
                    Semua antrean pengajuan telah selesai diproses. Layanan berjalan lancar!
                @endif
            </p>
        </div>
        <div class="flex items-center gap-3">
            <div class="text-right">
                <span class="text-xs uppercase tracking-wider font-semibold text-slate-400 block">Tanggal Hari Ini</span>
                <span class="text-sm font-bold text-slate-800">{{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}</span>
            </div>
            <div class="w-12 h-12 rounded-xl bg-slate-50 border border-slate-200 flex items-center justify-center text-slate-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5" />
                </svg>
            </div>
        </div>
    </div>

    {{-- 3 Kartu Operasional Bersih & Simple (Tidak Warna-Warni) --}}
    <section class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        {{-- Card 1: Antrean Pengajuan --}}
        <div class="bg-white p-6 rounded-2xl border border-slate-200/80 shadow-sm hover:shadow-md hover:border-blue-300 transition-all group">
            <div class="flex items-start justify-between">
                <div>
                    <span class="text-xs uppercase tracking-wider font-semibold text-slate-400 block mb-1">Pengajuan Menunggu</span>
                    <h3 class="text-3xl font-extrabold text-slate-900 tracking-tight">{{ number_format($Pengajuan) }}</h3>
                    <div class="flex items-center gap-2 mt-3">
                        @if($Pengajuan > 0)
                            <span class="inline-flex items-center text-xs font-semibold text-amber-700 bg-amber-50 px-2.5 py-0.5 rounded-full border border-amber-200">
                                ⏳ Perlu Diproses
                            </span>
                        @else
                            <span class="inline-flex items-center text-xs font-semibold text-emerald-700 bg-emerald-50 px-2.5 py-0.5 rounded-full border border-emerald-200">
                                ✓ Antrean Bersih
                            </span>
                        @endif
                    </div>
                </div>
                <div class="w-12 h-12 rounded-xl bg-amber-50 border border-amber-200/80 flex items-center justify-center text-amber-600 flex-shrink-0 group-hover:scale-105 transition-transform">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                    </svg>
                </div>
            </div>
            <div class="mt-5 pt-4 border-t border-slate-100">
                <a href="/pengajuan" class="text-xs font-semibold text-blue-600 hover:text-blue-800 flex items-center justify-between">
                    <span>Buka Antrean Pengajuan</span>
                    <span class="text-sm">→</span>
                </a>
            </div>
        </div>

        {{-- Card 2: Buku Sedang Dipinjam --}}
        <div class="bg-white p-6 rounded-2xl border border-slate-200/80 shadow-sm hover:shadow-md hover:border-blue-300 transition-all group">
            <div class="flex items-start justify-between">
                <div>
                    <span class="text-xs uppercase tracking-wider font-semibold text-slate-400 block mb-1">Buku Beredar di Anggota</span>
                    <h3 class="text-3xl font-extrabold text-slate-900 tracking-tight">{{ number_format($SedangDipinjam) }}</h3>
                    <div class="flex items-center gap-2 mt-3">
                        @if($Terlambat > 0)
                            <span class="inline-flex items-center text-xs font-semibold text-rose-700 bg-rose-50 px-2.5 py-0.5 rounded-full border border-rose-200">
                                ⚠ {{ $Terlambat }} Jatuh Tempo
                            </span>
                        @else
                            <span class="inline-flex items-center text-xs font-semibold text-blue-700 bg-blue-50 px-2.5 py-0.5 rounded-full border border-blue-200">
                                📚 Sirkulasi Aktif
                            </span>
                        @endif
                    </div>
                </div>
                <div class="w-12 h-12 rounded-xl bg-blue-50 border border-blue-200/80 flex items-center justify-center text-blue-600 flex-shrink-0 group-hover:scale-105 transition-transform">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25" />
                    </svg>
                </div>
            </div>
            <div class="mt-5 pt-4 border-t border-slate-100">
                <a href="/pengembalian" class="text-xs font-semibold text-blue-600 hover:text-blue-800 flex items-center justify-between">
                    <span>Kelola Pengembalian Buku</span>
                    <span class="text-sm">→</span>
                </a>
            </div>
        </div>

        {{-- Card 3: Pengunjung Hari Ini --}}
        <div class="bg-white p-6 rounded-2xl border border-slate-200/80 shadow-sm hover:shadow-md hover:border-blue-300 transition-all group">
            <div class="flex items-start justify-between">
                <div>
                    <span class="text-xs uppercase tracking-wider font-semibold text-slate-400 block mb-1">Pengunjung Hari Ini</span>
                    <h3 class="text-3xl font-extrabold text-slate-900 tracking-tight">{{ number_format($TamuHariIni) }}</h3>
                    <div class="flex items-center gap-2 mt-3">
                        <span class="inline-flex items-center text-xs font-semibold text-emerald-700 bg-emerald-50 px-2.5 py-0.5 rounded-full border border-emerald-200">
                            👥 Buku Tamu Digital
                        </span>
                    </div>
                </div>
                <div class="w-12 h-12 rounded-xl bg-emerald-50 border border-emerald-200/80 flex items-center justify-center text-emerald-600 flex-shrink-0 group-hover:scale-105 transition-transform">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" />
                    </svg>
                </div>
            </div>
            <div class="mt-5 pt-4 border-t border-slate-100">
                <a href="/petugas/daftar-tamu" class="text-xs font-semibold text-blue-600 hover:text-blue-800 flex items-center justify-between">
                    <span>Lihat Daftar Tamu Hari Ini</span>
                    <span class="text-sm">→</span>
                </a>
            </div>
        </div>
    </section>

    {{-- Akses Cepat Operasional Meja Sirkulasi --}}
    <div class="mb-8">
        <span class="text-xs uppercase tracking-wider font-bold text-slate-400 block mb-3">Tindakan Cepat Staf</span>
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
            <a href="/pengajuan" class="flex items-center gap-3 p-4 rounded-xl bg-white border border-slate-200/80 hover:border-blue-400 hover:bg-blue-50/40 transition-all shadow-sm group">
                <div class="w-10 h-10 rounded-lg bg-blue-100 text-blue-600 flex items-center justify-center flex-shrink-0 group-hover:scale-110 transition-transform">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div>
                    <h4 class="text-sm font-bold text-slate-800 group-hover:text-blue-600 transition-colors">Konfirmasi Pinjaman</h4>
                    <p class="text-xs text-slate-400">Verifikasi pengajuan dari anggota</p>
                </div>
            </a>

            <a href="/pengembalian" class="flex items-center gap-3 p-4 rounded-xl bg-white border border-slate-200/80 hover:border-emerald-400 hover:bg-emerald-50/40 transition-all shadow-sm group">
                <div class="w-10 h-10 rounded-lg bg-emerald-100 text-emerald-600 flex items-center justify-center flex-shrink-0 group-hover:scale-110 transition-transform">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 15L3 9m0 0l6-6M3 9h12a6 6 0 010 12h-3" />
                    </svg>
                </div>
                <div>
                    <h4 class="text-sm font-bold text-slate-800 group-hover:text-emerald-600 transition-colors">Terima Pengembalian</h4>
                    <p class="text-xs text-slate-400">Proses buku yang dikembalikan</p>
                </div>
            </a>

            <a href="/pembayaran" class="flex items-center gap-3 p-4 rounded-xl bg-white border border-slate-200/80 hover:border-purple-400 hover:bg-purple-50/40 transition-all shadow-sm group">
                <div class="w-10 h-10 rounded-lg bg-purple-100 text-purple-600 flex items-center justify-center flex-shrink-0 group-hover:scale-110 transition-transform">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18.75a60.07 60.07 0 0115.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 013 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75m-1.5-1.5h.375c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125h-.375m1.5-1.5H21a.75.75 0 00-.75.75v.75m0 0H3.75m0 0h-.375a1.125 1.125 0 01-1.125-1.125V15m1.5 1.5v-.75A.75.75 0 003 15h-.75M15 10.5a3 3 0 11-6 0 3 3 0 016 0zm3 0h.008v.008H18V10.5zm-12 0h.008v.008H6V10.5z" />
                    </svg>
                </div>
                <div>
                    <h4 class="text-sm font-bold text-slate-800 group-hover:text-purple-600 transition-colors">Kasir Denda</h4>
                    <p class="text-xs text-slate-400">Pembayaran denda keterlambatan</p>
                </div>
            </a>
        </div>
    </div>

    {{-- Tabel Antrean Pengajuan Peminjaman Terbaru --}}
    <section>
        <div class="bg-white w-full rounded-2xl p-6 border border-slate-200/80 shadow-sm overflow-x-auto">
            <div class="flex items-center justify-between pb-5 border-b border-slate-100">
                <div>
                    <h3 class="text-lg font-bold text-slate-900">Antrean Pengajuan Menunggu Konfirmasi</h3>
                    <p class="text-xs text-slate-500 mt-0.5">Daftar buku yang baru diajukan oleh anggota untuk segera diperiksa</p>
                </div>
                <a href="/pengajuan" class="text-xs font-semibold text-blue-600 hover:text-blue-800 bg-blue-50 hover:bg-blue-100 px-3.5 py-1.5 rounded-lg transition-colors">
                    Buka Semua Pengajuan ({{ $Pengajuan }})
                </a>
            </div>

            <table class="w-full min-w-[750px] border-collapse mt-2">
                <thead>
                    <tr class="text-left border-b border-slate-200">
                        <th class="py-3 px-4 text-xs font-semibold text-slate-500 uppercase">Buku</th>
                        <th class="py-3 px-4 text-xs font-semibold text-slate-500 uppercase">Nama Anggota</th>
                        <th class="py-3 px-4 text-xs font-semibold text-slate-500 uppercase text-center">Tgl Pinjam</th>
                        <th class="py-3 px-4 text-xs font-semibold text-slate-500 uppercase text-center">Status</th>
                        <th class="py-3 px-4 text-xs font-semibold text-slate-500 uppercase text-center">Aksi Cepat</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse ($Pengajuan_terbaru as $pengajuan)
                        <tr class="hover:bg-slate-50/70 transition-colors">
                            <td class="py-3.5 px-4">
                                <div class="font-bold text-slate-900 text-sm">{{ $pengajuan->buku->judul_buku ?? 'Buku Tidak Diketahui' }}</div>
                                <div class="text-xs text-slate-400 font-mono mt-0.5">{{ $pengajuan->buku->kode_buku ?? '-' }} • Rak: {{ $pengajuan->buku->rak ?? '-' }}</div>
                            </td>
                            <td class="py-3.5 px-4">
                                <div class="font-medium text-slate-800 text-sm">{{ $pengajuan->anggota->nama_lengkap ?? 'Anggota' }}</div>
                                <div class="text-xs text-slate-400 font-mono">{{ $pengajuan->anggota->nomer_induk ?? '-' }}</div>
                            </td>
                            <td class="py-3.5 px-4 text-center text-sm text-slate-600 font-medium whitespace-nowrap">
                                {{ \Carbon\Carbon::parse($pengajuan->tanggal_pinjam)->translatedFormat('d M Y') }}
                            </td>
                            <td class="py-3.5 px-4 text-center whitespace-nowrap">
                                <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-semibold bg-amber-50 text-amber-700 border border-amber-200">
                                    <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span>
                                    <span>Menunggu</span>
                                </span>
                            </td>
                            <td class="py-3.5 px-4 text-center whitespace-nowrap">
                                <a href="/pengajuan?cari={{ $pengajuan->anggota->nomer_induk ?? '' }}" 
                                   class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-semibold bg-blue-50 text-blue-600 border border-blue-200 hover:bg-blue-600 hover:text-white transition-all cursor-pointer">
                                    <span>Proses</span>
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
                                    </svg>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-12 text-slate-400">
                                <div class="flex flex-col items-center justify-center">
                                    <div class="w-12 h-12 rounded-full bg-emerald-50 text-emerald-600 flex items-center justify-center mb-2">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                                        </svg>
                                    </div>
                                    <span class="text-sm font-semibold text-slate-700">Tidak ada pengajuan yang menunggu konfirmasi</span>
                                    <span class="text-xs text-slate-400 mt-0.5">Semua permintaan peminjaman buku sudah selesai diproses.</span>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>
@endsection
