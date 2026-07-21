<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    public function show()
    {
        $user = Auth::user();
        $config = $this->roleConfig($user->role);

        if (! $config) {
            abort(403);
        }

        $relatedProfile = $this->relatedProfile($user);
        if ($relatedProfile instanceof \Illuminate\Http\RedirectResponse) {
            return $relatedProfile;
        }

        return view('profile.index', [
            'user' => $user,
            'config' => $config,
            'relatedProfile' => $relatedProfile,
        ]);
    }

    public function update(Request $request)
    {
        $user = Auth::user();
        $config = $this->roleConfig($user->role);

        if (! $config) {
            abort(403);
        }

        $relatedProfile = $this->relatedProfile($user);
        if ($relatedProfile instanceof \Illuminate\Http\RedirectResponse) {
            return $relatedProfile;
        }

        $validated = $request->validate($this->validationRules($user));

        DB::transaction(function () use ($user, $validated, $request, $relatedProfile) {
            $userData = [
                'name' => $validated['name'],
                'email' => $validated['email'],
            ];

            if (array_key_exists('username', $validated)) {
                $userData['username'] = $validated['username'];
            }

            if ($request->filled('password')) {
                $userData['password'] = Hash::make($request->password);
            }

            $user->update($userData);

            if ($user->role === 'guru' && $relatedProfile) {
                $relatedProfile->update([
                    'nama_lengkap' => $validated['name'],
                    'gelar_depan' => $validated['gelar_depan'] ?? null,
                    'gelar_belakang' => $validated['gelar_belakang'] ?? null,
                    'no_hp' => $validated['no_hp'] ?? null,
                    'alamat' => $validated['alamat'] ?? null,
                ]);
            }

            if ($user->role === 'siswa' && $relatedProfile) {
                $relatedProfile->update([
                    'nama_lengkap' => $validated['name'],
                    'tempat_lahir' => $validated['tempat_lahir'] ?? null,
                    'tanggal_lahir' => $validated['tanggal_lahir'] ?? null,
                    'alamat' => $validated['alamat'] ?? null,
                    'nama_ayah' => $validated['nama_ayah'] ?? null,
                    'nama_ibu' => $validated['nama_ibu'] ?? null,
                    'no_hp_ortu' => $validated['no_hp_ortu'] ?? null,
                ]);
            }
        });

        return redirect()->back()->with('success', 'Profil berhasil diperbarui.');
    }

    private function validationRules($user): array
    {
        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', Rule::unique('users', 'email')->ignore($user->id)],
            'password' => ['nullable', 'string', 'min:6', 'confirmed'],
        ];

        if (in_array($user->role, ['admin', 'kepala_sekolah'], true)) {
            $rules['username'] = ['required', 'string', 'max:255', Rule::unique('users', 'username')->ignore($user->id)];
        }

        if ($user->role === 'guru') {
            $rules['gelar_depan'] = ['nullable', 'string', 'max:50'];
            $rules['gelar_belakang'] = ['nullable', 'string', 'max:50'];
            $rules['no_hp'] = ['nullable', 'string', 'max:30'];
            $rules['alamat'] = ['nullable', 'string', 'max:255'];
        }

        if ($user->role === 'siswa') {
            $rules['tempat_lahir'] = ['nullable', 'string', 'max:100'];
            $rules['tanggal_lahir'] = ['nullable', 'date'];
            $rules['alamat'] = ['nullable', 'string', 'max:255'];
            $rules['nama_ayah'] = ['nullable', 'string', 'max:255'];
            $rules['nama_ibu'] = ['nullable', 'string', 'max:255'];
            $rules['no_hp_ortu'] = ['nullable', 'string', 'max:30'];
        }

        return $rules;
    }

    private function roleConfig(string $role): ?array
    {
        return match ($role) {
            'admin' => [
                'layout' => 'layouts.admin',
                'title' => 'Konfigurasi Akun',
                'header' => 'Konfigurasi Akun',
                'heading' => 'Profil Admin',
                'description' => 'Kelola informasi akun admin dan keamanan login.',
                'updateRoute' => 'admin.profile.update',
                'indexRoute' => 'admin.profile.index',
                'icon' => 'fas fa-user-cog',
                'theme' => [
                    'icon' => 'from-blue-500 to-indigo-600',
                    'button' => 'from-blue-600 to-indigo-600',
                    'focus' => 'focus:border-blue-500 focus:ring-blue-500',
                    'soft' => 'bg-blue-50 text-blue-700 border-blue-100',
                    'label' => 'Admin',
                ],
            ],
            'guru' => [
                'layout' => 'layouts.guru',
                'title' => 'Profil Saya',
                'header' => 'Profil Saya',
                'heading' => 'Profil Guru',
                'description' => 'Perbarui data diri guru dan password akun Anda.',
                'updateRoute' => 'guru.profile.update',
                'indexRoute' => 'guru.profile.index',
                'icon' => 'fas fa-id-badge',
                'theme' => [
                    'icon' => 'from-green-500 to-emerald-600',
                    'button' => 'from-green-600 to-emerald-600',
                    'focus' => 'focus:border-green-500 focus:ring-green-500',
                    'soft' => 'bg-green-50 text-green-700 border-green-100',
                    'label' => 'Guru',
                ],
            ],
            'siswa' => [
                'layout' => 'layouts.siswa',
                'title' => 'Profil Saya',
                'header' => 'Profil Saya',
                'heading' => 'Profil Siswa',
                'description' => 'Kelola data akun siswa, biodata singkat, dan password login.',
                'updateRoute' => 'siswa.profile.update',
                'indexRoute' => 'siswa.profil',
                'icon' => 'fas fa-user-graduate',
                'theme' => [
                    'icon' => 'from-yellow-500 to-amber-600',
                    'button' => 'from-yellow-500 to-amber-600',
                    'focus' => 'focus:border-yellow-500 focus:ring-yellow-500',
                    'soft' => 'bg-yellow-50 text-yellow-700 border-yellow-100',
                    'label' => 'Siswa',
                ],
            ],
            'kepala_sekolah' => [
                'layout' => 'layouts.kepala_sekolah',
                'title' => 'Profil Saya',
                'header' => 'Profil Saya',
                'heading' => 'Profil Kepala Sekolah',
                'description' => 'Perbarui identitas akun dan keamanan login kepala sekolah.',
                'updateRoute' => 'kepala_sekolah.profile.update',
                'indexRoute' => 'kepala_sekolah.profile.index',
                'icon' => 'fas fa-user-tie',
                'theme' => [
                    'icon' => 'from-indigo-500 to-purple-600',
                    'button' => 'from-indigo-600 to-purple-600',
                    'focus' => 'focus:border-indigo-500 focus:ring-indigo-500',
                    'soft' => 'bg-indigo-50 text-indigo-700 border-indigo-100',
                    'label' => 'Kepala Sekolah',
                ],
            ],
            default => null,
        };
    }

    private function relatedProfile($user)
    {
        if ($user->role === 'guru') {
            if (! $user->guru) {
                return redirect()->route('guru.dashboard')->withErrors(['msg' => 'Data guru tidak ditemukan.']);
            }

            return $user->guru;
        }

        if ($user->role === 'siswa') {
            if (! $user->siswa) {
                return redirect()->route('siswa.dashboard')->withErrors(['msg' => 'Data siswa tidak ditemukan.']);
            }

            return $user->siswa;
        }

        return null;
    }
}
