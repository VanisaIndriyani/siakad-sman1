<?php

namespace App\Http\Controllers;

use App\Models\Absensi;
use App\Models\Guru;
use App\Models\Jadwal;
use App\Models\Kelas;
use App\Models\Mapel;
use App\Models\Nilai;
use App\Models\Siswa;
use App\Models\User;
use Endroid\QrCode\Color\Color;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\ErrorCorrectionLevel;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\RoundBlockSizeMode;
use Endroid\QrCode\Writer\PngWriter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class AdminController extends Controller
{
    public function guru(Request $request)
    {
        $query = Guru::with('user');

        // Search
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nip', 'like', "%{$search}%")
                    ->orWhere('nama_lengkap', 'like', "%{$search}%")
                    ->orWhereHas('user', function ($q) use ($search) {
                        $q->where('email', 'like', "%{$search}%");
                    });
            });
        }

        // Filter by Status (Example)
        if ($request->has('status') && $request->status != '') {
            $status = $request->status == 'active' ? 1 : 0;
            $query->where('is_active', $status);
        }

        $gurus = $query->paginate(10);

        return view('admin.guru.index', compact('gurus'));
    }

    public function storeGuru(Request $request)
    {
        $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'nip' => 'required|string|unique:gurus,nip',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6',
            'gelar_depan' => 'nullable|string',
            'gelar_belakang' => 'nullable|string',
            'no_hp' => 'nullable|string',
            'alamat' => 'nullable|string',
        ]);

        DB::transaction(function () use ($request) {
            // Create User
            $user = User::create([
                'name' => $request->nama_lengkap,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => 'guru', // Assuming role column exists or handled via seeder logic, but let's assume 'role' field or similar logic.
                // Wait, UserSeeder uses simple create. Let's check User model if it has 'role'.
                // If not, we might need to rely on the existence of Guru record to determine role, or just name.
                // Looking at UserSeeder in memory (or I should check User model).
                // Let's assume standard User model for now. I'll check User model in a sec.
            ]);

            // Assign role if Spatie is used, or just 'role' column.
            // Based on previous context, it seems role-based access is manual or simple.
            // I'll assume 'role' column exists or just create User.
            // WAIT, `0001_01_01_000000_create_users_table.php` showed `name`, `email`, `password`. NO `role` column!
            // But `DashboardController` logic uses: `if ($user->guru)`. So role is determined by relationship existence.
            // So creating User is enough.

            // Create Guru
            Guru::create([
                'user_id' => $user->id,
                'nip' => $request->nip,
                'nama_lengkap' => $request->nama_lengkap,
                'gelar_depan' => $request->gelar_depan,
                'gelar_belakang' => $request->gelar_belakang,
                'no_hp' => $request->no_hp,
                'alamat' => $request->alamat,
                'is_active' => true,
            ]);
        });

        return redirect()->route('admin.guru.index')->with('success', 'Data Guru berhasil ditambahkan');
    }

    public function importGuruCsv(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:xlsx,xls,csv,txt|max:10240',
        ]);

        $file = $request->file('file');
        $path = $file->getRealPath();
        $ext = strtolower((string) $file->getClientOriginalExtension());
        $rows = $this->readRows($path, $ext);
        if (count($rows) < 2) {
            return redirect()->back()->with('error', 'File kosong.');
        }

        $header = $this->normalizeHeader(array_shift($rows));
        $required = ['nama_lengkap', 'nip', 'email'];
        foreach ($required as $col) {
            if (! array_key_exists($col, $header)) {
                return redirect()->back()->with('error', 'Kolom wajib tidak ditemukan: '.$col);
            }
        }

        $created = 0;
        $skipped = 0;
        $issues = [];

        foreach ($rows as $i => $row) {
            if ($this->isEmptyCsvRow($row)) {
                continue;
            }

            $line = $i + 2;
            $nama = trim((string) ($row[$header['nama_lengkap']] ?? ''));
            $nip = trim((string) ($row[$header['nip']] ?? ''));
            $email = trim((string) ($row[$header['email']] ?? ''));
            $password = trim((string) ($row[$header['password']] ?? ''));

            if ($nama === '' || $nip === '' || $email === '') {
                $skipped++;
                $issues[] = "Baris {$line}: kolom wajib kosong.";

                continue;
            }

            if ($password === '') {
                $password = $nip;
            }

            if (Guru::where('nip', $nip)->exists()) {
                $skipped++;
                $issues[] = "Baris {$line}: NIP sudah ada ({$nip}).";

                continue;
            }

            if (User::where('email', $email)->exists()) {
                $skipped++;
                $issues[] = "Baris {$line}: email sudah ada ({$email}).";

                continue;
            }

            DB::transaction(function () use ($row, $header, $nama, $nip, $email, $password, &$created) {
                $userData = [
                    'name' => $nama,
                    'email' => $email,
                    'password' => Hash::make($password),
                ];
                if (Schema::hasColumn('users', 'username')) {
                    $userData['username'] = $nip;
                }
                if (Schema::hasColumn('users', 'role')) {
                    $userData['role'] = 'guru';
                }
                $user = User::create($userData);

                Guru::create([
                    'user_id' => $user->id,
                    'nip' => $nip,
                    'nama_lengkap' => $nama,
                    'gelar_depan' => trim((string) ($row[$header['gelar_depan']] ?? '')) ?: null,
                    'gelar_belakang' => trim((string) ($row[$header['gelar_belakang']] ?? '')) ?: null,
                    'no_hp' => trim((string) ($row[$header['no_hp']] ?? '')) ?: null,
                    'alamat' => trim((string) ($row[$header['alamat']] ?? '')) ?: null,
                    'is_active' => true,
                ]);

                $created++;
            });
        }

        $message = "Import Guru selesai. Berhasil: {$created}, Dilewati: {$skipped}.";
        if (count($issues)) {
            $message .= ' Catatan: '.implode(' | ', array_slice($issues, 0, 5));
        }

        return redirect()->back()->with('success', $message);
    }

    public function templateGuruCsv()
    {
        $filename = 'template-import-guru.xlsx';

        $spreadsheet = new Spreadsheet;
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Template Guru');

        $sheet->fromArray([
            ['nama_lengkap', 'nip', 'email', 'password', 'gelar_depan', 'gelar_belakang', 'no_hp', 'alamat'],
            ['Budi Santoso', '198001012010011001', 'budi.guru01@sekolah.sch.id', '198001012010011001', 'Dr.', 'M.Pd', '081234567890', 'Jl. Merdeka No 1'],
        ]);

        $sheet->getStyle('1:1')->getFont()->setBold(true);
        foreach (range('A', 'H') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        return response()->streamDownload(function () use ($spreadsheet) {
            $writer = new Xlsx($spreadsheet);
            $writer->save('php://output');
        }, $filename, [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        ]);
    }

    public function updateGuru(Request $request, $id)
    {
        $guru = Guru::findOrFail($id);
        $user = $guru->user;

        $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'nip' => 'required|string|unique:gurus,nip,'.$guru->id,
            'email' => 'required|email|unique:users,email,'.$user->id,
            'gelar_depan' => 'nullable|string',
            'gelar_belakang' => 'nullable|string',
            'no_hp' => 'nullable|string',
            'alamat' => 'nullable|string',
            'is_active' => 'boolean',
        ]);

        DB::transaction(function () use ($request, $guru, $user) {
            // Update User
            $userData = [
                'name' => $request->nama_lengkap,
                'email' => $request->email,
            ];
            if ($request->filled('password')) {
                $userData['password'] = Hash::make($request->password);
            }
            $user->update($userData);

            // Update Guru
            $guru->update([
                'nip' => $request->nip,
                'nama_lengkap' => $request->nama_lengkap,
                'gelar_depan' => $request->gelar_depan,
                'gelar_belakang' => $request->gelar_belakang,
                'no_hp' => $request->no_hp,
                'alamat' => $request->alamat,
                'is_active' => $request->has('is_active'),
            ]);
        });

        return redirect()->route('admin.guru.index')->with('success', 'Data Guru berhasil diperbarui');
    }

    public function destroyGuru($id)
    {
        $guru = Guru::findOrFail($id);
        $user = $guru->user;

        // Deleting user will cascade delete guru
        $user->delete();

        return redirect()->route('admin.guru.index')->with('success', 'Data Guru berhasil dihapus');
    }

    public function storePengumuman(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'isi' => 'required|string',
            'file_pdf' => 'nullable|file|mimes:pdf|max:5120', // Max 5MB
        ]);

        $filePath = null;
        if ($request->hasFile('file_pdf')) {
            $filePath = $request->file('file_pdf')->store('pengumuman', 'public');
        }

        \App\Models\Pengumuman::create([
            'judul' => $request->judul,
            'isi' => $request->isi,
            'file_path' => $filePath,
            'is_active' => true,
        ]);

        $judulPeng = $request->judul;
        $pengId = \App\Models\Pengumuman::latest()->value('id');
        $urlPeng = route('home') . '#pengumuman-' . $pengId;

        User::whereIn('role', ['admin', 'guru', 'siswa', 'kepala_sekolah'])
            ->where('status', 'active')
            ->chunkById(100, function ($users) use ($judulPeng, $urlPeng) {
                foreach ($users as $u) {
                    $u->addNotification(
                        'Pengumuman Baru',
                        "Pengumuman baru tersedia: {$judulPeng}. Silakan baca informasinya.",
                        'info',
                        'fa-bullhorn',
                        $urlPeng
                    );
                }
            });

        return redirect()->back()->with('success', 'Pengumuman berhasil ditambahkan');
    }

    public function updatePengumuman(Request $request, $id)
    {
        $pengumuman = \App\Models\Pengumuman::findOrFail($id);

        $request->validate([
            'judul' => 'required|string|max:255',
            'isi' => 'required|string',
            'file_pdf' => 'nullable|file|mimes:pdf|max:5120',
            'is_active' => 'nullable|boolean',
        ]);

        $data = [
            'judul' => $request->judul,
            'isi' => $request->isi,
            'is_active' => $request->has('is_active'),
        ];

        if ($request->hasFile('file_pdf')) {
            // Delete old file if exists
            if ($pengumuman->file_path) {
                Storage::disk('public')->delete($pengumuman->file_path);
            }
            $data['file_path'] = $request->file('file_pdf')->store('pengumuman', 'public');
        }

        $pengumuman->update($data);

        return redirect()->back()->with('success', 'Pengumuman berhasil diperbarui');
    }

    public function destroyPengumuman($id)
    {
        \App\Models\Pengumuman::findOrFail($id)->delete();

        return redirect()->back()->with('success', 'Pengumuman berhasil dihapus');
    }

    public function siswa(Request $request)
    {
        $query = Siswa::with(['user', 'kelas']);

        // Search
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nisn', 'like', "%{$search}%")
                    ->orWhere('nis', 'like', "%{$search}%")
                    ->orWhere('nama_lengkap', 'like', "%{$search}%");
            });
        }

        // Filter by Tingkat
        if ($request->has('tingkat') && $request->tingkat != '') {
            $query->whereHas('kelas', function ($q) use ($request) {
                $q->where('tingkat', $request->tingkat);
            });
        }

        // Filter by Jurusan
        if ($request->has('jurusan') && $request->jurusan != '') {
            $query->whereHas('kelas', function ($q) use ($request) {
                $q->where('jurusan', $request->jurusan);
            });
        }

        $siswas = $query->paginate(10);
        $kelases = Kelas::all();

        return view('admin.siswa.index', compact('siswas', 'kelases'));
    }

    public function showSiswa($id)
    {
        $siswa = Siswa::with(['user', 'kelas.waliKelas.user'])->findOrFail($id);

        return view('admin.siswa.show', compact('siswa'));
    }

    public function cetakKartuSiswa($id)
    {
        $siswa = Siswa::with('kelas')->findOrFail($id);

        // Mock a class object to reuse the view structure if possible,
        // OR simply reuse the view but ensure $kelas->siswas is just this student.
        // If the student has no class, we create a dummy class object or handle it in view.

        $kelas = $siswa->kelas;

        if (! $kelas) {
            // Create a dummy object if student has no class, though unlikely in this context
            $kelas = new Kelas;
            $kelas->nama_kelas = 'Tanpa Kelas';
        }

        // Override the relation to include only this student
        $kelas->setRelation('siswas', collect([$siswa]));

        $qrDataUris = [];
        $payload = $siswa->nisn ? 'NISN:'.$siswa->nisn : 'ID:'.$siswa->id;
        $writer = new PngWriter;
        $qrCode = new QrCode(
            data: $payload,
            encoding: new Encoding('UTF-8'),
            errorCorrectionLevel: ErrorCorrectionLevel::Low,
            size: 240,
            margin: 1,
            roundBlockSizeMode: RoundBlockSizeMode::Margin,
            foregroundColor: new Color(0, 0, 0),
            backgroundColor: new Color(255, 255, 255),
        );
        $qrDataUris[$siswa->id] = $writer->write($qrCode)->getDataUri();

        return view('admin.kelas.kartu', compact('kelas', 'qrDataUris'));
    }

    public function importSiswaCsv(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:xlsx,xls,csv,txt|max:10240',
        ]);

        $file = $request->file('file');
        $path = $file->getRealPath();
        $ext = strtolower((string) $file->getClientOriginalExtension());
        $rows = $this->readRows($path, $ext);
        if (count($rows) < 2) {
            return redirect()->back()->with('error', 'File kosong.');
        }

        $header = $this->normalizeHeader(array_shift($rows));
        $required = ['nama_lengkap', 'nisn', 'email', 'kelas', 'jenis_kelamin'];
        foreach ($required as $col) {
            if (! array_key_exists($col, $header)) {
                return redirect()->back()->with('error', 'Kolom wajib tidak ditemukan: '.$col);
            }
        }

        $created = 0;
        $skipped = 0;
        $issues = [];

        foreach ($rows as $i => $row) {
            if ($this->isEmptyCsvRow($row)) {
                continue;
            }

            $line = $i + 2;
            $nama = trim((string) ($row[$header['nama_lengkap']] ?? ''));
            $nisn = trim((string) ($row[$header['nisn']] ?? ''));
            $nis = trim((string) ($row[$header['nis']] ?? ''));
            $email = trim((string) ($row[$header['email']] ?? ''));
            $kelasNama = trim((string) ($row[$header['kelas']] ?? ''));
            $jk = strtoupper(trim((string) ($row[$header['jenis_kelamin']] ?? '')));
            $noHpOrtu = trim((string) ($row[$header['no_hp_ortu']] ?? ''));
            $password = trim((string) ($row[$header['password']] ?? ''));

            if ($nama === '' || $nisn === '' || $email === '' || $kelasNama === '' || $jk === '') {
                $skipped++;
                $issues[] = "Baris {$line}: kolom wajib kosong.";

                continue;
            }

            if (! in_array($jk, ['L', 'P'], true)) {
                $skipped++;
                $issues[] = "Baris {$line}: jenis_kelamin harus L atau P.";

                continue;
            }

            $kelas = Kelas::where('nama_kelas', $kelasNama)->first();
            if (! $kelas) {
                $skipped++;
                $issues[] = "Baris {$line}: kelas tidak ditemukan ({$kelasNama}).";

                continue;
            }

            if ($password === '') {
                $password = $nisn;
            }

            if (Siswa::where('nisn', $nisn)->exists()) {
                $skipped++;
                $issues[] = "Baris {$line}: NISN sudah ada ({$nisn}).";

                continue;
            }

            if (User::where('email', $email)->exists()) {
                $skipped++;
                $issues[] = "Baris {$line}: email sudah ada ({$email}).";

                continue;
            }

            DB::transaction(function () use ($nama, $nisn, $nis, $email, $kelas, $jk, $noHpOrtu, $password, &$created) {
                $userData = [
                    'name' => $nama,
                    'email' => $email,
                    'password' => Hash::make($password),
                ];
                if (Schema::hasColumn('users', 'username')) {
                    $userData['username'] = $nisn;
                }
                if (Schema::hasColumn('users', 'role')) {
                    $userData['role'] = 'siswa';
                }
                $user = User::create($userData);

                Siswa::create([
                    'user_id' => $user->id,
                    'kelas_id' => $kelas->id,
                    'nisn' => $nisn,
                    'nis' => $nis !== '' ? $nis : null,
                    'nama_lengkap' => $nama,
                    'jenis_kelamin' => $jk,
                    'no_hp_ortu' => $noHpOrtu !== '' ? $noHpOrtu : null,
                ]);

                $created++;
            });
        }

        $message = "Import Siswa selesai. Berhasil: {$created}, Dilewati: {$skipped}.";
        if (count($issues)) {
            $message .= ' Catatan: '.implode(' | ', array_slice($issues, 0, 5));
        }

        return redirect()->back()->with('success', $message);
    }

    public function templateSiswaCsv()
    {
        $filename = 'template-import-siswa.xlsx';

        $spreadsheet = new Spreadsheet;
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Template Siswa');

        $sheet->fromArray([
            ['nama_lengkap', 'nisn', 'nis', 'email', 'password', 'kelas', 'jenis_kelamin', 'no_hp_ortu'],
            ['Opan Sihombing', '0061257875', '8039', 'opan.siswa01@sekolah.sch.id', '0061257875', 'XII IPA', 'L', '081234567890'],
        ]);

        $sheet->getStyle('1:1')->getFont()->setBold(true);
        foreach (range('A', 'H') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        return response()->streamDownload(function () use ($spreadsheet) {
            $writer = new Xlsx($spreadsheet);
            $writer->save('php://output');
        }, $filename, [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        ]);
    }

    private function readRows(string $path, string $ext): array
    {
        if ($ext === 'xlsx' || $ext === 'xls') {
            return $this->readExcelRows($path);
        }

        return $this->readCsvRows($path);
    }

    private function readExcelRows(string $path): array
    {
        $spreadsheet = IOFactory::load($path);
        $sheet = $spreadsheet->getActiveSheet();
        $raw = $sheet->toArray(null, false, false, false);

        $rows = [];
        foreach ($raw as $row) {
            $rows[] = array_map(static fn ($cell) => is_string($cell) ? trim($cell) : $cell, $row);
        }

        return $rows;
    }

    private function readCsvRows(string $path): array
    {
        $handle = fopen($path, 'r');
        if (! $handle) {
            return [];
        }

        $firstLine = fgets($handle);
        if ($firstLine === false) {
            fclose($handle);

            return [];
        }

        $delimiter = $this->detectDelimiter($firstLine);
        $rows = [];

        $rows[] = str_getcsv($this->normalizeBom($firstLine), $delimiter);
        while (($row = fgetcsv($handle, 0, $delimiter)) !== false) {
            $rows[] = $row;
        }

        fclose($handle);

        return $rows;
    }

    private function detectDelimiter(string $line): string
    {
        $candidates = [',', ';', "\t", '|'];
        $best = ',';
        $bestCount = 0;
        foreach ($candidates as $d) {
            $count = count(str_getcsv($line, $d));
            if ($count > $bestCount) {
                $bestCount = $count;
                $best = $d;
            }
        }

        return $best;
    }

    private function normalizeBom(string $value): string
    {
        return preg_replace('/^\xEF\xBB\xBF/', '', $value) ?? $value;
    }

    private function normalizeHeader(array $row): array
    {
        $map = [];
        foreach ($row as $i => $name) {
            $key = Str::of((string) $name)
                ->lower()
                ->replace([' ', '-', '.', '/'], '_')
                ->replace('__', '_')
                ->toString();

            $aliases = [
                'nama' => 'nama_lengkap',
                'nama_siswa' => 'nama_lengkap',
                'nama_guru' => 'nama_lengkap',
                'nohp_ortu' => 'no_hp_ortu',
                'no_hp_orang_tua' => 'no_hp_ortu',
                'hp_ortu' => 'no_hp_ortu',
                'kelas_id' => 'kelas',
                'nama_kelas' => 'kelas',
                'jk' => 'jenis_kelamin',
            ];

            $key = $aliases[$key] ?? $key;
            $map[$key] = $i;
        }

        return $map;
    }

    private function isEmptyCsvRow(array $row): bool
    {
        foreach ($row as $cell) {
            if (trim((string) $cell) !== '') {
                return false;
            }
        }

        return true;
    }

    public function qrSiswaPng(Request $request, $id)
    {
        $siswa = Siswa::findOrFail($id);
        $payload = $siswa->nisn ? 'NISN:'.$siswa->nisn : 'ID:'.$siswa->id;

        $writer = new PngWriter;
        $qrCode = new QrCode(
            data: $payload,
            encoding: new Encoding('UTF-8'),
            errorCorrectionLevel: ErrorCorrectionLevel::Low,
            size: 240,
            margin: 1,
            roundBlockSizeMode: RoundBlockSizeMode::Margin,
            foregroundColor: new Color(0, 0, 0),
            backgroundColor: new Color(255, 255, 255),
        );

        $result = $writer->write($qrCode);

        $filename = 'qr-'.($siswa->nisn ?: $siswa->id).'.png';
        $disposition = $request->boolean('download') ? 'attachment' : 'inline';

        return response($result->getString(), 200, [
            'Content-Type' => $result->getMimeType(),
            'Content-Disposition' => $disposition.'; filename="'.$filename.'"',
            'Cache-Control' => 'no-store, private',
        ]);
    }

    public function storeSiswa(Request $request)
    {
        $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'nisn' => 'required|string|unique:siswas,nisn',
            'nis' => 'nullable|string',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6',
            'kelas_id' => 'nullable|exists:kelas,id',
            'jenis_kelamin' => 'required|in:L,P',
            'tempat_lahir' => 'nullable|string',
            'tanggal_lahir' => 'nullable|date',
            'alamat' => 'nullable|string',
            'nama_ayah' => 'nullable|string',
            'nama_ibu' => 'nullable|string',
            'no_hp_ortu' => 'nullable|string',
        ]);

        DB::transaction(function () use ($request) {
            // Create User
            $user = User::create([
                'name' => $request->nama_lengkap,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);

            // Create Siswa
            Siswa::create([
                'user_id' => $user->id,
                'kelas_id' => $request->kelas_id,
                'nisn' => $request->nisn,
                'nis' => $request->nis,
                'nama_lengkap' => $request->nama_lengkap,
                'jenis_kelamin' => $request->jenis_kelamin,
                'tempat_lahir' => $request->tempat_lahir,
                'tanggal_lahir' => $request->tanggal_lahir,
                'alamat' => $request->alamat,
                'nama_ayah' => $request->nama_ayah,
                'nama_ibu' => $request->nama_ibu,
                'no_hp_ortu' => $request->no_hp_ortu,
            ]);
        });

        return redirect()->route('admin.siswa.index')->with('success', 'Data Siswa berhasil ditambahkan');
    }

    public function updateSiswa(Request $request, $id)
    {
        $siswa = Siswa::findOrFail($id);
        $user = $siswa->user;

        $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'nisn' => 'required|string|unique:siswas,nisn,'.$siswa->id,
            'nis' => 'nullable|string',
            'email' => 'required|email|unique:users,email,'.$user->id,
            'kelas_id' => 'nullable|exists:kelas,id',
            'jenis_kelamin' => 'required|in:L,P',
            'tempat_lahir' => 'nullable|string',
            'tanggal_lahir' => 'nullable|date',
            'alamat' => 'nullable|string',
            'nama_ayah' => 'nullable|string',
            'nama_ibu' => 'nullable|string',
            'no_hp_ortu' => 'nullable|string',
        ]);

        DB::transaction(function () use ($request, $siswa, $user) {
            // Update User
            $userData = [
                'name' => $request->nama_lengkap,
                'email' => $request->email,
            ];
            if ($request->filled('password')) {
                $userData['password'] = Hash::make($request->password);
            }
            $user->update($userData);

            // Update Siswa
            $siswa->update([
                'kelas_id' => $request->kelas_id,
                'nisn' => $request->nisn,
                'nis' => $request->nis,
                'nama_lengkap' => $request->nama_lengkap,
                'jenis_kelamin' => $request->jenis_kelamin,
                'tempat_lahir' => $request->tempat_lahir,
                'tanggal_lahir' => $request->tanggal_lahir,
                'alamat' => $request->alamat,
                'nama_ayah' => $request->nama_ayah,
                'nama_ibu' => $request->nama_ibu,
                'no_hp_ortu' => $request->no_hp_ortu,
            ]);
        });

        return redirect()->route('admin.siswa.index')->with('success', 'Data Siswa berhasil diperbarui');
    }

    public function destroySiswa($id)
    {
        $siswa = Siswa::findOrFail($id);
        $user = $siswa->user;
        $user->delete();

        return redirect()->route('admin.siswa.index')->with('success', 'Data Siswa berhasil dihapus');
    }

    public function exportSiswa()
    {
        $siswas = Siswa::with('kelas')->get();
        $filename = 'data_siswa_'.date('YmdHis').'.csv';

        $headers = [
            'Content-type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=$filename",
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0',
        ];

        $columns = ['NISN', 'NIS', 'Nama Lengkap', 'Kelas', 'Jenis Kelamin', 'Tempat Lahir', 'Tanggal Lahir', 'Alamat', 'Nama Ayah', 'Nama Ibu', 'No HP Ortu'];

        $callback = function () use ($siswas, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);

            foreach ($siswas as $siswa) {
                $row['NISN'] = $siswa->nisn;
                $row['NIS'] = $siswa->nis;
                $row['Nama Lengkap'] = $siswa->nama_lengkap;
                $row['Kelas'] = $siswa->kelas ? $siswa->kelas->nama_kelas : '-';
                $row['Jenis Kelamin'] = $siswa->jenis_kelamin;
                $row['Tempat Lahir'] = $siswa->tempat_lahir;
                $row['Tanggal Lahir'] = $siswa->tanggal_lahir;
                $row['Alamat'] = $siswa->alamat;
                $row['Nama Ayah'] = $siswa->nama_ayah;
                $row['Nama Ibu'] = $siswa->nama_ibu;
                $row['No HP Ortu'] = $siswa->no_hp_ortu;

                fputcsv($file, [
                    $row['NISN'],
                    $row['NIS'],
                    $row['Nama Lengkap'],
                    $row['Kelas'],
                    $row['Jenis Kelamin'],
                    $row['Tempat Lahir'],
                    $row['Tanggal Lahir'],
                    $row['Alamat'],
                    $row['Nama Ayah'],
                    $row['Nama Ibu'],
                    $row['No HP Ortu'],
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function kelas(Request $request)
    {
        $query = Kelas::with('waliKelas')->withCount('siswas');

        // Search
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where('nama_kelas', 'like', "%{$search}%");
        }

        // Filter by Tingkat
        if ($request->has('tingkat') && $request->tingkat != '') {
            $query->where('tingkat', $request->tingkat);
        }

        // Filter by Jurusan
        if ($request->has('jurusan') && $request->jurusan != '') {
            $query->where('jurusan', $request->jurusan);
        }

        $kelases = $query->paginate(10);
        $gurus = Guru::all(); // For assigning wali kelas

        return view('admin.kelas.index', compact('kelases', 'gurus'));
    }

    public function showKelas($id)
    {
        $kelas = Kelas::with(['waliKelas', 'siswas'])->findOrFail($id);

        return view('admin.kelas.show', compact('kelas'));
    }

    public function cetakKartu($id)
    {
        $kelas = Kelas::with(['siswas', 'waliKelas'])->findOrFail($id);

        $writer = new PngWriter;
        $qrDataUris = [];
        foreach ($kelas->siswas as $siswa) {
            $payload = $siswa->nisn ? 'NISN:'.$siswa->nisn : 'ID:'.$siswa->id;
            $qrCode = new QrCode(
                data: $payload,
                encoding: new Encoding('UTF-8'),
                errorCorrectionLevel: ErrorCorrectionLevel::Low,
                size: 240,
                margin: 1,
                roundBlockSizeMode: RoundBlockSizeMode::Margin,
                foregroundColor: new Color(0, 0, 0),
                backgroundColor: new Color(255, 255, 255),
            );
            $qrDataUris[$siswa->id] = $writer->write($qrCode)->getDataUri();
        }

        return view('admin.kelas.kartu', compact('kelas', 'qrDataUris'));
    }

    public function storeKelas(Request $request)
    {
        $request->validate([
            'nama_kelas' => 'required|string|max:255',
            'tingkat' => 'required|in:10,11,12',
            'jurusan' => 'required|in:IPA,IPS,BAHASA',
            'wali_kelas_id' => 'nullable|exists:gurus,id',
        ]);

        Kelas::create([
            'nama_kelas' => $request->nama_kelas,
            'tingkat' => $request->tingkat,
            'jurusan' => $request->jurusan,
            'wali_kelas_id' => $request->wali_kelas_id,
            'tahun_ajaran' => '2025/2026', // Default for now
        ]);

        return redirect()->route('admin.kelas.index')->with('success', 'Kelas berhasil ditambahkan');
    }

    public function updateKelas(Request $request, $id)
    {
        $kelas = Kelas::findOrFail($id);

        $request->validate([
            'nama_kelas' => 'required|string|max:255',
            'tingkat' => 'required|in:10,11,12',
            'jurusan' => 'required|in:IPA,IPS,BAHASA',
            'wali_kelas_id' => 'nullable|exists:gurus,id',
        ]);

        $kelas->update([
            'nama_kelas' => $request->nama_kelas,
            'tingkat' => $request->tingkat,
            'jurusan' => $request->jurusan,
            'wali_kelas_id' => $request->wali_kelas_id,
        ]);

        return redirect()->route('admin.kelas.index')->with('success', 'Kelas berhasil diperbarui');
    }

    public function destroyKelas($id)
    {
        Kelas::findOrFail($id)->delete();

        return redirect()->route('admin.kelas.index')->with('success', 'Kelas berhasil dihapus');
    }

    public function mapel(Request $request)
    {
        $query = Mapel::query();

        // Search
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('kode_mapel', 'like', "%{$search}%")
                    ->orWhere('nama_mapel', 'like', "%{$search}%");
            });
        }

        // Filter by Kelompok
        if ($request->has('kelompok') && $request->kelompok != '') {
            $query->where('kelompok', $request->kelompok);
        }

        $mapels = $query->paginate(10);

        return view('admin.mapel.index', compact('mapels'));
    }

    public function storeMapel(Request $request)
    {
        $request->validate([
            'kode_mapel' => 'required|string|unique:mapels,kode_mapel',
            'nama_mapel' => 'required|string|max:255',
            'kelompok' => 'required|in:A,B,C',
            'kkm' => 'required|integer|min:0|max:100',
        ]);

        Mapel::create([
            'kode_mapel' => $request->kode_mapel,
            'nama_mapel' => $request->nama_mapel,
            'kelompok' => $request->kelompok,
            'kkm' => $request->kkm,
        ]);

        return redirect()->route('admin.mapel.index')->with('success', 'Mata Pelajaran berhasil ditambahkan');
    }

    public function updateMapel(Request $request, $id)
    {
        $mapel = Mapel::findOrFail($id);

        $request->validate([
            'kode_mapel' => 'required|string|unique:mapels,kode_mapel,'.$mapel->id,
            'nama_mapel' => 'required|string|max:255',
            'kelompok' => 'required|in:A,B,C',
            'kkm' => 'required|integer|min:0|max:100',
        ]);

        $mapel->update([
            'kode_mapel' => $request->kode_mapel,
            'nama_mapel' => $request->nama_mapel,
            'kelompok' => $request->kelompok,
            'kkm' => $request->kkm,
        ]);

        return redirect()->route('admin.mapel.index')->with('success', 'Mata Pelajaran berhasil diperbarui');
    }

    public function destroyMapel($id)
    {
        Mapel::findOrFail($id)->delete();

        return redirect()->route('admin.mapel.index')->with('success', 'Mata Pelajaran berhasil dihapus');
    }

    public function jadwal(Request $request)
    {
        $query = Jadwal::with(['kelas', 'mapel', 'guru']);

        // Search
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->whereHas('mapel', function ($q) use ($search) {
                    $q->where('nama_mapel', 'like', "%{$search}%");
                })
                    ->orWhereHas('guru', function ($q) use ($search) {
                        $q->where('nama_lengkap', 'like', "%{$search}%");
                    })
                    ->orWhereHas('kelas', function ($q) use ($search) {
                        $q->where('nama_kelas', 'like', "%{$search}%");
                    });
            });
        }

        // Filter by Hari
        if ($request->has('hari') && $request->hari != '') {
            $query->where('hari', $request->hari);
        }

        // Filter by Kelas
        if ($request->has('kelas_id') && $request->kelas_id != '') {
            $query->where('kelas_id', $request->kelas_id);
        }

        $jadwals = $query->orderByRaw("FIELD(hari, 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu')")->orderBy('jam_mulai')->paginate(10);
        $kelases = Kelas::all();
        $mapels = Mapel::all();
        $gurus = Guru::where('is_active', true)->get();

        return view('admin.jadwal.index', compact('jadwals', 'kelases', 'mapels', 'gurus'));
    }

    public function storeJadwal(Request $request)
    {
        $request->validate([
            'kelas_id' => 'required|exists:kelas,id',
            'mapel_id' => 'required|exists:mapels,id',
            'guru_id' => 'required|exists:gurus,id',
            'hari' => 'required|in:Senin,Selasa,Rabu,Kamis,Jumat,Sabtu',
            'jam_mulai' => 'required',
            'jam_selesai' => 'required|after:jam_mulai',
            'ruangan' => 'nullable|string',
        ]);

        $jadwal = Jadwal::create([
            'kelas_id' => $request->kelas_id,
            'mapel_id' => $request->mapel_id,
            'guru_id' => $request->guru_id,
            'hari' => $request->hari,
            'jam_mulai' => $request->jam_mulai,
            'jam_selesai' => $request->jam_selesai,
            'ruangan' => $request->ruangan,
            'semester' => 'Genap',
            'tahun_ajaran' => '2025/2026',
        ]);

        $this->notifyJadwalChanged($jadwal, true);

        return redirect()->route('admin.jadwal.index')->with('success', 'Jadwal berhasil ditambahkan');
    }

    public function updateJadwal(Request $request, $id)
    {
        $jadwal = Jadwal::findOrFail($id);

        $request->validate([
            'kelas_id' => 'required|exists:kelas,id',
            'mapel_id' => 'required|exists:mapels,id',
            'guru_id' => 'required|exists:gurus,id',
            'hari' => 'required|in:Senin,Selasa,Rabu,Kamis,Jumat,Sabtu',
            'jam_mulai' => 'required',
            'jam_selesai' => 'required|after:jam_mulai',
            'ruangan' => 'nullable|string',
        ]);

        $jadwal->update([
            'kelas_id' => $request->kelas_id,
            'mapel_id' => $request->mapel_id,
            'guru_id' => $request->guru_id,
            'hari' => $request->hari,
            'jam_mulai' => $request->jam_mulai,
            'jam_selesai' => $request->jam_selesai,
            'ruangan' => $request->ruangan,
        ]);

        $this->notifyJadwalChanged($jadwal->fresh(), false);

        return redirect()->route('admin.jadwal.index')->with('success', 'Jadwal berhasil diperbarui');
    }

    public function destroyJadwal($id)
    {
        Jadwal::findOrFail($id)->delete();

        return redirect()->route('admin.jadwal.index')->with('success', 'Jadwal berhasil dihapus');
    }

    public function nilai(Request $request)
    {
        $query = Nilai::with(['siswa.kelas', 'mapel', 'guru']);

        // Search
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->whereHas('siswa', function ($q) use ($search) {
                    $q->where('nama_lengkap', 'like', "%{$search}%")
                        ->orWhere('nisn', 'like', "%{$search}%");
                })
                    ->orWhereHas('mapel', function ($q) use ($search) {
                        $q->where('nama_mapel', 'like', "%{$search}%");
                    });
            });
        }

        // Filter by Kelas
        if ($request->has('kelas_id') && $request->kelas_id != '') {
            $query->whereHas('siswa', function ($q) use ($request) {
                $q->where('kelas_id', $request->kelas_id);
            });
        }

        // Filter by Mapel
        if ($request->has('mapel_id') && $request->mapel_id != '') {
            $query->where('mapel_id', $request->mapel_id);
        }

        // Filter by Kategori
        if ($request->has('kategori') && $request->kategori != '') {
            $query->where('kategori', $request->kategori);
        }

        $nilais = $query->latest()->paginate(20);
        $kelases = Kelas::all();
        $mapels = Mapel::all();

        return view('admin.nilai.index', compact('nilais', 'kelases', 'mapels'));
    }

    public function exportNilaiPdf(Request $request)
    {
        $query = Nilai::with(['siswa.kelas', 'mapel']);

        // Search by Siswa or Mapel
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->whereHas('siswa', function ($q) use ($search) {
                    $q->where('nama_lengkap', 'like', "%{$search}%");
                })
                    ->orWhereHas('mapel', function ($q) use ($search) {
                        $q->where('nama_mapel', 'like', "%{$search}%");
                    });
            });
        }

        // Filter by Kelas
        if ($request->has('kelas_id') && $request->kelas_id != '') {
            $query->whereHas('siswa', function ($q) use ($request) {
                $q->where('kelas_id', $request->kelas_id);
            });
        }

        // Filter by Mapel
        if ($request->has('mapel_id') && $request->mapel_id != '') {
            $query->where('mapel_id', $request->mapel_id);
        }

        // Filter by Kategori
        if ($request->has('kategori') && $request->kategori != '') {
            $query->where('kategori', $request->kategori);
        }

        $nilais = $query->latest()->get();
        $kelas = $request->kelas_id ? Kelas::find($request->kelas_id) : null;
        $mapel = $request->mapel_id ? Mapel::find($request->mapel_id) : null;
        $kategori = $request->kategori;

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('admin.nilai.pdf', compact('nilais', 'kelas', 'mapel', 'kategori'));
        $pdf->setPaper('a4', 'portrait');

        return $pdf->stream('laporan-nilai.pdf');
    }

    public function pengumuman()
    {
        $pengumumans = \App\Models\Pengumuman::latest()->paginate(10);

        return view('admin.pengumuman.index', compact('pengumumans'));
    }

    public function profile()
    {
        return view('admin.profile');
    }

    public function updateProfile(Request $request)
    {
        $user = \Illuminate\Support\Facades\Auth::user();

        $request->validate([
            'email' => 'required|email|unique:users,email,'.$user->id,
            'password' => 'nullable|string|min:6|confirmed',
        ]);

        $userData = [
            'email' => $request->email,
        ];

        if ($request->filled('password')) {
            $userData['password'] = Hash::make($request->password);
        }

        $user->update($userData);

        return redirect()->back()->with('success', 'Profil berhasil diperbarui');
    }

    public function absensi(Request $request)
    {
        $query = Absensi::with(['siswa', 'kelas', 'mapel', 'guru']);

        // Search by Student Name
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->whereHas('siswa', function ($q) use ($search) {
                $q->where('nama_lengkap', 'like', "%{$search}%");
            });
        }

        // Filter by Kelas
        if ($request->has('kelas_id') && $request->kelas_id != '') {
            $query->where('kelas_id', $request->kelas_id);
        }

        // Filter by Mapel
        if ($request->has('mapel_id') && $request->mapel_id != '') {
            $query->where('mapel_id', $request->mapel_id);
        }

        $absensis = $query->latest()->paginate(20);
        $kelases = Kelas::all();
        $mapels = Mapel::all();

        return view('admin.absensi.index', compact('absensis', 'kelases', 'mapels'));
    }

    public function exportAbsensiPdf(Request $request)
    {
        $query = Absensi::with(['siswa', 'kelas', 'mapel', 'guru']);

        // Search by Student Name
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->whereHas('siswa', function ($q) use ($search) {
                $q->where('nama_lengkap', 'like', "%{$search}%");
            });
        }

        // Filter by Kelas
        if ($request->has('kelas_id') && $request->kelas_id != '') {
            $query->where('kelas_id', $request->kelas_id);
        }

        // Filter by Mapel
        if ($request->has('mapel_id') && $request->mapel_id != '') {
            $query->where('mapel_id', $request->mapel_id);
        }

        $absensis = $query->latest()->get();
        $kelas = $request->kelas_id ? Kelas::find($request->kelas_id) : null;
        $mapel = $request->mapel_id ? Mapel::find($request->mapel_id) : null;

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('admin.absensi.pdf', compact('absensis', 'kelas', 'mapel'));
        $pdf->setPaper('a4', 'portrait');

        return $pdf->stream('laporan-absensi.pdf');
    }

    public function verifikasiPengguna(Request $request)
    {
        $query = User::with(['guru', 'siswa'])->whereIn('status', ['pending', 'rejected', 'inactive']);

        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }

        if ($request->has('role') && $request->role != '') {
            $query->where('role', $request->role);
        }

        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('username', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });
        }

        $pendingUsers = $query->latest()->paginate(15);
        $activeCount = User::where('status', 'active')->count();
        $pendingCount = User::where('status', 'pending')->count();
        $rejectedCount = User::where('status', 'rejected')->count();

        return view('admin.verifikasi_pengguna.index', compact('pendingUsers', 'activeCount', 'pendingCount', 'rejectedCount'));
    }

    public function approveUser($id)
    {
        $user = User::findOrFail($id);

        if (! in_array($user->status, ['pending', 'rejected', 'inactive'])) {
            return back()->with('error', 'Status akun tidak dapat diubah.');
        }

        $user->update([
            'status' => 'active',
            'rejection_note' => null,
        ]);

        if ($user->role === 'guru' && $user->guru) {
            $user->guru->update(['is_active' => true]);
        }

        $roleLabel = match ($user->role) {
            'guru' => 'Guru',
            'siswa' => 'Siswa',
            'kepala_sekolah' => 'Kepala Sekolah',
            'admin' => 'Admin',
            'tendik' => 'Tenaga Kependidikan',
            default => ucfirst($user->role),
        };
        $user->addNotification(
            'Akun Disetujui',
            "Selamat! Akun {$roleLabel} Anda telah disetujui oleh Admin. Silakan login untuk mengakses sistem.",
            'success',
            'fa-check-circle',
            route('login')
        );

        return back()->with('success', "Akun {$user->name} berhasil disetujui dan dapat login.");
    }

    public function rejectUser(Request $request, $id)
    {
        $request->validate([
            'rejection_note' => 'nullable|string|max:500',
        ]);

        $user = User::findOrFail($id);

        if (! in_array($user->status, ['pending', 'active', 'inactive'])) {
            return back()->with('error', 'Status akun tidak dapat diubah.');
        }

        $user->update([
            'status' => 'rejected',
            'rejection_note' => $request->rejection_note,
        ]);

        if ($user->role === 'guru' && $user->guru) {
            $user->guru->update(['is_active' => false]);
        }

        $note = $request->rejection_note ? " Alasan: {$request->rejection_note}" : '';
        $roleLabel = match ($user->role) {
            'guru' => 'Guru',
            'siswa' => 'Siswa',
            'kepala_sekolah' => 'Kepala Sekolah',
            'admin' => 'Admin',
            'tendik' => 'Tenaga Kependidikan',
            default => ucfirst($user->role),
        };
        $user->addNotification(
            'Akun Ditolak',
            "Mohon maaf, akun {$roleLabel} Anda ditolak oleh Admin.{$note}",
            'danger',
            'fa-times-circle',
            null
        );

        return back()->with('success', "Akun {$user->name} berhasil ditolak.");
    }

    public function deactivateUser($id)
    {
        $user = User::findOrFail($id);

        if ($user->status !== 'active') {
            return back()->with('error', 'Hanya akun Active yang dapat dinonaktifkan.');
        }

        $user->update([
            'status' => 'inactive',
        ]);

        if ($user->role === 'guru' && $user->guru) {
            $user->guru->update(['is_active' => false]);
        }

        $roleLabel = $user->role === 'guru' ? 'Guru' : ($user->role === 'siswa' ? 'Siswa' : ($user->role === 'kepala_sekolah' ? 'Kepala Sekolah' : $user->role));
        $user->addNotification(
            'Akun Dinonaktifkan',
            "Akun {$roleLabel} Anda telah dinonaktifkan oleh Admin. Silakan hubungi Admin untuk informasi lebih lanjut.",
            'warning',
            'fa-ban',
            null
        );

        return back()->with('success', "Akun {$user->name} berhasil dinonaktifkan.");
    }

    private function notifyJadwalChanged(Jadwal $jadwal, bool $isNew): void
    {
        $jadwal->loadMissing(['kelas', 'mapel', 'guru.user']);

        $kelasNama = $jadwal->kelas?->nama_kelas ?? 'Kelas';
        $mapelNama = $jadwal->mapel?->nama_mapel ?? 'Mapel';
        $ruangan = $jadwal->ruangan ? " (Ruangan: {$jadwal->ruangan})" : '';
        $action = $isNew ? 'ditambahkan' : 'diperbarui';

        if ($jadwal->guru && $jadwal->guru->user && $jadwal->guru->user->status === 'active') {
            $jadwal->guru->user->addNotification(
                "Jadwal Mengajar {$action}",
                "Jadwal {$mapelNama} kelas {$kelasNama} pada hari {$jadwal->hari} {$jadwal->jam_mulai}-{$jadwal->jam_selesai}{$ruangan} telah {$action}.",
                $isNew ? 'success' : 'warning',
                'fa-calendar-plus',
                route('guru.jadwal')
            );
        }

        $siswasNotif = Siswa::where('kelas_id', $jadwal->kelas_id)
            ->with('user')
            ->whereHas('user', function ($q) {
                $q->where('status', 'active');
            })
            ->get();

        $titleSiswa = "Jadwal Pelajaran {$action}";
        $msgSiswa = "Jadwal {$mapelNama} hari {$jadwal->hari} {$jadwal->jam_mulai}-{$jadwal->jam_selesai}{$ruangan} untuk kelas {$kelasNama} telah {$action}.";
        foreach ($siswasNotif as $s) {
            if ($s->user) {
                $s->user->addNotification(
                    $titleSiswa,
                    $msgSiswa,
                    $isNew ? 'info' : 'warning',
                    'fa-calendar-alt',
                    route('siswa.jadwal')
                );
            }
        }
    }

    public function resetPassword(Request $request, $id)
    {
        $request->validate([
            'password' => 'required|string|min:6|confirmed',
        ]);

        $user = User::findOrFail($id);

        $user->update([
            'password' => $request->password,
        ]);

        $roleLabel = $user->role === 'guru' ? 'Guru' : ($user->role === 'siswa' ? 'Siswa' : ($user->role === 'kepala_sekolah' ? 'Kepala Sekolah' : $user->role));
        $user->addNotification(
            'Password Direset oleh Admin',
            "Password akun {$roleLabel} Anda telah direset oleh Admin. Silakan gunakan password baru untuk login dan segera ganti password Anda.",
            'warning',
            'fa-key',
            route('login')
        );

        return back()->with('success', "Password akun {$user->name} berhasil direset.");
    }

    public function laporanMasalah(Request $request)
    {
        $query = \App\Models\LaporanMasalah::with(['user', 'admin']);

        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }

        if ($request->has('kategori') && $request->kategori != '') {
            $query->where('kategori', $request->kategori);
        }

        $laporans = $query->latest()->paginate(15);

        return view('admin.laporan_masalah.index', compact('laporans'));
    }

    public function responLaporanMasalah(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:open,in_progress,resolved,closed',
            'respon_admin' => 'nullable|string|max:1000',
        ]);

        $laporan = \App\Models\LaporanMasalah::findOrFail($id);
        $admin = Auth::user();

        $laporan->update([
            'status' => $request->status,
            'respon_admin' => $request->respon_admin,
            'admin_id' => $admin->id,
            'resolved_at' => in_array($request->status, ['resolved', 'closed']) ? now() : null,
        ]);

        if ($laporan->user) {
            $statusLabel = [
                'open' => 'Dibuka',
                'in_progress' => 'Diproses',
                'resolved' => 'Selesai',
                'closed' => 'Ditutup',
            ];

            $laporan->user->addNotification(
                "Laporan Masalah: {$statusLabel[$request->status]}",
                "Laporan Anda dengan subjek '{$laporan->subject}' telah diperbarui. Status: {$statusLabel[$request->status]}." . ($request->respon_admin ? " Respon: {$request->respon_admin}" : ''),
                $request->status === 'resolved' ? 'success' : 'info',
                'fa-headset',
                route('bantuan.lapor')
            );
        }

        return back()->with('success', 'Laporan masalah berhasil diperbarui.');
    }

    public function kelolaFaq(Request $request)
    {
        $faqs = \App\Models\Faq::orderBy('sort_order')->paginate(20);
        return view('admin.faq.index', compact('faqs'));
    }

    public function storeFaq(Request $request)
    {
        $request->validate([
            'question' => 'required|string|max:500',
            'answer' => 'required|string|max:5000',
            'for_role' => 'required|in:all,admin,guru,siswa,kepala_sekolah',
            'sort_order' => 'nullable|integer|min:0|max:999',
            'is_active' => 'nullable|boolean',
        ]);

        \App\Models\Faq::create([
            'question' => $request->question,
            'answer' => $request->answer,
            'for_role' => $request->for_role,
            'sort_order' => $request->sort_order ?? 0,
            'is_active' => $request->has('is_active'),
        ]);

        return back()->with('success', 'FAQ berhasil ditambahkan.');
    }

    public function updateFaq(Request $request, $id)
    {
        $faq = \App\Models\Faq::findOrFail($id);

        $request->validate([
            'question' => 'required|string|max:500',
            'answer' => 'required|string|max:5000',
            'for_role' => 'required|in:all,admin,guru,siswa,kepala_sekolah',
            'sort_order' => 'nullable|integer|min:0|max:999',
            'is_active' => 'nullable|boolean',
        ]);

        $faq->update([
            'question' => $request->question,
            'answer' => $request->answer,
            'for_role' => $request->for_role,
            'sort_order' => $request->sort_order ?? 0,
            'is_active' => $request->has('is_active'),
        ]);

        return back()->with('success', 'FAQ berhasil diperbarui.');
    }

    public function destroyFaq($id)
    {
        \App\Models\Faq::findOrFail($id)->delete();
        return back()->with('success', 'FAQ berhasil dihapus.');
    }

    public function kelolaKebijakan(Request $request)
    {
        $kebijakans = \App\Models\Kebijakan::latest()->paginate(15);
        return view('admin.kebijakan.index', compact('kebijakans'));
    }

    public function storeKebijakan(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:kebijakans,slug',
            'content' => 'required|string|max:10000',
            'for_role' => 'required|in:all,admin,guru,siswa,kepala_sekolah',
            'is_active' => 'nullable|boolean',
        ]);

        \App\Models\Kebijakan::create([
            'title' => $request->title,
            'slug' => $request->slug,
            'content' => $request->content,
            'for_role' => $request->for_role,
            'is_active' => $request->has('is_active'),
        ]);

        return back()->with('success', 'Kebijakan berhasil ditambahkan.');
    }

    public function updateKebijakan(Request $request, $id)
    {
        $kebijakan = \App\Models\Kebijakan::findOrFail($id);

        $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:kebijakans,slug,' . $kebijakan->id,
            'content' => 'required|string|max:10000',
            'for_role' => 'required|in:all,admin,guru,siswa,kepala_sekolah',
            'is_active' => 'nullable|boolean',
        ]);

        $kebijakan->update([
            'title' => $request->title,
            'slug' => $request->slug,
            'content' => $request->content,
            'for_role' => $request->for_role,
            'is_active' => $request->has('is_active'),
        ]);

        return back()->with('success', 'Kebijakan berhasil diperbarui.');
    }

    public function destroyKebijakan($id)
    {
        \App\Models\Kebijakan::findOrFail($id)->delete();
        return back()->with('success', 'Kebijakan berhasil dihapus.');
    }
}
