<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>MyLibrary - Perpustakaan Digital</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @auth
        @if(Auth::user()->role === 'kepala_perpus')
            <link rel="stylesheet" href="{{ asset('css/admin-dark.css') }}?v={{ file_exists(public_path('css/admin-dark.css')) ? filemtime(public_path('css/admin-dark.css')) : time() }}">
        @elseif(Auth::user()->role === 'petugas')
            <link rel="stylesheet" href="{{ asset('css/petugas-ui.css') }}?v={{ file_exists(public_path('css/petugas-ui.css')) ? filemtime(public_path('css/petugas-ui.css')) : time() }}">
        @elseif(Auth::user()->role === 'anggota')
            <link rel="stylesheet" href="{{ asset('css/anggota-ui.css') }}?v={{ file_exists(public_path('css/anggota-ui.css')) ? filemtime(public_path('css/anggota-ui.css')) : time() }}">
        @endif
    @endauth
    @yield('styles')

</head>

<body class="bg-[#F8FAFC] {{ Auth::check() && Auth::user()->role === 'kepala_perpus' ? 'admin-dark' : (Auth::check() && Auth::user()->role === 'petugas' ? 'petugas-mode' : (Auth::check() && Auth::user()->role === 'anggota' ? 'anggota-mode' : '')) }} @yield('body_class')">

    @auth
        @if(Auth::user()->role === 'anggota')
            {{-- Portal Web Navigation Bar untuk Anggota / Pembaca --}}
            @include('components.navbar-anggota')

            {{-- Main Content Anggota (Full-Width Portal Experience) --}}
            <main class="min-h-screen pt-20 pb-16 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                @yield('main')
            </main>

            {{-- Footer Portal --}}
            @include('components.footer-anggota')
        @else
            {{-- Back-office Sidebar untuk Kepala Perpustakaan & Petugas --}}
            <div class="fixed z-40">
                @include('components.sidebar')
            </div>

            {{-- Main Content Back-office --}}
            <main class="ml-80 min-h-screen p-6">
                @php
                    $role = Auth::user()->role;
                    if ($role === 'kepala_perpus') {
                        $nama = Auth::user()->KepalaPerpus->nama_lengkap ?? Auth::user()->username;
                    } elseif ($role === 'petugas') {
                        $nama = Auth::user()->Petugas->nama_lengkap ?? Auth::user()->username;
                    } else {
                        $nama = Auth::user()->username;
                    }
                @endphp
                <section>
                    <h1 class="text-[30px] text-[#35094D]">Hallo, <span class="font-semibold">{{ $nama }}</span></h1>
                    <span class="text-[#35094d90]">Selamat Datang Kembali Di Halaman <span
                            class="font-medium text-[#35094D]">@yield('halaman')</span> @yield('suffix')</span>
                </section>

                @yield('main')
            </main>
        @endif
    @else
        <main class="min-h-screen">
            @yield('main')
        </main>
    @endauth

    {{-- Modal alert --}}
    @include('components.alert-success')
    @include('components.alert-error')

    {{-- Loading Search --}}
    @include('components.loading-cari')

    {{-- Loading Sidebar Navigation --}}
    @include('components.loading-sidebar')

    <script src="{{ asset('js/script.js') }}"></script>
    @yield('scripts')
</body>

</html>
