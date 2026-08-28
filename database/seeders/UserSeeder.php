<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Administrator',
            'username' => 'admin',
            'email' => 'admin@sman1tuhemberua.sch.id',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'status' => 'active',
        ]);

        User::create([
            'name' => 'Kepala Sekolah',
            'username' => 'kepsek',
            'email' => 'kepsek@sman1tuhemberua.sch.id',
            'password' => Hash::make('password'),
            'role' => 'kepala_sekolah',
            'status' => 'active',
        ]);

        User::create([
            'name' => 'Budi Santoso',
            'username' => 'budi',
            'email' => 'budi@sman1tuhemberua.sch.id',
            'password' => Hash::make('password'),
            'role' => 'guru',
            'status' => 'active',
        ]);

        User::create([
            'name' => 'Siti Rahma',
            'username' => 'siti',
            'email' => 'siti@sman1tuhemberua.sch.id',
            'password' => Hash::make('password'),
            'role' => 'guru',
            'status' => 'active',
        ]);

         User::create([
            'name' => 'Joko Susilo',
            'username' => 'joko',
            'email' => 'joko@sman1tuhemberua.sch.id',
            'password' => Hash::make('password'),
            'role' => 'guru',
            'status' => 'active',
        ]);

        User::create([
            'name' => 'Andi Pratama',
            'username' => 'andi',
            'email' => 'andi@siswa.sman1tuhemberua.sch.id',
            'password' => Hash::make('password'),
            'role' => 'siswa',
            'status' => 'active',
        ]);

        User::create([
            'name' => 'Siti Aminah',
            'username' => 'aminah',
            'email' => 'aminah@siswa.sman1tuhemberua.sch.id',
            'password' => Hash::make('password'),
            'role' => 'siswa',
            'status' => 'active',
        ]);

        for ($i = 1; $i <= 6; $i++) {
            User::create([
                'name' => 'Tendik ' . $i,
                'username' => 'tendik' . $i,
                'email' => 'tendik' . $i . '@sman1tuhemberua.sch.id',
                'password' => Hash::make('password'),
                'role' => 'tendik',
                'status' => 'active',
            ]);
        }
    }
}
