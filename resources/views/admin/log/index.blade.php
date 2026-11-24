@extends('layouts.app')

@section('content')

<div class="p-6">

    {{-- Header --}}
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-6">

        <div>
            <h1 class="text-2xl font-bold text-white">
                Log Aktivitas
            </h1>

            <p class="text-gray-400 text-sm mt-1">
                Riwayat aktivitas pengguna dalam sistem
            </p>
        </div>

    </div>


    {{-- Filter --}}
    <div class="bg-gray-900/70 border border-purple-900/50 rounded-2xl p-5 mb-6">

        <form method="GET"
              action="{{ route('admin.log.index') }}"
              class="grid grid-cols-1 md:grid-cols-3 gap-4">

            {{-- Search --}}
            <div>
                <label class="block text-sm text-gray-400 mb-2">
                    Cari Aktivitas
                </label>

                <input
                    type="text"
                    name="search"
                    value="{{ request('search') }}"
                    placeholder="Contoh: menambahkan kendaraan..."
                    class="w-full bg-gray-800 border border-gray-700 rounded-xl px-4 py-3
                           text-white placeholder-gray-500
                           focus:outline-none focus:ring-2 focus:ring-purple-600"
                >
            </div>


            {{-- Tanggal --}}
            <div>
                <label class="block text-sm text-gray-400 mb-2">
                    Tanggal
                </label>

                <input
                    type="date"
                    name="tanggal"
                    value="{{ request('tanggal') }}"
                    class="w-full bg-gray-800 border border-gray-700 rounded-xl px-4 py-3
                           text-white
                           focus:outline-none focus:ring-2 focus:ring-purple-600"
                >
            </div>


            {{-- Button --}}
            <div class="flex items-end gap-2">

                <button
                    type="submit"
                    class="px-5 py-3 bg-purple-700 hover:bg-purple-600
                           text-white rounded-xl transition">
                    🔍 Cari
                </button>

                <a
                    href="{{ route('admin.log.index') }}"
                    class="px-5 py-3 bg-gray-700 hover:bg-gray-600
                           text-white rounded-xl transition">
                    Reset
                </a>

            </div>

        </form>

    </div>


    {{-- Table --}}
    <div class="bg-gray-900/70 border border-purple-900/50 rounded-2xl overflow-hidden">

        <div class="overflow-x-auto">

            <table class="w-full">

                <thead class="bg-purple-950/40">

                    <tr class="text-left text-gray-300 text-sm">

                        <th class="px-6 py-4">
                            No
                        </th>

                        <th class="px-6 py-4">
                            Pengguna
                        </th>

                        <th class="px-6 py-4">
                            Aktivitas
                        </th>

                        <th class="px-6 py-4">
                            Waktu
                        </th>

                        <th class="px-6 py-4 text-center">
                            Detail
                        </th>

                    </tr>

                </thead>


                <tbody class="divide-y divide-gray-800">

                    @forelse($logs as $log)

                        <tr class="hover:bg-purple-950/20 transition">

                            <td class="px-6 py-4 text-gray-400">
                                {{ $logs->firstItem() + $loop->index }}
                            </td>


                            <td class="px-6 py-4">

                                <div class="flex items-center gap-3">

                                    <div class="w-10 h-10 rounded-full
                                                bg-purple-700/30
                                                flex items-center justify-center">

                                        👤

                                    </div>

                                    <div>

                                        <p class="text-white font-medium">
                                            {{ $log->user->nama_lengkap ?? 'Sistem' }}
                                        </p>

                                        @if($log->user)
                                            <p class="text-xs text-gray-500">
                                                {{ ucfirst($log->user->role) }}
                                            </p>
                                        @endif

                                    </div>

                                </div>

                            </td>


                            <td class="px-6 py-4">

                                <span class="text-gray-300">
                                    {{ $log->aktivitas }}
                                </span>

                            </td>


                            <td class="px-6 py-4 text-gray-400">

                                {{ $log->waktu_aktivitas
                                    ? $log->waktu_aktivitas->format('d/m/Y H:i:s')
                                    : '-' }}

                            </td>


                            <td class="px-6 py-4 text-center">

                                <a
                                    href="{{ route('admin.log.show', $log->id_log) }}"
                                    class="inline-flex items-center px-4 py-2
                                           bg-purple-700/20
                                           text-purple-300
                                           hover:bg-purple-700
                                           hover:text-white
                                           rounded-lg transition">

                                    👁 Detail

                                </a>

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td colspan="5"
                                class="px-6 py-12 text-center">

                                <div class="text-4xl mb-3">
                                    📋
                                </div>

                                <p class="text-gray-400">
                                    Belum ada aktivitas.
                                </p>

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>


        {{-- Pagination --}}
        @if($logs->hasPages())

            <div class="px-6 py-4 border-t border-gray-800">

                {{ $logs->links() }}

            </div>

        @endif

    </div>

</div>

@endsection