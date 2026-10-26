@extends('layouts.index')

@section('halaman', 'Katalog Buku Perpustakaan')

@section('main')
    {{-- Header Section --}}
    <section class="mb-6">
        <div class="flex flex-col md:flex-row md:items-end justify-between gap-4">
            <div>
                <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">Katalog Buku Perpustakaan</h1>
                <p class="text-slate-500 text-xs sm:text-sm mt-1">Telusuri seluruh koleksi buku fisik yang tersedia untuk dipinjam.</p>
            </div>
            <div class="text-xs text-slate-500 bg-white px-3.5 py-1.5 rounded-full border border-slate-200 shadow-2xs self-start md:self-auto">
                Total Koleksi: <span class="font-bold text-slate-800">{{ $Bukus->total() }} Judul</span>
            </div>
        </div>

        {{-- Search & Filter Bar --}}
        <div class="bg-white rounded-2xl border border-slate-200/80 p-4 mt-6 shadow-xs">
            <form action="/daftar-buku" method="GET" class="flex flex-col sm:flex-row items-center gap-3">
                <div class="relative w-full flex-1">
                    <svg class="w-4 h-4 text-slate-400 absolute left-3.5 top-1/2 -translate-y-1/2 pointer-events-none" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                    <input name="cari" type="text" placeholder="Ketik judul buku, penulis, atau nomor ISBN..."
                        class="w-full bg-slate-50 border border-slate-200 rounded-xl pl-10 pr-4 py-2.5 text-sm text-slate-800 placeholder:text-slate-400 focus:bg-white focus:border-blue-500 focus:ring-2 focus:ring-blue-100 transition outline-none"
                        value="{{ request('cari') }}">
                </div>

                <div class="w-full sm:w-auto flex items-center gap-2 flex-shrink-0">
                    <select name="kategori" onchange="this.form.submit()"
                        class="w-full sm:w-48 bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2.5 text-sm text-slate-700 outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-100 transition cursor-pointer">
                        <option value="">Semua Kategori</option>
                        @foreach ($kategoris as $kat)
                            <option value="{{ $kat }}" {{ request('kategori') == $kat ? 'selected' : '' }}>
                                {{ $kat }}
                            </option>
                        @endforeach
                    </select>

                    <button type="submit" class="px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white rounded-xl text-xs font-semibold shadow-xs transition cursor-pointer">
                        Cari
                    </button>

                    @if(request('kategori') || request('cari'))
                        <a href="/daftar-buku" class="px-3.5 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-600 rounded-xl text-xs font-semibold transition">
                            Reset
                        </a>
                    @endif
                </div>
            </form>

            {{-- Horizontal Category Chips --}}
            <div class="flex items-center gap-2 overflow-x-auto no-scrollbar pt-3 mt-3 border-t border-slate-100 text-xs">
                <span class="text-slate-400 font-medium flex-shrink-0">Kategori:</span>
                <a href="/daftar-buku" class="category-chip px-3 py-1 rounded-full border border-slate-200 text-slate-600 flex-shrink-0 {{ !request('kategori') ? 'active' : '' }}">
                    Semua
                </a>
                @foreach (['Teknologi & Komputer', 'Novel', 'Fiksi', 'Ekonomi & Bisnis', 'Ilmu Pengetahuan', 'Buku Teks', 'Sejarah'] as $popularKat)
                    <a href="/daftar-buku?kategori={{ urlencode($popularKat) }}"
                       class="category-chip px-3 py-1 rounded-full border border-slate-200 text-slate-600 flex-shrink-0 {{ request('kategori') == $popularKat ? 'active' : '' }}">
                        {{ $popularKat }}
                    </a>
                @endforeach
            </div>
        </div>
    </section>

    {{-- Books Grid --}}
    <section class="mb-12">
        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-5">
            @forelse ($Bukus as $buku)
                <div class="book-card bg-white rounded-2xl border border-slate-200/80 p-3.5 flex flex-col justify-between group shadow-xs">
                    <a href="/daftar-buku/detail-buku={{ $buku->id }}" class="block">
                        {{-- Cover Buku --}}
                        <div class="aspect-[3/4] w-full rounded-xl overflow-hidden bg-slate-100 border border-slate-200/60 relative mb-3">
                            <img class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300"
                                src="{{ $buku->cover_buku ? asset('storage/' . $buku->cover_buku) : asset('icons/no-image.jpg') }}"
                                alt="{{ $buku->judul_buku ?? 'cover' }}">

                            {{-- Stock Badge Overlay --}}
                            <div class="absolute top-2 right-2">
                                @if($buku->stok_buku > 0)
                                    <span class="bg-white/95 backdrop-blur-md text-emerald-700 text-[10px] font-bold px-2 py-0.5 rounded-md shadow-xs border border-emerald-200">
                                        Stok: {{ $buku->stok_buku }}
                                    </span>
                                @else
                                    <span class="bg-white/95 backdrop-blur-md text-rose-600 text-[10px] font-bold px-2 py-0.5 rounded-md shadow-xs border border-rose-200">
                                        Kosong
                                    </span>
                                @endif
                            </div>
                        </div>

                        {{-- Metadata --}}
                        <span class="text-[10px] font-semibold text-blue-600 uppercase tracking-wider block mb-1">
                            {{ $buku->kategori ?? 'Umum' }}
                        </span>
                        <h3 class="font-bold text-slate-800 text-sm line-clamp-2 leading-snug group-hover:text-blue-600 transition-colors">
                            {{ $buku->judul_buku ?? 'Tanpa Judul' }}
                        </h3>
                        <p class="text-xs text-slate-400 mt-1 truncate">
                            {{ $buku->penulis ?? 'Anonim' }}
                        </p>
                    </a>

                    {{-- Action Card --}}
                    <div class="mt-3 pt-2.5 border-t border-slate-100 flex items-center justify-between">
                        <span class="text-[11px] text-slate-400 font-mono">{{ $buku->tahun_terbit ?? '-' }}</span>
                        <a href="/daftar-buku/detail-buku={{ $buku->id }}"
                           class="text-xs font-semibold text-blue-600 hover:text-blue-800 inline-flex items-center gap-1">
                            <span>Pinjam</span>
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                            </svg>
                        </a>
                    </div>
                </div>
            @empty
                <div class="col-span-full bg-white rounded-2xl border border-slate-200 p-16 text-center shadow-xs">
                    <div class="w-12 h-12 rounded-full bg-slate-100 text-slate-400 mx-auto flex items-center justify-center mb-3">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                        </svg>
                    </div>
                    <h3 class="text-sm font-bold text-slate-700">Buku tidak ditemukan</h3>
                    <p class="text-xs text-slate-400 mt-1 mb-4">Coba cari dengan kata kunci lain atau pilih kategori yang berbeda.</p>
                    <a href="/daftar-buku" class="px-4 py-2 bg-blue-600 text-white rounded-xl text-xs font-semibold shadow-xs">
                        Lihat Semua Koleksi
                    </a>
                </div>
            @endforelse
        </div>

        {{-- Pagination --}}
        @if ($Bukus->hasPages())
            <div class="mt-8 flex justify-center">
                {{ $Bukus->links() }}
            </div>
        @endif
    </section>
@endsection
