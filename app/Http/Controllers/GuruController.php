<?php

namespace App\Http\Controllers;

use App\Models\Absensi;
use App\Models\Jadwal;
use App\Models\Kelas;
use App\Models\Mapel;
use App\Models\Nilai;
use App\Models\Siswa;
use App\Models\User;
use App\Services\WhatsappService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class GuruController extends Controller
{
    public function absensi(Request $request)
    {
        $guru = Auth::user()->guru;

        if (! $guru) {
            return redirect()->back()->with('error', 'Data guru tidak ditemukan.');
        }

        // Get classes taught by this guru
        $kelasDiampu = $guru->jadwals()->with('kelas')->get()->pluck('kelas')->unique('id');

        // Get mapels taught by this guru
        $mapelDiampu = $guru->jadwals()->with('mapel')->get()->pluck('mapel')->unique('id');

        $selectedKelasId = $request->query('kelas_id');
        $selectedMapelId = $request->query('mapel_id');
        $selectedTanggal = $request->query('tanggal', date('Y-m-d'));

        $siswas = [];

        if ($selectedKelasId && $selectedMapelId) {
            $siswas = Siswa::where('kelas_id', $selectedKelasId)->orderBy('nama_lengkap')->get();

            // Load existing attendance
            foreach ($siswas as $siswa) {
                $absensi = Absensi::where('siswa_id', $siswa->id)
                    ->where('mapel_id', $selectedMapelId)
                    ->where('guru_id', $guru->id)
                    ->where('tanggal', $selectedTanggal)
                    ->first();

                $siswa->status_absensi = $absensi ? $absensi->status : 'Hadir'; // Default Hadir
                $siswa->keterangan_absensi = $absensi ? $absensi->keterangan : null;
            }
        }

        return view('guru.absensi.index', compact('kelasDiampu', 'mapelDiampu', 'siswas', 'selectedKelasId', 'selectedMapelId', 'selectedTanggal'));
    }

    public function storeAbsensi(Request $request)
    {
        $request->validate([
            'kelas_id' => 'required',
            'mapel_id' => 'required',
            'tanggal' => 'required|date',
            'status' => 'required|array',
            'status.*' => 'in:Hadir,Izin,Sakit,Alpa',
        ]);

        $guru = Auth::user()->guru;

        foreach ($request->status as $siswaId => $status) {
            $existingStatus = Absensi::where('siswa_id', $siswaId)
                ->where('mapel_id', $request->mapel_id)
                ->where('guru_id', $guru->id)
                ->where('kelas_id', $request->kelas_id)
                ->where('tanggal', $request->tanggal)
                ->value('status');

            $absensi = Absensi::updateOrCreate(
                [
                    'siswa_id' => $siswaId,
                    'mapel_id' => $request->mapel_id,
                    'guru_id' => $guru->id,
                    'kelas_id' => $request->kelas_id,
                    'tanggal' => $request->tanggal,
                ],
                [
                    'status' => $status,
                    'keterangan' => $request->keterangan[$siswaId] ?? null,
                ]
            );

            if ($existingStatus !== $status) {
                $siswa = Siswa::with(['user', 'kelas'])->find($siswaId);
                if ($siswa) {
                    $this->notifyOrtuAbsensi(
                        $siswa,
                        (int) $request->kelas_id,
                        (int) $request->mapel_id,
                        $request->tanggal,
                        $absensi->status,
                        $guru->nama_lengkap ?? 'Guru'
                    );
                }
            }
        }

        return redirect()->back()->with('success', 'Absensi berhasil disimpan.');
    }

    public function scanAbsensi(Request $request)
    {
        $request->validate([
            'kelas_id' => 'required',
            'mapel_id' => 'required',
            'tanggal' => 'required|date',
            'qr' => 'required|string',
            'status' => 'nullable|in:Hadir,Izin,Sakit,Alpa',
        ]);

        $guru = Auth::user()->guru;
        if (! $guru) {
            return response()->json(['message' => 'Data guru tidak ditemukan.'], 404);
        }

        $kelasId = (int) $request->input('kelas_id');
        $mapelId = (int) $request->input('mapel_id');
        $tanggal = $request->input('tanggal');
        $status = $request->input('status', 'Hadir');

        $mengajar = Jadwal::where('guru_id', $guru->id)
            ->where('kelas_id', $kelasId)
            ->where('mapel_id', $mapelId)
            ->exists();

        if (! $mengajar) {
            return response()->json(['message' => 'Anda tidak mengajar kelas/mapel ini.'], 403);
        }

        $parsed = $this->parseQrPayload($request->input('qr'));
        if (! $parsed) {
            return response()->json(['message' => 'QR tidak valid.'], 422);
        }

        $siswa = null;
        if ($parsed['type'] === 'id') {
            $siswa = Siswa::find($parsed['value']);
        } else {
            $siswa = Siswa::where('nisn', $parsed['value'])->first();
        }

        if (! $siswa) {
            return response()->json(['message' => 'Siswa tidak ditemukan.'], 404);
        }

        if ((int) $siswa->kelas_id !== $kelasId) {
            return response()->json(['message' => 'QR siswa tidak sesuai kelas yang dipilih.'], 422);
        }

        $absensi = Absensi::updateOrCreate(
            [
                'siswa_id' => $siswa->id,
                'mapel_id' => $mapelId,
                'guru_id' => $guru->id,
                'kelas_id' => $kelasId,
                'tanggal' => $tanggal,
            ],
            [
                'status' => $status,
                'keterangan' => null,
            ]
        );

        $this->notifyOrtuAbsensi(
            $siswa->loadMissing(['user', 'kelas']),
            $kelasId,
            $mapelId,
            $tanggal,
            $absensi->status,
            $guru->nama_lengkap ?? 'Guru'
        );

        return response()->json([
            'message' => 'Absensi tersimpan.',
            'siswa' => [
                'id' => $siswa->id,
                'nama_lengkap' => $siswa->nama_lengkap,
                'nisn' => $siswa->nisn,
            ],
            'absensi' => [
                'id' => $absensi->id,
                'status' => $absensi->status,
                'tanggal' => $absensi->tanggal,
            ],
        ]);
    }

    private function parseQrPayload(string $raw): ?array
    {
        $value = trim($raw);
        if ($value === '') {
            return null;
        }

        $upper = strtoupper($value);
        if (str_starts_with($upper, 'NISN:')) {
            $nisn = trim(substr($value, 5));

            return $nisn !== '' ? ['type' => 'nisn', 'value' => $nisn] : null;
        }

        if (str_starts_with($upper, 'ID:')) {
            $id = trim(substr($value, 3));
            if ($id === '' || ! ctype_digit($id)) {
                return null;
            }

            return ['type' => 'id', 'value' => (int) $id];
        }

        if (ctype_digit($value)) {
            if (strlen($value) >= 8) {
                return ['type' => 'nisn', 'value' => $value];
            }

            return ['type' => 'id', 'value' => (int) $value];
        }

        return null;
    }

    private function notifyOrtuAbsensi(Siswa $siswa, int $kelasId, int $mapelId, string $tanggal, string $status, string $namaGuru): void
    {
        if (! in_array($status, ['Hadir', 'Alpa'], true)) {
            return;
        }

        $to = $siswa->no_hp_ortu ?? null;
        if (! $to) {
            return;
        }

        $kelas = $siswa->kelas?->nama_kelas ?? Kelas::find($kelasId)?->nama_kelas ?? '-';
        $mapel = Mapel::find($mapelId)?->nama_mapel ?? '-';
        $labelStatus = $status === 'Alpa' ? 'Alpa (Bolos)' : $status;

        $body = "Assalamu’alaikum Bapak/Ibu,\n\n"

."Kami informasikan kehadiran siswa:\n\n"

."Nama : {$siswa->nama_lengkap}\n"
."Kelas: {$kelas}\n"
."Mapel: {$mapel}\n"
."Tanggal: {$tanggal}\n"
."Status: {$labelStatus}\n\n"

."Mohon perhatian Bapak/Ibu.\n\n"

."Terima kasih.\n"
."SMA Negeri 1 Tuhemberua";

        try {
            app(WhatsappService::class)->send($to, $body);
        } catch (\Throwable $e) {
        }
    }

    public function nilai(Request $request)
    {
        $guru = Auth::user()->guru;

        if (! $guru) {
            return redirect()->back()->with('error', 'Data guru tidak ditemukan.');
        }

        // Get classes taught by this guru
        $kelasDiampu = $guru->jadwals()->with('kelas')->get()->pluck('kelas')->unique('id');

        // Get mapels taught by this guru
        $mapelDiampu = $guru->jadwals()->with('mapel')->get()->pluck('mapel')->unique('id');

        $selectedKelasId = $request->query('kelas_id');
        $selectedMapelId = $request->query('mapel_id');
        $selectedKategori = $request->query('kategori');

        $siswas = [];

        if ($selectedKelasId && $selectedMapelId) {
            $siswas = Siswa::where('kelas_id', $selectedKelasId)->orderBy('nama_lengkap')->get();

            // Load existing grades if any
            foreach ($siswas as $siswa) {
                $nilai = Nilai::where('siswa_id', $siswa->id)
                    ->where('mapel_id', $selectedMapelId)
                    ->where('kategori', $selectedKategori)
                    ->where('guru_id', $guru->id)
                    ->first();
                $siswa->nilai_value = $nilai ? $nilai->nilai : null;
                $siswa->catatan = $nilai ? $nilai->catatan : null;
            }
        }

        return view('guru.nilai.index', compact('kelasDiampu', 'mapelDiampu', 'siswas', 'selectedKelasId', 'selectedMapelId', 'selectedKategori'));
    }

  public function storeNilai(Request $request)
{
    $request->validate([
        'kelas_id' => 'required|integer',
        'mapel_id' => 'required|integer',
        'kategori' => 'required|string',
        'nilai' => 'required|array',
        'nilai.*' => 'nullable|numeric|min:0|max:100',
        'catatan' => 'nullable|array',
    ]);

    $guru = Auth::user()->guru;

    if (!$guru) {
        return redirect()->back()->with('error', 'Data guru tidak ditemukan.');
    }

    // Pastikan guru memang mengajar kelas dan mapel tersebut
    $mengajar = Jadwal::where('guru_id', $guru->id)
        ->where('kelas_id', $request->kelas_id)
        ->where('mapel_id', $request->mapel_id)
        ->exists();

    if (!$mengajar) {
        return redirect()->back()->with(
            'error',
            'Anda tidak memiliki akses untuk menginput nilai pada kelas dan mata pelajaran ini.'
        );
    }

    try {

        DB::transaction(function () use ($request, $guru) {

            foreach ($request->nilai as $siswaId => $nilaiValue) {

                // Lewati jika nilai kosong
                if ($nilaiValue === null || $nilaiValue === '') {
                    continue;
                }

                // Pastikan siswa benar-benar berada di kelas yang dipilih
                $siswa = Siswa::where('id', $siswaId)
                    ->where('kelas_id', $request->kelas_id)
                    ->first();

                if (!$siswa) {
                    continue;
                }

                Nilai::updateOrCreate(
                    [
                        'siswa_id' => $siswa->id,
                        'mapel_id' => $request->mapel_id,
                        'guru_id' => $guru->id,
                        'kategori' => $request->kategori,
                        'semester' => 'Genap',
                        'tahun_ajaran' => '2025/2026',
                    ],
                    [
                        'nilai' => $nilaiValue,
                        'catatan' => $request->catatan[$siswaId] ?? null,
                    ]
                );
            }
        });

    } catch (\Throwable $e) {

        // Simpan error ke log Laravel
        \Log::error('Gagal menyimpan nilai', [
            'error' => $e->getMessage(),
            'file' => $e->getFile(),
            'line' => $e->getLine(),
            'guru_id' => $guru->id ?? null,
            'kelas_id' => $request->kelas_id,
            'mapel_id' => $request->mapel_id,
            'kategori' => $request->kategori,
        ]);

        return redirect()->back()->with(
            'error',
            'Nilai gagal disimpan. Silakan coba lagi.'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | NOTIFIKASI ADMIN
    |--------------------------------------------------------------------------
    | Dibuat terpisah supaya kalau notifikasi error,
    | proses simpan nilai tetap berhasil.
    */

    try {

        $mapel = Mapel::find($request->mapel_id);
        $kelas = Kelas::find($request->kelas_id);

        $kategoriLabel = match (strtolower($request->kategori)) {
            'uh1' => 'Ulangan Harian 1',
            'uh2' => 'Ulangan Harian 2',
            'uh3' => 'Ulangan Harian 3',
            'uts' => 'UTS',
            'uas' => 'UAS',
            'tugas' => 'Tugas',
            default => $request->kategori,
        };

        $mapelNama = $mapel?->nama_mapel ?? 'Mapel';
        $kelasNama = $kelas?->nama_kelas ?? 'Kelas';

        $admins = User::where('role', 'admin')
            ->where('status', 'active')
            ->get();

        $title = "Nilai Baru Masuk: {$kategoriLabel} {$mapelNama}";

        $message = "Guru {$guru->nama_lengkap} telah memasukkan {$kategoriLabel} {$mapelNama} untuk {$kelasNama}. Silakan periksa/verifikasi nilai.";

        foreach ($admins as $admin) {

            try {
                $admin->addNotification(
                    $title,
                    $message,
                    'warning',
                    'fa-clipboard-check',
                    route('admin.nilai.index') .
                    '?kelas_id=' . $request->kelas_id .
                    '&mapel_id=' . $request->mapel_id
                );
            } catch (\Throwable $e) {

                \Log::error('Gagal membuat notifikasi admin', [
                    'error' => $e->getMessage(),
                    'admin_id' => $admin->id,
                ]);

            }
        }

    } catch (\Throwable $e) {

        \Log::error('Gagal proses notifikasi nilai', [
            'error' => $e->getMessage(),
        ]);
    }

    return redirect()->back()->with(
        'success',
        'Nilai berhasil disimpan.'
    );
}

    public function jadwal()
    {
        $guru = Auth::user()->guru;

        if (! $guru) {
            return redirect()->back()->with('error', 'Data guru tidak ditemukan.');
        }

        $jadwals = $guru->jadwals()->with(['kelas', 'mapel'])->orderBy('jam_mulai')->get()->groupBy('hari');

        return view('guru.jadwal.index', compact('jadwals'));
    }

    public function reviewRaport()
    {
        $guru = Auth::user()->guru;

        if (! $guru) {
            return redirect()->back()->with('error', 'Data guru tidak ditemukan.');
        }

        // Check if guru is wali kelas
        $kelas = Kelas::where('wali_kelas_id', $guru->id)->first();

        $siswas = [];
        if ($kelas) {
            $siswas = $kelas->siswas()->orderBy('nama_lengkap')->get();
        }

        return view('guru.raport.index', compact('kelas', 'siswas'));
    }

    public function showRaport($id)
    {
        $guru = Auth::user()->guru;

        if (! $guru) {
            return redirect()->back()->with('error', 'Data guru tidak ditemukan.');
        }

        // Verify if the student belongs to the class managed by this guru
        $kelas = Kelas::where('wali_kelas_id', $guru->id)->first();

        if (! $kelas) {
            return redirect()->route('guru.raport.index')->with('error', 'Anda bukan Wali Kelas.');
        }

        $siswa = Siswa::where('id', $id)->where('kelas_id', $kelas->id)->first();

        if (! $siswa) {
            return redirect()->route('guru.raport.index')->with('error', 'Siswa tidak ditemukan di kelas Anda.');
        }

        $nilais = $siswa->nilais()->with(['mapel', 'guru'])->orderBy('mapel_id')->get()->groupBy('mapel_id');

        return view('guru.raport.show', compact('nilais', 'siswa'));
    }

    public function exportRaportPdf($id)
    {
        $guru = Auth::user()->guru;

        if (! $guru) {
            return redirect()->back()->with('error', 'Data guru tidak ditemukan.');
        }

        // Verify if the student belongs to the class managed by this guru
        $kelas = Kelas::where('wali_kelas_id', $guru->id)->first();

        if (! $kelas) {
            return redirect()->route('guru.raport.index')->with('error', 'Anda bukan Wali Kelas.');
        }

        $siswa = Siswa::where('id', $id)->where('kelas_id', $kelas->id)->first();

        if (! $siswa) {
            return redirect()->route('guru.raport.index')->with('error', 'Siswa tidak ditemukan di kelas Anda.');
        }

        $nilais = $siswa->nilais()->with(['mapel', 'guru'])->orderBy('mapel_id')->get()->groupBy('mapel_id');

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('guru.raport.pdf', compact('nilais', 'siswa'));
        $pdf->setPaper('a4', 'portrait');

        return $pdf->stream('raport-siswa-'.$siswa->nisn.'.pdf');
    }
}
