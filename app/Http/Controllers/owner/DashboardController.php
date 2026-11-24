<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Models\Transaksi;
use App\Models\AreaParkir;
use App\Models\User;
use App\Models\Kendaraan;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // Kendaraan yang sedang parkir
        $kendaraanAktif = Transaksi::where('status', 'masuk')->count();

        // Total kapasitas parkir
        $kapasitasTotal = AreaParkir::sum('kapasitas');

        // Total terisi
        $terisiTotal = $kendaraanAktif;

        // Persentase terisi
        $persentaseTerisi = $kapasitasTotal > 0
            ? round(($terisiTotal / $kapasitasTotal) * 100)
            : 0;

        // TOTAL PENDAPATAN
        $totalPendapatan = DB::table('tb_transaksi')
            ->where('status', 'keluar')
            ->sum('biaya_total');
            
        // TOTAL TRANSAKSI
        $totalTransaksi = Transaksi::where('status', 'keluar')->count();

        // Total kendaraan
        $totalKendaraan = Kendaraan::count();

        // Petugas aktif
        $petugasAktif = User::where('role', 'petugas')
            ->where('status_aktif', 1)
            ->count();

        // Transaksi terbaru
        $transaksiTerbaru = Transaksi::with('kendaraan')
            ->latest('waktu_masuk')
            ->limit(10)
            ->get();

       // --- KODINGAN UNTUK MENGISI GRAFIK ---
        // Contoh: Mengambil pendapatan berdasarkan hari dalam seminggu atau tanggal
        $pendapatanPerHari = DB::table('tb_transaksi')
            ->select(
                DB::raw('SUM(biaya_total) as total'),
                DB::raw('DAYOFWEEK(waktu_keluar) as hari')
            )
            ->where('status', 'keluar')
            ->groupBy(DB::raw('DAYOFWEEK(waktu_keluar)'))
            ->pluck('total', 'hari');

        // Mapping hari dalam MySQL (1=Minggu, 2=Senin, ..., 7=Sabtu)
        // Kita susun agar urut dari Senin (Senin - Minggu)
        $chartData = [];
        $mappingHari = [2, 3, 4, 5, 6, 7, 1]; // Senin sampai Minggu
        foreach ($mappingHari as $h) {
            $chartData[] = $pendapatanPerHari[$h] ?? 0;
        }

        $chartLabels = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'];
        // ------------------------------------

        return view('owner.dashboard', compact(
            'kendaraanAktif',
            'kapasitasTotal',
            'terisiTotal',
            'persentaseTerisi',
            'totalPendapatan',
            'totalTransaksi',
            'totalKendaraan',
            'petugasAktif',
            'transaksiTerbaru',
            'chartLabels', // <-- Masukkan ke compact
            'chartData'    // <-- Masukkan ke compact
        ));
    }
}