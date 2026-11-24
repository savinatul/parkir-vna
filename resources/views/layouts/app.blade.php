<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>
        @yield('title', 'Admin - Parkir Ajaa')
    </title>

    <!-- MENGGUNAKAN TAILWIND VIA NPM VITE -->
    @vite('resources/css/app.css')

    <style>
        /* Kustomisasi Scrollbar */
        ::-webkit-scrollbar {
            width: 6px;
        }

        ::-webkit-scrollbar-track {
            background: #0e0b1a;
        }

        ::-webkit-scrollbar-thumb {
            background: #5b21b6;
            border-radius: 10px;
        }

        /* Efek glassmorphism untuk kartu statistik dashboard */
        .glass-card {
            background: rgba(22, 19, 48, 0.4);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border: 1px solid rgba(147, 51, 234, 0.2);
            box-shadow: 0 8px 32px 0 rgba(0, 0, 0, 0.37);
        }
    </style>
</head>

<body class="bg-[#0b0914] text-white antialiased">

<div class="min-h-screen flex">

    {{-- ================================================= --}}
    {{-- SIDEBAR --}}
    {{-- ================================================= --}}
    <aside class="w-64 bg-[#100c1d] border-r border-purple-900/30
                  fixed left-0 top-0 bottom-0
                  flex flex-col z-10">

        {{-- LOGO --}}
        <div class="h-20 px-6 flex items-center border-b border-purple-900/30">
            <div class="w-11 h-11 rounded-xl
                        bg-gradient-to-tr from-purple-600 to-indigo-500
                        flex items-center justify-center
                        font-bold text-xl shadow-lg">
                P
            </div>
            <div class="ml-3">
                <h1 class="font-bold text-white leading-tight">
                    Parkir Ajaa
                </h1>
                <p class="text-[11px] text-purple-400">
                    Management System
                </p>
            </div>
        </div>

        {{-- USER LOGIN --}}
        <div class="px-5 py-5 border-b border-purple-900/20">
            <div class="flex items-center">
                <div class="w-10 h-10 rounded-full
                            bg-purple-700
                            flex items-center justify-center
                            font-bold text-white shrink-0">
                    {{ strtoupper(substr(Auth::user()->nama_lengkap ?? 'A', 0, 1)) }}
                </div>
                <div class="ml-3 min-w-0">
                    <p class="text-sm font-semibold text-white truncate">
                        {{ Auth::user()->nama_lengkap ?? 'Admin' }}
                    </p>
                    <p class="text-xs text-purple-400">
                        {{ ucfirst(Auth::user()->role ?? 'admin') }}
                    </p>
                </div>
            </div>
        </div>

        {{-- MENU KONDISIONAL BERDASARKAN ROLE USER --}}
        <nav class="flex-1 overflow-y-auto px-4 py-5">
            @if(auth()->user()->role == 'admin')
                
                {{-- MENU UTAMA ADMIN --}}
                <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl mb-2 {{ request()->routeIs('admin.dashboard') ? 'bg-purple-700 text-white shadow-lg shadow-purple-950/40' : 'text-gray-400 hover:bg-purple-950/50 hover:text-white' }} transition">
                    <span class="text-lg">📊</span><span class="text-sm font-medium">Dashboard</span>
                </a>

                <p class="px-4 mt-6 mb-3 text-[10px] font-bold tracking-widest text-purple-400 uppercase">Master Data</p>

                <a href="{{ route('admin.user.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl mb-1 {{ request()->routeIs('admin.user.*') ? 'bg-purple-700 text-white' : 'text-gray-400 hover:bg-purple-950/50 hover:text-white' }} transition">
                    <span>👥</span><span class="text-sm">User</span>
                </a>
                <a href="{{ route('admin.kendaraan.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl mb-1 {{ request()->routeIs('admin.kendaraan.*') ? 'bg-purple-700 text-white' : 'text-gray-400 hover:bg-purple-950/50 hover:text-white' }} transition">
                    <span>🚗</span><span class="text-sm">Kendaraan</span>
                </a>
                <a href="{{ route('admin.area-parkir.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl mb-1 {{ request()->routeIs('admin.area-parkir.*') ? 'bg-purple-700 text-white' : 'text-gray-400 hover:bg-purple-950/50 hover:text-white' }} transition">
                    <span>🅿️</span><span class="text-sm">Area Parkir</span>
                </a>
                <a href="{{ route('admin.tarif.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl mb-1 {{ request()->routeIs('admin.tarif.*') ? 'bg-purple-700 text-white' : 'text-gray-400 hover:bg-purple-950/50 hover:text-white' }} transition">
                    <span>💰</span><span class="text-sm">Tarif</span>
                </a>

                <p class="px-4 mt-6 mb-3 text-[10px] font-bold tracking-widest text-purple-400 uppercase">Sistem</p>
                <a href="{{ route('admin.log.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl mb-1 {{ request()->routeIs('admin.log.*') ? 'bg-purple-700 text-white' : 'text-gray-400 hover:bg-purple-950/50 hover:text-white' }} transition">
                    <span>📝</span><span class="text-sm">Log Aktivitas</span>
                </a>

            @elseif(auth()->user()->role == 'owner')

                {{-- MENU UTAMA OWNER --}}
                <a href="{{ route('owner.dashboard') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl mb-2 {{ request()->routeIs('owner.dashboard') ? 'bg-purple-700 text-white shadow-lg' : 'text-gray-400 hover:bg-purple-950/50 hover:text-white' }} transition">
                    <span class="text-lg">📊</span><span class="text-sm font-medium">Dashboard</span>
                </a>

                <p class="px-4 mt-6 mb-3 text-[10px] font-bold tracking-widest text-purple-400 uppercase">Menu Owner</p>
                
                <a href="{{ route('owner.laporan.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl mb-1 {{ request()->routeIs('owner.laporan.*') ? 'bg-purple-700 text-white' : 'text-gray-400 hover:bg-purple-950/50 hover:text-white' }} transition">
                    <span>📈</span><span class="text-sm">Laporan</span>
                </a>

            @elseif(auth()->user()->role == 'petugas')

                {{-- MENU UTAMA PETUGAS --}}
                <a href="{{ route('petugas.dashboard') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl mb-2 {{ request()->routeIs('petugas.dashboard') ? 'bg-purple-700 text-white shadow-lg' : 'text-gray-400 hover:bg-purple-950/50 hover:text-white' }} transition">
                    <span class="text-lg">📊</span><span class="text-sm font-medium">Dashboard</span>
                </a>

                <p class="px-4 mt-6 mb-3 text-[10px] font-bold tracking-widest text-purple-400 uppercase">Menu Petugas</p>
                
                <a href="{{ route('petugas.transaksi.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl mb-1 {{ request()->routeIs('petugas.transaksi.*') ? 'bg-purple-700 text-white' : 'text-gray-400 hover:bg-purple-950/50 hover:text-white' }} transition">
                    <span>🔄</span><span class="text-sm">Transaksi</span>
                </a>

            @endif
        </nav>

        {{-- LOGOUT --}}
        <div class="p-4 border-t border-purple-900/30">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="w-full flex items-center gap-3 px-4 py-3 rounded-xl text-gray-400 hover:bg-rose-500/10 hover:text-rose-400 transition">
                    <span>🚪</span>
                    <span class="text-sm font-medium">Logout</span>
                </button>
            </form>
        </div>
    </aside>

    {{-- ================================================= --}}
    {{-- AREA KONTEN KANAN --}}
    {{-- ================================================= --}}
    <div class="flex-1 pl-64 flex flex-col min-h-screen">
        
        {{-- TOPBAR / HEADER HALAMAN DINAMIS --}}
        <header class="h-20 px-8 flex items-center justify-between border-b border-purple-900/30 bg-[#0c0917]/50 backdrop-blur-md sticky top-0 z-9">
            <div>
                <h2 class="text-xl font-bold text-white">@yield('page_title', 'Dashboard')</h2>
                <p class="text-xs text-purple-400">@yield('page_subtitle')</p>
            </div>
        </header>

        {{-- TEMPAT MASUK KONTEN UTAMA --}}
        <main class="flex-1 p-8">
            @yield('content')
        </main>

    </div>

</div>

</body>
</html>
