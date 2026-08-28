<?php

namespace App\Http\Controllers;

use App\Models\Absensi;
use App\Models\Guru;
use App\Models\Kelas;
use App\Models\Mapel;
use App\Models\Notifikasi;
use App\Models\Pengumuman;
use App\Models\Siswa;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;

class DashboardController extends Controller
{
    public function login()
    {
        if (Auth::check()) {
            $role = Auth::user()->role;
            return match ($role) {
                'admin' => redirect()->route('admin.dashboard'),
                'guru' => redirect()->route('guru.dashboard'),
                'siswa' => redirect()->route('siswa.dashboard'),
                'kepala_sekolah' => redirect()->route('kepala_sekolah.dashboard'),
                default => redirect('/'),
            };
        }

        return view('auth.login');
    }

    public function authenticate(Request $request)
    {
        $request->validate([
            'username' => ['required', 'string'],
            'password' => ['required', 'string', 'min:4'],
        ], [], [
            'username' => 'Username',
            'password' => 'Password',
        ]);

        $GENERIC_ERROR = 'Username atau password salah.';
        $STATUS_BLOCKED = 'Akun Anda tidak dapat diakses saat ini. Silakan hubungi Admin.';

        $throttleKey = 'login|' . Str::lower($request->username) . '|' . $request->ip();

        if (RateLimiter::tooManyAttempts($throttleKey, 5)) {
            $seconds = RateLimiter::availableIn($throttleKey);
            return back()->withErrors([
                'username' => "Terlalu banyak percobaan login. Silakan coba lagi dalam {$seconds} detik.",
            ])->onlyInput('username');
        }

        $credentials = [
            'username' => trim($request->username),
            'password' => $request->password,
        ];

        $genericFail = function () use ($throttleKey, $request, $GENERIC_ERROR) {
            RateLimiter::hit($throttleKey, 60);
            return back()->withErrors([
                'username' => $GENERIC_ERROR,
            ])->onlyInput('username');
        };

        if (! Auth::validate($credentials)) {
            return $genericFail();
        }

        $user = Auth::getProvider()->retrieveByCredentials(['username' => $credentials['username']]);

        if (! $user) {
            return $genericFail();
        }

        if ($user->status === 'pending') {
            RateLimiter::hit($throttleKey, 60);
            return back()->withErrors([
                'username' => 'Akun Anda masih menunggu verifikasi Admin. Silakan tunggu atau hubungi Admin.',
            ])->onlyInput('username');
        }

        if ($user->status === 'rejected') {
            $note = $user->rejection_note ? ' Alasan: ' . $user->rejection_note : '';
            RateLimiter::hit($throttleKey, 60);
            return back()->withErrors([
                'username' => 'Akun Anda ditolak oleh Admin.' . $note,
            ])->onlyInput('username');
        }

        if ($user->status === 'inactive') {
            RateLimiter::hit($throttleKey, 60);
            return back()->withErrors([
                'username' => 'Akun Anda dinonaktifkan. Silakan hubungi Admin.',
            ])->onlyInput('username');
        }

        Auth::login($user, $request->filled('remember'));
        RateLimiter::clear($throttleKey);
        $request->session()->regenerate();
        $request->session()->put('auth_logged_in_at', now()->toIso8601String());

        $role = Auth::user()->role;

        return match ($role) {
            'admin' => redirect()->route('admin.dashboard'),
            'guru' => redirect()->route('guru.dashboard'),
            'siswa' => redirect()->route('siswa.dashboard'),
            'kepala_sekolah' => redirect()->route('kepala_sekolah.dashboard'),
            default => (function () {
                Auth::logout();
                request()->session()->invalidate();
                request()->session()->regenerateToken();
                return redirect()->route('login')->with('error', 'Role tidak valid');
            })(),
        };
    }

    public function admin()
    {
        $totalGuru = Guru::count();
        $totalSiswa = Siswa::count();
        $totalKelas = Kelas::count();
        $totalMapel = Mapel::count();
        $totalPendingUsers = User::where('status', 'pending')->count();
        $totalOpenLaporan = \App\Models\LaporanMasalah::whereIn('status', ['open', 'in_progress'])->count();

        return view('admin.dashboard', compact('totalGuru', 'totalSiswa', 'totalKelas', 'totalMapel', 'totalPendingUsers', 'totalOpenLaporan'));
    }

    public function guru()
    {
        $guru = Auth::user()->guru;

        if (! $guru) {
            Auth::logout();
            return redirect()->route('login')->withErrors(['msg' => 'Data guru tidak ditemukan.']);
        }

        $kelasDiampu = $guru->jadwals()->with('kelas')->get()->pluck('kelas')->unique('id');
        $kelasDiampuCount = $kelasDiampu->count();
        $kelasDiampuList = $kelasDiampu->pluck('nama_kelas')->implode(', ');

        $daysMap = [
            'Sunday' => 'Minggu',
            'Monday' => 'Senin',
            'Tuesday' => 'Selasa',
            'Wednesday' => 'Rabu',
            'Thursday' => 'Kamis',
            'Friday' => 'Jumat',
            'Saturday' => 'Sabtu',
        ];
        $today = $daysMap[date('l')];

        $jadwalHariIni = $guru->jadwals()->where('hari', $today)->with(['kelas', 'mapel'])->orderBy('jam_mulai')->get();
        $jadwalHariIniCount = $jadwalHariIni->count();

        return view('guru.dashboard', compact('guru', 'kelasDiampuCount', 'kelasDiampuList', 'jadwalHariIni', 'jadwalHariIniCount'));
    }

    public function siswa()
    {
        $siswa = Auth::user()->siswa;

        if (! $siswa) {
            Auth::logout();
            return redirect()->route('login')->withErrors(['msg' => 'Data siswa tidak ditemukan.']);
        }

        $rataRataNilai = $siswa->nilais()->avg('nilai') ?? 0;
        $nilaiTerbaru = $siswa->nilais()->with('mapel')->latest()->take(3)->get();

        $totalAbsensi = Absensi::where('siswa_id', $siswa->id)->count();
        $hadirCount = Absensi::where('siswa_id', $siswa->id)->where('status', 'Hadir')->count();
        $kehadiranPercentage = $totalAbsensi > 0 ? ($hadirCount / $totalAbsensi) * 100 : 100;

        $pengumumans = Pengumuman::where('is_active', true)->latest()->take(3)->get();

        return view('siswa.dashboard', compact('siswa', 'rataRataNilai', 'nilaiTerbaru', 'kehadiranPercentage', 'pengumumans'));
    }

    public function kepalaSekolah()
    {
        $totalGuru = Guru::count();
        $totalSiswa = Siswa::count();
        $totalKelas = Kelas::count();
        $totalMapel = Mapel::count();

        $rataRataNilaiSekolah = \App\Models\Nilai::avg('nilai') ?? 0;
        $totalAbsensiHariIni = \App\Models\Absensi::whereDate('tanggal', date('Y-m-d'))->count();

        return view('kepala_sekolah.dashboard', compact(
            'totalGuru',
            'totalSiswa',
            'totalKelas',
            'totalMapel',
            'rataRataNilaiSekolah',
            'totalAbsensiHariIni'
        ));
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->flush();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        $request->session()->regenerate(true);

        $response = redirect()->route('login')->with('success', 'Anda telah keluar dari sistem.');

        $response->headers->set('Cache-Control', 'no-store, no-cache, must-revalidate, max-age=0, post-check=0, pre-check=0');
        $response->headers->set('Pragma', 'no-cache');
        $response->headers->set('Expires', 'Thu, 01 Jan 1970 00:00:00 GMT');

        return $response;
    }
}
