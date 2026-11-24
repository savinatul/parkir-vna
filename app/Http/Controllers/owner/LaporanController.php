<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Models\Transaksi;
use Carbon\Carbon;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    /**
     * ==========================================
     * LAPORAN
     * ==========================================
     */
    public function index(Request $request)
    {
        // Tanggal laporan
        $tanggalMulai = $request->tanggal_mulai
            ? Carbon::parse($request->tanggal_mulai)
            : Carbon::today();

        $tanggalSelesai = $request->tanggal_selesai
            ? Carbon::parse($request->tanggal_selesai)
            : Carbon::today();

        $status = $request->status;


        // ==========================================
        // DATA TRANSAKSI
        // ==========================================

        $query = Transaksi::with([
            'kendaraan',
            'tarif',
            'area',
            'user'
        ]);


        /*
        |--------------------------------------------------------------------------
        | TRANSAKSI YANG RELEVAN DENGAN PERIODE
        |--------------------------------------------------------------------------
        |
        | Transaksi masuk pada periode
        | ATAU
        | transaksi keluar pada periode.
        |
        */

        $query->where(function ($q) use ($tanggalMulai, $tanggalSelesai) {

            $q->whereBetween('waktu_masuk', [
                $tanggalMulai->copy()->startOfDay(),
                $tanggalSelesai->copy()->endOfDay()
            ])

            ->orWhereBetween('waktu_keluar', [
                $tanggalMulai->copy()->startOfDay(),
                $tanggalSelesai->copy()->endOfDay()
            ]);

        });


        // Filter status
        if ($status) {
            $query->where('status', $status);
        }


        // Ambil transaksi
        $transaksi = $query
            ->orderByDesc('waktu_masuk')
            ->paginate(10)
            ->withQueryString();


        // ==========================================
        // STATISTIK TRANSAKSI
        // ==========================================

        /*
        |--------------------------------------------------------------------------
        | TOTAL TRANSAKSI
        |--------------------------------------------------------------------------
        */

        $statistikQuery = Transaksi::query();

        $statistikQuery->where(function ($q) use ($tanggalMulai, $tanggalSelesai) {

            $q->whereBetween('waktu_masuk', [
                $tanggalMulai->copy()->startOfDay(),
                $tanggalSelesai->copy()->endOfDay()
            ])

            ->orWhereBetween('waktu_keluar', [
                $tanggalMulai->copy()->startOfDay(),
                $tanggalSelesai->copy()->endOfDay()
            ]);

        });


        // Filter status statistik
        if ($status) {
            $statistikQuery->where('status', $status);
        }


        $totalTransaksi = (clone $statistikQuery)->count();


        // ==========================================
        // KENDARAAN MASUK
        // ==========================================

        $totalMasuk = Transaksi::whereBetween('waktu_masuk', [
            $tanggalMulai->copy()->startOfDay(),
            $tanggalSelesai->copy()->endOfDay()
        ])
        ->when($status, function ($query) use ($status) {
            $query->where('status', $status);
        })
        ->count();


        // ==========================================
        // KENDARAAN KELUAR
        // ==========================================

        $totalKeluar = Transaksi::whereBetween('waktu_keluar', [
            $tanggalMulai->copy()->startOfDay(),
            $tanggalSelesai->copy()->endOfDay()
        ])
        ->where('status', 'keluar')
        ->count();


        // ==========================================
        // TOTAL PENDAPATAN
        // ==========================================

        $totalPendapatan = Transaksi::whereBetween('waktu_keluar', [
            $tanggalMulai->copy()->startOfDay(),
            $tanggalSelesai->copy()->endOfDay()
        ])
        ->where('status', 'keluar')
        ->sum('biaya_total');


        // ==========================================
        // TOTAL DURASI
        // ==========================================

        $totalJam = Transaksi::whereBetween('waktu_keluar', [
            $tanggalMulai->copy()->startOfDay(),
            $tanggalSelesai->copy()->endOfDay()
        ])
        ->where('status', 'keluar')
        ->sum('durasi_jam');


        // ==========================================
        // VIEW
        // ==========================================

        return view('owner.laporan.index', compact(
            'transaksi',
            'tanggalMulai',
            'tanggalSelesai',
            'status',
            'totalTransaksi',
            'totalMasuk',
            'totalKeluar',
            'totalPendapatan',
            'totalJam'
        ));
    }


    /**
     * ==========================================
     * DETAIL LAPORAN
     * ==========================================
     */
    public function show($id)
    {
        $transaksi = Transaksi::with([
            'kendaraan',
            'tarif',
            'area',
            'user'
        ])->findOrFail($id);

        return view(
            'owner.laporan.show',
            compact('transaksi')
        );
    }


    /**
     * ==========================================
     * CETAK LAPORAN
     * ==========================================
     */
    public function cetak(Request $request)
    {
        // Tanggal laporan
        $tanggalMulai = $request->tanggal_mulai
            ? Carbon::parse($request->tanggal_mulai)
            : Carbon::today();

        $tanggalSelesai = $request->tanggal_selesai
            ? Carbon::parse($request->tanggal_selesai)
            : Carbon::today();

        $status = $request->status;


        // ==========================================
        // TRANSAKSI
        // ==========================================

        $query = Transaksi::with([
            'kendaraan',
            'tarif',
            'area',
            'user'
        ]);


        $query->where(function ($q) use ($tanggalMulai, $tanggalSelesai) {

            $q->whereBetween('waktu_masuk', [
                $tanggalMulai->copy()->startOfDay(),
                $tanggalSelesai->copy()->endOfDay()
            ])

            ->orWhereBetween('waktu_keluar', [
                $tanggalMulai->copy()->startOfDay(),
                $tanggalSelesai->copy()->endOfDay()
            ]);

        });


        if ($status) {
            $query->where('status', $status);
        }


        $transaksi = $query
            ->orderByDesc('waktu_masuk')
            ->get();


        // ==========================================
        // STATISTIK
        // ==========================================

        $totalTransaksi = $transaksi->count();

        $totalMasuk = $transaksi
            ->filter(function ($trx) use ($tanggalMulai, $tanggalSelesai) {

                return $trx->waktu_masuk >= $tanggalMulai->copy()->startOfDay()
                    && $trx->waktu_masuk <= $tanggalSelesai->copy()->endOfDay();

            })
            ->count();


        $totalKeluar = $transaksi
            ->filter(function ($trx) use ($tanggalMulai, $tanggalSelesai) {

                return $trx->status === 'keluar'
                    && $trx->waktu_keluar
                    && $trx->waktu_keluar >= $tanggalMulai->copy()->startOfDay()
                    && $trx->waktu_keluar <= $tanggalSelesai->copy()->endOfDay();

            })
            ->count();


        $totalPendapatan = $transaksi
            ->filter(function ($trx) use ($tanggalMulai, $tanggalSelesai) {

                return $trx->status === 'keluar'
                    && $trx->waktu_keluar
                    && $trx->waktu_keluar >= $tanggalMulai->copy()->startOfDay()
                    && $trx->waktu_keluar <= $tanggalSelesai->copy()->endOfDay();

            })
            ->sum('biaya_total');


        $totalJam = $transaksi
            ->filter(function ($trx) use ($tanggalMulai, $tanggalSelesai) {

                return $trx->status === 'keluar'
                    && $trx->waktu_keluar
                    && $trx->waktu_keluar >= $tanggalMulai->copy()->startOfDay()
                    && $trx->waktu_keluar <= $tanggalSelesai->copy()->endOfDay();

            })
            ->sum('durasi_jam');


        return view('owner.laporan.cetak', compact(
            'transaksi',
            'tanggalMulai',
            'tanggalSelesai',
            'status',
            'totalTransaksi',
            'totalMasuk',
            'totalKeluar',
            'totalPendapatan',
            'totalJam'
        ));
    }
}