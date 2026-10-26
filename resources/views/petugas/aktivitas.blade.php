@extends('layouts.index')

@section('halaman', 'Riwayat Aktivitas Petugas')

@section('main')
    {{-- Header & Filters --}}
    <section class="mt-8 flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center font-bold">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <div>
                <h2 class="text-xl font-bold text-slate-800">Riwayat Penanganan Sirkulasi</h2>
                <p class="text-xs text-slate-500 mt-0.5">Catatan seluruh transaksi peminjaman & pengembalian yang telah Anda proses</p>
            </div>
        </div>

        <div class="flex flex-wrap items-center gap-2">
            {{-- Filter Form --}}
            <form action="/aktivitas" method="GET" class="flex flex-wrap items-center gap-2">
                <select name="jenis_aktivitas"
                    class="bg-white border border-slate-200 rounded-xl px-3 py-2 text-xs font-medium text-slate-700 outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-100 transition cursor-pointer">
                    <option value="pengajuan" {{ request('jenis_aktivitas', 'pengajuan') == 'pengajuan' ? 'selected' : '' }}>
                        Peminjaman
                    </option>
                    <option value="pengembalian" {{ request('jenis_aktivitas') == 'pengembalian' ? 'selected' : '' }}>
                        Pengembalian
                    </option>
                </select>

                <select name="filter_waktu"
                    class="bg-white border border-slate-200 rounded-xl px-3 py-2 text-xs font-medium text-slate-700 outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-100 transition cursor-pointer">
                    <option value="" {{ request('filter_waktu') == '' ? 'selected' : '' }}>Semua Periode</option>
                    <option value="minggu_ini" {{ request('filter_waktu') == 'minggu_ini' ? 'selected' : '' }}>Minggu Ini</option>
                    <option value="bulan_ini" {{ request('filter_waktu') == 'bulan_ini' ? 'selected' : '' }}>Bulan Ini</option>
                    <option value="bulan_lalu" {{ request('filter_waktu') == 'bulan_lalu' ? 'selected' : '' }}>Bulan Lalu</option>
                </select>

                <button type="submit"
                    class="bg-blue-600 hover:bg-blue-700 text-white px-3.5 py-2 rounded-xl text-xs font-semibold cursor-pointer shadow-sm transition flex items-center gap-1.5">
                    <svg class="w-3.5 h-3.5 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
                    </svg>
                    <span>Filter</span>
                </button>
            </form>

            {{-- Export PDF --}}
            <form action="/cetak-pdf/pengajuan" method="GET">
                <input type="hidden" name="filter_waktu" value="{{ request('filter_waktu') }}">
                <input type="hidden" name="jenis_aktivitas" value="{{ request('jenis_aktivitas') ?? 'pengajuan' }}">
                <button type="submit"
                    class="bg-slate-900 hover:bg-slate-800 text-white px-3.5 py-2 rounded-xl text-xs font-semibold transition shadow-sm flex items-center gap-1.5 cursor-pointer">
                    <svg class="w-3.5 h-3.5 text-rose-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    <span>Export PDF</span>
                </button>
            </form>
        </div>
    </section>

    {{-- Content Table --}}
    <section class="mt-6">
        <div class="bg-white w-full rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
            <div class="px-6 py-4 border-b border-slate-100 flex flex-col sm:flex-row sm:items-center justify-between gap-2 bg-slate-50/60">
                <div class="flex items-center gap-2">
                    <span class="w-2.5 h-2.5 rounded-full bg-blue-500"></span>
                    <span class="text-sm font-semibold text-slate-700">
                        {{ $jenis_aktivitas === 'pengembalian' ? 'Daftar Pengembalian Yang Telah Diproses' : 'Daftar Peminjaman Yang Telah Diproses' }}
                    </span>
                </div>
                <div class="text-xs text-slate-500">
                    Petugas: <span class="font-bold text-slate-800">{{ Auth::user()->Petugas->nama_lengkap ?? Auth::user()->username }}</span>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm">
                    <thead>
                        <tr class="bg-slate-50/80 border-b border-slate-200 text-slate-500 text-xs uppercase tracking-wider font-semibold">
                            <th class="py-3.5 px-4 text-center">Buku</th>
                            <th class="py-3.5 px-4">Peminjam</th>
                            @if ($jenis_aktivitas === 'pengembalian')
                                <th class="py-3.5 px-4 text-center">Tgl Dikembalikan</th>
                                <th class="py-3.5 px-4 text-center">Keterlambatan</th>
                                <th class="py-3.5 px-4 text-center">Total Denda</th>
                                <th class="py-3.5 px-4 text-center">Bayar</th>
                            @else
                                <th class="py-3.5 px-4 text-center">Tgl Pinjam</th>
                                <th class="py-3.5 px-4 text-center">Jatuh Tempo</th>
                            @endif
                            <th class="py-3.5 px-4 text-center">Status</th>
                            <th class="py-3.5 px-4 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse ($aktivitas_data as $item)
                            <tr class="hover:bg-slate-50/80 transition-colors">
                                {{-- Buku --}}
                                <td class="py-4 px-4 text-center">
                                    <span class="inline-block font-mono text-[11px] font-bold text-blue-700 bg-blue-50 border border-blue-200 px-2 py-0.5 rounded-md mb-1">
                                        {{ $item->peminjaman->buku->kode_buku ?? 'KODE-N/A' }}
                                    </span>
                                    <p class="font-semibold text-slate-800 text-xs max-w-[180px] mx-auto truncate" title="{{ $item->peminjaman->buku->judul_buku ?? 'N/A' }}">
                                        {{ $item->peminjaman->buku->judul_buku ?? 'Buku' }}
                                    </p>
                                </td>

                                {{-- Peminjam --}}
                                <td class="py-4 px-4">
                                    <p class="font-semibold text-slate-800 text-xs">
                                        {{ $item->peminjaman->anggota->nama_lengkap ?? 'Anggota' }}
                                    </p>
                                    <p class="text-[11px] font-mono text-slate-500 mt-0.5">
                                        {{ $item->peminjaman->anggota->nomer_induk ?? '-' }}
                                    </p>
                                </td>

                                @if ($jenis_aktivitas === 'pengembalian')
                                    <td class="py-4 px-4 text-center text-xs text-slate-700 font-medium">
                                        {{ $item->tanggal_kembalikan ? \Carbon\Carbon::parse($item->tanggal_kembalikan)->translatedFormat('d M Y') : '-' }}
                                    </td>
                                    <td class="py-4 px-4 text-center text-xs">
                                        @if(($item->total_hari_terlambat ?? 0) > 0)
                                            <span class="text-rose-600 font-semibold bg-rose-50 border border-rose-200 px-2 py-0.5 rounded-full">
                                                {{ ceil($item->total_hari_terlambat) }} hari
                                            </span>
                                        @else
                                            <span class="text-emerald-700 font-medium bg-emerald-50 border border-emerald-200 px-2 py-0.5 rounded-full">
                                                Tepat Waktu
                                            </span>
                                        @endif
                                    </td>
                                    <td class="py-4 px-4 text-center text-xs font-semibold text-slate-800">
                                        Rp {{ number_format($item->jumlah_denda ?? 0, 0, ',', '.') }}
                                    </td>
                                    <td class="py-4 px-4 text-center">
                                        @if ($item->status_pembayaran === 'lunas')
                                            <span class="bg-emerald-50 text-emerald-700 border border-emerald-200 text-[11px] font-semibold px-2.5 py-0.5 rounded-full">
                                                Lunas
                                            </span>
                                        @elseif ($item->status_pembayaran === 'tertunda')
                                            <span class="bg-amber-50 text-amber-700 border border-amber-200 text-[11px] font-semibold px-2.5 py-0.5 rounded-full">
                                                Tertunda
                                            </span>
                                        @else
                                            <span class="text-slate-400 text-xs">-</span>
                                        @endif
                                    </td>
                                @else
                                    <td class="py-4 px-4 text-center text-xs text-slate-700 font-medium">
                                        {{ $item->peminjaman->tanggal_pinjam ? \Carbon\Carbon::parse($item->peminjaman->tanggal_pinjam)->translatedFormat('d M Y') : '-' }}
                                    </td>
                                    <td class="py-4 px-4 text-center text-xs text-slate-700 font-medium">
                                        {{ $item->peminjaman->tanggal_jatuh_tempo ? \Carbon\Carbon::parse($item->peminjaman->tanggal_jatuh_tempo)->translatedFormat('d M Y') : '-' }}
                                    </td>
                                @endif

                                {{-- Status --}}
                                <td class="py-4 px-4 text-center">
                                    @if ($item->status === 'dipinjamkan' || $item->status === 'dipinjam')
                                        <span class="bg-blue-50 text-blue-700 border border-blue-200 font-semibold text-[11px] px-2.5 py-0.5 rounded-full">
                                            Dipinjam
                                        </span>
                                    @elseif ($item->status === 'dikembalikan')
                                        <span class="bg-emerald-50 text-emerald-700 border border-emerald-200 font-semibold text-[11px] px-2.5 py-0.5 rounded-full">
                                            Dikembalikan
                                        </span>
                                    @elseif ($item->status === 'ditolak')
                                        <span class="bg-rose-50 text-rose-700 border border-rose-200 font-semibold text-[11px] px-2.5 py-0.5 rounded-full">
                                            Ditolak
                                        </span>
                                    @else
                                        <span class="bg-slate-100 text-slate-600 font-semibold text-[11px] px-2.5 py-0.5 rounded-full">
                                            {{ ucfirst($item->status) }}
                                        </span>
                                    @endif
                                </td>

                                {{-- Aksi / Detail --}}
                                <td class="py-4 px-4 text-center">
                                    @if ($jenis_aktivitas === 'pengembalian')
                                        <button class="openModalDetailPengembalian bg-slate-100 hover:bg-slate-200 text-slate-700 px-2.5 py-1.5 rounded-lg text-xs font-medium transition cursor-pointer inline-flex items-center gap-1"
                                            data-id="{{ $item->peminjaman->id ?? '' }}"
                                            data-nomer_induk="{{ $item->peminjaman->anggota->nomer_induk ?? '' }}"
                                            data-nama="{{ $item->peminjaman->anggota->nama_lengkap ?? '' }}"
                                            data-jk="{{ $item->peminjaman->anggota->jenis_kelamin ?? '' }}"
                                            data-alamat="{{ $item->peminjaman->anggota->alamat ?? '' }}"
                                            data-tgl_pinjam="{{ $item->peminjaman->tanggal_pinjam ?? '' }}"
                                            data-tgl_tempo="{{ $item->peminjaman->tanggal_jatuh_tempo ?? '' }}"
                                            data-tgl_kembalikan="{{ $item->tanggal_kembalikan ?? $item->updated_at->format('Y-m-d') }}"
                                            data-total_hari_telat="{{ $item->total_hari_terlambat ?? 0 }}"
                                            data-status_pinjaman="{{ $item->peminjaman->status ?? '' }}"
                                            data-status_kembalikan="{{ $item->status ?? '' }}"
                                            data-kode_buku="{{ $item->peminjaman->buku->kode_buku ?? '' }}"
                                            data-judul_buku="{{ $item->peminjaman->buku->judul_buku ?? '' }}"
                                            data-penulis="{{ $item->peminjaman->buku->penulis ?? '' }}"
                                            data-thn_terbit="{{ $item->peminjaman->buku->tahun_terbit ?? '' }}"
                                            data-jumlah_denda="{{ $item->jumlah_denda ?? 0 }}"
                                            data-total_bayar="{{ $item->total_bayar ?? 0 }}"
                                            data-jumlah_bayar="{{ $item->jumlah_bayar ?? 0 }}"
                                            data-buku_rusak="{{ $item->buku_rusak ?? 0 }}"
                                            data-buku_hilang="{{ $item->buku_hilang ?? 0 }}"
                                            data-status_pembayaran="{{ $item->status_pembayaran ?? '' }}"
                                            data-jumlah_kembalian="{{ $item->jumlah_kembalian ?? 0 }}" type="button">
                                            <svg class="w-3.5 h-3.5 text-slate-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                            </svg>
                                            <span>Detail</span>
                                        </button>
                                    @else
                                        <button class="openModalDetailPengajuan bg-slate-100 hover:bg-slate-200 text-slate-700 px-2.5 py-1.5 rounded-lg text-xs font-medium transition cursor-pointer inline-flex items-center gap-1"
                                            data-id="{{ $item->id ?? '' }}"
                                            data-nomer_induk="{{ $item->peminjaman->anggota->nomer_induk ?? '' }}"
                                            data-nama="{{ $item->peminjaman->anggota->nama_lengkap ?? '' }}"
                                            data-jk="{{ $item->peminjaman->anggota->jenis_kelamin ?? '' }}"
                                            data-alamat="{{ $item->peminjaman->anggota->alamat ?? '' }}"
                                            data-tgl_pinjam="{{ $item->peminjaman->tanggal_pinjam ?? '' }}"
                                            data-tgl_tempo="{{ $item->peminjaman->tanggal_jatuh_tempo ?? '' }}"
                                            data-status="{{ $item->status ?? '' }}"
                                            data-kode_buku="{{ $item->peminjaman->buku->kode_buku ?? '' }}"
                                            data-judul_buku="{{ $item->peminjaman->buku->judul_buku ?? '' }}"
                                            data-penulis="{{ $item->peminjaman->buku->penulis ?? '' }}"
                                            data-thn_terbit="{{ $item->peminjaman->buku->tahun_terbit ?? '' }}" type="button">
                                            <svg class="w-3.5 h-3.5 text-slate-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                            </svg>
                                            <span>Detail</span>
                                        </button>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center py-12">
                                    <div class="flex flex-col items-center justify-center">
                                        <div class="w-12 h-12 rounded-full bg-slate-100 flex items-center justify-center text-slate-400 mb-2">
                                            <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                        </div>
                                        <p class="text-sm font-medium text-slate-700">Belum ada riwayat transaksi pada filter ini.</p>
                                        <p class="text-xs text-slate-400 mt-0.5">Silakan pilih jenis aktivitas atau periode waktu lain.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if ($aktivitas_data->hasPages())
                <div class="px-6 py-4 border-t border-slate-100 bg-slate-50/40">
                    {{ $aktivitas_data->links() }}
                </div>
            @endif
        </div>
    </section>

    {{-- Modal Detail --}}
    @include('components.modal-detail-pengajuan')
    @include('components.modal-detail-pengembalian')

@endsection
