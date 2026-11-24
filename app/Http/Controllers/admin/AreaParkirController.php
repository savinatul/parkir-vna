<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AreaParkir;
use Illuminate\Http\Request;
use App\Models\LogAktivitas;
use Illuminate\Support\Facades\Auth;

class AreaParkirController extends Controller
{
    public function index()
    {
        $areaParkir = AreaParkir::orderBy('id_area', 'desc')
            ->paginate(10);

        return view('admin.area-parkir.index', compact('areaParkir'));
    }

    public function create()
    {
        return view('admin.area-parkir.create');
    }

    public function store(Request $request)
    {
       $request->validate([
            'nama_area'       => 'required|string|max:100',
            'jenis_kendaraan' => 'required|in:motor,mobil,truk,lainnya', // <-- TAMBAHKAN INI
            'kapasitas'       => 'required|integer|min:1',
        ]);

        AreaParkir::create([
            'nama_area'       => $request->nama_area,
            'jenis_kendaraan' => $request->jenis_kendaraan, // <-- TAMBAHKAN INI
            'kapasitas'       => $request->kapasitas,
            'terisi'          => 0,
        ]);

        return redirect()
            ->route('admin.area-parkir.index')
            ->with('success', 'Area parkir berhasil ditambahkan.');
    }

    public function show(AreaParkir $areaParkir)
    {
        return view(
            'admin.area-parkir.show',
            compact('areaParkir')
        );
    }

    public function edit(AreaParkir $areaParkir)
    {
        return view(
            'admin.area-parkir.edit',
            compact('areaParkir')
        );
    }

    public function update(Request $request, AreaParkir $areaParkir)
    {
       $request->validate([
            'nama_area'       => 'required|string|max:100',
            'jenis_kendaraan' => 'required|in:motor,mobil,truk,lainnya', // <-- TAMBAHKAN INI
            'kapasitas'       => 'required|integer|min:1',
        ]);

        // Kendaraan yang terisi tidak boleh melebihi kapasitas
        if ($request->terisi > $request->kapasitas) {
            return back()
                ->withInput()
                ->withErrors([
                    'terisi' => 'Jumlah kendaraan tidak boleh melebihi kapasitas area.'
                ]);
        }

        $areaParkir->update([
            'nama_area'       => $request->nama_area,
            'jenis_kendaraan' => $request->jenis_kendaraan, // <-- TAMBAHKAN INI
            'kapasitas'       => $request->kapasitas,
        ]);

        return redirect()
            ->route('admin.area-parkir.index')
            ->with('success', 'Area parkir berhasil diperbarui.');
    }

    public function destroy(AreaParkir $areaParkir)
    {
        $areaParkir->delete();

        return redirect()
            ->route('admin.area-parkir.index')
            ->with('success', 'Area parkir berhasil dihapus.');
    }
}