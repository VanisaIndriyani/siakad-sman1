<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Pengumuman;

class PengumumanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Pengumuman::create([
            'judul' => 'Penerimaan Peserta Didik Baru (PPDB) 2026/2027',
            'isi' => 'Pendaftaran PPDB Tahun Ajaran 2026/2027 akan segera dibuka mulai tanggal 1 Juni 2026. Persiapkan dokumen yang diperlukan.',
            'is_active' => true,
        ]);

        Pengumuman::create([
            'judul' => 'Jadwal Ujian Semester Genap',
            'isi' => 'Ujian Semester Genap akan dilaksanakan pada tanggal 15-20 Juni 2026. Harap siswa mempersiapkan diri dengan baik.',
            'is_active' => true,
        ]);

        Pengumuman::create([
            'judul' => 'Libur Hari Raya',
            'isi' => 'Dalam rangka menyambut Hari Raya, kegiatan belajar mengajar diliburkan mulai tanggal 25-30 Mei 2026.',
            'is_active' => true,
        ]);
    }
}
