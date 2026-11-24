<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use App\Models\Transaksi;
use App\Models\Kendaraan;
use App\Models\Tarif;
use App\Models\AreaParkir;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class TransaksiController extends Controller
{
    public function index()
    {
        $transaksi = Transaksi::with([
            'kendaraan',
            'tarif',
            'user',
            'area'
        ])
        ->orderByDesc('id_parkir')
        ->paginate(10);

        return view('petugas.transaksi.index', compact('transaksi'));
    }

    public function create()
    {
        // Kendaraan yang masih parkir tidak ditampilkan
        $kendaraanMasuk = Transaksi::where('status', 'masuk')
            ->pluck('id_kendaraan');

        $kendaraan = Kendaraan::whereNotIn(
            'id_kendaraan',
            $kendaraanMasuk
        )->get();

        // Ambil semua tarif
        $tarif = Tarif::orderBy('jenis_kendaraan')->get();

        // Ambil area yang masih tersedia
        $area = AreaParkir::whereColumn(
            'terisi',
            '<',
            'kapasitas'
        )->get();

        return view('petugas.transaksi.create', compact(
            'kendaraan',
            'tarif',
            'area'
        ));
    }

        public function store(Request $request)
    {
        $request->validate([
            'id_kendaraan' => 'required|exists:tb_kendaraan,id_kendaraan',
            'id_area'      => 'required|exists:tb_area_parkir,id_area',
        ], [
            'id_kendaraan.required' => 'Kendaraan wajib dipilih.',
            'id_kendaraan.exists'   => 'Kendaraan tidak ditemukan.',
            'id_area.required'      => 'Area parkir wajib dipilih.',
            'id_area.exists'        => 'Area parkir tidak ditemukan.',
        ]);

        $kendaraan = Kendaraan::findOrFail($request->id_kendaraan);
        $area      = AreaParkir::findOrFail($request->id_area);

        // 1. Cek kecocokan jenis kendaraan dengan area parkir
        if ($area->jenis_kendaraan !== $kendaraan->jenis_kendaraan) {
            return back()
                ->withInput()
                ->with('error', 'Area ' . $area->nama_area . ' hanya diperuntukkan bagi ' . $area->jenis_kendaraan . '.');
        }

        // 2. Cek apakah kapasitas area sudah penuh
        if ($area->terisi >= $area->kapasitas) {
            return back()
                ->withInput()
                ->with('error', 'Area ' . $area->nama_area . ' sudah penuh.');
        }

        // 3. Cari tarif otomatis berdasarkan jenis kendaraan
        $tarif = Tarif::where('jenis_kendaraan', $kendaraan->jenis_kendaraan)
            ->where('tarif_perjam', '>', 0)
            ->first();

        if (!$tarif) {
            return back()
                ->withInput()
                ->with('error', 'Tarif untuk jenis kendaraan tersebut belum tersedia.');
        }

        // 4. Cek apakah kendaraan masih parkir
        $sudahParkir = Transaksi::where('id_kendaraan', $request->id_kendaraan)
            ->where('status', 'masuk')
            ->exists();

        if ($sudahParkir) {
            return back()
                ->withInput()
                ->with('error', 'Kendaraan tersebut masih berada di area parkir.');
        }

        // 5. Simpan transaksi dan tambah jumlah terisi pada area
        DB::transaction(function () use ($request, $tarif) {
            $idParkir = (Transaksi::max('id_parkir') ?? 0) + 1;

            Transaksi::create([
                'id_parkir'    => $idParkir,
                'id_kendaraan' => $request->id_kendaraan,
                'waktu_masuk'  => now(),
                'waktu_keluar' => null,
                'id_tarif'     => $tarif->id_tarif,
                'durasi_jam'   => null,
                'biaya_total'  => null,
                'status'       => 'masuk',
                'id_user'      => Auth::id(),
                'id_area'      => $request->id_area,
            ]);

            AreaParkir::where('id_area', $request->id_area)->increment('terisi');
        });

        return redirect()
            ->route('petugas.transaksi.index')
            ->with('success', 'Kendaraan berhasil dicatat masuk dengan tarif otomatis.');
    }


    public function edit($id)
    {
        $transaksi = Transaksi::with([
            'kendaraan',
            'tarif',
            'area'
        ])->findOrFail($id);

        $kendaraan = Kendaraan::all();
        $tarif = Tarif::orderBy('jenis_kendaraan')->get();
        $area = AreaParkir::all();

        return view(
            'petugas.transaksi.edit',
            compact(
                'transaksi',
                'kendaraan',
                'tarif',
                'area'
            )
        );
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'id_kendaraan' => 'required|exists:tb_kendaraan,id_kendaraan',
            'id_tarif' => 'required|exists:tb_tarif,id_tarif',
            'id_area' => 'required|exists:tb_area_parkir,id_area',
        ], [
            'id_kendaraan.required' => 'Kendaraan wajib dipilih.',
            'id_kendaraan.exists' => 'Kendaraan tidak ditemukan.',
            'id_tarif.required' => 'Tarif wajib dipilih.',
            'id_tarif.exists' => 'Tarif tidak ditemukan.',
            'id_area.required' => 'Area parkir wajib dipilih.',
            'id_area.exists' => 'Area parkir tidak ditemukan.',
        ]);

        $transaksi = Transaksi::findOrFail($id);

        // Cek apakah kendaraan sedang digunakan transaksi lain
        $sudahParkir = Transaksi::where(
            'id_kendaraan',
            $request->id_kendaraan
        )
        ->where('status', 'masuk')
        ->where('id_parkir', '!=', $id)
        ->exists();

        if ($sudahParkir) {
            return back()
                ->withInput()
                ->with(
                    'error',
                    'Kendaraan tersebut masih berada di area parkir.'
                );
        }

        DB::transaction(function () use ($request, $transaksi) {
            // Kalau area parkir berubah
            if ($transaksi->id_area != $request->id_area) {
                // Kurangi area lama
                if ($transaksi->status === 'masuk') {
                    AreaParkir::where(
                        'id_area',
                        $transaksi->id_area
                    )
                    ->where('terisi', '>', 0)
                    ->decrement('terisi');
                }

                // Tambah area baru
                if ($transaksi->status === 'masuk') {
                    AreaParkir::where(
                        'id_area',
                        $request->id_area
                    )
                    ->increment('terisi');
                }
            }

            $transaksi->update([
                'id_kendaraan' => $request->id_kendaraan,
                'id_tarif' => $request->id_tarif,
                'id_area' => $request->id_area,
            ]);
        });

        return redirect()
            ->route('petugas.transaksi.index')
            ->with(
                'success',
                'Transaksi berhasil diperbarui.'
            );
    }

    public function show($id)
    {
        $transaksi = Transaksi::with([
            'kendaraan',
            'tarif',
            'user',
            'area'
        ])->findOrFail($id);

        return view(
            'petugas.transaksi.show',
            compact('transaksi')
        );
    }

        public function keluar($id)
    {
        $transaksi = Transaksi::with([
            'tarif',
            'area'
        ])->findOrFail($id);

        if ($transaksi->status === 'keluar') {
            return back()->with(
                'error',
                'Kendaraan tersebut sudah keluar.'
            );
        }

        if (!$transaksi->tarif) {
            return back()->with(
                'error',
                'Tarif transaksi tidak ditemukan. Silakan periksa data tarif kendaraan.'
            );
        }

        $waktuKeluar = now();

        // Hitung selisih menit lalu bulatkan ke atas (minimal 1 jam)
        $menit = Carbon::parse($transaksi->waktu_masuk)->diffInMinutes($waktuKeluar);
        $durasiJam = max(1, (int) ceil($menit / 60));

        // Ambil tarif per jam
        $tarifPerJam = $transaksi->tarif->tarif_perjam;

        // Hitung total biaya
        $biayaTotal = $durasiJam * $tarifPerJam;

        DB::transaction(function () use (
            $transaksi,
            $waktuKeluar,
            $durasiJam,
            $biayaTotal
        ) {
            $transaksi->update([
                'waktu_keluar' => $waktuKeluar,
                'durasi_jam'   => $durasiJam,
                'biaya_total'  => $biayaTotal,
                'status'       => 'keluar',
            ]);

            if ($transaksi->id_area) {
                AreaParkir::where('id_area', $transaksi->id_area)
                    ->where('terisi', '>', 0)
                    ->decrement('terisi');
            }
        });

        return redirect()
            ->route('petugas.transaksi.index')
            ->with(
                'success',
                'Kendaraan berhasil keluar. Total biaya: Rp ' . number_format($biayaTotal, 0, ',', '.')
            );
    }


    public function destroy($id)
    {
        DB::transaction(function () use ($id) {
            $transaksi = Transaksi::findOrFail($id);

            // Kalau transaksi masih MASUK, kurangi jumlah kendaraan di area
            if ($transaksi->status === 'masuk') {
                AreaParkir::where(
                    'id_area',
                    $transaksi->id_area
                )
                ->where('terisi', '>', 0)
                ->decrement('terisi');
            }

            // Hapus transaksi
            $transaksi->delete();
        });

        return redirect()
            ->route('petugas.transaksi.index')
            ->with(
                'success',
                'Transaksi berhasil dihapus.'
            );
    }

    public function struk($id)
    {
        $transaksi = Transaksi::with([
            'kendaraan',
            'tarif',
            'user',
            'area'
        ])->findOrFail($id);

        return view('petugas.transaksi.struk', compact('transaksi'));
    }
}