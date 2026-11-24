@extends('layouts.app')

@section('content')

<div class="p-6 max-w-2xl mx-auto">

    <div class="mb-6">

        <h1 class="text-2xl font-bold text-white">
            Detail Tarif
        </h1>

        <p class="text-sm text-gray-400 mt-1">
            Informasi tarif parkir
        </p>

    </div>


    <div class="bg-[#120d20]
                border border-purple-900/30
                rounded-2xl p-6">

        <div class="bg-[#171326] rounded-xl p-5 mb-4">

            <p class="text-xs text-gray-500 mb-2">
                Jenis Kendaraan
            </p>

            <p class="text-xl font-bold text-white capitalize">
                {{ $tarif->jenis_kendaraan }}
            </p>

        </div>


        <div class="bg-[#171326] rounded-xl p-5">

            <p class="text-xs text-gray-500 mb-2">
                Tarif Per Jam
            </p>

            <p class="text-2xl font-bold text-purple-400">
                Rp {{ number_format($tarif->tarif_perjam, 0, ',', '.') }}
            </p>

        </div>


        <div class="flex justify-end gap-3 mt-6">

            <a href="{{ route('admin.tarif.index') }}"
               class="px-5 py-3 rounded-xl
                      bg-gray-800 text-gray-300 text-sm
                      hover:bg-gray-700">
                Kembali
            </a>

            <a href="{{ route('admin.tarif.edit', $tarif->id_tarif) }}"
               class="px-5 py-3 rounded-xl
                      bg-purple-600 text-white text-sm
                      hover:bg-purple-500">
                Edit
            </a>

        </div>

    </div>

</div>

@endsection