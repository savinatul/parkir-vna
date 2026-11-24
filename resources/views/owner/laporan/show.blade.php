@extends('layouts.app')

@section('content')

<div class="max-w-5xl mx-auto space-y-6">

    {{-- HEADER --}}
    <div class="flex items-center justify-between">

        <div>

            <a href="{{ route('owner.laporan.index') }}"
               class="text-sm text-purple-400
                      hover:text-purple-300">

                ← Kembali ke Laporan

            </a>

            <h1 class="text-2xl font-black text-white mt-3">

                Detail Transaksi

            </h1>

            <p class="text-sm text-purple-300 mt-1">

                Informasi lengkap transaksi parkir

            </p>

        </div>


        <a href="{{ route('owner.laporan.cetak', [
                    'tanggal_mulai' => \Carbon\Carbon::parse(
                        $transaksi->waktu_masuk
                    )->format('Y-m-d'),

                    'tanggal_selesai' => \Carbon\Carbon::parse(
                        $transaksi->waktu_masuk
                    )->format('Y-m-d')
                ]) }}"
           target="_blank"
           class="px-5 py-3 rounded-xl
                  bg-purple-600 hover:bg-purple-500
                  text-white text-sm font-bold">

            🖨️ Cetak

        </a>

    </div>


    {{-- STATUS --}}
    <div class="bg-[#100b1d]
                border border-purple-900/40
                rounded-2xl p-6">

        <div class="flex flex-col md:flex-row
                    md:items-center
                    md:justify-between
                    gap-4">

            <div>

                <p class="text-xs text-purple-400">
                    ID Transaksi
                </p>

                <h2 class="text-2xl font-black text-white">
                    #{{ $transaksi->id_parkir }}
                </h2>

            </div>


            @if($transaksi->status === 'masuk')

                <span class="inline-flex
                             w-fit
                             px-4 py-2
                             rounded-xl
                             bg-yellow-500/10
                             border border-yellow-500/20
                             text-yellow-400
                             text-xs
                             font-black">

                    🚘 KENDARAAN MASUK

                </span>

            @else

                <span class="inline-flex
                             w-fit
                             px-4 py-2
                             rounded-xl
                             bg-green-500/10
                             border border-green-500/20
                             text-green-400
                             text-xs
                             font-black">

                    🏁 KENDARAAN KELUAR

                </span>

            @endif

        </div>

    </div>


    {{-- INFORMASI KENDARAAN --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-5">

        <div class="bg-[#100b1d]
                    border border-purple-900/40
                    rounded-2xl p-6">

            <h2 class="text-lg font-black text-white mb-5">
                🚗 Informasi Kendaraan
            </h2>

            <div class="space-y-4">

                <div>
                    <p class="text-xs text-purple-400">
                        Plat Nomor
                    </p>

                    <p class="text-lg font-black text-white">
                        {{ $transaksi->kendaraan->plat_nomor ?? '-' }}
                    </p>
                </div>


                <div>
                    <p class="text-xs text-purple-400">
                        Jenis Kendaraan
                    </p>

                    <p class="text-white font-bold">
                        {{ ucfirst(
                            $transaksi->kendaraan->jenis_kendaraan ?? '-'
                        ) }}
                    </p>
                </div>


                <div>
                    <p class="text-xs text-purple-400">
                        Area Parkir
                    </p>

                    <p class="text-white font-bold">
                        {{ $transaksi->area->nama_area ?? '-' }}
                    </p>
                </div>

            </div>

        </div>


        {{-- WAKTU --}}
        <div class="bg-[#100b1d]
                    border border-purple-900/40
                    rounded-2xl p-6">

            <h2 class="text-lg font-black text-white mb-5">
                🕐 Waktu Parkir
            </h2>

            <div class="space-y-4">

                <div>

                    <p class="text-xs text-purple-400">
                        Waktu Masuk
                    </p>

                    <p class="text-white font-bold">

                        {{ $transaksi->waktu_masuk
                            ? \Carbon\Carbon::parse(
                                $transaksi->waktu_masuk
                            )->format('d F Y, H:i')
                            : '-'
                        }}

                    </p>

                </div>


                <div>

                    <p class="text-xs text-purple-400">
                        Waktu Keluar
                    </p>

                    <p class="text-white font-bold">

                        {{ $transaksi->waktu_keluar
                            ? \Carbon\Carbon::parse(
                                $transaksi->waktu_keluar
                            )->format('d F Y, H:i')
                            : 'Kendaraan masih parkir'
                        }}

                    </p>

                </div>


                <div>

                    <p class="text-xs text-purple-400">
                        Durasi Parkir
                    </p>

                    <p class="text-xl font-black text-white">

                        {{ $transaksi->durasi_jam
                            ? $transaksi->durasi_jam . ' jam'
                            : '-'
                        }}

                    </p>

                </div>

            </div>

        </div>

    </div>


    {{-- PEMBAYARAN --}}
    <div class="bg-[#100b1d]
                border border-purple-900/40
                rounded-2xl p-6">

        <h2 class="text-lg font-black text-white mb-5">
            💰 Informasi Pembayaran
        </h2>


        <div class="grid grid-cols-1 md:grid-cols-3 gap-5">

            <div>

                <p class="text-xs text-purple-400">
                    Jenis Kendaraan
                </p>

                <p class="text-white font-bold mt-1">

                    {{ ucfirst(
                        $transaksi->kendaraan->jenis_kendaraan ?? '-'
                    ) }}

                </p>

            </div>


            <div>

                <p class="text-xs text-purple-400">
                    Tarif
                </p>

                <p class="text-white font-bold mt-1">

                    Rp {{ number_format(
                        $transaksi->tarif->tarif_perjam ?? 0,
                        0,
                        ',',
                        '.'
                    ) }}

                    / jam

                </p>

            </div>


            <div>

                <p class="text-xs text-purple-400">
                    Total Biaya
                </p>

                <p class="text-2xl font-black text-white mt-1">

                    @if($transaksi->biaya_total !== null)

                        Rp {{ number_format(
                            $transaksi->biaya_total,
                            0,
                            ',',
                            '.'
                        ) }}

                    @else

                        Belum selesai

                    @endif

                </p>

            </div>

        </div>

    </div>


    {{-- PETUGAS --}}
    <div class="bg-[#100b1d]
                border border-purple-900/40
                rounded-2xl p-6">

        <h2 class="text-lg font-black text-white mb-5">
            👤 Petugas
        </h2>

        <div class="flex items-center gap-4">

            <div class="w-12 h-12
                        rounded-full
                        bg-purple-600/20
                        flex items-center justify-center
                        text-xl">

                👤

            </div>

            <div>

                <p class="font-bold text-white">

                    {{ $transaksi->user->nama_lengkap ?? '-' }}

                </p>

                <p class="text-xs text-purple-400">

                    Petugas transaksi

                </p>

            </div>

        </div>

    </div>

</div>

@endsection