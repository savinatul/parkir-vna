@extends('layouts.app')

@section('content')

<div class="p-6">

    <div class="mb-6">
        <h1 class="text-2xl font-bold text-white">Tambah User</h1>
        <p class="text-sm text-gray-400 mt-1">
            Tambahkan akun baru untuk sistem parkir
        </p>
    </div>

    <div class="max-w-3xl bg-[#120d20] border border-purple-900/30 rounded-2xl p-6">

        <form action="{{ route('admin.user.store') }}" method="POST" class="space-y-6">

            @csrf

            {{-- Nama --}}
            <div>
                <label class="block text-sm font-medium text-gray-300 mb-2">
                    Nama Lengkap
                </label>

                <input
                    type="text"
                    name="nama_lengkap"
                    value="{{ old('nama_lengkap') }}"
                    placeholder="Masukkan nama lengkap"
                    class="w-full px-4 py-3 rounded-xl bg-[#171326]
                           border border-purple-900/40 text-gray-200
                           focus:outline-none focus:border-purple-500
                           focus:ring-1 focus:ring-purple-500"
                >

                @error('nama_lengkap')
                    <p class="text-rose-400 text-xs mt-2">{{ $message }}</p>
                @enderror
            </div>

            {{-- Username --}}
            <div>
                <label class="block text-sm font-medium text-gray-300 mb-2">
                    Username
                </label>

                <input
                    type="text"
                    name="username"
                    value="{{ old('username') }}"
                    placeholder="Masukkan username"
                    class="w-full px-4 py-3 rounded-xl bg-[#171326]
                           border border-purple-900/40 text-gray-200
                           focus:outline-none focus:border-purple-500
                           focus:ring-1 focus:ring-purple-500"
                >

                @error('username')
                    <p class="text-rose-400 text-xs mt-2">{{ $message }}</p>
                @enderror
            </div>

            {{-- Password --}}
            <div>
                <label class="block text-sm font-medium text-gray-300 mb-2">
                    Password
                </label>

                <input
                    type="password"
                    name="password"
                    placeholder="Masukkan password"
                    class="w-full px-4 py-3 rounded-xl bg-[#171326]
                           border border-purple-900/40 text-gray-200
                           focus:outline-none focus:border-purple-500
                           focus:ring-1 focus:ring-purple-500"
                >

                @error('password')
                    <p class="text-rose-400 text-xs mt-2">{{ $message }}</p>
                @enderror
            </div>

            {{-- Role --}}
            <div>
                <label class="block text-sm font-medium text-gray-300 mb-2">
                    Role
                </label>

                <select
                    name="role"
                    class="w-full px-4 py-3 rounded-xl bg-[#171326]
                           border border-purple-900/40 text-gray-200
                           focus:outline-none focus:border-purple-500
                           focus:ring-1 focus:ring-purple-500"
                >
                    <option value="">-- Pilih Role --</option>

                    <option value="owner" {{ old('role') == 'owner' ? 'selected' : '' }}>
                        Owner
                    </option>

                    <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>
                        Admin
                    </option>

                    <option value="petugas" {{ old('role') == 'petugas' ? 'selected' : '' }}>
                        Petugas
                    </option>
                </select>

                @error('role')
                    <p class="text-rose-400 text-xs mt-2">{{ $message }}</p>
                @enderror
            </div>

            {{-- Status --}}
            <div>
                <label class="block text-sm font-medium text-gray-300 mb-2">
                    Status
                </label>

                <select
                    name="status_aktif"
                    class="w-full px-4 py-3 rounded-xl bg-[#171326]
                           border border-purple-900/40 text-gray-200
                           focus:outline-none focus:border-purple-500
                           focus:ring-1 focus:ring-purple-500"
                >
                    <option value="">-- Pilih Status --</option>

                    <option value="1" {{ old('status_aktif') == '1' ? 'selected' : '' }}>
                        Aktif
                    </option>

                    <option value="0" {{ old('status_aktif') == '0' ? 'selected' : '' }}>
                        Nonaktif
                    </option>
                </select>

                @error('status_aktif')
                    <p class="text-rose-400 text-xs mt-2">{{ $message }}</p>
                @enderror
            </div>

            {{-- Tombol --}}
            <div class="flex justify-end gap-3 pt-4">

                <a href="{{ route('admin.user.index') }}"
                   class="px-5 py-3 rounded-xl bg-gray-700/50
                          text-gray-300 hover:bg-gray-700 transition">
                    Batal
                </a>

                <button
                    type="submit"
                    class="px-6 py-3 rounded-xl
                           bg-gradient-to-r from-purple-600 to-indigo-600
                           text-white font-semibold
                           hover:brightness-110 transition"
                >
                    Simpan User
                </button>

            </div>

        </form>

    </div>

</div>

@endsection