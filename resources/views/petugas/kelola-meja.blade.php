@extends('layouts.index')

@section('halaman', 'Kelola Meja Baca')

@section('main')
    @php
        $allBangkus = collect($mejas)->flatten();
        $totalBangku = $allBangkus->count();
        $totalTerisi = $allBangkus->where('status', 'terisi')->count();
        $totalKosong = $allBangkus->where('status', 'kosong')->count();
    @endphp

    {{-- Header & Stats Summary --}}
    <section class="mt-8 flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center font-bold">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                </svg>
            </div>
            <div>
                <h2 class="text-xl font-bold text-slate-800">Denah Meja Baca</h2>
                <p class="text-xs text-slate-500 mt-0.5">Perbarui status keterisian bangku saat patroli ruangan (rutin tiap 20-30 menit)</p>
            </div>
        </div>

        {{-- Stat Summary Pills --}}
        <div class="flex items-center gap-3">
            <div class="bg-white border border-slate-200 px-4 py-2 rounded-xl shadow-sm flex items-center gap-2.5">
                <span class="w-3 h-3 rounded-full bg-emerald-500"></span>
                <div>
                    <p class="text-[10px] text-slate-400 font-semibold uppercase">Kosong</p>
                    <p class="text-sm font-bold text-slate-800">{{ $totalKosong }} Bangku</p>
                </div>
            </div>
            <div class="bg-white border border-slate-200 px-4 py-2 rounded-xl shadow-sm flex items-center gap-2.5">
                <span class="w-3 h-3 rounded-full bg-rose-500"></span>
                <div>
                    <p class="text-[10px] text-slate-400 font-semibold uppercase">Terisi</p>
                    <p class="text-sm font-bold text-slate-800">{{ $totalTerisi }} Bangku</p>
                </div>
            </div>
        </div>
    </section>

    {{-- Grid Meja --}}
    <section class="mt-6">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach ($mejas as $kodeMeja => $bangkus)
                @php
                    $terisiCount = $bangkus->where('status', 'terisi')->count();
                    $kosongCount = $bangkus->where('status', 'kosong')->count();
                    $isFull = $terisiCount === 4;
                    $isEmpty = $kosongCount === 4;
                @endphp
                <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-5 hover:border-slate-300 transition-all">

                    {{-- Header Meja --}}
                    <div class="flex items-center justify-between mb-4 pb-3 border-b border-slate-100">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 bg-slate-900 text-white rounded-xl flex items-center justify-center font-bold text-sm shadow-sm">
                                {{ $kodeMeja }}
                            </div>
                            <div>
                                <h3 class="font-bold text-slate-800 text-sm">Meja {{ substr($kodeMeja, 1) }}</h3>
                                <p class="text-xs text-slate-400 font-medium">
                                    {{ $terisiCount }}/4 Terisi
                                </p>
                            </div>
                        </div>

                        {{-- Indicator Badge --}}
                        @if ($isEmpty)
                            <span class="text-xs bg-emerald-50 text-emerald-700 border border-emerald-200 font-semibold px-2.5 py-1 rounded-full">
                                Semua Kosong
                            </span>
                        @elseif ($isFull)
                            <span class="text-xs bg-rose-50 text-rose-700 border border-rose-200 font-semibold px-2.5 py-1 rounded-full">
                                Penuh
                            </span>
                        @else
                            <span class="text-xs bg-amber-50 text-amber-700 border border-amber-200 font-semibold px-2.5 py-1 rounded-full">
                                Sebagian
                            </span>
                        @endif
                    </div>

                    {{-- Grid 4 Bangku (2x2) --}}
                    <div class="grid grid-cols-2 gap-3">
                        @foreach ($bangkus as $bangku)
                            @php
                                $isTerisi = $bangku->status === 'terisi';
                            @endphp
                            <div class="rounded-xl border p-3 transition-all {{ $isTerisi ? 'bg-rose-50/60 border-rose-200' : 'bg-emerald-50/40 border-emerald-200' }}">

                                {{-- Label Bangku --}}
                                <div class="flex items-center justify-between mb-2">
                                    <span class="font-bold text-xs font-mono text-slate-700">
                                        {{ $kodeMeja }}-{{ $bangku->nomor_bangku }}
                                    </span>
                                    <span class="text-[10px] font-semibold px-2 py-0.5 rounded-full {{ $isTerisi ? 'bg-rose-100 text-rose-700' : 'bg-emerald-100 text-emerald-700' }}">
                                        {{ $isTerisi ? 'Terisi' : 'Kosong' }}
                                    </span>
                                </div>

                                {{-- Timestamp & User --}}
                                <div class="text-[10px] text-slate-400 mb-2.5">
                                    @if ($isTerisi && $bangku->user)
                                        <p class="font-semibold text-slate-700 truncate" title="{{ $bangku->user->Anggota->nama_lengkap ?? $bangku->user->username }}">
                                            👤 {{ $bangku->user->Anggota->nama_lengkap ?? $bangku->user->username }}
                                        </p>
                                    @endif
                                    <p class="text-[9px]">
                                        @if ($bangku->terakhir_diperbarui)
                                            {{ $bangku->terakhir_diperbarui->diffForHumans() }}
                                        @else
                                            Belum dicatat
                                        @endif
                                    </p>
                                </div>

                                {{-- Tombol Toggle --}}
                                <form action="/update-meja/{{ $bangku->id }}" method="POST">
                                    @csrf
                                    @if (!$isTerisi)
                                        <input type="hidden" name="status" value="terisi">
                                        <button type="submit"
                                            class="w-full text-xs font-semibold py-1.5 rounded-lg bg-rose-100 text-rose-700 hover:bg-rose-200 transition-colors cursor-pointer text-center">
                                            Tandai Terisi
                                        </button>
                                    @else
                                        <input type="hidden" name="status" value="kosong">
                                        <button type="submit"
                                            class="w-full text-xs font-semibold py-1.5 rounded-lg bg-emerald-100 text-emerald-700 hover:bg-emerald-200 transition-colors cursor-pointer text-center">
                                            Tandai Kosong
                                        </button>
                                    @endif
                                </form>
                            </div>
                        @endforeach
                    </div>

                    {{-- Footer: petugas terakhir update --}}
                    @if ($bangkus->whereNotNull('petugas_id')->isNotEmpty())
                        <div class="mt-3.5 pt-2.5 border-t border-slate-100 text-[11px] text-slate-400 flex justify-between items-center">
                            <span>Update:</span>
                            <span class="font-medium text-slate-600">{{ $bangkus->whereNotNull('petugas_id')->last()->petugas->nama_lengkap ?? $bangkus->whereNotNull('petugas_id')->last()->petugas->username ?? '-' }}</span>
                        </div>
                    @endif
                </div>
            @endforeach
        </div>
    </section>
@endsection
