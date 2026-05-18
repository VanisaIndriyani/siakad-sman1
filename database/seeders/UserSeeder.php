<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Admin
        User::create([
            'name' => 'Administrator',
            'username' => 'admin',
            'email' => 'admin@sman1tuhemberua.sch.id',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        // Kepala Sekolah
        User::create([
            'name' => 'Kepala Sekolah',
            'username' => 'kepsek',
            'email' => 'kepsek@sman1tuhemberua.sch.id',
            'password' => Hash::make('password'),
            'role' => 'kepala_sekolah',
        ]);

        // Guru 1 (Budi Santoso)
        User::create([
            'name' => 'Budi Santoso',
            'username' => 'budi',
            'email' => 'budi@sman1tuhemberua.sch.id',
            'password' => Hash::make('password'),
            'role' => 'guru',
        ]);

        // Guru 2 (Siti Rahma)
        User::create([
            'name' => 'Siti Rahma',
            'username' => 'siti',
            'email' => 'siti@sman1tuhemberua.sch.id',
            'password' => Hash::make('password'),
            'role' => 'guru',
        ]);

         // Guru 3 (Joko Susilo)
         User::create([
            'name' => 'Joko Susilo',
            'username' => 'joko',
            'email' => 'joko@sman1tuhemberua.sch.id',
            'password' => Hash::make('password'),
            'role' => 'guru',
        ]);

        // Siswa 1 (Andi Pratama)
        User::create([
            'name' => 'Andi Pratama',
            'username' => 'andi',
            'email' => 'andi@siswa.sman1tuhemberua.sch.id',
            'password' => Hash::make('password'),
            'role' => 'siswa',
        ]);

        // Siswa 2 (Siti Aminah)
        User::create([
            'name' => 'Siti Aminah',
            'username' => 'aminah',
            'email' => 'aminah@siswa.sman1tuhemberua.sch.id',
            'password' => Hash::make('password'),
            'role' => 'siswa',
        ]);

        // Tenaga Kependidikan (6 Orang)
        for ($i = 1; $i <= 6; $i++) {
            User::create([
                'name' => 'Tendik ' . $i,
                'username' => 'tendik' . $i,
                'email' => 'tendik' . $i . '@sman1tuhemberua.sch.id',
                'password' => Hash::make('password'),
                'role' => 'tendik',
            ]);
        }
    }
}
