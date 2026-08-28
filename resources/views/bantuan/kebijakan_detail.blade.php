<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $kebijakan->title }} - SIAKAD SMA Negeri 1 Tuhemberua</title>
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
    </style>
</head>
<body class="min-h-screen bg-slate-900 text-slate-800 antialiased relative overflow-x-hidden">

    <div class="fixed inset-0 z-0">
        <img src="https://images.unsplash.com/photo-1523050854058-8df90110c9f1?ixlib=rb-1.2.1&auto=format&fit=crop&w=1950&q=80" alt="Background" class="w-full h-full object-cover opacity-15 mix-blend-overlay">
        <div class="absolute inset-0 bg-gradient-to-b from-slate-900 via-slate-900/95 to-slate-900"></div>
    </div>

    <div class="fixed blob bg-purple-600 w-96 h-96 rounded-full -top-20 right-0 animate-pulse pointer-events-none"></div>
    <div class="fixed blob bg-emerald-500 w-72 h-72 rounded-full bottom-0 left-10 animate-pulse pointer-events-none" style="animation-delay: 2s;"></div>

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
                <a href="{{ route('bantuan.index') }}" class="block px-4 py-3 rounded-xl text-sm font-semibold text-slate-600 hover:text-blue-600 hover:bg-slate-50">Bantuan</a>
                <a href="{{ route('bantuan.panduan') }}" class="block px-4 py-3 rounded-xl text-sm font-semibold text-slate-600 hover:text-blue-600 hover:bg-slate-50">Panduan</a>
                <a href="{{ route('bantuan.faq') }}" class="block px-4 py-3 rounded-xl text-sm font-semibold text-slate-600 hover:text-blue-600 hover:bg-slate-50">FAQ</a>
                <a href="{{ route('bantuan.kebijakan') }}" class="block px-4 py-3 rounded-xl text-sm font-semibold text-white bg-blue-600">Kebijakan</a>
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

    <section class="relative z-10 pt-32 pb-20 px-4 sm:px-6 lg:px-8 max-w-4xl mx-auto">
        <a href="{{ route('bantuan.kebijakan') }}" class="inline-flex items-center gap-2 text-slate-400 hover:text-white transition-all hover:-translate-x-1 group mb-8">
            <div class="w-11 h-11 rounded-2xl bg-white/5 backdrop-blur-sm flex items-center justify-center border border-white/10 group-hover:bg-white/10 transition-colors">
                <i class="fas fa-arrow-left"></i>
            </div>
            <span class="text-sm font-semibold">Kembali ke Daftar Kebijakan</span>
        </a>

        @php
            $roleBadge = match($kebijakan->for_role) {
                'admin' => ['bg-red-100', 'text-red-700', 'Admin'],
                'guru' => ['bg-blue-100', 'text-blue-700', 'Guru'],
                'siswa' => ['bg-purple-100', 'text-purple-700', 'Siswa'],
                'kepala_sekolah' => ['bg-amber-100', 'text-amber-700', 'Kepala Sekolah'],
                default => ['bg-slate-100', 'text-slate-700', 'Semua Role'],
            };
        @endphp

        <div class="glass-card rounded-[2rem] overflow-hidden shadow-2xl">
            <div class="p-8 md:p-12 bg-gradient-to-br from-purple-500/10 via-emerald-500/5 to-transparent border-b border-slate-100">
                <div class="flex flex-wrap items-center gap-3 mb-6">
                    <span class="inline-flex items-center gap-2 px-4 py-2 rounded-xl text-xs font-bold uppercase tracking-wider {{ $roleBadge[0] }} {{ $roleBadge[1] }}">
                        <i class="fas fa-user-tag mr-1"></i>{{ $roleBadge[2] }}
                    </span>
                    @if($kebijakan->is_active)
                        <span class="inline-flex items-center gap-2 px-4 py-2 rounded-xl text-xs font-bold bg-emerald-100 text-emerald-700">
                            <i class="fas fa-check-circle mr-1"></i>Aktif
                        </span>
                    @endif
                </div>
                <div class="flex items-start gap-5">
                    <div class="flex-shrink-0 w-16 h-16 md:w-20 md:h-20 rounded-3xl bg-gradient-to-br from-purple-500 to-indigo-600 flex items-center justify-center shadow-xl shadow-purple-500/30">
                        <i class="fas fa-file-contract text-white text-2xl md:text-3xl"></i>
                    </div>
                    <div class="flex-1">
                        <h1 class="text-3xl md:text-4xl lg:text-5xl font-extrabold text-slate-800 mb-4 leading-tight">
                            {{ $kebijakan->title }}
                        </h1>
                        <div class="flex flex-wrap items-center gap-4 text-sm text-slate-500 font-medium">
                            <span class="inline-flex items-center gap-2">
                                <i class="fas fa-calendar text-emerald-500"></i>
                                Terakhir diperbarui: <span class="font-bold text-slate-700">{{ $kebijakan->updated_at->format('d F Y') }}</span>
                            </span>
                            <span class="inline-flex items-center gap-2">
                                <i class="fas fa-history text-amber-500"></i>
                                Dibuat: <span class="font-bold text-slate-700">{{ $kebijakan->created_at->format('d F Y') }}</span>
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="p-8 md:p-12">
                <div class="prose prose-slate max-w-none">
                    <div class="text-slate-700 leading-relaxed whitespace-pre-line text-[15px] space-y-4">
                        {!! nl2br(e($kebijakan->content)) !!}
                    </div>
                </div>
            </div>

            <div class="p-8 md:p-10 pt-0">
                <div class="p-6 rounded-3xl bg-gradient-to-r from-emerald-50 to-amber-50 border border-emerald-100/50 flex flex-col sm:flex-row items-start sm:items-center gap-5">
                    <div class="w-14 h-14 rounded-2xl bg-white flex items-center justify-center shadow-sm flex-shrink-0">
                        <i class="fas fa-question-circle text-emerald-600 text-2xl"></i>
                    </div>
                    <div class="flex-1">
                        <h4 class="font-bold text-slate-800 mb-1">Masih ada pertanyaan?</h4>
                        <p class="text-sm text-slate-600">Jika Anda membutuhkan klarifikasi mengenai kebijakan ini, silakan hubungi admin atau laporkan melalui form bantuan.</p>
                    </div>
                    <a href="{{ route('bantuan.lapor') }}" class="inline-flex items-center gap-2 px-6 py-3 bg-gradient-to-r from-emerald-500 to-emerald-600 hover:from-emerald-600 hover:to-emerald-700 text-white rounded-2xl text-sm font-bold transition-all shadow-lg shadow-emerald-500/30 flex-shrink-0">
                        <i class="fas fa-headset"></i>
                        Hubungi Kami
                    </a>
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
    </script>
</body>
</html>
