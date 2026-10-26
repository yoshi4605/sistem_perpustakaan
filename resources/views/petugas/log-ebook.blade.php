@extends('layouts.index')

@section('halaman', 'Log Unduhan E-Book')

@section('main')
    {{-- Metric Cards (Clean, Simple, Professional) --}}
    <section class="grid grid-cols-1 md:grid-cols-3 gap-5 mt-8">
        {{-- Card 1: Total Unduhan --}}
        <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm flex items-center justify-between">
            <div>
                <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Total Unduhan E-Book</p>
                <p class="text-3xl font-extrabold text-slate-800 mt-1">{{ number_format($TotalDownload) }}</p>
                <p class="text-[11px] text-slate-400 mt-1">Akumulasi seluruh unduhan di sistem</p>
            </div>
            <div class="w-12 h-12 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                </svg>
            </div>
        </div>

        {{-- Card 2: Pengguna Unik --}}
        <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm flex items-center justify-between">
            <div>
                <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Pengguna Berbeda (Unik)</p>
                <p class="text-3xl font-extrabold text-slate-800 mt-1">{{ number_format($PenggunaUnik) }}</p>
                <p class="text-[11px] text-slate-400 mt-1">Jumlah anggota yang telah mengunduh</p>
            </div>
            <div class="w-12 h-12 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                </svg>
            </div>
        </div>

        {{-- Card 3: Hari Ini --}}
        <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm flex items-center justify-between">
            <div>
                <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Unduhan Hari Ini</p>
                <p class="text-3xl font-extrabold text-blue-600 mt-1">{{ number_format($HariIni) }}</p>
                <p class="text-[11px] text-slate-400 mt-1">Total berkas diunduh hari ini</p>
            </div>
            <div class="w-12 h-12 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
            </div>
        </div>
    </section>

    {{-- Table Section --}}
    <section class="mt-8 mb-16">
        <div class="bg-white w-full rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
            <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between bg-slate-50/60">
                <div class="flex items-center gap-2">
                    <span class="w-2.5 h-2.5 rounded-full bg-blue-500"></span>
                    <span class="text-sm font-semibold text-slate-700">Daftar Riwayat Unduhan Anggota</span>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm">
                    <thead>
                        <tr class="bg-slate-50/80 border-b border-slate-200 text-slate-500 text-xs uppercase tracking-wider font-semibold">
                            <th class="py-3.5 px-4 text-center w-12">No</th>
                            <th class="py-3.5 px-4">Nama Anggota</th>
                            <th class="py-3.5 px-4 text-center">NPM / NIDN</th>
                            <th class="py-3.5 px-4 text-center">Tipe</th>
                            <th class="py-3.5 px-4">Judul E-Book</th>
                            <th class="py-3.5 px-4 text-center">Tanggal & Jam</th>
                            <th class="py-3.5 px-4 text-right pr-6">Ukuran</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse ($LogEbooks as $index => $log)
                            <tr class="hover:bg-slate-50/80 transition-colors">
                                <td class="py-4 px-4 text-center text-slate-400 text-xs">
                                    {{ $LogEbooks->firstItem() + $index }}
                                </td>
                                <td class="py-4 px-4 font-semibold text-slate-800">
                                    {{ $log->user->name ?? 'User Tidak Diketahui' }}
                                </td>
                                <td class="py-4 px-4 text-center text-slate-500 font-mono text-xs">
                                    {{ $log->user->npm ?? '-' }}
                                </td>
                                <td class="py-4 px-4 text-center">
                                    @if(strtolower($log->user->role ?? '') === 'mahasiswa')
                                        <span class="bg-blue-50 text-blue-700 border border-blue-200 px-2.5 py-0.5 rounded-full text-xs font-medium">
                                            Mahasiswa
                                        </span>
                                    @else
                                        <span class="bg-indigo-50 text-indigo-700 border border-indigo-200 px-2.5 py-0.5 rounded-full text-xs font-medium">
                                            Dosen
                                        </span>
                                    @endif
                                </td>
                                <td class="py-4 px-4 font-medium text-slate-700 max-w-xs truncate" title="{{ $log->ebook->judul_ebook ?? '' }}">
                                    {{ $log->ebook->judul_ebook ?? 'E-Book Terhapus' }}
                                </td>
                                <td class="py-4 px-4 text-center text-xs text-slate-500 font-mono">
                                    {{ $log->created_at->translatedFormat('d M Y') }} • {{ $log->created_at->format('H:i') }}
                                </td>
                                <td class="py-4 px-4 text-right pr-6 font-semibold text-slate-600 text-xs font-mono">
                                    {{ $log->ebook->ukuran_file ?? '-' }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-12">
                                    <div class="flex flex-col items-center justify-center">
                                        <div class="w-12 h-12 rounded-full bg-slate-100 flex items-center justify-center text-slate-400 mb-2">
                                            <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                            </svg>
                                        </div>
                                        <p class="text-sm font-medium text-slate-700">Belum ada riwayat unduhan e-book.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($LogEbooks instanceof \Illuminate\Pagination\LengthAwarePaginator && $LogEbooks->hasPages())
                <div class="px-6 py-4 border-t border-slate-100 bg-slate-50/40">
                    {{ $LogEbooks->links() }}
                </div>
            @endif
        </div>
    </section>
@endsection
