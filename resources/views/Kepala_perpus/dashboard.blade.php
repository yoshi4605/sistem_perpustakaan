@extends('layouts.index')

@section('halaman', 'Dashboard')
@section('suffix', 'Anda!')

@section('main')

    {{-- â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â• --}}
    {{--  KPI METRIC STRIP â€” 5 Compact Cards                  --}}
    {{-- â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â• --}}
    <section class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-4 mt-8">

        {{-- KPI 1: Total Anggota --}}
        <div class="group relative overflow-hidden rounded-2xl bg-[#0f172a]/50 backdrop-blur-lg border border-slate-700/25 p-5 transition-all duration-300 hover:bg-slate-800/60 hover:border-cyan-500/20 hover:shadow-[0_0_30px_rgba(6,182,212,0.08)] hover:-translate-y-0.5">
            {{-- Top accent glow --}}
            <div class="absolute top-0 left-0 right-0 h-[2px] bg-gradient-to-r from-transparent via-cyan-500/60 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
            <div class="flex items-center gap-3">
                <div class="w-11 h-11 rounded-xl bg-cyan-500/10 flex items-center justify-center text-cyan-400 flex-shrink-0">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z"/></svg>
                </div>
                <div>
                    <p class="text-[11px] font-semibold uppercase tracking-wider text-slate-400">Total Anggota</p>
                    <p class="text-2xl font-bold text-slate-100 mt-0.5" style="font-family: 'Courier New', monospace;">{{ number_format($Jumlah_Anggota) }}</p>
                </div>
            </div>
        </div>

        {{-- KPI 2: Total Petugas --}}
        <div class="group relative overflow-hidden rounded-2xl bg-[#0f172a]/50 backdrop-blur-lg border border-slate-700/25 p-5 transition-all duration-300 hover:bg-slate-800/60 hover:border-violet-500/20 hover:shadow-[0_0_30px_rgba(139,92,246,0.08)] hover:-translate-y-0.5">
            <div class="absolute top-0 left-0 right-0 h-[2px] bg-gradient-to-r from-transparent via-violet-500/60 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
            <div class="flex items-center gap-3">
                <div class="w-11 h-11 rounded-xl bg-violet-500/10 flex items-center justify-center text-violet-400 flex-shrink-0">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z"/></svg>
                </div>
                <div>
                    <p class="text-[11px] font-semibold uppercase tracking-wider text-slate-400">Petugas Aktif</p>
                    <p class="text-2xl font-bold text-slate-100 mt-0.5" style="font-family: 'Courier New', monospace;">{{ number_format($Jumlah_Petugas) }}</p>
                </div>
            </div>
        </div>

        {{-- KPI 3: Total Buku --}}
        <div class="group relative overflow-hidden rounded-2xl bg-[#0f172a]/50 backdrop-blur-lg border border-slate-700/25 p-5 transition-all duration-300 hover:bg-slate-800/60 hover:border-emerald-500/20 hover:shadow-[0_0_30px_rgba(16,185,129,0.08)] hover:-translate-y-0.5">
            <div class="absolute top-0 left-0 right-0 h-[2px] bg-gradient-to-r from-transparent via-emerald-500/60 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
            <div class="flex items-center gap-3">
                <div class="w-11 h-11 rounded-xl bg-emerald-500/10 flex items-center justify-center text-emerald-400 flex-shrink-0">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25"/></svg>
                </div>
                <div>
                    <p class="text-[11px] font-semibold uppercase tracking-wider text-slate-400">Koleksi Buku</p>
                    <p class="text-2xl font-bold text-slate-100 mt-0.5" style="font-family: 'Courier New', monospace;">{{ number_format($jumlah_buku) }}</p>
                </div>
            </div>
        </div>

        {{-- KPI 4: Peminjaman --}}
        <div class="group relative overflow-hidden rounded-2xl bg-[#0f172a]/50 backdrop-blur-lg border border-slate-700/25 p-5 transition-all duration-300 hover:bg-slate-800/60 hover:border-amber-500/20 hover:shadow-[0_0_30px_rgba(245,158,11,0.08)] hover:-translate-y-0.5">
            <div class="absolute top-0 left-0 right-0 h-[2px] bg-gradient-to-r from-transparent via-amber-500/60 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
            <div class="flex items-center gap-3">
                <div class="w-11 h-11 rounded-xl bg-amber-500/10 flex items-center justify-center text-amber-400 flex-shrink-0">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5m-13.5-9L12 3m0 0l4.5 4.5M12 3v13.5"/></svg>
                </div>
                <div>
                    <p class="text-[11px] font-semibold uppercase tracking-wider text-slate-400">Peminjaman</p>
                    <p class="text-2xl font-bold text-slate-100 mt-0.5" style="font-family: 'Courier New', monospace;">{{ number_format($jumlah_peminjaman) }}</p>
                </div>
            </div>
        </div>

        {{-- KPI 5: Pengembalian --}}
        <div class="group relative overflow-hidden rounded-2xl bg-[#0f172a]/50 backdrop-blur-lg border border-slate-700/25 p-5 transition-all duration-300 hover:bg-slate-800/60 hover:border-rose-500/20 hover:shadow-[0_0_30px_rgba(244,63,94,0.08)] hover:-translate-y-0.5">
            <div class="absolute top-0 left-0 right-0 h-[2px] bg-gradient-to-r from-transparent via-rose-500/60 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
            <div class="flex items-center gap-3">
                <div class="w-11 h-11 rounded-xl bg-rose-500/10 flex items-center justify-center text-rose-400 flex-shrink-0">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12M12 16.5V3"/></svg>
                </div>
                <div>
                    <p class="text-[11px] font-semibold uppercase tracking-wider text-slate-400">Pengembalian</p>
                    <p class="text-2xl font-bold text-slate-100 mt-0.5" style="font-family: 'Courier New', monospace;">{{ number_format($jumlah_pengembalian) }}</p>
                </div>
            </div>
        </div>

    </section>

    {{-- â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â• --}}
    {{--  CHART ROW 1: Spline Area (8 col) + Doughnut (4 col) --}}
    {{-- â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â• --}}
    <section class="grid grid-cols-12 gap-6 mt-6">

        {{-- Primary Chart: Tren Peminjaman & Pengembalian --}}
        <div class="col-span-12 lg:col-span-8 relative overflow-hidden rounded-2xl bg-[#0f172a]/55 backdrop-blur-xl border border-slate-700/20 shadow-[0_0_40px_rgba(6,182,212,0.04)] p-6 transition-all duration-500 hover:shadow-[0_0_60px_rgba(6,182,212,0.08)] hover:border-slate-600/30">
            {{-- Ambient Glow --}}
            <div class="absolute -top-24 -right-24 w-48 h-48 bg-cyan-500/8 rounded-full blur-3xl pointer-events-none"></div>

            <div class="flex items-center justify-between mb-5 relative z-10">
                <div>
                    <h3 class="text-[17px] font-bold text-slate-100">Tren Peminjaman & Pengembalian</h3>
                    <p class="text-sm text-slate-500 mt-1">6 bulan terakhir</p>
                </div>
            </div>
            <div id="trendChart" class="w-full" style="min-height: 300px;"></div>
        </div>

        {{-- Secondary Chart: Doughnut Status Buku --}}
        <div class="col-span-12 lg:col-span-4 relative overflow-hidden rounded-2xl bg-[#0f172a]/55 backdrop-blur-xl border border-slate-700/20 shadow-[0_0_40px_rgba(139,92,246,0.04)] p-6 transition-all duration-500 hover:shadow-[0_0_60px_rgba(139,92,246,0.08)] hover:border-slate-600/30">
            <div class="absolute -bottom-16 -left-16 w-40 h-40 bg-violet-500/8 rounded-full blur-3xl pointer-events-none"></div>

            <div class="mb-4 relative z-10">
                <h3 class="text-[17px] font-bold text-slate-100">Status Koleksi</h3>
                <p class="text-sm text-slate-500 mt-1">Distribusi ketersediaan buku</p>
            </div>
            <div id="doughnutChart" class="w-full" style="min-height: 260px;"></div>

            {{-- Custom Legend --}}
            <div class="grid grid-cols-3 gap-3 mt-4 relative z-10">
                <div class="flex items-center gap-2">
                    <div class="w-2.5 h-2.5 rounded-full bg-emerald-500 flex-shrink-0"></div>
                    <span class="text-xs text-slate-400">Tersedia</span>
                </div>
                <div class="flex items-center gap-2">
                    <div class="w-2.5 h-2.5 rounded-full bg-cyan-500 flex-shrink-0"></div>
                    <span class="text-xs text-slate-400">Dipinjam</span>
                </div>
                <div class="flex items-center gap-2">
                    <div class="w-2.5 h-2.5 rounded-full bg-amber-500 flex-shrink-0"></div>
                    <span class="text-xs text-slate-400">Terlambat</span>
                </div>
            </div>
        </div>

    </section>

    {{-- â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â• --}}
    {{--  CHART ROW 2: Bar Chart (5 col) + Activity (7 col)   --}}
    {{-- â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â• --}}
    <section class="grid grid-cols-12 gap-6 mt-6 mb-10">

        {{-- Tertiary Chart: Kategori Populer --}}
        <div class="col-span-12 lg:col-span-5 relative overflow-hidden rounded-2xl bg-[#0f172a]/55 backdrop-blur-xl border border-slate-700/20 shadow-[0_0_40px_rgba(16,185,129,0.04)] p-6 transition-all duration-500 hover:shadow-[0_0_60px_rgba(16,185,129,0.08)] hover:border-slate-600/30">
            <div class="absolute -top-16 -left-16 w-40 h-40 bg-emerald-500/6 rounded-full blur-3xl pointer-events-none"></div>

            <div class="mb-5 relative z-10">
                <h3 class="text-[17px] font-bold text-slate-100">Kategori Terpopuler</h3>
                <p class="text-sm text-slate-500 mt-1">Top 5 berdasarkan peminjaman</p>
            </div>
            <div id="barChart" class="w-full" style="min-height: 280px;"></div>
        </div>

        {{-- Activity Table: Aktivitas Terbaru --}}
        <div class="col-span-12 lg:col-span-7 relative overflow-hidden rounded-2xl bg-[#0f172a]/55 backdrop-blur-xl border border-slate-700/20 shadow-[0_0_40px_rgba(6,182,212,0.04)] p-6 transition-all duration-500 hover:shadow-[0_0_60px_rgba(6,182,212,0.08)] hover:border-slate-600/30">
            <div class="absolute -bottom-20 -right-20 w-48 h-48 bg-cyan-500/5 rounded-full blur-3xl pointer-events-none"></div>

            <div class="flex items-center justify-between mb-5 relative z-10">
                <div>
                    <h3 class="text-[17px] font-bold text-slate-100">Aktivitas Terbaru</h3>
                    <p class="text-sm text-slate-500 mt-1">Peminjaman terbaru</p>
                </div>
                <a href="/daftar-transaksi" class="text-xs text-slate-500 hover:text-slate-300 border border-slate-700/30 rounded-lg px-3 py-1.5 hover:bg-slate-800/50 transition-all duration-200">
                    Lihat Semua â†’
                </a>
            </div>

            {{-- Table --}}
            <div class="relative z-10 overflow-x-auto">
                {{-- Table Header --}}
                <div class="grid grid-cols-[2fr_2.5fr_1.2fr_1.3fr] gap-2 px-3 py-2.5 text-[11px] font-semibold uppercase tracking-wider text-slate-500 border-b border-slate-700/20">
                    <span>Anggota</span>
                    <span>Judul Buku</span>
                    <span>Tanggal</span>
                    <span>Status</span>
                </div>

                {{-- Table Rows --}}
                @forelse($aktivitas_terbaru as $aktivitas)
                    <div class="grid grid-cols-[2fr_2.5fr_1.2fr_1.3fr] gap-2 px-3 py-3.5 items-center border-b border-slate-700/10 hover:bg-slate-800/30 transition-colors duration-200">
                        <div class="flex items-center gap-2.5">
                            <div class="w-8 h-8 rounded-lg bg-gradient-to-br from-cyan-500 to-violet-500 flex items-center justify-center flex-shrink-0">
                                <span class="text-[10px] font-bold text-white">
                                    {{ strtoupper(substr($aktivitas->anggota->nama_lengkap ?? 'NN', 0, 2)) }}
                                </span>
                            </div>
                            <span class="text-[13px] font-medium text-slate-200 truncate">{{ $aktivitas->anggota->nama_lengkap ?? '-' }}</span>
                        </div>
                        <span class="text-[13px] text-slate-400 truncate">{{ $aktivitas->buku->judul_buku ?? '-' }}</span>
                        <span class="text-xs text-slate-500">{{ \Carbon\Carbon::parse($aktivitas->tanggal_pinjam)->translatedFormat('d M') }}</span>
                        <div>
                            @if($aktivitas->status === 'dipinjam')
                                <span class="inline-block px-2.5 py-1 rounded-lg text-[11px] font-medium bg-emerald-500/12 text-emerald-400">Dipinjam</span>
                            @elseif($aktivitas->status === 'dikembalikan')
                                <span class="inline-block px-2.5 py-1 rounded-lg text-[11px] font-medium bg-cyan-500/12 text-cyan-400">Kembali</span>
                            @elseif($aktivitas->status === 'menunggu')
                                <span class="inline-block px-2.5 py-1 rounded-lg text-[11px] font-medium bg-amber-500/12 text-amber-400">Menunggu</span>
                            @elseif($aktivitas->status === 'ditolak')
                                <span class="inline-block px-2.5 py-1 rounded-lg text-[11px] font-medium bg-rose-500/12 text-rose-400">Ditolak</span>
                            @else
                                <span class="inline-block px-2.5 py-1 rounded-lg text-[11px] font-medium bg-slate-500/12 text-slate-400">{{ ucfirst($aktivitas->status) }}</span>
                            @endif
                        </div>
                    </div>
                @empty
                    <div class="py-10 text-center text-slate-500 text-sm">
                        <svg class="w-10 h-10 mx-auto mb-2 opacity-30" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M20.25 7.5l-.625 10.632a2.25 2.25 0 01-2.247 2.118H6.622a2.25 2.25 0 01-2.247-2.118L3.75 7.5m6 4.125l2.25 2.25m0 0l2.25 2.25M12 13.875l2.25-2.25M12 13.875l-2.25 2.25M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125z"/></svg>
                        Belum ada aktivitas peminjaman.
                    </div>
                @endforelse
            </div>
        </div>

    </section>

@endsection

@section('scripts')
{{-- ApexCharts CDN --}}
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {

    // â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•
    //  CHART 1: Spline Area â€” Tren Peminjaman
    // â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•
    const trendOptions = {
        series: [
            { name: 'Peminjaman',   data: @json($tren_bulanan['peminjaman']) },
            { name: 'Pengembalian', data: @json($tren_bulanan['pengembalian']) }
        ],
        chart: {
            type: 'area',
            height: 300,
            background: 'transparent',
            foreColor: '#64748b',
            fontFamily: 'Poppins, system-ui, sans-serif',
            toolbar: {
                show: true,
                tools: {
                    download: true,
                    selection: false,
                    zoom: false,
                    zoomin: false,
                    zoomout: false,
                    pan: false,
                    reset: false
                }
            },
            dropShadow: {
                enabled: true,
                top: 3,
                left: 0,
                blur: 14,
                opacity: 0.3,
                color: ['#06b6d4', '#8b5cf6']
            },
            animations: {
                enabled: true,
                easing: 'easeinout',
                speed: 1400,
                dynamicAnimation: { speed: 400 }
            }
        },
        colors: ['#06b6d4', '#8b5cf6'],
        stroke: { curve: 'smooth', width: 3, lineCap: 'round' },
        fill: {
            type: 'gradient',
            gradient: {
                shade: 'dark',
                type: 'vertical',
                shadeIntensity: 0.4,
                opacityFrom: 0.4,
                opacityTo: 0.02,
                stops: [0, 90, 100]
            }
        },
        grid: {
            show: true,
            borderColor: 'rgba(148, 163, 184, 0.06)',
            strokeDashArray: 4,
            position: 'back',
            xaxis: { lines: { show: false } },
            yaxis: { lines: { show: true } },
            padding: { top: 0, right: 8, bottom: 0, left: 8 }
        },
        xaxis: {
            categories: @json($tren_bulanan['labels']),
            labels: { style: { colors: '#64748b', fontSize: '12px', fontWeight: 500 } },
            axisBorder: { show: false },
            axisTicks: { show: false },
            crosshairs: { stroke: { color: '#06b6d4', width: 1, dashArray: 4 } }
        },
        yaxis: {
            labels: {
                style: { colors: '#64748b', fontSize: '12px', fontWeight: 500 },
                formatter: (val) => Math.round(val)
            }
        },
        tooltip: {
            theme: 'dark',
            style: { fontSize: '13px' },
            x: { show: true },
            marker: { show: true }
        },
        legend: {
            position: 'top',
            horizontalAlign: 'right',
            floating: true,
            offsetY: -8,
            labels: { colors: '#94a3b8' },
            markers: { width: 10, height: 10, radius: 12 }
        },
        dataLabels: { enabled: false },
        markers: { size: 0, hover: { size: 6, sizeOffset: 3 } }
    };
    new ApexCharts(document.querySelector('#trendChart'), trendOptions).render();


    // â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•
    //  CHART 2: Doughnut â€” Status Buku
    // â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•
    const doughnutOptions = {
        series: [
            {{ $status_buku['tersedia'] }},
            {{ $status_buku['dipinjam'] }},
            {{ $status_buku['terlambat'] }}
        ],
        chart: {
            type: 'donut',
            height: 260,
            background: 'transparent',
            foreColor: '#94a3b8',
            fontFamily: 'Poppins, system-ui, sans-serif',
            dropShadow: {
                enabled: true,
                top: 0,
                left: 0,
                blur: 16,
                opacity: 0.2,
                color: '#06b6d4'
            }
        },
        colors: ['#10b981', '#06b6d4', '#f59e0b'],
        labels: ['Tersedia', 'Dipinjam', 'Terlambat'],
        stroke: { width: 2, colors: ['#0f172a'] },
        plotOptions: {
            pie: {
                donut: {
                    size: '72%',
                    labels: {
                        show: true,
                        name: {
                            show: true,
                            color: '#94a3b8',
                            fontSize: '13px',
                            fontWeight: 500,
                            offsetY: -10
                        },
                        value: {
                            show: true,
                            color: '#f1f5f9',
                            fontSize: '26px',
                            fontWeight: 700,
                            fontFamily: "'Courier New', monospace",
                            offsetY: 4,
                            formatter: (val) => parseInt(val).toLocaleString()
                        },
                        total: {
                            show: true,
                            showAlways: true,
                            label: 'Total Buku',
                            color: '#64748b',
                            fontSize: '12px',
                            fontWeight: 500,
                            formatter: (w) => w.globals.seriesTotals.reduce((a, b) => a + b, 0).toLocaleString()
                        }
                    }
                }
            }
        },
        legend: { show: false },
        dataLabels: { enabled: false },
        tooltip: {
            theme: 'dark',
            fillSeriesColor: false,
            style: { fontSize: '13px' },
            y: { formatter: (val) => val.toLocaleString() + ' buku' }
        },
        states: {
            hover: { filter: { type: 'lighten', value: 0.08 } },
            active: { filter: { type: 'none' } }
        }
    };
    new ApexCharts(document.querySelector('#doughnutChart'), doughnutOptions).render();


    // â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•
    //  CHART 3: Horizontal Bar â€” Kategori Populer
    // â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•
    const barLabels = @json($kategori_populer['labels']);
    const barData = @json($kategori_populer['data']);

    if (barLabels.length > 0) {
        const barOptions = {
            series: [{ name: 'Peminjaman', data: barData }],
            chart: {
                type: 'bar',
                height: 280,
                background: 'transparent',
                foreColor: '#64748b',
                fontFamily: 'Poppins, system-ui, sans-serif',
                toolbar: { show: false },
                animations: { enabled: true, easing: 'easeinout', speed: 1000 }
            },
            plotOptions: {
                bar: {
                    horizontal: true,
                    barHeight: '55%',
                    borderRadius: 6,
                    borderRadiusApplication: 'end',
                    distributed: false
                }
            },
            colors: ['#06b6d4'],
            fill: {
                type: 'gradient',
                gradient: {
                    shade: 'dark',
                    type: 'horizontal',
                    shadeIntensity: 0.3,
                    gradientToColors: ['#8b5cf6'],
                    inverseColors: false,
                    opacityFrom: 1,
                    opacityTo: 0.85,
                    stops: [0, 100]
                }
            },
            xaxis: {
                categories: barLabels,
                labels: { style: { colors: '#64748b', fontSize: '12px', fontWeight: 500 } },
                axisBorder: { show: false },
                axisTicks: { show: false }
            },
            yaxis: {
                labels: { style: { colors: '#94a3b8', fontSize: '13px', fontWeight: 500 } }
            },
            grid: {
                show: true,
                borderColor: 'rgba(148, 163, 184, 0.06)',
                strokeDashArray: 4,
                xaxis: { lines: { show: true } },
                yaxis: { lines: { show: false } },
                padding: { top: -10, right: 10, bottom: 0, left: 10 }
            },
            tooltip: {
                theme: 'dark',
                style: { fontSize: '13px' },
                y: { formatter: (val) => val + ' peminjaman' }
            },
            dataLabels: {
                enabled: true,
                style: {
                    colors: ['#f1f5f9'],
                    fontSize: '12px',
                    fontWeight: 600,
                    fontFamily: "'Courier New', monospace"
                },
                offsetX: -4
            }
        };
        new ApexCharts(document.querySelector('#barChart'), barOptions).render();
    } else {
        // Tampilkan pesan kosong jika tidak ada data kategori
        document.querySelector('#barChart').innerHTML = `
            <div class="flex flex-col items-center justify-center h-full text-slate-500 py-16">
                <svg class="w-10 h-10 mb-2 opacity-30" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 013 19.875v-6.75zM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V8.625zM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V4.125z"/></svg>
                <span class="text-sm">Belum ada data kategori.</span>
            </div>`;
    }

});
</script>
@endsection
