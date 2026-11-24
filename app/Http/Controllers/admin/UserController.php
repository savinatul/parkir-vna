<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\LogAktivitas;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function index()
    {
        $users = User::orderBy('id_user', 'desc')->paginate(10);

        return view('admin.user.index', compact('users'));
    }

    public function create()
    {
        return view('admin.user.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_lengkap' => 'required|max:50',
            'username' => 'required|max:50|unique:tb_user,username',
            'password' => 'required|min:6|max:100',
            'role' => 'required|in:owner,admin,petugas',
            'status_aktif' => 'required|boolean',
        ]);

        User::create([
            'nama_lengkap' => $request->nama_lengkap,
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'status_aktif' => $request->status_aktif,
        ]);

        return redirect()
            ->route('admin.user.index')
            ->with('success', 'User berhasil ditambahkan.');
    }

    public function show(User $user)
    {
        return view('admin.user.show', compact('user'));
    }

    public function edit(User $user)
    {
        return view('admin.user.edit', compact('user'));
    }

    
    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'nama_lengkap' => 'required|string|max:50',
            'username' => 'required|string|max:50|unique:tb_user,username,'
                . $user->id_user . ',id_user',
            'role' => 'required|in:owner,admin,petugas',
            'status_aktif' => 'required|boolean',
            'password' => 'nullable|string|min:6|max:100',
        ]);

        $data = [
            'nama_lengkap' => $validated['nama_lengkap'],
            'username' => $validated['username'],
            'role' => $validated['role'],
            'status_aktif' => $validated['status_aktif'],
        ];

        // Password hanya berubah jika kolom diisi.
        if (!empty($validated['password'])) {
            $data['password'] = Hash::make($validated['password']);
        }

        $user->update($data);

        return redirect()
            ->route('admin.user.index')
            ->with('success', 'Data user berhasil diperbarui.');
    }


    public function destroy(User $user)
    {
        // Jangan menghapus akun yang sedang digunakan
        if ($user->id_user == session('user_id')) {
            return back()->with('error', 'Akun yang sedang digunakan tidak dapat dihapus.');
        }

        $user->delete();

        return redirect()
            ->route('admin.user.index')
            ->with('success', 'User berhasil dihapus.');
    }
}