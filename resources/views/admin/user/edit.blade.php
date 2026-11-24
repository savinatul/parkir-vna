
@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-[#0b0814] px-6 py-10 text-white md:px-12">
    <div class="mx-auto max-w-4xl">
        <h1 class="text-2xl font-bold">Edit User</h1>
        <p class="mb-6 text-sm text-gray-400">
            Ubah informasi akun user
        </p>

        <div class="rounded-2xl border border-purple-900/60 bg-[#130d20] p-6 md:p-8">
            <form
                action="{{ route('admin.user.update', $user->id_user) }}"
                method="POST"
                class="space-y-5"
            >
                @csrf
                @method('PUT')

                {{-- Nama Lengkap --}}
                <div>
                    <label for="nama_lengkap"
                        class="mb-2 block text-sm font-medium">
                        Nama Lengkap
                    </label>
                    <input
                        type="text"
                        id="nama_lengkap"
                        name="nama_lengkap"
                        value="{{ old('nama_lengkap', $user->nama_lengkap) }}"
                        required
                        class="w-full rounded-xl border border-purple-900/70 bg-[#1b1329] px-4 py-3 text-white outline-none transition focus:border-purple-500 focus:ring-2 focus:ring-purple-500/20"
                    >
                    @error('nama_lengkap')
                        <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Username --}}
                <div>
                    <label for="username"
                        class="mb-2 block text-sm font-medium">
                        Username
                    </label>
                    <input
                        type="text"
                        id="username"
                        name="username"
                        value="{{ old('username', $user->username) }}"
                        required
                        class="w-full rounded-xl border border-purple-900/70 bg-[#1b1329] px-4 py-3 text-white outline-none transition focus:border-purple-500 focus:ring-2 focus:ring-purple-500/20"
                    >
                    @error('username')
                        <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Password Baru --}}
                <div>
                    <label for="password"
                        class="mb-2 block text-sm font-medium">
                        Password Baru
                    </label>
                    <input
                        type="password"
                        id="password"
                        name="password"
                        minlength="6"
                        autocomplete="new-password"
                        placeholder="Kosongkan jika tidak ingin mengganti password"
                        class="w-full rounded-xl border border-purple-900/70 bg-[#1b1329] px-4 py-3 text-white outline-none transition placeholder:text-gray-500 focus:border-purple-500 focus:ring-2 focus:ring-purple-500/20"
                    >
                    <p class="mt-2 text-xs text-gray-400">
                        Kosongkan jika password tidak ingin diubah.
                    </p>
                    @error('password')
                        <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Role --}}
                <div>
                    <label for="role"
                        class="mb-2 block text-sm font-medium">
                        Role
                    </label>
                    <select
                        id="role"
                        name="role"
                        required
                        class="w-full rounded-xl border border-purple-900/70 bg-[#1b1329] px-4 py-3 text-white outline-none focus:border-purple-500"
                    >
                        <option value="owner"
                            @selected(old('role', $user->role) === 'owner')>
                            Owner
                        </option>
                        <option value="admin"
                            @selected(old('role', $user->role) === 'admin')>
                            Admin
                        </option>
                        <option value="petugas"
                            @selected(old('role', $user->role) === 'petugas')>
                            Petugas
                        </option>
                    </select>
                    @error('role')
                        <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Status --}}
                <div>
                    <label for="status_aktif"
                        class="mb-2 block text-sm font-medium">
                        Status
                    </label>
                    <select
                        id="status_aktif"
                        name="status_aktif"
                        required
                        class="w-full rounded-xl border border-purple-900/70 bg-[#1b1329] px-4 py-3 text-white outline-none focus:border-purple-500"
                    >
                        <option value="1"
                            @selected((string) old('status_aktif', $user->status_aktif) === '1')>
                            Aktif
                        </option>
                        <option value="0"
                            @selected((string) old('status_aktif', $user->status_aktif) === '0')>
                            Nonaktif
                        </option>
                    </select>
                    @error('status_aktif')
                        <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Tombol --}}
                <div class="flex flex-wrap justify-end gap-3 pt-5">
                    <a
                        href="{{ route('admin.user.index') }}"
                        class="rounded-xl bg-gray-800 px-5 py-3 text-sm font-medium text-white transition hover:bg-gray-700"
                    >
                        Batal
                    </a>

                    <button
                        type="submit"
                        class="rounded-xl bg-gradient-to-r from-purple-600 to-indigo-600 px-6 py-3 text-sm font-semibold text-white transition hover:from-purple-500 hover:to-indigo-500"
                    >
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
