@extends('layouts.app')

@section('content')

<div class="p-6">

    <div class="flex flex-col md:flex-row md:items-center
                md:justify-between gap-4 mb-6">

        <div>
            <h1 class="text-2xl font-bold text-white">
                Tarif Parkir
            </h1>

            <p class="text-sm text-gray-400 mt-1">
                Kelola tarif parkir kendaraan
            </p>
        </div>

        <a href="{{ route('admin.tarif.create') }}"
           class="px-5 py-3 rounded-xl
                  bg-gradient-to-r from-purple-600 to-indigo-700
                  text-white text-sm font-semibold
                  hover:brightness-110 transition">
            + Tambah Tarif
        </a>
    </div>


    @if(session('success'))
        <div class="mb-5 px-4 py-3 rounded-xl
                    bg-emerald-500/10
                    border border-emerald-500/30
                    text-emerald-400 text-sm">
            {{ session('success') }}
        </div>
    @endif


    <div class="bg-[#120d20]
                border border-purple-900/30
                rounded-2xl overflow-hidden">

        <div class="overflow-x-auto">

            <table class="w-full">

                <thead class="bg-purple-950/30">

                    <tr>

                        <th class="px-6 py-4 text-left text-xs
                                   font-semibold text-gray-400 uppercase">
                            No
                        </th>

                        <th class="px-6 py-4 text-left text-xs
                                   font-semibold text-gray-400 uppercase">
                            Jenis Kendaraan
                        </th>

                        <th class="px-6 py-4 text-left text-xs
                                   font-semibold text-gray-400 uppercase">
                            Tarif / Jam
                        </th>

                        <th class="px-6 py-4 text-center text-xs
                                   font-semibold text-gray-400 uppercase">
                            Aksi
                        </th>

                    </tr>

                </thead>

                <tbody class="divide-y divide-purple-900/20">

                    @forelse($tarif as $item)

                        <tr class="hover:bg-purple-950/20 transition">

                            <td class="px-6 py-4 text-sm text-gray-400">
                                {{ $tarif->firstItem() + $loop->index }}
                            </td>

                            <td class="px-6 py-4">

                                @if($item->jenis_kendaraan == 'motor')
                                    <span class="px-3 py-1 rounded-full
                                                 bg-purple-500/10
                                                 text-purple-400 text-xs">
                                        🏍️ Motor
                                    </span>

                                @elseif($item->jenis_kendaraan == 'mobil')
                                    <span class="px-3 py-1 rounded-full
                                                 bg-indigo-500/10
                                                 text-indigo-400 text-xs">
                                        🚗 Mobil
                                    </span>

                                @elseif($item->jenis_kendaraan == 'truk')
                                    <span class="px-3 py-1 rounded-full
                                                 bg-amber-500/10
                                                 text-amber-400 text-xs">
                                        🚛 Truk
                                    </span>

                                @else
                                    <span class="px-3 py-1 rounded-full
                                                 bg-gray-500/10
                                                 text-gray-400 text-xs">
                                        🚙 Lainnya
                                    </span>
                                @endif

                            </td>

                            <td class="px-6 py-4">

                                <span class="font-semibold text-white">
                                    Rp {{ number_format($item->tarif_perjam, 0, ',', '.') }}
                                </span>

                                <span class="text-xs text-gray-500">
                                    / jam
                                </span>

                            </td>

                            <td class="px-6 py-4">

                                <div class="flex justify-center gap-2">

                                    <a href="{{ route('admin.tarif.show', $item->id_tarif) }}"
                                       class="px-3 py-2 rounded-lg
                                              bg-indigo-500/10
                                              text-indigo-400
                                              text-xs hover:bg-indigo-500/20">
                                        Detail
                                    </a>

                                    <a href="{{ route('admin.tarif.edit', $item->id_tarif) }}"
                                       class="px-3 py-2 rounded-lg
                                              bg-purple-500/10
                                              text-purple-400
                                              text-xs hover:bg-purple-500/20">
                                        Edit
                                    </a>

                                    <form action="{{ route('admin.tarif.destroy', $item->id_tarif) }}"
                                          method="POST"
                                          onsubmit="return confirm('Yakin ingin menghapus tarif ini?')">

                                        @csrf
                                        @method('DELETE')

                                        <button type="submit"
                                                class="px-3 py-2 rounded-lg
                                                       bg-rose-500/10
                                                       text-rose-400
                                                       text-xs
                                                       hover:bg-rose-500/20">
                                            Hapus
                                        </button>

                                    </form>

                                </div>

                            </td>

                        </tr>

                    @empty

                        <tr>
                            <td colspan="4"
                                class="px-6 py-12 text-center
                                       text-gray-500">
                                Belum ada data tarif.
                            </td>
                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>


        @if($tarif->hasPages())

            <div class="p-5 border-t border-purple-900/20">
                {{ $tarif->links() }}
            </div>

        @endif

    </div>

</div>

@endsection
