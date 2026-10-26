@extends('layouts.index')
@section('halaman', 'Koleksi Skripsi & Tugas Akhir')
@section('main')
    <section class="mt-8 px-2 md:px-6">
        <div class="mb-6 flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <h2 class="text-2xl font-bold text-white tracking-tight">Koleksi Skripsi & Tugas Akhir</h2>
                <p class="text-slate-400 text-sm mt-0.5">Repositori tugas akhir, skripsi, dan artikel ilmiah mahasiswa</p>
            </div>
            <a href="/koleksi-skripsi/tambah" class="inline-flex items-center gap-2 bg-gradient-to-r from-cyan-600 to-cyan-500 hover:from-cyan-500 hover:to-cyan-400 text-white px-5 py-2.5 rounded-xl font-semibold text-sm shadow-lg shadow-cyan-950/40 transition-all cursor-pointer w-fit">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                </svg>
                <span>Input Skripsi</span>
            </a>
        </div>

        <form action="/koleksi-skripsi" method="GET" class="flex items-center gap-3 mb-8">
            <div class="relative w-full max-w-[450px]">
                <input name="cari" type="text" placeholder="Cari judul, penulis, NPM..." class="w-full bg-slate-900/60 border border-slate-700/80 rounded-xl px-4 py-2.5 text-white placeholder-slate-500 focus:outline-none focus:border-cyan-500 text-sm" value="{{ request('cari') }}">
            </div>
            <button type="submit" class="bg-cyan-600 hover:bg-cyan-500 text-white px-5 py-2.5 rounded-xl font-medium text-sm transition-all cursor-pointer">Cari</button>
            @if(request('cari'))
                <a href="/koleksi-skripsi" class="text-xs text-slate-400 hover:text-cyan-400 underline ml-2">Reset</a>
            @endif
        </form>

        <div class="space-y-4 mb-10">
            @forelse($skripsis as $skripsi)
                <div class="bg-slate-900/40 p-5 rounded-2xl shadow-xl border border-slate-700/60 hover:border-slate-600 transition-all flex flex-col md:flex-row items-start gap-4">
                    {{-- Cover / Foto Skripsi atau Icon Fallback --}}
                    @if($skripsi->gambar)
                        <div class="w-16 h-22 rounded-xl overflow-hidden border border-cyan-500/30 flex-shrink-0 shadow-md bg-slate-800">
                            <img src="{{ asset('storage/' . $skripsi->gambar) }}" class="w-full h-full object-cover" alt="{{ $skripsi->judul_skripsi }}">
                        </div>
                    @else
                        <div class="w-14 h-14 bg-gradient-to-tr from-cyan-500/20 to-violet-500/20 border border-cyan-500/30 text-cyan-400 flex items-center justify-center rounded-xl flex-shrink-0 shadow-md">
                            <img src="{{ asset('icons/svg/skripsi-aktif.svg') }}" class="w-7 h-7 object-contain" alt="Skripsi">
                        </div>
                    @endif

                    <div class="flex-1 min-w-0">
                        <h3 class="text-base md:text-lg font-bold text-white leading-snug">
                            {{ $skripsi->judul_skripsi }}
                        </h3>
                        <p class="text-xs md:text-sm text-slate-400 mt-1">
                            <span class="text-cyan-400 font-semibold">{{ $skripsi->nama_penulis }}</span> — NPM: <span class="text-slate-300 font-mono">{{ $skripsi->npm }}</span> — {{ $skripsi->program_studi }} ({{ $skripsi->tahun_lulus }})
                        </p>
                        <p class="text-slate-300 text-xs md:text-sm mt-2 line-clamp-2 leading-relaxed">
                            {{ $skripsi->abstrak }}
                        </p>

                        <div class="flex flex-wrap gap-2 mt-3.5">
                            @if($skripsi->nomor_rak && $skripsi->nomor_baris)
                                <span class="bg-cyan-500/10 text-cyan-400 border border-cyan-500/25 text-xs px-2.5 py-1 rounded-lg font-medium">
                                    Rak: {{ $skripsi->nomor_rak }} Baris {{ $skripsi->nomor_baris }}
                                </span>
                            @endif
                            @if($skripsi->is_cd_artikel)
                                <span class="bg-emerald-500/10 text-emerald-400 text-xs px-2.5 py-1 rounded-lg font-medium border border-emerald-500/25">
                                    ✓ Disertai CD Artikel
                                </span>
                            @endif
                            <span class="bg-violet-500/10 text-violet-300 text-xs px-2.5 py-1 rounded-lg font-medium border border-violet-500/25">
                                Sumbangan Mahasiswa
                            </span>
                        </div>
                    </div>

                    <div class="flex md:flex-col gap-2 md:ml-4 flex-shrink-0 w-full md:w-auto justify-end mt-2 md:mt-0">
                        <a href="/koleksi-skripsi/{{ $skripsi->id }}/edit"
                            class="inline-flex items-center justify-center gap-1.5 text-xs font-semibold text-amber-400 hover:text-amber-300 bg-amber-500/15 border border-amber-500/30 px-3.5 py-1.5 rounded-xl transition-all cursor-pointer hover:bg-amber-500/25">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                            </svg>
                            <span>Edit</span>
                        </a>
                        <form action="/koleksi-skripsi/{{ $skripsi->id }}" method="POST"
                            onsubmit="return confirm('Apakah Anda yakin ingin menghapus skripsi ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                class="w-full inline-flex items-center justify-center gap-1.5 text-xs font-semibold text-rose-400 hover:text-rose-300 bg-rose-500/15 border border-rose-500/30 px-3.5 py-1.5 rounded-xl transition-all cursor-pointer hover:bg-rose-500/25">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                                </svg>
                                <span>Hapus</span>
                            </button>
                        </form>
                    </div>
                </div>
            @empty
                <div class="bg-slate-900/40 p-12 rounded-2xl shadow-xl text-center text-slate-400 border border-slate-700/60">
                    Data skripsi tidak ditemukan.
                </div>
            @endforelse
        </div>

        @if(method_exists($skripsis, 'links'))
            <div class="mt-4">
                {{ $skripsis->links() }}
            </div>
        @endif
    </section>  
@endsection
