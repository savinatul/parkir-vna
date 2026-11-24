@extends('layouts.app')

@section('page_title', 'Detail Transaksi')
@section('page_subtitle', 'Informasi lengkap transaksi parkir')

@section('content')

<div class="max-w-3xl mx-auto">

    @if(session('error'))
        <div class="mb-5 bg-red-500/20 border border-red-400/30 text-red-300 px-5 py-4 rounded-xl">
            {{ session('error') }}
        </div>
    @endif

    <div class="bg-white/5 border border-white/10 rounded-2xl p-7">

        <div class="flex justify-between items-center mb-7">

            <div>
                <h2 class="text-2xl font-bold text-white">
                    Transaksi #{{ $transaksi->id_parkir }}
                </h2>

                <p class="text-gray-400 mt-1">
                    Detail parkir kendaraan
                </p>
            </div>

            @if($transaksi->status === 'masuk')

                <span class="px-4 py-2 rounded-full bg-yellow-500/20 text-yellow-300 font-semibold text-sm">
                    MASUK
                </span>

            @else

                <span class="px-4 py-2 rounded-full bg-green-500/20 text-green-300 font-semibold text-sm">
                    KELUAR
                </span>

            @endif

        </div>


        <div class="grid md:grid-cols-2 gap-5">

            {{-- Plat --}}
            <div class="bg-white/5 rounded-xl p-5">
                <p class="text-gray-500 text-sm">
                    Plat Nomor
                </p>

                <p class="text-white text-lg font-bold mt-1">
                    {{ $transaksi->kendaraan->plat_nomor ?? '-' }}
                </p>
            </div>


            {{-- Jenis --}}
            <div class="bg-white/5 rounded-xl p-5">
                <p class="text-gray-500 text-sm">
                    Jenis Kendaraan
                </p>

                <p class="text-white text-lg font-bold mt-1">
                    {{ $transaksi->kendaraan->jenis_kendaraan ?? '-' }}
                </p>
            </div>


            {{-- Tarif --}}
            <div class="bg-white/5 rounded-xl p-5">
                <p class="text-gray-500 text-sm">
                    Tarif Per Jam
                </p>

                <p class="text-white text-lg font-bold mt-1">
                    Rp {{ number_format($transaksi->tarif->tarif_per_jam ?? 0, 0, ',', '.') }}
                </p>
            </div>


            {{-- Area --}}
            <div class="bg-white/5 rounded-xl p-5">
                <p class="text-gray-500 text-sm">
                    Area Parkir
                </p>

                <p class="text-white text-lg font-bold mt-1">
                    {{ $transaksi->area->nama_area ?? '-' }}
                </p>
            </div>


            {{-- Waktu masuk --}}
            <div class="bg-white/5 rounded-xl p-5">
                <p class="text-gray-500 text-sm">
                    Waktu Masuk
                </p>

                <p class="text-white font-semibold mt-1">
                    {{ $transaksi->waktu_masuk?->format('d/m/Y H:i:s') ?? '-' }}
                </p>
            </div>


            {{-- Waktu keluar --}}
            <div class="bg-white/5 rounded-xl p-5">
                <p class="text-gray-500 text-sm">
                    Waktu Keluar
                </p>

                <p class="text-white font-semibold mt-1">
                    {{ $transaksi->waktu_keluar?->format('d/m/Y H:i:s') ?? '-' }}
                </p>
            </div>


            {{-- Durasi --}}
            <div class="bg-white/5 rounded-xl p-5">
                <p class="text-gray-500 text-sm">
                    Durasi Parkir
                </p>

                <p class="text-white text-lg font-bold mt-1">
                    {{ $transaksi->durasi_jam ? $transaksi->durasi_jam . ' jam' : '-' }}
                </p>
            </div>


            {{-- Total --}}
            <div class="bg-purple-500/10 border border-purple-400/20 rounded-xl p-5">
                <p class="text-purple-300 text-sm">
                    Total Biaya
                </p>

                <p class="text-purple-200 text-xl font-bold mt-1">
                    Rp {{ number_format($transaksi->biaya_total ?? 0, 0, ',', '.') }}
                </p>
            </div>

        </div>


        {{-- Tombol --}}
        <div class="flex justify-between items-center mt-8">

            <a href="{{ route('petugas.transaksi.index') }}"
               class="px-5 py-3 rounded-xl bg-gray-700 hover:bg-gray-600 text-white">
                ← Kembali
            </a>


            @if($transaksi->status === 'masuk')

                <form action="{{ route('petugas.transaksi.keluar', $transaksi->id_parkir) }}"
                      method="POST"
                      onsubmit="return confirm('Yakin kendaraan akan keluar?')">

                    @csrf

                    <button type="submit"
                            class="px-6 py-3 rounded-xl bg-green-600 hover:bg-green-700 text-white font-semibold">
                        🚗 Kendaraan Keluar
                    </button>

                </form>

            @endif

        </div>

    </div>

</div>

@endsection