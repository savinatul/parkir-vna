@extends('layouts.app')

@section('content')

<div class="p-6">

    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
        <div>
            <h1 class="text-2xl font-bold text-white">Data User</h1>
            <p class="text-sm text-gray-400 mt-1">
                Kelola akun admin, owner, dan petugas
            </p>
        </div>

        <a href="{{ route('admin.user.create') }}"
           class="px-5 py-3 rounded-xl bg-gradient-to-r from-purple-600 to-indigo-600
                  text-white text-sm font-semibold hover:brightness-110 transition">
            + Tambah User
        </a>
    </div>

    @if(session('success'))
        <div class="mb-5 px-4 py-3 rounded-xl
                    bg-emerald-500/10 border border-emerald-500/30
                    text-emerald-400 text-sm">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="mb-5 px-4 py-3 rounded-xl
                    bg-rose-500/10 border border-rose-500/30
                    text-rose-400 text-sm">
            {{ session('error') }}
        </div>
    @endif

    <div class="bg-[#120d20] border border-purple-900/30 rounded-2xl overflow-hidden">

        <div class="overflow-x-auto">

            <table class="w-full">

                <thead class="bg-purple-950/30">
                    <tr class="text-left text-xs uppercase text-gray-400">
                        <th class="px-6 py-4">No</th>
                        <th class="px-6 py-4">Nama Lengkap</th>
                        <th class="px-6 py-4">Username</th>
                        <th class="px-6 py-4">Role</th>
                        <th class="px-6 py-4">Status</th>
                        <th class="px-6 py-4 text-center">Aksi</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-purple-900/20">

                    @forelse($users as $user)

                        <tr class="hover:bg-purple-950/20 transition">

                            <td class="px-6 py-4 text-sm text-gray-400">
                                {{ $users->firstItem() + $loop->index }}
                            </td>

                            <td class="px-6 py-4">
                                <span class="font-semibold text-white">
                                    {{ $user->nama_lengkap }}
                                </span>
                            </td>

                            <td class="px-6 py-4 text-sm text-gray-300">
                                {{ $user->username }}
                            </td>

                            <td class="px-6 py-4">

                                @if($user->role == 'owner')
                                    <span class="px-3 py-1 rounded-full text-xs
                                                 bg-amber-500/10 text-amber-400
                                                 border border-amber-500/20">
                                        Owner
                                    </span>

                                @elseif($user->role == 'admin')
                                    <span class="px-3 py-1 rounded-full text-xs
                                                 bg-purple-500/10 text-purple-400
                                                 border border-purple-500/20">
                                        Admin
                                    </span>

                                @else
                                    <span class="px-3 py-1 rounded-full text-xs
                                                 bg-blue-500/10 text-blue-400
                                                 border border-blue-500/20">
                                        Petugas
                                    </span>
                                @endif

                            </td>

                            <td class="px-6 py-4">

                                @if($user->status_aktif)
                                    <span class="px-3 py-1 rounded-full text-xs
                                                 bg-emerald-500/10 text-emerald-400
                                                 border border-emerald-500/20">
                                        Aktif
                                    </span>
                                @else
                                    <span class="px-3 py-1 rounded-full text-xs
                                                 bg-rose-500/10 text-rose-400
                                                 border border-rose-500/20">
                                        Nonaktif
                                    </span>
                                @endif

                            </td>

                            <td class="px-6 py-4">

                                <div class="flex justify-center gap-2">

                                    <a href="{{ route('admin.user.show', $user->id_user) }}"
                                       class="px-3 py-2 rounded-lg bg-blue-500/10
                                              text-blue-400 hover:bg-blue-500/20 text-xs">
                                        Detail
                                    </a>

                                    <a href="{{ route('admin.user.edit', $user->id_user) }}"
                                       class="px-3 py-2 rounded-lg bg-amber-500/10
                                              text-amber-400 hover:bg-amber-500/20 text-xs">
                                        Edit
                                    </a>

                                    <form action="{{ route('admin.user.destroy', $user->id_user) }}"
                                          method="POST"
                                          onsubmit="return confirm('Yakin ingin menghapus user ini?')">

                                        @csrf
                                        @method('DELETE')

                                        <button type="submit"
                                                class="px-3 py-2 rounded-lg bg-rose-500/10
                                                       text-rose-400 hover:bg-rose-500/20 text-xs">
                                            Hapus
                                        </button>

                                    </form>

                                </div>

                            </td>

                        </tr>

                    @empty

                        <tr>
                            <td colspan="6"
                                class="px-6 py-12 text-center text-gray-500">
                                Belum ada data user.
                            </td>
                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

        <div class="p-5 border-t border-purple-900/20">
            {{ $users->links() }}
        </div>

    </div>

</div>

@endsection