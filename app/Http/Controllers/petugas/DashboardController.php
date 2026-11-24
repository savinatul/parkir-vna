<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use App\Models\Transaksi;
use App\Models\AreaParkir;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // Kendaraan yang masih sedang parkir
        $kendaraanAktif = Transaksi::where(
            'status',
            'masuk'
        )->count();

        // Total kapasitas seluruh area
        $kapasitasTotal = AreaParkir::sum('kapasitas');

        // Total kendaraan yang sedang mengisi area
        $terisiTotal = AreaParkir::sum('terisi');

        // Slot tersedia (Diperbaiki: ditambahkan operator minus)
        $slotTersedia = $kapasitasTotal - $terisiTotal;

        // Persentase area terisi
        $persentaseTerisi = $kapasitasTotal > 0
            ? round(($terisiTotal / $kapasitasTotal) * 100)
            : 0;

        // Semua kendaraan yang masuk hari ini
        $kendaraanMasukHariIni = Transaksi::whereDate(
            'waktu_masuk',
            today()
        )->count();

        // Transaksi keluar hari ini
        $transaksiSelesaiHariIni = Transaksi::whereDate(
            'waktu_keluar',
            today()
        )
        ->where('status', 'keluar')
        ->count();

        // Total transaksi hari ini
        $transaksiHariIni = Transaksi::whereDate(
            'waktu_masuk',
            today()
        )->count();

        // =====================================================
        // GRAFIK 7 HARI TERAKHIR
        // =====================================================

        $chartLabels = [];
        $chartData = [];

        for ($i = 6; $i >= 0; $i--) {
            $tanggal = Carbon::today()->subDays($i);

            // Nama hari
            $chartLabels[] = $tanggal->translatedFormat('l');

            // Jumlah kendaraan masuk pada hari tersebut
            $chartData[] = Transaksi::whereDate(
                'waktu_masuk',
                $tanggal
            )->count();
        }

        // =====================================================
        // TRANSAKSI TERBARU
        // =====================================================

        $transaksiTerbaru = Transaksi::with([
            'kendaraan',
            'area'
        ])
        ->latest('waktu_masuk')
        ->limit(10)
        ->get();

        return view('petugas.dashboard', compact(
            'kendaraanAktif',
            'kapasitasTotal',
            'terisiTotal',
            'slotTersedia',
            'persentaseTerisi',
            'kendaraanMasukHariIni',
            'transaksiSelesaiHariIni',
            'transaksiHariIni',
            'chartLabels', // Ditambahkan agar grafik terbaca di view
            'chartData',   // Ditambahkan agar grafik terbaca di view
            'transaksiTerbaru'
        ));
    }

    public function area()
    {
        $areas = AreaParkir::orderBy(
            'nama_area'
        )->get();

        return view(
            'petugas.area.index',
            compact('areas')
        );
    }
}