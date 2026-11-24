@extends('layouts.app')

@section('content')

<div class="p-6">

    {{-- HEADER --}}
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-2xl font-bold text-white">
                Detail Kendaraan
            </h1>
            <p class="text-sm text-gray-400 mt-1">
                Informasi lengkap kendaraan
            </p>
        </div>

        <a href="{{ route('admin.kendaraan.index') }}"
           class="px-5 py-2.5 rounded-xl bg-purple-700 hover:bg-purple-600 text-white text-sm font-medium transition">
            ← Kembali
        </a>
    </div>


    {{-- CARD --}}
    <div class="bg-[#171326] border border-purple-900/30 rounded-2xl overflow-hidden">

        {{-- TITLE --}}
        <div class="px-6 py-5 border-b border-purple-900/30">
            <h2 class="text-lg font-semibold text-white">
                Data Kendaraan
            </h2>
        </div>


        {{-- DATA --}}
        <div class="p-6">

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                {{-- ID --}}
                <div>
                    <p class="text-xs text-gray-500 mb-1">
                        ID Kendaraan
                    </p>

                    <p class="text-white font-medium">
                        {{ $kendaraan->id_kendaraan }}
                    </p>
                </div>


                {{-- PLAT --}}
                <div>
                    <p class="text-xs text-gray-500 mb-1">
                        Plat Nomor
                    </p>

                    <p class="text-white font-semibold text-lg">
                        {{ $kendaraan->plat_nomor }}
                    </p>
                </div>


                {{-- JENIS --}}
                <div>
                    <p class="text-xs text-gray-500 mb-1">
                        Jenis Kendaraan
                    </p>

                    <p class="text-white">
                        {{ ucfirst($kendaraan->jenis_kendaraan) }}
                    </p>
                </div>


                {{-- WARNA --}}
                <div>
                    <p class="text-xs text-gray-500 mb-1">
                        Warna
                    </p>

                    <p class="text-white">
                        {{ $kendaraan->warna }}
                    </p>
                </div>


                {{-- PEMILIK --}}
                <div>
                    <p class="text-xs text-gray-500 mb-1">
                        Pemilik
                    </p>

                    <p class="text-white">
                        {{ $kendaraan->pemilik }}
                    </p>
                </div>


                {{-- PETUGAS --}}
                <div>
                    <p class="text-xs text-gray-500 mb-1">
                        Petugas
                    </p>

                    <p class="text-white">
                        @if($kendaraan->id_user)
                            Petugas #{{ $kendaraan->id_user }}
                        @else
                            -
                        @endif
                    </p>
                </div>

            </div>

        </div>


        {{-- FOOTER BUTTON --}}
        <div class="px-6 py-5 border-t border-purple-900/30 flex justify-end gap-3">

            <a href="{{ route('admin.kendaraan.edit', $kendaraan->id_kendaraan) }}"
               class="px-5 py-2.5 rounded-xl bg-indigo-600 hover:bg-indigo-500 text-white text-sm font-medium transition">
                ✏️ Edit
            </a>

            <form action="{{ route('admin.kendaraan.destroy', $kendaraan->id_kendaraan) }}"
                  method="POST"
                  onsubmit="return confirm('Yakin ingin menghapus kendaraan ini?')">

                @csrf
                @method('DELETE')

                <button type="submit"
                        class="px-5 py-2.5 rounded-xl bg-rose-600 hover:bg-rose-500 text-white text-sm font-medium transition">
                    🗑️ Hapus
                </button>

            </form>

        </div>

    </div>

</div>

@endsection