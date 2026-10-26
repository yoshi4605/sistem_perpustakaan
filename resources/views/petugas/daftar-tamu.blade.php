@extends('layouts.index')

@section('halaman', 'Daftar Tamu')

@section('main')

    {{-- Filter Bar --}}
    <section class="mt-8 flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center font-bold">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                </svg>
            </div>
            <div>
                <h2 class="text-xl font-bold text-slate-800">Buku Tamu Perpustakaan</h2>
                <p class="text-xs text-slate-500 mt-0.5">Pantau data pengunjung yang hadir dan mengisi buku tamu</p>
            </div>
        </div>

        <form action="/petugas/daftar-tamu" method="GET" class="flex items-center gap-2">
            <input type="date" name="tanggal" value="{{ $tanggal }}"
                class="bg-white px-4 py-2.5 rounded-xl border border-slate-200 text-slate-700 text-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-100 transition outline-none">
            <button type="submit"
                class="bg-blue-600 text-white px-5 py-2.5 rounded-xl hover:bg-blue-700 transition font-medium text-sm cursor-pointer shadow-sm flex items-center gap-1.5">
                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
                </svg>
                <span>Filter</span>
            </button>
        </form>
    </section>

    <section class="mt-6">
        <div class="bg-white w-full rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
            <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between bg-slate-50/60">
                <div class="flex items-center gap-2">
                    <span class="w-2.5 h-2.5 rounded-full bg-blue-500"></span>
                    <span class="text-sm font-semibold text-slate-700">
                        Kunjungan Tanggal {{ \Carbon\Carbon::parse($tanggal)->translatedFormat('d F Y') }}
                    </span>
                </div>
                <span class="text-xs text-slate-500 bg-white px-3 py-1 rounded-full border border-slate-200">
                    Total: {{ $pengunjung->count() }} Pengunjung
                </span>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm">
                    <thead>
                        <tr class="bg-slate-50/80 border-b border-slate-200 text-slate-500 text-xs uppercase tracking-wider font-semibold">
                            <th class="py-3.5 px-4 text-center w-12">No</th>
                            <th class="py-3.5 px-4 text-center w-20">Foto</th>
                            <th class="py-3.5 px-4">Nama Pengunjung</th>
                            <th class="py-3.5 px-4 text-center">NPM / No. Anggota</th>
                            <th class="py-3.5 px-4 text-center">Tujuan Kunjungan</th>
                            <th class="py-3.5 px-4 text-center">Jam Masuk</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse ($pengunjung as $index => $tamu)
                            <tr class="hover:bg-slate-50/80 transition-colors">
                                <td class="py-4 px-4 text-center text-slate-400 text-xs">{{ $index + 1 }}</td>
                                <td class="py-4 px-4 text-center">
                                    @if($tamu->foto_wajah)
                                        <div class="photo-zoom-trigger relative group cursor-pointer inline-block"
                                             title="Klik untuk zoom foto"
                                             data-nama="{{ $tamu->nama }}"
                                             data-npm="{{ $tamu->npm }}"
                                             data-tujuan="{{ $tamu->tujuan }}"
                                             data-waktu="{{ \Carbon\Carbon::parse($tamu->created_at)->format('H:i') }}">
                                            <img src="{{ $tamu->foto_wajah }}" alt="Foto {{ $tamu->nama }}"
                                                class="w-10 h-10 rounded-full object-cover mx-auto border-2 border-slate-200 group-hover:border-blue-600 group-hover:scale-105 transition-all shadow-sm">
                                            <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 rounded-full flex items-center justify-center transition-all pointer-events-none">
                                                <svg class="w-3.5 h-3.5 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
                                                </svg>
                                            </div>
                                        </div>
                                    @else
                                        <img src="{{ asset('icons/default-avatar.png') }}" alt="No foto"
                                            class="w-10 h-10 rounded-full object-cover mx-auto border border-slate-200">
                                    @endif
                                </td>
                                <td class="py-4 px-4 font-semibold text-slate-800">{{ $tamu->nama }}</td>
                                <td class="py-4 px-4 text-center text-slate-500 font-mono text-xs">{{ $tamu->npm }}</td>
                                <td class="py-4 px-4 text-center">
                                    <span class="bg-blue-50 text-blue-700 px-3 py-1 rounded-full text-xs font-medium border border-blue-100">
                                        {{ $tamu->tujuan }}
                                    </span>
                                </td>
                                <td class="py-4 px-4 text-center text-slate-600 font-medium text-xs">{{ \Carbon\Carbon::parse($tamu->created_at)->format('H:i') }} WIB</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-12">
                                    <div class="flex flex-col items-center justify-center">
                                        <div class="w-12 h-12 rounded-full bg-slate-100 flex items-center justify-center text-slate-400 mb-2">
                                            <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                                            </svg>
                                        </div>
                                        <p class="text-sm font-medium text-slate-700">Tidak ada tamu pada tanggal ini.</p>
                                        <p class="text-xs text-slate-400 mt-0.5">Silakan pilih tanggal lain pada filter.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </section>

    {{-- MODAL ZOOM IN FOTO PENGUNJUNG --}}
    <div id="photoZoomModal" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/80 backdrop-blur-sm p-4 transition-all duration-200 opacity-0">
        <div id="photoZoomCard" class="relative bg-white border border-slate-200 rounded-2xl max-w-lg w-full overflow-hidden shadow-2xl transform scale-95 transition-all duration-200">
            
            {{-- Header Modal --}}
            <div class="flex items-center justify-between px-5 py-3.5 border-b border-slate-100 bg-slate-50">
                <div>
                    <h4 id="zoomModalNama" class="text-slate-900 font-bold text-base leading-tight">Nama Pengunjung</h4>
                    <p id="zoomModalSub" class="text-xs text-slate-500 mt-0.5">NIK/NPM • Jam Masuk</p>
                </div>
                <button type="button" onclick="closePhotoZoomModal()" class="w-8 h-8 rounded-lg bg-slate-200 hover:bg-slate-300 text-slate-600 hover:text-slate-900 flex items-center justify-center transition-all cursor-pointer text-sm">
                    ✕
                </button>
            </div>

            {{-- Foto Zoom Display --}}
            <div class="p-4 bg-slate-900 flex items-center justify-center min-h-[260px]">
                <img id="zoomModalImg" src="" alt="Foto Pengunjung" 
                     class="max-h-[65vh] w-auto max-w-full rounded-xl object-contain shadow-lg border border-slate-800">
            </div>

            {{-- Footer Modal --}}
            <div class="px-5 py-3 border-t border-slate-100 bg-slate-50 flex justify-between items-center text-xs">
                <div class="flex items-center gap-2">
                    <span class="text-slate-500">Tujuan:</span>
                    <span id="zoomModalTujuan" class="font-semibold text-blue-700 bg-blue-50 border border-blue-200 px-2.5 py-0.5 rounded-md">
                        -
                    </span>
                </div>
                <button type="button" onclick="closePhotoZoomModal()" class="px-4 py-1.5 rounded-xl border border-slate-300 text-slate-700 hover:bg-slate-100 text-xs font-medium transition-all cursor-pointer">
                    Tutup
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

        modal.addEventListener('click', function(e) {
            if (e.target === this) {
                closePhotoZoomModal();
            }
        });

        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' && !modal.classList.contains('hidden')) {
                closePhotoZoomModal();
            }
        });
    });
</script>
@endsection
