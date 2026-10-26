@extends('layouts.index')

@section('halaman', 'Detail Penerbit')
@section('suffix', 'Daftar buku yang diterbitkan oleh ' . $penerbit->nama_penerbit)

@section('main')
    <section class="mt-8 px-2">

        {{-- Back + Header --}}
        <div class="flex items-center gap-4 mb-8">
            <a href="/daftar-penerbit" class="text-cyan-400 hover:text-cyan-300 transition p-2.5 rounded-xl bg-slate-900/60 border border-slate-700/60 hover:border-cyan-500/40 shadow-md">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
            </a>
            <div class="w-14 h-14 rounded-2xl bg-gradient-to-tr from-cyan-500/20 to-violet-500/20 border border-cyan-500/30 flex items-center justify-center overflow-hidden flex-shrink-0 p-1.5 shadow-lg shadow-cyan-500/10">
                @if($penerbit->logo)
                    <img src="{{ asset('storage/' . $penerbit->logo) }}" class="w-full h-full object-contain" alt="{{ $penerbit->nama_penerbit }}">
                @else
                    <img src="{{ asset('icons/svg/penerbit-aktif.svg') }}" class="w-7 h-7 object-contain" alt="Penerbit">
                @endif
            </div>
            <div>
                <h2 class="text-2xl font-bold text-white tracking-tight">{{ $penerbit->nama_penerbit }}</h2>
                <p class="text-xs text-slate-400 mt-0.5">{{ $penerbit->bukus_count }} judul buku terdaftar di katalog</p>
            </div>
        </div>

        {{-- Info Penerbit --}}
        <div class="bg-white rounded-2xl border border-slate-700/60 p-6 mb-8 grid grid-cols-2 md:grid-cols-4 gap-6 shadow-xl">
            <div>
                <p class="text-xs text-slate-400 font-semibold uppercase tracking-wider mb-1">Alamat</p>
                <p class="text-sm font-medium text-white">{{ $penerbit->alamat ?? '-' }}</p>
            </div>
            <div>
                <p class="text-xs text-slate-400 font-semibold uppercase tracking-wider mb-1">Email</p>
                <p class="text-sm font-medium text-cyan-400">{{ $penerbit->email ?? '-' }}</p>
            </div>
            <div>
                <p class="text-xs text-slate-400 font-semibold uppercase tracking-wider mb-1">Telepon</p>
                <p class="text-sm font-medium text-white">{{ $penerbit->telepon ?? '-' }}</p>
            </div>
            <div>
                <p class="text-xs text-slate-400 font-semibold uppercase tracking-wider mb-1">Website</p>
                @if($penerbit->website)
                    <a href="{{ $penerbit->website }}" target="_blank" class="text-sm font-medium text-cyan-400 hover:underline">
                        {{ $penerbit->website }}
                    </a>
                @else
                    <p class="text-sm font-medium text-slate-500">-</p>
                @endif
            </div>
        </div>

        {{-- Daftar Buku --}}
        <div class="bg-white rounded-2xl border border-slate-700/60 overflow-hidden shadow-xl">
            <div class="p-6 border-b border-slate-700/60">
                <h3 class="font-bold text-white text-base">Koleksi Buku Terdaftar</h3>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full min-w-[700px] border-collapse">
                    <thead>
                        <tr>
                            <th class="py-3.5 px-4 text-left text-xs uppercase tracking-wider text-slate-300 font-semibold">Cover</th>
                            <th class="py-3.5 px-4 text-left text-xs uppercase tracking-wider text-slate-300 font-semibold">Judul Buku</th>
                            <th class="py-3.5 px-4 text-left text-xs uppercase tracking-wider text-slate-300 font-semibold">Penulis</th>
                            <th class="py-3.5 px-4 text-left text-xs uppercase tracking-wider text-slate-300 font-semibold">Kategori</th>
                            <th class="py-3.5 px-4 text-center text-xs uppercase tracking-wider text-slate-300 font-semibold">Tahun Terbit</th>
                            <th class="py-3.5 px-4 text-center text-xs uppercase tracking-wider text-slate-300 font-semibold">Stok</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($bukus as $buku)
                            <tr class="border-t border-slate-700/40 hover:bg-slate-800/40 transition">
                                <td class="py-4 px-4">
                                    <img class="w-10 rounded shadow"
                                        src="{{ $buku->cover_buku ? asset('storage/' . $buku->cover_buku) : asset('icons/no-image.jpg') }}"
                                        alt="{{ $buku->judul_buku }}">
                                </td>
                                <td class="py-4 px-4 font-semibold text-white">{{ $buku->judul_buku }}</td>
                                <td class="py-4 px-4 text-slate-300 text-sm">{{ $buku->penulis }}</td>
                                <td class="py-4 px-4 text-slate-300 text-sm">{{ $buku->kategori ?? '-' }}</td>
                                <td class="py-4 px-4 text-center text-slate-300 text-sm">{{ $buku->tahun_terbit }}</td>
                                <td class="py-4 px-4 text-center">
                                    @if ($buku->stok_buku === 0)
                                        <span class="bg-rose-500/20 text-rose-300 border border-rose-500/30 px-3.5 py-1 rounded-full text-xs font-bold">{{ $buku->stok_buku }}</span>
                                    @elseif ($buku->stok_buku <= 4)
                                        <span class="bg-amber-500/20 text-amber-300 border border-amber-500/30 px-3.5 py-1 rounded-full text-xs font-bold">{{ $buku->stok_buku }}</span>
                                    @else
                                        <span class="bg-emerald-500/20 text-emerald-300 border border-emerald-500/30 px-3.5 py-1 rounded-full text-xs font-bold">{{ $buku->stok_buku }}</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="py-12 text-center text-slate-400 italic">Belum ada buku dari penerbit ini.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </section>
@endsection
