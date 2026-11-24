<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tarif;
use Illuminate\Http\Request;
use App\Models\LogAktivitas;
use Illuminate\Support\Facades\Auth;

class TarifController extends Controller
{
    public function index()
    {
        $tarif = Tarif::orderBy('id_tarif', 'desc')
            ->paginate(10);

        return view('admin.tarif.index', compact('tarif'));
    }

    public function create()
    {
        return view('admin.tarif.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'jenis_kendaraan' => 'required|in:motor,mobil,truk,lainnya',
            'tarif_perjam' => 'required|numeric|min:0',
        ]);

        Tarif::create([
            'jenis_kendaraan' => $request->jenis_kendaraan,
            'tarif_perjam' => $request->tarif_perjam,
        ]);

        return redirect()
            ->route('admin.tarif.index')
            ->with('success', 'Tarif berhasil ditambahkan.');
    }

    public function show(Tarif $tarif)
    {
        return view('admin.tarif.show', compact('tarif'));
    }

    public function edit(Tarif $tarif)
    {
        return view('admin.tarif.edit', compact('tarif'));
    }

    public function update(Request $request, Tarif $tarif)
    {
        $request->validate([
            'jenis_kendaraan' => 'required|in:motor,mobil,truk,lainnya',
            'tarif_perjam' => 'required|numeric|min:0',
        ]);

        $tarif->update([
            'jenis_kendaraan' => $request->jenis_kendaraan,
            'tarif_perjam' => $request->tarif_perjam,
        ]);

        return redirect()
            ->route('admin.tarif.index')
            ->with('success', 'Tarif berhasil diperbarui.');
    }

    public function destroy(Tarif $tarif)
    {
        $tarif->delete();

        return redirect()
            ->route('admin.tarif.index')
            ->with('success', 'Tarif berhasil dihapus.');
    }
}
