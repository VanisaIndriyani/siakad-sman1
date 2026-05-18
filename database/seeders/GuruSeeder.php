<?php

namespace Database\Seeders;

use App\Models\Guru;
use App\Models\User;
use Illuminate\Database\Seeder;

class GuruSeeder extends Seeder
{
    public function run(): void
    {
        // Existing specific gurus
        $budi = User::where('username', 'budi')->first();
        if ($budi && !Guru::where('user_id', $budi->id)->exists()) {
            Guru::create([
                'user_id' => $budi->id,
                'nip' => '198501012010011001',
                'nama_lengkap' => 'Budi Santoso',
                'gelar_depan' => 'Drs.',
                'gelar_belakang' => 'M.Pd.',
                'no_hp' => '081234567890',
                'alamat' => 'Jl. Pendidikan No. 1',
                'is_active' => true,
            ]);
        }

        $siti = User::where('username', 'siti')->first();
        if ($siti && !Guru::where('user_id', $siti->id)->exists()) {
            Guru::create([
                'user_id' => $siti->id,
                'nip' => '199002022015022002',
                'nama_lengkap' => 'Siti Rahma',
                'gelar_depan' => null,
                'gelar_belakang' => 'S.Pd.',
                'no_hp' => '081234567891',
                'alamat' => 'Jl. Merdeka No. 5',
                'is_active' => true,
            ]);
        }

        $joko = User::where('username', 'joko')->first();
        if ($joko && !Guru::where('user_id', $joko->id)->exists()) {
            Guru::create([
                'user_id' => $joko->id,
                'nip' => '198803032012031003',
                'nama_lengkap' => 'Joko Susilo',
                'gelar_depan' => null,
                'gelar_belakang' => 'S.Si.',
                'no_hp' => '081234567892',
                'alamat' => 'Jl. Pahlawan No. 10',
                'is_active' => true,
            ]);
        }

        // Generate 44 more gurus to reach 47
        $faker = \Faker\Factory::create('id_ID');
        
        for ($i = 0; $i < 44; $i++) {
            $name = $faker->name;
            $username = 'guru' . ($i + 4);
            $email = $username . '@sman1tuhemberua.sch.id';
            
            $user = User::create([
                'name' => $name,
                'username' => $username,
                'email' => $email,
                'password' => \Illuminate\Support\Facades\Hash::make('password'),
                'role' => 'guru',
            ]);

            Guru::create([
                'user_id' => $user->id,
                'nip' => $faker->unique()->numerify('19##########00##'),
                'nama_lengkap' => $name,
                'gelar_depan' => $faker->randomElement(['Drs.', 'Dra.', null]),
                'gelar_belakang' => $faker->randomElement(['S.Pd.', 'M.Pd.', 'S.Si.', 'S.Kom.']),
                'no_hp' => $faker->phoneNumber,
                'alamat' => $faker->address,
                'is_active' => true,
            ]);
        }
    }
}
