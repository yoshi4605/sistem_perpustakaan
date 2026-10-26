@extends('layouts.index')

@section('halaman', 'Kelola Buku')

@section('main')


    {{-- Filter --}}
    <section class="mt-20 mb-8 flex justify-between items-center">
        <div>
            {{-- Tambah Buku Button --}}
            <a href="/kelola-buku/tambah-buku"
                class="flex items-center gap-2 mt-6 border text-white bg-[#35094D] px-6 py-3 rounded-md">
                <img src="{{ asset('icons/svg/add-buku-icon.svg') }}" alt="">
                <span>Tambah Buku</span>
            </a>
        </div>
        <div class="">
            {{-- Searching Buku --}}
            <form action="/kelola-buku" method="GET" class="form-cari flex items-center gap-2">
                @csrf
                <div class="relative w-full max-w-[450px]">
                    <div class="absolute inset-y-0 left-4 flex items-center">
                        <img src="{{ asset('icons/svg/Search.svg') }}" alt="">
                    </div>
                    <input name="cari" type="text" placeholder="Cari kode buku, judul buku...."
                        class="bg-white w-full pl-12 pr-4 py-3 rounded-md placeholder:text-gray-300 border border-gray-200"
                        value="{{ request('cari') }}">
                </div>
                <select name="kategori" onchange="this.form.submit()"
                    class="bg-white px-4 py-3 rounded-md border border-gray-200 text-sm text-gray-600 cursor-pointer">
                    <option value="">Semua Kategori</option>
                    @foreach ($kategoris as $kat)
                        <option value="{{ $kat }}" {{ request('kategori') == $kat ? 'selected' : '' }}>
                            {{ $kat }}
                        </option>
                    @endforeach
                </select>
                <button type="submit"
                    class="bg-[#35094D] text-white px-6 py-3 rounded-md hover:bg-[#2a073a] transition duration-300 cursor-pointer">Cari</button>
                @if(request('kategori') || request('cari'))
                    <a href="/kelola-buku" class="text-sm text-gray-400 hover:text-[#35094D] underline whitespace-nowrap">Reset</a>
                @endif
            </form>
        </div>
    </section>

    {{-- Table Pinjaman Aktif, Pending Dan Kembalikan(Pending) --}}
    <section>
        <div class="bg-white w-full rounded-2xl mt-4 p-6 shadow-xl border border-slate-700/60 overflow-x-auto">
            <div class="font-bold text-white text-base pb-4">Aktif</div>
            {{-- Table Riwayat Aktif (Pending Dan Aktif) --}}
            <table class="w-full min-w-[950px] border-collapse">
                <thead class="text-slate-300 font-semibold text-xs uppercase tracking-wider">
                    <tr>
                        <th class="py-3.5 px-4 text-center whitespace-nowrap">Cover</th>
                        <th class="py-3.5 px-4 text-center whitespace-nowrap">ISBN</th>
                        <th class="py-3.5 px-5 text-center whitespace-nowrap">Judul Buku</th>
                        <th class="py-3.5 px-4 text-center whitespace-nowrap">Penulis</th>
                        <th class="py-3.5 px-4 text-center whitespace-nowrap">Kategori</th>
                        <th class="py-3.5 px-4 text-center whitespace-nowrap">Rak</th>
                        <th class="py-3.5 px-4 text-center whitespace-nowrap">Penerbit</th>
                        <th class="py-3.5 px-6 text-center whitespace-nowrap min-w-[130px]">Tahun Terbit</th>
                        <th class="py-3.5 px-6 text-center whitespace-nowrap min-w-[110px]">Stok Buku</th>
                        <th class="py-3.5 px-5 text-center whitespace-nowrap min-w-[140px]">Aksi</th>
                    </tr>
                </thead>
                <tbody class="text-[#35094D]">
                    @forelse ($Bukus as $buku)
                        <tr class="border-b border-gray-200">
                            <td class="py-4 px-4 flex justify-center">
                                @if($buku->cover_buku)
                                    <img class="w-10 h-14 object-cover rounded-lg shadow-sm border border-slate-700"
                                        src="{{ asset('storage/' . $buku->cover_buku) }}"
                                        alt="{{ $buku->judul_buku ?? 'Cover buku' }}">
                                @else
                                    <div class="w-10 h-14 rounded-lg bg-slate-800 border border-slate-700/80 flex items-center justify-center text-slate-500 shadow-sm">
                                        <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25" />
                                        </svg>
                                    </div>
                                @endif
                            </td>
                            <td class="py-4 px-4 text-center whitespace-nowrap">{{ $buku->kode_buku ?? 'N/A' }}</td>
                            <td class="py-4 px-5 text-center font-medium">{{ $buku->judul_buku ?? 'N/A' }}</td>
                            <td class="py-4 px-4 text-center">{{ $buku->penulis ?? 'N/A' }}</td>
                            <td class="py-4 px-4 text-center">{{ $buku->kategori ?? '-' }}</td>
                            <td class="py-4 px-4 text-center">
                                @if($buku->rak)
                                    <span class="bg-cyan-500/10 text-cyan-400 border border-cyan-500/25 font-bold px-3 py-1 rounded-full text-xs">
                                        {{ $buku->rak }}
                                    </span>
                                @else
                                    <span class="text-slate-500">—</span>
                                @endif
                            </td>
                            <td class="py-4 px-4 text-center">{{ $buku->penerbit ?? '-' }}</td>
                            <td class="py-4 px-6 text-center whitespace-nowrap">{{ $buku->tahun_terbit ?? 'N/A' }}</td>
                            <td class="py-4 px-6 text-center whitespace-nowrap">
                                @if ($buku->stok_buku === 0)
                                    <span class="bg-rose-500/15 text-rose-400 border border-rose-500/30 px-3.5 py-1 rounded-full font-bold text-xs">
                                        {{ $buku->stok_buku ?? 0 }}
                                    </span>
                                @elseif ($buku->stok_buku <= 4)
                                    <span class="bg-amber-500/15 text-amber-300 border border-amber-500/30 px-3.5 py-1 rounded-full font-bold text-xs">
                                        {{ $buku->stok_buku ?? 'N/A' }}
                                    </span>
                                @else
                                    <span class="bg-emerald-500/15 text-emerald-400 border border-emerald-500/30 px-3.5 py-1 rounded-full font-bold text-xs">
                                        {{ $buku->stok_buku ?? 'N/A' }}
                                    </span>
                                @endif
                            </td>
                            {{-- Aksi --}}
                            <td class="py-4 px-5 text-center whitespace-nowrap">
                                <div class="flex items-center justify-center gap-2">
                                    <button onclick="window.location='/kelola-buku/{{ $buku->id }}'"
                                        class="btn_open_modal_kembalikan inline-flex items-center gap-1 bg-amber-500/20 text-amber-400 border border-amber-500/40 hover:bg-amber-500/30 px-3.5 py-1.5 rounded-xl text-xs font-semibold cursor-pointer transition-all">
                                        Edit
                                    </button>
                                    <button 
                                        class="btn_open_delete_buku inline-flex items-center gap-1 bg-rose-500/20 text-rose-400 border border-rose-500/40 hover:bg-rose-500/30 px-3.5 py-1.5 rounded-xl text-xs font-semibold cursor-pointer transition-all" data-buku-id="{{ $buku->id }}">
                                        Hapus
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="10" class="text-center py-8 text-gray-500 italic">Tidak ada buku yang ditemukan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            <div class="mt-6">
                {{ $Bukus->links() }}
            </div>
        </div>

        {{-- Modal Delete Pengguna --}}
        <section
            class="open_modal_delete_buku hidden fixed inset-0 bg-black/40 backdrop-blur-sm flex justify-center items-center z-50">
            <div class="bg-white p-8 w-full max-w-[32rem] rounded-xl">
                <div class="flex flex-col items-center gap-4">
                    <img class="w-36" src="{{ asset('icons/svg/delete-icon.svg') }}" alt="">
                    <span class="text-[#35094D] font-bold text-center">
                        Yakin ingin Hapus Buku ini? <br>
                        <span class="font-normal text-[14px]">Tindakan Ini Akan Hapus Data Secara Permanen.</span>
                    </span>
                </div>
                <div class="flex justify-center gap-4 my-6">
                    <button
                        class="btn_close_delete_buku border border-gray-200 text-[#35094D] px-10 py-2 rounded-full cursor-pointer">
                        Batal
                    </button>
                    <form class="delete_form_buku" action="" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                            class="btn_delete_buku bg-[#35094D] text-white px-10 py-2 rounded-full flex items-center justify-center gap-2 min-w-[140px]">
                            <span class="text_close_delete_buku">Ya, Hapus</span>
                            <svg class="spinner_delete hidden animate-spin h-5 w-5 text-white"
                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                    stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor"
                                    d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z">
                                </path>
                            </svg>
                        </button>
                    </form>
                </div>
            </div>
        </section>
    </section>
@endsection
