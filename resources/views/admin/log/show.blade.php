@extends('layouts.app')

@section('content')

<div class="p-6">

    {{-- Header --}}
    <div class="flex items-center gap-3 mb-6">

        <a
            href="{{ route('admin.log.index') }}"
            class="w-10 h-10 rounded-xl bg-gray-800
                   hover:bg-purple-700
                   flex items-center justify-center
                   text-white transition">
            ←
        </a>

        <div>
            <h1 class="text-2xl font-bold text-white">
                Detail Log Aktivitas
            </h1>

            <p class="text-gray-400 text-sm">
                Informasi aktivitas pengguna
            </p>
        </div>

    </div>


    {{-- Card --}}
    <div class="max-w-3xl">

        <div class="bg-gray-900/70
                    border border-purple-900/50
                    rounded-2xl p-6">

            {{-- User --}}
            <div class="flex items-center gap-4 pb-6 border-b border-gray-800">

                <div class="w-14 h-14 rounded-full
                            bg-purple-700/30
                            flex items-center justify-center
                            text-2xl">

                    👤

                </div>

                <div>

                    <p class="text-white font-semibold text-lg">
                        {{ $log->user->nama_lengkap ?? 'Sistem' }}
                    </p>

                    @if($log->user)

                        <p class="text-gray-400 text-sm">
                            {{ ucfirst($log->user->role) }}
                        </p>

                    @endif

                </div>

            </div>


            {{-- Informasi --}}
            <div class="space-y-5 mt-6">

                <div>

                    <p class="text-sm text-gray-500 mb-1">
                        ID Log
                    </p>

                    <p class="text-white">
                        #{{ $log->id_log }}
                    </p>

                </div>


                <div>

                    <p class="text-sm text-gray-500 mb-1">
                        Aktivitas
                    </p>

                    <div class="bg-gray-800 rounded-xl p-4">

                        <p class="text-white">
                            {{ $log->aktivitas }}
                        </p>

                    </div>

                </div>


                <div>

                    <p class="text-sm text-gray-500 mb-1">
                        Waktu Aktivitas
                    </p>

                    <p class="text-white">
                        {{ $log->waktu_aktivitas
                            ? $log->waktu_aktivitas->format('d F Y, H:i:s')
                            : '-' }}
                        WIB
                    </p>

                </div>

            </div>

        </div>

    </div>

</div>

@endsection