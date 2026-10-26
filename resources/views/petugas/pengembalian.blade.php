@extends('layouts.index')

@section('halaman', 'Daftar Pengembalian Buku')

@section('main')
    {{-- Header & Search Bar --}}
    <section class="mt-8 flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center font-bold">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6" />
                    </svg>
                </div>
                <div>
                    <h2 class="text-xl font-bold text-slate-800">Antrean Pengembalian</h2>
                    <p class="text-xs text-slate-500 mt-0.5">Konfirmasi buku yang dikembalikan anggota dan cek perhitungan denda jika ada keterlambatan</p>
                </div>
            </div>
        </div>

        {{-- Form Cari --}}
        <form action="/pengembalian" method="GET" class="flex items-center gap-2">
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
                <a href="/pengembalian" class="bg-slate-100 hover:bg-slate-200 text-slate-600 px-3.5 py-2.5 rounded-xl text-sm transition font-medium">
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
                    <span class="w-2.5 h-2.5 rounded-full bg-blue-500 animate-pulse"></span>
                    <span class="text-sm font-semibold text-slate-700">Daftar Pengembalian Menunggu Verifikasi</span>
                </div>
                <span class="text-xs text-slate-500 bg-white px-3 py-1 rounded-full border border-slate-200">
                    Total: {{ $pengembalians->total() }} Data
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
                            <th class="py-3.5 px-4 text-center">Tgl Dikembalikan</th>
                            <th class="py-3.5 px-4 text-center">Status</th>
                            <th class="py-3.5 px-4 text-center">Aksi Petugas</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse ($pengembalians as $pengembalian)
                            @php
                                $isTerlambat = false;
                                if ($pengembalian->tanggal_kembalikan && $pengembalian->peminjaman && $pengembalian->peminjaman->tanggal_jatuh_tempo) {
                                    $isTerlambat = \Carbon\Carbon::parse($pengembalian->tanggal_kembalikan)->toDateString() >
                                                   \Carbon\Carbon::parse($pengembalian->peminjaman->tanggal_jatuh_tempo)->toDateString();
                                }
                            @endphp
                            <tr class="hover:bg-slate-50/80 transition-colors">
                                {{-- Info Buku --}}
                                <td class="py-4 px-4 text-center">
                                    <span class="inline-block font-mono text-[11px] font-bold text-blue-700 bg-blue-50 border border-blue-200 px-2.5 py-0.5 rounded-md mb-1">
                                        {{ $pengembalian->peminjaman->buku->kode_buku ?? 'KODE-N/A' }}
                                    </span>
                                    <p class="font-semibold text-slate-800 text-sm max-w-[200px] mx-auto truncate" title="{{ $pengembalian->peminjaman->buku->judul_buku ?? 'N/A' }}">
                                        {{ $pengembalian->peminjaman->buku->judul_buku ?? 'Buku Tidak Diketahui' }}
                                    </p>
                                </td>

                                {{-- Peminjam --}}
                                <td class="py-4 px-4">
                                    <p class="font-semibold text-slate-800">
                                        {{ $pengembalian->peminjaman->anggota->nama_lengkap ?? 'N/A' }}
                                    </p>
                                    <p class="text-xs font-mono text-slate-500 mt-0.5">
                                        NIK/NIS: {{ $pengembalian->peminjaman->anggota->nomer_induk ?? '-' }}
                                    </p>
                                </td>

                                {{-- Tgl Pinjam --}}
                                <td class="py-4 px-4 text-center text-slate-700 font-medium">
                                    {{ $pengembalian->peminjaman->tanggal_pinjam ? \Carbon\Carbon::parse($pengembalian->peminjaman->tanggal_pinjam)->translatedFormat('d M Y') : '-' }}
                                </td>

                                {{-- Tgl Tempo --}}
                                <td class="py-4 px-4 text-center text-slate-700 font-medium">
                                    {{ $pengembalian->peminjaman->tanggal_jatuh_tempo ? \Carbon\Carbon::parse($pengembalian->peminjaman->tanggal_jatuh_tempo)->translatedFormat('d M Y') : '-' }}
                                </td>

                                {{-- Tgl Pengembalian & Late Warning --}}
                                <td class="py-4 px-4 text-center">
                                    @if ($isTerlambat || ($pengembalian->total_hari_terlambat > 0))
                                        <div class="flex flex-col items-center">
                                            <span class="text-xs text-rose-600 font-bold bg-rose-50 border border-rose-200 px-2.5 py-0.5 rounded-full inline-flex items-center gap-1">
                                                <svg class="w-3 h-3 text-rose-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                                </svg>
                                                Telat {{ $pengembalian->total_hari_terlambat }} hari
                                            </span>
                                            <span class="text-[11px] text-slate-500 mt-1 font-medium">
                                                {{ $pengembalian->tanggal_kembalikan ? \Carbon\Carbon::parse($pengembalian->tanggal_kembalikan)->translatedFormat('d M Y') : '-' }}
                                            </span>
                                        </div>
                                    @else
                                        <span class="text-xs font-semibold text-emerald-700 bg-emerald-50 border border-emerald-200 px-2.5 py-0.5 rounded-full inline-flex items-center gap-1">
                                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                            Tepat Waktu
                                        </span>
                                        <p class="text-[11px] text-slate-500 mt-1">
                                            {{ $pengembalian->tanggal_kembalikan ? \Carbon\Carbon::parse($pengembalian->tanggal_kembalikan)->translatedFormat('d M Y') : '-' }}
                                        </p>
                                    @endif
                                </td>

                                {{-- Status --}}
                                <td class="py-4 px-4 text-center">
                                    <span class="inline-flex items-center gap-1.5 bg-amber-50 text-amber-700 border border-amber-200 px-3 py-1 rounded-full text-xs font-semibold">
                                        <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span>
                                        {{ ucfirst($pengembalian->status ?? 'menunggu') }}
                                    </span>
                                </td>

                                {{-- Aksi --}}
                                <td class="py-4 px-4 text-center">
                                    <div class="flex items-center justify-center gap-1.5">
                                        {{-- Detail --}}
                                        <button class="openModalDetailPengembalian bg-slate-100 hover:bg-slate-200 text-slate-700 px-2.5 py-1.5 rounded-lg text-xs font-medium transition cursor-pointer flex items-center gap-1"
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
                                            type="button"
                                            title="Lihat Detail">
                                            <svg class="w-3.5 h-3.5 text-slate-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                            </svg>
                                            <span>Detail</span>
                                        </button>

                                        {{-- Konfirmasi / Terima --}}
                                        <button type="button"
                                            class="btnOpenModalKembalikan bg-blue-600 hover:bg-blue-700 text-white px-3 py-1.5 rounded-lg text-xs font-semibold transition cursor-pointer shadow-sm flex items-center gap-1"
                                            data-id="{{ $pengembalian->id }}"
                                            data-judul="{{ $pengembalian->peminjaman->buku->judul_buku ?? '' }}"
                                            data-kode="{{ $pengembalian->peminjaman->buku->kode_buku ?? '' }}"
                                            data-nama="{{ $pengembalian->peminjaman->anggota->nama_lengkap ?? '' }}"
                                            data-nis="{{ $pengembalian->peminjaman->anggota->nomer_induk ?? '' }}"
                                            data-pinjam="{{ $pengembalian->peminjaman->tanggal_pinjam ?? '' }}"
                                            data-tempo="{{ $pengembalian->peminjaman->tanggal_jatuh_tempo ?? '' }}"
                                            data-telat="{{ $pengembalian->total_hari_terlambat ?? 0 }}"
                                            title="Terima Pengembalian Buku">
                                            <svg class="w-3.5 h-3.5 text-white" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                                            </svg>
                                            <span>Proses</span>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-12">
                                    <div class="flex flex-col items-center justify-center">
                                        <div class="w-12 h-12 rounded-full bg-slate-100 flex items-center justify-center text-slate-400 mb-2">
                                            <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                            </svg>
                                        </div>
                                        <p class="text-sm font-medium text-slate-700">Tidak ada pengembalian yang pending.</p>
                                        <p class="text-xs text-slate-400 mt-0.5">Semua buku yang dikembalikan telah diverifikasi.</p>
                                    </div>
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

    {{-- Detail Pengembalian Modal --}}
    @include('components.modal-detail-pengembalian')

    {{-- Modal Kembalikan (Denda & Kondisi Buku) --}}
    @include('components.modal-pengembalian-konfirmasi-petugas')

@endsection
