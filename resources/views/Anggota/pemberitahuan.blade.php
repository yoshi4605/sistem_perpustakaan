@extends('layouts.index')

@section('halaman', 'Pemberitahuan')

@section('main')
    {{-- Header Section --}}
    <section class="mb-6">
        @php
            $unreadCount = $pemberitahuans->where('sudah_dilihat', 0)->count();
        @endphp
        <div class="flex flex-col md:flex-row md:items-end justify-between gap-4">
            <div>
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-blue-50 text-blue-700 text-xs font-semibold mb-2">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                    </svg>
                    Pusat Informasi
                </div>
                <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">Pemberitahuan Masuk</h1>
                <p class="text-slate-500 text-xs sm:text-sm mt-1">Pemberitahuan resmi dari petugas perpustakaan seputar peminjaman, pengembalian, dan denda.</p>
            </div>
            <div class="flex items-center gap-2 self-start md:self-auto">
                <span class="text-xs text-slate-500 bg-white px-3.5 py-1.5 rounded-full border border-slate-200 shadow-2xs">
                    Total: <strong class="text-slate-800">{{ $pemberitahuans->count() }} Pesan</strong>
                </span>
                @if($unreadCount > 0)
                    <span class="text-xs font-semibold text-blue-700 bg-blue-50 px-3 py-1.5 rounded-full border border-blue-200/80 shadow-2xs">
                        {{ $unreadCount }} Belum Dibaca
                    </span>
                @endif
            </div>
        </div>
    </section>

    {{-- Notifications List --}}
    <section class="mb-12 max-w-4xl">
        <div class="space-y-3">
            @forelse ($pemberitahuans as $pemberitahuan)
                <div class="p-5 rounded-2xl border transition-all flex items-start gap-4 {{ $pemberitahuan->sudah_dilihat ? 'bg-white/80 border-slate-200/70 opacity-90' : 'bg-white border-blue-200 shadow-xs ring-1 ring-blue-100' }}">
                    
                    {{-- Icon indicator --}}
                    <div class="w-11 h-11 rounded-xl flex items-center justify-center flex-shrink-0 {{ $pemberitahuan->sudah_dilihat ? 'bg-slate-100 text-slate-400' : 'bg-blue-50 text-blue-600' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                    </div>

                    {{-- Message body --}}
                    <div class="flex-1 min-w-0">
                        <div class="flex flex-wrap items-center justify-between gap-2 mb-1.5">
                            <div class="flex items-center gap-2">
                                <span class="text-xs font-bold uppercase tracking-wider text-slate-800">Petugas Perpustakaan</span>
                                @if (!$pemberitahuan->sudah_dilihat)
                                    <span class="w-2 h-2 rounded-full bg-blue-600"></span>
                                    <span class="text-2xs font-bold text-blue-600 bg-blue-50 px-2 py-0.5 rounded-full border border-blue-100">Baru</span>
                                @else
                                    <span class="text-2xs text-slate-400">Sudah Dibaca</span>
                                @endif
                            </div>
                            <span class="text-xs text-slate-400">
                                {{ $pemberitahuan->created_at ? $pemberitahuan->created_at->diffForHumans() : '-' }}
                            </span>
                        </div>

                        <p class="text-xs sm:text-sm text-slate-700 leading-relaxed font-normal">
                            {{ Str::limit($pemberitahuan->pesan, 180) }}
                        </p>

                        <div class="mt-3 pt-3 border-t border-slate-100 flex items-center justify-between gap-3">
                            <span class="text-2xs text-slate-400">
                                {{ $pemberitahuan->created_at ? $pemberitahuan->created_at->translatedFormat('d F Y, H:i') : '' }}
                            </span>

                            <div class="flex items-center gap-2">
                                @if (!$pemberitahuan->sudah_dilihat)
                                    <form action="/pemberitahuan/read/{{ $pemberitahuan->id }}" method="POST" class="inline">
                                        @csrf
                                        <button type="submit" class="text-xs text-slate-500 hover:text-slate-800 font-medium px-2.5 py-1 rounded-lg hover:bg-slate-100 transition cursor-pointer">
                                            Tandai Dibaca
                                        </button>
                                    </form>
                                @endif
                                <a href="/pemberitahuan/detail/{{ $pemberitahuan->id }}" class="inline-flex items-center gap-1.5 text-xs font-semibold text-blue-600 hover:text-blue-700 bg-blue-50/70 hover:bg-blue-100/70 px-3 py-1.5 rounded-lg transition cursor-pointer">
                                    Baca Selengkapnya
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </div>

                </div>
            @empty
                <div class="bg-white rounded-2xl border border-slate-200/80 p-12 text-center shadow-xs">
                    <div class="w-16 h-16 mx-auto rounded-2xl bg-slate-100 flex items-center justify-center text-slate-400 mb-4">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                        </svg>
                    </div>
                    <h3 class="text-base font-bold text-slate-800">Tidak Ada Pemberitahuan</h3>
                    <p class="text-xs sm:text-sm text-slate-500 mt-1 max-w-sm mx-auto">
                        Kotak masuk Anda bersih! Semua pengumuman dan informasi peminjaman akan otomatis muncul di sini.
                    </p>
                </div>
            @endforelse
        </div>
    </section>
@endsection
