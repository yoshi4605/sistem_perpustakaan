@if(Auth::check() && Auth::user()->role === 'kepala_perpus')
    {{-- ═════════════════════════════════════════════════════════════════════════ --}}
    {{-- ADMIN COMMAND CENTER SIDEBAR (ANTI-GRAVITY DARK MODE)                   --}}
    {{-- ═════════════════════════════════════════════════════════════════════════ --}}
    @php
        $pendingCount = \App\Models\Peminjaman::where('status', 'menunggu')->count();
        $tamuCount = \App\Models\BukuTamu::whereDate('created_at', today())->count();
    @endphp

    <section id="sidebar-nav" class="bg-[#0f172a] w-full max-w-[316px] h-screen px-6 py-6 relative flex flex-col justify-between flex-shrink-0 select-none border-r border-slate-800/80 shadow-2xl">
        <div class="flex flex-col h-[calc(100vh-80px)]">
            {{-- 1. Logo & Branding Header (Point 5) --}}
            <div class="flex items-center gap-3 px-1">
                <div class="w-11 h-11 rounded-2xl bg-gradient-to-tr from-cyan-500 to-violet-600 flex items-center justify-center shadow-lg shadow-cyan-500/25 flex-shrink-0 p-2">
                    <img src="{{ asset('icons/logo.png') }}" class="w-full h-full object-contain drop-shadow" alt="logo">
                </div>
                <div class="flex flex-col overflow-hidden">
                    <div class="flex items-center gap-2">
                        <span class="text-[19px] font-extrabold leading-none tracking-tight sidebar-brand-title">Perpustakaan</span>
                    </div>
                    <div class="flex items-center gap-2 mt-1">
                        <span class="text-[14px] text-slate-200 font-semibold leading-none">Saya</span>
                        <span class="text-[9px] uppercase tracking-wider font-bold px-2 py-0.5 rounded-full bg-cyan-500/15 text-cyan-300 border border-cyan-500/30">
                            Admin OS v2.0
                        </span>
                    </div>
                </div>
            </div>

            {{-- 2. User Profile Card with Live Pulse & Quick Settings (Point 4) --}}
            <div class="mt-5 flex items-center justify-between border border-slate-700/60 rounded-2xl p-3 bg-slate-900/60 backdrop-blur-md shadow-inner">
                <div class="flex items-center gap-3 overflow-hidden">
                    <div class="relative flex-shrink-0">
                        <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-cyan-500/20 to-violet-500/20 border border-cyan-500/30 flex items-center justify-center p-0.5 overflow-hidden">
                            <img src="{{ Auth::user()->profile_photo ? asset('storage/' . Auth::user()->profile_photo) : asset('icons/svg/default-profile-sidebar.svg') }}" class="w-full h-full object-cover rounded-lg" alt="profile">
                        </div>
                        {{-- Live Pulse Dot (Online) --}}
                        <span class="absolute -top-0.5 -right-0.5 flex h-3 w-3">
                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                            <span class="relative inline-flex rounded-full h-3 w-3 bg-emerald-500 border-2 border-slate-900"></span>
                        </span>
                    </div>
                    <div class="flex flex-col overflow-hidden">
                        <span class="text-[13px] font-bold text-white truncate">{{ Auth::user()->username }}</span>
                        <div class="flex items-center gap-1.5 mt-0.5">
                            <span class="text-[9px] font-semibold text-cyan-400 uppercase tracking-wider bg-cyan-500/10 px-1.5 py-0.2 rounded border border-cyan-500/20">
                                Kepala Perpus
                            </span>
                            <span class="text-[10px] text-slate-400">#{{ Auth::user()->id }}</span>
                        </div>
                    </div>
                </div>

                {{-- Quick Link to Profile Settings --}}
                <a href="/profile-kepala-perpus" title="Kelola Profil & Pengaturan Akun" class="w-8 h-8 rounded-lg flex items-center justify-center text-slate-400 hover:text-cyan-300 hover:bg-slate-800/80 transition-all flex-shrink-0 border border-transparent hover:border-slate-700">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9.594 3.94c.09-.542.56-.94 1.11-.94h2.593c.55 0 1.02.398 1.11.94l.213 1.281c.063.374.313.686.645.87.074.04.147.083.22.127.324.196.72.257 1.075.124l1.217-.456a1.125 1.125 0 011.37.49l1.296 2.247a1.125 1.125 0 01-.26 1.431l-1.003.827c-.293.24-.438.613-.431.992a6.759 6.759 0 010 .255c-.007.378.138.75.43.99l1.005.828c.424.35.534.954.26 1.43l-1.298 2.247a1.125 1.125 0 01-1.369.491l-1.217-.456c-.355-.133-.75-.072-1.076.124a6.57 6.57 0 01-.22.128c-.331.183-.581.495-.644.869l-.213 1.28c-.09.543-.56.941-1.11.941h-2.594c-.55 0-1.02-.398-1.11-.94l-.213-1.281c-.062-.374-.312-.686-.644-.87a6.52 6.52 0 01-.22-.127c-.325-.196-.72-.257-1.076-.124l-1.217.456a1.125 1.125 0 01-1.369-.49l-1.297-2.247a1.125 1.125 0 01.26-1.431l1.004-.827c.292-.24.437-.613.43-.992a6.932 6.932 0 010-.255c.007-.378-.138-.75-.43-.99l-1.004-.828a1.125 1.125 0 01-.26-1.43l1.297-2.247a1.125 1.125 0 011.37-.491l1.216.456c.356.133.751.072 1.076-.124.072-.044.146-.087.22-.128.332-.183.582-.495.644-.869l.214-1.281z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                </a>
            </div>

            {{-- 3. Scrollable Grouped Navigation (Point 1, 2, 3) --}}
            <div class="mt-4 flex-1 overflow-y-auto pr-1 space-y-5">

                {{-- GROUP 1: ANALITIK & UTAMA --}}
                <div>
                    <span class="sidebar-section-title text-[10px] font-bold tracking-wider text-slate-400 uppercase px-2">Analitik & Utama</span>
                    <ul class="mt-2 space-y-1.5">
                        <li>
                            <a href="/dashboard-kepala-perpustakaan"
                                class="{{ request()->is('dashboard-kepala-perpustakaan*') ? 'active-menu font-semibold' : '' }} flex items-center gap-3 text-[14px]">
                                <div class="w-5 h-5 flex items-center justify-center flex-shrink-0">
                                    <img src="{{ request()->is('dashboard-kepala-perpustakaan*') ? asset('icons/svg/dashboard-active.svg') : asset('icons/svg/dashboard-inactive.svg') }}" class="w-4 h-4 object-contain" alt="">
                                </div>
                                <span>Command Center</span>
                            </a>
                        </li>
                        <li>
                            <a href="/daftar-laporan"
                                class="{{ request()->is('daftar-laporan*') ? 'active-menu font-semibold' : '' }} flex items-center gap-3 text-[14px]">
                                <div class="w-5 h-5 flex items-center justify-center flex-shrink-0">
                                    <img src="{{ request()->is('daftar-laporan*') ? asset('icons/svg/laporan-aktif.svg') : asset('icons/svg/laporan-inaktif.svg') }}" class="w-4 h-4 object-contain" alt="">
                                </div>
                                <span>Laporan & Statistik</span>
                            </a>
                        </li>
                    </ul>
                </div>

                {{-- GROUP 2: SIRKULASI & TRANSAKSI --}}
                <div>
                    <span class="sidebar-section-title text-[10px] font-bold tracking-wider text-slate-400 uppercase px-2">Sirkulasi & Tamu</span>
                    <ul class="mt-2 space-y-1.5">
                        <li>
                            <a href="/daftar-transaksi"
                                class="{{ request()->is('daftar-transaksi*') ? 'active-menu font-semibold' : '' }} flex items-center justify-between text-[14px]">
                                <div class="flex items-center gap-3">
                                    <div class="w-5 h-5 flex items-center justify-center flex-shrink-0">
                                        <img src="{{ request()->is('daftar-transaksi*') ? asset('icons/svg/transaksi-aktif.svg') : asset('icons/svg/transaksi-inaktif.svg') }}" class="w-4 h-4 object-contain" alt="">
                                    </div>
                                    <span>Transaksi Sirkulasi</span>
                                </div>
                                @if($pendingCount > 0)
                                    <span class="badge-pending text-[10px] font-bold px-2 py-0.5 rounded-full">
                                        {{ $pendingCount }}
                                    </span>
                                @endif
                            </a>
                        </li>
                        <li>
                            <a href="/daftar-pengunjung"
                                class="{{ request()->is('daftar-pengunjung*') ? 'active-menu font-semibold' : '' }} flex items-center justify-between text-[14px]">
                                <div class="flex items-center gap-3">
                                    <div class="w-5 h-5 flex items-center justify-center flex-shrink-0">
                                        <img src="{{ request()->is('daftar-pengunjung*') ? asset('icons/svg/pengguna-aktif.svg') : asset('icons/svg/pengguna-inaktif.svg') }}" class="w-4 h-4 object-contain" alt="">
                                    </div>
                                    <span>Buku Tamu</span>
                                </div>
                                @if($tamuCount > 0)
                                    <span class="badge-visitor text-[10px] font-bold px-2 py-0.5 rounded-full">
                                        {{ $tamuCount }} hari ini
                                    </span>
                                @endif
                            </a>
                        </li>
                    </ul>
                </div>

                {{-- GROUP 3: KATALOG & KOLEKSI --}}
                <div>
                    <span class="sidebar-section-title text-[10px] font-bold tracking-wider text-slate-400 uppercase px-2">Koleksi Pustaka</span>
                    <ul class="mt-2 space-y-1.5">
                        <li>
                            <a href="/kelola-buku"
                                class="{{ request()->is('kelola-buku*') ? 'active-menu font-semibold' : '' }} flex items-center gap-3 text-[14px]">
                                <div class="w-5 h-5 flex items-center justify-center flex-shrink-0">
                                    <img src="{{ request()->is('kelola-buku*') ? asset('icons/svg/buku-aktif.svg') : asset('icons/svg/buku-inactive.svg') }}" class="w-4 h-4 object-contain" alt="">
                                </div>
                                <span>Katalog Buku</span>
                            </a>
                        </li>
                        <li>
                            <a href="/input-ebook"
                                class="{{ request()->is('input-ebook*') ? 'active-menu font-semibold' : '' }} flex items-center gap-3 text-[14px]">
                                <div class="w-5 h-5 flex items-center justify-center flex-shrink-0">
                                    <img src="{{ request()->is('input-ebook*') ? asset('icons/svg/ebook-add-aktif.svg') : asset('icons/svg/ebook-add-inactive.svg') }}" class="w-4 h-4 object-contain" alt="">
                                </div>
                                <span>E-Book Digital</span>
                            </a>
                        </li>
                        <li>
                            <a href="/koleksi-skripsi"
                                class="{{ request()->is('koleksi-skripsi*') ? 'active-menu font-semibold' : '' }} flex items-center gap-3 text-[14px]">
                                <div class="w-5 h-5 flex items-center justify-center flex-shrink-0">
                                    <img src="{{ request()->is('koleksi-skripsi*') ? asset('icons/svg/skripsi-aktif.svg') : asset('icons/svg/skripsi-inactive.svg') }}" class="w-4 h-4 object-contain" alt="">
                                </div>
                                <span>Skripsi & Riset</span>
                            </a>
                        </li>
                        <li>
                            <a href="/daftar-penerbit"
                                class="{{ request()->is('daftar-penerbit*') ? 'active-menu font-semibold' : '' }} flex items-center gap-3 text-[14px]">
                                <div class="w-5 h-5 flex items-center justify-center flex-shrink-0">
                                    <img src="{{ request()->is('daftar-penerbit*') ? asset('icons/svg/penerbit-aktif.svg') : asset('icons/svg/penerbit-inactive.svg') }}" class="w-4 h-4 object-contain" alt="">
                                </div>
                                <span>Mitra Penerbit</span>
                            </a>
                        </li>
                    </ul>
                </div>

                {{-- GROUP 4: MANAJEMEN SISTEM --}}
                <div class="pb-2">
                    <span class="sidebar-section-title text-[10px] font-bold tracking-wider text-slate-400 uppercase px-2">Manajemen Sistem</span>
                    <ul class="mt-2 space-y-1.5">
                        <li>
                            <a href="/daftar-pengguna"
                                class="{{ request()->is('daftar-pengguna*') ? 'active-menu font-semibold' : '' }} flex items-center gap-3 text-[14px]">
                                <div class="w-5 h-5 flex items-center justify-center flex-shrink-0">
                                    <img src="{{ request()->is('daftar-pengguna*') ? asset('icons/svg/pengguna-aktif.svg') : asset('icons/svg/pengguna-inaktif.svg') }}" class="w-4 h-4 object-contain" alt="">
                                </div>
                                <span>Kelola Pengguna</span>
                            </a>
                        </li>
                        <li>
                            <a href="/setting"
                                class="{{ request()->is('setting*') ? 'active-menu font-semibold' : '' }} flex items-center gap-3 text-[14px]">
                                <div class="w-5 h-5 flex items-center justify-center flex-shrink-0">
                                    <img src="{{ request()->is('setting*') ? asset('icons/svg/gear-aktif.svg') : asset('icons/svg/gear-inaktif.svg') }}" class="w-4 h-4 object-contain" alt="">
                                </div>
                                <span>Kebijakan & Denda</span>
                            </a>
                        </li>
                    </ul>
                </div>

            </div>
        </div>

        {{-- 4. Clean Minimalist Ghost Logout Area (Point 6) --}}
        <div class="pt-3 border-t border-slate-800/80 mt-auto">
            <button
                class="btn_open_modal admin-logout-btn flex items-center justify-center gap-2.5 w-full rounded-xl py-2.5 px-4 text-[13px] font-medium transition-all duration-200 cursor-pointer">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15M12 9l-3 3m0 0l3 3m-3-3h12.75" />
                </svg>
                <span>Akhiri Sesi (Keluar)</span>
            </button>
        </div>

        {{-- Dark Glassmorphism Logout Modal for Admin --}}
        <section class="open_modal hidden fixed inset-0 bg-black/70 backdrop-blur-md flex justify-center items-center z-50 p-4">
            <div class="bg-[#0f172a] border border-slate-700/60 p-8 w-full max-w-md rounded-2xl shadow-2xl">
                <div class="flex flex-col items-center text-center gap-4">
                    <div class="w-16 h-16 rounded-2xl bg-rose-500/15 border border-rose-500/30 flex items-center justify-center text-rose-400 shadow-lg shadow-rose-900/20">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
                        </svg>
                    </div>
                    <h3 class="text-white font-bold text-xl">Konfirmasi Keluar</h3>
                    <p class="text-slate-400 text-sm">Apakah Anda yakin ingin mengakhiri sesi administrasi perpustakaan ini?</p>
                </div>

                <div class="flex justify-center gap-3 mt-8">
                    <button
                        class="btn_close border border-slate-700 text-slate-300 px-6 py-2.5 rounded-xl font-medium hover:bg-slate-800 transition-all text-sm cursor-pointer">
                        Batal
                    </button>

                    <form id="logout_form" action="/logout" method="POST">
                        @csrf
                        <button type="submit" id="btn_logout"
                            class="bg-gradient-to-r from-rose-600 to-rose-700 text-white px-6 py-2.5 rounded-xl font-medium flex items-center justify-center gap-2 min-w-[130px] hover:from-rose-500 hover:to-rose-600 shadow-lg shadow-rose-900/30 transition-all text-sm cursor-pointer">
                            <span id="text_logout">Ya, Keluar</span>
                            <svg id="spinner" class="hidden animate-spin h-4 w-4 text-white"
                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor"
                                    d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                </path>
                            </svg>
                        </button>
                    </form>
                </div>
            </div>
        </section>

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const openModalBtn = document.querySelector('.btn_open_modal');
                const closeModalBtn = document.querySelector('.btn_close');
                const modal = document.querySelector('.open_modal');

                openModalBtn?.addEventListener('click', () => modal?.classList.remove('hidden'));
                closeModalBtn?.addEventListener('click', () => modal?.classList.add('hidden'));

                const logoutForm = document.getElementById('logout_form');
                const btnLogout = document.getElementById('btn_logout');
                const spinner = document.getElementById('spinner');
                const textLogout = document.getElementById('text_logout');

                logoutForm?.addEventListener('submit', function() {
                    if (btnLogout) {
                        btnLogout.disabled = true;
                        btnLogout.classList.add('opacity-70', 'cursor-not-allowed');
                    }
                    closeModalBtn?.classList.add('invisible');
                    spinner?.classList.remove('hidden');
                    if (textLogout) textLogout.innerText = 'Tunggu...';
                });
            });
        </script>
    </section>

@elseif(Auth::check() && Auth::user()->role === 'petugas')
    {{-- ═════════════════════════════════════════════════════════════════════════ --}}
    {{-- PETUGAS / PUSTAKAWAN SIDEBAR (CLEAN, SIMPLE, INTERACTIVE LIGHT MODE)       --}}
    {{-- ═════════════════════════════════════════════════════════════════════════ --}}
    @php
        $pendingPengajuan = \App\Models\Peminjaman::where('status', 'menunggu')->count();
        $namaPetugas = Auth::user()->Petugas->nama_lengkap ?? Auth::user()->username;
    @endphp

    <section id="sidebar-nav" class="bg-white w-full max-w-[316px] h-screen px-6 py-6 relative flex flex-col justify-between flex-shrink-0 select-none border-r border-slate-200 shadow-sm">
        <div class="flex flex-col h-[calc(100vh-80px)]">
            {{-- 1. Logo & Branding Header --}}
            <div class="flex items-center gap-3 px-1">
                <div class="w-10 h-10 rounded-xl bg-blue-600 flex items-center justify-center shadow-md shadow-blue-500/20 flex-shrink-0 p-2">
                    <img src="{{ asset('icons/logo.png') }}" class="w-full h-full object-contain filter brightness-0 invert" alt="logo">
                </div>
                <div class="flex flex-col overflow-hidden">
                    <span class="text-lg font-bold text-slate-900 leading-none tracking-tight">Perpustakaan Saya</span>
                    <div class="flex items-center gap-1.5 mt-1">
                        <span class="text-[10px] uppercase tracking-wider font-bold px-2 py-0.5 rounded-full bg-blue-50 text-blue-700 border border-blue-200">
                            Meja Pustakawan
                        </span>
                    </div>
                </div>
            </div>

            {{-- 2. Staff Profile Card --}}
            <div class="mt-5 flex items-center justify-between border border-slate-200 rounded-xl p-3 bg-slate-50/70 hover:bg-slate-50 transition-colors">
                <div class="flex items-center gap-3 overflow-hidden">
                    <div class="relative flex-shrink-0">
                        <div class="w-10 h-10 rounded-xl bg-slate-200 border border-slate-300 flex items-center justify-center p-0.5 overflow-hidden">
                            <img src="{{ Auth::user()->profile_photo ? asset('storage/' . Auth::user()->profile_photo) : asset('icons/svg/default-profile-sidebar.svg') }}" class="w-full h-full object-cover rounded-lg" alt="profile">
                        </div>
                        <span class="absolute -top-0.5 -right-0.5 flex h-2.5 w-2.5">
                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                            <span class="relative inline-flex rounded-full h-2.5 w-2.5 bg-emerald-500 border border-white"></span>
                        </span>
                    </div>
                    <div class="flex flex-col overflow-hidden">
                        <span class="text-sm font-bold text-slate-800 truncate">{{ $namaPetugas }}</span>
                        <span class="text-xs text-slate-400 truncate">Pustakawan • Staff</span>
                    </div>
                </div>

                <a href="/profile-petugas" title="Pengaturan Profil" class="w-8 h-8 rounded-lg flex items-center justify-center text-slate-400 hover:text-blue-600 hover:bg-white transition-all flex-shrink-0 border border-transparent hover:border-slate-200">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                </a>
            </div>

            {{-- 3. Scrollable Navigation Menu --}}
            <div class="mt-4 flex-1 overflow-y-auto pr-1 space-y-5">
                {{-- GROUP 1: SIRKULASI & OPERASIONAL --}}
                <div>
                    <span class="text-[10px] font-bold tracking-wider text-slate-400 uppercase px-2 block mb-1.5">Sirkulasi Utama</span>
                    <ul class="space-y-1">
                        <li>
                            <a href="/dashboard-petugas"
                                class="{{ request()->is('dashboard-petugas*') ? 'bg-blue-50 text-blue-600 font-semibold border border-blue-200/80' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-50' }} flex items-center gap-3 px-3 py-2 rounded-xl text-sm transition-all">
                                <div class="w-5 h-5 flex items-center justify-center flex-shrink-0">
                                    <svg class="w-4 h-4 {{ request()->is('dashboard-petugas*') ? 'text-blue-600' : 'text-slate-400' }}" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6A2.25 2.25 0 016 3.75h2.25A2.25 2.25 0 0110.5 6v2.25a2.25 2.25 0 01-2.25 2.25H6a2.25 2.25 0 01-2.25-2.25V6zM3.75 15.75A2.25 2.25 0 016 13.5h2.25a2.25 2.25 0 012.25 2.25V18a2.25 2.25 0 01-2.25 2.25H6A2.25 2.25 0 013.75 18v-2.25zM13.5 6a2.25 2.25 0 012.25-2.25H18A2.25 2.25 0 0120.25 6v2.25A2.25 2.25 0 0118 10.5h-2.25a2.25 2.25 0 01-2.25-2.25V6zM13.5 15.75a2.25 2.25 0 012.25-2.25H18a2.25 2.25 0 012.25 2.25V18A2.25 2.25 0 0118 20.25h-2.25A2.25 2.25 0 0113.5 18v-2.25z" />
                                    </svg>
                                </div>
                                <span>Dashboard</span>
                            </a>
                        </li>
                        <li>
                            <a href="/pengajuan"
                                class="{{ request()->is('pengajuan*') ? 'bg-blue-50 text-blue-600 font-semibold border border-blue-200/80' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-50' }} flex items-center justify-between px-3 py-2 rounded-xl text-sm transition-all">
                                <div class="flex items-center gap-3">
                                    <div class="w-5 h-5 flex items-center justify-center flex-shrink-0">
                                        <svg class="w-4 h-4 {{ request()->is('pengajuan*') ? 'text-blue-600' : 'text-slate-400' }}" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                    </div>
                                    <span>Konfirmasi Pinjaman</span>
                                </div>
                                @if($pendingPengajuan > 0)
                                    <span class="text-xs font-bold px-2 py-0.5 rounded-full bg-amber-100 text-amber-700 border border-amber-200">
                                        {{ $pendingPengajuan }}
                                    </span>
                                @endif
                            </a>
                        </li>
                        <li>
                            <a href="/pengembalian"
                                class="{{ request()->is('pengembalian*') ? 'bg-blue-50 text-blue-600 font-semibold border border-blue-200/80' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-50' }} flex items-center gap-3 px-3 py-2 rounded-xl text-sm transition-all">
                                <div class="w-5 h-5 flex items-center justify-center flex-shrink-0">
                                    <svg class="w-4 h-4 {{ request()->is('pengembalian*') ? 'text-blue-600' : 'text-slate-400' }}" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 15L3 9m0 0l6-6M3 9h12a6 6 0 010 12h-3" />
                                    </svg>
                                </div>
                                <span>Terima Pengembalian</span>
                            </a>
                        </li>
                        <li>
                            <a href="/pembayaran"
                                class="{{ request()->is('pembayaran*') ? 'bg-blue-50 text-blue-600 font-semibold border border-blue-200/80' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-50' }} flex items-center gap-3 px-3 py-2 rounded-xl text-sm transition-all">
                                <div class="w-5 h-5 flex items-center justify-center flex-shrink-0">
                                    <svg class="w-4 h-4 {{ request()->is('pembayaran*') ? 'text-blue-600' : 'text-slate-400' }}" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18.75a60.07 60.07 0 0115.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 013 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75m-1.5-1.5h.375c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125h-.375m1.5-1.5H21a.75.75 0 00-.75.75v.75m0 0H3.75m0 0h-.375a1.125 1.125 0 01-1.125-1.125V15m1.5 1.5v-.75A.75.75 0 003 15h-.75M15 10.5a3 3 0 11-6 0 3 3 0 016 0zm3 0h.008v.008H18V10.5zm-12 0h.008v.008H6V10.5z" />
                                    </svg>
                                </div>
                                <span>Kasir Denda</span>
                            </a>
                        </li>
                    </ul>
                </div>

                {{-- GROUP 2: KATALOG & KOLEKSI --}}
                <div>
                    <span class="text-[10px] font-bold tracking-wider text-slate-400 uppercase px-2 block mb-1.5">Katalog & Koleksi</span>
                    <ul class="space-y-1">
                        <li>
                            <a href="/kelola-buku"
                                class="{{ request()->is('kelola-buku*') ? 'bg-blue-50 text-blue-600 font-semibold border border-blue-200/80' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-50' }} flex items-center gap-3 px-3 py-2 rounded-xl text-sm transition-all">
                                <div class="w-5 h-5 flex items-center justify-center flex-shrink-0">
                                    <svg class="w-4 h-4 {{ request()->is('kelola-buku*') ? 'text-blue-600' : 'text-slate-400' }}" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25" />
                                    </svg>
                                </div>
                                <span>Daftar Buku</span>
                            </a>
                        </li>
                        <li>
                            <a href="/koleksi-skripsi"
                                class="{{ request()->is('koleksi-skripsi*') ? 'bg-blue-50 text-blue-600 font-semibold border border-blue-200/80' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-50' }} flex items-center gap-3 px-3 py-2 rounded-xl text-sm transition-all">
                                <div class="w-5 h-5 flex items-center justify-center flex-shrink-0">
                                    <svg class="w-4 h-4 {{ request()->is('koleksi-skripsi*') ? 'text-blue-600' : 'text-slate-400' }}" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M4.26 10.147a60.436 60.436 0 00-.491 6.347A48.627 48.627 0 0112 20.904a48.627 48.627 0 018.232-4.41 60.46 60.46 0 00-.491-6.347m-15.482 0a50.57 50.57 0 00-2.658-.813A59.905 59.905 0 0112 3.493a59.902 59.902 0 0110.399 5.84c-.896.248-1.783.52-2.658.814m-15.482 0A50.697 50.697 0 0112 13.489a50.702 50.702 0 017.74-3.342M6.75 15a.75.75 0 100-1.5.75.75 0 000 1.5zm0 0v-3.675A55.378 55.378 0 0112 8.443m-7.007 11.55A5.981 5.981 0 006.75 15.75v-1.5" />
                                    </svg>
                                </div>
                                <span>Koleksi Skripsi</span>
                            </a>
                        </li>
                        <li>
                            <a href="/log-ebook"
                                class="{{ request()->is('log-ebook*') ? 'bg-blue-50 text-blue-600 font-semibold border border-blue-200/80' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-50' }} flex items-center gap-3 px-3 py-2 rounded-xl text-sm transition-all">
                                <div class="w-5 h-5 flex items-center justify-center flex-shrink-0">
                                    <svg class="w-4 h-4 {{ request()->is('log-ebook*') ? 'text-blue-600' : 'text-slate-400' }}" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3" />
                                    </svg>
                                </div>
                                <span>Log E-Book</span>
                            </a>
                        </li>
                        <li>
                            <a href="/petugas/daftar-penerbit"
                                class="{{ request()->is('petugas/daftar-penerbit*') ? 'bg-blue-50 text-blue-600 font-semibold border border-blue-200/80' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-50' }} flex items-center gap-3 px-3 py-2 rounded-xl text-sm transition-all">
                                <div class="w-5 h-5 flex items-center justify-center flex-shrink-0">
                                    <svg class="w-4 h-4 {{ request()->is('petugas/daftar-penerbit*') ? 'text-blue-600' : 'text-slate-400' }}" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 21v-7.5a.75.75 0 01.75-.75h3a.75.75 0 01.75.75V21m-4.5 0H2.36m11.14 0H18m0 0h3.64m-1.39 0V9.349m-16.5 11.65V9.35m0 0a3.001 3.001 0 003.75-.614A2.993 2.993 0 009.75 9.75c.896 0 1.7-.393 2.25-1.016a2.993 2.993 0 002.25 1.016c.896 0 1.7-.393 2.25-1.015a3.001 3.001 0 003.75.614m-16.5 0a3.004 3.004 0 01-.621-4.72L4.318 3.44A1.5 1.5 0 015.378 3h13.243a1.5 1.5 0 011.06.44l1.19 1.189a3 3 0 01-.621 4.72m-13.5 8.65h3.75a.75.75 0 00.75-.75V13.5a.75.75 0 00-.75-.75H6.75a.75.75 0 00-.75.75v3.75c0 .414.336.75.75.75z" />
                                    </svg>
                                </div>
                                <span>Daftar Penerbit</span>
                            </a>
                        </li>
                    </ul>
                </div>

                {{-- GROUP 3: LAYANAN & PENGUNJUNG --}}
                <div>
                    <span class="text-[10px] font-bold tracking-wider text-slate-400 uppercase px-2 block mb-1.5">Layanan & Tamu</span>
                    <ul class="space-y-1">
                        <li>
                            <a href="/petugas/daftar-tamu"
                                class="{{ request()->is('petugas/daftar-tamu*') ? 'bg-blue-50 text-blue-600 font-semibold border border-blue-200/80' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-50' }} flex items-center gap-3 px-3 py-2 rounded-xl text-sm transition-all">
                                <div class="w-5 h-5 flex items-center justify-center flex-shrink-0">
                                    <svg class="w-4 h-4 {{ request()->is('petugas/daftar-tamu*') ? 'text-blue-600' : 'text-slate-400' }}" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" />
                                    </svg>
                                </div>
                                <span>Buku Tamu</span>
                            </a>
                        </li>
                        <li>
                            <a href="/kelola-meja"
                                class="{{ request()->is('kelola-meja*') ? 'bg-blue-50 text-blue-600 font-semibold border border-blue-200/80' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-50' }} flex items-center gap-3 px-3 py-2 rounded-xl text-sm transition-all">
                                <div class="w-5 h-5 flex items-center justify-center flex-shrink-0">
                                    <svg class="w-4 h-4 {{ request()->is('kelola-meja*') ? 'text-blue-600' : 'text-slate-400' }}" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 9h16.5m-16.5 6.75h16.5M3.75 19.5h16.5M5.625 4.5h12.75a1.875 1.875 0 010 3.75H5.625a1.875 1.875 0 010-3.75z" />
                                    </svg>
                                </div>
                                <span>Manajemen Meja</span>
                            </a>
                        </li>
                        <li>
                            <a href="/laporan"
                                class="{{ request()->is('laporan*') ? 'bg-blue-50 text-blue-600 font-semibold border border-blue-200/80' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-50' }} flex items-center gap-3 px-3 py-2 rounded-xl text-sm transition-all">
                                <div class="w-5 h-5 flex items-center justify-center flex-shrink-0">
                                    <svg class="w-4 h-4 {{ request()->is('laporan*') ? 'text-blue-600' : 'text-slate-400' }}" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m2.25 0H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                                    </svg>
                                </div>
                                <span>Laporan Sirkulasi</span>
                            </a>
                        </li>
                        <li>
                            <a href="/aktivitas"
                                class="{{ request()->is('aktivitas*') ? 'bg-blue-50 text-blue-600 font-semibold border border-blue-200/80' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-50' }} flex items-center gap-3 px-3 py-2 rounded-xl text-sm transition-all">
                                <div class="w-5 h-5 flex items-center justify-center flex-shrink-0">
                                    <svg class="w-4 h-4 {{ request()->is('aktivitas*') ? 'text-blue-600' : 'text-slate-400' }}" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                                <span>Aktivitas Saya</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        {{-- 4. Tombol Logout Petugas --}}
        <div class="pt-3 border-t border-slate-200">
            <button class="btn_open_modal flex items-center justify-between w-full px-4 py-2.5 rounded-xl text-sm font-semibold text-rose-600 bg-rose-50 hover:bg-rose-100 border border-rose-200/80 transition-all cursor-pointer">
                <div class="flex items-center gap-2.5">
                    <svg class="w-4 h-4 text-rose-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15M12 9l-3 3m0 0l3 3m-3-3h12.75" />
                    </svg>
                    <span>Keluar Akun</span>
                </div>
            </button>
        </div>
    </section>

    {{-- Modal Logout Khusus Petugas --}}
    <section class="open_modal hidden fixed inset-0 bg-slate-900/60 backdrop-blur-xs flex justify-center items-center z-50 p-4">
        <div class="bg-white border border-slate-200 p-7 w-full max-w-sm rounded-2xl shadow-2xl text-center animate-in fade-in zoom-in-95 duration-150">
            <div class="w-14 h-14 rounded-2xl bg-rose-50 border border-rose-100 flex items-center justify-center text-rose-600 mx-auto mb-4">
                <svg class="w-7 h-7" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15M12 9l-3 3m0 0l3 3m-3-3h12.75" />
                </svg>
            </div>
            <h3 class="text-slate-900 font-bold text-lg">Konfirmasi Keluar</h3>
            <p class="text-slate-500 text-xs mt-1 mb-6">Apakah Anda yakin ingin mengakhiri sesi kerja petugas perpustakaan?</p>

            <div class="flex items-center gap-2.5">
                <button type="button" class="btn_close flex-1 border border-slate-200 hover:bg-slate-50 text-slate-700 py-2.5 px-4 rounded-xl font-semibold text-xs transition cursor-pointer">
                    Batal
                </button>

                <form action="/logout" method="POST" class="flex-1">
                    @csrf
                    <button type="submit" class="w-full bg-rose-600 hover:bg-rose-700 text-white py-2.5 px-4 rounded-xl font-semibold text-xs shadow-xs transition cursor-pointer">
                        Ya, Keluar
                    </button>
                </form>
            </div>
        </div>
    </section>

@else
    {{-- ═════════════════════════════════════════════════════════════════════════ --}}
    {{-- PETUGAS & ANGGOTA ORIGINAL SIDEBAR (CLASSIC LIGHT MODE)                 --}}
    {{-- ═════════════════════════════════════════════════════════════════════════ --}}
    <section id="sidebar-nav" class="bg-[#FFFFFF] w-full max-w-[316px] h-screen px-10 py-8 relative">
        {{-- Logo --}}
        <div class="flex items-center gap-3">
            <div class="flex-shrink-0">
                <img src="{{ asset('icons/logo.png') }}" alt="logo">
            </div>
            <div class="flex flex-col">
                <span class="text-[22px] text-[#35094D] font-medium leading-none">Perpustakaaan</span>
                <span class="text-[16px] text-[#35094D] mt-1">Saya</span>
            </div>
        </div>

        {{-- Keterangan Masuk Sebagai --}}
        <div class="mt-10 flex items-center gap-4 border border-gray-200 rounded-2xl p-3">
            <div class="flex-shrink-0">
                <img src="{{ asset('icons/svg/default-profile-sidebar.svg') }}" alt="profile">
            </div>
            <div class="flex flex-col overflow-hidden">
                <span class="text-[14px] font-medium text-[#35094D]">Anda Masuk Sebagai :</span>
                <span class="text-[10px] text-[#35094d90] capitalize truncate">
                    {{ Auth::user()->username }} - {{ ['petugas' => 'Pustakawan', 'anggota' => 'Anggota'][Auth::user()->role] ?? Auth::user()->role }}#{{ Auth::user()->id }}
                </span>
            </div>
        </div>

        {{-- List Menu --}}
        <div class="my-5 overflow-y-auto max-h-[calc(100vh-350px)]">
            {{-- UMUM --}}
            <div class="mb-5">
                <span class="text-[10px] font-medium text-[#35094d90]">UMUM</span>
                <ul class="mt-2 space-y-4">
                    {{-- Dashboard Anggota --}}
                    @role('anggota')
                        <li>
                            <a href="/dashboard-anggota"
                                class="{{ request()->is('dashboard-anggota*') ? 'text-[#35094D] font-semibold' : 'text-[#35094d90]' }} flex items-center gap-2 text-[16px]">
                                <div class="w-6 h-6 flex items-center justify-center">
                                    <img src="{{ request()->is('dashboard-anggota*') ? asset('icons/svg/dashboard-active.svg') : asset('icons/svg/dashboard-inactive.svg') }}"
                                        class="w-5 h-5 object-contain" alt="">
                                </div>
                                <span>Dashboard</span>
                            </a>
                        </li>
                        <li>
                            <a href="/daftar-buku"
                                class="{{ request()->is('daftar-buku*') ? 'text-[#35094D] font-semibold' : 'text-[#35094d90]' }} flex items-center gap-2 text-[16px]">
                                <div class="w-6 h-6 flex items-center justify-center">
                                    <img src="{{ request()->is('daftar-buku*') ? asset('icons/svg/buku-aktif.svg') : asset('icons/svg/buku-inactive.svg') }}"
                                        class="w-5 h-5 object-contain" alt="">
                                </div>
                                <span>Daftar Buku</span>
                            </a>
                        </li>
                        <li>
                            <a href="/e-book"
                                class="{{ request()->is('e-book*') ? 'text-[#35094D] font-semibold' : 'text-[#35094d90]' }} flex items-center gap-2 text-[16px]">
                                <div class="w-6 h-6 flex items-center justify-center">
                                    <img src="{{ request()->is('e-book*') ? asset('icons/svg/ebook-add-aktif.svg') : asset('icons/svg/ebook-add-inactive.svg') }}"
                                        class="w-5 h-5 object-contain" alt="E-Book">
                                </div>
                                <span>E-Book</span>
                            </a>
                        </li>
                        <li>
                            <a href="/cari-skripsi"
                                class="{{ request()->is('koleksi-skripsi*') ? 'text-[#35094D] font-semibold' : 'text-[#35094d90]' }} flex items-center gap-2 text-[16px]">
                                <div class="w-6 h-6 flex items-center justify-center">
                                    <img src="{{ request()->is('cari-skripsi*') ? asset('icons/svg/skripsi-aktif.svg') : asset('icons/svg/skripsi-inactive.svg') }}"
                                        class="w-5 h-5 object-contain" alt="Cari Skripsi">
                                </div>
                                <span>Cari Skripsi</span>
                            </a>
                        </li>
                    @endrole

                    {{-- Dashboard Petugas --}}
                    @role('petugas')
                        <li>
                            <a href="/dashboard-petugas"
                                class="{{ request()->is('dashboard-petugas*') ? 'text-[#35094D] font-semibold' : 'text-[#35094d90]' }} flex items-center gap-2 text-[16px]">
                                <div class="w-6 h-6 flex items-center justify-center">
                                    <img src="{{ request()->is('dashboard-petugas*') ? asset('icons/svg/dashboard-active.svg') : asset('icons/svg/dashboard-inactive.svg') }}"
                                        class="w-5 h-5 object-contain" alt="">
                                </div>
                                <span>Dashboard</span>
                            </a>
                        </li>
                    @endrole
                </ul>
            </div>

            {{-- PENGAJUAN PETUGAS --}}
            @role('petugas')
                <div class="mb-5">
                    <span class="text-[10px] font-medium text-[#35094d90]">PENGAJUAN</span>
                    <ul class="mt-2 space-y-4">
                        <li>
                            <a href="/pengajuan"
                                class="{{ request()->is('pengajuan*') ? 'text-[#35094D] font-semibold' : 'text-[#35094d90]' }} flex items-center gap-2 text-[16px]">
                                <div class="w-6 h-6 flex items-center justify-center">
                                    <img src="{{ request()->is('pengajuan*') ? asset('icons/svg/transaksi-aktif.svg') : asset('icons/svg/transaksi-inaktif.svg') }}"
                                        class="w-6 h-6 object-contain" alt="">
                                </div>
                                <span>Pengajuan</span>
                            </a>
                        </li>
                        <li>
                            <a href="/pengembalian"
                                class="{{ request()->is('pengembalian*') ? 'text-[#35094D] font-semibold' : 'text-[#35094d90]' }} flex items-center gap-2 text-[16px]">
                                <div class="w-6 h-6 flex items-center justify-center">
                                    <img src="{{ request()->is('pengembalian*') ? asset('icons/svg/transaksi-aktif.svg') : asset('icons/svg/transaksi-inaktif.svg') }}"
                                        class="w-6 h-6 object-contain rotate-180" alt="">
                                </div>
                                <span>Pengembalian</span>
                            </a>
                        </li>
                        <li>
                            <a href="/pembayaran"
                                class="{{ request()->is('pembayaran*') ? 'text-[#35094D] font-semibold' : 'text-[#35094d90]' }} flex items-center gap-2 text-[16px]">
                                <div class="w-6 h-6 flex items-center justify-center">
                                    <img src="{{ request()->is('pembayaran*') ? asset('icons/svg/payment-aktif.svg') : asset('icons/svg/payment-inaktif.svg') }}"
                                        class="w-5 h-5 object-contain" alt="">
                                </div>
                                <span>Pembayaran</span>
                            </a>
                        </li>
                        <span class="text-[10px] font-medium text-[#35094d90]">DATA BUKU</span>
                        <li class="mt-2">
                            <a href="/kelola-buku"
                                class="{{ request()->is('kelola-buku*') ? 'text-[#35094D] font-semibold' : 'text-[#35094d90]' }} flex items-center gap-2 text-[16px]">
                                <div class="w-6 h-6 flex items-center justify-center">
                                    <img src="{{ request()->is('kelola-buku*') ? asset('icons/svg/buku-aktif.svg') : asset('icons/svg/buku-inactive.svg') }}"
                                        class="w-5 h-5 object-contain" alt="">
                                </div>
                                <span>Daftar Buku</span>
                            </a>
                        </li>
                        <li class="mt-2">
                            <a href="/koleksi-skripsi"
                                class="{{ request()->is('koleksi-skripsi*') ? 'text-[#35094D] font-semibold' : 'text-[#35094d90]' }} flex items-center gap-2 text-[16px]">
                                <div class="w-6 h-6 flex items-center justify-center">
                                    <img src="{{ asset('icons/svg/skripsi-aktif.svg') }}" class="w-5 h-5 object-contain"
                                        alt="Skripsi">
                                </div>
                                <span>Koleksi Skripsi</span>
                            </a>
                        </li>
                        <li class="mt-2">
                            <a href="/log-ebook"
                                class="{{ request()->is('log-ebook*') ? 'text-[#35094D] font-semibold' : 'text-[#35094d90]' }} flex items-center gap-2 text-[16px]">
                                <div class="w-6 h-6 flex items-center justify-center">
                                    <img src="{{ asset('icons/svg/ebook-add-aktif.svg') }}" class="w-5 h-5 object-contain"
                                        alt="Log E-Book">
                                </div>
                                <span>Log E-Book</span>
                            </a>
                        </li>
                        <li class="mt-2">
                            <a href="/petugas/daftar-penerbit"
                                class="{{ request()->is('petugas/daftar-penerbit*') ? 'text-[#35094D] font-semibold' : 'text-[#35094d90]' }} flex items-center gap-2 text-[16px]">
                                <div class="w-6 h-6 flex items-center justify-center">
                                    <img src="{{ asset('icons/svg/penerbit-aktif.svg') }}" class="w-5 h-5 object-contain"
                                        alt="Daftar Penerbit">
                                </div>
                                <span>Daftar Penerbit</span>
                            </a>
                        </li>
                    </ul>
                </div>
            @endrole

            {{-- TRANSAKSI ANGGOTA --}}
            @role('anggota')
                <div class="mb-5">
                    <span class="text-[10px] font-medium text-[#35094d90]">TRANSAKSI</span>
                    <ul class="mt-2 space-y-4">
                        <li>
                            <a href="/riwayat-pinjaman"
                                class="{{ request()->is('riwayat-pinjaman') ? 'text-[#35094D] font-semibold' : 'text-[#35094d90]' }} flex items-center gap-2 text-[16px]">
                                <div class="w-6 h-6 flex items-center justify-center">
                                    <img src="{{ request()->is('riwayat-pinjaman') ? asset('icons/svg/riwayat-pinjaman-aktif.svg') : asset('icons/svg/riwayat-pinjaman-inactive.svg') }}"
                                        class="w-7 h-7 object-contain" alt="">
                                </div>
                                <span>Riwayat Peminjaman</span>
                            </a>
                        </li>
                        <li>
                            <a href="/denda-anggota"
                                class="{{ request()->is('denda-anggota*') ? 'text-[#35094D] font-semibold' : 'text-[#35094d90]' }} flex items-center gap-2 text-[16px]">
                                <div class="w-6 h-6 flex items-center justify-center">
                                    <img src="{{ request()->is('denda-anggota*') ? asset('icons/svg/payment-aktif.svg') : asset('icons/svg/payment-inaktif.svg') }}"
                                        class="w-5 h-5 object-contain" alt="">
                                </div>
                                <span>Denda Saya</span>
                            </a>
                        </li>
                    </ul>
                </div>
            @endrole

            {{-- LAINNYA --}}
            <div>
                <span class="text-[10px] font-medium text-[#35094d90]">LAINNYA</span>
                <ul class="mt-2 space-y-4">
                    @role('petugas')
                        <li>
                            <a href="/daftar-pengunjung"
                                class="{{ request()->is('daftar-pengunjung*') ? 'text-[#35094D] font-semibold' : 'text-[#35094d90]' }} flex items-center gap-2 text-[16px]">
                                <div class="w-6 h-6 flex items-center justify-center">
                                    <img src="{{ request()->is('daftar-pengunjung*') ? asset('icons/svg/pengguna-aktif.svg') : asset('icons/svg/pengguna-inaktif.svg') }}"
                                        class="w-5 h-5 object-contain" alt="">
                                </div>
                                <span>Daftar Tamu</span>
                            </a>
                        </li>
                        <li>
                            <a href="/aktivitas"
                                class="{{ request()->is('aktivitas*') ? 'text-[#35094D] font-semibold' : 'text-[#35094d90]' }} flex items-center gap-2 text-[16px]">
                                <div class="w-6 h-6 flex items-center justify-center">
                                    <img src="{{ request()->is('aktivitas*') ? asset('icons/svg/activity-aktif.svg') : asset('icons/svg/aktifity-inaktif.svg') }}"
                                        class="w-8 h-8 object-contain" alt="">
                                </div>
                                <span>Aktivitas Saya</span>
                            </a>
                        </li>
                        <li>
                            <a href="/laporan"
                                class="{{ request()->is('laporan*') ? 'text-[#35094D] font-semibold' : 'text-[#35094d90]' }} flex items-center gap-2 text-[16px]">
                                <div class="w-6 h-6 flex items-center justify-center">
                                    <img src="{{ request()->is('laporan*') ? asset('icons/svg/laporan-aktif.svg') : asset('icons/svg/laporan-inaktif.svg') }}"
                                        class="w-5 h-5 object-contain" alt="">
                                </div>
                                <span>Laporan</span>
                            </a>
                        </li>
                        <li>
                            <a href="/kelola-meja"
                                class="{{ request()->is('kelola-meja*') ? 'text-[#35094D] font-semibold' : 'text-[#35094d90]' }} flex items-center gap-2 text-[16px]">
                                <div class="w-6 h-6 flex items-center justify-center">
                                    <img src="https://api.iconify.design/ri:table-fill.svg?color=%2335094D"
                                        class="w-5 h-5 object-contain" alt="Manajemen Meja">
                                </div>
                                <span>Manajemen Meja</span>
                            </a>
                        </li>
                        <li>
                            <a href="/profile-petugas"
                                class="{{ request()->is('profile-petugas*') ? 'text-[#35094D] font-semibold' : 'text-[#35094d90]' }} flex items-center gap-2 text-[16px]">
                                <div class="w-6 h-6 flex items-center justify-center">
                                    <img src="{{ request()->is('profile-petugas*') ? asset('icons/svg/profile-aktif.svg') : asset('icons/svg/profile-inactive.svg') }}"
                                        class="w-6 h-6 object-contain" alt="">
                                </div>
                                <span>Profile</span>
                            </a>
                        </li>
                    @endrole

                    @role('anggota')
                        <li>
                            <a href="/profile-anggota"
                                class="{{ request()->is('profile-anggota*') ? 'text-[#35094D] font-semibold' : 'text-[#35094d90]' }} flex items-center gap-2 text-[16px]">
                                <div class="w-6 h-6 flex items-center justify-center">
                                    <img src="{{ request()->is('profile-aktif.svg') ? asset('icons/svg/profile-aktif.svg') : asset('icons/svg/profile-inactive.svg') }}"
                                        class="w-6 h-6 object-contain" alt="">
                                </div>
                                <span>Profile</span>
                            </a>
                        </li>
                        <li class="relative">
                            @php
                                $user = Auth::user();
                                $pemberitahuan = $user->Anggota->pemberitahuan ?? collect();
                                $belumDilihat = $pemberitahuan->where('sudah_dilihat', false)->count();
                            @endphp
                            <a href="/pemberitahuan"
                                class="{{ request()->is('pemberitahuan*') ? 'text-[#35094D] font-semibold' : 'text-[#35094d90]' }} flex items-center gap-2 text-[16px]">
                                <div class="w-6 h-6 flex items-center justify-center">
                                    <img src="{{ request()->is('pemberitahuan*') ? asset('icons/svg/lonceng-aktif.svg') : asset('icons/svg/lonceng-inactive.svg') }}"
                                        class="w-5 h-5 object-contain" alt="">
                                </div>
                                <span>Pemberitahuan</span>
                                @if ($belumDilihat > 0)
                                    <span class="text-xs bg-red-500 text-white px-2 py-0.5 rounded-full">
                                        {{ $belumDilihat }}
                                    </span>
                                @endif
                            </a>
                        </li>
                    @endrole
                </ul>
            </div>
        </div>

        {{-- Original Logout Button for Petugas/Anggota --}}
        <div class="absolute bottom-8 left-10 right-10">
            <button
                class="btn_open_modal flex items-center justify-between bg-[#35094D] w-full rounded-2xl p-3 text-[16px] text-white cursor-pointer hover:bg-[#2a073d] transition-colors">
                <img src="{{ asset('icons/svg/sign-out.svg') }}" class="w-5 h-5" alt="">
                <span class="font-medium">Keluar</span>
                <div class="w-5 h-5"></div>
            </button>
        </div>

        {{-- Original Modal Logout --}}
        <section class="open_modal hidden fixed inset-0 bg-black/40 backdrop-blur-sm flex justify-center items-center z-50">
            <div class="bg-white p-8 w-full max-w-md rounded-2xl shadow-xl">
                <div class="flex flex-col items-center text-center gap-4">
                    <img class="w-20" src="{{ asset('icons/svg/warning.svg') }}" alt="warning">
                    <h3 class="text-[#35094D] font-bold text-xl">Yakin Ingin Keluar?</h3>
                    <p class="text-gray-500 text-sm">Anda harus login kembali untuk mengakses data perpustakaan.</p>
                </div>

                <div class="flex justify-center gap-3 mt-8">
                    <button
                        class="btn_close border border-[#35094D] text-[#35094D] px-6 py-2 rounded-2xl font-medium cursor-pointer">
                        Batal
                    </button>

                    <form id="logout_form" action="/logout" method="POST">
                        @csrf
                        <button type="submit" id="btn_logout"
                            class="bg-[#35094D] text-white px-6 py-2 rounded-2xl font-medium flex items-center justify-center gap-2 min-w-[130px] cursor-pointer">
                            <span id="text_logout">Ya, Keluar</span>
                            <svg id="spinner" class="hidden animate-spin h-5 w-5 text-white"
                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor"
                                    d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                </path>
                            </svg>
                        </button>
                    </form>
                </div>
            </div>
        </section>

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const openModalBtn = document.querySelector('.btn_open_modal');
                const closeModalBtn = document.querySelector('.btn_close');
                const modal = document.querySelector('.open_modal');

                openModalBtn?.addEventListener('click', () => modal?.classList.remove('hidden'));
                closeModalBtn?.addEventListener('click', () => modal?.classList.add('hidden'));

                const logoutForm = document.getElementById('logout_form');
                const btnLogout = document.getElementById('btn_logout');
                const spinner = document.getElementById('spinner');
                const textLogout = document.getElementById('text_logout');

                logoutForm?.addEventListener('submit', function() {
                    if (btnLogout) {
                        btnLogout.disabled = true;
                        btnLogout.classList.add('opacity-70', 'cursor-not-allowed');
                    }
                    closeModalBtn?.classList.add('invisible');
                    spinner?.classList.remove('hidden');
                    if (textLogout) textLogout.innerText = 'Tunggu...';
                });
            });
        </script>
    </section>
@endif
