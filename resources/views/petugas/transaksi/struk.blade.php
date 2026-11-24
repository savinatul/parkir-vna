<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Struk Parkir - Parkir Ajaa</title>

    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
        }

        @media print {
            body {
                background: white !important;
            }

            .no-print {
                display: none !important;
            }

            .struk {
                box-shadow: none !important;
            }
        }
    </style>
</head>

<body class="bg-gray-100 min-h-screen py-8">

    <div class="max-w-sm mx-auto px-4">

        {{-- STRUK --}}
        <div class="struk bg-white rounded-2xl shadow-lg overflow-hidden">

            {{-- HEADER --}}
            <div class="text-center px-6 pt-6 pb-4">

                <h1 class="text-xl font-bold text-gray-900">
                    PARKIR AJAA
                </h1>

                <p class="text-sm text-gray-500 mt-1">
                    Struk Pembayaran Parkir
                </p>

                {{-- garis ungu --}}
                <div class="w-16 h-1 bg-purple-600 rounded-full mx-auto mt-4"></div>

            </div>


            {{-- INFO TRANSAKSI --}}
            <div class="mx-5 border-y border-gray-200 py-4">

                <div class="flex justify-between text-sm mb-2">
                    <span class="text-gray-500">
                        No. Transaksi
                    </span>

                    <span class="font-semibold text-purple-700">
                        #{{ str_pad($transaksi->id_parkir, 5, '0', STR_PAD_LEFT) }}
                    </span>
                </div>

                <div class="flex justify-between text-sm">
                    <span class="text-gray-500">
                        Petugas
                    </span>

                    <span class="font-medium text-gray-800">
                        {{ $transaksi->user->nama_lengkap ?? '-' }}
                    </span>
                </div>

            </div>


            {{-- DATA KENDARAAN --}}
            <div class="px-5 py-5">

                <h2 class="text-sm font-bold text-purple-700 mb-3">
                    DATA KENDARAAN
                </h2>

                <div class="space-y-2 text-sm">

                    <div class="flex justify-between">
                        <span class="text-gray-500">
                            Plat Nomor
                        </span>

                        <span class="font-semibold">
                            {{ $transaksi->kendaraan->plat_nomor ?? '-' }}
                        </span>
                    </div>

                    <div class="flex justify-between">
                        <span class="text-gray-500">
                            Jenis
                        </span>

                        <span class="font-semibold">
                            {{ ucfirst($transaksi->kendaraan->jenis_kendaraan ?? '-') }}
                        </span>
                    </div>

                    <div class="flex justify-between">
                        <span class="text-gray-500">
                            Warna
                        </span>

                        <span class="font-semibold">
                            {{ ucfirst($transaksi->kendaraan->warna ?? '-') }}
                        </span>
                    </div>

                    <div class="flex justify-between">
                        <span class="text-gray-500">
                            Area Parkir
                        </span>

                        <span class="font-semibold">
                            {{ $transaksi->area->nama_area ?? '-' }}
                        </span>
                    </div>

                </div>


                {{-- PEMBATAS --}}
                <div class="border-t border-dashed border-gray-300 my-5"></div>


                {{-- WAKTU PARKIR --}}
                <h2 class="text-sm font-bold text-purple-700 mb-3">
                    WAKTU PARKIR
                </h2>

                <div class="space-y-2 text-sm">

                    <div class="flex justify-between gap-4">
                        <span class="text-gray-500">
                            Waktu Masuk
                        </span>

                        <span class="font-semibold text-right">
                            {{ \Carbon\Carbon::parse($transaksi->waktu_masuk)->format('d/m/Y H:i') }}
                        </span>
                    </div>

                    <div class="flex justify-between gap-4">
                        <span class="text-gray-500">
                            Waktu Keluar
                        </span>

                        <span class="font-semibold text-right">
                            {{ $transaksi->waktu_keluar
                                ? \Carbon\Carbon::parse($transaksi->waktu_keluar)->format('d/m/Y H:i')
                                : '-' }}
                        </span>
                    </div>

                    <div class="flex justify-between">
                        <span class="text-gray-500">
                            Durasi
                        </span>

                        <span class="font-semibold">
                            {{ $transaksi->durasi_jam ?? 0 }} Jam
                        </span>
                    </div>

                </div>


                {{-- PEMBATAS --}}
                <div class="border-t border-dashed border-gray-300 my-5"></div>


                {{-- PEMBAYARAN --}}
                <h2 class="text-sm font-bold text-purple-700 mb-3">
                    PEMBAYARAN
                </h2>

                <div class="flex justify-between text-sm">

                    <span class="text-gray-500">
                        Tarif / Jam
                    </span>

                    <span class="font-semibold">
                        Rp {{ number_format($transaksi->tarif->tarif_perjam ?? 0, 0, ',', '.') }}
                    </span>

                </div>


                {{-- TOTAL --}}
                <div class="bg-purple-50 rounded-xl px-4 py-4 mt-4">

                    <div class="flex justify-between items-center">

                        <span class="font-bold text-gray-800">
                            Total Bayar
                        </span>

                        <span class="text-xl font-bold text-purple-700">
                            Rp {{ number_format($transaksi->biaya_total ?? 0, 0, ',', '.') }}
                        </span>

                    </div>

                </div>

            </div>


            {{-- FOOTER --}}
            <div class="border-t border-gray-200 px-5 py-5 text-center">

                <p class="text-sm text-gray-600">
                    Terima kasih telah menggunakan
                    layanan parkir kami.
                </p>

                <p class="text-xs text-gray-400 mt-2">
                    Simpan struk ini sebagai bukti pembayaran.
                </p>

                <p class="text-xs font-semibold text-purple-600 mt-4">
                    — PARKIR AJAA —
                </p>

            </div>

        </div>


        {{-- BUTTON --}}
        <div class="no-print grid grid-cols-2 gap-3 mt-4">

            <button
                onclick="window.print()"
                class="bg-purple-600 hover:bg-purple-700 text-white py-3 rounded-xl font-semibold transition">
                🖨️ Cetak Struk
            </button>

            <a
                href="{{ url()->previous() }}"
                class="bg-gray-200 hover:bg-gray-300 text-gray-800 py-3 rounded-xl font-semibold text-center transition">
                ← Kembali
            </a>

        </div>

    </div>

</body>
</html>