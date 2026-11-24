```blade
@extends('layouts.app')

@section('content')

<div class="p-6">

    <div class="mb-6">
        <h1 class="text-2xl font-bold text-white">Detail User</h1>
        <p class="text-sm text-gray-400 mt-1">
            Informasi lengkap user
        </p>
    </div>

    <div class="max-w-3xl bg-[#120d20] border border-purple-900/30 rounded-2xl p-6">

        <div class="space-y-5">

            {{-- Nama Lengkap --}}
            <div>
                <p class="text-xs text-gray-500 mb-1">Nama Lengkap</p>
                <p class="text-white font-semibold">
                    {{ $user->nama_lengkap }}
                </p>
            </div>

            {{-- Username --}}
            <div>
                <p class="text-xs text-gray-500 mb-1">Username</p>
                <p class="text-gray-200">
                    {{ $user->username }}
                </p>
            </div>

            {{-- Role --}}
            <div>
                <p class="text-xs text-gray-500 mb-1">Role</p>

                <span class="inline-block px-3 py-1 rounded-full text-xs
                    @if($user->role == 'owner')
                        bg-amber-500/10 text-amber-400
                    @elseif($user->role == 'admin')
                        bg-purple-500/10 text-purple-400
                    @else
                        bg-blue-500/10 text-blue-400
                    @endif
                ">
                    {{ ucfirst($user->role) }}
                </span>
            </div>

            {{-- Status --}}
            <div>
                <p class="text-xs text-gray-500 mb-1">Status</p>

                @if($user->status_aktif)
                    <span class="inline-block px-3 py-1 rounded-full bg-emerald-500/10 text-emerald-400 text-xs">
                        Aktif
                    </span>
                @else
                    <span class="inline-block px-3 py-1 rounded-full bg-rose-500/10 text-rose-400 text-xs">
                        Nonaktif
                    </span>
                @endif
            </div>

        </div>

        {{-- Tombol Aksi --}}
        <div class="flex justify-end gap-3 mt-8 pt-5 border-t border-purple-900/20">

            <a href="{{ route('admin.user.index') }}"
               class="px-5 py-3 rounded-xl bg-gray-700/50 text-gray-300 hover:bg-gray-700 transition">
                Kembali
            </a>

            <a href="{{ route('admin.user.edit', $user->id_user) }}"
               class="px-5 py-3 rounded-xl bg-gradient-to-r from-purple-600 to-indigo-600 text-white font-semibold hover:brightness-110 transition">
                Edit
            </a>

        </div>

    </div>

</div>

@endsection
```