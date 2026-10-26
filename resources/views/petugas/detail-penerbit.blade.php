@extends('layouts.index')

@section('halaman', 'Detail Penerbit')
@section('suffix', 'Daftar buku yang diterbitkan oleh ' . $penerbit->nama_penerbit)

@section('main')
    <section class="mt-8">

        {{-- Back + Header --}}
        <div class="flex items-center gap-3 mb-6">
            <a href="/petugas/daftar-penerbit" class="w-9 h-9 rounded-xl bg-white border border-slate-200 text-slate-600 hover:text-slate-900 hover:bg-slate-100 flex items-center justify-center transition shadow-sm">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
            </a>
            <div>
                <h2 class="text-xl font-bold text-slate-800">{{ $penerbit->nama_penerbit }}</h2>
                <p class="text-xs text-slate-400 mt-0.5">{{ $penerbit->bukus_count }} judul buku terdaftar di katalog</p>
            </div>
        </div>

        {{-- Info Penerbit --}}
        <div class="bg-white rounded-2xl border border-slate-200 p-6 mb-6 shadow-sm grid grid-cols-2 md:grid-cols-4 gap-4">
            <div>
                <p class="text-[11px] text-slate-400 font-semibold uppercase tracking-wider mb-1">Alamat Kantor</p>
                <p class="text-xs font-semibold text-slate-700">{{ $penerbit->alamat ?? '-' }}</p>
            </div>
            <div>
                <p class="text-[11px] text-slate-400 font-semibold uppercase tracking-wider mb-1">Email Kontak</p>
                <p class="text-xs font-semibold text-slate-700">{{ $penerbit->email ?? '-' }}</p>
            </div>
            <div>
                <p class="text-[11px] text-slate-400 font-semibold uppercase tracking-wider mb-1">Nomor Telepon</p>
                <p class="text-xs font-semibold text-slate-700">{{ $penerbit->telepon ?? '-' }}</p>
            </div>
            <div>
                <p class="text-[11px] text-slate-400 font-semibold uppercase tracking-wider mb-1">Situs Web</p>
                <p class="text-xs font-semibold text-slate-700">{{ $penerbit->website ?? '-' }}</p>
            </div>
        </div>

        {{-- Daftar Buku --}}
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
            <div class="px-6 py-4 border-b border-slate-100 bg-slate-50/60">
                <h3 class="font-bold text-sm text-slate-800">Daftar Buku Terbitan</h3>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm">
                    <thead>
                        <tr class="bg-slate-50/80 border-b border-slate-200 text-slate-500 text-xs uppercase tracking-wider font-semibold">
                            <th class="py-3 px-6 text-center w-16">Cover</th>
                            <th class="py-3 px-6">Judul Buku</th>
                            <th class="py-3 px-6">Penulis</th>
                            <th class="py-3 px-6">Kategori</th>
                            <th class="py-3 px-6 text-center">Tahun</th>
                            <th class="py-3 px-6 text-center">Stok</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse ($bukus as $buku)
                            <tr class="hover:bg-slate-50/80 transition">
                                <td class="py-3.5 px-6 text-center">
                                    <img class="w-10 h-14 object-cover rounded-lg border border-slate-200 shadow-sm mx-auto"
                                        src="{{ $buku->cover_buku ? asset('storage/' . $buku->cover_buku) : asset('icons/no-image.jpg') }}"
                                        alt="{{ $buku->judul_buku }}">
                                </td>
                                <td class="py-3.5 px-6 font-semibold text-slate-800">{{ $buku->judul_buku }}</td>
                                <td class="py-3.5 px-6 text-slate-600 text-xs">{{ $buku->penulis }}</td>
                                <td class="py-3.5 px-6 text-slate-600 text-xs">{{ $buku->kategori ?? '-' }}</td>
                                <td class="py-3.5 px-6 text-center text-slate-500 font-mono text-xs">{{ $buku->tahun_terbit }}</td>
                                <td class="py-3.5 px-6 text-center">
                                    @if ($buku->stok_buku === 0)
                                        <span class="bg-rose-50 text-rose-700 border border-rose-200 px-3 py-0.5 rounded-full text-xs font-semibold">Kosong (0)</span>
                                    @elseif ($buku->stok_buku <= 4)
                                        <span class="bg-amber-50 text-amber-700 border border-amber-200 px-3 py-0.5 rounded-full text-xs font-semibold">{{ $buku->stok_buku }} Sisa</span>
                                    @else
                                        <span class="bg-emerald-50 text-emerald-700 border border-emerald-200 px-3 py-0.5 rounded-full text-xs font-semibold">{{ $buku->stok_buku }} Buku</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-10 text-slate-400 text-sm">
                                    Belum ada buku terdaftar untuk penerbit ini.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </section>
@endsection
