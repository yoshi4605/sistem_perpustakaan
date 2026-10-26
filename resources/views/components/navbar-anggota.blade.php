@php
    $anggotaId = optional(Auth::user()->Anggota)->id;
    $unreadNotifCount = $anggotaId ? \App\Models\Pemberitahuan::where('anggota_id', $anggotaId)->where('sudah_dilihat', 0)->count() : 0;
    $activeLoanCount = $anggotaId ? \App\Models\Peminjaman::where('anggota_id', $anggotaId)->where('status', 'dipinjam')->count() : 0;
    $userFoto = Auth::user()->profile_photo ? asset('storage/' . Auth::user()->profile_photo) : asset('icons/default-avatar.png');
    $namaUser = Auth::user()->Anggota->nama_lengkap ?? Auth::user()->username;
@endphp

<header class="fixed top-0 left-0 right-0 z-50 bg-white/95 backdrop-blur-md border-b border-slate-200/80 shadow-xs">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-16">
            
            {{-- Brand / Logo --}}
            <div class="flex items-center gap-3">
                <a href="/dashboard-anggota" class="flex items-center gap-2.5 group">
                    <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-blue-600 to-indigo-600 text-white flex items-center justify-center shadow-md shadow-blue-500/20 group-hover:scale-105 transition-transform">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                        </svg>
                    </div>
                    <div>
                        <span class="font-extrabold text-slate-900 text-base tracking-tight group-hover:text-blue-600 transition-colors">MyLibrary</span>
                        <span class="block text-[10px] font-semibold text-slate-400 -mt-1 tracking-wider uppercase">Portal Baca</span>
                    </div>
                </a>
            </div>

            {{-- Desktop Navigation Links --}}
            <nav class="hidden md:flex items-center gap-1">
                <a href="/dashboard-anggota"
                   class="{{ request()->is('dashboard-anggota') ? 'text-blue-600 font-semibold bg-blue-50/80' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-100/70 font-medium' }} px-3.5 py-2 rounded-xl text-sm transition-all flex items-center gap-1.5">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                    </svg>
                    <span>Beranda</span>
                </a>

                <a href="/daftar-buku"
                   class="{{ request()->is('daftar-buku*') ? 'text-blue-600 font-semibold bg-blue-50/80' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-100/70 font-medium' }} px-3.5 py-2 rounded-xl text-sm transition-all flex items-center gap-1.5">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                    </svg>
                    <span>Jelajah Buku</span>
                </a>

                <a href="/e-book"
                   class="{{ request()->is('e-book*') ? 'text-blue-600 font-semibold bg-blue-50/80' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-100/70 font-medium' }} px-3.5 py-2 rounded-xl text-sm transition-all flex items-center gap-1.5">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    <span>E-Book</span>
                </a>

                <a href="/cari-skripsi"
                   class="{{ request()->is('cari-skripsi*') ? 'text-blue-600 font-semibold bg-blue-50/80' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-100/70 font-medium' }} px-3.5 py-2 rounded-xl text-sm transition-all flex items-center gap-1.5">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14zm-4 6v-7.5l4-2.222" />
                    </svg>
                    <span>Skripsi</span>
                </a>

                <a href="/bangku-baca"
                   class="{{ request()->is('bangku-baca*') ? 'text-blue-600 font-semibold bg-blue-50/80' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-100/70 font-medium' }} px-3.5 py-2 rounded-xl text-sm transition-all flex items-center gap-1.5">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                    </svg>
                    <span>Bangku Baca</span>
                </a>

                {{-- Rak Buku Saya --}}
                <a href="/riwayat-pinjaman"
                   class="{{ request()->is('riwayat-pinjaman*') ? 'text-blue-600 font-semibold bg-blue-50/80' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-100/70 font-medium' }} px-3.5 py-2 rounded-xl text-sm transition-all flex items-center gap-1.5">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                    </svg>
                    <span>Buku Saya</span>
                    @if($activeLoanCount > 0)
                        <span class="ml-1 bg-blue-100 text-blue-700 font-bold text-[10px] px-2 py-0.5 rounded-full">
                            {{ $activeLoanCount }}
                        </span>
                    @endif
                </a>

                {{-- Denda Saya --}}
                <a href="/denda-anggota"
                   class="{{ request()->is('denda-anggota*') ? 'text-blue-600 font-semibold bg-blue-50/80' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-100/70 font-medium' }} px-3.5 py-2 rounded-xl text-sm transition-all flex items-center gap-1.5">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span>Denda</span>
                </a>
            </nav>

            {{-- Right Actions: Notifikasi & Profile --}}
            <div class="flex items-center gap-3">
                {{-- Notification Bell --}}
                <a href="/pemberitahuan" class="relative p-2 rounded-xl text-slate-500 hover:text-slate-900 hover:bg-slate-100/80 transition" title="Pemberitahuan">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                    </svg>
                    @if($unreadNotifCount > 0)
                        <span class="absolute top-1.5 right-1.5 w-2.5 h-2.5 bg-rose-500 rounded-full ring-2 ring-white"></span>
                    @endif
                </a>

                {{-- User Profile Pill & Dropdown --}}
                <div class="relative" id="userMenuDropdownWrapper">
                    <button type="button" id="userMenuBtn" class="flex items-center gap-2.5 pl-2 pr-3 py-1.5 rounded-full hover:bg-slate-100/80 transition cursor-pointer border border-slate-200/60">
                        <img src="{{ $userFoto }}" alt="{{ $namaUser }}" class="w-7 h-7 rounded-full object-cover border border-slate-200">
                        <span class="hidden sm:inline font-semibold text-xs text-slate-700 max-w-[120px] truncate">{{ $namaUser }}</span>
                        <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>

                    {{-- Dropdown Menu --}}
                    <div id="userMenuDropdown" class="hidden absolute right-0 mt-2 w-56 bg-white rounded-2xl shadow-xl border border-slate-200 py-2 z-50 animate-in fade-in zoom-in-95 duration-150">
                        <div class="px-4 py-2.5 border-b border-slate-100">
                            <p class="font-bold text-slate-800 text-sm truncate">{{ $namaUser }}</p>
                            <p class="text-[11px] text-slate-400 font-mono mt-0.5">NIS/NIK: {{ Auth::user()->Anggota->nomer_induk ?? '-' }}</p>
                        </div>

                        <div class="py-1">
                            <a href="/profile-anggota" class="flex items-center gap-2 px-4 py-2 text-xs font-medium text-slate-700 hover:bg-slate-50 transition">
                                <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                                <span>Profil Saya</span>
                            </a>
                            <a href="/riwayat-pinjaman" class="flex items-center gap-2 px-4 py-2 text-xs font-medium text-slate-700 hover:bg-slate-50 transition">
                                <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                </svg>
                                <span>Buku Pinjaman Saya</span>
                            </a>
                        </div>

                        <div class="border-t border-slate-100 pt-1">
                            <button type="button" onclick="document.getElementById('logoutModal').classList.remove('hidden')" class="w-full text-left flex items-center gap-2 px-4 py-2 text-xs font-medium text-rose-600 hover:bg-rose-50 transition cursor-pointer">
                                <svg class="w-4 h-4 text-rose-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                </svg>
                                <span>Keluar Akun</span>
                            </button>
                        </div>
                    </div>
                </div>

                {{-- Mobile Menu Hamburger --}}
                <button type="button" id="mobileMenuBtn" class="md:hidden p-2 rounded-xl text-slate-600 hover:bg-slate-100 transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    {{-- Mobile Navigation Drawer --}}
    <div id="mobileMenuDrawer" class="hidden md:hidden border-t border-slate-200 bg-white px-4 py-3 space-y-1 shadow-lg">
        <a href="/dashboard-anggota" class="block px-3 py-2 rounded-xl text-sm font-medium {{ request()->is('dashboard-anggota') ? 'bg-blue-50 text-blue-600 font-semibold' : 'text-slate-700' }}">Beranda</a>
        <a href="/daftar-buku" class="block px-3 py-2 rounded-xl text-sm font-medium {{ request()->is('daftar-buku*') ? 'bg-blue-50 text-blue-600 font-semibold' : 'text-slate-700' }}">Jelajah Buku</a>
        <a href="/e-book" class="block px-3 py-2 rounded-xl text-sm font-medium {{ request()->is('e-book*') ? 'bg-blue-50 text-blue-600 font-semibold' : 'text-slate-700' }}">E-Book</a>
        <a href="/cari-skripsi" class="block px-3 py-2 rounded-xl text-sm font-medium {{ request()->is('cari-skripsi*') ? 'bg-blue-50 text-blue-600 font-semibold' : 'text-slate-700' }}">Koleksi Skripsi</a>
        <a href="/bangku-baca" class="block px-3 py-2 rounded-xl text-sm font-medium {{ request()->is('bangku-baca*') ? 'bg-blue-50 text-blue-600 font-semibold' : 'text-slate-700' }}">Pilih Bangku Baca</a>
        <a href="/riwayat-pinjaman" class="block px-3 py-2 rounded-xl text-sm font-medium {{ request()->is('riwayat-pinjaman*') ? 'bg-blue-50 text-blue-600 font-semibold' : 'text-slate-700' }}">Buku Saya (Pinjaman)</a>
        <a href="/denda-anggota" class="block px-3 py-2 rounded-xl text-sm font-medium {{ request()->is('denda-anggota*') ? 'bg-blue-50 text-blue-600 font-semibold' : 'text-slate-700' }}">Denda</a>
    </div>
</header>

{{-- Modal Logout --}}
<div id="logoutModal" class="hidden fixed inset-0 z-50 bg-slate-900/50 backdrop-blur-sm flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl max-w-sm w-full p-6 shadow-2xl border border-slate-100 text-center animate-in fade-in zoom-in-95 duration-150">
        <div class="w-12 h-12 rounded-full bg-rose-50 text-rose-500 mx-auto flex items-center justify-center mb-3">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
            </svg>
        </div>
        <h4 class="font-bold text-slate-800 text-base">Keluar dari Akun?</h4>
        <p class="text-xs text-slate-500 mt-1 mb-5">Anda harus login kembali untuk meminjam buku atau mengunduh e-book.</p>
        <div class="flex items-center gap-2">
            <button type="button" onclick="document.getElementById('logoutModal').classList.add('hidden')" class="flex-1 px-4 py-2 rounded-xl border border-slate-200 text-xs font-semibold text-slate-700 hover:bg-slate-50 transition cursor-pointer">
                Batal
            </button>
            <form action="/logout" method="POST" class="flex-1">
                @csrf
                <button type="submit" class="w-full px-4 py-2 rounded-xl bg-rose-600 hover:bg-rose-700 text-white text-xs font-semibold shadow-sm transition cursor-pointer">
                    Ya, Keluar
                </button>
            </form>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const userMenuBtn = document.getElementById('userMenuBtn');
        const userMenuDropdown = document.getElementById('userMenuDropdown');
        const mobileMenuBtn = document.getElementById('mobileMenuBtn');
        const mobileMenuDrawer = document.getElementById('mobileMenuDrawer');

        if (userMenuBtn && userMenuDropdown) {
            userMenuBtn.addEventListener('click', (e) => {
                e.stopPropagation();
                userMenuDropdown.classList.toggle('hidden');
            });

            document.addEventListener('click', (e) => {
                if (!userMenuDropdown.contains(e.target) && !userMenuBtn.contains(e.target)) {
                    userMenuDropdown.classList.add('hidden');
                }
            });
        }

        if (mobileMenuBtn && mobileMenuDrawer) {
            mobileMenuBtn.addEventListener('click', () => {
                mobileMenuDrawer.classList.toggle('hidden');
            });
        }
    });
</script>

