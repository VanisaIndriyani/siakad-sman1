@extends($config['layout'])

@section('title', $config['title'])
@section('header', $config['header'])

@php
    $theme = $config['theme'];
    $inputClass = 'w-full rounded-xl border-gray-200 px-4 py-3 shadow-sm transition-colors '.$theme['focus'];
    $readonlyClass = 'w-full rounded-xl border-gray-200 bg-gray-50 px-4 py-3 text-gray-500';
@endphp

@section('content')
<div class="max-w-6xl mx-auto space-y-6">
    <div class="bg-white rounded-3xl shadow-xl border border-gray-100 overflow-hidden">
        <div class="p-8 md:p-10 border-b border-gray-100">
            <div class="flex flex-col gap-6 md:flex-row md:items-center md:justify-between">
                <div class="flex items-center gap-5">
                    <div class="w-20 h-20 rounded-3xl bg-gradient-to-br {{ $theme['icon'] }} flex items-center justify-center shadow-lg">
                        <i class="{{ $config['icon'] }} text-3xl text-white"></i>
                    </div>
                    <div>
                        <div class="inline-flex items-center rounded-full border px-3 py-1 text-xs font-semibold {{ $theme['soft'] }}">
                            {{ $theme['label'] }}
                        </div>
                        <h2 class="text-2xl md:text-3xl font-bold text-slate-800 mt-3">{{ $config['heading'] }}</h2>
                        <p class="text-sm text-slate-500 mt-1">{{ $config['description'] }}</p>
                    </div>
                </div>
                <div class="rounded-2xl bg-slate-50 border border-slate-100 px-5 py-4">
                    <p class="text-xs font-semibold uppercase tracking-widest text-slate-400">Login Aktif</p>
                    <p class="text-lg font-bold text-slate-800 mt-1">{{ $user->name }}</p>
                    <p class="text-sm text-slate-500">{{ $user->email }}</p>
                </div>
            </div>
        </div>

        <form action="{{ route($config['updateRoute']) }}" method="POST" class="p-8 md:p-10">
            @csrf
            @method('PUT')

            <div class="grid gap-8 xl:grid-cols-[1.2fr_0.8fr]">
                <div class="space-y-8">
                    <div>
                        <h3 class="text-lg font-semibold text-slate-800">Informasi Profil</h3>
                        <p class="text-sm text-slate-500 mt-1">Perbarui data utama yang tampil pada akun Anda.</p>
                    </div>

                    <div class="grid gap-5 md:grid-cols-2">
                        <div class="md:col-span-2">
                            <label for="name" class="block text-sm font-medium text-slate-700 mb-2">Nama Lengkap</label>
                            <input type="text" id="name" name="name" value="{{ old('name', $relatedProfile->nama_lengkap ?? $user->name) }}" class="{{ $inputClass }}" required>
                        </div>

                        <div class="md:col-span-2">
                            <label for="email" class="block text-sm font-medium text-slate-700 mb-2">Email</label>
                            <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}" class="{{ $inputClass }}" required>
                        </div>

                        @if(in_array($user->role, ['admin', 'kepala_sekolah']))
                            <div class="md:col-span-2">
                                <label for="username" class="block text-sm font-medium text-slate-700 mb-2">Username</label>
                                <input type="text" id="username" name="username" value="{{ old('username', $user->username) }}" class="{{ $inputClass }}" required>
                                <p class="text-xs text-slate-400 mt-2">Username ini bisa dipakai saat login.</p>
                            </div>
                        @endif

                        @if($user->role === 'guru')
                            <div>
                                <label class="block text-sm font-medium text-slate-700 mb-2">NIP</label>
                                <input type="text" value="{{ $relatedProfile->nip }}" class="{{ $readonlyClass }}" disabled>
                            </div>
                            <div>
                                <label for="no_hp" class="block text-sm font-medium text-slate-700 mb-2">No. HP</label>
                                <input type="text" id="no_hp" name="no_hp" value="{{ old('no_hp', $relatedProfile->no_hp) }}" class="{{ $inputClass }}">
                            </div>
                            <div>
                                <label for="gelar_depan" class="block text-sm font-medium text-slate-700 mb-2">Gelar Depan</label>
                                <input type="text" id="gelar_depan" name="gelar_depan" value="{{ old('gelar_depan', $relatedProfile->gelar_depan) }}" class="{{ $inputClass }}">
                            </div>
                            <div>
                                <label for="gelar_belakang" class="block text-sm font-medium text-slate-700 mb-2">Gelar Belakang</label>
                                <input type="text" id="gelar_belakang" name="gelar_belakang" value="{{ old('gelar_belakang', $relatedProfile->gelar_belakang) }}" class="{{ $inputClass }}">
                            </div>
                            <div class="md:col-span-2">
                                <label for="alamat" class="block text-sm font-medium text-slate-700 mb-2">Alamat</label>
                                <textarea id="alamat" name="alamat" rows="4" class="{{ $inputClass }}">{{ old('alamat', $relatedProfile->alamat) }}</textarea>
                            </div>
                        @endif

                        @if($user->role === 'siswa')
                            <div>
                                <label class="block text-sm font-medium text-slate-700 mb-2">NISN</label>
                                <input type="text" value="{{ $relatedProfile->nisn }}" class="{{ $readonlyClass }}" disabled>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-slate-700 mb-2">NIS</label>
                                <input type="text" value="{{ $relatedProfile->nis ?: '-' }}" class="{{ $readonlyClass }}" disabled>
                            </div>
                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium text-slate-700 mb-2">Kelas</label>
                                <input type="text" value="{{ $relatedProfile->kelas->nama_kelas ?? '-' }}" class="{{ $readonlyClass }}" disabled>
                            </div>
                            <div>
                                <label for="tempat_lahir" class="block text-sm font-medium text-slate-700 mb-2">Tempat Lahir</label>
                                <input type="text" id="tempat_lahir" name="tempat_lahir" value="{{ old('tempat_lahir', $relatedProfile->tempat_lahir) }}" class="{{ $inputClass }}">
                            </div>
                            <div>
                                <label for="tanggal_lahir" class="block text-sm font-medium text-slate-700 mb-2">Tanggal Lahir</label>
                                <input type="date" id="tanggal_lahir" name="tanggal_lahir" value="{{ old('tanggal_lahir', $relatedProfile->tanggal_lahir) }}" class="{{ $inputClass }}">
                            </div>
                            <div>
                                <label for="nama_ayah" class="block text-sm font-medium text-slate-700 mb-2">Nama Ayah</label>
                                <input type="text" id="nama_ayah" name="nama_ayah" value="{{ old('nama_ayah', $relatedProfile->nama_ayah) }}" class="{{ $inputClass }}">
                            </div>
                            <div>
                                <label for="nama_ibu" class="block text-sm font-medium text-slate-700 mb-2">Nama Ibu</label>
                                <input type="text" id="nama_ibu" name="nama_ibu" value="{{ old('nama_ibu', $relatedProfile->nama_ibu) }}" class="{{ $inputClass }}">
                            </div>
                            <div>
                                <label for="no_hp_ortu" class="block text-sm font-medium text-slate-700 mb-2">No. HP Orang Tua</label>
                                <input type="text" id="no_hp_ortu" name="no_hp_ortu" value="{{ old('no_hp_ortu', $relatedProfile->no_hp_ortu) }}" class="{{ $inputClass }}">
                            </div>
                            <div class="md:col-span-2">
                                <label for="alamat" class="block text-sm font-medium text-slate-700 mb-2">Alamat</label>
                                <textarea id="alamat" name="alamat" rows="4" class="{{ $inputClass }}">{{ old('alamat', $relatedProfile->alamat) }}</textarea>
                            </div>
                        @endif
                    </div>
                </div>

                <div class="space-y-6">
                    <div class="rounded-3xl border border-gray-100 bg-slate-50 p-6">
                        <h3 class="text-lg font-semibold text-slate-800">Keamanan Akun</h3>
                        <p class="text-sm text-slate-500 mt-1">Kosongkan password jika tidak ingin mengubahnya.</p>

                        <div class="space-y-5 mt-6">
                            <div>
                                <label for="password" class="block text-sm font-medium text-slate-700 mb-2">Password Baru</label>
                                <div class="relative">
                                    <input type="password" id="password" name="password" class="{{ $inputClass }} pr-12 password-toggle-input" placeholder="Minimal 6 karakter">
                                    <button type="button" class="absolute inset-y-0 right-0 px-4 text-slate-400 hover:text-slate-600 transition-colors password-toggle-button" data-target="password" aria-label="Lihat password baru">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </div>
                            </div>
                            <div>
                                <label for="password_confirmation" class="block text-sm font-medium text-slate-700 mb-2">Konfirmasi Password</label>
                                <div class="relative">
                                    <input type="password" id="password_confirmation" name="password_confirmation" class="{{ $inputClass }} pr-12 password-toggle-input" placeholder="Ulangi password baru">
                                    <button type="button" class="absolute inset-y-0 right-0 px-4 text-slate-400 hover:text-slate-600 transition-colors password-toggle-button" data-target="password_confirmation" aria-label="Lihat konfirmasi password">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="rounded-3xl border border-gray-100 bg-white p-6">
                        <h3 class="text-lg font-semibold text-slate-800">Ringkasan Akun</h3>
                        <div class="space-y-4 mt-5">
                            <div>
                                <p class="text-xs font-semibold uppercase tracking-widest text-slate-400">Role</p>
                                <p class="text-sm font-semibold text-slate-700 mt-1">{{ $theme['label'] }}</p>
                            </div>
                            <div>
                                <p class="text-xs font-semibold uppercase tracking-widest text-slate-400">ID Login</p>
                                <p class="text-sm font-semibold text-slate-700 mt-1">
                                    @if($user->role === 'guru')
                                        {{ $relatedProfile->nip }}
                                    @elseif($user->role === 'siswa')
                                        {{ $relatedProfile->nisn }}
                                    @else
                                        {{ $user->username ?: '-' }}
                                    @endif
                                </p>
                            </div>
                            <div>
                                <p class="text-xs font-semibold uppercase tracking-widest text-slate-400">Email</p>
                                <p class="text-sm font-semibold text-slate-700 mt-1 break-all">{{ $user->email }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-10 flex flex-col-reverse gap-3 border-t border-gray-100 pt-6 sm:flex-row sm:justify-end">
                <button type="button" onclick="window.history.back()" class="px-6 py-3 rounded-xl border border-gray-200 text-gray-600 font-medium hover:bg-gray-50 transition-colors">
                    Batal
                </button>
                <button type="submit" class="px-6 py-3 rounded-xl bg-gradient-to-r {{ $theme['button'] }} text-white font-semibold shadow-lg transition-all">
                    <i class="fas fa-save mr-2"></i> Simpan Perubahan
                </button>
            </div>
        </form>
    </div>

    @if($user->role === 'siswa')
        <div class="bg-white rounded-3xl shadow-xl border border-gray-100 overflow-hidden">
            <div class="p-6 md:p-8 border-b border-gray-100 flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
                <div>
                    <h3 class="text-xl font-bold text-slate-800">Kartu Siswa</h3>
                    <p class="text-sm text-slate-500 mt-1">Tetap tersedia untuk dilihat dan diunduh dari halaman profil.</p>
                </div>
                <div class="flex flex-col gap-3 sm:flex-row">
                    <a href="{{ route('siswa.qr.png', ['download' => 1]) }}" class="inline-flex items-center justify-center rounded-xl bg-yellow-500 px-4 py-3 text-sm font-semibold text-white hover:bg-yellow-600 transition-colors">
                        <i class="fas fa-download mr-2"></i> Download PNG
                    </a>
                    <a href="{{ route('siswa.qr.pdf', ['download' => 1]) }}" class="inline-flex items-center justify-center rounded-xl bg-blue-600 px-4 py-3 text-sm font-semibold text-white hover:bg-blue-700 transition-colors">
                        <i class="fas fa-file-pdf mr-2"></i> Download PDF
                    </a>
                </div>
            </div>
            <div class="p-6 md:p-8">
                <div class="mx-auto max-w-md rounded-[28px] border border-blue-100 bg-white shadow-lg overflow-hidden">
                    <div class="bg-blue-900 px-6 py-5 text-white flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <div class="w-11 h-11 rounded-2xl bg-white/15 flex items-center justify-center">
                                <i class="fas fa-graduation-cap"></i>
                            </div>
                            <div>
                                <p class="text-sm font-bold uppercase tracking-wide">SMA Negeri 1</p>
                                <p class="text-[11px] text-blue-200 tracking-widest">KARTU TANDA PELAJAR</p>
                            </div>
                        </div>
                        <span class="rounded-full bg-yellow-400 px-3 py-1 text-[10px] font-bold uppercase tracking-wider text-blue-900">Aktif</span>
                    </div>
                    <div class="p-6 space-y-5">
                        <div>
                            <p class="text-[11px] font-semibold uppercase tracking-widest text-slate-400">Nama Lengkap</p>
                            <h4 class="text-xl font-bold text-slate-800 mt-1">{{ $relatedProfile->nama_lengkap }}</h4>
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <p class="text-[11px] font-semibold uppercase tracking-widest text-slate-400">NISN</p>
                                <p class="text-sm font-bold text-slate-700 mt-1">{{ $relatedProfile->nisn }}</p>
                            </div>
                            <div>
                                <p class="text-[11px] font-semibold uppercase tracking-widest text-slate-400">Kelas</p>
                                <p class="text-sm font-bold text-slate-700 mt-1">{{ $relatedProfile->kelas->nama_kelas ?? '-' }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="border-t border-slate-100 bg-slate-50 px-6 py-4 flex items-center justify-between">
                        <div class="text-[11px] text-slate-400">
                            Berlaku selama menjadi siswa aktif.
                        </div>
                        <img src="{{ route('siswa.qr.png') }}" width="84" height="84" class="bg-white rounded-lg p-1 border border-slate-200" alt="QR Code Siswa">
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('.password-toggle-button').forEach(function (button) {
            button.addEventListener('click', function () {
                const targetId = button.getAttribute('data-target');
                const input = document.getElementById(targetId);
                const icon = button.querySelector('i');

                if (!input || !icon) {
                    return;
                }

                const isPassword = input.type === 'password';
                input.type = isPassword ? 'text' : 'password';
                icon.classList.toggle('fa-eye', !isPassword);
                icon.classList.toggle('fa-eye-slash', isPassword);
            });
        });
    });
</script>
@endpush
