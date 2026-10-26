@extends('layouts.index')

@section('halaman', 'Koleksi Skripsi')

@section('main')
    {{-- Header Section --}}
    <section class="mb-6">
        <div class="flex flex-col md:flex-row md:items-end justify-between gap-4">
            <div>
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-indigo-50 text-indigo-700 text-xs font-semibold mb-2">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 14l9-5-9-5-9 5 9 5z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z" />
                    </svg>
                    Repositori Karya Ilmiah
                </div>
                <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">Katalog Skripsi & Tugas Akhir</h1>
                <p class="text-slate-500 text-xs sm:text-sm mt-1">Cari referensi skripsi mahasiswa. Abstrak dapat dibaca online, dokumen fisik lengkap berada pada rak perpustakaan.</p>
            </div>
            <div class="text-xs text-slate-500 bg-white px-3.5 py-1.5 rounded-full border border-slate-200 shadow-2xs self-start md:self-auto">
                Total Koleksi: <span class="font-bold text-slate-800">{{ $skripsis->total() }} Skripsi</span>
            </div>
        </div>

        {{-- Notice Banner --}}
        <div class="mt-4 p-4 rounded-2xl bg-amber-50/80 border border-amber-200/70 text-amber-900 text-xs sm:text-sm flex items-start gap-3">
            <svg class="w-5 h-5 text-amber-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <div class="leading-relaxed">
                <span class="font-bold">Informasi Akses Koleksi:</span> Sesuai ketentuan hak cipta akademik, hanya lembaran abstrak dan metadata yang ditampilkan secara daring. Untuk membaca naskah skripsi lengkap, catat <strong>Nomor Rak & Baris</strong> lalu kunjungi bagian koleksi khusus di perpustakaan.
            </div>
        </div>

        {{-- Search Bar --}}
        <div class="bg-white rounded-2xl border border-slate-200/80 p-4 mt-4 shadow-xs">
            <form action="/cari-skripsi" method="GET" class="flex flex-col sm:flex-row items-center gap-3">
                <div class="relative w-full flex-1">
                    <svg class="w-4 h-4 text-slate-400 absolute left-3.5 top-1/2 -translate-y-1/2 pointer-events-none" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                    <input name="cari" type="text" placeholder="Cari judul skripsi, nama penulis, atau NPM mahasiswa..."
                        class="w-full bg-slate-50 border border-slate-200 rounded-xl pl-10 pr-4 py-2.5 text-sm text-slate-800 placeholder:text-slate-400 focus:bg-white focus:border-blue-500 focus:ring-2 focus:ring-blue-100 transition outline-none"
                        value="{{ request('cari') }}">
                </div>

                <div class="w-full sm:w-auto flex items-center gap-2 flex-shrink-0">
                    <button type="submit" class="w-full sm:w-auto px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white rounded-xl text-xs font-semibold shadow-xs transition cursor-pointer">
                        Cari Skripsi
                    </button>

                    @if(request('cari'))
                        <a href="/cari-skripsi" class="px-3.5 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-600 rounded-xl text-xs font-semibold transition">
                            Reset
                        </a>
                    @endif
                </div>
            </form>
        </div>
    </section>

    {{-- Daftar Skripsi List --}}
    <section class="mb-12">
        <div class="space-y-5">
            @forelse($skripsis as $index => $skripsi)
                <div class="bg-white rounded-2xl border border-slate-200/80 p-5 sm:p-6 shadow-xs hover:border-slate-300 transition-all flex flex-col md:flex-row items-start gap-5">
                    
                    {{-- Cover / Icon --}}
                    @if($skripsi->gambar)
                        <div class="w-24 h-32 sm:w-28 sm:h-36 rounded-xl overflow-hidden border border-slate-200 shadow-2xs flex-shrink-0 bg-slate-100">
                            <img src="{{ asset('storage/' . $skripsi->gambar) }}" class="w-full h-full object-cover" alt="{{ $skripsi->judul_skripsi }}">
                        </div>
                    @else
                        <div class="w-16 h-16 sm:w-20 sm:h-20 rounded-2xl bg-gradient-to-br from-indigo-500 to-purple-600 text-white flex items-center justify-center flex-shrink-0 shadow-xs">
                            <svg class="w-8 h-8 text-white/90" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 14l9-5-9-5-9 5 9 5z" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 14v7" />
                            </svg>
                        </div>
                    @endif

                    {{-- Main Content --}}
                    <div class="flex-1 w-full min-w-0">
                        {{-- Meta Chips --}}
                        <div class="flex flex-wrap items-center gap-2 mb-2">
                            @if($skripsi->program_studi)
                                <span class="px-2.5 py-0.5 rounded-full text-xs font-semibold bg-indigo-50 text-indigo-700 border border-indigo-100">
                                    {{ $skripsi->program_studi }}
                                </span>
                            @endif

                            @if($skripsi->tahun_lulus)
                                <span class="px-2.5 py-0.5 rounded-full text-xs font-medium bg-slate-100 text-slate-700">
                                    Lulus {{ $skripsi->tahun_lulus }}
                                </span>
                            @endif

                            @if($skripsi->nomor_rak && $skripsi->nomor_baris)
                                <span class="px-2.5 py-0.5 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-700 border border-emerald-100 flex items-center gap-1">
                                    <svg class="w-3 h-3 text-emerald-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16m-7 6h7" />
                                    </svg>
                                    Rak: {{ $skripsi->nomor_rak }} • Baris: {{ $skripsi->nomor_baris }}
                                </span>
                            @endif

                            @if($skripsi->is_cd_artikel)
                                <span class="px-2.5 py-0.5 rounded-full text-xs font-medium bg-sky-50 text-sky-700 border border-sky-100">
                                    CD Tersedia
                                </span>
                            @endif
                        </div>

                        {{-- Title --}}
                        <h3 class="text-base sm:text-lg font-bold text-slate-900 leading-snug">
                            {{ $skripsi->judul_skripsi }}
                        </h3>

                        {{-- Author & NPM --}}
                        <div class="flex flex-wrap items-center gap-y-1 gap-x-4 text-xs sm:text-sm text-slate-500 mt-2">
                            <span class="inline-flex items-center gap-1.5 font-medium text-slate-700">
                                <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                                {{ $skripsi->nama_penulis }}
                            </span>
                            <span class="text-slate-300">•</span>
                            <span>NPM: <strong class="text-slate-700 font-semibold">{{ $skripsi->npm }}</strong></span>
                        </div>

                        {{-- Abstract Box with toggle --}}
                        <div class="bg-slate-50 border border-slate-200/70 rounded-xl p-4 mt-3">
                            <div class="flex items-center justify-between mb-1.5">
                                <span class="text-xs font-bold text-slate-700 uppercase tracking-wider">Abstrak Penelitian</span>
                                @if(strlen($skripsi->abstrak) > 250)
                                    <button type="button" onclick="toggleAbstrak({{ $index }})" id="btn-toggle-{{ $index }}"
                                        class="text-xs font-semibold text-blue-600 hover:text-blue-700 cursor-pointer">
                                        Lihat Selengkapnya
                                    </button>
                                @endif
                            </div>
                            <p id="abstrak-text-{{ $index }}" class="text-slate-600 text-xs sm:text-sm leading-relaxed {{ strlen($skripsi->abstrak) > 250 ? 'line-clamp-3' : '' }}">
                                {{ $skripsi->abstrak }}
                            </p>
                        </div>

                        {{-- Physical Shelf Instruction Footer --}}
                        <div class="mt-3 flex flex-wrap items-center justify-between gap-2 pt-2 border-t border-slate-100 text-xs text-slate-500">
                            <span class="inline-flex items-center gap-1">
                                <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                                Lokasi Fisik: <strong>Rak {{ $skripsi->nomor_rak ?? '-' }} (Baris {{ $skripsi->nomor_baris ?? '-' }})</strong>
                            </span>
                            <span class="text-slate-400 italic">Koleksi Referensi (Tidak untuk dibawa pulang)</span>
                        </div>
                    </div>

                </div>
            @empty
                <div class="bg-white rounded-2xl border border-slate-200/80 p-12 text-center shadow-xs">
                    <div class="w-16 h-16 mx-auto rounded-2xl bg-slate-100 flex items-center justify-center text-slate-400 mb-4">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 14l9-5-9-5-9 5 9 5z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z" />
                        </svg>
                    </div>
                    <h3 class="text-base font-bold text-slate-800">Skripsi Tidak Ditemukan</h3>
                    <p class="text-xs sm:text-sm text-slate-500 mt-1 max-w-sm mx-auto">
                        @if(request('cari'))
                            Tidak ada skripsi dengan kata kunci "<span class="font-semibold text-slate-700">{{ request('cari') }}</span>". Coba gunakan kata kunci judul atau nama lain.
                        @else
                            Belum ada arsip skripsi yang dipublikasikan dalam katalog saat ini.
                        @endif
                    </p>
                    @if(request('cari'))
                        <div class="mt-5">
                            <a href="/cari-skripsi" class="inline-flex items-center gap-2 px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-xl text-xs font-semibold transition">
                                Reset Pencarian
                            </a>
                        </div>
                    @endif
                </div>
            @endforelse
        </div>

        {{-- Pagination --}}
        @if(method_exists($skripsis, 'links'))
            <div class="mt-8 flex justify-center">
                {{ $skripsis->links() }}
            </div>
        @endif
    </section>
@endsection

@section('scripts')
<script>
    function toggleAbstrak(idx) {
        const p = document.getElementById('abstrak-text-' + idx);
        const btn = document.getElementById('btn-toggle-' + idx);
        if (!p || !btn) return;

        if (p.classList.contains('line-clamp-3')) {
            p.classList.remove('line-clamp-3');
            btn.textContent = 'Sembunyikan';
        } else {
            p.classList.add('line-clamp-3');
            btn.textContent = 'Lihat Selengkapnya';
        }
    }
</script>
@endsection
