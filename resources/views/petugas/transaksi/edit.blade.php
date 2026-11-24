@extends('layouts.app')

@section('page_title', 'Edit Transaksi')
@section('page_subtitle', 'Ubah data transaksi kendaraan')

@section('content')

<div class="max-w-3xl mx-auto">

    @if(session('error'))
        <div class="mb-5 bg-red-500/20 border border-red-400/30 text-red-300 px-5 py-4 rounded-xl">
            {{ session('error') }}
        </div>
    @endif

    <div class="bg-white/5 border border-white/10 rounded-2xl p-7">

        <h2 class="text-xl font-bold text-white mb-6">
            ✏️ Edit Transaksi #{{ $transaksi->id_parkir }}
        </h2>

        <form action="{{ route('petugas.transaksi.update', $transaksi->id_parkir) }}"
              method="POST"
              class="space-y-6">

            @csrf
            @method('PUT')

            {{-- Kendaraan --}}
            <div>
                <label class="block text-gray-300 mb-2">
                    Kendaraan
                </label>

                <select name="id_kendaraan"
                        id="id_kendaraan"
                        required
                        class="w-full bg-gray-900 border border-white/10 rounded-xl px-4 py-3 text-white">

                    @foreach($kendaraan as $item)

                        <option value="{{ $item->id_kendaraan }}"
                                data-jenis="{{ strtolower($item->jenis_kendaraan) }}"
                                {{ $transaksi->id_kendaraan == $item->id_kendaraan ? 'selected' : '' }}>

                            {{ $item->plat_nomor }}
                            - {{ $item->jenis_kendaraan }}

                        </option>

                    @endforeach

                </select>
            </div>


            {{-- Tarif --}}
            <div>
                <label class="block text-gray-300 mb-2">
                    Tarif Parkir
                </label>

                <select name="id_tarif"
                        id="id_tarif"
                        required
                        class="w-full bg-gray-900 border border-white/10 rounded-xl px-4 py-3 text-white">

                    @foreach($tarif as $item)

                        <option value="{{ $item->id_tarif }}"
                                data-jenis="{{ strtolower($item->jenis_kendaraan) }}">

                            {{ $item->jenis_kendaraan }}
                            - Rp {{ number_format($item->tarif_per_jam, 0, ',', '.') }}/jam

                        </option>

                    @endforeach

                </select>
            </div>


            {{-- Area --}}
            <div>
                <label class="block text-gray-300 mb-2">
                    Area Parkir
                </label>

                <select name="id_area"
                        required
                        class="w-full bg-gray-900 border border-white/10 rounded-xl px-4 py-3 text-white">

                    @foreach($area as $item)

                        <option value="{{ $item->id_area }}"
                                {{ $transaksi->id_area == $item->id_area ? 'selected' : '' }}>

                            {{ $item->nama_area }}
                            — Terisi {{ $item->terisi }}/{{ $item->kapasitas }}

                        </option>

                    @endforeach

                </select>
            </div>


            <div class="flex justify-end gap-3 pt-4">

                <a href="{{ route('petugas.transaksi.index') }}"
                   class="px-5 py-3 rounded-xl bg-gray-700 hover:bg-gray-600 text-white">
                    Batal
                </a>

                <button type="submit"
                        class="px-5 py-3 rounded-xl bg-purple-600 hover:bg-purple-700 text-white font-semibold">
                    Simpan Perubahan
                </button>

            </div>

        </form>

    </div>

</div>

@endsection