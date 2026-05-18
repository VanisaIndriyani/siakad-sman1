<?php

namespace Database\Seeders;

use App\Models\Guru;
use App\Models\Mapel;
use App\Models\Nilai;
use App\Models\Siswa;
use Illuminate\Database\Seeder;

class NilaiSeeder extends Seeder
{
    public function run(): void
    {
        $siswa = Siswa::first();
        $guru = Guru::first();
        $mapel = Mapel::where('nama_mapel', 'Matematika Wajib')->first();

        if ($siswa && $guru && $mapel) {
            Nilai::create([
                'siswa_id' => $siswa->id,
                'mapel_id' => $mapel->id,
                'guru_id' => $guru->id,
                'kategori' => 'UH1',
                'nilai' => 85,
                'catatan' => 'Bagus, pertahankan',
            ]);

            Nilai::create([
                'siswa_id' => $siswa->id,
                'mapel_id' => $mapel->id,
                'guru_id' => $guru->id,
                'kategori' => 'UTS',
                'nilai' => 80,
            ]);

             Nilai::create([
                'siswa_id' => $siswa->id,
                'mapel_id' => $mapel->id,
                'guru_id' => $guru->id,
                'kategori' => 'UAS',
                'nilai' => 88,
            ]);
        }
    }
}
