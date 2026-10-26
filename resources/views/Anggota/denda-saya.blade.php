@extends('layouts.index')

@section('halaman', 'Tagihan & Riwayat Denda')

@section('main')
    {{-- Header Section --}}
    <section class="mb-6">
        <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-4">
            <div>
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-blue-50 text-blue-700 text-xs font-semibold mb-2">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                    Pembayaran & Tagihan
                </div>
                <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">Tagihan & Riwayat Denda</h1>
                <p class="text-slate-500 text-xs sm:text-sm mt-1">Denda keterlambatan, kerusakan, atau penggantian buku fisik perpustakaan.</p>
            </div>
            <a href="/riwayat-pinjaman" class="text-xs font-semibold text-blue-600 hover:text-blue-800 transition">
                &larr; Lihat Buku Pinjaman
            </a>
        </div>

        {{-- Info Alert --}}
        <div class="bg-gradient-to-r from-blue-50/90 to-indigo-50/90 border border-blue-200/80 rounded-2xl p-4 mt-6 flex items-start gap-3 shadow-xs">
            <div class="w-8 h-8 rounded-xl bg-blue-600 text-white flex items-center justify-center flex-shrink-0">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z" />
                </svg>
            </div>
            <div class="text-xs text-slate-700 leading-relaxed">
                <span class="font-bold text-slate-900">Pembayaran Fleksibel (Bisa Online / Kasir):</span> 
                Sekarang Anda dapat melunasi denda secara instan via <strong>Online Gateway (QRIS BCA/GoPay/OVO/ShopeePay/VA Bank)</strong> tanpa harus ke kasir. Status denda akan langsung otomatis <strong>LUNAS</strong> dalam hitungan detik. Jika menghendaki uang tunai, Anda tetap dapat membayar ke meja sirkulasi petugas.
            </div>
        </div>
    </section>

    {{-- Tab Navigation --}}
    <section class="mb-6">
        <div class="flex items-center gap-2 border-b border-slate-200">
            <button type="button" id="tabBtnTertunda" onclick="switchDendaTab('tertunda')"
                class="tab-btn px-4 py-3 text-sm font-bold text-blue-600 border-b-2 border-blue-600 transition flex items-center gap-2 cursor-pointer">
                <span>Denda Belum Lunas (Tertunda)</span>
                <span class="bg-amber-100 text-amber-700 text-xs font-bold px-2 py-0.5 rounded-full">
                    {{ $pengembalians->total() }}
                </span>
            </button>
            <button type="button" id="tabBtnLunas" onclick="switchDendaTab('lunas')"
                class="tab-btn px-4 py-3 text-sm font-semibold text-slate-500 hover:text-slate-800 border-b-2 border-transparent transition flex items-center gap-2 cursor-pointer">
                <span>Riwayat Selesai (Lunas)</span>
                <span class="bg-slate-100 text-slate-600 text-xs font-bold px-2 py-0.5 rounded-full">
                    {{ $RiwayatsDenda->total() }}
                </span>
            </button>
        </div>
    </section>

    {{-- TAB 1: DENDA TERTUNDA --}}
    <section id="panelTertunda" class="tab-panel mb-12">
        <div class="bg-white rounded-2xl border border-slate-200 shadow-xs overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm">
                    <thead>
                        <tr class="bg-slate-50/80 border-b border-slate-200 text-slate-500 text-xs uppercase tracking-wider font-semibold">
                            <th class="py-3.5 px-4 text-center">Buku</th>
                            <th class="py-3.5 px-4 text-center">Tgl Pengembalian</th>
                            <th class="py-3.5 px-4 text-center">Terlambat</th>
                            <th class="py-3.5 px-4 text-center">Kondisi Fisik</th>
                            <th class="py-3.5 px-4 text-center">Total Denda</th>
                            <th class="py-3.5 px-4 text-center">Status</th>
                            <th class="py-3.5 px-4 text-center">Aksi Pembayaran</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse ($pengembalians as $pengembalian)
                            <tr class="hover:bg-slate-50/70 transition-colors">
                                <td class="py-4 px-4 text-center">
                                    <span class="inline-block font-mono text-[11px] font-bold text-blue-700 bg-blue-50 border border-blue-200 px-2 py-0.5 rounded mb-1">
                                        {{ $pengembalian->peminjaman->buku->kode_buku ?? 'KODE-N/A' }}
                                    </span>
                                    <h3 class="font-bold text-slate-800 text-xs max-w-[200px] mx-auto truncate" title="{{ $pengembalian->peminjaman->buku->judul_buku ?? 'N/A' }}">
                                        {{ $pengembalian->peminjaman->buku->judul_buku ?? 'Buku' }}
                                    </h3>
                                </td>

                                <td class="py-4 px-4 text-center text-xs text-slate-700 font-medium">
                                    {{ $pengembalian->tanggal_kembalikan ? \Carbon\Carbon::parse($pengembalian->tanggal_kembalikan)->translatedFormat('d M Y') : '-' }}
                                </td>

                                <td class="py-4 px-4 text-center text-xs">
                                    @if(abs($pengembalian->total_hari_terlambat) > 0)
                                        <span class="text-rose-600 font-bold bg-rose-50 border border-rose-200 px-2.5 py-0.5 rounded-full">
                                            {{ abs($pengembalian->total_hari_terlambat) }} Hari
                                        </span>
                                    @else
                                        <span class="text-slate-400">-</span>
                                    @endif
                                </td>

                                <td class="py-4 px-4 text-center text-xs text-slate-600">
                                    @if($pengembalian->buku_hilang)
                                        <span class="text-rose-600 font-semibold">Buku Hilang</span>
                                    @elseif($pengembalian->buku_rusak)
                                        <span class="text-amber-600 font-semibold">Buku Rusak</span>
                                    @else
                                        <span class="text-slate-400">Normal</span>
                                    @endif
                                </td>

                                <td class="py-4 px-4 text-center text-xs font-bold text-rose-600">
                                    Rp {{ number_format($pengembalian->jumlah_denda, 0, ',', '.') }}
                                </td>

                                <td class="py-4 px-4 text-center">
                                    <span class="inline-flex items-center gap-1.5 bg-amber-50 text-amber-700 border border-amber-200 text-xs font-semibold px-3 py-1 rounded-full">
                                        <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span>
                                        Belum Lunas
                                    </span>
                                </td>

                                <td class="py-4 px-4 text-center">
                                    <button type="button" 
                                        onclick="bayarDendaOnline({{ $pengembalian->id }}, '{{ addslashes($pengembalian->peminjaman->buku->judul_buku ?? 'Buku') }}', {{ (int)$pengembalian->jumlah_denda }})"
                                        class="inline-flex items-center gap-1.5 px-3.5 py-2 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white rounded-xl text-xs font-semibold shadow-xs transition cursor-pointer">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                                        </svg>
                                        Bayar Online
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-12">
                                    <div class="flex flex-col items-center justify-center">
                                        <div class="w-12 h-12 rounded-full bg-emerald-50 text-emerald-500 mx-auto flex items-center justify-center mb-2">
                                            <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                        </div>
                                        <h3 class="text-sm font-bold text-slate-700">Tidak ada tagihan denda</h3>
                                        <p class="text-xs text-slate-400 mt-0.5">Semua pengembalian buku Anda tertib atau sudah lunas.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if ($pengembalians->hasPages())
                <div class="px-6 py-4 border-t border-slate-100 bg-slate-50/40">
                    {{ $pengembalians->links() }}
                </div>
            @endif
        </div>
    </section>

    {{-- TAB 2: RIWAYAT DENDA LUNAS --}}
    <section id="panelLunas" class="tab-panel hidden mb-12">
        <div class="bg-white rounded-2xl border border-slate-200 shadow-xs overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm">
                    <thead>
                        <tr class="bg-slate-50/80 border-b border-slate-200 text-slate-500 text-xs uppercase tracking-wider font-semibold">
                            <th class="py-3.5 px-4 text-center">Buku</th>
                            <th class="py-3.5 px-4 text-center">Tgl Pengembalian</th>
                            <th class="py-3.5 px-4 text-center">Keterlambatan</th>
                            <th class="py-3.5 px-4 text-center">Total Dibayar</th>
                            <th class="py-3.5 px-4 text-center">Metode Pembayaran</th>
                            <th class="py-3.5 px-4 text-center">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse ($RiwayatsDenda as $riwayat)
                            <tr class="hover:bg-slate-50/70 transition-colors">
                                <td class="py-4 px-4 text-center">
                                    <span class="inline-block font-mono text-[11px] font-bold text-blue-700 bg-blue-50 border border-blue-200 px-2 py-0.5 rounded mb-1">
                                        {{ $riwayat->peminjaman->buku->kode_buku ?? 'KODE-N/A' }}
                                    </span>
                                    <h3 class="font-bold text-slate-800 text-xs max-w-[200px] mx-auto truncate">
                                        {{ $riwayat->peminjaman->buku->judul_buku ?? 'Buku' }}
                                    </h3>
                                </td>

                                <td class="py-4 px-4 text-center text-xs text-slate-700 font-medium">
                                    {{ $riwayat->tanggal_kembalikan ? \Carbon\Carbon::parse($riwayat->tanggal_kembalikan)->translatedFormat('d M Y') : '-' }}
                                </td>

                                <td class="py-4 px-4 text-center text-xs text-slate-600 font-mono">
                                    {{ ceil($riwayat->total_hari_terlambat) }} Hari
                                </td>

                                <td class="py-4 px-4 text-center text-xs font-bold text-slate-800 font-mono">
                                    Rp {{ number_format($riwayat->jumlah_denda, 0, ',', '.') }}
                                </td>

                                <td class="py-4 px-4 text-center">
                                    @if(str_contains($riwayat->metode_pembayaran ?? '', 'online'))
                                        <span class="inline-flex items-center gap-1 bg-blue-50 text-blue-700 border border-blue-200 text-2xs font-semibold px-2.5 py-0.5 rounded-full">
                                            <svg class="w-3 h-3 text-blue-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z" />
                                            </svg>
                                            Online (Gateway/QRIS)
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1 bg-slate-100 text-slate-600 text-2xs font-medium px-2.5 py-0.5 rounded-full">
                                            Kasir Tunai
                                        </span>
                                    @endif
                                </td>

                                <td class="py-4 px-4 text-center">
                                    <span class="inline-flex items-center gap-1.5 bg-emerald-50 text-emerald-700 border border-emerald-200 text-xs font-semibold px-3 py-1 rounded-full">
                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                        Lunas
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-12 text-slate-400 text-xs">
                                    Belum ada catatan riwayat denda lunas.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if ($RiwayatsDenda->hasPages())
                <div class="px-6 py-4 border-t border-slate-100 bg-slate-50/40">
                    {{ $RiwayatsDenda->links() }}
                </div>
            @endif
        </div>
    </section>

    {{-- MODAL PEMBAYARAN ONLINE (MIDTRANS & QRIS SIMULATOR) --}}
    <div id="modalBayarOnline" class="fixed inset-0 z-50 hidden overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-xs transition-opacity" onclick="tutupModalBayar()"></div>

        <div class="flex min-h-screen items-center justify-center p-4 text-center sm:p-0">
            <div class="relative transform overflow-hidden rounded-3xl bg-white text-left shadow-2xl transition-all sm:my-8 sm:w-full sm:max-w-lg border border-slate-200/80">
                
                {{-- Modal Header --}}
                <div class="p-6 border-b border-slate-100 bg-gradient-to-r from-blue-600 to-indigo-600 text-white flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-white/10 flex items-center justify-center">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-base font-bold text-white">Pembayaran Denda Online</h3>
                            <p class="text-xs text-blue-100">Gateway Resmi Perpustakaan Digital</p>
                        </div>
                    </div>
                    <button type="button" onclick="tutupModalBayar()" class="text-white/80 hover:text-white cursor-pointer">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                {{-- Modal Content --}}
                <div class="p-6">
                    {{-- Detail Buku & Total Tagihan --}}
                    <div class="bg-slate-50 border border-slate-200/80 rounded-2xl p-4 mb-5">
                        <div class="flex items-center justify-between text-xs text-slate-500 mb-1">
                            <span>Buku Pinjaman:</span>
                            <span id="labelOrderId" class="font-mono text-2xs text-slate-400">TRX-PENDING</span>
                        </div>
                        <h4 id="labelJudulBuku" class="text-sm font-bold text-slate-900 leading-snug line-clamp-1 mb-3">-</h4>

                        <div class="pt-3 border-t border-slate-200 flex items-center justify-between">
                            <span class="text-xs font-semibold text-slate-600">Total Denda Harus Dibayar:</span>
                            <span id="labelTotalDenda" class="text-lg font-black text-rose-600 font-mono">Rp 0</span>
                        </div>
                    </div>

                    {{-- Loading State --}}
                    <div id="paymentLoading" class="py-8 text-center flex flex-col items-center justify-center">
                        <svg class="animate-spin h-8 w-8 text-blue-600 mb-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        <p class="text-xs font-semibold text-slate-700">Menghubungkan ke Gateway Pembayaran...</p>
                        <p class="text-2xs text-slate-400 mt-1">Menyiapkan kode pembayaran aman</p>
                    </div>

                    {{-- QRIS & E-Wallet Panel --}}
                    <div id="paymentMethods" class="hidden space-y-4">
                        <div class="text-center p-4 rounded-2xl border-2 border-dashed border-blue-200 bg-blue-50/40">
                            <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-blue-600 text-white text-2xs font-bold uppercase tracking-wider mb-3">
                                QRIS Standar Bank Indonesia
                            </div>
                            
                            {{-- QR Code Image / SVG --}}
                            <div class="w-44 h-44 mx-auto bg-white p-2.5 rounded-2xl border border-slate-200 shadow-sm flex items-center justify-center">
                                <img src="https://api.qrserver.com/v1/create-qr-code/?size=180x180&data=00020101021226680016ID.CO.PERPUSKU01189360091100223344550215ID102002130303UMI51440014ID.GO.ID5204581253033605405100005802ID5919PERPUSTAKAAN+DIGITAL6007JAKARTA61051011062070703A016304A1B2" 
                                    class="w-full h-full object-contain" alt="QRIS Pembayaran Denda">
                            </div>

                            <p class="text-xs font-medium text-slate-700 mt-3">Buka aplikasi mobile banking atau e-wallet Anda</p>
                            <p class="text-2xs text-slate-400">BCA Mobile, Livin Mandiri, GoPay, OVO, ShopeePay, Dana, LinkAja</p>
                        </div>

                        {{-- Action Buttons --}}
                        <div class="space-y-2 pt-2">
                            <button type="button" id="btnKonfirmasiBayar" onclick="konfirmasiPembayaranSukses()"
                                class="w-full py-3 px-4 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl text-xs font-bold shadow-xs transition flex items-center justify-center gap-2 cursor-pointer">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                                </svg>
                                <span>Saya Sudah Membayar (Verifikasi Otomatis)</span>
                            </button>

                            <button type="button" onclick="tutupModalBayar()"
                                class="w-full py-2.5 px-4 border border-slate-200 hover:bg-slate-50 text-slate-600 rounded-xl text-xs font-semibold transition cursor-pointer">
                                Tutup / Bayar Nanti
                            </button>
                        </div>
                    </div>

                    {{-- Success State --}}
                    <div id="paymentSuccessState" class="hidden py-8 text-center flex flex-col items-center justify-center">
                        <div class="w-16 h-16 rounded-full bg-emerald-100 text-emerald-600 flex items-center justify-center mb-3 animate-bounce">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                            </svg>
                        </div>
                        <h4 class="text-base font-bold text-slate-900">Pembayaran Berhasil!</h4>
                        <p class="text-xs text-slate-500 mt-1 max-w-xs mx-auto">Tagihan denda telah lunas secara otomatis. Saldo tagihan Anda telah berkurang.</p>
                        <div class="mt-4 inline-flex items-center gap-1.5 px-4 py-1.5 bg-emerald-50 text-emerald-700 border border-emerald-200 rounded-full text-xs font-semibold">
                            Status: LUNAS (Terverifikasi)
                        </div>
                    </div>

                </div>

            </div>
        </div>
    </div>
@endsection

@section('scripts')
{{-- Midtrans Snap JS SDK --}}
<script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}"></script>

<script>
    let activePengembalianId = null;
    let activeOrderId = null;

    function switchDendaTab(tab) {
        const panelTertunda = document.getElementById('panelTertunda');
        const panelLunas = document.getElementById('panelLunas');
        const btnTertunda = document.getElementById('tabBtnTertunda');
        const btnLunas = document.getElementById('tabBtnLunas');

        if (tab === 'tertunda') {
            panelTertunda.classList.remove('hidden');
            panelLunas.classList.add('hidden');
            btnTertunda.className = 'tab-btn px-4 py-3 text-sm font-bold text-blue-600 border-b-2 border-blue-600 transition flex items-center gap-2 cursor-pointer';
            btnLunas.className = 'tab-btn px-4 py-3 text-sm font-semibold text-slate-500 hover:text-slate-800 border-b-2 border-transparent transition flex items-center gap-2 cursor-pointer';
        } else {
            panelTertunda.classList.add('hidden');
            panelLunas.classList.remove('hidden');
            btnTertunda.className = 'tab-btn px-4 py-3 text-sm font-semibold text-slate-500 hover:text-slate-800 border-b-2 border-transparent transition flex items-center gap-2 cursor-pointer';
            btnLunas.className = 'tab-btn px-4 py-3 text-sm font-bold text-blue-600 border-b-2 border-blue-600 transition flex items-center gap-2 cursor-pointer';
        }
    }

    function bayarDendaOnline(pengembalianId, judulBuku, dendaNominal) {
        activePengembalianId = pengembalianId;
        
        // Buka modal
        const modal = document.getElementById('modalBayarOnline');
        const loading = document.getElementById('paymentLoading');
        const methods = document.getElementById('paymentMethods');
        const successState = document.getElementById('paymentSuccessState');

        document.getElementById('labelJudulBuku').textContent = judulBuku;
        document.getElementById('labelTotalDenda').textContent = 'Rp ' + Number(dendaNominal).toLocaleString('id-ID');
        document.getElementById('labelOrderId').textContent = 'TRX-' + pengembalianId + '-' + Date.now();

        modal.classList.remove('hidden');
        loading.classList.remove('hidden');
        methods.classList.add('hidden');
        successState.classList.add('hidden');

        // Request Snap Token ke backend Laravel
        fetch('/denda/snap-token/' + pengembalianId, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                activeOrderId = data.order_id;
                document.getElementById('labelOrderId').textContent = activeOrderId;

                // Jika bukan demo dan Midtrans Snap tersedia
                if (!data.is_demo && window.snap && typeof window.snap.pay === 'function') {
                    window.snap.pay(data.snap_token, {
                        onSuccess: function(result) {
                            prosesSuksesKeServer(result.order_id, result.payment_type || 'midtrans');
                        },
                        onPending: function(result) {
                            alert('Pembayaran Anda sedang diproses. Mohon selesaikan transfer.');
                        },
                        onError: function(result) {
                            alert('Pembayaran gagal atau dibatalkan.');
                        },
                        onClose: function() {
                            // Tampilkan modal internal jika snap ditutup
                            loading.classList.add('hidden');
                            methods.classList.remove('hidden');
                        }
                    });
                } else {
                    // Mode Demo / Fallback QRIS
                    loading.classList.add('hidden');
                    methods.classList.remove('hidden');
                }
            } else {
                alert(data.message || 'Gagal memuat token pembayaran.');
                tutupModalBayar();
            }
        })
        .catch(err => {
            console.error('Payment token error:', err);
            // Fallback ke QRIS modal
            loading.classList.add('hidden');
            methods.classList.remove('hidden');
        });
    }

    function konfirmasiPembayaranSukses() {
        const btn = document.getElementById('btnKonfirmasiBayar');
        btn.disabled = true;
        btn.classList.add('opacity-70', 'cursor-not-allowed');
        btn.innerHTML = `
            <svg class="animate-spin h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
            <span>Memverifikasi Pembayaran...</span>
        `;

        prosesSuksesKeServer(activeOrderId, 'qris_online');
    }

    function prosesSuksesKeServer(orderId, paymentType) {
        fetch('/denda/payment-success', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({
                pengembalian_id: activePengembalianId,
                order_id: orderId,
                payment_type: paymentType
            })
        })
        .then(response => response.json())
        .then(res => {
            if (res.status === 'success') {
                document.getElementById('paymentMethods').classList.add('hidden');
                document.getElementById('paymentLoading').classList.add('hidden');
                document.getElementById('paymentSuccessState').classList.remove('hidden');

                setTimeout(() => {
                    window.location.reload();
                }, 1800);
            } else {
                alert(res.message || 'Gagal memproses pembayaran');
            }
        })
        .catch(err => {
            console.error(err);
            alert('Terjadi kesalahan saat memproses pembayaran.');
        });
    }

    function tutupModalBayar() {
        document.getElementById('modalBayarOnline').classList.add('hidden');
    }
</script>
@endsection
