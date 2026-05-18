<?php

namespace Database\Seeders;

use App\Models\Mapel;
use Illuminate\Database\Seeder;

class MapelSeeder extends Seeder
{
    public function run(): void
    {
        $mapels = [
            ['kode' => 'MAT01', 'nama' => 'Matematika Wajib', 'kelompok' => 'A'],
            ['kode' => 'FIS01', 'nama' => 'Fisika', 'kelompok' => 'C'],
            ['kode' => 'KIM01', 'nama' => 'Kimia', 'kelompok' => 'C'],
            ['kode' => 'BIO01', 'nama' => 'Biologi', 'kelompok' => 'C'],
            ['kode' => 'IND01', 'nama' => 'Bahasa Indonesia', 'kelompok' => 'A'],
            ['kode' => 'ING01', 'nama' => 'Bahasa Inggris', 'kelompok' => 'A'],
            ['kode' => 'AGM01', 'nama' => 'Pendidikan Agama', 'kelompok' => 'A'],
            ['kode' => 'PKN01', 'nama' => 'PKN', 'kelompok' => 'A'],
        ];

        foreach ($mapels as $m) {
            Mapel::create([
                'kode_mapel' => $m['kode'],
                'nama_mapel' => $m['nama'],
                'kelompok' => $m['kelompok'],
                'kkm' => 75,
            ]);
        }
    }
}
