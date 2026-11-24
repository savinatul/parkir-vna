@extends('layouts.app')

@section('page_title', 'Transaksi Parkir')
@section('page_subtitle', 'Kelola kendaraan masuk dan keluar')

@section('content')

<div class="space-y-6">

    {{-- Pesan sukses --}}
    @if(session('success'))
        <div class="bg-green-500/20 border border-green-400/30 text-green-300 px-5 py-4 rounded-xl">
            {{ session('success') }}
        </div>
    @endif

    {{-- Pesan error --}}
    @if(session('error'))
        <div class="bg-red-500/20 border border-red-400/30 text-red-300 px-5 py-4 rounded-xl">
            {{ session('error') }}
        </div>
    @endif

    {{-- Error validasi --}}
    @if($errors->any())
        <div class="bg-red-500/20 border border-red-400/30 text-red-300 px-5 py-4 rounded-xl">
            <ul class="list-disc list-inside">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Header --}}
    <div class="flex justify-between items-center">
        <div>
            <h2 class="text-2xl font-bold text-white">
                Data Transaksi Parkir
            </h2>
            <p class="text-gray-400 mt-1">
                Daftar kendaraan yang masuk dan keluar
            </p>
        </div>

        <a href="{{ route('petugas.transaksi.create') }}"
           class="px-5 py-3 rounded-xl bg-purple-600 hover:bg-purple-700 text-white font-semibold transition">
            + Kendaraan Masuk
        </a>
    </div>

    {{-- Table --}}
    <div class="bg-white/5 border border-white/10 rounded-2xl overflow-hidden">

        <div class="overflow-x-auto">

            <table class="w-full text-sm text-left">

                <thead class="bg-white/10 text-gray-300 uppercase text-xs">
                    <tr>
                        <th class="px-5 py-4">ID</th>
                        <th class="px-5 py-4">Kendaraan</th>
                        <th class="px-5 py-4">Tarif</th>
                        <th class="px-5 py-4">Area</th>
                        <th class="px-5 py-4">Masuk</th>
                        <th class="px-5 py-4">Keluar</th>
                        <th class="px-5 py-4">Durasi</th>
                        <th class="px-5 py-4">Biaya</th>
                        <th class="px-5 py-4">Status</th>
                        <th class="px-5 py-4 text-center">Aksi</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-white/10">

                    @forelse($transaksi as $trx)

                        <tr class="hover:bg-white/5 transition">

                            <td class="px-5 py-4 text-white font-semibold">
                                #{{ $trx->id_parkir }}
                            </td>

                            <td class="px-5 py-4">
                                @if($trx->kendaraan)
                                    <div class="text-white font-semibold">
                                        {{ $trx->kendaraan->plat_nomor }}
                                    </div>

                                    <div class="text-gray-400 text-xs">
                                        {{ $trx->kendaraan->jenis_kendaraan }}
                                    </div>
                                @else
                                    <span class="text-gray-500">
                                        -
                                    </span>
                                @endif
                            </td>

                            <td class="px-5 py-4 text-gray-300">
                                @if($trx->tarif)
                                    Rp {{ number_format($trx->tarif->tarif_perjam, 0, ',', '.') }}
                                    <div class="text-xs text-gray-500">
                                        / jam
                                    </div>
                                @else
                                    -
                                @endif
                            </td>

                            <td class="px-5 py-4 text-gray-300">
                                {{ $trx->area->nama_area ?? '-' }}
                            </td>

                            <td class="px-5 py-4 text-gray-300">
                                {{ $trx->waktu_masuk?->format('d/m/Y H:i') ?? '-' }}
                            </td>

                            <td class="px-5 py-4 text-gray-300">
                                {{ $trx->waktu_keluar?->format('d/m/Y H:i') ?? '-' }}
                            </td>

                            <td class="px-5 py-4 text-gray-300">
                                @if($trx->durasi_jam)
                                    {{ $trx->durasi_jam }} jam
                                @else
                                    -
                                @endif
                            </td>

                            <td class="px-5 py-4 text-white font-semibold">
                                @if($trx->biaya_total !== null)
                                    Rp {{ number_format($trx->biaya_total, 0, ',', '.') }}
                                @else
                                    -
                                @endif
                            </td>

                            <td class="px-5 py-4">

                                @if($trx->status === 'masuk')

                                    <span class="px-3 py-1 rounded-full text-xs font-semibold bg-yellow-500/20 text-yellow-300">
                                        MASUK
                                    </span>

                                @else

                                    <span class="px-3 py-1 rounded-full text-xs font-semibold bg-green-500/20 text-green-300">
                                        KELUAR
                                    </span>

                                @endif

                            </td>

                            <td class="px-5 py-4">

                                <div class="flex items-center justify-center gap-2">

                                    {{-- Detail --}}
                                    <a href="{{ route('petugas.transaksi.show', $trx->id_parkir) }}"
                                       class="px-3 py-2 rounded-lg bg-blue-500/20 text-blue-300 hover:bg-blue-500/30"
                                       title="Detail">
                                        👁
                                    </a>

                                    {{-- Edit --}}
                                    @if($trx->status === 'masuk')
                                        <a href="{{ route('petugas.transaksi.edit', $trx->id_parkir) }}"
                                           class="px-3 py-2 rounded-lg bg-yellow-500/20 text-yellow-300 hover:bg-yellow-500/30"
                                           title="Edit">
                                            ✏️
                                        </a>

                                        {{-- Keluar --}}
                                        <form action="{{ route('petugas.transaksi.keluar', $trx->id_parkir) }}"
                                              method="POST"
                                              onsubmit="return confirm('Yakin kendaraan ini akan keluar?')">

                                            @csrf

                                            <button type="submit"
                                                    class="px-3 py-2 rounded-lg bg-green-500/20 text-green-300 hover:bg-green-500/30"
                                                    title="Kendaraan Keluar">
                                                🚗
                                            </button>

                                        </form>
                                    @endif
                                    
                                    @if($trx->status === 'keluar')
                                        <a
                                            href="{{ route('petugas.transaksi.struk', $trx->id_parkir) }}"
                                            target="_blank"
                                            class="px-3 py-2 rounded-lg bg-purple-500/20 text-purple-300 hover:bg-purple-500/30"
                                            title="Cetak Struk">
                                            🧾
                                        </a>
                                    @endif

                                    {{-- Hapus --}}
                                    <form action="{{ route('petugas.transaksi.destroy', $trx->id_parkir) }}"
                                          method="POST"
                                          onsubmit="return confirm('Yakin ingin menghapus transaksi ini?')">

                                        @csrf
                                        @method('DELETE')

                                        <button type="submit"
                                                class="px-3 py-2 rounded-lg bg-red-500/20 text-red-300 hover:bg-red-500/30"
                                                title="Hapus">
                                            🗑
                                        </button>

                                    </form>

                                </div>

                            </td>

                        </tr>

                    @empty

                        <tr>
                            <td colspan="10"
                                class="px-5 py-12 text-center text-gray-400">

                                <div class="text-4xl mb-3">
                                    🅿️
                                </div>

                                <p class="text-lg">
                                    Belum ada transaksi parkir
                                </p>

                            </td>
                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

        {{-- Pagination --}}
        @if($transaksi->hasPages())
            <div class="px-5 py-4 border-t border-white/10">
                {{ $transaksi->links() }}
            </div>
        @endif

    </div>

</div>

@endsection