<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transaksi;
use App\Models\AreaParkir;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $hariIni = Carbon::now('Asia/Jakarta')->toDateString();

        // 1. Data Cards Summary
        $kendaraanAktif = Transaksi::where('status', 'masuk')->count();
        $kapasitasTotal = AreaParkir::sum('kapasitas');
        $terisiTotal = Transaksi::where('status', 'masuk')->count();
        $persentaseTerisi = $kapasitasTotal > 0 ? round(($terisiTotal / $kapasitasTotal) * 100) : 0;
        
        // Pendapatan hari ini (menggunakan kolom biaya_total)
        $pendapatanHariIni = Transaksi::where('status', 'keluar')
            ->whereDate('waktu_keluar', $hariIni)
            ->sum('biaya_total');

        $petugasAktif = User::whereIn('role', ['admin', 'petugas'])
            ->where('status_aktif', 1)
            ->count();

        // 2. Data Grafik Pendapatan 7 Hari Terakhir
        $grafikPendapatan = Transaksi::where('status', 'keluar')
            ->select(
                DB::raw('DATE(waktu_keluar) as tanggal'),
                DB::raw('SUM(biaya_total) as total')
            )
            ->whereDate('waktu_keluar', '>=', Carbon::now('Asia/Jakarta')->subDays(6))
            ->groupBy('tanggal')
            ->orderBy('tanggal', 'ASC')
            ->get();

        $chartLabels = [];
        $chartData = [];

        // Loop untuk mengisi data grafik 7 hari terakhir
        for ($i = 6; $i >= 0; $i--) {
            $tgl = Carbon::now('Asia/Jakarta')->subDays($i)->toDateString();
            $chartLabels[] = Carbon::parse($tgl)->translatedFormat('d M');
            
            $dataHarian = $grafikPendapatan->firstWhere('tanggal', $tgl);
            $chartData[] = $dataHarian ? $dataHarian->total : 0;
        }

        return view('admin.dashboard', compact(
            'kendaraanAktif',
            'kapasitasTotal',
            'terisiTotal',
            'persentaseTerisi',
            'pendapatanHariIni',
            'petugasAktif',
            'chartLabels',
            'chartData'
        ));
    }
}