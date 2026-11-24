<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LogAktivitas;
use Illuminate\Http\Request;

class LogAktivitasController extends Controller
{
    public function index(Request $request)
    {
        $query = LogAktivitas::with('user');

        // Pencarian aktivitas, nama pengguna, atau username.
        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->where('aktivitas', 'like', '%' . $search . '%')
                    ->orWhereHas('user', function ($userQuery) use ($search) {
                        $userQuery->where(
                            'nama_lengkap',
                            'like',
                            '%' . $search . '%'
                        )->orWhere(
                            'username',
                            'like',
                            '%' . $search . '%'
                        );
                    });
            });
        }

        // Filter berdasarkan tanggal.
        if ($request->filled('tanggal')) {
            $query->whereDate(
                'waktu_aktivitas',
                $request->tanggal
            );
        }

        // Tampilkan aktivitas terbaru terlebih dahulu.
        $logs = $query
            ->orderByDesc('waktu_aktivitas')
            ->orderByDesc('id_log')
            ->paginate(10)
            ->withQueryString();

        return view('admin.log.index', compact('logs'));
    }

    public function show($id)
    {
        $log = LogAktivitas::with('user')
            ->findOrFail($id);

        return view('admin.log.show', compact('log'));
    }
}