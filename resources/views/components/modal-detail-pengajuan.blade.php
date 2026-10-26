{{-- Modal Detail Pengajuan --}}
<section
    class="modal_detail_pengajuan hidden fixed inset-0 bg-slate-900/50 backdrop-blur-sm flex items-center justify-center p-4 z-50">
    <div
        class="bg-white w-full max-w-3xl rounded-2xl shadow-2xl border border-slate-100 overflow-hidden animate-in fade-in zoom-in duration-200">

        {{-- Header Modal --}}
        <div class="px-6 py-4 border-b border-slate-100 flex justify-between items-center bg-slate-50/70">
            <div class="flex items-center gap-2.5">
                <div class="w-8 h-8 rounded-lg bg-blue-50 text-blue-600 flex items-center justify-center">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div>
                    <h3 class="text-base font-bold text-slate-800">Detail Permohonan Pinjaman</h3>
                    <p class="text-xs text-slate-400">Informasi lengkap data peminjam dan buku</p>
                </div>
            </div>
            <button type="button" class="closeModalPengajuan w-8 h-8 rounded-lg bg-slate-100 hover:bg-slate-200 text-slate-500 hover:text-slate-800 flex items-center justify-center transition cursor-pointer text-sm font-semibold">
                ✕
            </button>
        </div>

        {{-- Body --}}
        <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-6 max-h-[80vh] overflow-y-auto">

            {{-- Kolom Kiri: Info Anggota --}}
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
            </div>

            {{-- Kolom Kanan: Detail Buku & Masa Pinjam --}}
            <div class="space-y-4">
                <div class="border-b border-slate-100 pb-2">
                    <h4 class="text-xs font-bold text-slate-400 uppercase tracking-wider flex items-center gap-1.5">
                        <svg class="w-3.5 h-3.5 text-blue-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                        </svg>
                        Informasi Koleksi & Periode
                    </h4>
                </div>

                {{-- Status & Periode Card --}}
                <div class="bg-slate-50 p-4 rounded-xl border border-slate-200/80 space-y-3">
                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="block text-[10px] font-semibold text-slate-500 uppercase tracking-wider mb-1">Tgl Pengajuan</label>
                            <input type="text" readonly
                                class="tgl_pinjam w-full bg-white border border-slate-200 rounded-lg px-3 py-1.5 text-xs text-slate-800 font-medium">
                        </div>
                        <div>
                            <label class="block text-[10px] font-semibold text-rose-600 uppercase tracking-wider mb-1">Jatuh Tempo</label>
                            <input type="text" readonly
                                class="tgl_tempo w-full bg-white border border-rose-200 rounded-lg px-3 py-1.5 text-xs text-rose-700 font-semibold">
                        </div>
                    </div>
                    <div class="flex items-center justify-between pt-2 border-t border-slate-200/60">
                        <span class="text-xs text-slate-500">Status Saat Ini:</span>
                        <span class="status inline-flex items-center px-3 py-0.5 rounded-full text-xs font-semibold">
                            -
                        </span>
                    </div>
                </div>

                {{-- Data Buku --}}
                <div class="space-y-3">
                    <div>
                        <label class="block text-[11px] font-semibold text-slate-500 uppercase tracking-wider mb-1">Kode Buku</label>
                        <input type="text" readonly
                            class="kode_buku w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2 text-sm text-blue-700 font-mono font-semibold">
                    </div>
                    <div>
                        <label class="block text-[11px] font-semibold text-slate-500 uppercase tracking-wider mb-1">Judul Buku</label>
                        <input type="text" readonly
                            class="judul_buku w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2 text-sm text-slate-800 font-semibold">
                    </div>
                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="block text-[11px] font-semibold text-slate-500 uppercase tracking-wider mb-1">Penulis</label>
                            <input type="text" readonly
                                class="penulis w-full bg-slate-50 border border-slate-200 rounded-xl px-3 py-2 text-xs text-slate-700">
                        </div>
                        <div>
                            <label class="block text-[11px] font-semibold text-slate-500 uppercase tracking-wider mb-1">Tahun Terbit</label>
                            <input type="text" readonly
                                class="thn_terbit w-full bg-slate-50 border border-slate-200 rounded-xl px-3 py-2 text-xs text-slate-700 font-mono">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Footer Modal --}}
        <div class="px-6 py-3.5 bg-slate-50 border-t border-slate-100 flex justify-end">
            <button type="button" class="closeModalPengajuan bg-slate-200 hover:bg-slate-300 text-slate-700 px-5 py-2 rounded-xl text-sm font-medium transition cursor-pointer">
                Tutup
            </button>
        </div>
    </div>
</section>

<script>
    // Modal Detail Pengajuan
    const openModalDetailPengajuan = document.querySelectorAll('.openModalDetailPengajuan');
    const modalDetailPengajuan = document.querySelector('.modal_detail_pengajuan');
    const closeModalPengajuanBtns = modalDetailPengajuan ? modalDetailPengajuan.querySelectorAll('.closeModalPengajuan') : [];
    
    if (modalDetailPengajuan) {
        const InputNomerInduk = modalDetailPengajuan.querySelector('.nomer_induk');
        const InputNama = modalDetailPengajuan.querySelector('.nama_lengkap');
        const InputJk = modalDetailPengajuan.querySelector('.jenis_kelamin');
        const InputAlamat = modalDetailPengajuan.querySelector('.alamat');

        const InputTgl_pinjam = modalDetailPengajuan.querySelector('.tgl_pinjam');
        const InputTgl_tempo = modalDetailPengajuan.querySelector('.tgl_tempo');
        const InputStatus = modalDetailPengajuan.querySelector('.status');

        const InputKode_buku = modalDetailPengajuan.querySelector('.kode_buku');
        const InputJudul_buku = modalDetailPengajuan.querySelector('.judul_buku');
        const InputPenulis = modalDetailPengajuan.querySelector('.penulis');
        const InputThn_terbit = modalDetailPengajuan.querySelector('.thn_terbit');

        openModalDetailPengajuan.forEach(btn => {
            btn.addEventListener("click", function() {
                const no_induk = this.dataset.nomer_induk;
                const nama_lengkap = this.dataset.nama;
                const jk = this.dataset.jk;
                const alamat = this.dataset.alamat;

                const tgl_pinjam = this.dataset.tgl_pinjam;
                const tgl_tempo = this.dataset.tgl_tempo;

                const status = this.dataset.status;
                const kode_buku = this.dataset.kode_buku;
                const judul_buku = this.dataset.judul_buku;
                const penulis = this.dataset.penulis;
                const thn_terbit = this.dataset.thn_terbit;

                modalDetailPengajuan.classList.remove("hidden");
                modalDetailPengajuan.classList.add("flex");

                InputNomerInduk.value = no_induk || 'N/A';
                InputNama.value = nama_lengkap || 'N/A';
                InputJk.value = jk || 'N/A';
                InputAlamat.value = alamat || 'Tidak Ada Alamat';
                InputTgl_pinjam.value = tgl_pinjam || '-';
                InputTgl_tempo.value = tgl_tempo || '-';

                // Reset status styling
                InputStatus.className = 'status inline-flex items-center px-3 py-0.5 rounded-full text-xs font-semibold';
                if (status === "dipinjamkan" || status === "dipinjam") {
                    InputStatus.classList.add('bg-emerald-50', 'text-emerald-700', 'border', 'border-emerald-200');
                    InputStatus.textContent = 'Dipinjam';
                } else if (status === "ditolak") {
                    InputStatus.classList.add('bg-rose-50', 'text-rose-700', 'border', 'border-rose-200');
                    InputStatus.textContent = 'Ditolak';
                } else {
                    InputStatus.classList.add('bg-amber-50', 'text-amber-700', 'border', 'border-amber-200');
                    InputStatus.textContent = status || 'Menunggu';
                }

                InputKode_buku.value = kode_buku || '-';
                InputJudul_buku.value = judul_buku || '-';
                InputPenulis.value = penulis || '-';
                InputThn_terbit.value = thn_terbit || '-';
            });
        });

        closeModalPengajuanBtns.forEach(btn => {
            btn.addEventListener("click", function() {
                modalDetailPengajuan.classList.add('hidden');
                modalDetailPengajuan.classList.remove('flex');
            });
        });
    }
</script>
