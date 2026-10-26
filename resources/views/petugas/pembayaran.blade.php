@extends('layouts.index')

@section('halaman', 'Kasir Pembayaran Denda')

@section('main')
    {{-- Header & Search Bar --}}
    <section class="mt-8 flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center font-bold">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                </div>
                <div>
                    <h2 class="text-xl font-bold text-slate-800">Kasir Pembayaran Denda</h2>
                    <p class="text-xs text-slate-500 mt-0.5">Kelola pelunasan denda keterlambatan, kerusakan, atau kehilangan buku</p>
                </div>
            </div>
        </div>

        {{-- Form Cari --}}
        <form action="/pembayaran" method="GET" class="flex items-center gap-2">
            <div class="relative w-full sm:w-80">
                <div class="absolute inset-y-0 left-3.5 flex items-center pointer-events-none text-slate-400">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </div>
                <input name="cari" type="text" placeholder="Cari nama anggota atau NIS/NIK..."
                    class="bg-white w-full pl-10 pr-4 py-2.5 rounded-xl placeholder:text-slate-400 border border-slate-200 text-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-100 transition-all outline-none"
                    value="{{ request('cari') }}">
            </div>
            <button type="submit"
                class="bg-blue-600 text-white px-5 py-2.5 rounded-xl hover:bg-blue-700 transition font-medium text-sm cursor-pointer shadow-sm flex items-center gap-1.5">
                <span>Cari</span>
            </button>
            @if(request('cari'))
                <a href="/pembayaran" class="bg-slate-100 hover:bg-slate-200 text-slate-600 px-3.5 py-2.5 rounded-xl text-sm transition font-medium">
                    Reset
                </a>
            @endif
        </form>
    </section>

    {{-- Table Section --}}
    <section class="mt-6">
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
            <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between bg-slate-50/60">
                <div class="flex items-center gap-2">
                    <span class="w-2.5 h-2.5 rounded-full bg-amber-500 animate-pulse"></span>
                    <span class="text-sm font-semibold text-slate-700">Daftar Tagihan Denda Tertunda</span>
                </div>
                <span class="text-xs text-slate-500 bg-white px-3 py-1 rounded-full border border-slate-200">
                    Total: {{ $pengembalians->total() }} Tagihan
                </span>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm">
                    <thead>
                        <tr class="bg-slate-50/80 border-b border-slate-200 text-slate-500 text-xs uppercase tracking-wider font-semibold">
                            <th class="py-3.5 px-4">Anggota</th>
                            <th class="py-3.5 px-4 text-center">Tgl Pengembalian</th>
                            <th class="py-3.5 px-4 text-center">Buku Rusak</th>
                            <th class="py-3.5 px-4 text-center">Buku Hilang</th>
                            <th class="py-3.5 px-4 text-center">Total Denda</th>
                            <th class="py-3.5 px-4 text-center">Status</th>
                            <th class="py-3.5 px-4 text-center">Aksi Kasir</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse ($pengembalians as $pengembalian)
                            <tr class="hover:bg-slate-50/80 transition-colors">
                                {{-- Info Anggota --}}
                                <td class="py-4 px-4">
                                    <p class="font-semibold text-slate-800">
                                        {{ $pengembalian->peminjaman->anggota->nama_lengkap ?? 'Anggota Tidak Diketahui' }}
                                    </p>
                                    <p class="text-xs font-mono text-slate-500 mt-0.5">
                                        NIK/NIS: {{ $pengembalian->peminjaman->anggota->nomer_induk ?? '-' }}
                                    </p>
                                </td>

                                {{-- Tanggal Pengembalian --}}
                                <td class="py-4 px-4 text-center text-slate-700 font-medium">
                                    {{ $pengembalian->tanggal_kembalikan ? \Carbon\Carbon::parse($pengembalian->tanggal_kembalikan)->translatedFormat('d M Y') : '-' }}
                                </td>

                                {{-- Rusak --}}
                                <td class="py-4 px-4 text-center">
                                    @if($pengembalian->buku_rusak)
                                        <span class="text-xs font-semibold text-rose-700 bg-rose-50 border border-rose-200 px-2.5 py-0.5 rounded-full">
                                            Ya
                                        </span>
                                    @else
                                        <span class="text-xs text-slate-400">Tidak</span>
                                    @endif
                                </td>

                                {{-- Hilang --}}
                                <td class="py-4 px-4 text-center">
                                    @if($pengembalian->buku_hilang)
                                        <span class="text-xs font-semibold text-rose-700 bg-rose-50 border border-rose-200 px-2.5 py-0.5 rounded-full">
                                            Ya
                                        </span>
                                    @else
                                        <span class="text-xs text-slate-400">Tidak</span>
                                    @endif
                                </td>

                                {{-- Total Denda --}}
                                <td class="py-4 px-4 text-center">
                                    <span class="font-bold text-rose-600 text-sm">
                                        Rp {{ number_format($pengembalian->jumlah_denda, 0, ',', '.') }}
                                    </span>
                                </td>

                                {{-- Status Pembayaran --}}
                                <td class="py-4 px-4 text-center">
                                    @if ($pengembalian->status_pembayaran == 'lunas')
                                        <span class="inline-flex items-center gap-1 text-xs font-semibold text-emerald-700 bg-emerald-50 border border-emerald-200 px-2.5 py-0.5 rounded-full">
                                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                            Lunas
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1 text-xs font-semibold text-amber-700 bg-amber-50 border border-amber-200 px-2.5 py-0.5 rounded-full">
                                            <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span>
                                            Tertunda
                                        </span>
                                    @endif
                                </td>

                                {{-- Aksi --}}
                                <td class="py-4 px-4 text-center">
                                    <button data-id="{{ $pengembalian->id }}"
                                        data-buku="{{ $pengembalian->peminjaman->buku->judul_buku ?? 'Buku' }}"
                                        data-anggota="{{ $pengembalian->peminjaman->anggota->nama_lengkap ?? 'Anggota' }}"
                                        data-tgl-pinjam="{{ $pengembalian->tanggal_kembalikan ?? $pengembalian->peminjaman->tanggal_pinjam ?? '-' }}"
                                        data-total-denda="Rp {{ number_format($pengembalian->jumlah_denda, 0, ',', '.') }}"
                                        class="btnOpenModalBayar bg-blue-600 hover:bg-blue-700 text-white px-3.5 py-1.5 rounded-lg text-xs font-semibold transition cursor-pointer shadow-sm inline-flex items-center gap-1.5">
                                        <svg class="w-3.5 h-3.5 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                                        </svg>
                                        <span>Proses Bayar</span>
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-12">
                                    <div class="flex flex-col items-center justify-center">
                                        <div class="w-12 h-12 rounded-full bg-emerald-50 text-emerald-500 flex items-center justify-center mb-2">
                                            <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                        </div>
                                        <p class="text-sm font-medium text-slate-700">Tidak ada tagihan denda tertunda.</p>
                                        <p class="text-xs text-slate-400 mt-0.5">Semua denda anggota telah lunas dibayarkan.</p>
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

    {{-- Modal Pembayaran Kasir --}}
    <div
        class="openModalPembayaran hidden fixed inset-0 bg-slate-900/50 backdrop-blur-sm flex justify-center items-center z-50 p-4 transition-all">
        <div class="bg-white rounded-2xl shadow-2xl w-full max-w-2xl overflow-hidden border border-slate-100">

            {{-- Header --}}
            <div class="px-6 py-4 border-b border-slate-100 flex justify-between items-center bg-slate-50/70">
                <div class="flex items-center gap-2.5">
                    <div class="w-8 h-8 rounded-lg bg-emerald-50 text-emerald-600 flex items-center justify-center">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-base font-bold text-slate-800">Kasir Pelunasan Denda</h3>
                        <p class="text-xs text-slate-400">Verifikasi uang tunai dan proses tanda lunas</p>
                    </div>
                </div>
                <button type="button"
                    class="btnCloseModalPembayaran w-8 h-8 rounded-lg bg-slate-100 hover:bg-slate-200 text-slate-500 hover:text-slate-800 flex items-center justify-center transition cursor-pointer text-sm font-semibold">
                    ✕
                </button>
            </div>

            <form class="all_form form_pembayaran grid grid-cols-1 md:grid-cols-2 divide-y md:divide-y-0 md:divide-x divide-slate-100" method="POST">
                @csrf
                <input type="hidden" name="jumlah_denda" class="inputJumlahDendaHidden">
                <input type="hidden" name="total_bayar" class="inputTotalBayarHidden">
                <input type="hidden" name="jumlah_kembalian" class="inputKembalianHidden">
                <input type="hidden" name="jumlah_bayar" class="inputJumlahBayarReal">

                {{-- Kolom Kiri: Rincian Pinjaman --}}
                <div class="p-6 flex flex-col justify-between gap-4">
                    <div class="space-y-4">
                        <div class="border-b border-slate-100 pb-2">
                            <h4 class="text-xs font-bold text-slate-400 uppercase tracking-wider">Informasi Peminjaman</h4>
                        </div>
                        <div class="bg-slate-50 border border-slate-200/80 rounded-xl p-4 space-y-3">
                            <div>
                                <p class="text-[10px] text-slate-400 font-semibold uppercase tracking-wider">Judul Buku</p>
                                <p class="textBuku font-bold text-slate-800 text-sm mt-0.5 leading-snug"></p>
                            </div>
                            <div>
                                <p class="text-[10px] text-slate-400 font-semibold uppercase tracking-wider">Nama Anggota</p>
                                <p class="textAnggota font-semibold text-slate-700 text-sm mt-0.5"></p>
                            </div>
                            <div class="pt-2 border-t border-slate-200/60">
                                <p class="text-[10px] text-slate-400 font-semibold uppercase tracking-wider">Tanggal Dikembalikan</p>
                                <p class="textTglPinjam font-medium text-slate-700 text-xs mt-0.5"></p>
                            </div>
                        </div>
                    </div>

                    <div class="p-3 bg-amber-50 border border-amber-200 rounded-xl text-xs text-amber-800 flex items-start gap-2">
                        <svg class="w-4 h-4 text-amber-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span>Pastikan menerima uang tunai terlebih dahulu sebelum menyelesaikan transaksi.</span>
                    </div>
                </div>

                {{-- Kolom Kanan: Perhitungan Pembayaran --}}
                <div class="p-6 flex flex-col justify-between gap-4">
                    <div class="space-y-4">
                        <div class="border-b border-slate-100 pb-2">
                            <h4 class="text-xs font-bold text-slate-400 uppercase tracking-wider">Perhitungan Kasir</h4>
                        </div>

                        <div class="bg-slate-50 border border-slate-200/80 rounded-xl p-4 space-y-3">
                            <div class="flex justify-between items-center pb-3 border-b border-slate-200/60">
                                <span class="text-xs text-slate-500 font-medium">Total Denda</span>
                                <span class="textTotalDenda text-lg font-bold text-rose-600">Rp 0</span>
                            </div>
                            <div>
                                <label class="block text-[11px] font-semibold text-slate-600 uppercase tracking-wider mb-1">Uang Diterima (Rp)</label>
                                <input type="number" placeholder="Masukkan jumlah uang..." min="0"
                                    class="inputJumlahBayar w-full text-right text-sm font-bold text-slate-800 bg-white border border-slate-200 rounded-xl px-3.5 py-2.5 outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-100 transition">
                            </div>
                            <div class="flex justify-between items-center pt-2">
                                <span class="text-xs text-slate-500 font-medium">Uang Kembalian:</span>
                                <span class="textKembalian text-base font-bold text-emerald-600">Rp 0</span>
                            </div>
                        </div>
                    </div>

                    {{-- Tombol Aksi --}}
                    <div class="flex items-center gap-3 pt-2">
                        <button type="button"
                            class="btnCloseModalPembayaran bg-slate-100 hover:bg-slate-200 text-slate-600 font-medium px-4 py-2.5 rounded-xl text-sm transition cursor-pointer flex-1 text-center">
                            Batal
                        </button>
                        <button type="submit"
                            class="btn_simpan_perubahan flex-1 bg-emerald-600 hover:bg-emerald-700 text-white font-semibold py-2.5 px-4 rounded-xl transition flex items-center justify-center gap-2 shadow-sm text-sm">
                            <svg class="spinner_load hidden animate-spin h-4 w-4 text-white"
                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" />
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z" />
                            </svg>
                            <span class="text_simpan">Lunaskan</span>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script>
        const btnOpenModalBayar = document.querySelectorAll('.btnOpenModalBayar');
        const openModalPembayaran = document.querySelector('.openModalPembayaran');
        const formPembayaran = document.querySelector('.form_pembayaran');
        const btnCloseModals = document.querySelectorAll('.btnCloseModalPembayaran');

        const textBuku = document.querySelector('.textBuku');
        const textAnggota = document.querySelector('.textAnggota');
        const textTglPinjam = document.querySelector('.textTglPinjam');
        const textTotalDenda = document.querySelector('.textTotalDenda');
        const textKembalian = document.querySelector('.textKembalian');

        const inputJumlahBayar = document.querySelector('.inputJumlahBayar');
        const inputTotalBayarHidden = document.querySelector('.inputTotalBayarHidden');
        const inputKembalianHidden = document.querySelector('.inputKembalianHidden');
        const inputJumlahBayarReal = document.querySelector('.inputJumlahBayarReal');
        const inputJumlahDendaHidden = document.querySelector('.inputJumlahDendaHidden');

        const btnSimpan = document.querySelector('.btn_simpan_perubahan');

        function formatRupiah(angka) {
            return 'Rp ' + angka.toLocaleString('id-ID');
        }

        btnOpenModalBayar.forEach(btn => {
            btn.addEventListener('click', function() {
                const id = this.dataset.id;
                const buku = this.dataset.buku;
                const anggota = this.dataset.anggota;
                const tglPinjam = this.dataset.tglPinjam;
                const totalDendaText = this.dataset.totalDenda;

                textBuku.textContent = buku;
                textAnggota.textContent = anggota;
                textTglPinjam.textContent = tglPinjam;
                textTotalDenda.textContent = totalDendaText;

                const totalAngka = parseInt(totalDendaText.replace(/[^0-9]/g, '')) || 0;
                inputJumlahDendaHidden.value = totalAngka;

                inputJumlahBayar.value = '';
                textKembalian.textContent = 'Rp 0';

                btnSimpan.disabled = true;
                btnSimpan.classList.add('opacity-50', 'cursor-not-allowed');

                formPembayaran.action = `/pembayaran/${id}`;

                openModalPembayaran.classList.remove('hidden');
                openModalPembayaran.classList.add('flex');
            });
        });

        btnCloseModals.forEach(btn => {
            btn.addEventListener('click', () => {
                openModalPembayaran.classList.add('hidden');
                openModalPembayaran.classList.remove('flex');
            });
        });

        function hitungKembalian() {
            const total = parseInt(textTotalDenda.textContent.replace(/[^0-9]/g, '')) || 0;
            const bayar = parseInt(inputJumlahBayar.value) || 0;

            const kembalian = Math.max(bayar - total, 0);

            textKembalian.textContent = formatRupiah(kembalian);

            inputTotalBayarHidden.value = bayar;
            inputKembalianHidden.value = kembalian;
            inputJumlahBayarReal.value = bayar;

            let boleh = bayar > 0 && bayar >= total;

            btnSimpan.disabled = !boleh;
            btnSimpan.classList.toggle('opacity-50', !boleh);
            btnSimpan.classList.toggle('cursor-not-allowed', !boleh);
        }

        inputJumlahBayar.addEventListener('input', () => {
            hitungKembalian();
        });

        formPembayaran.addEventListener('submit', function(e) {
            const total = parseInt(textTotalDenda.textContent.replace(/[^0-9]/g, '')) || 0;
            const bayar = parseInt(inputJumlahBayar.value) || 0;
            const kembalian = Math.max(bayar - total, 0);

            inputJumlahBayarReal.value = bayar;
            inputTotalBayarHidden.value = bayar;
            inputKembalianHidden.value = kembalian;
        });
    </script>
@endsection
