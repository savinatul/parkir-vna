
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Parkir Ajaa</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-screen w-full flex items-center justify-center p-4 relative bg-[#0b0914]">

    {{-- Background gambar parkir --}}
    <div
        class="fixed inset-0 z-0 bg-cover bg-center bg-no-repeat"
        style="background-image: url('{{ asset('images/parkir.png') }}');"
        aria-hidden="true"
    ></div>

    {{-- Lapisan gelap transparan agar form tetap terbaca --}}
    <div
        class="fixed inset-0 z-0 bg-[#0b0914]/55"
        aria-hidden="true"
    ></div>

    {{-- Efek cahaya ungu --}}
    <div
        class="fixed inset-0 z-0 pointer-events-none"
        style="background: radial-gradient(ellipse at center, rgba(110, 40, 180, 0.12), transparent 70%);"
        aria-hidden="true"
    ></div>

    {{-- Kotak login --}}
    <div class="relative z-10 w-full max-w-md bg-[#19132b]/90 border border-purple-500/30 rounded-3xl p-8 lg:p-10 backdrop-blur-md shadow-2xl shadow-black/70">

        {{-- Header --}}
        <div class="text-center mb-8">
            <div class="w-14 h-14 bg-gradient-to-tr from-purple-600 to-indigo-500 text-white font-bold rounded-2xl flex items-center justify-center text-2xl shadow-xl shadow-purple-950/60 border border-purple-400/20 mx-auto mb-4">
                🅿️
            </div>

            <h1 class="font-bold text-2xl text-white tracking-wide">
                Parkir Ajaa
            </h1>

            <p class="text-xs text-purple-300 font-medium tracking-wider uppercase mt-1">
                Sistem Manajemen Parkir
            </p>

            <div class="w-12 h-0.5 bg-gradient-to-r from-purple-500 to-indigo-500 mx-auto mt-4 rounded-full"></div>
        </div>

        {{-- Form login --}}
        <form action="{{ route('login.process') }}" method="POST" class="space-y-5">
            @csrf

            {{-- Notifikasi logout --}}
            @if (session('status'))
                <div role="status" class="bg-emerald-500/10 border border-emerald-500/30 text-emerald-400 px-4 py-3 rounded-xl text-sm">
                    {{ session('status') }}
                </div>
            @endif

            {{-- Notifikasi error --}}
            @if (session('error'))
                <div role="alert" class="bg-rose-500/10 border border-rose-500/30 text-rose-400 px-4 py-3 rounded-xl text-sm">
                    {{ session('error') }}
                </div>
            @endif

            {{-- Notifikasi berhasil --}}
            @if (session('success'))
                <div role="status" class="bg-emerald-500/10 border border-emerald-500/30 text-emerald-400 px-4 py-3 rounded-xl text-sm">
                    {{ session('success') }}
                </div>
            @endif

            {{-- Validasi --}}
            @if ($errors->any())
                <div role="alert" class="bg-rose-500/10 border border-rose-500/30 text-rose-400 px-4 py-3 rounded-xl text-sm">
                    Periksa kembali data yang kamu masukkan.
                </div>
            @endif

            {{-- Username --}}
            <div>
                <label for="username" class="block text-xs font-semibold text-purple-200 uppercase tracking-wider mb-2">
                    Username
                </label>

                <input
                    id="username"
                    type="text"
                    name="username"
                    value="{{ old('username') }}"
                    placeholder="Masukkan username"
                    autocomplete="username"
                    required
                    autofocus
                    class="w-full px-5 py-3.5 rounded-xl bg-[#0e0b1a]/90 border border-purple-500/30 text-white text-sm focus:outline-none focus:border-purple-500 focus:ring-2 focus:ring-purple-500/30 transition-all placeholder-gray-500"
                >

                @error('username')
                    <p class="text-rose-400 text-xs mt-2 font-medium">
                        {{ $message }}
                    </p>
                @enderror
            </div>

            {{-- Password --}}
            <div>
                <label for="password" class="block text-xs font-semibold text-purple-200 uppercase tracking-wider mb-2">
                    Password
                </label>

                <input
                    id="password"
                    type="password"
                    name="password"
                    placeholder="Masukkan password"
                    autocomplete="current-password"
                    required
                    class="w-full px-5 py-3.5 rounded-xl bg-[#0e0b1a]/90 border border-purple-500/30 text-white text-sm focus:outline-none focus:border-purple-500 focus:ring-2 focus:ring-purple-500/30 transition-all placeholder-gray-500"
                >

                @error('password')
                    <p class="text-rose-400 text-xs mt-2 font-medium">
                        {{ $message }}
                    </p>
                @enderror
            </div>

            {{-- Ingat saya --}}
            <div class="flex items-center text-xs py-1">
                <label for="remember" class="flex items-center text-gray-300 cursor-pointer select-none">
                    <input
                        id="remember"
                        type="checkbox"
                        name="remember"
                        value="1"
                        @checked(old('remember'))
                        class="accent-purple-600 rounded mr-2 cursor-pointer w-4 h-4"
                    >
                    <span>Ingat saya</span>
                </label>
            </div>

            {{-- Tombol login --}}
            <button
                type="submit"
                class="w-full py-4 px-6 rounded-xl bg-gradient-to-r from-purple-600 to-indigo-600 text-white text-sm font-bold shadow-lg shadow-purple-950/50 hover:from-purple-500 hover:to-indigo-500 active:scale-[0.98] transition-all duration-200 uppercase tracking-wider border border-purple-400/20"
            >
                Login ke Sistem
            </button>
        </form>

        {{-- Footer --}}
        <div class="text-center text-[10px] text-gray-400 tracking-wide mt-8 pt-4 border-t border-purple-500/20">
            &copy; {{ date('Y') }} Parkir Ajaa. All rights reserved.
        </div>
    </div>

</body>
</html>
