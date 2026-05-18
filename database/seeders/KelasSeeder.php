<?php

namespace Database\Seeders;

use App\Models\Guru;
use App\Models\Kelas;
use Illuminate\Database\Seeder;

class KelasSeeder extends Seeder
{
    public function run(): void
    {
        $gurus = Guru::all();
        $guruIndex = 0;

        $tingkats = ['10', '11', '12'];
        $jurusans = ['IPA', 'IPS'];
        
        // Create 1 class for each combination (Total 6 classes)
        foreach ($tingkats as $tingkat) {
            foreach ($jurusans as $jurusan) {
                $namaKelas = '';
                if ($tingkat == '10') $namaKelas = 'X';
                elseif ($tingkat == '11') $namaKelas = 'XI';
                elseif ($tingkat == '12') $namaKelas = 'XII';
                
                $namaKelas .= ' ' . $jurusan;

                // Assign Wali Kelas if available
                $waliKelasId = null;
                if (isset($gurus[$guruIndex])) {
                    $waliKelasId = $gurus[$guruIndex]->id;
                    $guruIndex++;
                }

                Kelas::create([
                    'nama_kelas' => $namaKelas,
                    'tingkat' => $tingkat,
                    'jurusan' => $jurusan,
                    'wali_kelas_id' => $waliKelasId,
                ]);
            }
        }
    }
}
