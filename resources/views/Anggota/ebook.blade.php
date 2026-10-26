@extends('layouts.index')

@section('halaman', 'Koleksi E-Book Digital')

@section('main')
    {{-- Header Section --}}
    <section class="mb-6">
        <div class="flex flex-col md:flex-row md:items-end justify-between gap-4">
            <div>
                <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">Koleksi E-Book Digital</h1>
                <p class="text-slate-500 text-xs sm:text-sm mt-1">Unduh dokumen e-book resmi perpustakaan dan baca di perangkatmu kapan saja.</p>
            </div>
            <div class="text-xs text-slate-500 bg-white px-3.5 py-1.5 rounded-full border border-slate-200 shadow-2xs self-start md:self-auto">
                Total Koleksi: <span class="font-bold text-slate-800">{{ $Ebooks->total() }} E-Book</span>
            </div>
        </div>

        {{-- Search & Filter Bar --}}
        <div class="bg-white rounded-2xl border border-slate-200/80 p-4 mt-6 shadow-xs">
            <form action="/e-book" method="GET" class="flex flex-col sm:flex-row items-center gap-3">
                <div class="relative w-full flex-1">
                    <svg class="w-4 h-4 text-slate-400 absolute left-3.5 top-1/2 -translate-y-1/2 pointer-events-none" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                    <input name="cari" type="text" placeholder="Cari judul e-book, topik, atau penulis..."
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
                        <a href="/e-book" class="px-3.5 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-600 rounded-xl text-xs font-semibold transition">
                            Reset
                        </a>
                    @endif
                </div>
            </form>
        </div>
    </section>

    {{-- Ebooks Grid --}}
    <section class="mb-12">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
            @forelse ($Ebooks as $ebook)
                <div class="book-card bg-white p-5 rounded-2xl border border-slate-200/80 shadow-xs flex flex-col justify-between hover:border-slate-300 transition-all">
                    <div class="flex items-start gap-4">
                        {{-- Icon PDF Document --}}
                        <div class="w-12 h-14 bg-gradient-to-br from-rose-500 to-rose-600 text-white rounded-xl flex flex-col items-center justify-center shrink-0 shadow-xs">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                            </svg>
                            <span class="text-[9px] font-bold tracking-wider uppercase mt-0.5">PDF</span>
                        </div>

                        <div class="flex-1 min-w-0">
                            <span class="inline-block text-[10px] font-semibold text-blue-600 uppercase tracking-wider mb-0.5">
                                {{ $ebook->kategori ?? 'Umum' }}
                            </span>
                            <h3 class="font-bold text-slate-800 text-sm line-clamp-2 leading-snug" title="{{ $ebook->judul_ebook ?? '' }}">
                                {{ $ebook->judul_ebook ?? 'Tanpa Judul' }}
                            </h3>
                            <p class="text-xs text-slate-400 mt-1 truncate">
                                {{ $ebook->penulis ?? 'Penulis Anonim' }} • {{ $ebook->tahun_terbit ?? '-' }}
                            </p>
                        </div>
                    </div>

                    {{-- Footer & Download CTA --}}
                    <div class="flex items-center justify-between border-t border-slate-100 pt-3.5 mt-4">
                        <div class="text-[11px] text-slate-400">
                            <span class="font-medium text-slate-600">{{ $ebook->ukuran_file ?? 'PDF' }}</span>
                            <span>&bull; {{ number_format($ebook->total_download ?? 0) }} unduhan</span>
                        </div>

                        <a href="{{ route('ebook.download', $ebook->id) }}"
                           class="inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-xl bg-blue-600 hover:bg-blue-700 text-white text-xs font-semibold shadow-xs transition">
                            <svg class="w-3.5 h-3.5 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                            </svg>
                            <span>Unduh</span>
                        </a>
                    </div>
                </div>
            @empty
                <div class="col-span-full bg-white rounded-2xl border border-slate-200 p-16 text-center shadow-xs">
                    <div class="w-12 h-12 rounded-full bg-slate-100 text-slate-400 mx-auto flex items-center justify-center mb-3">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                    </div>
                    <h3 class="text-sm font-bold text-slate-700">E-Book tidak ditemukan</h3>
                    <p class="text-xs text-slate-400 mt-1 mb-4">Coba cari dengan kata kunci lain atau reset filter kategori.</p>
                    <a href="/e-book" class="px-4 py-2 bg-blue-600 text-white rounded-xl text-xs font-semibold shadow-xs">
                        Lihat Semua E-Book
                    </a>
                </div>
            @endforelse
        </div>

        {{-- Pagination --}}
        @if ($Ebooks->hasPages())
            <div class="mt-8 flex justify-center">
                {{ $Ebooks->links() }}
            </div>
        @endif
    </section>
@endsection
