<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrasi - SIAKAD SMA Negeri 1 Tuhemberua</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        .blob {
            position: absolute;
            filter: blur(80px);
            z-index: 0;
            opacity: 0.6;
        }
        .glass-card {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.5);
        }
        .role-card {
            transition: all 0.3s ease;
            cursor: pointer;
        }
        .role-card.selected {
            border-color: #2563eb;
            background: rgba(37, 99, 235, 0.08);
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.15);
        }
        .conditional-field { display: none; }
        .conditional-field.visible { display: block; }
    </style>
</head>
<body class="min-h-screen flex flex-col md:flex-row items-center justify-center relative overflow-y-auto bg-slate-900 py-8 md:py-10">

    <div class="fixed inset-0 z-0">
        <img src="https://images.unsplash.com/photo-1523050854058-8df90110c9f1?ixlib=rb-1.2.1&auto=format&fit=crop&w=1950&q=80" alt="School Background" class="w-full h-full object-cover opacity-20 mix-blend-overlay">
        <div class="absolute inset-0 bg-gradient-to-b from-slate-900/90 via-slate-900/80 to-slate-900"></div>
    </div>

    <div class="fixed blob bg-emerald-600 w-96 h-96 rounded-full top-0 left-0 -translate-x-1/2 -translate-y-1/2 animate-pulse pointer-events-none"></div>
    <div class="fixed blob bg-blue-600 w-96 h-96 rounded-full bottom-0 right-0 translate-x-1/2 translate-y-1/2 animate-pulse pointer-events-none" style="animation-delay: 2s;"></div>

    <div class="w-full max-w-lg px-4 md:px-6 relative z-10">
        <div class="w-full max-w-md px-6 mb-6 z-20 mx-auto">
            <a href="{{ url('/') }}" class="inline-flex items-center gap-2 text-slate-300 hover:text-white transition-all hover:-translate-x-1 group">
                <div class="w-10 h-10 rounded-full bg-white/5 backdrop-blur-sm flex items-center justify-center border border-white/10 group-hover:bg-white/10 transition-colors">
                    <i class="fas fa-arrow-left text-sm"></i>
                </div>
                <span class="text-sm font-semibold">Kembali ke Beranda</span>
            </a>
        </div>

        <div class="glass-card rounded-[2rem] shadow-2xl overflow-hidden transition-all duration-300 transform hover:scale-[1.005] hover:shadow-emerald-500/10">
            <div class="p-6 md:p-8">
                <div class="text-center mb-6 md:mb-8">
                    <div class="inline-flex items-center justify-center w-14 h-14 md:w-16 md:h-16 rounded-2xl bg-gradient-to-tr from-emerald-600 to-blue-600 text-white mb-3 md:mb-4 shadow-lg shadow-emerald-500/30">
                        <i class="fas fa-user-plus text-xl md:text-2xl"></i>
                    </div>
                    <h1 class="text-xl md:text-2xl font-bold text-slate-800 tracking-tight">Daftar Akun</h1>
                    <p class="text-slate-500 text-xs md:text-sm mt-2 font-medium">Isi data di bawah ini. Akun Anda akan diverifikasi Admin sebelum dapat digunakan.</p>
                </div>

                @if ($errors->any())
                    <div class="bg-red-50 border-l-4 border-red-500 text-red-700 p-4 rounded-lg mb-6 shadow-sm">
                        <div class="flex">
                            <div class="py-1"><i class="fas fa-exclamation-circle mr-3"></i></div>
                            <div>
                                <p class="font-bold text-sm">Registrasi Gagal</p>
                                <ul class="mt-1 list-disc list-inside text-xs space-y-1">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                @endif

                <form action="{{ route('register.post') }}" method="POST" class="space-y-4 md:space-y-5">
                    @csrf

                    <div class="mb-1">
                        <label class="block text-sm font-bold text-slate-700 mb-2">Daftar Sebagai <span class="text-red-500">*</span></label>
                        <div class="grid grid-cols-3 gap-2 md:gap-3">
                            <label class="role-card selected block border-2 border-slate-200 rounded-xl p-2 md:p-3 text-center bg-slate-50/50 hover:border-emerald-400" data-role="guru">
                                <input type="radio" name="role" value="guru" class="hidden" checked>
                                <i class="fas fa-chalkboard-teacher text-lg md:text-xl text-emerald-600 mb-1"></i>
                                <p class="text-[10px] md:text-sm font-bold text-slate-700">Guru</p>
                            </label>
                            <label class="role-card block border-2 border-slate-200 rounded-xl p-2 md:p-3 text-center bg-slate-50/50 hover:border-blue-400" data-role="siswa">
                                <input type="radio" name="role" value="siswa" class="hidden">
                                <i class="fas fa-user-graduate text-lg md:text-xl text-blue-600 mb-1"></i>
                                <p class="text-[10px] md:text-sm font-bold text-slate-700">Siswa</p>
                            </label>
                            <label class="role-card block border-2 border-slate-200 rounded-xl p-2 md:p-3 text-center bg-slate-50/50 hover:border-indigo-400" data-role="kepala_sekolah">
                                <input type="radio" name="role" value="kepala_sekolah" class="hidden">
                                <i class="fas fa-user-tie text-lg md:text-xl text-indigo-600 mb-1"></i>
                                <p class="text-[10px] md:text-sm font-bold text-slate-700">Kepsek</p>
                            </label>
                        </div>
                    </div>

                    <div>
                        <label for="name" class="block text-sm font-bold text-slate-700 mb-2">Nama Lengkap <span class="text-red-500">*</span></label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <i class="fas fa-id-card text-slate-400"></i>
                            </div>
                            <input type="text" id="name" name="name" value="{{ old('name') }}" class="w-full pl-11 pr-4 py-2.5 md:py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 transition-all outline-none text-slate-800 font-medium placeholder:text-slate-400 text-sm" placeholder="Nama Lengkap" required>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="username" class="block text-sm font-bold text-slate-700 mb-2">Username <span class="text-red-500">*</span></label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <i class="fas fa-at text-slate-400"></i>
                                </div>
                                <input type="text" id="username" name="username" value="{{ old('username') }}" class="w-full pl-11 pr-4 py-2.5 md:py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 transition-all outline-none text-slate-800 font-medium placeholder:text-slate-400 text-sm" placeholder="username" required>
                            </div>
                        </div>

                        <div>
                            <label for="email" class="block text-sm font-bold text-slate-700 mb-2">Email <span class="text-slate-400 text-[10px] font-medium">(Opsional)</span></label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <i class="fas fa-envelope text-slate-400"></i>
                                </div>
                                <input type="email" id="email" name="email" value="{{ old('email') }}" class="w-full pl-11 pr-4 py-2.5 md:py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 transition-all outline-none text-slate-800 font-medium placeholder:text-slate-400 text-sm" placeholder="email@contoh.com">
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="password" class="block text-sm font-bold text-slate-700 mb-2">Password <span class="text-red-500">*</span></label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <i class="fas fa-lock text-slate-400"></i>
                                </div>
                                <input type="password" id="password" name="password" class="w-full pl-11 pr-4 py-2.5 md:py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 transition-all outline-none text-slate-800 font-medium placeholder:text-slate-400 text-sm" placeholder="Min. 6 karakter" required>
                            </div>
                        </div>

                        <div>
                            <label for="password_confirmation" class="block text-sm font-bold text-slate-700 mb-2">Konfirmasi Password <span class="text-red-500">*</span></label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <i class="fas fa-lock text-slate-400"></i>
                                </div>
                                <input type="password" id="password_confirmation" name="password_confirmation" class="w-full pl-11 pr-4 py-2.5 md:py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 transition-all outline-none text-slate-800 font-medium placeholder:text-slate-400 text-sm" placeholder="Ulangi password" required>
                            </div>
                        </div>
                    </div>

                    <div id="field-kelas" class="conditional-field {{ old('role', 'guru') === 'siswa' ? 'visible' : '' }}">
                        <label for="kelas_id" class="block text-sm font-bold text-slate-700 mb-2">Kelas <span class="text-red-500">*</span></label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <i class="fas fa-door-open text-slate-400"></i>
                            </div>
                            <select id="kelas_id" name="kelas_id" class="w-full pl-11 pr-4 py-2.5 md:py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 transition-all outline-none text-slate-800 font-medium text-sm">
                                <option value="">-- Pilih Kelas --</option>
                                @foreach($kelas as $k)
                                    <option value="{{ $k->id }}" {{ old('kelas_id') == $k->id ? 'selected' : '' }}>{{ $k->nama_kelas }}</option>
                                @endforeach
                            </select>
                        </div>
                        @if($kelas->isEmpty())
                            <p class="text-xs text-amber-600 mt-1"><i class="fas fa-exclamation-triangle"></i> Data kelas belum ada. Pemberitahuan ini akan otomatis hilang setelah Admin menambahkan data kelas.</p>
                        @endif
                    </div>

                    <div id="field-mapel" class="conditional-field {{ old('role', 'guru') === 'guru' ? 'visible' : '' }}">
                        <label for="mapel_id" class="block text-sm font-bold text-slate-700 mb-2">Mata Pelajaran <span class="text-slate-400 text-[10px] font-medium">(Opsional)</span></label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <i class="fas fa-book text-slate-400"></i>
                            </div>
                            <select id="mapel_id" name="mapel_id" class="w-full pl-11 pr-4 py-2.5 md:py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 transition-all outline-none text-slate-800 font-medium text-sm">
                                <option value="">-- Pilih Mata Pelajaran --</option>
                                @foreach($mapels as $m)
                                    <option value="{{ $m->id }}" {{ old('mapel_id') == $m->id ? 'selected' : '' }}>{{ $m->nama_mapel }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="jenis_kelamin" class="block text-sm font-bold text-slate-700 mb-2">
                                Jenis Kelamin
                                <span id="jkRequiredBadge" class="text-red-500">*</span>
                                <span id="jkOptionalBadge" class="text-slate-400 text-[10px] font-medium hidden">(Opsional)</span>
                            </label>
                            <select id="jenis_kelamin" name="jenis_kelamin" class="w-full px-4 py-2.5 md:py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 transition-all outline-none text-slate-800 font-medium text-sm">
                                <option value="">Pilih</option>
                                <option value="L" {{ old('jenis_kelamin') == 'L' ? 'selected' : '' }}>Laki-laki</option>
                                <option value="P" {{ old('jenis_kelamin') == 'P' ? 'selected' : '' }}>Perempuan</option>
                            </select>
                        </div>

                        <div>
                            <label for="no_hp" class="block text-sm font-bold text-slate-700 mb-2">No. HP</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <i class="fas fa-phone text-slate-400"></i>
                                </div>
                                <input type="text" id="no_hp" name="no_hp" value="{{ old('no_hp') }}" class="w-full pl-11 pr-4 py-2.5 md:py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 transition-all outline-none text-slate-800 font-medium placeholder:text-slate-400 text-sm" placeholder="08xxxxxxxx">
                            </div>
                        </div>
                    </div>

                    <div>
                        <label for="alamat" class="block text-sm font-bold text-slate-700 mb-2">Alamat</label>
                        <textarea id="alamat" name="alamat" rows="2" class="w-full px-4 py-2.5 md:py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 transition-all outline-none text-slate-800 font-medium placeholder:text-slate-400 text-sm resize-none" placeholder="Alamat lengkap">{{ old('alamat') }}</textarea>
                    </div>

                    <div class="bg-amber-50 border-l-4 border-amber-400 p-3 rounded-lg">
                        <div class="flex items-start gap-2">
                            <i class="fas fa-info-circle text-amber-500 mt-0.5 text-sm"></i>
                            <p class="text-xs text-amber-700 font-medium">Setelah mendaftar, akun Anda berstatus <strong>Pending</strong> dan tidak bisa login sebelum disetujui oleh Admin. Admin akan memverifikasi data Anda.</p>
                        </div>
                    </div>

                    <button type="submit" class="w-full bg-gradient-to-r from-emerald-600 to-blue-600 text-white font-bold py-3 px-4 rounded-xl shadow-lg shadow-emerald-500/30 hover:shadow-emerald-500/50 transition-all duration-300 hover:-translate-y-0.5 flex items-center justify-center gap-2">
                        <i class="fas fa-user-check"></i>
                        <span>Daftar Sekarang</span>
                    </button>

                    <div class="text-center pt-1">
                        <p class="text-xs md:text-sm text-slate-500 font-medium">
                            Sudah punya akun?
                            <a href="{{ route('login') }}" class="text-emerald-600 font-bold hover:text-emerald-700 hover:underline transition-colors">Login disini</a>
                        </p>
                    </div>
                </form>
            </div>

            <div class="bg-slate-50/50 px-6 py-3 md:py-4 border-t border-slate-100 text-center backdrop-blur-sm">
                <p class="text-xs text-slate-500 font-medium">
                    &copy; {{ date('Y') }} SMA Negeri 1 Tuhemberua. All rights reserved.
                </p>
            </div>
        </div>
    </div>

    <script>
        (function () {
            const roleCards = document.querySelectorAll('.role-card');
            const fieldKelas = document.getElementById('field-kelas');
            const fieldMapel = document.getElementById('field-mapel');
            const kelasSelect = document.getElementById('kelas_id');
            const jkSelect = document.getElementById('jenis_kelamin');
            const jkRequiredBadge = document.getElementById('jkRequiredBadge');
            const jkOptionalBadge = document.getElementById('jkOptionalBadge');

            function updateConditional(role) {
                if (fieldKelas) fieldKelas.classList.remove('visible');
                if (fieldMapel) fieldMapel.classList.remove('visible');
                if (kelasSelect) kelasSelect.required = false;
                if (jkSelect) jkSelect.required = false;
                if (jkRequiredBadge) jkRequiredBadge.classList.add('hidden');
                if (jkOptionalBadge) jkOptionalBadge.classList.remove('hidden');

                if (role === 'siswa') {
                    if (fieldKelas) fieldKelas.classList.add('visible');
                    if (kelasSelect) kelasSelect.required = true;
                    if (jkSelect) jkSelect.required = true;
                    if (jkRequiredBadge) jkRequiredBadge.classList.remove('hidden');
                    if (jkOptionalBadge) jkOptionalBadge.classList.add('hidden');
                } else if (role === 'guru') {
                    if (fieldMapel) fieldMapel.classList.add('visible');
                }
            }

            roleCards.forEach(card => {
                card.addEventListener('click', function () {
                    document.querySelectorAll('.role-card').forEach(c => c.classList.remove('selected'));
                    this.classList.add('selected');
                    const radio = this.querySelector('input[type="radio"]');
                    if (radio) {
                        radio.checked = true;
                        updateConditional(radio.value);
                    }
                });
            });

            const initialRole = document.querySelector('input[name="role"]:checked');
            if (initialRole) updateConditional(initialRole.value);
        })();
    </script>
</body>
</html>
