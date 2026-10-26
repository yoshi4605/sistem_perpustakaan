@extends('layouts.index')

@section('halaman', 'Bangku & Meja Baca')

@section('main')
    @php
        $allBangkus = collect($mejas)->flatten();
        $totalBangku = $allBangkus->count();
        $totalTerisi = $allBangkus->where('status', 'terisi')->count();
        $totalKosong = $allBangkus->where('status', 'kosong')->count();
    @endphp

    {{-- Header Section --}}
    <section class="mb-6">
        <div class="flex flex-col md:flex-row md:items-end justify-between gap-4">
            <div>
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-blue-50 text-blue-700 text-xs font-semibold mb-2">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                    </svg>
                    Layanan Baca di Tempat (KF-04)
                </div>
                <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">Ketersediaan & Pemilihan Bangku Baca</h1>
                <p class="text-slate-500 text-xs sm:text-sm mt-1">Pantau denah ruangan secara real-time dan pilih tempat duduk Anda untuk kenyamanan membaca di perpustakaan.</p>
            </div>

            {{-- Stat Pills --}}
            <div class="flex items-center gap-2.5 self-start md:self-auto">
                <div class="bg-white border border-slate-200 px-3.5 py-1.5 rounded-full shadow-2xs flex items-center gap-2">
                    <span class="w-2.5 h-2.5 rounded-full bg-emerald-500"></span>
                    <span class="text-xs text-slate-600 font-medium">Tersedia: <strong class="text-slate-800">{{ $totalKosong }}</strong></span>
                </div>
                <div class="bg-white border border-slate-200 px-3.5 py-1.5 rounded-full shadow-2xs flex items-center gap-2">
                    <span class="w-2.5 h-2.5 rounded-full bg-slate-400"></span>
                    <span class="text-xs text-slate-600 font-medium">Terisi: <strong class="text-slate-800">{{ $totalTerisi }}</strong></span>
                </div>
            </div>
        </div>
    </section>

    {{-- Banner Bangku Aktif Saya (Jika Ada) --}}
    @if ($myBangku)
        <section class="mb-8">
            <div class="p-5 rounded-2xl bg-gradient-to-r from-blue-600 to-indigo-600 text-white shadow-md flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 rounded-2xl bg-white/15 flex items-center justify-center flex-shrink-0">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                        </svg>
                    </div>
                    <div>
                        <div class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full bg-white/20 text-blue-100 text-2xs font-bold uppercase tracking-wider mb-1">
                            Sesi Membaca Aktif
                        </div>
                        <h3 class="text-lg font-bold text-white">
                            Anda Menempati Meja {{ $myBangku->kode_meja }} — Bangku #{{ $myBangku->nomor_bangku }}
                        </h3>
                        <p class="text-xs text-blue-100 mt-0.5">
                            Mulai menempati: {{ $myBangku->terakhir_diperbarui ? $myBangku->terakhir_diperbarui->format('H:i') : now()->format('H:i') }} WIB. Silakan nikmati bacaan Anda di tempat.
                        </p>
                    </div>
                </div>

                <form action="/bangku-baca/selesai/{{ $myBangku->id }}" method="POST" onsubmit="return confirm('Apakah Anda sudah selesai membaca dan ingin mengosongkan bangku ini kembali?')">
                    @csrf
                    <button type="submit" class="px-5 py-2.5 bg-white text-blue-700 hover:bg-blue-50 rounded-xl text-xs font-bold shadow-xs transition cursor-pointer flex items-center gap-1.5">
                        <svg class="w-4 h-4 text-rose-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                        </svg>
                        Selesai Membaca (Lepas Bangku)
                    </button>
                </form>
            </div>
        </section>
    @else
        <section class="mb-6">
            <div class="bg-blue-50/70 border border-blue-200/80 rounded-2xl p-4 flex items-start gap-3 shadow-2xs">
                <svg class="w-5 h-5 text-blue-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <div class="text-xs text-slate-700 leading-relaxed">
                    <span class="font-bold text-slate-900">Petunjuk Pemilihan Tempat:</span> Klik salah satu bangku bertanda <strong>Hijau (Tersedia)</strong> di denah bawah untuk memesan tempat duduk membaca. Setelah selesai membaca, Anda dapat menekan tombol <em>"Selesai Membaca"</em> agar bangku dapat digunakan pengunjung lain.
                </div>
            </div>
        </section>
    @endif

    {{-- Legenda Warna --}}
    <section class="mb-6">
        <div class="flex flex-wrap items-center gap-4 text-xs font-medium text-slate-600 bg-white p-3.5 rounded-xl border border-slate-200 shadow-2xs">
            <span class="font-semibold text-slate-800">Petunjuk Denah:</span>
            <div class="flex items-center gap-1.5">
                <span class="w-3.5 h-3.5 rounded-lg bg-emerald-500 border border-emerald-600"></span>
                <span>Kosong (Dapat Dipilih)</span>
            </div>
            <div class="flex items-center gap-1.5">
                <span class="w-3.5 h-3.5 rounded-lg bg-blue-600 ring-2 ring-blue-300"></span>
                <span>Bangku Anda</span>
            </div>
            <div class="flex items-center gap-1.5">
                <span class="w-3.5 h-3.5 rounded-lg bg-slate-300 border border-slate-400"></span>
                <span>Terisi oleh Pengguna Lain</span>
            </div>
        </div>
    </section>

    {{-- Grid Denah Meja --}}
    <section class="mb-14">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach ($mejas as $kodeMeja => $bangkus)
                @php
                    $terisiCount = $bangkus->where('status', 'terisi')->count();
                    $kosongCount = $bangkus->where('status', 'kosong')->count();
                @endphp
                <div class="bg-white rounded-2xl border border-slate-200/90 shadow-xs p-5 hover:border-slate-300 transition-all flex flex-col justify-between">
                    
                    {{-- Header Meja --}}
                    <div class="flex items-center justify-between pb-3 border-b border-slate-100 mb-4">
                        <div class="flex items-center gap-2.5">
                            <div class="w-8 h-8 rounded-xl bg-slate-100 flex items-center justify-center font-bold text-xs text-slate-700">
                                {{ $kodeMeja }}
                            </div>
                            <div>
                                <h3 class="text-sm font-bold text-slate-800">Meja Baca {{ $kodeMeja }}</h3>
                                <p class="text-2xs text-slate-400">Kapasitas 4 Pengunjung</p>
                            </div>
                        </div>

                        <div>
                            @if ($kosongCount === 0)
                                <span class="px-2.5 py-1 rounded-full text-2xs font-bold bg-rose-50 text-rose-600 border border-rose-200">
                                    Penuh
                                </span>
                            @else
                                <span class="px-2.5 py-1 rounded-full text-2xs font-bold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                    Sisa {{ $kosongCount }} Bangku
                                </span>
                            @endif
                        </div>
                    </div>

                    {{-- Visual Denah Bangku Meja (Layout 4 Kursi mengelilingi Meja) --}}
                    <div class="bg-slate-50/70 border border-slate-200/70 rounded-2xl p-4 my-2">
                        <div class="grid grid-cols-2 gap-3">
                            @foreach ($bangkus as $bangku)
                                @php
                                    $isMine = ($bangku->status === 'terisi' && $bangku->user_id === Auth::id());
                                    $isOccupied = ($bangku->status === 'terisi' && !$isMine);
                                    $isFree = ($bangku->status === 'kosong');
                                @endphp

                                <div class="relative">
                                    @if ($isFree)
                                        {{-- Tombol Pilih Bangku --}}
                                        <form action="/bangku-baca/pilih/{{ $bangku->id }}" method="POST">
                                            @csrf
                                            <button type="submit" 
                                                class="w-full p-3 rounded-xl border-2 border-dashed border-emerald-300 bg-emerald-50/80 hover:bg-emerald-100 hover:border-emerald-500 text-emerald-800 text-left transition-all group cursor-pointer flex flex-col justify-between h-20 shadow-2xs hover:scale-[1.02]">
                                                <div class="flex items-center justify-between w-full">
                                                    <span class="text-xs font-bold">#{{ $bangku->nomor_bangku }}</span>
                                                    <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                                                </div>
                                                <span class="text-2xs font-semibold text-emerald-700 group-hover:underline">
                                                    Pilih Bangku &rarr;
                                                </span>
                                            </button>
                                        </form>
                                    @elseif ($isMine)
                                        {{-- Bangku Milik Sendiri --}}
                                        <div class="w-full p-3 rounded-xl bg-blue-600 text-white flex flex-col justify-between h-20 shadow-sm ring-2 ring-blue-300">
                                            <div class="flex items-center justify-between w-full">
                                                <span class="text-xs font-bold">#{{ $bangku->nomor_bangku }}</span>
                                                <span class="text-2xs font-semibold bg-white/20 px-1.5 py-0.5 rounded">Aktif</span>
                                            </div>
                                            <span class="text-2xs font-bold">Bangku Anda</span>
                                        </div>
                                    @else
                                        {{-- Bangku Terisi Orang Lain --}}
                                        <div class="w-full p-3 rounded-xl bg-slate-100 border border-slate-200 text-slate-400 flex flex-col justify-between h-20 cursor-not-allowed">
                                            <div class="flex items-center justify-between w-full">
                                                <span class="text-xs font-semibold">#{{ $bangku->nomor_bangku }}</span>
                                                <span class="w-2 h-2 rounded-full bg-slate-300"></span>
                                            </div>
                                            <span class="text-2xs font-medium text-slate-400">Sedang Digunakan</span>
                                        </div>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    </div>

                    {{-- Footer Info --}}
                    <div class="mt-3 pt-2 text-2xs text-slate-400 text-center">
                        Area Ruang Baca Utama • Lantai 1
                    </div>

                </div>
            @endforeach
        </div>
    </section>
@endsection

