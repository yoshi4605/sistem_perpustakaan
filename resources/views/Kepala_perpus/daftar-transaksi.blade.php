@extends('layouts.index')

@section('halaman', 'Transaksi Pengajuan Dan Pengembalian')

@section('main')
    <section class="mt-20">
        {{-- Header --}}
        <div class="flex flex-col gap-4 mb-6">
            <div class="flex flex-col md:flex-row md:items-center justify-end gap-3">
                <form action="/daftar-transaksi" method="GET" class="form-cari flex gap-2 items-center">
                    <select name="jenis_transaksi"
                        class="border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-red-500">
                        <option value="pengajuan"
                            {{ request('jenis_transaksi', 'pengajuan') == 'pengajuan' ? 'selected' : '' }}>Konfirmasi
                            Pengajuan</option>
                        <option value="pengembalian" {{ request('jenis_transaksi') == 'pengembalian' ? 'selected' : '' }}>
                            Konfirmasi Pengembalian</option>
                    </select>

                    <select name="filter_waktu"
                        class="border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-red-500">
                        <option value="" {{ request('filter_waktu') == '' ? 'selected' : '' }}>Semua</option>
                        <option value="minggu_ini" {{ request('filter_waktu') == 'minggu_ini' ? 'selected' : '' }}>
                            Minggu Ini
                        </option>
                        <option value="bulan_ini" {{ request('filter_waktu') == 'bulan_ini' ? 'selected' : '' }}>
                            Bulan Ini
                        </option>
                        <option value="bulan_lalu" {{ request('filter_waktu') == 'bulan_lalu' ? 'selected' : '' }}>
                            Bulan Lalu
                        </option>
                    </select>

                    <button type="submit"
                        class="flex items-center gap-2 bg-[#35094D] text-white px-4 py-2 rounded-lg text-sm cursor-pointer">
                        <img class="w-5" src="{{ asset('icons/svg/filter.svg') }}" alt="">
                        <span>Terapkan</span>
                    </button>
                </form>
                {{-- Filter Preset --}}

                {{-- Tombol Export PDF --}}
                <form action="/cetak-pdf/transaksi" method="GET" class="form-cari">
                    <input type="hidden" name="filter_waktu" value="{{ request('filter_waktu') }}">
                    <input type="hidden" name="jenis_transaksi" value="{{ request('jenis_transaksi') ?? 'pengajuan' }}">

                    <button type="submit"
                        class="flex items-center gap-2 bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg transition-all shadow-sm">
                        <img src="{{ asset('icons/svg/pdf-export.svg') }}" alt="">
                        <span class="font-medium">Export PDF</span>
                    </button>
                </form>

            </div>
        </div>

        <div class="bg-white w-full rounded-2xl mt-8 p-6 shadow-xl border border-slate-700/60 overflow-x-auto">
            <table class="w-full min-w-[850px] border-collapse">
                <thead>
                    <tr class="text-left border-b border-gray-200">
                        <th class="py-3.5 px-4 text-center text-slate-300 font-semibold uppercase text-xs tracking-wider whitespace-nowrap">Kode Buku</th>
                        <th class="py-3.5 px-4 text-center text-slate-300 font-semibold uppercase text-xs tracking-wider whitespace-nowrap">Nik/Nis</th>
                        <th class="py-3.5 px-4 text-center text-slate-300 font-semibold uppercase text-xs tracking-wider whitespace-nowrap">Nama Peminjam</th>
                        @if ($jenis_transaksi === 'pengembalian')
                            <th class="py-3.5 px-4 text-center text-slate-300 font-semibold uppercase text-xs tracking-wider whitespace-nowrap">Tanggal Dikembalikan</th>
                            <th class="py-3.5 px-4 text-center text-slate-300 font-semibold uppercase text-xs tracking-wider whitespace-nowrap">Hari Telat</th>
                            <th class="py-3.5 px-4 text-center text-slate-300 font-semibold uppercase text-xs tracking-wider whitespace-nowrap">Denda Terbayar</th>
                        @else
                            <th class="py-3.5 px-4 text-center text-slate-300 font-semibold uppercase text-xs tracking-wider whitespace-nowrap">Tanggal Pinjam</th>
                            <th class="py-3.5 px-4 text-center text-slate-300 font-semibold uppercase text-xs tracking-wider whitespace-nowrap">Tanggal Jatuh Tempo</th>
                        @endif
                        <th class="py-3.5 px-4 text-center text-slate-300 font-semibold uppercase text-xs tracking-wider whitespace-nowrap">Petugas</th>
                        <th class="py-3.5 px-4 text-center text-slate-300 font-semibold uppercase text-xs tracking-wider whitespace-nowrap">Detail</th>
                        <th class="py-3.5 px-4 text-center text-slate-300 font-semibold uppercase text-xs tracking-wider whitespace-nowrap">Status Konfirmasi</th>
                    </tr>
                </thead>
                <tbody class="text-[#35094D]">
                    @forelse ($transaksis as $item)
                        <tr class="border-b border-gray-200">
                            <td class="py-4 text-center">{{ $item->peminjaman->buku->kode_buku ?? 'N/A' }}</td>
                            <td class="py-4 text-center">{{ $item->peminjaman->anggota->nomer_induk ?? 'N/A' }}</td>
                            <td class="py-4 text-center">{{ $item->peminjaman->anggota->nama_lengkap ?? 'N/A' }}</td>
                            @if ($jenis_transaksi === 'pengembalian')
                                <td class="py-4 text-center">
                                    {{ $item->tanggal_kembalikan ?? $item->updated_at->format('Y-m-d') }}</td>
                                <td
                                    class="py-4 text-center text-{{ $item->total_hari_terlambat > 0 ? 'red-500 font-medium' : 'gray-700' }}">
                                    {{ ceil($item->total_hari_terlambat ?? 0) }} hari
                                </td>
                                <td class="py-4 text-center">Rp {{ number_format($item->jumlah_denda, 0, ',', '.') }}</td>
                            @else
                                <td class="py-4 text-center">{{ $item->peminjaman->tanggal_pinjam ?? 'N/A' }}</td>
                                <td class="py-4 text-center">{{ $item->peminjaman->tanggal_jatuh_tempo ?? 'N/A' }}</td>
                            @endif
                            <td class="py-4 text-center">{{ $item->peminjaman->petugas->nama_lengkap ?? 'N/A' }}</td>
                            <td class="py-4">
                                @if ($jenis_transaksi === 'pengembalian')
                                    <button class="openModalDetailPengembalian mx-auto flex justify-center cursor-pointer"
                                        data-id="{{ $item->peminjaman->id }}"
                                        data-nomer_induk="{{ $item->peminjaman->anggota->nomer_induk }}"
                                        data-nama="{{ $item->peminjaman->anggota->nama_lengkap }}"
                                        data-jk="{{ $item->peminjaman->anggota->jenis_kelamin }}"
                                        data-alamat="{{ $item->peminjaman->anggota->alamat }}"
                                        data-tgl_pinjam="{{ $item->peminjaman->tanggal_pinjam }}"
                                        data-tgl_tempo="{{ $item->peminjaman->tanggal_jatuh_tempo }}"
                                        data-tgl_kembalikan="{{ $item->tanggal_kembalikan ?? $item->updated_at->format('Y-m-d') }}"
                                        data-total_hari_telat="{{ $item->total_hari_terlambat }}"
                                        data-status_pinjaman="{{ $item->peminjaman->status }}"
                                        data-status_kembalikan="{{ $item->status }}"
                                        data-kode_buku="{{ $item->peminjaman->buku->kode_buku }}"
                                        data-judul_buku="{{ $item->peminjaman->buku->judul_buku }}"
                                        data-penulis="{{ $item->peminjaman->buku->penulis }}"
                                        data-thn_terbit="{{ $item->peminjaman->buku->tahun_terbit }}"
                                        data-jumlah_denda="{{ $item->jumlah_denda }}"
                                        data-total_bayar="{{ $item->total_bayar }}"
                                        data-jumlah_bayar="{{ $item->jumlah_bayar }}"
                                        data-buku_rusak="{{ $item->buku_rusak }}"
                                        data-buku_hilang="{{ $item->buku_hilang }}"
                                        data-status_pembayaran="{{ $item->status_pembayaran }}"
                                        data-jumlah_kembalian="{{ $item->jumlah_kembalian }}" type="button">
                                        <img src="{{ asset('icons/svg/detail.svg') }}" alt="">
                                    </button>
                                @else
                                    <button class="openModalDetailPengajuan mx-auto flex justify-center cursor-pointer"
                                        data-id="{{ $item->id }}"
                                        data-nomer_induk="{{ $item->peminjaman->anggota->nomer_induk }}"
                                        data-nama="{{ $item->peminjaman->anggota->nama_lengkap }}"
                                        data-jk="{{ $item->peminjaman->anggota->jenis_kelamin }}"
                                        data-alamat="{{ $item->peminjaman->anggota->alamat }}"
                                        data-tgl_pinjam="{{ $item->peminjaman->tanggal_pinjam }}"
                                        data-tgl_tempo="{{ $item->peminjaman->tanggal_jatuh_tempo }}"
                                        data-status="{{ $item->status }}"
                                        data-kode_buku="{{ $item->peminjaman->buku->kode_buku }}"
                                        data-judul_buku="{{ $item->peminjaman->buku->judul_buku }}"
                                        data-penulis="{{ $item->peminjaman->buku->penulis }}"
                                        data-thn_terbit="{{ $item->peminjaman->buku->tahun_terbit }}" type="button">
                                        <img src="{{ asset('icons/svg/detail.svg') }}" alt="">
                                    </button>
                                @endif
                            </td>
                            <td class="py-4 text-center capitalize">
                                @if ($item->status === 'dipinjamkan' || $item->status === 'dikembalikan')
                                    <span class="bg-[#16C09861] font-medium text-[#008767] px-6 py-2 rounded-full">
                                        {{ $item->status }}
                                    </span>
                                @elseif ($item->status === 'ditolak')
                                    <span class="bg-red-200 font-medium text-red-500 px-6 py-2 rounded-full">
                                        {{ $item->status }}
                                    </span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="text-center py-10 px-4 text-slate-400 italic">
                                Tidak ada data transaksi yang ditemukan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            <div class="mt-4">
                {{ $transaksis->links() }}
            </div>
        </div>
    </section>

    {{-- Modal Detail --}}
    @include('components.modal-detail-pengajuan')
    @include('components.modal-detail-pengembalian')

@endsection
