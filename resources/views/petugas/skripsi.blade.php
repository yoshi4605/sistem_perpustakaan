@extends('layouts.index')

@section('halaman', 'Koleksi Skripsi & Tugas Akhir')

@section('main')
    {{-- Header & Search Bar --}}
    <section class="mt-8 flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center font-bold">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14zm-4 6v-7.5l4-2.222" />
                </svg>
            </div>
            <div>
                <h2 class="text-xl font-bold text-slate-800">Koleksi Skripsi & Tugas Akhir</h2>
                <p class="text-xs text-slate-500 mt-0.5">Repositori karya ilmiah, skripsi mahasiswa, dan nomor lokasi rak</p>
            </div>
        </div>

        {{-- Form Cari --}}
        <form action="/koleksi-skripsi" method="GET" class="flex items-center gap-2">
            <div class="relative w-full sm:w-80">
                <div class="absolute inset-y-0 left-3.5 flex items-center pointer-events-none text-slate-400">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </div>
                <input name="cari" type="text" placeholder="Cari judul, penulis, NPM..."
                    class="bg-white w-full pl-10 pr-4 py-2.5 rounded-xl placeholder:text-slate-400 border border-slate-200 text-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-100 transition-all outline-none"
                    value="{{ request('cari') }}">
            </div>
            <button type="submit"
                class="bg-blue-600 text-white px-5 py-2.5 rounded-xl hover:bg-blue-700 transition font-medium text-sm cursor-pointer shadow-sm flex items-center gap-1.5">
                <span>Cari</span>
            </button>
            @if(request('cari'))
                <a href="/koleksi-skripsi" class="bg-slate-100 hover:bg-slate-200 text-slate-600 px-3.5 py-2.5 rounded-xl text-sm transition font-medium">
                    Reset
                </a>
            @endif
        </form>
    </section>

    {{-- Daftar Koleksi Skripsi --}}
    <section class="mt-6 mb-12">
        <div class="space-y-4">
            @forelse($skripsis as $skripsi)
                <div class="bg-white p-5 rounded-2xl shadow-sm border border-slate-200 flex flex-col sm:flex-row items-start gap-4 hover:border-slate-300 transition-all">
                    @if($skripsi->gambar)
                        <div class="w-20 h-28 rounded-xl overflow-hidden border border-slate-200 flex-shrink-0 shadow-sm bg-slate-50">
                            <img src="{{ asset('storage/' . $skripsi->gambar) }}" class="w-full h-full object-cover" alt="{{ $skripsi->judul_skripsi }}">
                        </div>
                    @else
                        <div class="w-16 h-20 bg-blue-50 text-blue-600 border border-blue-200 flex items-center justify-center rounded-xl flex-shrink-0 shadow-sm">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14zm-4 6v-7.5l4-2.222" />
                            </svg>
                        </div>
                    @endif

                    <div class="flex-1 min-w-0">
                        <h3 class="text-base font-bold text-slate-800 leading-snug">
                            {{ $skripsi->judul_skripsi }}
                        </h3>
                        <p class="text-xs text-slate-500 mt-1">
                            <span class="font-semibold text-slate-700">{{ $skripsi->nama_penulis }}</span> • NPM: {{ $skripsi->npm }} • {{ $skripsi->program_studi }} (Lulus: {{ $skripsi->tahun_lulus }})
                        </p>
                        @if($skripsi->abstrak)
                            <p class="text-slate-600 text-xs mt-2 line-clamp-2 leading-relaxed">
                                {{ $skripsi->abstrak }}
                            </p>
                        @endif

                        <div class="flex flex-wrap items-center gap-2 mt-3.5">
                            @if($skripsi->nomor_rak && $skripsi->nomor_baris)
                                <span class="bg-blue-50 text-blue-700 border border-blue-200 text-xs px-3 py-1 rounded-lg font-medium inline-flex items-center gap-1.5">
                                    <svg class="w-3.5 h-3.5 text-blue-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                                    </svg>
                                    Lokasi Rak {{ $skripsi->nomor_rak }}, Baris {{ $skripsi->nomor_baris }}
                                </span>
                            @endif
                            @if($skripsi->is_cd_artikel)
                                <span class="bg-emerald-50 text-emerald-700 border border-emerald-200 text-xs px-3 py-1 rounded-lg font-medium inline-flex items-center gap-1.5">
                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                    Tersedia CD Artikel
                                </span>
                            @endif
                        </div>
                    </div>
                </div>
            @empty
                <div class="bg-white p-12 rounded-2xl shadow-sm text-center text-slate-400 border border-slate-200">
                    <p class="text-sm font-medium">Data skripsi tidak ditemukan.</p>
                </div>
            @endforelse
        </div>

        @if(method_exists($skripsis, 'links'))
            <div class="mt-6">
                {{ $skripsis->links() }}
            </div>
        @endif
    </section>
@endsection
