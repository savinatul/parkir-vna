<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kendaraan;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\LogAktivitas;
use Illuminate\Support\Facades\Auth;

class KendaraanController extends Controller
{
    public function index()
    {
        $kendaraan = Kendaraan::with('petugas')
            ->latest('id_kendaraan')
            ->paginate(10);

        return view('admin.kendaraan.index', compact('kendaraan'));
    }

    public function create()
    {
        // Hanya mengambil user yang memiliki role PETUGAS
        // dan statusnya masih aktif
        $petugas = User::where('role', 'petugas')
            ->where('status_aktif', 1)
            ->orderBy('nama_lengkap')
            ->get();

        return view('admin.kendaraan.create', compact('petugas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'plat_nomor' => 'required|string|max:20',
            'kode_rfid' => 'nullable|string|max:50|unique:tb_kendaraan,kode_rfid',
            'jenis_kendaraan' => 'required|in:motor,mobil,truk,lainnya',
            'warna' => 'required|string|max:30',
            'pemilik' => 'required|string|max:100',
            'id_user' => 'required|exists:tb_user,id_user',
        ], [
            'plat_nomor.required' => 'Plat nomor wajib diisi.',
            'kode_rfid.unique' => 'Kartu RFID ini sudah terdaftar pada kendaraan lain.',
            'jenis_kendaraan.required' => 'Jenis kendaraan wajib dipilih.',
            'warna.required' => 'Warna kendaraan wajib diisi.',
            'pemilik.required' => 'Nama pemilik wajib diisi.',
            'id_user.required' => 'Petugas wajib dipilih.',
            'id_user.exists' => 'Petugas tidak ditemukan.',
        ]);

        // Pastikan user yang dipilih benar-benar PETUGAS
        $petugas = User::where('id_user', $request->id_user)
            ->where('role', 'petugas')
            ->where('status_aktif', 1)
            ->first();

        if (!$petugas) {
            return back()
                ->withInput()
                ->with('error', 'Petugas yang dipilih tidak valid.');
        }

        Kendaraan::create([
            'plat_nomor' => strtoupper($request->plat_nomor),
            'kode_rfid' => $request->kode_rfid ?: null,
            'jenis_kendaraan' => $request->jenis_kendaraan,
            'warna' => $request->warna,
            'pemilik' => $request->pemilik,
            'id_user' => $request->id_user,
        ]);

        return redirect()
            ->route('admin.kendaraan.index')
            ->with('success', 'Data kendaraan berhasil ditambahkan.');
    }

    public function show($id)
    {
        $kendaraan = Kendaraan::with('petugas')
            ->findOrFail($id);

        return view('admin.kendaraan.show', compact('kendaraan'));
    }

        public function edit($id)
    {
        $kendaraan = Kendaraan::findOrFail($id);

        // Ambil hanya user yang role-nya petugas dan masih aktif
        $petugas = User::where('role', 'petugas')
            ->where('status_aktif', 1)
            ->orderBy('nama_lengkap')
            ->get();

        return view('admin.kendaraan.edit', compact(
            'kendaraan',
            'petugas'
        ));
    }


    public function update(Request $request, $id)
    {
        $request->validate([
            'plat_nomor' => 'required|string|max:20',
            'kode_rfid' => 'nullable|string|max:50|unique:tb_kendaraan,kode_rfid,' . $id . ',id_kendaraan',
            'jenis_kendaraan' => 'required',
            'warna' => 'required|string|max:30',
            'pemilik' => 'required|string|max:100',
            'id_user' => 'required|exists:tb_user,id_user',
        ], [
            'plat_nomor.required' => 'Plat nomor wajib diisi.',
            'kode_rfid.unique' => 'Kartu RFID ini sudah terdaftar pada kendaraan lain.',
            'jenis_kendaraan.required' => 'Jenis kendaraan wajib dipilih.',
            'warna.required' => 'Warna kendaraan wajib diisi.',
            'pemilik.required' => 'Nama pemilik wajib diisi.',
            'id_user.required' => 'Petugas wajib dipilih.',
            'id_user.exists' => 'Petugas tidak ditemukan.',
        ]);

        // Pastikan user yang dipilih benar-benar petugas aktif
        $petugas = User::where('id_user', $request->id_user)
            ->where('role', 'petugas')
            ->where('status_aktif', 1)
            ->first();

        if (!$petugas) {
            return back()
                ->withInput()
                ->with('error', 'Petugas yang dipilih tidak valid.');
        }

        $kendaraan = Kendaraan::findOrFail($id);

        $kendaraan->update([
            'plat_nomor' => strtoupper($request->plat_nomor),
            'kode_rfid' => $request->kode_rfid ?: null,
            'jenis_kendaraan' => $request->jenis_kendaraan,
            'warna' => $request->warna,
            'pemilik' => $request->pemilik,
            'id_user' => $request->id_user,
        ]);

        return redirect()
            ->route('admin.kendaraan.index')
            ->with('success', 'Data kendaraan berhasil diperbarui.');
        }

    public function destroy($id)
    {
        $kendaraan = Kendaraan::findOrFail($id);

        $kendaraan->delete();

        return redirect()
            ->route('admin.kendaraan.index')
            ->with('success', 'Data kendaraan berhasil dihapus.');
    }
}