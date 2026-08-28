<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panduan Pengguna - SIAKAD SMA Negeri 1 Tuhemberua</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        .blob {
            position: absolute;
            filter: blur(80px);
            z-index: 0;
            opacity: 0.5;
        }
        .glass-card {
            background: rgba(255, 255, 255, 0.92);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.6);
        }
        .glass-nav {
            background: rgba(15, 23, 42, 0.85);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }
        .tab-panel { display: none; }
        .tab-panel.active { display: block; animation: fadeIn 0.5s ease; }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .step-card { transition: all 0.3s ease; }
        .step-card:hover { transform: translateX(6px); }
    </style>
</head>
<body class="min-h-screen bg-slate-900 text-slate-800 antialiased relative overflow-x-hidden">

    <div class="fixed inset-0 z-0">
        <img src="https://images.unsplash.com/photo-1523050854058-8df90110c9f1?ixlib=rb-1.2.1&auto=format&fit=crop&w=1950&q=80" alt="Background" class="w-full h-full object-cover opacity-15 mix-blend-overlay">
        <div class="absolute inset-0 bg-gradient-to-b from-slate-900 via-slate-900/95 to-slate-900"></div>
    </div>

    <div class="fixed blob bg-emerald-600 w-96 h-96 rounded-full top-20 -left-10 animate-pulse pointer-events-none"></div>
    <div class="fixed blob bg-amber-500 w-80 h-80 rounded-full bottom-20 right-0 animate-pulse pointer-events-none" style="animation-delay: 1.5s;"></div>

    <nav class="fixed w-full z-50 transition-all duration-300 bg-white/80 backdrop-blur-lg border-b border-slate-200/50 supports-[backdrop-filter]:bg-white/60">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-20 items-center">
                <div class="flex items-center gap-3 group cursor-pointer">
                    <a href="{{ url('/') }}" class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-gradient-to-tr from-blue-600 to-indigo-600 flex items-center justify-center shadow-lg shadow-blue-500/20 group-hover:scale-110 transition-transform duration-300">
                            <i class="fas fa-graduation-cap text-white text-lg"></i>
                        </div>
                        <div>
                            <span class="text-xl font-bold text-slate-900 tracking-tight block leading-none">SIAKAD</span>
                            <span class="text-[10px] text-blue-600 font-bold uppercase tracking-widest group-hover:text-blue-500 transition-colors">SMAN 1 Tuhemberua</span>
                        </div>
                    </a>
                </div>
                <div class="hidden md:flex items-center space-x-8">
                    <a href="{{ url('/') }}#beranda" class="text-sm font-medium text-slate-600 hover:text-blue-600 transition-colors">Beranda</a>
                    <a href="{{ url('/') }}#fitur" class="text-sm font-medium text-slate-600 hover:text-blue-600 transition-colors">Fitur</a>
                    <a href="{{ url('/') }}#statistik" class="text-sm font-medium text-slate-600 hover:text-blue-600 transition-colors">Statistik</a>
                    <a href="{{ url('/') }}#pengumuman" class="text-sm font-medium text-slate-600 hover:text-blue-600 transition-colors">Pengumuman</a>
                    <div class="relative">
                        <button class="text-sm font-medium text-blue-600 transition-colors flex items-center gap-2 focus:outline-none" id="dropdownBantuanBtn">
                            Bantuan
                            <i class="fas fa-chevron-down text-[10px] transition-transform" id="dropdownBantuanIcon"></i>
                        </button>
                        <div id="dropdownBantuanMenu" class="absolute left-0 mt-3 w-52 bg-white/95 backdrop-blur-xl rounded-2xl shadow-2xl shadow-slate-900/10 border border-slate-200/50 py-2 hidden origin-top-left">
                            <a href="{{ route('bantuan.panduan') }}" class="block px-5 py-3 text-sm font-semibold text-slate-700 hover:bg-blue-50 hover:text-blue-600 transition-colors flex items-center gap-3">
                                <i class="fas fa-book w-5 text-center text-blue-500"></i> Panduan Penggunaan
                            </a>
                            <a href="{{ route('bantuan.faq') }}" class="block px-5 py-3 text-sm font-semibold text-slate-700 hover:bg-blue-50 hover:text-blue-600 transition-colors flex items-center gap-3">
                                <i class="fas fa-circle-question w-5 text-center text-blue-500"></i> FAQ
                            </a>
                            <a href="{{ route('bantuan.kebijakan') }}" class="block px-5 py-3 text-sm font-semibold text-slate-700 hover:bg-blue-50 hover:text-blue-600 transition-colors flex items-center gap-3">
                                <i class="fas fa-shield-halved w-5 text-center text-blue-500"></i> Kebijakan Sistem
                            </a>
                            <div class="my-1 mx-4 border-t border-slate-100"></div>
                            <a href="{{ route('bantuan.lapor') }}" class="block px-5 py-3 text-sm font-semibold text-amber-700 hover:bg-amber-50 transition-colors flex items-center gap-3">
                                <i class="fas fa-circle-exclamation w-5 text-center text-amber-500"></i> Laporkan Masalah
                            </a>
                        </div>
                    </div>
                    <a href="{{ url('/') }}#lokasi" class="text-sm font-medium text-slate-600 hover:text-blue-600 transition-colors">Lokasi</a>
                    
                    @if (Route::has('login'))
                        @auth
                            <a href="{{ route('admin.dashboard') }}" class="px-6 py-2.5 bg-blue-600 text-white text-sm font-semibold rounded-full hover:bg-blue-700 shadow-lg shadow-blue-500/30 transition-all hover:-translate-y-0.5 hover:shadow-blue-500/50">Dashboard</a>
                        @else
                            <a href="{{ route('login') }}" class="px-6 py-2.5 bg-slate-900 text-white text-sm font-semibold rounded-full hover:bg-slate-800 shadow-lg shadow-slate-500/30 transition-all hover:-translate-y-0.5 hover:shadow-slate-500/50 flex items-center gap-2">
                                <i class="fas fa-sign-in-alt"></i> Login
                            </a>
                        @endauth
                    @endif
                </div>
                <button id="mobileMenuBtn" class="md:hidden text-slate-800 p-2 rounded-xl hover:bg-slate-100 transition-all">
                    <i class="fas fa-bars text-xl"></i>
                </button>
            </div>
        </div>
        <div id="mobileMenu" class="hidden md:hidden border-t border-slate-200 bg-white/95 backdrop-blur-xl">
            <div class="px-4 py-4 space-y-1">
                <a href="{{ url('/') }}#beranda" class="block px-4 py-3 rounded-xl text-sm font-semibold text-slate-600 hover:text-blue-600 hover:bg-slate-50">Beranda</a>
                <a href="{{ url('/') }}#fitur" class="block px-4 py-3 rounded-xl text-sm font-semibold text-slate-600 hover:text-blue-600 hover:bg-slate-50">Fitur</a>
                <a href="{{ url('/') }}#statistik" class="block px-4 py-3 rounded-xl text-sm font-semibold text-slate-600 hover:text-blue-600 hover:bg-slate-50">Statistik</a>
                <a href="{{ url('/') }}#pengumuman" class="block px-4 py-3 rounded-xl text-sm font-semibold text-slate-600 hover:text-blue-600 hover:bg-slate-50">Pengumuman</a>
                <a href="{{ route('bantuan.panduan') }}" class="block px-4 py-3 rounded-xl text-sm font-semibold text-white bg-blue-600">Panduan</a>
                <a href="{{ route('bantuan.faq') }}" class="block px-4 py-3 rounded-xl text-sm font-semibold text-slate-600 hover:text-blue-600 hover:bg-slate-50">FAQ</a>
                <a href="{{ route('bantuan.kebijakan') }}" class="block px-4 py-3 rounded-xl text-sm font-semibold text-slate-600 hover:text-blue-600 hover:bg-slate-50">Kebijakan</a>
                <a href="{{ route('bantuan.lapor') }}" class="block px-4 py-3 rounded-xl text-sm font-semibold text-slate-600 hover:text-blue-600 hover:bg-slate-50">Laporkan Masalah</a>
                <a href="{{ url('/') }}#lokasi" class="block px-4 py-3 rounded-xl text-sm font-semibold text-slate-600 hover:text-blue-600 hover:bg-slate-50">Lokasi</a>
                <div class="pt-3 mt-3 border-t border-slate-200 flex gap-2">
                    @auth
                        <a href="{{ route('admin.dashboard') }}" class="flex-1 text-center px-4 py-3 rounded-xl text-sm font-bold text-white bg-blue-600">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="flex-1 text-center px-4 py-3 rounded-xl text-sm font-bold text-white bg-slate-900">Login</a>
                        <a href="{{ route('register') }}" class="flex-1 text-center px-4 py-3 rounded-xl text-sm font-bold text-white bg-blue-600">Register</a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <section class="relative z-10 pt-32 pb-20 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto">
        <div class="text-center mb-12">
            <span class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 text-xs font-bold uppercase tracking-wider mb-6">
                <i class="fas fa-book"></i>
                Panduan Penggunaan
            </span>
            <h1 class="text-4xl md:text-5xl lg:text-6xl font-extrabold text-white mb-4 leading-tight">
                Panduan Lengkap
                <span class="bg-gradient-to-r from-emerald-400 via-emerald-300 to-amber-400 bg-clip-text text-transparent">SIAKAD</span>
            </h1>
            <p class="text-lg text-slate-400 font-medium max-w-2xl mx-auto">
                Pelajari cara menggunakan sistem akademik SIAKAD sesuai 11 materi standar peran Anda (Registrasi, Login, Logout, Data Master, Verifikasi, Nilai, Jadwal, Absensi, Raport, Pengumuman, Lapor Masalah).
            </p>
        </div>

        <div class="flex flex-col lg:flex-row gap-6">
            <div class="lg:w-80 flex-shrink-0">
                <div class="glass-card rounded-3xl p-4 lg:sticky lg:top-28">
                    <p class="text-[11px] font-bold text-slate-500 uppercase tracking-wider px-4 py-3">Pilih Panduan Berdasarkan Peran</p>
                    <div class="space-y-2">
                        <button onclick="switchTab('admin')" id="tab-btn-admin" class="tab-btn w-full flex items-center gap-4 px-5 py-4 rounded-2xl text-left transition-all bg-emerald-50 border-2 border-emerald-200 text-emerald-700">
                            <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-red-500 to-red-600 flex items-center justify-center text-white shadow-sm">
                                <i class="fas fa-user-shield text-lg"></i>
                            </div>
                            <div>
                                <p class="font-bold">Administrator</p>
                                <p class="text-xs opacity-75">Kelola sistem penuh</p>
                            </div>
                        </button>
                        <button onclick="switchTab('guru')" id="tab-btn-guru" class="tab-btn w-full flex items-center gap-4 px-5 py-4 rounded-2xl text-left transition-all hover:bg-slate-50 border-2 border-transparent">
                            <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-blue-500 to-indigo-600 flex items-center justify-center text-white shadow-sm">
                                <i class="fas fa-chalkboard-teacher text-lg"></i>
                            </div>
                            <div>
                                <p class="font-bold text-slate-800">Guru</p>
                                <p class="text-xs text-slate-500">Mengajar & Penilaian</p>
                            </div>
                        </button>
                        <button onclick="switchTab('siswa')" id="tab-btn-siswa" class="tab-btn w-full flex items-center gap-4 px-5 py-4 rounded-2xl text-left transition-all hover:bg-slate-50 border-2 border-transparent">
                            <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-purple-500 to-purple-600 flex items-center justify-center text-white shadow-sm">
                                <i class="fas fa-user-graduate text-lg"></i>
                            </div>
                            <div>
                                <p class="font-bold text-slate-800">Siswa</p>
                                <p class="text-xs text-slate-500">Belajar & Akademik</p>
                            </div>
                        </button>
                        <button onclick="switchTab('kepala')" id="tab-btn-kepala" class="tab-btn w-full flex items-center gap-4 px-5 py-4 rounded-2xl text-left transition-all hover:bg-slate-50 border-2 border-transparent">
                            <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-amber-500 to-orange-500 flex items-center justify-center text-white shadow-sm">
                                <i class="fas fa-user-tie text-lg"></i>
                            </div>
                            <div>
                                <p class="font-bold text-slate-800">Kepala Sekolah</p>
                                <p class="text-xs text-slate-500">Monitoring & Verifikasi</p>
                            </div>
                        </button>
                    </div>
                </div>
            </div>

            <div class="flex-1">
                {{-- TAB ADMIN --}}
                <div id="tab-admin" class="tab-panel active">
                    <div class="glass-card rounded-3xl p-8 md:p-10 mb-6 bg-gradient-to-br from-red-500/5 to-transparent border-t-4 border-red-500">
                        <div class="flex flex-wrap items-center gap-5 mb-2">
                            <div class="w-16 h-16 rounded-3xl bg-gradient-to-br from-red-500 to-red-600 flex items-center justify-center text-white shadow-xl shadow-red-500/30">
                                <i class="fas fa-user-shield text-2xl"></i>
                            </div>
                            <div>
                                <h2 class="text-3xl font-extrabold text-slate-800">Panduan Administrator</h2>
                                <p class="text-slate-500 font-medium mt-1">11 Materi Standar Peran: Full Akses Sistem</p>
                            </div>
                        </div>
                    </div>
                    <div class="space-y-4">
                        @php
                            $adminSections = [
                                [
                                    'icon' => 'fa-user-plus', 'color' => 'from-emerald-500 to-emerald-700', 'border' => 'border-slate-200', 'stepBg' => 'bg-emerald-100 text-emerald-700',
                                    'title' => '1. Cara Registrasi & Penambahan User Baru',
                                    'steps' => [
                                        'Registrasi akun GURU, SISWA, KEPALA SEKOLAH BISA dilakukan sendiri oleh publik via halaman Register (role Admin TIDAK BOLEH dibuat publik → sesuai SOP keamanan).',
                                        'Cara 1 (Verifikasi Publik): User (Guru/Siswa/Kepsek) isi form Register sendiri. Admin tinggal approve. Lihat Ikon Lonceng > Notifikasi Registrasi Baru.',
                                        'Cara 2 (Admin tambah manual): Sidebar User & Akses > Daftar User > Tambah User. Isi username, role (Admin/Guru/Siswa/Kepsek/Tendik), password awal (otomatis hash via cast hashed).',
                                        'Setelah user dibuat, data Guru/Siswa harus sinkron: Buka Data Guru/Siswa > Tambah > hubungkan dengan user_id yang baru dibuat.',
                                        'Kirim password awal secara OFFLINE ke user (WA/email pribadi), dan instruksikan SEGERA ganti password di halaman Profil setelah login pertama.',
                                    ],
                                ],
                                [
                                    'icon' => 'fa-right-to-bracket', 'color' => 'from-blue-500 to-blue-700', 'border' => 'border-slate-200', 'stepBg' => 'bg-blue-100 text-blue-700',
                                    'title' => '2. Cara Login Sebagai Admin',
                                    'steps' => [
                                        'Buka browser, akses domain SIAKAD sekolah (contoh: siakad.sman1tuhemberua.sch.id) > klik Login pojok kanan atas.',
                                        'Form Login: HANYA kolom Username & Password (TIDAK ada NIP/NISN).',
                                        'Masukkan Username Admin dan Password yang benar.',
                                        'Klik Login. Sistem mengecek: Rate Limit 5x/60s, status akun harus ACTIVE, role harus Admin.',
                                        'Jika berhasil: Masuk Dashboard Admin. Terdapat Widget Total User, Jumlah Pending Verifikasi, Notifikasi Laporan Masalah, Ringkasan Akademik.',
                                        'Jika gagal: Pesan GENERIK "Username atau password salah." (tidak membocorkan username ada/tidak ada = perlindungan enumerasi OWASP).',
                                    ],
                                ],
                                [
                                    'icon' => 'fa-right-from-bracket', 'color' => 'from-slate-600 to-slate-800', 'border' => 'border-slate-200', 'stepBg' => 'bg-slate-100 text-slate-700',
                                    'title' => '3. Cara Logout Admin Yang Aman',
                                    'steps' => [
                                        'Avatar pojok kanan atas dropdown > Keluar / Logout.',
                                        'Sistem otomatis melakukan: session()->flush() (hapus semua data), session()->invalidate() (hapus storage), session()->regenerate(true) (hapus ID session lama + buat ID BARU).',
                                        'Auto redirect ke halaman Login.',
                                        'Response Header NoCache aktif: Cache-Control no-store,no-cache; Pragma no-cache; Expires 1970. Akibatnya: TOMBOL BACK BROWSER TIDAK BISA MEMBUKA KEMBALI dashboard dari cache (keamanan).',
                                        'Gunakan cara ini SETIAP selesai mengakses, terutama jika memakai PC shared / warnet. JANGAN cuma tutup tab.',
                                    ],
                                ],
                                [
                                    'icon' => 'fa-users', 'color' => 'from-purple-500 to-purple-700', 'border' => 'border-purple-200', 'stepBg' => 'bg-purple-100 text-purple-700',
                                    'title' => '4. Cara Mengelola Data Siswa dan Guru',
                                    'steps' => [
                                        'Sidebar kiri menu: Master Data > Data Siswa / Data Guru.',
                                        'Tombol + Tambah Data: isi form lengkap (Nama Lengkap, JK, Tempat/Tgl Lahir, Alamat, No HP, dll). Hubungkan dengan User ID jika akun sudah dibuat.',
                                        'Fitur Edit: Klik icon pensil pada baris data. Jika UBAH NAMA LENGKAP, otomatis SINKRON dengan users.name (transaksional di ProfileController jika perubahan dari Profil User; jika perubahan Admin manual pastikan 1:1 save).',
                                        'Fitur Hapus: Peringatan soft/hard delete. Jika hard delete, CASCADE user_id FK → user akun juga terhapus (aturan 1:1 struktur data).',
                                        'Fitur Import Excel (jika tersedia): Download Template, isi sesuai format, Upload, sistem batch insert 500 data aman chunk.',
                                        'Cek validasi: Kolom NIP/NISN boleh NULL jika data belum ada (TIDAK boleh diisi fiktif).',
                                    ],
                                ],
                                [
                                    'icon' => 'fa-user-check', 'color' => 'from-emerald-500 to-teal-600', 'border' => 'border-emerald-200', 'stepBg' => 'bg-emerald-100 text-emerald-700',
                                    'title' => '5. Cara Melakukan Verifikasi Pengguna',
                                    'steps' => [
                                        'Cara Cepat: Klik IKON LONCENG Dashboard > Lihat unread badge > Klik notifikasi "Registrasi {Siswa/Guru/Kepsek} Baru" > langsung pindah halaman Verifikasi Pengguna (filter otomatis Pending).',
                                        'Cara Manual: Sidebar User & Akses > Verifikasi Pengguna.',
                                        'Tab Pending = user yang belum diverifikasi. Klik nama user untuk buka detail > cek data kelengkapan.',
                                        '✅ SETUJUI (Approve): Klik tombol Setujui → status user = ACTIVE. Jika Guru → is_active = true di tabel gurus. User TERKAIT OTOMATIS terima Notifikasi "Akun Disetujui" di lonceng saat login.',
                                        '❌ TOLAK (Reject): Klik Tolak > wajib isi alasan penolakan → status = REJECTED. User mendapat Notifikasi "Akun Ditolak + Alasan".',
                                        '⛔ NONAKTIFKAN: User yang sudah active bisa di-nonaktif (status=INACTIVE) bila ada pelanggaran. User dapat notif "Akun Dinonaktifkan" dan TIDAK BISA login.',
                                        '🔑 RESET PASSWORD: Jika user lupa password > Klik Reset Password > buat password default (otomatis hash). Kirim via channel aman OFFLINE.',
                                    ],
                                ],
                                [
                                    'icon' => 'fa-pen-to-square', 'color' => 'from-orange-500 to-orange-700', 'border' => 'border-orange-200', 'stepBg' => 'bg-orange-100 text-orange-700',
                                    'title' => '6. Cara Input / Koreksi Nilai (Override)',
                                    'steps' => [
                                        'Nilai normal diinput oleh GURU MAPEL di halaman Input Nilai per kelas. Admin bisa OVERRIDE jika melewati batas waktu input nilai (telah close).',
                                        'Sidebar Akademik > menu Nilai > pilih filter: Kelas + Mapel + Tahun Ajaran + Semester + Kategori Nilai (Tugas, Harian, UTS, UAS).',
                                        'Klik tombol Edit Nilai. Perhatikan: setiap perubahan Admin selalu disertai Berita Acara / catatan di kolom keterangan agar audit trail jelas.',
                                        'Simpan → sistem OTOMATIS kirim NOTIFIKASI ke SISWA terkait "Nilai Anda diperbarui oleh Admin".',
                                        'Jika ragu, hubungi terlebih dahulu Guru Mapel + konfirmasi data via BK sebelum mengubah nilai raport.',
                                    ],
                                ],
                                [
                                    'icon' => 'fa-chart-line', 'color' => 'from-cyan-500 to-blue-600', 'border' => 'border-cyan-200', 'stepBg' => 'bg-cyan-100 text-cyan-700',
                                    'title' => '7. Cara Melihat Nilai (Rekap Semua Kelas)',
                                    'steps' => [
                                        'Sidebar Akademik > Nilai > Tab Rekap.',
                                        'Pilih filter Tahun Ajaran, Semester, Tingkat Kelas, Kelas spesifik, Mapel. Klik Tampilkan.',
                                        'Anda melihat Tabel rekap: Baris = semua Siswa di kelas; Kolom = semua Kategori Nilai (T1, T2, UTS, UAS) + rata-rata + KKM + Status Ketuntasan.',
                                        'Klik nama siswa untuk buka Detail Nilai individu lengkap dengan history perubahan & audit trail.',
                                        'Export tombol: Export Excel, Cetak PDF Rekap per Mapel untuk Rapat Pleno Kelulusan / Rapat Ortu.',
                                    ],
                                ],
                                [
                                    'icon' => 'fa-calendar-alt', 'color' => 'from-indigo-500 to-indigo-700', 'border' => 'border-indigo-200', 'stepBg' => 'bg-indigo-100 text-indigo-700',
                                    'title' => '8. Cara Melihat / Mengelola Jadwal Pelajaran',
                                    'steps' => [
                                        'Sidebar Akademik > Jadwal Pelajaran.',
                                        'Tombol Tambah Jadwal: Isi Hari (Senin-Jumat), Jam Ke (1-10), Kelas, Mapel, Guru Pengampu, Ruangan (opsional). Klik Simpan.',
                                        'Setiap penambahan / perubahan Jadwal → OTOMATIS kirim NOTIFIKASI ke: (a) Guru Pengampu terkait, (b) SEMUA SISWA di kelas yang bersangkutan. Ikon lonceng mereka bertambah.',
                                        'Fitur Edit / Hapus Jadwal: perubahan tetap kirim notifikasi "Jadwal Mengajar / Pelajaran diperbarui".',
                                        'Tab View: Harian / Mingguan per Kelas / per Guru. Export PDF.',
                                    ],
                                ],
                                [
                                    'icon' => 'fa-clipboard-user', 'color' => 'from-pink-500 to-pink-700', 'border' => 'border-pink-200', 'stepBg' => 'bg-pink-100 text-pink-700',
                                    'title' => '9. Cara Melihat & Rekap Absensi',
                                    'steps' => [
                                        'Sidebar Akademik > Absensi.',
                                        '2 Opsi: Absensi Siswa (per kelas per hari) / Absensi Guru & Tendik.',
                                        'Filter Tanggal → Rekap per siswa: Hadir, Sakit, Ijin, Alpa, Persentase Kehadiran.',
                                        'Export rekap bulanan sebagai Excel untuk BK / Wali Kelas / Orang tua.',
                                        'Kirim Pengingat jika ada siswa alpa ≥ 3 hari berturut-turut (via Pengumuman Private / hubungi Wali Kelas).',
                                    ],
                                ],
                                [
                                    'icon' => 'fa-file-pdf', 'color' => 'from-red-500 to-rose-700', 'border' => 'border-red-200', 'stepBg' => 'bg-red-100 text-red-700',
                                    'title' => '10. Cara Membuat & Mengunduh Raport',
                                    'steps' => [
                                        'Pastikan SEMUA nilai semua mapel sudah diinput & DIVALIDASI. Pastikan Absensi sudah direkap.',
                                        'Sidebar Akademik > Raport & Leger > Generate Raport.',
                                        'Filter: Tahun Ajaran, Semester, Kelas. Klik Generate.',
                                        'Admin dapat: Preview Raport, Edit Cover, Tambah Catatan Wali Kelas, Tambah TTD Kepsek.',
                                        'Setelah publish, SISWA terkait dapat notifikasi "Raport telah tersedia". Mereka bisa Login → menu Raport → unduh PDF.',
                                        'Unduh batch ZIP semua raport kelas (aturan > 100 file = job queue async agar tidak timeout).',
                                    ],
                                ],
                                [
                                    'icon' => 'fa-bullhorn', 'color' => 'from-amber-500 to-orange-500', 'border' => 'border-amber-200', 'stepBg' => 'bg-amber-100 text-amber-700',
                                    'title' => '11. Fitur Lainnya: Pengumuman, FAQ, Kebijakan, Tanggapi Laporan Masalah',
                                    'steps' => [
                                        '📢 Pengumuman: Sidebar Pengumuman > Tambah Pengumuman. Pilih Target (Semua/Guru/Siswa/Kepsek/Tendik). Setiap publish → sistem kirim NOTIFIKASI "Pengumuman Baru: judul" ke SEMUA user target via chunkById (aman memori 100 row per loop).',
                                        '❓ Kelola FAQ: Sidebar Bantuan > FAQ. Tambah pertanyaan + jawaban, pilih for_role (semua/guru/siswa/kepsek). Sort urutan display.',
                                        '📜 Kelola Kebijakan: Sidebar Bantuan > Kebijakan Sistem. Tambah Judul, Slug (otomatis unique), Isi konten panjang markdown/HTML. User bisa baca di /bantuan/kebijakan.',
                                        '📥 Laporan Masalah: Sidebar Bantuan > Laporan Masalah. Terdapat list dengan status (Open, In Progress, Resolved, Closed). Buka detail laporan, ganti status, isi Respon Admin → KIRIM OTOMATIS notifikasi ke user PELAPOR: "Laporan Anda: Status Diperbarui".',
                                        '🔎 Audit & Log: Login terakhir user, perubahan data penting → untuk audit internal.',
                                    ],
                                ],
                            ];
                        @endphp
                        @foreach($adminSections as $s)
                        <div class="glass-card rounded-3xl p-7 step-card border-l-4 {{ $s['border'] }} hover:shadow-md">
                            <div class="flex items-start gap-5 mb-6">
                                <div class="w-14 h-14 rounded-2xl bg-gradient-to-br {{ $s['color'] }} flex items-center justify-center text-white shadow-md flex-shrink-0">
                                    <i class="fas {{ $s['icon'] }} text-xl"></i>
                                </div>
                                <h3 class="text-xl font-bold text-slate-800 pt-3">{{ $s['title'] }}</h3>
                            </div>
                            <div class="ml-4 md:ml-20 space-y-3">
                                @foreach($s['steps'] as $i => $step)
                                <div class="flex items-start gap-4 p-4 rounded-2xl bg-slate-50/70 hover:bg-slate-50 transition-colors">
                                    <div class="flex-shrink-0 w-8 h-8 rounded-xl {{ $s['stepBg'] }} font-bold text-sm flex items-center justify-center">{{ $i + 1 }}</div>
                                    <p class="text-sm text-slate-700 font-medium leading-relaxed pt-1">{{ $step }}</p>
                                </div>
                                @endforeach
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>

                {{-- TAB GURU --}}
                <div id="tab-guru" class="tab-panel">
                    <div class="glass-card rounded-3xl p-8 md:p-10 mb-6 bg-gradient-to-br from-blue-500/5 to-transparent border-t-4 border-blue-500">
                        <div class="flex flex-wrap items-center gap-5 mb-2">
                            <div class="w-16 h-16 rounded-3xl bg-gradient-to-br from-blue-500 to-indigo-600 flex items-center justify-center text-white shadow-xl shadow-blue-500/30">
                                <i class="fas fa-chalkboard-teacher text-2xl"></i>
                            </div>
                            <div>
                                <h2 class="text-3xl font-extrabold text-slate-800">Panduan Guru</h2>
                                <p class="text-slate-500 font-medium mt-1">11 Materi Standar Peran: Mengajar, Penilaian, Absensi, Raport</p>
                            </div>
                        </div>
                    </div>
                    <div class="space-y-4">
                        @php
                            $guruSections = [
                                [
                                    'icon' => 'fa-user-plus', 'color' => 'from-emerald-500 to-green-600', 'border' => 'border-emerald-200', 'stepBg' => 'bg-emerald-100 text-emerald-700',
                                    'title' => '1. Cara Registrasi Sebagai Guru',
                                    'steps' => [
                                        'Buka beranda SIAKAD sekolah > klik tombol REGISTER pojok kanan atas.',
                                        'Pilih kartu berwarna BIRU: **Saya ingin mendaftar sebagai Guru**.',
                                        'Isi formulir: Nama Lengkap, Username (unik), Password, Konfirmasi Password, Email (opsional, validasi jika diisi), No HP, Alamat, Jenis Kelamin, Mata Pelajaran yang diampu (wajib pilih dari daftar yang sudah ada).',
                                        'Klik Kirim Registrasi → otomatis user dibuat dengan status **PENDING (menunggu verifikasi Admin)**.',
                                        'Anda akan lihat pesan sukses: "Registrasi berhasil! Akun Anda menunggu verifikasi Admin."',
                                        'Admin akan memeriksa data Anda. Jika disetujui, Anda BISA LOGIN. Coba login secara berkala, atau tunggu info dari sekolah.',
                                    ],
                                ],
                                [
                                    'icon' => 'fa-right-to-bracket', 'color' => 'from-blue-500 to-blue-700', 'border' => 'border-blue-200', 'stepBg' => 'bg-blue-100 text-blue-700',
                                    'title' => '2. Cara Login Sebagai Guru',
                                    'steps' => [
                                        'Halaman Login: HANYA kolom Username + Password.',
                                        'Masukkan Username & Password Anda (bukan NIP; NIP diset NULL jika belum ada).',
                                        'Klik Login.',
                                        'Jika status Anda PENDING / REJECTED / INACTIVE → middleware CheckUserStatus menolak login, redirect kembali login dengan error "Akun Anda belum aktif".',
                                        'Jika sukses: Masuk Dashboard Guru, widget Selamat Datang, Jadwal Hari Ini, Jumlah Kelas, Ikon Lonceng berisi Notifikasi (misal Jadwal ditambah Admin, Pengumuman, Akun Disetujui, dll).',
                                    ],
                                ],
                                [
                                    'icon' => 'fa-right-from-bracket', 'color' => 'from-slate-600 to-slate-800', 'border' => 'border-slate-200', 'stepBg' => 'bg-slate-100 text-slate-700',
                                    'title' => '3. Cara Logout Yang Benar',
                                    'steps' => [
                                        'Avatar Huruf / Foto Profil pojok kanan atas → klik dropdown → Logout.',
                                        'Sistem menghapus semua session lama (flush + invalidate + regenerateID true) + redirect login + header NoCache.',
                                        'TIDAK BOLEH hanya tutup tab, terutama menggunakan komputer Lab / shared.',
                                        'Setelah logout, tekan tombol Back browser: TIDAK AKAN bisa kembali ke dashboard (halaman harus login ulang). Ini perlindungan anti-cache.',
                                    ],
                                ],
                                [
                                    'icon' => 'fa-chalkboard-user', 'color' => 'from-sky-500 to-blue-600', 'border' => 'border-sky-200', 'stepBg' => 'bg-sky-100 text-sky-700',
                                    'title' => '4. Cara Melihat Data Siswa & Profil Data Guru',
                                    'steps' => [
                                        'Sidebar Profil Guru: Menampilkan Nama Lengkap, Gelar, Mapel yang diampu, No HP, Alamat, Foto.',
                                        'Edit Profil: klik Ubah Profil → Anda bisa update Nama, Gelar, No HP, Alamat, JK, Foto Avatar. Jika ganti Nama → otomatis sinkron ke users.name (DB transaction).',
                                        'Ubah Password: Menu Ubah Password, masukkan Password Lama, Password Baru, Konfirmasi. Password akan otomatis dihash (cast hashed) → Admin TIDAK bisa melihatnya.',
                                        'Lihat Data Siswa: Hanya siswa di kelas yang Anda ajar bisa dilihat (side Data Siswa Saya).',
                                        'Untuk koreksi NISN / data administratif siswa: Lapor ke Admin via Bantuan > Lapor Masalah kategori Data Akademik.',
                                    ],
                                ],
                                [
                                    'icon' => 'fa-calendar-week', 'color' => 'from-blue-500 to-blue-700', 'border' => 'border-blue-200', 'stepBg' => 'bg-blue-100 text-blue-700',
                                    'title' => '5. Cara Melihat Jadwal Mengajar',
                                    'steps' => [
                                        'Dashboard: Widget Jadwal Mengajar Hari Ini (menampilkan kelas, mapel, jam, ruang hari ini).',
                                        'Sidebar Akademik → Jadwal Pelajaran.',
                                        'Filter: Hari (Senin s/d Jumat), Kelas, Ruangan. Kolom: Jam, Kelas, Mapel, Ruangan.',
                                        'Tombol Download PDF: simpan offline atau cetak ditempel meja guru.',
                                        'Jika Admin merubah jadwal (menambah / edit) → Anda akan menerima NOTIFIKASI di IKON LONCENG: "Jadwal Mengajar diperbarui: Mapel X Kelas Y hari Z jam J". Klik notifikasi → langsung ke halaman Jadwal + status terbaca otomatis.',
                                    ],
                                ],
                                [
                                    'icon' => 'fa-file-invoice', 'color' => 'from-emerald-500 to-teal-600', 'border' => 'border-emerald-200', 'stepBg' => 'bg-emerald-100 text-emerald-700',
                                    'title' => '6. Cara Input Nilai Siswa',
                                    'steps' => [
                                        'Sidebar Akademik → menu **Nilai**.',
                                        'Pilih Filter: Kategori Nilai (Tugas 1/2, Harian, UTS, UAS), Tahun Ajaran, Semester, Kelas. Klik Buka Input Nilai.',
                                        'Anda hanya bisa input mapel yang SESUAI mapel profil guru Anda (mapel lain TIDAK tampil / readonly).',
                                        'Muncul tabel: semua nama siswa kelas tersebut. Isi nilai 0-100 pada input di samping nama. KOSONGKAN jika siswa tidak mengikuti (tidak dipaksa 0).',
                                        'Klik **Simpan Semua Nilai** → proses DB transaction (jika satu nilai error maka rollback semua, aman data).',
                                        'Sesudah sukses: (a) SEMUA ADMIN terima notifikasi "Nilai Baru Masuk: Kategori X Mapel Y Kelas Z → segera verifikasi", (b) SETIAP SISWA yang nilainya Anda isi terima NOTIFIKASI "Nilai Baru Tersedia: Kategori Nilai X Mapel Y".',
                                    ],
                                ],
                                [
                                    'icon' => 'fa-magnifying-glass-chart', 'color' => 'from-cyan-500 to-blue-600', 'border' => 'border-cyan-200', 'stepBg' => 'bg-cyan-100 text-cyan-700',
                                    'title' => '7. Cara Melihat / Memeriksa Kembali Nilai',
                                    'steps' => [
                                        'Sidebar Nilai > Filter kelas > Lihat Rekap Nilai.',
                                        'Anda bisa melihat: Rata-rata nilai per siswa, siswa di bawah KKM, distribusi nilai (min/max).',
                                        'Klik baris siswa → Detail Riwayat Nilai (history semua input + perbaikan).',
                                        'Jika salah input: klik Edit Nilai → ubah angka → Simpan Perbaikan → Admin menerima notifikasi koreksi nilai.',
                                    ],
                                ],
                                [
                                    'icon' => 'fa-qrcode', 'color' => 'from-purple-500 to-purple-700', 'border' => 'border-purple-200', 'stepBg' => 'bg-purple-100 text-purple-700',
                                    'title' => '8. Cara Melakukan Absensi Siswa (QR / Manual)',
                                    'steps' => [
                                        'Sidebar Akademik → Absensi → Pilih Kelas & Pertemuan Ke / Tanggal.',
                                        'Cara QR Scanner: Klik Mode QR → buka html5-qrcode scanner → minta siswa tunjukkan QR profil mereka satu per satu → scan OK = otomatis centang Hadir.',
                                        'Cara Manual (jika scanner error / HP lowbat): centang manual kolom Hadir / Sakit / Ijin / Alpha → isi catatan (misal "Sakit demam, surat dokter ada").',
                                        'Klik Simpan Absensi → data masuk.',
                                        'Lihat rekap bulanan: Export PDF untuk wali kelas.',
                                    ],
                                ],
                                [
                                    'icon' => 'fa-file-pen', 'color' => 'from-rose-500 to-rose-700', 'border' => 'border-rose-200', 'stepBg' => 'bg-rose-100 text-rose-700',
                                    'title' => '9. Cara Mengisi Catatan Raport / Deskripsi Mapel',
                                    'steps' => [
                                        'Sidebar Akademik → Raport → Input Catatan Mapel.',
                                        'Pilih kelas, mapel, semester.',
                                        'Anda bisa menulis deskripsi naratif per siswa (minimal 3 kalimat sesuai Capaian Kompetensi).',
                                        'Tombol Simpan Otomatis (auto-save) setiap 30 detik, atau klik Simpan All.',
                                        'Koordinasi dengan Wali Kelas untuk catatan umum.',
                                    ],
                                ],
                                [
                                    'icon' => 'fa-file-arrow-down', 'color' => 'from-amber-500 to-orange-600', 'border' => 'border-amber-200', 'stepBg' => 'bg-amber-100 text-amber-700',
                                    'title' => '10. Cara Melihat & Mengunduh Raport Kelas Yang Anda Ajar',
                                    'steps' => [
                                        'Sidebar Akademik → Raport → Cek Daftar Raport.',
                                        'Anda hanya bisa melihat raport kelas yang Anda ajar / Anda sebagai Wali Kelas.',
                                        'Filter: Kelas + Semester.',
                                        'Tombol Lihat: buka preview PDF.',
                                        'Tombol Unduh ZIP: download semua raport sekaligus.',
                                    ],
                                ],
                                [
                                    'icon' => 'fa-ellipsis', 'color' => 'from-slate-600 to-slate-800', 'border' => 'border-slate-300', 'stepBg' => 'bg-slate-200 text-slate-700',
                                    'title' => '11. Fitur Lainnya: Pengumuman, FAQ, Notifikasi, Lapor Masalah',
                                    'steps' => [
                                        '🔔 IKON LONCENG: Selalu periksa! Isinya bisa: Jadwal berubah, Pengumuman Admin, Reset Password jika Admin ubah, dll. Klik notifikasi → auto mark as read + badge berkurang.',
                                        '📢 Pengumuman: Sidebar Pengumuman. Baca info terbaru (Rapat, Libur, Ujian, dll).',
                                        '❓ FAQ: Bantuan > FAQ. Jawaban untuk pertanyaan umum (lupa password, akun pending, dll).',
                                        '📜 Kebijakan Sistem: Bantuan > Kebijakan. Baca aturan privasi data, keamanan akun, sanksi pelanggaran.',
                                        '📥 Laporkan Masalah: Bantuan > Laporkan Masalah. Jika menemukan bug / ada data salah / butuh bantuan: Pilih kategori → isi Subject → Deskripsi detail → lampirkan screenshoot (max 5MB) → Kirim. Admin segera dapat notifikasi dan merespon status (Open/InProgress/Resolved/Closed). Anda mendapat NOTIFIKASI BALASAN admin di lonceng.',
                                    ],
                                ],
                            ];
                        @endphp
                        @foreach($guruSections as $s)
                        <div class="glass-card rounded-3xl p-7 step-card border-l-4 {{ $s['border'] }} hover:shadow-md">
                            <div class="flex items-start gap-5 mb-6">
                                <div class="w-14 h-14 rounded-2xl bg-gradient-to-br {{ $s['color'] }} flex items-center justify-center text-white shadow-md flex-shrink-0">
                                    <i class="fas {{ $s['icon'] }} text-xl"></i>
                                </div>
                                <h3 class="text-xl font-bold text-slate-800 pt-3">{{ $s['title'] }}</h3>
                            </div>
                            <div class="ml-4 md:ml-20 space-y-3">
                                @foreach($s['steps'] as $i => $step)
                                <div class="flex items-start gap-4 p-4 rounded-2xl bg-slate-50/70 hover:bg-slate-50 transition-colors">
                                    <div class="flex-shrink-0 w-8 h-8 rounded-xl {{ $s['stepBg'] }} font-bold text-sm flex items-center justify-center">{{ $i + 1 }}</div>
                                    <p class="text-sm text-slate-700 font-medium leading-relaxed pt-1">{{ $step }}</p>
                                </div>
                                @endforeach
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>

                {{-- TAB SISWA --}}
                <div id="tab-siswa" class="tab-panel">
                    <div class="glass-card rounded-3xl p-8 md:p-10 mb-6 bg-gradient-to-br from-purple-500/5 to-transparent border-t-4 border-purple-500">
                        <div class="flex flex-wrap items-center gap-5 mb-2">
                            <div class="w-16 h-16 rounded-3xl bg-gradient-to-br from-purple-500 to-purple-600 flex items-center justify-center text-white shadow-xl shadow-purple-500/30">
                                <i class="fas fa-user-graduate text-2xl"></i>
                            </div>
                            <div>
                                <h2 class="text-3xl font-extrabold text-slate-800">Panduan Siswa</h2>
                                <p class="text-slate-500 font-medium mt-1">11 Materi Standar Peran: Belajar, Lihat Akademik, Raport</p>
                            </div>
                        </div>
                    </div>
                    <div class="space-y-4">
                        @php
                            $siswaSections = [
                                [
                                    'icon' => 'fa-user-plus', 'color' => 'from-emerald-500 to-green-600', 'border' => 'border-emerald-200', 'stepBg' => 'bg-emerald-100 text-emerald-700',
                                    'title' => '1. Cara Registrasi Sebagai Siswa',
                                    'steps' => [
                                        'Buka website SIAKAD sekolah → tombol REGISTER di pojok kanan atas.',
                                        'Pilih kartu HIJAU: **Saya ingin mendaftar sebagai Siswa**.',
                                        'Isi form: Nama Lengkap, Username (unik, hanya huruf/angka), Password (min 8 karakter), Konfirmasi Password, Email (opsional, tapi jika diisi harus valid), No HP Orang Tua / Wali, Alamat, **Jenis Kelamin (wajib siswa)**, **Kelas (wajib pilih)**, dsb.',
                                        'Klik Kirim Registrasi.',
                                        'User Anda dibuat dengan status PENDING. Semua ADMIN dapat notifikasi di lonceng: "Registrasi Siswa Baru dan menunggu verifikasi".',
                                        'Tunggu verifikasi Admin (maksimal 1x24 jam). Coba login setelah itu. Jika Anda diterima → status Active, BISA login. Jika ditolak → ada notif alasan penolakan.',
                                    ],
                                ],
                                [
                                    'icon' => 'fa-right-to-bracket', 'color' => 'from-blue-500 to-blue-700', 'border' => 'border-blue-200', 'stepBg' => 'bg-blue-100 text-blue-700',
                                    'title' => '2. Cara Login Siswa',
                                    'steps' => [
                                        'Buka halaman Login (masukkan URL SIAKAD / Login link).',
                                        'Isi Username dan Password Anda (JANGAN memakai NISN di kolom Username. NISN = data admin; jika belum punya → diset NULL oleh sistem).',
                                        'Klik tombol Login.',
                                        'Sistem memvalidasi Rate Limit 5x/60 detik per username + IP. Jika salah >5 → tunggu 1 menit lagi.',
                                        'Jika akun PENDING/REJECTED/INACTIVE → ditolak dengan pesan "Akun belum aktif / ditolak / dinonaktifkan". Silakan hubungi Admin melalui orang tua / Bantuan > Lapor Masalah.',
                                        'Jika sukses → Masuk Dashboard Siswa, widget: Total Mapel, Jadwal Hari Ini, Rata-rata Nilai, Tombol Cepat (Lihat Nilai, Jadwal, Raport).',
                                    ],
                                ],
                                [
                                    'icon' => 'fa-right-from-bracket', 'color' => 'from-slate-600 to-slate-800', 'border' => 'border-slate-200', 'stepBg' => 'bg-slate-100 text-slate-700',
                                    'title' => '3. Cara Logout Yang Aman',
                                    'steps' => [
                                        'Avatar pojok kanan atas → dropdown Logout.',
                                        'Session dihapus total, ID session diganti baru (menghindari session hijacking).',
                                        'Redirect ke Login. Header NoCache → tombol BACK tidak bisa menampilkan dashboard Anda di komputer umum.',
                                        'Sangat disarankan logout sebelum meninggalkan Lab Komputer / Perpustakaan / pinjam temen HP.',
                                    ],
                                ],
                                [
                                    'icon' => 'fa-id-card', 'color' => 'from-indigo-500 to-blue-600', 'border' => 'border-indigo-200', 'stepBg' => 'bg-indigo-100 text-indigo-700',
                                    'title' => '4. Cara Melihat & Mengubah Profil Diri',
                                    'steps' => [
                                        'Sidebar Profil Saya: menampilkan Nama Lengkap, NISN (jika ada), NIS, Kelas, JK, Tempat/Tanggal Lahir, Alamat, No HP Ortu, Nama Ayah/Ibu.',
                                        'Tombol Ubah Profil: Anda dapat mengubah Nama (otomatis sinkron users.name), No HP Pribadi, Alamat Tinggal. Klik Simpan.',
                                        'Tombol Ubah Password: masukkan Password LAMA → Password BARU (disarankan campuran huruf+angka+simbol, minimal 10). Simpan.',
                                        'KOLOM KELAS DAN NISN TIDAK BISA DIUBAH SENDIRI: harus melalui Admin (ajukan perubahan via Bantuan > Lapor Masalah → kategori Data Akademik + lampirkan bukti).',
                                        'Foto Profil: Anda bisa upload foto selfie terbaru (max 2MB, JPG/PNG).',
                                    ],
                                ],
                                [
                                    'icon' => 'fa-book-open', 'color' => 'from-emerald-500 to-green-600', 'border' => 'border-emerald-200', 'stepBg' => 'bg-emerald-100 text-emerald-700',
                                    'title' => '5. Cara Melihat Nilai Akademik',
                                    'steps' => [
                                        'Sidebar Akademik → **Nilai**.',
                                        'Filter: Pilih Semester (Ganjil / Genap) dan Tahun Ajaran (2025/2026).',
                                        'Tampilan: Tabel per Mapel. Kolom: Nilai Tugas (1,2,3), Nilai Harian, UTS, UAS, Rata-rata Akhir, KKM, Keterangan (TUNTAS / TIDAK TUNTAS), Rangking (jika diaktifkan sekolah).',
                                        'Klik judul mapel → Detail nilai (history input, catatan guru, deskripsi).',
                                        'Setiap kali Guru / Admin memasukkan / mengubah nilai Anda → Anda mendapat NOTIFIKASI di lonceng: "Nilai Baru Tersedia: {Kategori} {Mapel} — silakan cek".',
                                        'Jika nilai tidak muncul: cek filter semester, atau tanya ke Guru Mapel / lapor ke Admin via Bantuan.',
                                    ],
                                ],
                                [
                                    'icon' => 'fa-calendar-day', 'color' => 'from-blue-500 to-cyan-600', 'border' => 'border-blue-200', 'stepBg' => 'bg-blue-100 text-blue-700',
                                    'title' => '6. Cara Melihat Jadwal Pelajaran',
                                    'steps' => [
                                        'Dashboard: Widget Jadwal Pelajaran Hari Ini (menampilkan hari ini hanya mapel kelas Anda).',
                                        'Sidebar Akademik → **Jadwal Pelajaran**.',
                                        'Tampilan: Hari Senin s/d Jumat, Jam ke, Ruangan, Guru Pengampu.',
                                        'Tombol Download PDF jadwal untuk dicetak ditempel buku catatan / HP homescreen.',
                                        'Jika Admin merubah jadwal (menambah jam, pindah guru, dll) → Anda menerima NOTIFIKASI lonceng: "Jadwal Pelajaran diperbarui: {Mapel} hari X jam J kelas K". Klik notif → auto ke halaman Jadwal.',
                                    ],
                                ],
                                [
                                    'icon' => 'fa-clipboard-check', 'color' => 'from-amber-500 to-yellow-500', 'border' => 'border-amber-200', 'stepBg' => 'bg-amber-100 text-amber-700',
                                    'title' => '7. Cara Melihat Rekap Absensi Harian',
                                    'steps' => [
                                        'Sidebar Akademik → Absensi.',
                                        'Rekap Bulanan: Total Hadir, Sakit, Ijin, Alpha, Persentase. Kriteria ketidakhadiran sesuai peraturan sekolah (misal alpa >3 kali → surat panggilan ortu).',
                                        'Rekap Harian: Klik detail tanggal → Status kehadiran Anda beserta catatan Guru.',
                                        'Jika ada ketidaksesuaian: "Saya HADIR tapi tercatat ALPHA" → konfirmasi ke Wali Kelas / Guru Piket, lalu laporkan ke Admin via Bantuan > Lapor Masalah (kategori Data Akademik), dengan bukti: foto surat ijin/sakit.',
                                    ],
                                ],
                                [
                                    'icon' => 'fa-qrcode', 'color' => 'from-purple-500 to-purple-700', 'border' => 'border-purple-200', 'stepBg' => 'bg-purple-100 text-purple-700',
                                    'title' => '8. Cara Absensi QR (Jika Sekolah Menggunakan)',
                                    'steps' => [
                                        'Datang ke sekolah TEPAT WAKTU sebelum bel masuk.',
                                        'Login SIAKAD, Sidebar Profil → Generate QR Code Saya. Tunjukkan layar HP ke Guru Piket / scanner QR di gerbang.',
                                        'Status barcode hanya berlaku 30 detik (diganti otomatis anti share).',
                                        'Jika HP lowbat / tidak bawa: lapor ke Guru Piket untuk input manual.',
                                        'Setelah ter-scan → status langsung berubah "Hadir".',
                                    ],
                                ],
                                [
                                    'icon' => 'fa-file-contract', 'color' => 'from-cyan-500 to-blue-600', 'border' => 'border-cyan-200', 'stepBg' => 'bg-cyan-100 text-cyan-700',
                                    'title' => '9. Cara Melihat Pengumuman & Notifikasi Akademik',
                                    'steps' => [
                                        '🏮 IKON LONCENG: Selalu periksa! Notifikasi penting: Nilai baru, Jadwal diperbarui, Raport tersedia, Pengumuman Admin, Respon Laporan Masalah Anda.',
                                        'Klik angka badge merah → panel notifikasi terbuka. Klik salah satu item → auto mark as read (badge berkurang).',
                                        '📢 Sidebar Pengumuman → list pengumuman terbaru. Baca sampai selesai! (Rapat, Libur, UTS/UAS, Pendaftaran Ekstrakurikuler, dll).',
                                    ],
                                ],
                                [
                                    'icon' => 'fa-file-download', 'color' => 'from-purple-500 to-pink-600', 'border' => 'border-purple-200', 'stepBg' => 'bg-purple-100 text-purple-700',
                                    'title' => '10. Cara Melihat & Mengunduh Raport',
                                    'steps' => [
                                        'Sidebar Akademik → **Raport**.',
                                        'Pilih filter: Tahun Ajaran (2025/2026) + Semester (Ganjil/Genap). Klik Tampilkan Raport.',
                                        'Anda melihat: Cover (Logo, Nama, NIS/NISN, Kelas, Fotonya), Identitas KepSek & Wali Kelas + TTD digital.',
                                        'Daftar Nilai + Capaian Kompetensi per mapel (narasi dari Guru Mapel).',
                                        'Rekap Absensi, Catatan Wali Kelas, Jumlah SKS / Jam Pelajaran.',
                                        'Tombol **Unduh PDF Raport** → file PDF disimpan ke HP / komputer → bisa dicetak / dikirim Ortu via WA.',
                                        'Jika Admin mempublish raport → Anda menerima NOTIFIKASI lonceng: "Raport Semester {X} telah tersedia. Silakan unduh."',
                                    ],
                                ],
                                [
                                    'icon' => 'fa-headset', 'color' => 'from-amber-500 to-orange-500', 'border' => 'border-amber-200', 'stepBg' => 'bg-amber-100 text-amber-700',
                                    'title' => '11. Cara Lapor Masalah & Hubungi Admin (Kebijakan, FAQ, Bantuan)',
                                    'steps' => [
                                        '❓ FAQ: Bantuan → FAQ. Cari jawaban cepat: "Bagaimana jika lupa password?" "Mengapa akun belum bisa login?" dll. Sudah disediakan jawaban 7 pertanyaan umum beserta role-specific (Admin/Guru/Siswa).',
                                        '📜 Kebijakan Sistem: Bantuan → Kebijakan. Baca 6 aturan wajib (jaga username pass, jangan pinjam akun, jangan akses data luar hak, dll) + Kebijakan Privasi + Syarat Ketentuan.',
                                        '📥 Lapor Masalah (PENTING): Bantuan → Lapor Masalah. Gunakan jika menemu kendala: (a) Bug error sistem, (b) Saran ide fitur, (c) Masalah akun/login, (d) Data Akademik salah (nilai/kelas), (e) Lainnya. Isi: Kategori, Subject, Deskripsi detail (langkah demi langkah jika bug), Lampirkan Screenshoot (max 5MB). Kirim!',
                                        'Riwayat Laporan Anda muncul di bawah form, beserta status (Open/In Progress/Resolved).',
                                        'Jika Admin merespon → Anda mendapat NOTIFIKASI di lonceng "Laporan Anda Diperbarui" dan RESPON ADMIN muncul sebagai badge hijau di card laporan Anda.',
                                    ],
                                ],
                            ];
                        @endphp
                        @foreach($siswaSections as $s)
                        <div class="glass-card rounded-3xl p-7 step-card border-l-4 {{ $s['border'] }} hover:shadow-md">
                            <div class="flex items-start gap-5 mb-6">
                                <div class="w-14 h-14 rounded-2xl bg-gradient-to-br {{ $s['color'] }} flex items-center justify-center text-white shadow-md flex-shrink-0">
                                    <i class="fas {{ $s['icon'] }} text-xl"></i>
                                </div>
                                <h3 class="text-xl font-bold text-slate-800 pt-3">{{ $s['title'] }}</h3>
                            </div>
                            <div class="ml-4 md:ml-20 space-y-3">
                                @foreach($s['steps'] as $i => $step)
                                <div class="flex items-start gap-4 p-4 rounded-2xl bg-slate-50/70 hover:bg-slate-50 transition-colors">
                                    <div class="flex-shrink-0 w-8 h-8 rounded-xl {{ $s['stepBg'] }} font-bold text-sm flex items-center justify-center">{{ $i + 1 }}</div>
                                    <p class="text-sm text-slate-700 font-medium leading-relaxed pt-1">{{ $step }}</p>
                                </div>
                                @endforeach
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>

                {{-- TAB KEPALA SEKOLAH --}}
                <div id="tab-kepala" class="tab-panel">
                    <div class="glass-card rounded-3xl p-8 md:p-10 mb-6 bg-gradient-to-br from-amber-500/5 to-transparent border-t-4 border-amber-500">
                        <div class="flex flex-wrap items-center gap-5 mb-2">
                            <div class="w-16 h-16 rounded-3xl bg-gradient-to-br from-amber-500 to-orange-500 flex items-center justify-center text-white shadow-xl shadow-amber-500/30">
                                <i class="fas fa-user-tie text-2xl"></i>
                            </div>
                            <div>
                                <h2 class="text-3xl font-extrabold text-slate-800">Panduan Kepala Sekolah</h2>
                                <p class="text-slate-500 font-medium mt-1">11 Materi Standar Peran: Monitoring, Validasi, Laporan Akademik</p>
                            </div>
                        </div>
                    </div>
                    <div class="space-y-4">
                        @php
                            $kepsekSections = [
                                [
                                    'icon' => 'fa-user-plus', 'color' => 'from-emerald-500 to-green-600', 'border' => 'border-emerald-200', 'stepBg' => 'bg-emerald-100 text-emerald-700',
                                    'title' => '1. Cara Registrasi Akun Kepala Sekolah',
                                    'steps' => [
                                        'Jika Anda Kepala Sekolah yang baru pertama kali pakai SIAKAD, buka beranda → tombol REGISTER.',
                                        'Pilih kartu WARNA KUNING / OREN: **Saya ingin mendaftar sebagai Kepala Sekolah**.',
                                        'Isi formulir: Nama Lengkap, Username, Password, Konfirmasi, Email, No HP, Alamat, JK. Klik Kirim.',
                                        'Status otomatis PENDING. Admin verifikasi data Anda. Setelah disetujui (status Active) → dapat login.',
                                        'Anda juga dapat dibuatkan akun oleh Admin yang sudah ada langsung (via menu User > Tambah User role Kepala Sekolah).',
                                    ],
                                ],
                                [
                                    'icon' => 'fa-right-to-bracket', 'color' => 'from-amber-500 to-orange-600', 'border' => 'border-amber-200', 'stepBg' => 'bg-amber-100 text-amber-700',
                                    'title' => '2. Cara Login Kepala Sekolah',
                                    'steps' => [
                                        'Buka Login → Username + Password.',
                                        'Klik Login. Masuk Dashboard Kepsek.',
                                        'Dashboard menampilkan: Total Siswa Aktif, Total Guru, Total Kelas, Rata-rata Nilai Sekolah, Persentase Kehadiran Bulan Ini, Jumlah Pengumuman Aktif, Jumlah Laporan Masalah.',
                                        'Widget Ikon Lonceng: Notifikasi dari Admin, Respon Laporan Masalah (jika Kepsek melapor), Pengumuman baru.',
                                    ],
                                ],
                                [
                                    'icon' => 'fa-right-from-bracket', 'color' => 'from-slate-600 to-slate-800', 'border' => 'border-slate-200', 'stepBg' => 'bg-slate-100 text-slate-700',
                                    'title' => '3. Cara Logout Yang Aman',
                                    'steps' => [
                                        'Avatar → Logout. Session flush + invalidate + regenerate ID.',
                                        'Redirect ke Login. Anti cache: tidak bisa kembali via tombol BACK.',
                                        'Penting untuk log out jika menggunakan laptop sekolah / ruang TU bersama.',
                                    ],
                                ],
                                [
                                    'icon' => 'fa-users', 'color' => 'from-blue-500 to-indigo-600', 'border' => 'border-blue-200', 'stepBg' => 'bg-blue-100 text-blue-700',
                                    'title' => '4. Cara Melihat Data Siswa & Guru Keseluruhan',
                                    'steps' => [
                                        'Sidebar Monitoring → Data Siswa / Data Guru.',
                                        'Tampilan list: Nama, Kelas, JK, No HP, Mapel (guru), Status Aktif.',
                                        'Filter: Per Kelas, Per Tingkat, Per Mapel, Search nama.',
                                        'Klik baris → Detail data pribadi lengkap.',
                                        'Edit per data hanya boleh oleh Admin. Kepsek saran perubahan via Bantuan / Pengumuman ke Admin TU.',
                                    ],
                                ],
                                [
                                    'icon' => 'fa-user-check', 'color' => 'from-emerald-500 to-teal-600', 'border' => 'border-emerald-200', 'stepBg' => 'bg-emerald-100 text-emerald-700',
                                    'title' => '5. Cara Memantau Verifikasi Pengguna',
                                    'steps' => [
                                        'Sidebar Monitoring → Verifikasi Pengguna.',
                                        'Melihat statistik: Total Pending, Total Active, Total Rejected.',
                                        'Anda bisa melihat list nama user pending sebagai informasi (tidak perlu approve; approval resmi dilakukan Admin TU sesuai petunjuk Anda).',
                                        'Jika ada user seharusnya sudah di-approve tapi masih pending → notifikasi Admin via chat WhatsApp.',
                                    ],
                                ],
                                [
                                    'icon' => 'fa-chart-bar', 'color' => 'from-blue-600 to-blue-800', 'border' => 'border-blue-300', 'stepBg' => 'bg-blue-100 text-blue-700',
                                    'title' => '6. Cara Melihat Rekap Nilai Akademik',
                                    'steps' => [
                                        'Sidebar Monitoring → Monitoring Nilai.',
                                        'Filter: Tahun Ajaran, Semester, Tingkat Kelas, Kelas, Mapel.',
                                        'Grafik & Tabel: Rata-rata kelas, Mapel dengan rata-rata terendah, Mapel dengan rata-rata tertinggi, Persentase ketuntasan KKM per mapel.',
                                        'Klik bar kelas → detail per siswa rangking.',
                                        'Data ini untuk Rapat Pleno, Evaluasi KBM, Presentasi Dinas Pendidikan.',
                                    ],
                                ],
                                [
                                    'icon' => 'fa-calendar-alt', 'color' => 'from-indigo-500 to-indigo-700', 'border' => 'border-indigo-200', 'stepBg' => 'bg-indigo-100 text-indigo-700',
                                    'title' => '7. Cara Melihat Jadwal Pelajaran Sekolah',
                                    'steps' => [
                                        'Sidebar Monitoring → Jadwal Sekolah.',
                                        'Filter Per Guru / Per Kelas / Per Ruangan.',
                                        'Melihat konflik jadwal (guru bertabrakan, ruangan dipakai 2 mapel), Admin yang menyelesaikan. Anda memberikan arahan.',
                                        'Ekspor PDF: Jadwal per kelas, untuk dikirim ke grup WA guru / wali murid.',
                                    ],
                                ],
                                [
                                    'icon' => 'fa-clipboard-list', 'color' => 'from-emerald-600 to-teal-700', 'border' => 'border-emerald-300', 'stepBg' => 'bg-emerald-100 text-emerald-700',
                                    'title' => '8. Cara Memantau Absensi Siswa & Guru',
                                    'steps' => [
                                        'Sidebar Monitoring → Absensi.',
                                        '2 Tab: Rekap Absensi Siswa (per kelas, per bulan) & Rekap Absensi Guru & Tendik.',
                                        'Siswa dengan Alpha > 3 hari → flag peringatan merah.',
                                        'Guru dengan jam mengajar absen tidak masuk tanpa keterangan → flag review BK.',
                                        'Export laporan bulanan: Excel / PDF untuk Arsip & Dinas.',
                                    ],
                                ],
                                [
                                    'icon' => 'fa-stamp', 'color' => 'from-amber-600 to-orange-700', 'border' => 'border-amber-300', 'stepBg' => 'bg-amber-100 text-amber-700',
                                    'title' => '9. Cara Memverifikasi & Tanda Tangan Digital Raport',
                                    'steps' => [
                                        'Sidebar Akademik → Verifikasi Raport.',
                                        'Daftar raport yang sudah di-generate Admin + Wali Kelas tapi BELUM ditandatangani Kepsek.',
                                        'Klik Detail → review isi: cek nilai, keabsahan, cap, data siswa.',
                                        'Klik **Validasi & Tanda Tangan** → Nama Kepala Sekolah & TTD digital tercetak di cover raport.',
                                        'Setelah tanda tangan → Siswa dapat unduh PDF resminya.',
                                    ],
                                ],
                                [
                                    'icon' => 'fa-file-lines', 'color' => 'from-slate-600 to-slate-800', 'border' => 'border-slate-300', 'stepBg' => 'bg-slate-200 text-slate-700',
                                    'title' => '10. Cara Mengunduh Laporan Akademik',
                                    'steps' => [
                                        'Sidebar Laporan → Laporan Akademik.',
                                        'Filter Periode: Semester / Tahun Ajaran.',
                                        'Pilih opsi laporan: (a) Leger Nilai, (b) Rekap Absensi, (c) Statistik Kelulusan, (d) Distribusi Karyawan Guru.',
                                        'Klik Generate → Lihat Preview → Download Excel / Cetak PDF.',
                                        'File laporan untuk: Rapat Komite, Rapat Ortu, Dinas Pendidikan, Arsip Sekolah.',
                                    ],
                                ],
                                [
                                    'icon' => 'fa-bullhorn', 'color' => 'from-rose-500 to-pink-600', 'border' => 'border-rose-200', 'stepBg' => 'bg-rose-100 text-rose-700',
                                    'title' => '11. Fitur Lainnya: Pengumuman, Notifikasi, FAQ, Kebijakan, Laporkan IT Support',
                                    'steps' => [
                                        '📢 Pengumuman: Sidebar Pengumuman → Anda bisa melihat semua pengumuman yang dibuat Admin. Jika ada pengumuman baru untuk Guru / Siswa → Anda juga mendapat notifikasi.',
                                        '🔔 Notifikasi: Ikon Lonceng Dashboard selalu cek! Bila Admin mempublish raport / laporan → Anda diberi tahu.',
                                        '❓ FAQ & 📜 Kebijakan: Bantuan → FAQ & Kebijakan. Anda bisa baca SOP aturan sistem dan mereview isi untuk disempurnakan (beri saran ke Admin via Lapor Masalah kategori Saran).',
                                        '📥 Lapor Masalah IT Support: Jika Anda menemukan error sistem / fitur belum sesuai kebutuhan → Bantuan > Laporkan Masalah → pilih Bug / Saran → tim Admin TU segera notifikasi dan tindak lanjuti.',
                                        '✅ Verifikasi Laporan Masalah: Anda juga dapat melihat statistik laporan yang masuk per kategori dan kecepatan respon Admin.',
                                    ],
                                ],
                            ];
                        @endphp
                        @foreach($kepsekSections as $s)
                        <div class="glass-card rounded-3xl p-7 step-card border-l-4 {{ $s['border'] }} hover:shadow-md">
                            <div class="flex items-start gap-5 mb-6">
                                <div class="w-14 h-14 rounded-2xl bg-gradient-to-br {{ $s['color'] }} flex items-center justify-center text-white shadow-md flex-shrink-0">
                                    <i class="fas {{ $s['icon'] }} text-xl"></i>
                                </div>
                                <h3 class="text-xl font-bold text-slate-800 pt-3">{{ $s['title'] }}</h3>
                            </div>
                            <div class="ml-4 md:ml-20 space-y-3">
                                @foreach($s['steps'] as $i => $step)
                                <div class="flex items-start gap-4 p-4 rounded-2xl bg-slate-50/70 hover:bg-slate-50 transition-colors">
                                    <div class="flex-shrink-0 w-8 h-8 rounded-xl {{ $s['stepBg'] }} font-bold text-sm flex items-center justify-center">{{ $i + 1 }}</div>
                                    <p class="text-sm text-slate-700 font-medium leading-relaxed pt-1">{{ $step }}</p>
                                </div>
                                @endforeach
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>

    <footer class="relative z-10 bg-slate-900 text-slate-300 py-16 border-t border-slate-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid md:grid-cols-4 gap-12 mb-12">
                <div class="col-span-1 md:col-span-2">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="w-10 h-10 rounded-xl bg-blue-600 flex items-center justify-center shadow-lg shadow-blue-600/20">
                            <i class="fas fa-graduation-cap text-white text-lg"></i>
                        </div>
                        <span class="text-2xl font-bold text-white tracking-tight">SIAKAD SMAN 1</span>
                    </div>
                    <p class="text-slate-400 text-sm leading-relaxed max-w-sm mb-6">
                        Sistem Informasi Akademik SMA Negeri 1 Tuhemberua. Platform digital terpadu untuk memudahkan akses informasi, administrasi, dan kegiatan akademik sekolah secara transparan dan efisien.
                    </p>
                    <div class="flex gap-4">
                        <a href="#" class="w-10 h-10 rounded-full bg-slate-800 flex items-center justify-center hover:bg-blue-600 hover:text-white transition-all"><i class="fab fa-facebook-f"></i></a>
                        <a href="#" class="w-10 h-10 rounded-full bg-slate-800 flex items-center justify-center hover:bg-pink-600 hover:text-white transition-all"><i class="fab fa-instagram"></i></a>
                        <a href="#" class="w-10 h-10 rounded-full bg-slate-800 flex items-center justify-center hover:bg-red-600 hover:text-white transition-all"><i class="fab fa-youtube"></i></a>
                    </div>
                </div>
                
                <div>
                    <h4 class="text-white font-bold mb-6 uppercase text-xs tracking-wider">Tautan Cepat</h4>
                    <ul class="space-y-3 text-sm">
                        <li><a href="{{ url('/') }}#beranda" class="hover:text-blue-400 transition-colors flex items-center gap-2"><i class="fas fa-chevron-right text-xs text-slate-600"></i> Beranda</a></li>
                        <li><a href="{{ url('/') }}#fitur" class="hover:text-blue-400 transition-colors flex items-center gap-2"><i class="fas fa-chevron-right text-xs text-slate-600"></i> Fitur</a></li>
                        <li><a href="{{ url('/') }}#pengumuman" class="hover:text-blue-400 transition-colors flex items-center gap-2"><i class="fas fa-chevron-right text-xs text-slate-600"></i> Pengumuman</a></li>
                        <li><a href="{{ route('bantuan.panduan') }}" class="hover:text-blue-400 transition-colors flex items-center gap-2"><i class="fas fa-chevron-right text-xs text-slate-600"></i> Panduan Penggunaan</a></li>
                        <li><a href="{{ route('bantuan.faq') }}" class="hover:text-blue-400 transition-colors flex items-center gap-2"><i class="fas fa-chevron-right text-xs text-slate-600"></i> FAQ</a></li>
                        <li><a href="{{ route('bantuan.kebijakan') }}" class="hover:text-blue-400 transition-colors flex items-center gap-2"><i class="fas fa-chevron-right text-xs text-slate-600"></i> Kebijakan Sistem</a></li>
                        <li><a href="{{ route('bantuan.lapor') }}" class="hover:text-blue-400 transition-colors flex items-center gap-2"><i class="fas fa-chevron-right text-xs text-slate-600"></i> Laporkan Masalah</a></li>
                        <li><a href="{{ route('login') }}" class="hover:text-blue-400 transition-colors flex items-center gap-2"><i class="fas fa-chevron-right text-xs text-slate-600"></i> Login Guru/Siswa</a></li>
                    </ul>
                </div>
                
                <div>
                    <h4 class="text-white font-bold mb-6 uppercase text-xs tracking-wider">Hubungi Kami</h4>
                    <ul class="space-y-4 text-sm">
                        <li class="flex items-start gap-3">
                            <i class="fas fa-map-marker-alt mt-1 text-blue-500"></i>
                            <span>Silima Banua, Kec. Tuhemberua, Kabupaten Nias Utara, Sumatera Utara 22852</span>
                        </li>
                        <li class="flex items-center gap-3">
                            <i class="fas fa-phone text-blue-500"></i>
                            <span>(0639) 1234567</span>
                        </li>
                        <li class="flex items-center gap-3">
                            <i class="fas fa-envelope text-blue-500"></i>
                            <span>info@sman1tuhemberua.sch.id</span>
                        </li>
                    </ul>
                </div>
            </div>
            
            <div class="border-t border-slate-800 pt-8 flex flex-col md:flex-row justify-between items-center gap-4 text-xs text-slate-500">
                <p>&copy; {{ date('Y') }} SMA Negeri 1 Tuhemberua. All rights reserved.</p>
                <div class="flex gap-6">
                    <a href="{{ route('bantuan.kebijakan') }}" class="hover:text-white transition-colors">Kebijakan Sistem</a>
                    <a href="{{ route('bantuan.faq') }}" class="hover:text-white transition-colors">FAQ</a>
                </div>
            </div>
        </div>
    </footer>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const mb = document.getElementById('mobileMenuBtn');
            if (mb) mb.addEventListener('click', function() {
                document.getElementById('mobileMenu').classList.toggle('hidden');
            });
            const btn = document.getElementById('dropdownBantuanBtn');
            const menu = document.getElementById('dropdownBantuanMenu');
            const icon = document.getElementById('dropdownBantuanIcon');
            if (btn && menu) {
                btn.addEventListener('click', function(e) {
                    e.stopPropagation();
                    menu.classList.toggle('hidden');
                    if (icon) icon.style.transform = menu.classList.contains('hidden') ? 'rotate(0deg)' : 'rotate(180deg)';
                });
                document.addEventListener('click', function(e) {
                    if (!menu.contains(e.target) && !btn.contains(e.target)) {
                        menu.classList.add('hidden');
                        if (icon) icon.style.transform = 'rotate(0deg)';
                    }
                });
            }
        });
        function switchTab(tab) {
            document.querySelectorAll('.tab-panel').forEach(p => p.classList.remove('active'));
            document.querySelectorAll('.tab-btn').forEach(b => {
                b.classList.remove('bg-emerald-50', 'border-emerald-200', 'text-emerald-700');
                b.classList.add('border-transparent');
                const firstP = b.querySelector('p:first-of-type');
                if (firstP) { firstP.classList.add('text-slate-800'); }
            });
            document.getElementById('tab-' + tab).classList.add('active');
            const btn = document.getElementById('tab-btn-' + tab);
            btn.classList.add('bg-emerald-50', 'border-emerald-200', 'text-emerald-700');
            window.scrollTo({ top: 0, behavior: 'smooth' });
        }
    </script>
</body>
</html>
