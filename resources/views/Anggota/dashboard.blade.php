@extends('layouts.index')

@section('halaman', 'Beranda')

@section('main')
    @php
        $namaUser = Auth::user()->Anggota->nama_lengkap ?? Auth::user()->username;
    @endphp

    {{-- HERO BANNER (PORTAL EXPERIENCE) --}}
    <section class="relative overflow-hidden rounded-3xl bg-gradient-to-br from-slate-900 via-indigo-950 to-blue-900 text-white p-6 sm:p-10 shadow-xl mb-10">
        {{-- Background Decorative Element --}}
        <div class="absolute -right-10 -bottom-10 w-72 h-72 bg-blue-500/10 rounded-full blur-3xl pointer-events-none"></div>
        <div class="absolute right-20 top-0 w-52 h-52 bg-indigo-500/10 rounded-full blur-2xl pointer-events-none"></div>

        <div class="relative z-10 max-w-3xl">
            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-white/10 backdrop-blur-md text-xs font-medium text-blue-200 mb-3 border border-white/10">
                <span class="w-2 h-2 rounded-full bg-emerald-400"></span>
                Selamat Datang di Portal Perpustakaan Digital
            </span>
            <h1 class="text-2xl sm:text-4xl font-extrabold tracking-tight text-white mb-2">
                Halo, {{ $namaUser }}! Mau baca apa hari ini?
            </h1>
            <p class="text-slate-300 text-xs sm:text-sm leading-relaxed mb-6 max-w-2xl">
                Temukan ribuan buku fisik, unduh e-book praktis, atau telusuri repositori skripsi untuk referensi belajarmu.
            </p>

            {{-- Instant Search Bar --}}
            <form action="/daftar-buku" method="GET" class="flex flex-col sm:flex-row items-center gap-2 bg-white/10 backdrop-blur-md p-1.5 rounded-2xl border border-white/20 shadow-inner max-w-xl">
                <div class="relative w-full flex items-center">
                    <svg class="w-5 h-5 text-slate-300 absolute left-3.5 pointer-events-none" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                    <input type="text" name="cari" placeholder="Cari judul buku, penulis, atau kata kunci..."
                        class="w-full bg-transparent text-white placeholder:text-slate-300 text-sm pl-11 pr-4 py-2.5 outline-none">
                </div>
                <button type="submit" class="w-full sm:w-auto px-6 py-2.5 bg-blue-600 hover:bg-blue-500 text-white rounded-xl text-xs font-semibold shadow-md transition cursor-pointer flex-shrink-0">
                    Cari Buku
                </button>
            </form>

            {{-- Quick Category Pills --}}
            <div class="flex flex-wrap items-center gap-2 mt-4 text-xs text-slate-300">
                <span class="text-slate-400">Paling dicari:</span>
                <a href="/daftar-buku?kategori=Teknologi%20%26%20Komputer" class="bg-white/10 hover:bg-white/20 px-2.5 py-1 rounded-lg text-slate-200 transition">Teknologi</a>
                <a href="/daftar-buku?kategori=Novel" class="bg-white/10 hover:bg-white/20 px-2.5 py-1 rounded-lg text-slate-200 transition">Novel</a>
                <a href="/daftar-buku?kategori=Ekonomi%20%26%20Bisnis" class="bg-white/10 hover:bg-white/20 px-2.5 py-1 rounded-lg text-slate-200 transition">Bisnis</a>
                <a href="/e-book" class="bg-white/10 hover:bg-white/20 px-2.5 py-1 rounded-lg text-slate-200 transition">E-Book PDF</a>
            </div>
        </div>
    </section>

    {{-- PROFILE NOTICE (IF INCOMPLETE) --}}
    @if ($Presentase < 100)
        <div class="bg-blue-50/80 border border-blue-200/80 rounded-2xl p-4 mb-8 flex flex-col sm:flex-row sm:items-center justify-between gap-3 shadow-xs">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-blue-100 text-blue-600 flex items-center justify-center flex-shrink-0 font-bold">
                    {{ $Presentase }}%
                </div>
                <div>
                    <h3 class="text-sm font-bold text-slate-800">Kelengkapan Profil Anggota</h3>
                    <p class="text-xs text-slate-500 mt-0.5">Lengkapi biodata dan nomor kontak agar peminjaman buku dapat segera disetujui petugas.</p>
                </div>
            </div>
            <a href="/profile-anggota" class="inline-flex items-center justify-center px-4 py-2 rounded-xl bg-blue-600 hover:bg-blue-700 text-white text-xs font-semibold shadow-xs transition">
                Lengkapi Profil
            </a>
        </div>
    @endif

    {{-- SECTION: SEDANG KAMU PINJAM (ACTIVE BOOKSHELF) --}}
    <section class="mb-10">
        <div class="flex items-center justify-between mb-4">
            <div>
                <h2 class="text-lg font-bold text-slate-800 flex items-center gap-2">
                    <span>Sedang Kamu Pinjam</span>
                    @if(count($Pinjaman_aktif) > 0)
                        <span class="bg-blue-100 text-blue-700 text-xs font-bold px-2.5 py-0.5 rounded-full">
                            {{ count($Pinjaman_aktif) }} Buku
                        </span>
                    @endif
                </h2>
                <p class="text-xs text-slate-400">Pantau batas waktu jatuh tempo pengembalian buku</p>
            </div>
            <a href="/riwayat-pinjaman" class="text-xs font-semibold text-blue-600 hover:text-blue-800 flex items-center gap-1 transition">
                <span>Semua Pinjaman</span>
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                </svg>
            </a>
        </div>

        @if(count($Pinjaman_aktif) > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                @foreach ($Pinjaman_aktif as $pinjaman)
                    <div class="bg-white rounded-2xl border border-slate-200/80 p-4 shadow-sm hover:border-slate-300 transition-all flex items-start gap-3.5">
                        <div class="w-16 h-22 rounded-xl overflow-hidden border border-slate-200 flex-shrink-0 bg-slate-50 shadow-xs">
                            <img src="{{ $pinjaman->buku->cover_buku ? asset('storage/' . $pinjaman->buku->cover_buku) : asset('icons/no-image.jpg') }}"
                                 alt="{{ $pinjaman->buku->judul_buku }}" class="w-full h-full object-cover">
                        </div>
                        <div class="flex-1 min-w-0">
                            <span class="inline-block font-mono text-[10px] font-bold text-blue-600 bg-blue-50 px-2 py-0.5 rounded mb-1">
                                {{ $pinjaman->buku->kode_buku ?? 'KODE-N/A' }}
                            </span>
                            <h3 class="font-bold text-slate-800 text-sm truncate" title="{{ $pinjaman->buku->judul_buku }}">
                                {{ $pinjaman->buku->judul_buku }}
                            </h3>
                            <p class="text-xs text-slate-400 truncate">{{ $pinjaman->buku->penulis ?? 'Penulis' }}</p>

                            <div class="mt-3 pt-2.5 border-t border-slate-100 flex items-center justify-between">
                                <div class="text-[11px]">
                                    <span class="text-slate-400 block text-[10px]">Jatuh Tempo:</span>
                                    <span class="font-semibold text-slate-700">
                                        {{ $pinjaman->tanggal_jatuh_tempo ? \Carbon\Carbon::parse($pinjaman->tanggal_jatuh_tempo)->translatedFormat('d M Y') : '-' }}
                                    </span>
                                </div>
                                <div>
                                    @if ($pinjaman->sisa_hari !== null)
                                        @if ($pinjaman->sisa_hari > 2)
                                            <span class="inline-flex items-center gap-1 text-[11px] font-bold text-emerald-700 bg-emerald-50 border border-emerald-200 px-2 py-0.5 rounded-full">
                                                {{ $pinjaman->sisa_hari }} hari lagi
                                            </span>
                                        @elseif ($pinjaman->sisa_hari >= 0)
                                            <span class="inline-flex items-center gap-1 text-[11px] font-bold text-amber-700 bg-amber-50 border border-amber-200 px-2 py-0.5 rounded-full">
                                                Hari ini!
                                            </span>
                                        @else
                                            <span class="inline-flex items-center gap-1 text-[11px] font-bold text-rose-700 bg-rose-50 border border-rose-200 px-2 py-0.5 rounded-full">
                                                Telat {{ abs($pinjaman->sisa_hari) }} hari
                                            </span>
                                        @endif
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="bg-white rounded-2xl border border-slate-200/80 p-8 text-center shadow-xs">
                <div class="w-12 h-12 rounded-full bg-slate-100 text-slate-400 mx-auto flex items-center justify-center mb-2">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                    </svg>
                </div>
                <h3 class="text-sm font-bold text-slate-700">Kamu sedang tidak meminjam buku</h3>
                <p class="text-xs text-slate-400 mt-0.5 mb-4">Yuk temukan bacaan menarik dari ribuan koleksi buku kami.</p>
                <a href="/daftar-buku" class="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl bg-blue-600 hover:bg-blue-700 text-white text-xs font-semibold shadow-sm transition">
                    <span>Jelajahi Katalog Buku</span>
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                    </svg>
                </a>
            </div>
        @endif
    </section>

    {{-- SECTION: SHORTCUT LAYANAN (PORTAL CARDS) --}}
    <section class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4 mb-10">
        {{-- Card 1: Katalog Buku --}}
        <a href="/daftar-buku" class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-xs hover:border-blue-300 hover:shadow-md transition-all group">
            <div class="w-10 h-10 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center mb-3 group-hover:scale-105 transition-transform">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                </svg>
            </div>
            <h3 class="font-bold text-slate-800 text-sm group-hover:text-blue-600 transition-colors">Katalog Buku Fisik</h3>
            <p class="text-xs text-slate-400 mt-0.5">Cari buku, cek ketersediaan stok, dan ajukan peminjaman secara online.</p>
        </a>

        {{-- Card 2: E-Book --}}
        <a href="/e-book" class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-xs hover:border-blue-300 hover:shadow-md transition-all group">
            <div class="w-10 h-10 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center mb-3 group-hover:scale-105 transition-transform">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                </svg>
            </div>
            <h3 class="font-bold text-slate-800 text-sm group-hover:text-indigo-600 transition-colors">Koleksi E-Book PDF</h3>
            <p class="text-xs text-slate-400 mt-0.5">Akses langsung dan unduh dokumen buku digital ke smartphone atau laptop.</p>
        </a>

        {{-- Card 3: Skripsi --}}
        <a href="/cari-skripsi" class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-xs hover:border-blue-300 hover:shadow-md transition-all group">
            <div class="w-10 h-10 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center mb-3 group-hover:scale-105 transition-transform">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14zm-4 6v-7.5l4-2.222" />
                </svg>
            </div>
            <h3 class="font-bold text-slate-800 text-sm group-hover:text-emerald-600 transition-colors">Repositori Skripsi</h3>
            <p class="text-xs text-slate-400 mt-0.5">Cari referensi tugas akhir, baca abstrak, dan cek nomor rak fisiknya.</p>
        </a>

        {{-- Card 4: Bangku Baca (KF-04) --}}
        <a href="/bangku-baca" class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-xs hover:border-blue-300 hover:shadow-md transition-all group">
            <div class="w-10 h-10 rounded-xl bg-sky-50 text-sky-600 flex items-center justify-center mb-3 group-hover:scale-105 transition-transform">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                </svg>
            </div>
            <h3 class="font-bold text-slate-800 text-sm group-hover:text-sky-600 transition-colors">Pilih Bangku Baca</h3>
            <p class="text-xs text-slate-400 mt-0.5">Cek ketersediaan meja baca dan amankan tempat duduk baca di perpustakaan.</p>
        </a>

        {{-- Card 5: Denda & Riwayat --}}
        <a href="/denda-anggota" class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-xs hover:border-blue-300 hover:shadow-md transition-all group">
            <div class="w-10 h-10 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center mb-3 group-hover:scale-105 transition-transform">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <h3 class="font-bold text-slate-800 text-sm group-hover:text-amber-600 transition-colors">Riwayat & Denda</h3>
            <p class="text-xs text-slate-400 mt-0.5">Cek seluruh riwayat buku yang telah kamu kembalikan dan bayar denda online.</p>
        </a>
    </section>

    {{-- SECTION: KOLEKSI BUKU TERBARU (VISUAL CARDS ALA E-COMMERCE / WEB BACA) --}}
    @if(isset($bukuRekomendasi) && count($bukuRekomendasi) > 0)
        <section class="mb-12">
            <div class="flex items-center justify-between mb-5">
                <div>
                    <h2 class="text-lg font-bold text-slate-800">Koleksi Buku Pilihan</h2>
                    <p class="text-xs text-slate-400">Buku-buku terbaru yang siap kamu pinjam hari ini</p>
                </div>
                <a href="/daftar-buku" class="text-xs font-semibold text-blue-600 hover:text-blue-800 flex items-center gap-1 transition">
                    <span>Lihat Semua Katalog</span>
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                    </svg>
                </a>
            </div>

            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-4 gap-5">
                @foreach ($bukuRekomendasi as $buku)
                    <div class="book-card bg-white rounded-2xl border border-slate-200/80 p-3 flex flex-col justify-between group shadow-xs">
                        <a href="/daftar-buku/detail-buku={{ $buku->id }}" class="block">
                            {{-- Cover Buku --}}
                            <div class="aspect-[3/4] w-full rounded-xl overflow-hidden bg-slate-100 border border-slate-200/60 relative mb-3">
                                <img src="{{ $buku->cover_buku ? asset('storage/' . $buku->cover_buku) : asset('icons/no-image.jpg') }}"
                                     alt="{{ $buku->judul_buku }}"
                                     class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                                
                                {{-- Stock Badge Overlay --}}
                                <div class="absolute top-2 right-2">
                                    @if($buku->stok_buku > 0)
                                        <span class="bg-white/90 backdrop-blur-md text-emerald-700 text-[10px] font-bold px-2 py-0.5 rounded-md shadow-xs border border-emerald-200">
                                            Tersedia
                                        </span>
                                    @else
                                        <span class="bg-white/90 backdrop-blur-md text-rose-600 text-[10px] font-bold px-2 py-0.5 rounded-md shadow-xs border border-rose-200">
                                            Habis
                                        </span>
                                    @endif
                                </div>
                            </div>

                            {{-- Kategori & Info --}}
                            <span class="text-[10px] font-semibold text-blue-600 uppercase tracking-wider block mb-1">
                                {{ $buku->kategori ?? 'Umum' }}
                            </span>
                            <h3 class="font-bold text-slate-800 text-sm line-clamp-2 leading-snug group-hover:text-blue-600 transition-colors">
                                {{ $buku->judul_buku }}
                            </h3>
                            <p class="text-xs text-slate-400 mt-1 truncate">
                                {{ $buku->penulis ?? 'Anonim' }}
                            </p>
                        </a>

                        {{-- Action Bottom --}}
                        <div class="mt-3 pt-2.5 border-t border-slate-100 flex items-center justify-between">
                            <span class="text-[11px] text-slate-400 font-mono">{{ $buku->tahun_terbit ?? '-' }}</span>
                            <a href="/daftar-buku/detail-buku={{ $buku->id }}"
                               class="text-xs font-semibold text-blue-600 hover:text-blue-800 inline-flex items-center gap-1">
                                <span>Detail</span>
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                                </svg>
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        </section>
    @endif
@endsection
