<?php

namespace Database\Seeders;

use App\Models\Kelas;
use App\Models\Siswa;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Faker\Factory as Faker;

class SiswaSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create('id_ID');
        $kelasIds = Kelas::pluck('id')->toArray();

        // 1. Handle Existing Siswa from UserSeeder (Andi & Aminah)
        $andi = User::where('username', 'andi')->first();
        if ($andi && !Siswa::where('user_id', $andi->id)->exists()) {
            Siswa::create([
                'user_id' => $andi->id,
                'kelas_id' => !empty($kelasIds) ? $faker->randomElement($kelasIds) : null,
                'nisn' => '0051234567',
                'nis' => '1001',
                'nama_lengkap' => 'Andi Pratama',
                'jenis_kelamin' => 'L',
                'tempat_lahir' => 'Tuhemberua',
                'tanggal_lahir' => '2008-05-10',
                'alamat' => 'Desa A',
                'nama_ayah' => 'Budi',
                'nama_ibu' => 'Ani',
            ]);
        }

        $aminah = User::where('username', 'aminah')->first();
        if ($aminah && !Siswa::where('user_id', $aminah->id)->exists()) {
            Siswa::create([
                'user_id' => $aminah->id,
                'kelas_id' => !empty($kelasIds) ? $faker->randomElement($kelasIds) : null,
                'nisn' => '0057654321',
                'nis' => '1002',
                'nama_lengkap' => 'Siti Aminah',
                'jenis_kelamin' => 'P',
                'tempat_lahir' => 'Gunungsitoli',
                'tanggal_lahir' => '2008-08-17',
                'alamat' => 'Desa B',
                'nama_ayah' => 'Joko',
                'nama_ibu' => 'Susi',
            ]);
        }

        // 2. Generate Remaining Siswa to reach 563 total
        // Target: 285 Laki-laki, 278 Perempuan
        // Existing: 1 L (Andi), 1 P (Aminah)
        // Need: 284 L, 277 P

        $targetL = 285;
        $targetP = 278;

        // Count existing (in case seeder runs partially or on existing DB)
        $currentL = Siswa::where('jenis_kelamin', 'L')->count();
        $currentP = Siswa::where('jenis_kelamin', 'P')->count();

        $neededL = max(0, $targetL - $currentL);
        $neededP = max(0, $targetP - $currentP);

        // Generate Laki-laki
        for ($i = 0; $i < $neededL; $i++) {
            $this->createSiswa($faker, 'L', $kelasIds);
        }

        // Generate Perempuan
        for ($i = 0; $i < $neededP; $i++) {
            $this->createSiswa($faker, 'P', $kelasIds);
        }
    }

    private function createSiswa($faker, $gender, $kelasIds)
    {
        $firstName = $gender == 'L' ? $faker->firstNameMale : $faker->firstNameFemale;
        $name = $firstName . ' ' . $faker->lastName;
        $username = strtolower(str_replace(' ', '', $name)) . rand(100, 999);
        $email = $username . '@siswa.sman1tuhemberua.sch.id';

        // Check for unique email/username
        while (User::where('username', $username)->exists()) {
            $username .= rand(1, 9);
            $email = $username . '@siswa.sman1tuhemberua.sch.id';
        }

        $user = User::create([
            'name' => $name,
            'username' => $username,
            'email' => $email,
            'password' => Hash::make('password'),
            'role' => 'siswa',
        ]);

        Siswa::create([
            'user_id' => $user->id,
            'kelas_id' => !empty($kelasIds) ? $faker->randomElement($kelasIds) : null,
            'nisn' => $faker->unique()->numerify('00########'),
            'nis' => $faker->unique()->numerify('####'),
            'nama_lengkap' => $name,
            'jenis_kelamin' => $gender,
            'tempat_lahir' => $faker->city,
            'tanggal_lahir' => $faker->date('Y-m-d', '2010-01-01'),
            'alamat' => $faker->address,
            'nama_ayah' => $faker->name('male'),
            'nama_ibu' => $faker->name('female'),
        ]);
    }
}
