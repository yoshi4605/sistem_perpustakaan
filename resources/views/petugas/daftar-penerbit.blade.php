@extends('layouts.index')

@section('halaman', 'Daftar Penerbit & Rekanan')

@section('main')
    <section class="mt-8">

        {{-- Notice Banner --}}
        <div class="bg-blue-50 border border-blue-200 rounded-2xl p-4 mb-6 flex items-start gap-3">
            <div class="text-blue-600 flex-shrink-0 mt-0.5">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <div>
                <p class="text-slate-800 text-sm font-semibold">Direktori Mitra Penerbit</p>
                <p class="text-slate-600 text-xs mt-0.5">
                    Pustakawan dapat melihat informasi kontak penerbit dan daftar katalog bukunya. Penambahan atau pengeditan data mitra dikelola oleh Kepala Perpustakaan.
                </p>
            </div>
        </div>

        {{-- Cards Grid --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-12">
            @forelse ($penerbits as $penerbit)
                <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-5 flex flex-col justify-between hover:border-slate-300 transition-all">
                    <div>
                        <div class="flex items-start gap-3.5 mb-3">
                            @if (!empty($penerbit->logo))
                                <img src="{{ asset('storage/' . $penerbit->logo) }}" alt="{{ $penerbit->nama_penerbit }}"
                                    class="w-12 h-12 object-contain rounded-xl border border-slate-200 bg-white p-1 flex-shrink-0">
                            @else
                                <div class="w-12 h-12 bg-blue-50 text-blue-600 flex items-center justify-center rounded-xl flex-shrink-0 font-bold border border-blue-100">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                    </svg>
                                </div>
                            @endif

                            <div class="flex-1 min-w-0">
                                <a href="/petugas/daftar-penerbit/{{ $penerbit->id }}/detail" class="group">
                                    <h4 class="text-base font-bold text-slate-800 truncate group-hover:text-blue-600 transition">{{ $penerbit->nama_penerbit }}</h4>
                                </a>
                                <p class="text-xs text-slate-400 font-medium mt-0.5">{{ $penerbit->asal_negara_atau_kota ?? 'Nasional' }}</p>
                            </div>
                        </div>

                        <div class="space-y-1 text-xs text-slate-500 bg-slate-50 p-3 rounded-xl border border-slate-100">
                            <p class="truncate"><span class="text-slate-400">Email:</span> {{ $penerbit->email ?? '-' }}</p>
                            <p class="truncate"><span class="text-slate-400">Telp:</span> {{ $penerbit->telepon ?? '-' }}</p>
                        </div>
                    </div>

                    <div class="border-t border-slate-100 pt-3.5 mt-4 flex justify-between items-center text-xs">
                        <span class="text-slate-500 font-medium">Koleksi Buku:</span>
                        <a href="/petugas/daftar-penerbit/{{ $penerbit->id }}/detail" class="inline-flex items-center gap-1 font-bold text-blue-600 hover:text-blue-700 bg-blue-50 px-2.5 py-1 rounded-lg">
                            <span>{{ $penerbit->bukus_count ?? 0 }} Judul</span>
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                            </svg>
                        </a>
                    </div>
                </div>
            @empty
                <div class="col-span-1 md:col-span-2 lg:col-span-3 bg-white p-12 rounded-2xl text-center text-slate-400 border border-slate-200">
                    Tidak ada data penerbit yang ditemukan.
                </div>
            @endforelse
        </div>
    </section>
@endsection
