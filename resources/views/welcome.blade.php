<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SIAKAD SMA Negeri 1 Tuhemberua</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        .hero-pattern {
            background-color: #111827;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='40' height='40' viewBox='0 0 40 40'%3E%3Cg fill-rule='evenodd'%3E%3Cg fill='%231f2937' fill-opacity='0.4'%3E%3Cpath d='M0 38.59l2.83-2.83 1.41 1.41L1.41 40H0v-1.41zM0 1.4l2.83 2.83 1.41-1.41L1.41 0H0v1.41zM38.59 40l-2.83-2.83 1.41-1.41L40 38.59V40h-1.41zM40 1.41l-2.83 2.83-1.41-1.41L38.59 0H40v1.41zM20 18.6l2.83-2.83 1.41 1.41L21.41 20l2.83 2.83-1.41 1.41L20 21.41l-2.83 2.83-1.41-1.41L18.59 20l-2.83-2.83 1.41-1.41L20 18.59z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
        }
        .blob {
            position: absolute;
            filter: blur(80px);
            z-index: 0;
            opacity: 0.6;
        }
        .text-shadow {
            text-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
    </style>
</head>
<body class="bg-slate-50 text-slate-800 antialiased selection:bg-blue-500 selection:text-white">

    <!-- Navbar -->
    <nav class="fixed w-full z-50 transition-all duration-300 bg-white/80 backdrop-blur-lg border-b border-slate-200/50 supports-[backdrop-filter]:bg-white/60">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-20 items-center">
                <div class="flex items-center gap-3 group cursor-pointer">
                    <div class="w-10 h-10 rounded-xl bg-gradient-to-tr from-blue-600 to-indigo-600 flex items-center justify-center shadow-lg shadow-blue-500/20 group-hover:scale-110 transition-transform duration-300">
                        <i class="fas fa-graduation-cap text-white text-lg"></i>
                    </div>
                    <div>
                        <span class="text-xl font-bold text-slate-900 tracking-tight block leading-none">SIAKAD</span>
                        <span class="text-[10px] text-blue-600 font-bold uppercase tracking-widest group-hover:text-blue-500 transition-colors">SMAN 1 Tuhemberua</span>
                    </div>
                </div>
                <div class="hidden md:flex items-center space-x-8">
                    <a href="#beranda" class="text-sm font-medium text-slate-600 hover:text-blue-600 transition-colors">Beranda</a>
                    <a href="#fitur" class="text-sm font-medium text-slate-600 hover:text-blue-600 transition-colors">Fitur</a>
                    <a href="#statistik" class="text-sm font-medium text-slate-600 hover:text-blue-600 transition-colors">Statistik</a>
                    <a href="#pengumuman" class="text-sm font-medium text-slate-600 hover:text-blue-600 transition-colors">Pengumuman</a>
                    <a href="#lokasi" class="text-sm font-medium text-slate-600 hover:text-blue-600 transition-colors">Lokasi</a>
                    
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
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section id="beranda" class="relative pt-32 pb-24 lg:pt-48 lg:pb-40 overflow-hidden bg-slate-900">
        <!-- Animated Background -->
        <div class="absolute inset-0 z-0">
            <img src="https://images.unsplash.com/photo-1541339907198-e08756dedf3f?ixlib=rb-1.2.1&auto=format&fit=crop&w=1950&q=80" alt="School Background" class="w-full h-full object-cover opacity-20 mix-blend-overlay">
            <div class="absolute inset-0 bg-gradient-to-b from-slate-900/90 via-slate-900/80 to-slate-900"></div>
        </div>

        <!-- Blobs -->
        <div class="blob bg-blue-600 w-96 h-96 rounded-full top-0 left-0 -translate-x-1/2 -translate-y-1/2"></div>
        <div class="blob bg-indigo-600 w-96 h-96 rounded-full bottom-0 right-0 translate-x-1/2 translate-y-1/2"></div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 text-center">
            <div class="inline-flex items-center gap-2 py-1.5 px-4 rounded-full bg-blue-500/10 border border-blue-500/20 text-blue-300 text-xs font-bold uppercase tracking-widest mb-8 backdrop-blur-md animate-fade-in-up hover:bg-blue-500/20 transition-colors cursor-default">
                <span class="relative flex h-2 w-2">
                  <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-blue-400 opacity-75"></span>
                  <span class="relative inline-flex rounded-full h-2 w-2 bg-blue-500"></span>
                </span>
                Sistem Informasi Akademik Terpadu
            </div>
            
            <h1 class="text-5xl md:text-7xl lg:text-8xl font-extrabold text-white mb-8 leading-tight tracking-tight">
                Membangun Generasi <br>
                <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-400 via-indigo-400 to-purple-400 animate-gradient-x">Cerdas & Berkarakter</span>
            </h1>
            
            <p class="text-lg md:text-xl text-slate-300 mb-12 max-w-3xl mx-auto font-light leading-relaxed">
                Platform digital resmi SMA Negeri 1 Tuhemberua untuk akses informasi akademik, nilai, jadwal, dan administrasi sekolah yang transparan, akuntabel, dan efisien.
            </p>
            
            <div class="flex flex-col sm:flex-row justify-center gap-5">
                <a href="{{ route('login') }}" class="px-8 py-4 bg-blue-600 text-white font-bold rounded-2xl hover:bg-blue-500 shadow-xl shadow-blue-600/20 transition-all hover:-translate-y-1 hover:shadow-blue-600/40 flex items-center justify-center gap-3 group">
                    <span>Akses Portal Akademik</span>
                    <i class="fas fa-arrow-right group-hover:translate-x-1 transition-transform"></i>
                </a>
                <a href="#lokasi" class="px-8 py-4 bg-white/5 text-white font-bold rounded-2xl hover:bg-white/10 border border-white/10 backdrop-blur-sm transition-all hover:-translate-y-1 flex items-center justify-center gap-3">
                    <i class="fas fa-map-marker-alt"></i>
                    <span>Kunjungi Sekolah</span>
                </a>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section id="fitur" class="py-24 bg-white relative">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-3xl md:text-4xl font-bold text-slate-900 mb-4">Fitur Unggulan</h2>
                <p class="text-slate-500 max-w-2xl mx-auto">Memudahkan seluruh civitas akademika dalam menjalankan kegiatan belajar mengajar.</p>
            </div>

            <div class="grid md:grid-cols-3 gap-8">
                <!-- Feature 1 -->
                <div class="p-8 rounded-3xl bg-slate-50 border border-slate-100 hover:shadow-xl hover:shadow-slate-200/50 transition-all hover:-translate-y-2 group">
                    <div class="w-14 h-14 bg-blue-100 rounded-2xl flex items-center justify-center text-blue-600 mb-6 group-hover:scale-110 group-hover:rotate-3 transition-transform duration-300">
                        <i class="fas fa-chart-line text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-slate-900 mb-3">Monitoring Nilai</h3>
                    <p class="text-slate-500 leading-relaxed">Pantau perkembangan akademik siswa secara real-time dengan akses mudah ke data nilai harian, UTS, dan UAS yang transparan.</p>
                </div>

                <!-- Feature 2 -->
                <div class="p-8 rounded-3xl bg-slate-50 border border-slate-100 hover:shadow-xl hover:shadow-slate-200/50 transition-all hover:-translate-y-2 group">
                    <div class="w-14 h-14 bg-indigo-100 rounded-2xl flex items-center justify-center text-indigo-600 mb-6 group-hover:scale-110 group-hover:rotate-3 transition-transform duration-300">
                        <i class="fas fa-calendar-alt text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-slate-900 mb-3">Jadwal Terintegrasi</h3>
                    <p class="text-slate-500 leading-relaxed">Akses jadwal pelajaran yang selalu up-to-date, memudahkan siswa dan guru dalam mengatur agenda kegiatan belajar mengajar.</p>
                </div>

                <!-- Feature 3 -->
                <div class="p-8 rounded-3xl bg-slate-50 border border-slate-100 hover:shadow-xl hover:shadow-slate-200/50 transition-all hover:-translate-y-2 group">
                    <div class="w-14 h-14 bg-teal-100 rounded-2xl flex items-center justify-center text-teal-600 mb-6 group-hover:scale-110 group-hover:rotate-3 transition-transform duration-300">
                        <i class="fas fa-bullhorn text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-slate-900 mb-3">Informasi Sekolah</h3>
                    <p class="text-slate-500 leading-relaxed">Dapatkan informasi terbaru mengenai kegiatan sekolah, pengumuman penting, dan berita akademik lainnya secara langsung.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Statistik Section -->
    <section id="statistik" class="py-24 bg-blue-600 text-white relative overflow-hidden">
        <div class="absolute inset-0 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')] opacity-10"></div>
        <!-- Gradient overlay -->
        <div class="absolute inset-0 bg-gradient-to-tr from-blue-700 to-indigo-600 opacity-90"></div>
        
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="text-center mb-16">
                <h2 class="text-3xl md:text-4xl font-bold mb-4">Statistik Data Sekolah</h2>
                <p class="text-blue-100 max-w-2xl mx-auto text-lg">Gambaran umum data civitas akademika SMA Negeri 1 Tuhemberua saat ini.</p>
            </div>
            
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-6">
                <!-- Rombel -->
                <div class="p-6 bg-white/10 rounded-2xl backdrop-blur-md border border-white/10 hover:bg-white/20 transition-all group text-center">
                    <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center mx-auto mb-4 text-white group-hover:scale-110 transition-transform">
                        <i class="fas fa-users-class text-xl"></i>
                    </div>
                    <div class="text-4xl font-extrabold mb-1">{{ $kelasCount }}</div>
                    <div class="text-sm font-medium text-blue-100 uppercase tracking-wider">Rombel</div>
                </div>

                <!-- Jurusan -->
                <div class="p-6 bg-white/10 rounded-2xl backdrop-blur-md border border-white/10 hover:bg-white/20 transition-all group text-center">
                    <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center mx-auto mb-4 text-white group-hover:scale-110 transition-transform">
                        <i class="fas fa-shapes text-xl"></i>
                    </div>
                    <div class="text-4xl font-extrabold mb-1">{{ $jurusanCount }}</div>
                    <div class="text-sm font-medium text-blue-100 uppercase tracking-wider">Jurusan</div>
                </div>

                <!-- Total Siswa -->
                <div class="p-6 bg-white/10 rounded-2xl backdrop-blur-md border border-white/10 hover:bg-white/20 transition-all group text-center">
                    <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center mx-auto mb-4 text-white group-hover:scale-110 transition-transform">
                        <i class="fas fa-user-graduate text-xl"></i>
                    </div>
                    <div class="text-4xl font-extrabold mb-1">{{ $siswaCount }}</div>
                    <div class="text-sm font-medium text-blue-100 uppercase tracking-wider">Siswa Aktif</div>
                </div>

                <!-- Detail Gender -->
                <div class="p-6 bg-white/10 rounded-2xl backdrop-blur-md border border-white/10 hover:bg-white/20 transition-all text-left">
                    <div class="space-y-4">
                        <div>
                            <div class="flex justify-between items-center mb-1">
                                <span class="text-xs text-blue-200 uppercase tracking-wider"><i class="fas fa-mars mr-1"></i> Laki-laki</span>
                                <span class="font-bold text-sm">{{ $siswaL }}</span>
                            </div>
                            <div class="w-full bg-black/20 rounded-full h-1.5 overflow-hidden">
                                <div class="bg-blue-300 h-1.5 rounded-full" style="width: {{ $persenL }}%"></div>
                            </div>
                        </div>
                        <div>
                            <div class="flex justify-between items-center mb-1">
                                <span class="text-xs text-blue-200 uppercase tracking-wider"><i class="fas fa-venus mr-1"></i> Perempuan</span>
                                <span class="font-bold text-sm">{{ $siswaP }}</span>
                            </div>
                            <div class="w-full bg-black/20 rounded-full h-1.5 overflow-hidden">
                                <div class="bg-pink-300 h-1.5 rounded-full" style="width: {{ $persenP }}%"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Pengumuman Section -->
    <section id="pengumuman" class="py-24 bg-slate-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row justify-between items-end mb-12 gap-4">
                <div>
                    <span class="text-blue-600 font-bold tracking-wider uppercase text-xs mb-2 block">Informasi Terbaru</span>
                    <h2 class="text-3xl md:text-4xl font-bold text-slate-900">Pengumuman Sekolah</h2>
                </div>
                <a href="#" class="text-blue-600 font-semibold hover:text-blue-700 flex items-center gap-2 group">
                    Lihat Semua <i class="fas fa-arrow-right transform group-hover:translate-x-1 transition-transform"></i>
                </a>
            </div>

            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                @forelse($pengumumans as $pengumuman)
                <div class="bg-white rounded-3xl shadow-sm border border-slate-100 overflow-hidden hover:shadow-xl hover:shadow-slate-200/50 transition-all duration-300 hover:-translate-y-1 flex flex-col h-full group">
                    <div class="p-8 flex-1">
                        <div class="flex items-center gap-2 mb-4">
                            <span class="px-3 py-1 bg-blue-50 text-blue-600 rounded-lg text-xs font-bold uppercase tracking-wider">Info</span>
                            <span class="text-xs text-slate-400 font-medium">{{ $pengumuman->created_at->format('d M Y') }}</span>
                        </div>
                        <h3 class="text-xl font-bold text-slate-900 mb-3 line-clamp-2 group-hover:text-blue-600 transition-colors">{{ $pengumuman->judul }}</h3>
                        <p class="text-slate-500 text-sm leading-relaxed line-clamp-3 mb-4">{{ Str::limit($pengumuman->isi, 150) }}</p>
                        
                        @if($pengumuman->file_path)
                        <div class="mt-auto">
                            <a href="{{ route('pengumuman.lampiran', $pengumuman->id) }}" target="_blank" class="inline-flex items-center text-xs font-bold text-blue-600 bg-blue-50 px-3 py-1.5 rounded-lg border border-blue-100 hover:bg-blue-100 transition-all">
                                <i class="fas fa-file-pdf mr-2"></i> Lihat Lampiran
                            </a>
                        </div>
                        @endif
                    </div>
                    <div class="px-8 py-6 bg-slate-50/50 border-t border-slate-100">
                        <a href="#" class="text-blue-600 font-bold text-sm hover:text-blue-700 flex items-center gap-2 group/link">
                            Baca selengkapnya 
                            <i class="fas fa-arrow-right text-xs transform group-hover/link:translate-x-1 transition-transform"></i>
                        </a>
                    </div>
                </div>
                @empty
                <div class="col-span-full text-center py-16 bg-white rounded-3xl border border-dashed border-slate-300">
                    <div class="inline-flex items-center justify-center w-20 h-20 bg-slate-50 rounded-full mb-6">
                        <i class="far fa-newspaper text-slate-400 text-3xl"></i>
                    </div>
                    <h3 class="text-lg font-bold text-slate-900 mb-2">Belum ada pengumuman</h3>
                    <p class="text-slate-500">Silakan cek kembali nanti untuk informasi terbaru.</p>
                </div>
                @endforelse
            </div>
        </div>
    </section>

    <!-- Location Section (NEW) -->
    <section id="lokasi" class="py-24 bg-white border-t border-slate-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <span class="text-blue-600 font-bold tracking-wider uppercase text-xs mb-2 block">Lokasi</span>
                <h2 class="text-3xl md:text-4xl font-bold text-slate-900">Kunjungi Sekolah Kami</h2>
            </div>

            <div class="bg-white p-4 rounded-[2rem] shadow-2xl shadow-slate-200/50 border border-slate-100">
                <div class="grid lg:grid-cols-3 gap-0 lg:gap-8">
                    <!-- Contact Info -->
                    <div class="lg:col-span-1 p-8 bg-slate-50 rounded-3xl mb-8 lg:mb-0">
                        <h3 class="text-xl font-bold text-slate-900 mb-6">Kontak & Alamat</h3>
                        
                        <div class="space-y-6">
                            <div class="flex items-start gap-4">
                                <div class="w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center text-blue-600 shrink-0">
                                    <i class="fas fa-map-marker-alt"></i>
                                </div>
                                <div>
                                    <p class="text-sm font-bold text-slate-900 block mb-1">Alamat</p>
                                    <p class="text-sm text-slate-600 leading-relaxed">
                                        Silima Banua, Kec. Tuhemberua, Kabupaten Nias Utara, Sumatera Utara 22852
                                    </p>
                                </div>
                            </div>
                            
                            <div class="flex items-start gap-4">
                                <div class="w-10 h-10 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-600 shrink-0">
                                    <i class="fas fa-phone"></i>
                                </div>
                                <div>
                                    <p class="text-sm font-bold text-slate-900 block mb-1">Telepon</p>
                                    <p class="text-sm text-slate-600">(0639) 1234567</p>
                                </div>
                            </div>

                            <div class="flex items-start gap-4">
                                <div class="w-10 h-10 rounded-full bg-teal-100 flex items-center justify-center text-teal-600 shrink-0">
                                    <i class="fas fa-envelope"></i>
                                </div>
                                <div>
                                    <p class="text-sm font-bold text-slate-900 block mb-1">Email</p>
                                    <p class="text-sm text-slate-600">info@sman1tuhemberua.sch.id</p>
                                </div>
                            </div>
                            
                            <div class="flex items-start gap-4">
                                <div class="w-10 h-10 rounded-full bg-purple-100 flex items-center justify-center text-purple-600 shrink-0">
                                    <i class="fas fa-clock"></i>
                                </div>
                                <div>
                                    <p class="text-sm font-bold text-slate-900 block mb-1">Jam Operasional</p>
                                    <p class="text-sm text-slate-600">Senin - Jumat: 07:00 - 15:00 WIB</p>
                                    <p class="text-sm text-slate-500">Sabtu - Minggu: Libur</p>
                                </div>
                            </div>
                        </div>

                        <div class="mt-8 pt-8 border-t border-slate-200">
                            <a href="https://maps.google.com" target="_blank" class="w-full py-3 bg-blue-600 text-white rounded-xl font-bold text-sm flex items-center justify-center gap-2 hover:bg-blue-700 transition-colors">
                                <i class="fas fa-directions"></i> Petunjuk Arah
                            </a>
                        </div>
                    </div>

                    <!-- Map -->
                    <div class="lg:col-span-2 h-[400px] lg:h-auto rounded-3xl overflow-hidden relative group">
                        <iframe 
                            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3988.501669583283!2d97.43591817496599!3d1.4720016985141635!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3025ea802c9f51ef%3A0xb18c7f446269634f!2sSMA%20Negeri%201%20Tuhemberua!5e0!3m2!1sid!2sid!4v1768902534958!5m2!1sid!2sid" 
                            width="100%" 
                            height="100%" 
                            style="border:0;" 
                            allowfullscreen="" 
                            loading="lazy" 
                            referrerpolicy="no-referrer-when-downgrade"
                            class="grayscale group-hover:grayscale-0 transition-all duration-700 w-full h-full">
                        </iframe>
                        <div class="absolute top-4 right-4 bg-white/90 backdrop-blur px-4 py-2 rounded-lg text-xs font-bold text-slate-700 shadow-lg">
                            <i class="fas fa-map-marked-alt text-blue-600 mr-1"></i> Peta Lokasi
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-slate-900 text-slate-300 py-16 border-t border-slate-800">
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
                        <li><a href="#beranda" class="hover:text-blue-400 transition-colors flex items-center gap-2"><i class="fas fa-chevron-right text-xs text-slate-600"></i> Beranda</a></li>
                        <li><a href="#fitur" class="hover:text-blue-400 transition-colors flex items-center gap-2"><i class="fas fa-chevron-right text-xs text-slate-600"></i> Fitur</a></li>
                        <li><a href="#pengumuman" class="hover:text-blue-400 transition-colors flex items-center gap-2"><i class="fas fa-chevron-right text-xs text-slate-600"></i> Pengumuman</a></li>
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
                    <a href="#" class="hover:text-white transition-colors">Privacy Policy</a>
                    <a href="#" class="hover:text-white transition-colors">Terms of Service</a>
                </div>
            </div>
        </div>
    </footer>

</body>
</html>
