<?php

namespace App\Http\Controllers;

use App\Models\Absensi;
use App\Models\Guru;
use App\Models\Kelas;
use App\Models\Mapel;
use App\Models\Pengumuman;
use App\Models\Siswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function login()
    {
        return view('auth.login');
    }

    public function authenticate(Request $request)
    {
        $request->validate([
            'username' => ['required'],
            'password' => ['required'],
        ]);

        $loginId = $request->username;
        $password = $request->password;

        // Determine login type and find user
        $user = null;

        // 1. Check by Email
        if (filter_var($loginId, FILTER_VALIDATE_EMAIL)) {
            $user = \App\Models\User::where('email', $loginId)->first();
        } 
        // 2. Check by Username, NIP, or NISN
        else {
            // First check by Username (fallback)
            $user = \App\Models\User::where('username', $loginId)->first();
            
            // If not found, check by NIP (Guru)
            if (!$user) {
                $guru = \App\Models\Guru::where('nip', $loginId)->first();
                if ($guru) {
                    $user = $guru->user;
                }
            }

            // If not found, check by NISN (Siswa)
            if (!$user) {
                $siswa = \App\Models\Siswa::where('nisn', $loginId)->first();
                if ($siswa) {
                    $user = $siswa->user;
                }
            }
        }

        // Attempt login if user found
        if ($user && \Illuminate\Support\Facades\Hash::check($password, $user->password)) {
            Auth::login($user);
            $request->session()->regenerate();

            $role = Auth::user()->role;

            switch ($role) {
                case 'admin':
                    return redirect()->route('admin.dashboard');
                case 'guru':
                    return redirect()->route('guru.dashboard');
                case 'siswa':
                    return redirect()->route('siswa.dashboard');
                case 'kepala_sekolah':
                    return redirect()->route('kepala_sekolah.dashboard');
                default:
                    Auth::logout();
                    return redirect()->back()->with('error', 'Role tidak valid');
            }
        }

        return back()->withErrors([
            'username' => 'Login gagal. Periksa kembali ID Pengguna (Email/NIP/NISN) dan Password Anda.',
        ]);
    }

    public function admin()
    {
        $totalGuru = Guru::count();
        $totalSiswa = Siswa::count();
        $totalKelas = Kelas::count();
        $totalMapel = Mapel::count();

        return view('admin.dashboard', compact('totalGuru', 'totalSiswa', 'totalKelas', 'totalMapel'));
    }

    public function guru()
    {
        $guru = Auth::user()->guru;
        
        if (!$guru) {
             return redirect()->route('login')->withErrors(['msg' => 'Data guru tidak ditemukan.']);
        }

        // Get classes taught by this guru (distinct from jadwals)
        $kelasDiampu = $guru->jadwals()->with('kelas')->get()->pluck('kelas')->unique('id');
        $kelasDiampuCount = $kelasDiampu->count();
        $kelasDiampuList = $kelasDiampu->pluck('nama_kelas')->implode(', ');

        // Get today's schedule
        // Note: Carbon::now()->isoFormat('dddd') returns localized day name if locale is set, 
        // but let's assume standard English or mapped. 
        // Ideally we should use a consistent mapping. 
        // For this demo, let's just fetch all and filter in view or assume Monday for demo purposes if today is weekend.
        
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
        
        if (!$siswa) {
             return redirect()->route('login')->withErrors(['msg' => 'Data siswa tidak ditemukan.']);
        }

        $rataRataNilai = $siswa->nilais()->avg('nilai') ?? 0;
        $nilaiTerbaru = $siswa->nilais()->with('mapel')->latest()->take(3)->get();
        
        // Calculate Attendance Percentage
        $totalAbsensi = Absensi::where('siswa_id', $siswa->id)->count();
        $hadirCount = Absensi::where('siswa_id', $siswa->id)->where('status', 'Hadir')->count();
        $kehadiranPercentage = $totalAbsensi > 0 ? ($hadirCount / $totalAbsensi) * 100 : 100; // Default 100% if no data

        // Fetch Announcements
        $pengumumans = Pengumuman::where('is_active', true)->latest()->take(3)->get();
        
        return view('siswa.dashboard', compact('siswa', 'rataRataNilai', 'nilaiTerbaru', 'kehadiranPercentage', 'pengumumans'));
    }
    
    public function kepalaSekolah()
    {
        $totalGuru = Guru::count();
        $totalSiswa = Siswa::count();
        $totalKelas = Kelas::count();
        $totalMapel = Mapel::count();

        // Additional stats for Kepsek
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
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}
