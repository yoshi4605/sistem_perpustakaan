@extends('layouts.index')

@section('halaman', 'Input E-Book')
@section('suffix', 'Admin!')

@section('main')
    {{-- 3 Executive KPI Metric Cards (Refined & Proportional) --}}
    <section class="grid grid-cols-1 md:grid-cols-3 gap-5 mt-6 mb-8">
        {{-- Card 1: Total E-Book --}}
        <div class="relative overflow-hidden rounded-2xl p-5 border border-slate-700/60 bg-gradient-to-br from-slate-900/90 via-slate-900/70 to-cyan-950/30 backdrop-blur-md shadow-xl hover:border-cyan-500/40 transition-all duration-300 group">
            <div class="absolute -right-6 -bottom-6 w-24 h-24 bg-cyan-500/10 rounded-full blur-2xl pointer-events-none group-hover:bg-cyan-500/20 transition-all"></div>
            <div class="flex items-start justify-between">
                <div>
                    <span class="text-xs uppercase tracking-wider font-semibold text-slate-400 block mb-1">Total Koleksi E-Book</span>
                    <h3 class="text-3xl font-extrabold text-white tracking-tight">{{ number_format($TotalEbook ?? 0) }}</h3>
                    <div class="flex items-center gap-1.5 mt-2.5">
                        <span class="inline-flex items-center text-[11px] font-semibold text-emerald-400 bg-emerald-500/10 px-2 py-0.5 rounded-full border border-emerald-500/20">
                            ● Dokumen Aktif
                        </span>
                        <span class="text-[11px] text-slate-400">PDF & EPUB Digital</span>
                    </div>
                </div>
                <div class="w-12 h-12 rounded-xl bg-gradient-to-tr from-cyan-500/20 to-blue-500/20 border border-cyan-500/30 flex items-center justify-center text-cyan-400 shadow-lg shadow-cyan-500/10 flex-shrink-0">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25" />
                    </svg>
                </div>
            </div>
        </div>

        {{-- Card 2: Total Downloads --}}
        <div class="relative overflow-hidden rounded-2xl p-5 border border-slate-700/60 bg-gradient-to-br from-slate-900/90 via-slate-900/70 to-violet-950/30 backdrop-blur-md shadow-xl hover:border-violet-500/40 transition-all duration-300 group">
            <div class="absolute -right-6 -bottom-6 w-24 h-24 bg-violet-500/10 rounded-full blur-2xl pointer-events-none group-hover:bg-violet-500/20 transition-all"></div>
            <div class="flex items-start justify-between">
                <div>
                    <span class="text-xs uppercase tracking-wider font-semibold text-slate-400 block mb-1">Total Unduhan</span>
                    <h3 class="text-3xl font-extrabold text-white tracking-tight">{{ number_format($TotalDownloads ?? 0) }}</h3>
                    <div class="flex items-center gap-1.5 mt-2.5">
                        <span class="inline-flex items-center text-[11px] font-semibold text-violet-300 bg-violet-500/15 px-2 py-0.5 rounded-full border border-violet-500/30">
                            ↑ Akumulasi
                        </span>
                        <span class="text-[11px] text-slate-400">Seluruh Anggota</span>
                    </div>
                </div>
                <div class="w-12 h-12 rounded-xl bg-gradient-to-tr from-violet-500/20 to-purple-500/20 border border-violet-500/30 flex items-center justify-center text-violet-400 shadow-lg shadow-violet-500/10 flex-shrink-0">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3" />
                    </svg>
                </div>
            </div>
        </div>

        {{-- Card 3: Limit Kapasitas File --}}
        <div class="relative overflow-hidden rounded-2xl p-5 border border-slate-700/60 bg-gradient-to-br from-slate-900/90 via-slate-900/70 to-emerald-950/30 backdrop-blur-md shadow-xl hover:border-emerald-500/40 transition-all duration-300 group">
            <div class="absolute -right-6 -bottom-6 w-24 h-24 bg-emerald-500/10 rounded-full blur-2xl pointer-events-none group-hover:bg-emerald-500/20 transition-all"></div>
            <div class="flex items-start justify-between">
                <div>
                    <span class="text-xs uppercase tracking-wider font-semibold text-slate-400 block mb-1">Limit Kapasitas File</span>
                    <h3 class="text-3xl font-extrabold text-white tracking-tight">50 MB</h3>
                    <div class="flex items-center gap-1.5 mt-2.5">
                        <span class="inline-flex items-center text-[11px] font-semibold text-amber-300 bg-amber-500/15 px-2 py-0.5 rounded-full border border-amber-500/30">
                            Maksimal / Dokumen
                        </span>
                        <span class="text-[11px] text-slate-400">Optimal Server</span>
                    </div>
                </div>
                <div class="w-12 h-12 rounded-xl bg-gradient-to-tr from-emerald-500/20 to-teal-500/20 border border-emerald-500/30 flex items-center justify-center text-emerald-400 shadow-lg shadow-emerald-500/10 flex-shrink-0">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 6.375c0 2.278-3.694 4.125-8.25 4.125S3.75 8.653 3.75 6.375m16.5 0c0-2.278-3.694-4.125-8.25-4.125S3.75 4.097 3.75 6.375m16.5 0v11.25c0 2.278-3.694 4.125-8.25 4.125s-8.25-1.847-8.25-4.125V6.375m16.5 5.625c0 2.278-3.694 4.125-8.25 4.125s-8.25-1.847-8.25-4.125" />
                    </svg>
                </div>
            </div>
        </div>
    </section>

    {{-- Table Section --}}
    <section class="mb-20">
        <div class="flex justify-between items-center mb-5">
            <div>
                <h2 class="text-xl font-bold text-white tracking-tight">
                    Kelola Koleksi E-Book
                </h2>
                <p class="text-xs text-slate-400 mt-0.5">Daftar buku digital yang dapat diunduh oleh anggota perpustakaan</p>
            </div>
            <a href="/tambah-ebook" class="bg-gradient-to-r from-cyan-600 to-cyan-500 hover:from-cyan-500 hover:to-cyan-400 text-white px-5 py-2.5 rounded-xl font-semibold text-sm transition-all shadow-lg shadow-cyan-900/30 flex items-center gap-2 border border-cyan-400/30 cursor-pointer">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                </svg>
                <span>Upload E-Book</span>
            </a>
        </div>

        <div class="bg-white w-full rounded-2xl p-6 shadow-xl border border-slate-700/60 overflow-x-auto">
            <table class="w-full border-collapse min-w-[800px]">
                <thead>
                    <tr class="text-left border-b border-gray-100 text-sm">
                        <th class="py-3.5 px-4 text-slate-300 font-semibold uppercase text-xs">Judul</th>
                        <th class="py-3.5 px-4 text-slate-300 font-semibold uppercase text-xs">Pengarang</th>
                        <th class="py-3.5 px-4 text-slate-300 font-semibold uppercase text-xs">Kategori</th>
                        <th class="py-3.5 px-4 text-slate-300 font-semibold uppercase text-xs">Tahun</th>
                        <th class="py-3.5 px-4 text-slate-300 font-semibold uppercase text-xs">Ukuran</th>
                        <th class="py-3.5 px-4 text-slate-300 font-semibold uppercase text-xs text-center">Downloads</th>
                        <th class="py-3.5 px-4 text-slate-300 font-semibold uppercase text-xs">Diupload</th>
                        <th class="py-3.5 px-4 text-slate-300 font-semibold uppercase text-xs text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="text-[#35094D] text-[15px]">
                    @forelse ($Ebooks as $ebook)
                        <tr class="border-b border-slate-700/40 hover:bg-slate-800/40 transition-colors">
                            <td class="py-4 px-4 font-bold text-white">{{ $ebook->judul_ebook }}</td>
                            <td class="py-4 px-4 text-slate-300">{{ $ebook->penulis }}</td>
                            <td class="py-4 px-4">
                                <span class="bg-cyan-500/15 text-cyan-300 px-3 py-1 rounded-lg text-xs font-semibold border border-cyan-500/30">
                                    {{ $ebook->kategori }}
                                </span>
                            </td>
                            <td class="py-4 px-4 text-slate-300">{{ $ebook->tahun_terbit }}</td>
                            <td class="py-4 px-4 text-slate-300">{{ $ebook->ukuran_file }}</td>
                            <td class="py-4 px-4 text-center font-bold text-cyan-400">{{ number_format($ebook->total_download) }}</td>
                            <td class="py-4 px-4 text-slate-400 font-medium">Admin</td>
                            <td class="py-4 px-4">
                                <div class="flex justify-center items-center gap-2">
                                    {{-- Tombol Edit E-Book (SVG Lokal / In-line) --}}
                                    <a href="/edit-ebook/{{ $ebook->id }}"
                                        title="Edit E-Book"
                                        class="w-8 h-8 rounded-lg flex items-center justify-center bg-amber-500/15 text-amber-400 border border-amber-500/30 hover:bg-amber-500/30 hover:scale-105 transition-all cursor-pointer">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                                        </svg>
                                    </a>

                                    {{-- Tombol Hapus E-Book (SVG Lokal / In-line) --}}
                                    <form action="/hapus-ebook/{{ $ebook->id }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus e-book ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            title="Hapus E-Book"
                                            class="w-8 h-8 rounded-lg flex items-center justify-center bg-rose-500/15 text-rose-400 border border-rose-500/30 hover:bg-rose-500/30 hover:scale-105 transition-all cursor-pointer">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center py-12 text-slate-400 italic">
                                Tidak ada data e-book yang ditemukan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            @if ($Ebooks->hasPages())
                <div class="mt-6 flex justify-end">
                    {{ $Ebooks->links() }}
                </div>
            @endif
        </div>
    </section>
@endsection