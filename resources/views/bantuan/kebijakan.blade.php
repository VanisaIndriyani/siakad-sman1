<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kebijakan - SIAKAD SMA Negeri 1 Tuhemberua</title>
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

    <div class="fixed blob bg-purple-600 w-96 h-96 rounded-full top-0 left-0 -translate-x-1/2 -translate-y-1/2 animate-pulse pointer-events-none"></div>
    <div class="fixed blob bg-emerald-500 w-80 h-80 rounded-full bottom-10 right-20 animate-pulse pointer-events-none" style="animation-delay: 1.5s;"></div>

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

    <section class="relative z-10 pt-32 pb-12 px-4 sm:px-6 lg:px-8 max-w-6xl mx-auto">
        <div class="text-center mb-10">
            <span class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-purple-500/10 border border-purple-500/20 text-purple-400 text-xs font-bold uppercase tracking-wider mb-6">
                <i class="fas fa-shield-alt"></i>
                Kebijakan & Peraturan
            </span>
            <h1 class="text-4xl md:text-5xl font-extrabold text-white mb-4 leading-tight">
                Kebijakan
                <span class="bg-gradient-to-r from-purple-400 to-emerald-400 bg-clip-text text-transparent">Sistem</span>
            </h1>
            <p class="text-lg text-slate-400 font-medium max-w-2xl mx-auto">
                Pelajari kebijakan, syarat, dan ketentuan yang berlaku dalam penggunaan sistem akademik SIAKAD.
            </p>
        </div>

        <form action="{{ route('bantuan.kebijakan') }}" method="GET" class="glass-card rounded-3xl p-4 mb-10">
            <div class="flex flex-col lg:flex-row gap-3">
                <div class="relative flex-1">
                    <i class="fas fa-search absolute left-5 top-1/2 -translate-y-1/2 text-slate-400"></i>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari kebijakan berdasarkan judul atau isi..." class="w-full pl-14 pr-5 py-4 bg-slate-50 border border-slate-200 rounded-2xl focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 transition-all outline-none text-sm font-medium">
                </div>
                <select name="for_role" onchange="this.form.submit()" class="border border-slate-200 rounded-2xl px-5 py-4 text-sm focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 bg-slate-50 font-medium">
                    <option value="">Semua Role</option>
                    <option value="admin" {{ request('for_role') == 'admin' ? 'selected' : '' }}>Admin</option>
                    <option value="guru" {{ request('for_role') == 'guru' ? 'selected' : '' }}>Guru</option>
                    <option value="siswa" {{ request('for_role') == 'siswa' ? 'selected' : '' }}>Siswa</option>
                    <option value="kepala_sekolah" {{ request('for_role') == 'kepala_sekolah' ? 'selected' : '' }}>Kepala Sekolah</option>
                </select>
                <button type="submit" class="px-8 py-4 bg-gradient-to-r from-purple-500 to-purple-600 hover:from-purple-600 hover:to-purple-700 text-white rounded-2xl text-sm font-bold transition-all shadow-lg shadow-purple-500/30">
                    <i class="fas fa-search mr-2"></i>Cari
                </button>
            </div>
        </form>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
            @forelse($kebijakans as $kb)
                @php
                    $roleBadge = match($kb->for_role) {
                        'admin' => ['bg-red-100', 'text-red-700', 'Admin'],
                        'guru' => ['bg-blue-100', 'text-blue-700', 'Guru'],
                        'siswa' => ['bg-purple-100', 'text-purple-700', 'Siswa'],
                        'kepala_sekolah' => ['bg-amber-100', 'text-amber-700', 'Kepala Sekolah'],
                        default => ['bg-slate-100', 'text-slate-700', 'Semua Role'],
                    };
                @endphp
                <a href="{{ route('bantuan.kebijakan.show', $kb->slug) }}" class="group glass-card rounded-3xl p-7 hover:shadow-2xl hover:shadow-purple-500/10 transition-all duration-500 hover:-translate-y-1">
                    <div class="flex items-start justify-between mb-4">
                        <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-purple-500 to-indigo-600 flex items-center justify-center shadow-lg shadow-purple-500/30 group-hover:scale-110 group-hover:rotate-3 transition-all duration-500">
                            <i class="fas fa-file-contract text-white text-xl"></i>
                        </div>
                        <span class="inline-flex items-center px-3 py-1.5 rounded-xl text-[10px] font-bold uppercase tracking-wider {{ $roleBadge[0] }} {{ $roleBadge[1] }}">{{ $roleBadge[2] }}</span>
                    </div>
                    <h3 class="text-xl font-bold text-slate-800 mb-3 group-hover:text-purple-600 transition-colors leading-snug">{{ $kb->title }}</h3>
                    <p class="text-sm text-slate-500 mb-5 line-clamp-3 leading-relaxed">
                        {{ \Illuminate\Support\Str::limit(strip_tags($kb->content), 150) }}
                    </p>
                    <div class="flex items-center justify-between pt-4 border-t border-slate-100">
                        <div class="flex items-center gap-2 text-xs text-slate-400 font-medium">
                            <i class="fas fa-clock"></i>
                            <span>Diperbarui {{ $kb->updated_at->format('d M Y') }}</span>
                        </div>
                        <span class="inline-flex items-center gap-2 text-sm font-bold text-emerald-600 group-hover:translate-x-1 transition-transform">
                            Baca Selengkapnya
                            <i class="fas fa-arrow-right"></i>
                        </span>
                    </div>
                </a>
            @empty
                <div class="col-span-2 glass-card rounded-3xl p-16 text-center">
                    <div class="w-24 h-24 rounded-3xl bg-slate-100 flex items-center justify-center mx-auto mb-6">
                        <i class="fas fa-file-alt text-slate-400 text-4xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-slate-800 mb-2">Belum ada kebijakan</h3>
                    <p class="text-sm text-slate-500">Coba ubah kata kunci pencarian atau filter peran.</p>
                </div>
            @endforelse
        </div>

        <div class="mt-10 glass-card rounded-3xl p-6">
            {{ $kebijakans->appends(request()->query())->links('pagination.number-123') }}
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
