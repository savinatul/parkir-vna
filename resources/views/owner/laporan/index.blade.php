@extends('layouts.app')

@section('content')

<div class="space-y-6">

    {{-- HEADER --}}
    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">

        <div>
            <h1 class="text-2xl font-black text-white">
                Laporan Parkir
            </h1>

            <p class="text-sm text-purple-300 mt-1">
                Rekap seluruh aktivitas dan pendapatan parkir
            </p>
        </div>

        <a href="{{ route('owner.laporan.cetak', request()->query()) }}"
           target="_blank"
           class="inline-flex items-center justify-center gap-2
                  px-5 py-3 rounded-xl
                  bg-purple-600 hover:bg-purple-500
                  text-white text-sm font-bold
                  shadow-lg shadow-purple-900/20
                  transition">

            <span>🖨️</span>
            Cetak Laporan

        </a>

    </div>


    {{-- FILTER --}}
    <div class="bg-[#100b1d]
                border border-purple-900/40
                rounded-2xl p-5">

        <div class="flex items-center gap-2 mb-5">

            <span class="text-xl">
                🔎
            </span>

            <div>

                <h2 class="text-white font-bold">
                    Filter Laporan
                </h2>

                <p class="text-xs text-purple-400">
                    Pilih periode dan status transaksi
                </p>

            </div>

        </div>


        <form action="{{ route('owner.laporan.index') }}"
              method="GET"
              class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-4">

            {{-- TANGGAL MULAI --}}
            <div>

                <label class="block text-xs font-bold
                              text-purple-300 mb-2">

                    Tanggal Mulai

                </label>

                <input type="date"
                       name="tanggal_mulai"
                       value="{{ request('tanggal_mulai', $tanggalMulai ? $tanggalMulai->format('Y-m-d') : '') }}"
                       class="w-full
                              bg-[#0b0712]
                              border border-purple-900/50
                              rounded-xl
                              px-4 py-3
                              text-white text-sm
                              focus:outline-none
                              focus:border-purple-500">

            </div>


            {{-- TANGGAL SELESAI --}}
            <div>

                <label class="block text-xs font-bold
                              text-purple-300 mb-2">

                    Tanggal Selesai

                </label>

                <input type="date"
                       name="tanggal_selesai"
                       value="{{ request('tanggal_selesai', $tanggalSelesai ? $tanggalSelesai->format('Y-m-d') : '') }}"
                       class="w-full
                              bg-[#0b0712]
                              border border-purple-900/50
                              rounded-xl
                              px-4 py-3
                              text-white text-sm
                              focus:outline-none
                              focus:border-purple-500">

            </div>


            {{-- STATUS --}}
            <div>

                <label class="block text-xs font-bold
                              text-purple-300 mb-2">

                    Status Transaksi

                </label>

                <select name="status"
                        class="w-full
                               bg-[#0b0712]
                               border border-purple-900/50
                               rounded-xl
                               px-4 py-3
                               text-white text-sm
                               focus:outline-none
                               focus:border-purple-500">

                    <option value="">
                        Semua Status
                    </option>

                    <option value="masuk"
                        {{ request('status') == 'masuk' ? 'selected' : '' }}>
                        Kendaraan Masuk
                    </option>

                    <option value="keluar"
                        {{ request('status') == 'keluar' ? 'selected' : '' }}>
                        Kendaraan Keluar
                    </option>

                </select>

            </div>


            {{-- BUTTON --}}
            <div class="flex items-end gap-2">

                <button type="submit"
                        class="flex-1
                               px-4 py-3
                               rounded-xl
                               bg-purple-600
                               hover:bg-purple-500
                               text-white
                               font-bold text-sm
                               transition">

                    🔍 Terapkan

                </button>


                <a href="{{ route('owner.laporan.index') }}"
                   class="px-5 py-3
                          rounded-xl
                          bg-gray-800
                          hover:bg-gray-700
                          text-gray-200
                          font-bold text-sm
                          transition">

                    Reset

                </a>

            </div>

        </form>

    </div>


    {{-- PERIODE --}}
    <div class="flex items-center gap-2 text-sm">

        <span class="text-purple-400">
            Periode laporan:
        </span>

        <span class="font-bold text-white">

            {{ $tanggalMulai->format('d/m/Y') }}

            <span class="text-purple-500 mx-1">
                -
            </span>

            {{ $tanggalSelesai->format('d/m/Y') }}

        </span>

    </div>


    {{-- STATISTIK --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-5">

        {{-- TOTAL TRANSAKSI --}}
        <div class="bg-[#100b1d]
                    border border-purple-900/40
                    rounded-2xl p-5">

            <div class="flex items-center justify-between">

                <div>

                    <p class="text-xs text-purple-400">
                        Total Transaksi
                    </p>

                    <h2 class="text-3xl font-black
                               text-white mt-2">

                        {{ $totalTransaksi }}

                    </h2>

                </div>

                <div class="w-12 h-12
                            rounded-xl
                            bg-purple-600/15
                            flex items-center justify-center
                            text-2xl">

                    📊

                </div>

            </div>

        </div>


        {{-- MASUK --}}
        <div class="bg-[#100b1d]
                    border border-yellow-900/30
                    rounded-2xl p-5">

            <div class="flex items-center justify-between">

                <div>

                    <p class="text-xs text-purple-400">
                        Kendaraan Masuk
                    </p>

                    <h2 class="text-3xl font-black
                               text-white mt-2">

                        {{ $totalMasuk }}

                    </h2>

                </div>

                <div class="w-12 h-12
                            rounded-xl
                            bg-yellow-500/10
                            flex items-center justify-center
                            text-2xl">

                    🚘

                </div>

            </div>

        </div>


        {{-- KELUAR --}}
        <div class="bg-[#100b1d]
                    border border-green-900/30
                    rounded-2xl p-5">

            <div class="flex items-center justify-between">

                <div>

                    <p class="text-xs text-purple-400">
                        Kendaraan Keluar
                    </p>

                    <h2 class="text-3xl font-black
                               text-white mt-2">

                        {{ $totalKeluar }}

                    </h2>

                </div>

                <div class="w-12 h-12
                            rounded-xl
                            bg-green-500/10
                            flex items-center justify-center
                            text-2xl">

                    🏁

                </div>

            </div>

        </div>


        {{-- PENDAPATAN --}}
        <div class="bg-[#100b1d]
                    border border-purple-900/40
                    rounded-2xl p-5">

            <div class="flex items-center justify-between">

                <div>

                    <p class="text-xs text-purple-400">
                        Total Pendapatan
                    </p>

                    <h2 class="text-2xl font-black
                               text-white mt-2">

                        Rp {{ number_format(
                            $totalPendapatan,
                            0,
                            ',',
                            '.'
                        ) }}

                    </h2>

                </div>

                <div class="w-12 h-12
                            rounded-xl
                            bg-purple-600/15
                            flex items-center justify-center
                            text-2xl">

                    💰

                </div>

            </div>

        </div>

    </div>


    {{-- DURASI --}}
    <div class="bg-[#100b1d]
                border border-purple-900/40
                rounded-2xl p-5">

        <div class="flex items-center gap-4">

            <div class="w-12 h-12
                        rounded-xl
                        bg-purple-600/15
                        flex items-center justify-center
                        text-2xl">

                ⏱️

            </div>

            <div>

                <p class="text-xs text-purple-400">
                    Total Durasi Parkir
                </p>

                <p class="text-xl font-black text-white mt-1">

                    {{ $totalJam }} Jam

                </p>

            </div>

        </div>

    </div>


    {{-- TABEL --}}
    <div class="bg-[#100b1d]
                border border-purple-900/40
                rounded-2xl
                overflow-hidden">

        <div class="p-5
                    border-b border-purple-900/40
                    flex flex-col md:flex-row
                    md:items-center
                    md:justify-between
                    gap-3">

            <div>

                <h2 class="text-lg font-black text-white">
                    Detail Laporan
                </h2>

                <p class="text-xs text-purple-400 mt-1">
                    Data transaksi parkir berdasarkan periode
                </p>

            </div>

            <div class="text-xs text-purple-400">

                {{ $transaksi->total() }} data

            </div>

        </div>


        <div class="overflow-x-auto">

            <table class="w-full">

                <thead class="bg-[#181226]">

                    <tr class="text-left
                               text-[11px]
                               uppercase
                               tracking-wider
                               text-purple-300">

                        <th class="px-5 py-4">
                            No
                        </th>

                        <th class="px-5 py-4">
                            Kendaraan
                        </th>

                        <th class="px-5 py-4">
                            Jenis
                        </th>

                        <th class="px-5 py-4">
                            Area
                        </th>

                        <th class="px-5 py-4">
                            Masuk
                        </th>

                        <th class="px-5 py-4">
                            Keluar
                        </th>

                        <th class="px-5 py-4">
                            Durasi
                        </th>

                        <th class="px-5 py-4">
                            Biaya
                        </th>

                        <th class="px-5 py-4">
                            Status
                        </th>

                        <th class="px-5 py-4 text-center">
                            Aksi
                        </th>

                    </tr>

                </thead>


                <tbody class="divide-y divide-purple-900/30">

                    @forelse($transaksi as $trx)

                        <tr class="hover:bg-purple-950/20 transition">

                            {{-- NO --}}
                            <td class="px-5 py-4
                                       text-sm
                                       text-purple-300">

                                {{ $transaksi->firstItem() + $loop->index }}

                            </td>


                            {{-- KENDARAAN --}}
                            <td class="px-5 py-4">

                                <div>

                                    <p class="font-black text-white">

                                        {{ $trx->kendaraan->plat_nomor ?? '-' }}

                                    </p>

                                    <p class="text-[11px]
                                              text-purple-400">

                                        ID #{{ $trx->id_parkir }}

                                    </p>

                                </div>

                            </td>


                            {{-- JENIS --}}
                            <td class="px-5 py-4">

                                <span class="text-sm text-purple-200">

                                    {{ ucfirst(
                                        $trx->kendaraan->jenis_kendaraan ?? '-'
                                    ) }}

                                </span>

                            </td>


                            {{-- AREA --}}
                            <td class="px-5 py-4">

                                <span class="text-sm text-purple-200">

                                    {{ $trx->area->nama_area ?? '-' }}

                                </span>

                            </td>


                            {{-- MASUK --}}
                            <td class="px-5 py-4 whitespace-nowrap">

                                <p class="text-sm text-white">

                                    {{ $trx->waktu_masuk
                                        ? \Carbon\Carbon::parse(
                                            $trx->waktu_masuk
                                        )->format('d/m/Y')
                                        : '-'
                                    }}

                                </p>

                                <p class="text-[11px]
                                          text-purple-400">

                                    {{ $trx->waktu_masuk
                                        ? \Carbon\Carbon::parse(
                                            $trx->waktu_masuk
                                        )->format('H:i')
                                        : ''
                                    }}

                                </p>

                            </td>


                            {{-- KELUAR --}}
                            <td class="px-5 py-4 whitespace-nowrap">

                                @if($trx->waktu_keluar)

                                    <p class="text-sm text-white">

                                        {{ \Carbon\Carbon::parse(
                                            $trx->waktu_keluar
                                        )->format('d/m/Y') }}

                                    </p>

                                    <p class="text-[11px]
                                              text-purple-400">

                                        {{ \Carbon\Carbon::parse(
                                            $trx->waktu_keluar
                                        )->format('H:i') }}

                                    </p>

                                @else

                                    <span class="text-purple-500">
                                        —
                                    </span>

                                @endif

                            </td>


                            {{-- DURASI --}}
                            <td class="px-5 py-4">

                                @if($trx->durasi_jam)

                                    <span class="text-sm text-white">

                                        {{ $trx->durasi_jam }} jam

                                    </span>

                                @else

                                    <span class="text-purple-500">
                                        —
                                    </span>

                                @endif

                            </td>


                            {{-- BIAYA --}}
                            <td class="px-5 py-4 whitespace-nowrap">

                                @if($trx->biaya_total !== null)

                                    <span class="font-bold text-white">

                                        Rp {{ number_format(
                                            $trx->biaya_total,
                                            0,
                                            ',',
                                            '.'
                                        ) }}

                                    </span>

                                @else

                                    <span class="text-purple-500">
                                        —
                                    </span>

                                @endif

                            </td>


                            {{-- STATUS --}}
                            <td class="px-5 py-4">

                                @if($trx->status === 'masuk')

                                    <span class="inline-flex
                                                 px-3 py-1
                                                 rounded-lg
                                                 bg-yellow-500/10
                                                 border border-yellow-500/20
                                                 text-yellow-400
                                                 text-[10px]
                                                 font-black">

                                        MASUK

                                    </span>

                                @else

                                    <span class="inline-flex
                                                 px-3 py-1
                                                 rounded-lg
                                                 bg-green-500/10
                                                 border border-green-500/20
                                                 text-green-400
                                                 text-[10px]
                                                 font-black">

                                        KELUAR

                                    </span>

                                @endif

                            </td>


                            {{-- AKSI --}}
                            <td class="px-5 py-4">

                                <div class="flex justify-center">

                                    <a href="{{ route('owner.laporan.show', $trx->id_parkir) }}"
                                       class="px-3 py-2
                                              rounded-lg
                                              bg-purple-600/15
                                              hover:bg-purple-600/25
                                              text-purple-300
                                              text-xs
                                              font-bold
                                              transition">

                                        👁 Detail

                                    </a>

                                </div>

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td colspan="10"
                                class="px-5 py-16
                                       text-center">

                                <div class="text-4xl mb-3">
                                    📋
                                </div>

                                <p class="text-white font-bold">
                                    Belum ada data laporan
                                </p>

                                <p class="text-xs text-purple-400 mt-1">
                                    Tidak ada transaksi pada periode yang dipilih.
                                </p>

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>


        {{-- PAGINATION --}}
        @if($transaksi->hasPages())

            <div class="p-5
                        border-t border-purple-900/40">

                {{ $transaksi->links() }}

            </div>

        @endif

    </div>

</div>

@endsection