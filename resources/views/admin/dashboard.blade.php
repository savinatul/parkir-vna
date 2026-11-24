@extends('layouts.app')

@section('title', 'Dashboard Admin')
@section('page_title', 'Dashboard Admin')

@section('page_subtitle')
    Kelola kendaraan, area parkir, tarif, dan pengguna sistem.
@endsection

@section('content')
<div class="space-y-6">

    {{-- SELAMAT DATANG --}}
    <div class="rounded-2xl p-6 bg-gradient-to-r from-purple-700/80 to-indigo-700/80 border border-purple-500/30">
        <h1 class="text-2xl font-bold text-white">
            Selamat Datang Kembali, {{ auth()->user()->nama_lengkap }}! 👋
        </h1>
        <p class="text-purple-200 text-sm mt-2">
            Anda login sebagai Administrator Parkir Ajaa.
        </p>
    </div>

    {{-- STATISTIK CARDS --}}
    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-5">

        {{-- Kendaraan Aktif --}}
        <div class="glass-card rounded-2xl p-5">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-xs text-purple-300 uppercase font-semibold">Kendaraan Aktif</p>
                    <h2 class="text-3xl font-bold text-white mt-3">{{ $kendaraanAktif }}</h2>
                    <p class="text-xs text-emerald-400 mt-2">Sedang parkir</p>
                </div>
                <div class="w-11 h-11 rounded-xl bg-purple-600/20 flex items-center justify-center text-xl">🚘</div>
            </div>
        </div>

        {{-- Kapasitas Area --}}
        <div class="glass-card rounded-2xl p-5">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-xs text-purple-300 uppercase font-semibold">Kapasitas Area</p>
                    <h2 class="text-3xl font-bold text-white mt-3">
                        {{ $terisiTotal }} <span class="text-lg text-purple-400">/ {{ $kapasitasTotal }}</span>
                    </h2>
                    <p class="text-xs text-purple-400 mt-2">Terisi {{ $persentaseTerisi }}%</p>
                </div>
                <div class="w-11 h-11 rounded-xl bg-indigo-600/20 flex items-center justify-center text-xl">🅿️</div>
            </div>
            <div class="mt-4 w-full bg-purple-950 rounded-full h-2">
                <div class="bg-gradient-to-r from-purple-500 to-indigo-500 h-2 rounded-full" style="width: {{ min($persentaseTerisi, 100) }}%"></div>
            </div>
        </div>

        {{-- Pendapatan --}}
        <div class="glass-card rounded-2xl p-5">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-xs text-purple-300 uppercase font-semibold">Pendapatan Hari Ini</p>
                    <h2 class="text-2xl font-bold text-white mt-3">Rp {{ number_format($pendapatanHariIni, 0, ',', '.') }}</h2>
                    <p class="text-xs text-emerald-400 mt-2">↑ Real-time update</p>
                </div>
                <div class="w-11 h-11 rounded-xl bg-purple-600/20 flex items-center justify-center text-xl">💳</div>
            </div>
        </div>

        {{-- Petugas --}}
        <div class="glass-card rounded-2xl p-5">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-xs text-purple-300 uppercase font-semibold">Petugas Aktif</p>
                    <h2 class="text-3xl font-bold text-white mt-3">{{ $petugasAktif }}</h2>
                    <p class="text-xs text-purple-400 mt-2">Admin & Petugas terdaftar</p>
                </div>
                <div class="w-11 h-11 rounded-xl bg-purple-600/20 flex items-center justify-center text-xl">👥</div>
            </div>
        </div>

    </div>

    {{-- GRAFIK STATISTIK PENDAPATAN --}}
    <div class="glass-card rounded-2xl p-6">
        <div class="mb-4">
            <h2 class="text-lg font-bold text-white">Statistik Pendapatan Parkir</h2>
            <p class="text-xs text-purple-400 mt-1">Grafik perolehan pendapatan 7 hari terakhir</p>
        </div>
        <div class="relative w-full h-72">
            <canvas id="pendapatanChart"></canvas>
        </div>
    </div>

</div>

{{-- SCRIPT CHART.JS --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const ctx = document.getElementById('pendapatanChart').getContext('2d');
        
        const gradient = ctx.createLinearGradient(0, 0, 0, 300);
        gradient.addColorStop(0, 'rgba(168, 85, 247, 0.4)');
        gradient.addColorStop(1, 'rgba(168, 85, 247, 0.0)');

        new Chart(ctx, {
            type: 'line',
            data: {
                labels: {!! json_encode($chartLabels) !!},
                datasets: [{
                    label: 'Pendapatan',
                    data: {!! json_encode($chartData) !!},
                    borderColor: '#a855f7',
                    backgroundColor: gradient,
                    borderWidth: 3,
                    fill: true,
                    tension: 0.4,
                    pointBackgroundColor: '#a855f7',
                    pointBorderColor: '#fff',
                    pointRadius: 5,
                    pointHoverRadius: 7
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false }
                },
                scales: {
                    x: {
                        grid: { color: 'rgba(255, 255, 255, 0.05)' },
                        ticks: { color: '#c084fc' }
                    },
                    y: {
                        grid: { color: 'rgba(255, 255, 255, 0.05)' },
                        ticks: {
                            color: '#c084fc',
                            callback: function(value) {
                                return 'Rp ' + value.toLocaleString('id-ID');
                            }
                        }
                    }
                }
            }
        });
    });
</script>
@endsection