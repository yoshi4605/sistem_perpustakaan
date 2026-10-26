@extends('layouts.index')

@section('halaman', 'Daftar Pengunjung')

@section('main')

<section class="mt-8">
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-6">
        <div>
            <h2 class="text-2xl font-bold text-white tracking-tight">Daftar Pengunjung</h2>
            <p class="text-slate-400 text-sm mt-0.5">Catatan kehadiran tamu dan pengunjung perpustakaan</p>
        </div>
        
        {{-- Form Filter Tanggal --}}
        <form action="/daftar-pengunjung" method="GET" class="flex items-center gap-3">
            <input type="date" name="tanggal" value="{{ $tanggal }}"
                class="bg-slate-900/60 px-4 py-2 rounded-xl border border-slate-700/80 text-white focus:outline-none focus:border-cyan-500 text-sm">
            
            <button type="submit" class="bg-gradient-to-r from-cyan-600 to-cyan-500 hover:from-cyan-500 hover:to-cyan-400 text-white px-5 py-2 rounded-xl font-semibold text-sm transition-all shadow-lg shadow-cyan-950/40 cursor-pointer">
                Filter
            </button>
            
            @if(request('tanggal'))
                <a href="/daftar-pengunjung" class="text-slate-400 hover:text-cyan-400 underline text-xs">Reset</a>
            @endif
        </form>
    </div>

    <div class="bg-slate-900/40 w-full rounded-2xl mt-4 p-6 shadow-xl border border-slate-700/60 overflow-x-auto">
        <table class="w-full min-w-[750px] border-collapse">
            <thead class="text-slate-300 font-semibold text-xs uppercase tracking-wider bg-slate-900/80">
                <tr class="border-b border-slate-800">
                    <th class="py-3.5 px-4 text-center whitespace-nowrap">Nama</th>
                    <th class="py-3.5 px-4 text-center whitespace-nowrap">NIK / NPM</th>
                    <th class="py-3.5 px-4 text-center whitespace-nowrap">Tujuan</th>
                    <th class="py-3.5 px-4 text-center whitespace-nowrap">Waktu Masuk</th>
                    <th class="py-3.5 px-4 text-center whitespace-nowrap">Foto</th>
                </tr>
            </thead>
            <tbody class="text-slate-200">
                @forelse ($pengunjung as $tamu)
                <tr class="border-b border-slate-800/60 hover:bg-slate-800/40 transition-colors">
                    <td class="py-4 px-4 text-center font-medium">{{ $tamu->nama }}</td>
                    <td class="py-4 px-4 text-center font-mono text-slate-400">{{ $tamu->npm }}</td>
                    <td class="py-4 px-4 text-center">
                        <span class="inline-block px-3 py-1 rounded-full text-xs font-medium bg-cyan-500/10 text-cyan-300 border border-cyan-500/20">
                            {{ $tamu->tujuan }}
                        </span>
                    </td>
                    <td class="py-4 px-4 text-center text-slate-300 font-medium">{{ $tamu->created_at->format('H:i') }}</td>
                    <td class="py-4 px-4 flex justify-center">
                        {{-- Thumbnail Foto (Bisa di-klik untuk zoom in) --}}
                        <div class="photo-zoom-trigger relative group cursor-pointer"
                             title="Klik untuk memperbesar foto"
                             data-nama="{{ $tamu->nama }}"
                             data-npm="{{ $tamu->npm }}"
                             data-tujuan="{{ $tamu->tujuan }}"
                             data-waktu="{{ $tamu->created_at->format('H:i') }}">
                            <img src="{{ $tamu->foto_wajah }}" 
                                 class="w-16 h-12 object-cover rounded-lg shadow-md border border-slate-700 group-hover:border-cyan-400 group-hover:scale-105 transition-all duration-200" 
                                 alt="Foto {{ $tamu->nama }}">
                            
                            {{-- Overlay Icon Zoom saat hover --}}
                            <div class="absolute inset-0 bg-slate-950/50 opacity-0 group-hover:opacity-100 rounded-lg flex items-center justify-center transition-all duration-200 pointer-events-none">
                                <svg class="w-5 h-5 text-cyan-400 drop-shadow-md" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607zM10.5 7.5v6m3-3h-6" />
                                </svg>
                            </div>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center py-12 text-slate-400 italic">
                        Belum ada pengunjung pada tanggal {{ \Carbon\Carbon::parse($tanggal)->translatedFormat('d F Y') }}.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</section>

{{-- MODAL ZOOM IN FOTO PENGUNJUNG --}}
<div id="photoZoomModal" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/85 backdrop-blur-md p-4 transition-all duration-200 opacity-0">
    <div id="photoZoomCard" class="relative bg-slate-900 border border-slate-700/80 rounded-2xl max-w-lg w-full overflow-hidden shadow-2xl transform scale-95 transition-all duration-200">
        
        {{-- Header Modal --}}
        <div class="flex items-center justify-between px-5 py-3.5 border-b border-slate-800 bg-slate-950/60">
            <div class="flex items-center gap-3">
                <div class="w-8 h-8 rounded-lg bg-cyan-500/15 border border-cyan-500/30 text-cyan-400 flex items-center justify-center flex-shrink-0">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
                    </svg>
                </div>
                <div>
                    <h4 id="zoomModalNama" class="text-white font-bold text-base leading-tight">Nama Pengunjung</h4>
                    <p id="zoomModalSub" class="text-xs text-slate-400 mt-0.5">NIK/NPM • Jam Masuk</p>
                </div>
            </div>
            <button type="button" onclick="closePhotoZoomModal()" class="w-8 h-8 rounded-lg bg-slate-800 hover:bg-slate-700 text-slate-400 hover:text-white flex items-center justify-center transition-all cursor-pointer text-sm">
                ✕
            </button>
        </div>

        {{-- Foto Zoom Display --}}
        <div class="p-4 bg-slate-950/80 flex items-center justify-center min-h-[260px]">
            <img id="zoomModalImg" src="" alt="Foto Pengunjung" 
                 class="max-h-[65vh] w-auto max-w-full rounded-xl object-contain shadow-2xl border border-slate-800">
        </div>

        {{-- Footer Modal --}}
        <div class="px-5 py-3 border-t border-slate-800 bg-slate-950/60 flex justify-between items-center text-xs">
            <div class="flex items-center gap-2">
                <span class="text-slate-400">Tujuan:</span>
                <span id="zoomModalTujuan" class="font-semibold text-cyan-300 bg-cyan-500/15 border border-cyan-500/30 px-2.5 py-0.5 rounded-md">
                    -
                </span>
            </div>
            <button type="button" onclick="closePhotoZoomModal()" class="px-4 py-1.5 rounded-xl border border-slate-700 text-slate-300 hover:bg-slate-800 hover:text-white text-xs font-medium transition-all cursor-pointer">
                Tutup (Esc)
            </button>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const modal = document.getElementById('photoZoomModal');
        const card = document.getElementById('photoZoomCard');
        const imgTarget = document.getElementById('zoomModalImg');
        const namaTarget = document.getElementById('zoomModalNama');
        const subTarget = document.getElementById('zoomModalSub');
        const tujuanTarget = document.getElementById('zoomModalTujuan');

        window.openPhotoZoomModal = function(src, nama, npm, tujuan, waktu) {
            imgTarget.src = src;
            namaTarget.textContent = nama || 'Pengunjung Perpustakaan';
            subTarget.textContent = (npm ? 'NIK/NPM: ' + npm : '') + (waktu ? ' • Pukul ' + waktu + ' WIB' : '');
            tujuanTarget.textContent = tujuan || '-';

            modal.classList.remove('hidden');
            // Trigger transition
            setTimeout(() => {
                modal.classList.remove('opacity-0');
                card.classList.remove('scale-95');
                card.classList.add('scale-100');
            }, 10);
        };

        window.closePhotoZoomModal = function() {
            modal.classList.add('opacity-0');
            card.classList.remove('scale-100');
            card.classList.add('scale-95');
            setTimeout(() => {
                modal.classList.add('hidden');
                imgTarget.src = '';
            }, 200);
        };

        // Pasang event listener pada setiap thumbnail
        document.querySelectorAll('.photo-zoom-trigger').forEach(trigger => {
            trigger.addEventListener('click', function() {
                const img = this.querySelector('img');
                if (!img) return;
                const src = img.src;
                const nama = this.getAttribute('data-nama') || '';
                const npm = this.getAttribute('data-npm') || '';
                const tujuan = this.getAttribute('data-tujuan') || '';
                const waktu = this.getAttribute('data-waktu') || '';
                openPhotoZoomModal(src, nama, npm, tujuan, waktu);
            });
        });

        // Klik di area backdrop hitam untuk menutup modal
        modal.addEventListener('click', function(e) {
            if (e.target === this) {
                closePhotoZoomModal();
            }
        });

        // Tekan tombol ESC keyboard untuk menutup modal
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' && !modal.classList.contains('hidden')) {
                closePhotoZoomModal();
            }
        });
    });
</script>
@endsection
