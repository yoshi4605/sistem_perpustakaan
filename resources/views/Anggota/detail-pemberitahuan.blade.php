@extends('layouts.index')

@section('halaman', 'Detail Pemberitahuan')

@section('main')
    {{-- Back Link --}}
    <div class="mb-5">
        <a href="/pemberitahuan" class="inline-flex items-center gap-2 text-xs sm:text-sm font-semibold text-slate-600 hover:text-slate-900 transition">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            Kembali ke Kotak Masuk
        </a>
    </div>

    {{-- Detail Card --}}
    <section class="max-w-3xl">
        <div class="bg-white rounded-2xl border border-slate-200/80 shadow-xs overflow-hidden">
            
            {{-- Card Header --}}
            <div class="p-6 sm:p-8 border-b border-slate-100 bg-gradient-to-r from-slate-50 to-white">
                <div class="flex flex-wrap items-center justify-between gap-3">
                    <div class="flex items-center gap-3">
                        <div class="w-12 h-12 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center flex-shrink-0">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <div>
                            <div class="flex items-center gap-2">
                                <h2 class="text-base sm:text-lg font-bold text-slate-900">Petugas Perpustakaan</h2>
                                @if (!$pemberitahuan->sudah_dilihat)
                                    <span class="text-2xs font-bold text-blue-600 bg-blue-50 px-2 py-0.5 rounded-full border border-blue-100">Baru</span>
                                @else
                                    <span class="text-2xs font-medium text-slate-500 bg-slate-100 px-2 py-0.5 rounded-full">Sudah Dibaca</span>
                                @endif
                            </div>
                            <p class="text-xs text-slate-400 mt-0.5">
                                {{ $pemberitahuan->created_at ? $pemberitahuan->created_at->translatedFormat('l, d F Y - H:i') : '' }} WIB
                            </p>
                        </div>
                    </div>

                    <div class="text-xs text-slate-500 bg-white px-3 py-1 rounded-lg border border-slate-200 shadow-2xs">
                        Pemberitahuan Sistem
                    </div>
                </div>
            </div>

            {{-- Letter Body --}}
            <div class="p-6 sm:p-8 space-y-6">
                <div>
                    <span class="text-xs font-semibold text-slate-400 uppercase tracking-wider block mb-1">Kepada Anggota</span>
                    <h3 class="text-base font-bold text-slate-900">
                        {{ Auth::user()->Anggota->nama_lengkap ?? Auth::user()->username }}
                        @if(Auth::user()->Anggota->nomer_induk ?? false)
                            <span class="text-xs font-normal text-slate-500">({{ Auth::user()->Anggota->nomer_induk }})</span>
                        @endif
                    </h3>
                </div>

                <div class="bg-slate-50 border border-slate-200/70 rounded-2xl p-5 sm:p-6 text-slate-800 text-sm sm:text-base leading-relaxed whitespace-pre-line">
                    {!! nl2br(e($pemberitahuan->pesan)) !!}
                </div>

                <div class="pt-4 border-t border-slate-100 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                    <div class="text-xs text-slate-500">
                        Salam hangat,<br>
                        <strong class="text-slate-800 font-semibold">Tim Pengelola & Petugas Perpustakaan</strong>
                    </div>

                    <div class="flex items-center gap-3 self-end sm:self-auto">
                        <a href="/pemberitahuan" class="px-4 py-2 border border-slate-200 hover:bg-slate-50 text-slate-700 rounded-xl text-xs font-semibold transition cursor-pointer">
                            Kembali
                        </a>

                        @if (!$pemberitahuan->sudah_dilihat)
                            <form action="/pemberitahuan/read/{{ $pemberitahuan->id }}" method="POST">
                                @csrf
                                <button type="submit" class="px-5 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-xl text-xs font-semibold shadow-xs transition cursor-pointer">
                                    Tandai Sudah Dibaca
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>

        </div>
    </section>
@endsection
