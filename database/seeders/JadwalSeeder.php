<?php

namespace Database\Seeders;

use App\Models\Guru;
use App\Models\Jadwal;
use App\Models\Kelas;
use App\Models\Mapel;
use Illuminate\Database\Seeder;

class JadwalSeeder extends Seeder
{
    public function run(): void
    {
        // Ambil semua data yang diperlukan
        $kelases = Kelas::all();
        $gurus = Guru::all();
        $mapels = Mapel::all();

        // Pastikan data tersedia
        if ($kelases->isEmpty() || $gurus->isEmpty() || $mapels->isEmpty()) {
            return;
        }

        foreach ($kelases as $kelas) {
            // Jadwal Senin - Kamis (07:00 - 15:00)
            $days = ['Senin', 'Selasa', 'Rabu', 'Kamis'];
            foreach ($days as $day) {
                // Acak mapel untuk hari ini agar bervariasi
                $dailyMapels = $mapels->shuffle();
                $dailyGurus = $gurus->shuffle(); // Acak guru juga

                // Sesi 1: 07:00 - 09:00
                $this->createJadwal($kelas, $dailyMapels[0], $dailyGurus[0], $day, '07:00', '09:00', 'R-' . $kelas->nama_kelas);

                // Sesi 2: 09:00 - 11:00
                $this->createJadwal($kelas, $dailyMapels[1], $dailyGurus[1], $day, '09:00', '11:00', 'R-' . $kelas->nama_kelas);

                // Istirahat 11:00 - 11:30

                // Sesi 3: 11:30 - 13:00
                $this->createJadwal($kelas, $dailyMapels[2], $dailyGurus[2], $day, '11:30', '13:00', 'R-' . $kelas->nama_kelas);

                // Sesi 4: 13:00 - 15:00
                $this->createJadwal($kelas, $dailyMapels[3], $dailyGurus[3], $day, '13:00', '15:00', 'R-' . $kelas->nama_kelas);
            }

            // Jadwal Jumat (07:00 - 15:00, Istirahat Panjang)
            $jumatMapels = $mapels->shuffle();
            $jumatGurus = $gurus->shuffle();

            // Sesi 1: 07:00 - 09:00
            $this->createJadwal($kelas, $jumatMapels[0], $jumatGurus[0], 'Jumat', '07:00', '09:00', 'R-' . $kelas->nama_kelas);

            // Sesi 2: 09:00 - 11:00
            $this->createJadwal($kelas, $jumatMapels[1], $jumatGurus[1], 'Jumat', '09:00', '11:00', 'R-' . $kelas->nama_kelas);

            // Istirahat Sholat Jumat 11:00 - 13:00

            // Sesi 3: 13:00 - 15:00
            $this->createJadwal($kelas, $jumatMapels[2], $jumatGurus[2], 'Jumat', '13:00', '15:00', 'R-' . $kelas->nama_kelas);
        }
    }

    private function createJadwal($kelas, $mapel, $guru, $hari, $mulai, $selesai, $ruangan)
    {
        Jadwal::create([
            'kelas_id' => $kelas->id,
            'mapel_id' => $mapel->id,
            'guru_id' => $guru->id,
            'hari' => $hari,
            'jam_mulai' => $mulai,
            'jam_selesai' => $selesai,
            'ruangan' => $ruangan,
        ]);
    }
}
