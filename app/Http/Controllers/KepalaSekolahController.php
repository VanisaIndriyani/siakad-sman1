<?php

namespace App\Http\Controllers;

use App\Models\Absensi;
use App\Models\Guru;
use App\Models\Kelas;
use App\Models\Nilai;
use App\Models\Siswa;
use Illuminate\Http\Request;

class KepalaSekolahController extends Controller
{
    public function laporanAkademik()
    {
        $totalSiswa = Siswa::count();
        $totalGuru = Guru::count();
        $totalKelas = Kelas::count();
        
        // Stats per class
        $kelasStats = Kelas::withCount('siswas')->get();
        
        return view('kepala_sekolah.laporan_akademik', compact('totalSiswa', 'totalGuru', 'totalKelas', 'kelasStats'));
    }

    public function monitoringNilai(Request $request)
    {
        $query = Nilai::with(['siswa', 'mapel', 'guru']);

        if ($request->filled('kelas_id')) {
            $query->whereHas('siswa', function($q) use ($request) {
                $q->where('kelas_id', $request->kelas_id);
            });
        }

        $nilais = $query->latest()->paginate(15);
        $kelases = Kelas::all();

        return view('kepala_sekolah.monitoring_nilai', compact('nilais', 'kelases'));
    }

    public function monitoringAbsensi(Request $request)
    {
        $query = Absensi::with(['siswa', 'mapel', 'kelas', 'guru']);

        if ($request->filled('tanggal')) {
            $query->whereDate('tanggal', $request->tanggal);
        } else {
            $query->whereDate('tanggal', date('Y-m-d'));
        }

        $absensis = $query->latest()->paginate(20);
        
        return view('kepala_sekolah.monitoring_absensi', compact('absensis'));
    }

    public function verifikasiRaport()
    {
        $siswas = Siswa::with(['kelas', 'nilais'])->paginate(10);
        
        return view('kepala_sekolah.verifikasi_raport', compact('siswas'));
    }

    public function doVerifikasiRaport($id)
    {
        // Mock verification for now
        return back()->with('success', 'Raport siswa berhasil diverifikasi oleh Kepala Sekolah.');
    }
}
