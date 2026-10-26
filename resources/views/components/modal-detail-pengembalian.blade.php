{{-- Modal Detail Pengembalian --}}
<section
    class="modal_detail_Pengembalian hidden fixed inset-0 bg-slate-900/50 backdrop-blur-sm flex items-center justify-center p-4 z-50">
    <div
        class="bg-white w-full max-w-3xl rounded-2xl shadow-2xl border border-slate-100 overflow-hidden animate-in fade-in zoom-in duration-200">

        {{-- Header Modal --}}
        <div class="px-6 py-4 border-b border-slate-100 flex justify-between items-center bg-slate-50/70">
            <div class="flex items-center gap-2.5">
                <div class="w-8 h-8 rounded-lg bg-indigo-50 text-indigo-600 flex items-center justify-center">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div>
                    <h3 class="text-base font-bold text-slate-800">Detail Riwayat Pengembalian</h3>
                    <p class="text-xs text-slate-400">Rincian pengembalian buku, denda, dan kondisi buku</p>
                </div>
            </div>
            <button type="button" class="closeModalPengembalian w-8 h-8 rounded-lg bg-slate-100 hover:bg-slate-200 text-slate-500 hover:text-slate-800 flex items-center justify-center transition cursor-pointer text-sm font-semibold">
                ✕
            </button>
        </div>

        {{-- Body --}}
        <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-6 max-h-[80vh] overflow-y-auto">

            {{-- Kolom Kiri: Info Anggota & Buku --}}
            <div class="space-y-4">
                <div class="border-b border-slate-100 pb-2">
                    <h4 class="text-xs font-bold text-slate-400 uppercase tracking-wider flex items-center gap-1.5">
                        <svg class="w-3.5 h-3.5 text-blue-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                        Identitas Anggota
                    </h4>
                </div>

                <div class="space-y-3">
                    <div>
                        <label class="block text-[11px] font-semibold text-slate-500 uppercase tracking-wider mb-1">NIS / NIK</label>
                        <input type="text" readonly
                            class="nomer_induk w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2 text-sm text-slate-800 font-mono outline-none">
                    </div>
                    <div>
                        <label class="block text-[11px] font-semibold text-slate-500 uppercase tracking-wider mb-1">Nama Anggota</label>
                        <input type="text" readonly
                            class="nama_lengkap w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2 text-sm text-slate-800 font-semibold outline-none">
                    </div>
                    <div>
                        <label class="block text-[11px] font-semibold text-slate-500 uppercase tracking-wider mb-1">Jenis Kelamin</label>
                        <input type="text" readonly
                            class="jenis_kelamin w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2 text-sm text-slate-700 outline-none capitalize">
                    </div>
                    <div>
                        <label class="block text-[11px] font-semibold text-slate-500 uppercase tracking-wider mb-1">Alamat</label>
                        <textarea readonly
                            class="alamat w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2 text-sm text-slate-700 outline-none h-20 resize-none leading-relaxed">-</textarea>
                    </div>
                </div>

                {{-- Data Buku --}}
                <div class="border-b border-slate-100 pb-2 pt-2">
                    <h4 class="text-xs font-bold text-slate-400 uppercase tracking-wider flex items-center gap-1.5">
                        <svg class="w-3.5 h-3.5 text-blue-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                        </svg>
                        Informasi Buku
                    </h4>
                </div>

                <div class="space-y-3">
                    <div class="grid grid-cols-3 gap-3">
                        <div class="col-span-1">
                            <label class="block text-[11px] font-semibold text-slate-500 uppercase tracking-wider mb-1">Kode</label>
                            <input type="text" readonly
                                class="kode_buku w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2 text-xs text-blue-700 font-mono font-semibold">
                        </div>
                        <div class="col-span-2">
                            <label class="block text-[11px] font-semibold text-slate-500 uppercase tracking-wider mb-1">Judul Buku</label>
                            <input type="text" readonly
                                class="judul_buku w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2 text-xs text-slate-800 font-semibold truncate">
                        </div>
                    </div>
                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="block text-[11px] font-semibold text-slate-500 uppercase tracking-wider mb-1">Penulis</label>
                            <input type="text" readonly
                                class="penulis w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2 text-xs text-slate-700">
                        </div>
                        <div>
                            <label class="block text-[11px] font-semibold text-slate-500 uppercase tracking-wider mb-1">Tahun Terbit</label>
                            <input type="text" readonly
                                class="thn_terbit w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2 text-xs text-slate-700 font-mono">
                        </div>
                    </div>
                </div>
            </div>

            {{-- Kolom Kanan: Detail Waktu & Denda --}}
            <div class="space-y-4">
                <div class="border-b border-slate-100 pb-2">
                    <h4 class="text-xs font-bold text-slate-400 uppercase tracking-wider flex items-center gap-1.5">
                        <svg class="w-3.5 h-3.5 text-indigo-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        Waktu & Keterlambatan
                    </h4>
                </div>

                {{-- Status & Tanggal Card --}}
                <div class="bg-slate-50 p-4 rounded-xl border border-slate-200/80 space-y-3">
                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="block text-[10px] font-semibold text-slate-500 uppercase tracking-wider mb-1">Tgl Pinjam</label>
                            <input type="text" readonly
                                class="tgl_pinjam w-full bg-white border border-slate-200 rounded-lg px-3 py-1.5 text-xs text-slate-800 font-medium">
                        </div>
                        <div>
                            <label class="block text-[10px] font-semibold text-slate-500 uppercase tracking-wider mb-1">Jatuh Tempo</label>
                            <input type="text" readonly
                                class="tgl_tempo w-full bg-white border border-slate-200 rounded-lg px-3 py-1.5 text-xs text-slate-800 font-medium">
                        </div>
                        <div>
                            <label class="block text-[10px] font-semibold text-slate-500 uppercase tracking-wider mb-1">Tgl Kembalikan</label>
                            <input type="text" readonly
                                class="tgl_kembalikan w-full bg-white border border-slate-200 rounded-lg px-3 py-1.5 text-xs text-slate-800 font-medium">
                        </div>
                        <div>
                            <label class="block text-[10px] font-semibold text-rose-600 uppercase tracking-wider mb-1">Total Hari Telat</label>
                            <input type="text" readonly
                                class="total_hari_terlambat w-full bg-white border border-rose-200 rounded-lg px-3 py-1.5 text-xs text-rose-700 font-bold">
                        </div>
                    </div>

                    {{-- Badges --}}
                    <div class="pt-2 border-t border-slate-200/60 flex flex-wrap gap-2 items-center justify-between text-xs">
                        <div>
                            <span class="text-slate-400 block text-[10px] mb-0.5">Status Pengembalian</span>
                            <span class="status_pengembalian inline-flex items-center px-2.5 py-0.5 rounded-full text-[11px] font-semibold">
                                -
                            </span>
                        </div>
                        <div>
                            <span class="text-slate-400 block text-[10px] mb-0.5">Status Pembayaran</span>
                            <span class="status_pembayaran inline-flex items-center px-2.5 py-0.5 rounded-full text-[11px] font-semibold">
                                -
                            </span>
                        </div>
                    </div>
                </div>

                {{-- Rincian Denda & Fisik Buku --}}
                <div class="border-b border-slate-100 pb-2 pt-2">
                    <h4 class="text-xs font-bold text-slate-400 uppercase tracking-wider flex items-center gap-1.5">
                        <svg class="w-3.5 h-3.5 text-rose-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                        Rincian Biaya & Fisik Buku
                    </h4>
                </div>

                <div class="space-y-3">
                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="block text-[11px] font-semibold text-slate-500 uppercase tracking-wider mb-1">Buku Rusak?</label>
                            <input type="text" readonly
                                class="buku_rusak w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2 text-xs text-slate-700 font-semibold">
                        </div>
                        <div>
                            <label class="block text-[11px] font-semibold text-slate-500 uppercase tracking-wider mb-1">Buku Hilang?</label>
                            <input type="text" readonly
                                class="buku_hilang w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2 text-xs text-slate-700 font-semibold">
                        </div>
                    </div>

                    <div class="bg-slate-50 p-3.5 rounded-xl border border-slate-200/80 space-y-2">
                        <div class="flex justify-between items-center text-xs">
                            <span class="text-slate-500">Total Denda:</span>
                            <input type="text" readonly class="jumlah_denda font-bold text-rose-600 bg-transparent text-right outline-none w-32">
                        </div>
                        <div class="flex justify-between items-center text-xs">
                            <span class="text-slate-500">Jumlah Bayar:</span>
                            <input type="text" readonly class="jumlah_bayar font-semibold text-slate-800 bg-transparent text-right outline-none w-32">
                        </div>
                        <div class="flex justify-between items-center text-xs pt-2 border-t border-slate-200/60">
                            <span class="text-slate-500">Kembalian:</span>
                            <input type="text" readonly class="jumlah_kembalian font-bold text-emerald-600 bg-transparent text-right outline-none w-32">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Footer Modal --}}
        <div class="px-6 py-3.5 bg-slate-50 border-t border-slate-100 flex justify-end">
            <button type="button" class="closeModalPengembalian bg-slate-200 hover:bg-slate-300 text-slate-700 px-5 py-2 rounded-xl text-sm font-medium transition cursor-pointer">
                Tutup
            </button>
        </div>
    </div>
</section>

<script>
    // Modal Detail Pengembalian
    const btnOpenPengembalian = document.querySelectorAll('.openModalDetailPengembalian');
    const modalPengembalian = document.querySelector('.modal_detail_Pengembalian');

    if (modalPengembalian) {
        const btnClosePengembalianBtns = modalPengembalian.querySelectorAll('.closeModalPengembalian');

        const pengembalianNomerInduk = modalPengembalian.querySelector('.nomer_induk');
        const pengembalianNama = modalPengembalian.querySelector('.nama_lengkap');
        const pengembalianJk = modalPengembalian.querySelector('.jenis_kelamin');
        const pengembalianAlamat = modalPengembalian.querySelector('.alamat');

        const pengembalianTglPinjam = modalPengembalian.querySelector('.tgl_pinjam');
        const pengembalianTglTempo = modalPengembalian.querySelector('.tgl_tempo');
        const pengembalianTglKembali = modalPengembalian.querySelector('.tgl_kembalikan');
        const pengembalianHariTelat = modalPengembalian.querySelector('.total_hari_terlambat');
        const pengembalianStatusPengembalian = modalPengembalian.querySelector('.status_pengembalian');
        const pengembalianStatusPembayaran = modalPengembalian.querySelector('.status_pembayaran');

        const pengembalianKodeBuku = modalPengembalian.querySelector('.kode_buku');
        const pengembalianJudulBuku = modalPengembalian.querySelector('.judul_buku');
        const pengembalianPenulis = modalPengembalian.querySelector('.penulis');
        const pengembalianThnTerbit = modalPengembalian.querySelector('.thn_terbit');

        const pengembalianBukuRusak = modalPengembalian.querySelector('.buku_rusak');
        const pengembalianBukuHilang = modalPengembalian.querySelector('.buku_hilang');
        const pengembalianJumlahDenda = modalPengembalian.querySelector('.jumlah_denda');
        const pengembalianJumlahBayar = modalPengembalian.querySelector('.jumlah_bayar');
        const pengembalianJumlahKembalian = modalPengembalian.querySelector('.jumlah_kembalian');

        btnOpenPengembalian.forEach(btn => {
            btn.addEventListener("click", function() {
                const no_induk = this.dataset.nomer_induk;
                const nama_lengkap = this.dataset.nama;
                const jk = this.dataset.jk;
                const alamat = this.dataset.alamat;

                const tgl_pinjam = this.dataset.tgl_pinjam;
                const tgl_tempo = this.dataset.tgl_tempo;
                const tgl_kembalikan = this.dataset.tgl_kembalikan;
                const hariTelat = this.dataset.total_hari_telat;

                const status_kembalikan = this.dataset.status_kembalikan;
                const status_pembayaran = this.dataset.status_pembayaran;

                const kode_buku = this.dataset.kode_buku;
                const judul_buku = this.dataset.judul_buku;
                const penulis = this.dataset.penulis;
                const thn_terbit = this.dataset.thn_terbit;

                const buku_rusak = this.dataset.buku_rusak;
                const buku_hilang = this.dataset.buku_hilang;
                const jumlah_denda = this.dataset.jumlah_denda;
                const jumlah_bayar = this.dataset.jumlah_bayar;
                const jumlah_kembalian = this.dataset.jumlah_kembalian;

                modalPengembalian.classList.remove("hidden");
                modalPengembalian.classList.add("flex");

                pengembalianNomerInduk.value = no_induk || 'N/A';
                pengembalianNama.value = nama_lengkap || 'N/A';
                pengembalianJk.value = jk || 'N/A';
                pengembalianAlamat.value = alamat || 'Tidak Ada Alamat';

                pengembalianTglPinjam.value = tgl_pinjam || '-';
                pengembalianTglTempo.value = tgl_tempo || '-';
                pengembalianTglKembali.value = tgl_kembalikan || '-';
                const hariFix = Math.ceil(hariTelat || 0);
                pengembalianHariTelat.value = hariFix + " hari";

                // Status Pengembalian
                pengembalianStatusPengembalian.className = 'status_pengembalian inline-flex items-center px-2.5 py-0.5 rounded-full text-[11px] font-semibold';
                if (status_kembalikan === "menunggu") {
                    pengembalianStatusPengembalian.classList.add('bg-amber-50', 'text-amber-700', 'border', 'border-amber-200');
                    pengembalianStatusPengembalian.textContent = 'Menunggu';
                } else {
                    pengembalianStatusPengembalian.classList.add('bg-blue-50', 'text-blue-700', 'border', 'border-blue-200');
                    pengembalianStatusPengembalian.textContent = 'Selesai';
                }

                // Status Pembayaran
                pengembalianStatusPembayaran.className = 'status_pembayaran inline-flex items-center px-2.5 py-0.5 rounded-full text-[11px] font-semibold';
                if (status_pembayaran === "tertunda") {
                    pengembalianStatusPembayaran.classList.add('bg-rose-50', 'text-rose-700', 'border', 'border-rose-200');
                    pengembalianStatusPembayaran.textContent = 'Tertunda';
                } else if (status_pembayaran === 'lunas') {
                    pengembalianStatusPembayaran.classList.add('bg-emerald-50', 'text-emerald-700', 'border', 'border-emerald-200');
                    pengembalianStatusPembayaran.textContent = 'Lunas';
                } else {
                    pengembalianStatusPembayaran.classList.add('bg-slate-50', 'text-slate-600', 'border', 'border-slate-200');
                    pengembalianStatusPembayaran.textContent = status_pembayaran || '-';
                }

                pengembalianKodeBuku.value = kode_buku || '-';
                pengembalianJudulBuku.value = judul_buku || '-';
                pengembalianPenulis.value = penulis || '-';
                pengembalianThnTerbit.value = thn_terbit || '-';

                pengembalianBukuRusak.value = buku_rusak === '1' ? "Ya" : "Tidak";
                pengembalianBukuHilang.value = buku_hilang === '1' ? "Ya" : "Tidak";

                function convertRupiah(angka) {
                    return 'Rp ' + (parseInt(angka) || 0).toLocaleString('id-ID');
                }

                if (pengembalianJumlahDenda) pengembalianJumlahDenda.value = convertRupiah(jumlah_denda);
                if (pengembalianJumlahBayar) pengembalianJumlahBayar.value = convertRupiah(jumlah_bayar);
                if (pengembalianJumlahKembalian) pengembalianJumlahKembalian.value = convertRupiah(jumlah_kembalian);
            });
        });

        btnClosePengembalianBtns.forEach(btn => {
            btn.addEventListener("click", function() {
                modalPengembalian.classList.add('hidden');
                modalPengembalian.classList.remove('flex');
            });
        });
    }
</script>
