<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\LogAktivitas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ], [
            'username.required' => 'Username wajib diisi.',
            'password.required' => 'Password wajib diisi.',
        ]);

        $user = User::where('username', $request->username)
            ->where('status_aktif', 1)
            ->first();

        if (!$user) {
            return back()
                ->withInput($request->only('username'))
                ->with('error', 'Username atau password salah.');
        }

        $password = $request->password;
        $storedPassword = $user->password;

        $isHashed = str_starts_with($storedPassword, '$2y$')
            || str_starts_with($storedPassword, '$argon2i$')
            || str_starts_with($storedPassword, '$argon2id$');

        $passwordValid = $isHashed
            ? Hash::check($password, $storedPassword)
            : hash_equals($storedPassword, $password);

        if (!$passwordValid) {
            return back()
                ->withInput($request->only('username'))
                ->with('error', 'Username atau password salah.');
        }

        if (!$isHashed) {
            $user->password = Hash::make($password);
            $user->save();
        }

        Auth::login($user, $request->boolean('remember'));

        $request->session()->regenerate();

        // Catat login setelah autentikasi berhasil.
        LogAktivitas::create([
            'id_user' => $user->id_user,
            'aktivitas' => 'Login ke sistem',
            'waktu_aktivitas' => now(),
        ]);

        return $this->redirectByRole($user->role);
    }

    public function logout(Request $request)
    {
        $user = Auth::user();

        // Catat logout sebelum sesi pengguna dihapus.
        if ($user) {
            LogAktivitas::create([
                'id_user' => $user->id_user,
                'aktivitas' => 'Logout dari sistem',
                'waktu_aktivitas' => now(),
            ]);
        }

        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()
            ->route('login')
            ->with('success', 'Anda berhasil logout.');
    }

    private function redirectByRole($role)
    {
        return match ($role) {
            'owner' => redirect()->route('owner.dashboard'),
            'admin' => redirect()->route('admin.dashboard'),
            'petugas' => redirect()->route('petugas.dashboard'),

            default => redirect()
                ->route('login')
                ->with('error', 'Role pengguna tidak valid.'),
        };
    }
}