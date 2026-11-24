<!DOCTYPE html>

<html lang="id">

<head>

    <meta charset="UTF-8">

    <title>Laporan Parkir</title>

    <script src="https://cdn.tailwindcss.com"></script>

</head>


<body class="bg-white text-gray-900">

<div class="max-w-7xl mx-auto p-8">


    {{-- BUTTON --}}
    <div class="print:hidden mb-6">

        <button onclick="window.print()"
                class="px-5 py-3
                       rounded-xl
                       bg-purple-600
                       hover:bg-purple-700
                       text-white
                       font-bold">

            🖨️ Cetak Laporan

        </button>

        <a href="{{ route('owner.laporan.index') }}"
           class="ml-2
                  px-5 py-3
                  rounded-xl
                  bg-gray-200
                  hover:bg-gray-300
                  text-gray-700
                  font-bold">

            ← Kembali

        </a>

    </div>


    {{-- HEADER --}}
    <div class="text-center border-b-2
                border-gray-800 pb-5 mb-6">

        <h1 class="text-3xl font-black">

            PARKIR AJAA

        </h1>

        <h2 class="text-xl font-bold mt-1">

            LAPORAN TRANSAKSI PARKIR

        </h2>

        <p class="text-sm text-gray-500 mt-1">

            Sistem Informasi Parkir

        </p>

    </div>


    {{-- PERIODE --}}
    <div class="mb-5 text-sm">

        <strong>Periode:</strong>

        {{ $tanggalMulai->format('d/m/Y') }}

        -

        {{ $tanggalSelesai->format('d/m/Y') }}

        @if($status)

            <span class="ml-4">

                <strong>Status:</strong>

                {{ strtoupper($status) }}

            </span>

        @endif

    </div>


    {{-- RINGKASAN --}}
    <div class="grid grid-cols-4 gap-4 mb-6">

        <div class="border border-gray-300
                    rounded-xl p-4">

            <p class="text-xs text-gray-500">
                Total Transaksi
            </p>

            <p class="text-2xl font-black mt-1">
                {{ $totalTransaksi }}
            </p>

        </div>


        <div class="border border-gray-300
                    rounded-xl p-4">

            <p class="text-xs text-gray-500">
                Kendaraan Masuk
            </p>

            <p class="text-2xl font-black mt-1">
                {{ $totalMasuk }}
            </p>

        </div>


        <div class="border border-gray-300
                    rounded-xl p-4">

            <p class="text-xs text-gray-500">
                Kendaraan Keluar
            </p>

            <p class="text-2xl font-black mt-1">
                {{ $totalKeluar }}
            </p>

        </div>


        <div class="border border-gray-300
                    rounded-xl p-4">

            <p class="text-xs text-gray-500">
                Total Pendapatan
            </p>

            <p class="text-xl font-black mt-1">

                Rp {{ number_format(
                    $totalPendapatan,
                    0,
                    ',',
                    '.'
                ) }}

            </p>

        </div>

    </div>


    {{-- TABLE --}}
    <div class="overflow-hidden">

        <table class="w-full border-collapse
                      text-xs">

            <thead>

                <tr class="bg-gray-100">

                    <th class="border border-gray-300
                               px-3 py-3">
                        No
                    </th>

                    <th class="border border-gray-300
                               px-3 py-3">
                        Plat
                    </th>

                    <th class="border border-gray-300
                               px-3 py-3">
                        Jenis
                    </th>

                    <th class="border border-gray-300
                               px-3 py-3">
                        Area
                    </th>

                    <th class="border border-gray-300
                               px-3 py-3">
                        Masuk
                    </th>

                    <th class="border border-gray-300
                               px-3 py-3">
                        Keluar
                    </th>

                    <th class="border border-gray-300
                               px-3 py-3">
                        Durasi
                    </th>

                    <th class="border border-gray-300
                               px-3 py-3">
                        Biaya
                    </th>

                    <th class="border border-gray-300
                               px-3 py-3">
                        Status
                    </th>

                </tr>

            </thead>


            <tbody>

                @forelse($transaksi as $index => $trx)

                    <tr>

                        <td class="border border-gray-300
                                   px-3 py-2 text-center">

                            {{ $index + 1 }}

                        </td>


                        <td class="border border-gray-300
                                   px-3 py-2 font-bold">

                            {{ $trx->kendaraan->plat_nomor ?? '-' }}

                        </td>


                        <td class="border border-gray-300
                                   px-3 py-2">

                            {{ ucfirst(
                                $trx->kendaraan->jenis_kendaraan ?? '-'
                            ) }}

                        </td>


                        <td class="border border-gray-300
                                   px-3 py-2">

                            {{ $trx->area->nama_area ?? '-' }}

                        </td>


                        <td class="border border-gray-300
                                   px-3 py-2">

                            {{ $trx->waktu_masuk
                                ? \Carbon\Carbon::parse(
                                    $trx->waktu_masuk
                                )->format('d/m/Y H:i')
                                : '-'
                            }}

                        </td>


                        <td class="border border-gray-300
                                   px-3 py-2">

                            {{ $trx->waktu_keluar
                                ? \Carbon\Carbon::parse(
                                    $trx->waktu_keluar
                                )->format('d/m/Y H:i')
                                : '-'
                            }}

                        </td>


                        <td class="border border-gray-300
                                   px-3 py-2">

                            {{ $trx->durasi_jam
                                ? $trx->durasi_jam . ' jam'
                                : '-'
                            }}

                        </td>


                        <td class="border border-gray-300
                                   px-3 py-2 font-bold">

                            @if($trx->biaya_total !== null)

                                Rp {{ number_format(
                                    $trx->biaya_total,
                                    0,
                                    ',',
                                    '.'
                                ) }}

                            @else

                                -

                            @endif

                        </td>


                        <td class="border border-gray-300
                                   px-3 py-2">

                            {{ strtoupper($trx->status) }}

                        </td>

                    </tr>

                @empty

                    <tr>

                        <td colspan="9"
                            class="border border-gray-300
                                   px-3 py-8
                                   text-center">

                            Tidak ada data transaksi.

                        </td>

                    </tr>

                @endforelse

            </tbody>

        </table>

    </div>


    {{-- FOOTER --}}
    <div class="flex justify-end mt-12">

        <div class="text-center w-48">

            <p class="text-sm">
                Dicetak pada
            </p>

            <p class="text-sm">

                {{ now()->format('d/m/Y H:i') }}

            </p>

            <div class="h-20"></div>

            <p class="font-bold border-t
                      border-gray-800 pt-2">

                Owner

            </p>

        </div>

    </div>

</div>


<style>

@media print {

    @page {
        size: A4 landscape;
        margin: 10mm;
    }

    body {
        background: white !important;
    }

}

</style>

</body>

</html>