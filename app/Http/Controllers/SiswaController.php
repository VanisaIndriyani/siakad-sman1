<?php

namespace App\Http\Controllers;

use App\Models\Absensi;
use App\Models\Jadwal;
use App\Models\Pengumuman;
use App\Models\Siswa;
use Endroid\QrCode\Color\Color;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\ErrorCorrectionLevel;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\RoundBlockSizeMode;
use Endroid\QrCode\Writer\PngWriter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SiswaController extends Controller
{
    public function nilai()
    {
        $siswa = Auth::user()->siswa;

        if (! $siswa) {
            return redirect()->back()->with('error', 'Data siswa tidak ditemukan.');
        }

        $nilais = $siswa->nilais()->with(['mapel', 'guru'])->orderBy('mapel_id')->get()->groupBy('mapel_id');

        return view('siswa.nilai.index', compact('nilais', 'siswa'));
    }

    public function absensi()
    {
        $siswa = Auth::user()->siswa;

        if (! $siswa) {
            return redirect()->back()->with('error', 'Data siswa tidak ditemukan.');
        }

        $absensis = Absensi::where('siswa_id', $siswa->id)
            ->with(['mapel', 'guru'])
            ->orderBy('tanggal', 'desc')
            ->paginate(15);

        $summary = [
            'Hadir' => Absensi::where('siswa_id', $siswa->id)->where('status', 'Hadir')->count(),
            'Izin' => Absensi::where('siswa_id', $siswa->id)->where('status', 'Izin')->count(),
            'Sakit' => Absensi::where('siswa_id', $siswa->id)->where('status', 'Sakit')->count(),
            'Alpa' => Absensi::where('siswa_id', $siswa->id)->where('status', 'Alpa')->count(),
        ];

        return view('siswa.absensi.index', compact('absensis', 'summary'));
    }

    public function jadwal()
    {
        $siswa = Auth::user()->siswa;

        if (! $siswa) {
            return redirect()->back()->with('error', 'Data siswa tidak ditemukan.');
        }

        // Get jadwal for the student's class
        $jadwals = Jadwal::where('kelas_id', $siswa->kelas_id)
            ->with(['mapel', 'guru'])
            ->orderBy('jam_mulai')
            ->get()
            ->groupBy('hari');

        return view('siswa.jadwal.index', compact('jadwals'));
    }

    public function exportJadwalPdf()
    {
        $siswa = Auth::user()->siswa;

        if (! $siswa) {
            return redirect()->back()->with('error', 'Data siswa tidak ditemukan.');
        }

        $jadwals = Jadwal::where('kelas_id', $siswa->kelas_id)
            ->with(['mapel', 'guru', 'kelas'])
            ->orderBy('jam_mulai')
            ->get();

        $grouped = $jadwals->groupBy('hari');

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('siswa.jadwal.pdf', [
            'siswa' => $siswa,
            'jadwalsByDay' => $grouped,
        ]);
        $pdf->setPaper('a4', 'portrait');

        return $pdf->stream('jadwal-'.$siswa->kelas->nama_kelas.'.pdf');
    }

    public function pengumuman()
    {
        $pengumumans = Pengumuman::where('is_active', true)->latest()->paginate(10);

        return view('siswa.pengumuman.index', compact('pengumumans'));
    }

    public function profil()
    {
        $siswa = Auth::user()->siswa;

        if (! $siswa) {
            return redirect()->back()->with('error', 'Data siswa tidak ditemukan.');
        }

        $payload = $this->qrPayload($siswa);
        $qrDataUriSmall = $this->qrPngResult($payload, 240, 1)->getDataUri();

        return view('siswa.profil', compact('siswa', 'qrDataUriSmall'));
    }

    public function qrPng(Request $request)
    {
        $siswa = Auth::user()->siswa;

        if (! $siswa) {
            return redirect()->back()->with('error', 'Data siswa tidak ditemukan.');
        }

        $payload = $this->qrPayload($siswa);
        $result = $this->qrPngResult($payload, 240, 1);

        $filename = 'qr-'.($siswa->nisn ?: $siswa->id).'.png';
        $disposition = $request->boolean('download') ? 'attachment' : 'inline';

        return response($result->getString(), 200, [
            'Content-Type' => $result->getMimeType(),
            'Content-Disposition' => $disposition.'; filename="'.$filename.'"',
            'Cache-Control' => 'no-store, private',
        ]);
    }

    public function qrPdf(Request $request)
    {
        $siswa = Auth::user()->siswa;

        if (! $siswa) {
            return redirect()->back()->with('error', 'Data siswa tidak ditemukan.');
        }

        $payload = $this->qrPayload($siswa);
        $result = $this->qrPngResult($payload, 320, 1);
        $qrDataUri = $result->getDataUri();

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('siswa.qr.pdf', [
            'siswa' => $siswa,
            'payload' => $payload,
            'qrDataUri' => $qrDataUri,
        ]);
        $pdf->setPaper('a4', 'portrait');

        $filename = 'kartu-siswa-'.($siswa->nisn ?: $siswa->id).'.pdf';
        if ($request->boolean('download')) {
            return $pdf->download($filename);
        }

        return $pdf->stream($filename);
    }

    private function qrPayload(Siswa $siswa): string
    {
        return $siswa->nisn ? 'NISN:'.$siswa->nisn : 'ID:'.$siswa->id;
    }

    private function qrPngResult(string $payload, int $size, int $margin)
    {
        $writer = new PngWriter;
        $qrCode = new QrCode(
            data: $payload,
            encoding: new Encoding('UTF-8'),
            errorCorrectionLevel: ErrorCorrectionLevel::Low,
            size: $size,
            margin: $margin,
            roundBlockSizeMode: RoundBlockSizeMode::Margin,
            foregroundColor: new Color(0, 0, 0),
            backgroundColor: new Color(255, 255, 255),
        );

        return $writer->write($qrCode);
    }
}
