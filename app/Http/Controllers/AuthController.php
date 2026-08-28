<?php

namespace App\Http\Controllers;

use App\Models\Guru;
use App\Models\Kelas;
use App\Models\Mapel;
use App\Models\Siswa;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function showRegistrationForm()
    {
        if (Auth::check()) {
            return redirect('/');
        }

        $kelas = Kelas::orderBy('nama_kelas')->get();
        $mapels = Mapel::orderBy('nama_mapel')->get();

        return view('auth.register', compact('kelas', 'mapels'));
    }

    public function register(Request $request)
    {
        if (Auth::check()) {
            return redirect('/');
        }

        $throttleKey = 'register|' . $request->ip();
        if (RateLimiter::tooManyAttempts($throttleKey, 3)) {
            $seconds = RateLimiter::availableIn($throttleKey);
            return back()->withErrors([
                'username' => "Terlalu banyak percobaan registrasi. Silakan coba lagi dalam {$seconds} detik.",
            ])->withInput();
        }

        $request->validate([
            'role' => 'required|in:guru,siswa,kepala_sekolah',
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:50|unique:users,username|alpha_dash:ascii',
            'email' => 'nullable|email|max:255|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
            'jenis_kelamin' => 'required_if:role,siswa|nullable|in:L,P',
            'no_hp' => 'nullable|string|max:20',
            'alamat' => 'nullable|string|max:500',
            'kelas_id' => 'required_if:role,siswa|nullable|exists:kelas,id',
            'mapel_id' => 'nullable|exists:mapels,id',
        ]);

        RateLimiter::hit($throttleKey, 300);

        try {
            DB::beginTransaction();

            $email = $request->filled('email') ? $request->email : null;

            $user = User::create([
                'name' => $request->name,
                'username' => $request->username,
                'email' => $email,
                'password' => $request->password,
                'role' => $request->role,
                'status' => 'pending',
            ]);

            if ($request->role === 'guru') {
                Guru::create([
                    'user_id' => $user->id,
                    'nip' => null,
                    'nama_lengkap' => $request->name,
                    'gelar_depan' => null,
                    'gelar_belakang' => null,
                    'jenis_kelamin' => $request->jenis_kelamin ?? null,
                    'no_hp' => $request->no_hp,
                    'alamat' => $request->alamat,
                    'is_active' => false,
                    'mapel_id' => $request->filled('mapel_id') ? $request->mapel_id : null,
                ]);
            } elseif ($request->role === 'siswa') {
                Siswa::create([
                    'user_id' => $user->id,
                    'kelas_id' => $request->kelas_id,
                    'nisn' => null,
                    'nis' => null,
                    'nama_lengkap' => $request->name,
                    'jenis_kelamin' => $request->jenis_kelamin ?? null,
                    'tempat_lahir' => null,
                    'tanggal_lahir' => null,
                    'alamat' => $request->alamat,
                    'nama_ayah' => null,
                    'nama_ibu' => null,
                    'no_hp_ortu' => $request->no_hp,
                ]);
            }

            $this->notifyAdminsNewRegistration($user);

            DB::commit();

            RateLimiter::clear($throttleKey);

            return redirect()->route('login')->with('success', 'Registrasi berhasil! Akun Anda menunggu verifikasi dari Admin. Silakan login kembali setelah akun Anda disetujui.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors([
                'email' => 'Terjadi kesalahan saat registrasi: ' . $e->getMessage(),
            ])->withInput();
        }
    }

    private function notifyAdminsNewRegistration(User $user)
    {
        $admins = User::where('role', 'admin')->where('status', 'active')->get();

        $roleLabel = match ($user->role) {
            'guru' => 'Guru',
            'siswa' => 'Siswa',
            'kepala_sekolah' => 'Kepala Sekolah',
            default => ucfirst($user->role),
        };
        $title = "Registrasi {$roleLabel} Baru";
        $message = "{$roleLabel} baru mendaftar: {$user->name} ({$user->username}). Segera verifikasi akun.";

        foreach ($admins as $admin) {
            $admin->addNotification(
                $title,
                $message,
                'success',
                'fa-user-plus',
                route('admin.verifikasi-pengguna.index')
            );
        }
    }
}
