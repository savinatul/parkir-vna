@extends('layouts.app')

@section('title', 'Dashboard Petugas')
@section('page-title', 'Dashboard Petugas')

@section('content')
<div class="space-y-6">

    {{-- BANNER SELAMAT DATANG --}}
    <div class="rounded-2xl p-6 bg-gradient-to-r from-purple-700/80 to-indigo-700/80 border border-purple-500/30">
        <h1 class="text-2xl font-bold text-white">
            Selamat Datang Kembali, {{ auth()->user()->nama_lengkap }}! 🛠️
        </h1>

        <p class="text-purple-200 text-sm mt-2">
            Anda login sebagai Petugas Operasional Lapangan Parkir Ajaa.
        </p>
    </div>


    {{-- STATISTIK CARDS --}}
    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-5">

        {{-- Kendaraan Masuk Hari Ini --}}
        <div class="glass-card rounded-2xl p-5">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-xs text-purple-300 uppercase font-semibold">
                        Kendaraan Masuk Hari Ini
                    </p>

                    <h2 class="text-3xl font-bold text-white mt-3">
                        {{ $kendaraanMasukHariIni ?? 0 }}
                    </h2>

                    <p class="text-xs text-emerald-400 mt-2">
                        Pencatatan berhasil
                    </p>
                </div>

                <div class="w-11 h-11 rounded-xl bg-purple-600/20 flex items-center justify-center text-xl">
                    📥
                </div>
            </div>
        </div>


        {{-- Kapasitas Area --}}
        <div class="glass-card rounded-2xl p-5">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-xs text-purple-300 uppercase font-semibold">
                        Kapasitas Area
                    </p>

                    <h2 class="text-3xl font-bold text-white mt-3">
                        {{ $terisiTotal ?? 0 }}

                        <span class="text-lg text-purple-400">
                            / {{ $kapasitasTotal ?? 0 }}
                        </span>
                    </h2>

                    <p class="text-xs text-purple-400 mt-2">
                        Terisi {{ $persentaseTerisi ?? 0 }}%
                    </p>
                </div>

                <div class="w-11 h-11 rounded-xl bg-indigo-600/20 flex items-center justify-center text-xl">
                    🅿️
                </div>
            </div>

            <div class="mt-4 w-full bg-purple-950 rounded-full h-2">
                <div
                    class="bg-gradient-to-r from-purple-500 to-indigo-500 h-2 rounded-full"
                    style="width: {{ min($persentaseTerisi ?? 0, 100) }}%">
                </div>
            </div>
        </div>


        {{-- Sedang Parkir --}}
        <div class="glass-card rounded-2xl p-5">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-xs text-purple-300 uppercase font-semibold">
                        Sedang Parkir
                    </p>

                    <h2 class="text-3xl font-bold text-white mt-3">
                        {{ $kendaraanAktif ?? 0 }}
                    </h2>

                    <p class="text-xs text-purple-400 mt-2">
                        Butuh pengawasan lapangan
                    </p>
                </div>

                <div class="w-11 h-11 rounded-xl bg-purple-600/20 flex items-center justify-center text-xl">
                    🚘
                </div>
            </div>
        </div>


        {{-- Transaksi Keluar --}}
        <div class="glass-card rounded-2xl p-5">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-xs text-purple-300 uppercase font-semibold">
                        Transaksi Keluar
                    </p>

                    <h2 class="text-3xl font-bold text-white mt-3">
                        {{ $transaksiSelesaiHariIni ?? 0 }}
                    </h2>

                    <p class="text-xs text-emerald-400 mt-2">
                        Hari ini
                    </p>
                </div>

                <div class="w-11 h-11 rounded-xl bg-purple-600/20 flex items-center justify-center text-xl">
                    💳
                </div>
            </div>
        </div>

    </div>


    {{-- GRAFIK OPERASIONAL --}}
    <div class="glass-card rounded-2xl p-6">

        <div class="mb-4">
            <h2 class="text-lg font-bold text-white">
                Grafik Volume Kendaraan Masuk
            </h2>

            <p class="text-xs text-purple-400 mt-1">
                Data intensitas kendaraan dalam 7 hari terakhir
            </p>
        </div>

        <div class="relative w-full h-72">
            <canvas id="volumeChartPetugas"></canvas>
        </div>

    </div>

</div>


{{-- ================================================= --}}
{{-- CHART.JS --}}
{{-- ================================================= --}}

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
document.addEventListener("DOMContentLoaded", function () {

    const canvas = document.getElementById('volumeChartPetugas');

    if (!canvas) {
        return;
    }

    const ctx = canvas.getContext('2d');

    const gradient = ctx.createLinearGradient(0, 0, 0, 300);

    gradient.addColorStop(0, 'rgba(168, 85, 247, 0.4)');
    gradient.addColorStop(1, 'rgba(168, 85, 247, 0.05)');

    const chartLabels = @json($chartLabels);
    const chartData = @json($chartData);

    new Chart(ctx, {
        type: 'bar',

        data: {
            labels: chartLabels,

            datasets: [{
                label: 'Kendaraan Masuk',

                data: chartData,

                backgroundColor: gradient,

                borderColor: '#a855f7',

                borderWidth: 2,

                borderRadius: 8
            }]
        },

        options: {
            responsive: true,

            maintainAspectRatio: false,

            plugins: {
                legend: {
                    display: false
                }
            },

            scales: {
                x: {
                    grid: {
                        color: 'rgba(255, 255, 255, 0.05)'
                    },

                    ticks: {
                        color: '#c084fc'
                    }
                },

                y: {
                    beginAtZero: true,

                    grid: {
                        color: 'rgba(255, 255, 255, 0.05)'
                    },

                    ticks: {
                        color: '#c084fc',
                        precision: 0
                    }
                }
            }
        }
    });

});
</script>

@endsection