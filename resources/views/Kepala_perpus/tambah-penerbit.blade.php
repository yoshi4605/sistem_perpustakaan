@extends('layouts.index')

@section('halaman', 'Daftar Penerbit')
@section('suffix', 'Kelola data supplier dan penerbit buku perpustakaan')

@section('main')
    <section class="mt-20 px-6">

        {{-- Notifikasi Sukses --}}
        @if(session('sukses'))
            <div class="mb-4 p-4 bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-xl text-sm font-medium">
                {{ session('sukses') }}
            </div>
        @endif

        {{-- Header & Tombol Tambah --}}
        <div class="flex justify-between items-center mb-8">
            <div>
                <h2 class="text-xl font-bold text-[#35094D]">Data Penerbit</h2>
                <p class="text-sm text-gray-400">Daftar supplier/penerbit buku perpustakaan</p>
            </div>
            <a href="/daftar-penerbit/tambah" class="bg-[#35094D] text-white px-5 py-2.5 rounded-xl font-medium hover:bg-[#250636] transition-colors flex items-center gap-2 text-sm shadow-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                Tambah Penerbit
            </a>
        </div>

        {{-- Grid Card --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-12">
            @forelse ($penerbits as $penerbit)
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 flex flex-col justify-between min-h-[170px] relative">

                    <div class="flex items-start justify-between gap-2">
                        <div class="flex items-start gap-4">
                            <div class="w-12 h-12 bg-gradient-to-tr from-cyan-500/20 to-violet-500/20 border border-cyan-500/30 text-cyan-400 flex items-center justify-center rounded-xl flex-shrink-0 overflow-hidden p-1">
                                @if($penerbit->logo)
                                    <img src="{{ asset('storage/' . $penerbit->logo) }}" class="w-full h-full object-contain" alt="{{ $penerbit->nama_penerbit }}">
                                @else
                                    <img src="{{ asset('icons/svg/penerbit-aktif.svg') }}" class="w-6 h-6 object-contain" alt="Penerbit">
                                @endif
                            </div>
                        <div class="min-w-0">
                                <a href="/daftar-penerbit/{{ $penerbit->id }}/detail">
                                    <h4 class="text-base font-bold text-[#35094D] truncate hover:underline">{{ $penerbit->nama_penerbit }}</h4>
                                </a>
                                <p class="text-xs text-gray-400 font-medium mt-0.5">{{ $penerbit->alamat ?? 'N/A' }}</p>
                                <p class="text-xs text-gray-500 mt-2 truncate">{{ $penerbit->email ?? '-' }}</p>
                            </div>
                        </div>

                        {{-- Action Buttons --}}
                        <div class="flex items-center gap-2">
                            {{-- Tombol Edit (Memanggil Fungsi JS dengan membawa data penorbit) --}}
                            <a href="/daftar-penerbit/{{ $penerbit->id }}/edit" class="text-blue-500 hover:text-blue-700 transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                            </a>

                            {{-- Tombol Hapus --}}
                            <form action="/daftar-penerbit/{{ $penerbit->id }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus penerbit ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-500 hover:text-red-700 transition-colors">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                </button>
                            </form>
                        </div>
                    </div>

                    <div class="border-t border-gray-100 pt-4 mt-4 flex justify-between items-center text-xs">
                        <span class="text-gray-400">Jumlah Buku</span>
                        <span class="font-bold text-[#35094D] text-sm">
                            {{ $penerbit->bukus_count ?? 0 }} <span class="text-[10px] font-normal text-gray-400">judul</span>
                        </span>
                    </div>
                </div>
            @empty
                <div class="col-span-1 md:col-span-3 bg-white p-12 rounded-2xl text-center text-gray-400 border border-gray-100">
                    Tidak ada data penerbit yang ditemukan.
                </div>
            @endforelse
        </div>
    </section>
@endsection