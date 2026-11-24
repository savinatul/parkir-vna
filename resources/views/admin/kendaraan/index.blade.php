@extends('layouts.app')

@section('title', 'Data Kendaraan')
@section('page_title', 'Data Kendaraan')
@section('page_subtitle', 'Kelola seluruh data kendaraan yang terdaftar')

@section('content')

<div class="space-y-6">

    {{-- ALERT --}}
    @if(session('success'))
        <div class="bg-emerald-500/10 border border-emerald-500/30
                    text-emerald-400 px-5 py-4 rounded-xl text-sm">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="bg-rose-500/10 border border-rose-500/30
                    text-rose-400 px-5 py-4 rounded-xl text-sm">
            {{ session('error') }}
        </div>
    @endif


    {{-- HEADER --}}
    <div class="glass-card rounded-2xl p-6">

        <div class="flex flex-col md:flex-row
                    md:items-center md:justify-between gap-4">

            <div>
                <h3 class="text-lg font-bold text-white">
                    Daftar Kendaraan
                </h3>

                <p class="text-xs text-gray-500 mt-1">
                    Data kendaraan yang tersimpan di sistem
                </p>
            </div>

            <a href="{{ route('admin.kendaraan.create') }}"
               class="inline-flex items-center justify-center
                      px-5 py-3 rounded-xl
                      bg-gradient-to-r from-purple-600 to-indigo-600
                      text-white text-sm font-semibold
                      hover:brightness-110 transition">

                + Tambah Kendaraan

            </a>

        </div>

    </div>


    {{-- TABLE --}}
    <div class="glass-card rounded-2xl overflow-hidden">

        <div class="overflow-x-auto">

            <table class="w-full">

                <thead class="bg-[#171026]">

                    <tr class="text-left text-xs text-purple-300">

                        <th class="px-6 py-4">
                            No
                        </th>

                        <th class="px-6 py-4">
                            Plat Nomor
                        </th>

                        <th class="px-6 py-4">
                            Jenis
                        </th>

                        <th class="px-6 py-4">
                            Warna
                        </th>

                        <th class="px-6 py-4">
                            Pemilik
                        </th>

                        <th class="px-6 py-4">
                            Petugas
                        </th>

                        <th class="px-6 py-4 text-center">
                            Aksi
                        </th>

                    </tr>

                </thead>


                <tbody class="divide-y divide-purple-900/20">

                    @forelse($kendaraan as $item)

                        <tr class="hover:bg-purple-950/20 transition">

                            <td class="px-6 py-4 text-sm text-gray-400">
                                {{ $loop->iteration }}
                            </td>

                            <td class="px-6 py-4">

                                <span class="font-bold text-white">
                                    {{ $item->plat_nomor }}
                                </span>

                            </td>

                            <td class="px-6 py-4">

                                <span class="px-3 py-1 rounded-full
                                             bg-purple-500/10
                                             text-purple-300
                                             text-xs capitalize">
                                    {{ $item->jenis_kendaraan }}
                                </span>

                            </td>

                            <td class="px-6 py-4 text-sm text-gray-300">
                                {{ $item->warna }}
                            </td>

                            <td class="px-6 py-4 text-sm text-gray-300">
                                {{ $item->pemilik }}
                            </td>

                            <td class="px-4 py-4 text-sm text-purple-100">
                                @if ($item->petugas)
                                    {{ $item->petugas->nama_lengkap }}
                                @else
                                    <span class="text-gray-500">Belum ditugaskan</span>
                                @endif
                            </td>

                            <td class="px-6 py-4">

                                <div class="flex justify-center gap-2">

                                    <a href="{{ route('admin.kendaraan.show', $item->id_kendaraan) }}"
                                       class="px-3 py-2 rounded-lg
                                              bg-blue-500/10
                                              text-blue-400
                                              text-xs">
                                        Detail
                                    </a>

                                    <a href="{{ route('admin.kendaraan.edit', $item->id_kendaraan) }}"
                                       class="px-3 py-2 rounded-lg
                                              bg-amber-500/10
                                              text-amber-400
                                              text-xs">
                                        Edit
                                    </a>

                                    <form
                                        action="{{ route('admin.kendaraan.destroy', $item->id_kendaraan) }}"
                                        method="POST"
                                        onsubmit="return confirm('Yakin ingin menghapus kendaraan ini?')"
                                    >

                                        @csrf
                                        @method('DELETE')

                                        <button
                                            type="submit"
                                            class="px-3 py-2 rounded-lg
                                                   bg-rose-500/10
                                                   text-rose-400
                                                   text-xs">
                                            Hapus
                                        </button>

                                    </form>

                                </div>

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td colspan="7"
                                class="px-6 py-12 text-center text-gray-500">

                                Belum ada data kendaraan.

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>


        {{-- PAGINATION --}}
        <div class="p-5 border-t border-purple-900/20">
            {{ $kendaraan->links() }}
        </div>

    </div>

</div>

@endsection