<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporkan Masalah - SIAKAD SMA Negeri 1 Tuhemberua</title>
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

    <div class="fixed blob bg-red-500 w-80 h-80 rounded-full top-20 left-0 -translate-x-1/3 animate-pulse pointer-events-none"></div>
    <div class="fixed blob bg-amber-500 w-96 h-96 rounded-full bottom-0 right-0 animate-pulse pointer-events-none" style="animation-delay: 1.5s;"></div>

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
                <a href="{{ route('bantuan.kebijakan') }}" class="block px-4 py-3 rounded-xl text-sm font-semibold text-slate-600 hover:text-blue-600 hover:bg-slate-50">Kebijakan</a>
                <a href="{{ route('bantuan.lapor') }}" class="block px-4 py-3 rounded-xl text-sm font-semibold text-white bg-blue-600">Laporkan Masalah</a>
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

    <section class="relative z-10 pt-32 pb-20 px-4 sm:px-6 lg:px-8 max-w-5xl mx-auto">
        <div class="text-center mb-12">
            <span class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-amber-500/10 border border-amber-500/20 text-amber-400 text-xs font-bold uppercase tracking-wider mb-6">
                <i class="fas fa-headset"></i>
                Support & Feedback
            </span>
            <h1 class="text-4xl md:text-5xl font-extrabold text-white mb-4 leading-tight">
                Laporkan
                <span class="bg-gradient-to-r from-amber-400 to-red-400 bg-clip-text text-transparent">Masalah Anda</span>
            </h1>
            <p class="text-lg text-slate-400 font-medium max-w-2xl mx-auto">
                Temukan bug, error, atau punya saran untuk perbaikan sistem? Kirimkan laporan Anda di sini.
            </p>
        </div>

        @if(session()->has('success'))
            <div class="glass-card rounded-3xl p-5 mb-8 flex items-center gap-4 border-l-4 border-emerald-500">
                <div class="w-12 h-12 rounded-2xl bg-emerald-100 flex items-center justify-center flex-shrink-0">
                    <i class="fas fa-check-circle text-emerald-600 text-xl"></i>
                </div>
                <div>
                    <h4 class="font-bold text-slate-800">Berhasil!</h4>
                    <p class="text-sm text-slate-600">{{ session('success') }}</p>
                </div>
                <button onclick="this.parentElement.remove()" class="ml-auto text-slate-400 hover:text-slate-600 p-2 rounded-lg hover:bg-slate-100 transition-all">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        @endif

        @if(session()->has('error'))
            <div class="glass-card rounded-3xl p-5 mb-8 flex items-center gap-4 border-l-4 border-red-500">
                <div class="w-12 h-12 rounded-2xl bg-red-100 flex items-center justify-center flex-shrink-0">
                    <i class="fas fa-exclamation-circle text-red-600 text-xl"></i>
                </div>
                <div>
                    <h4 class="font-bold text-slate-800">Error!</h4>
                    <p class="text-sm text-slate-600">{{ session('error') }}</p>
                </div>
                <button onclick="this.parentElement.remove()" class="ml-auto text-slate-400 hover:text-slate-600 p-2 rounded-lg hover:bg-slate-100 transition-all">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        @endif

        @if ($errors->any())
            <div class="glass-card rounded-3xl p-5 mb-8 border-l-4 border-red-500">
                <div class="flex items-center gap-4 mb-3">
                    <div class="w-12 h-12 rounded-2xl bg-red-100 flex items-center justify-center flex-shrink-0">
                        <i class="fas fa-triangle-exclamation text-red-600 text-xl"></i>
                    </div>
                    <div>
                        <h4 class="font-bold text-slate-800">Periksa kembali input Anda!</h4>
                    </div>
                </div>
                <ul class="list-disc list-inside ml-16 text-sm text-slate-600 space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="glass-card rounded-[2rem] overflow-hidden shadow-2xl mb-12">
            <div class="p-8 md:p-10 bg-gradient-to-br from-amber-500/10 via-red-500/5 to-transparent border-b border-slate-100">
                <div class="flex flex-wrap items-center gap-5">
                    <div class="w-16 h-16 rounded-3xl bg-gradient-to-br from-amber-500 to-red-500 flex items-center justify-center text-white shadow-xl shadow-amber-500/30">
                        <i class="fas fa-paper-plane text-2xl"></i>
                    </div>
                    <div>
                        <h2 class="text-2xl md:text-3xl font-extrabold text-slate-800">Form Laporan Masalah</h2>
                        <p class="text-slate-500 font-medium mt-1">Isi detail laporan Anda dengan jelas agar tim kami dapat segera merespon</p>
                    </div>
                </div>
            </div>

            <form action="{{ route('bantuan.lapor.kirim') }}" method="POST" enctype="multipart/form-data" class="p-8 md:p-10 space-y-6">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">Nama Pelapor <span class="text-red-500">*</span></label>
                        <div class="relative">
                            <i class="fas fa-user absolute left-4 top-1/2 -translate-y-1/2 text-slate-400"></i>
                            <input type="text" name="nama_pelapor" required value="{{ auth()->check() ? auth()->user()->name : old('nama_pelapor') }}" {{ auth()->check() ? 'readonly disabled' : '' }} class="w-full pl-12 pr-4 py-3.5 bg-slate-50 border border-slate-200 rounded-2xl focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 transition-all outline-none text-sm font-medium {{ auth()->check() ? 'opacity-75 cursor-not-allowed' : '' }}" placeholder="Masukkan nama lengkap Anda">
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">Email Pelapor <span class="text-red-500">*</span></label>
                        <div class="relative">
                            <i class="fas fa-envelope absolute left-4 top-1/2 -translate-y-1/2 text-slate-400"></i>
                            <input type="email" name="email_pelapor" required value="{{ auth()->check() ? auth()->user()->email : old('email_pelapor') }}" {{ auth()->check() ? 'readonly disabled' : '' }} class="w-full pl-12 pr-4 py-3.5 bg-slate-50 border border-slate-200 rounded-2xl focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 transition-all outline-none text-sm font-medium {{ auth()->check() ? 'opacity-75 cursor-not-allowed' : '' }}" placeholder="email@contoh.com">
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">Subject Laporan <span class="text-red-500">*</span></label>
                        <div class="relative">
                            <i class="fas fa-tag absolute left-4 top-1/2 -translate-y-1/2 text-slate-400"></i>
                            <input type="text" name="subject" required value="{{ old('subject') }}" class="w-full pl-12 pr-4 py-3.5 bg-slate-50 border border-slate-200 rounded-2xl focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 transition-all outline-none text-sm font-medium" placeholder="Subjek singkat laporan Anda">
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">Kategori <span class="text-red-500">*</span></label>
                        <div class="relative">
                            <i class="fas fa-folder absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 z-10"></i>
                            <select name="kategori" required class="w-full pl-12 pr-4 py-3.5 bg-slate-50 border border-slate-200 rounded-2xl focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 transition-all outline-none text-sm font-medium appearance-none">
                                <option value="" selected disabled>Pilih kategori laporan...</option>
                                <option value="bug" {{ old('kategori') == 'bug' ? 'selected' : '' }}>🐛 Bug / Error Sistem</option>
                                <option value="saran" {{ old('kategori') == 'saran' ? 'selected' : '' }}>💡 Saran & Fitur</option>
                                <option value="akses" {{ old('kategori') == 'akses' ? 'selected' : '' }}>🔐 Masalah Akses/Akun</option>
                                <option value="akademik" {{ old('kategori') == 'akademik' ? 'selected' : '' }}>📚 Data Akademik</option>
                                <option value="lainnya" {{ old('kategori') == 'lainnya' ? 'selected' : '' }}>📝 Lainnya</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">Deskripsi Laporan <span class="text-red-500">*</span></label>
                    <textarea name="deskripsi" rows="8" required maxlength="5000" class="w-full px-4 py-4 bg-slate-50 border border-slate-200 rounded-2xl focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 transition-all outline-none text-sm font-medium resize-y leading-relaxed" placeholder="Jelaskan secara detail laporan Anda. Sertakan langkah-langkah jika ini adalah bug, atau penjelasan detail jika ini adalah saran... (maks. 5000 karakter)">{{ old('deskripsi') }}</textarea>
                    <div class="flex justify-end mt-2">
                        <p class="text-xs text-slate-400 font-medium"><span id="charCount">0</span>/5000 karakter</p>
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">File Pendukung</label>
                    <div class="border-2 border-dashed border-slate-200 hover:border-emerald-400 rounded-2xl p-6 text-center transition-colors bg-slate-50/50">
                        <input type="file" name="file_pendukung" id="fileInput" class="hidden" accept=".jpg,.jpeg,.png,.pdf,.doc,.docx,.xls,.xlsx,.zip">
                        <label for="fileInput" class="cursor-pointer">
                            <div class="w-14 h-14 rounded-2xl bg-emerald-100 flex items-center justify-center mx-auto mb-3 hover:scale-110 transition-transform">
                                <i class="fas fa-cloud-upload-alt text-emerald-600 text-2xl"></i>
                            </div>
                            <p class="text-sm font-semibold text-slate-700 mb-1">Klik untuk upload file</p>
                            <p class="text-xs text-slate-500">atau drag and drop ke sini</p>
                            <p class="text-[11px] text-amber-600 font-bold mt-3 bg-amber-50 inline-block px-3 py-1.5 rounded-full">
                                <i class="fas fa-info-circle mr-1"></i>Maks. 5MB (JPG, PNG, PDF, DOC, XLS, ZIP)
                            </p>
                        </label>
                        <p id="fileName" class="text-xs text-slate-600 mt-3 font-medium hidden"></p>
                    </div>
                </div>

                <div class="flex flex-col sm:flex-row gap-4 pt-4">
                    <button type="reset" class="flex-1 px-6 py-4 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-2xl font-bold text-sm transition-colors">
                        <i class="fas fa-redo mr-2"></i>Reset Form
                    </button>
                    <button type="submit" class="flex-1 px-6 py-4 bg-gradient-to-r from-emerald-500 to-emerald-600 hover:from-emerald-600 hover:to-emerald-700 text-white rounded-2xl font-bold text-sm transition-all shadow-xl shadow-emerald-500/30 hover:shadow-emerald-500/50">
                        <i class="fas fa-paper-plane mr-2"></i>Kirim Laporan
                    </button>
                </div>
            </form>
        </div>

        @if(auth()->check() && isset($riwayatLaporan) && $riwayatLaporan->count() > 0)
        <div class="glass-card rounded-[2rem] overflow-hidden">
            <div class="p-8 md:p-10 bg-gradient-to-br from-emerald-500/10 via-blue-500/5 to-transparent border-b border-slate-100">
                <div class="flex flex-wrap items-center justify-between gap-4">
                    <div class="flex flex-wrap items-center gap-5">
                        <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-emerald-500 to-teal-600 flex items-center justify-center text-white shadow-lg shadow-emerald-500/30">
                            <i class="fas fa-history text-xl"></i>
                        </div>
                        <div>
                            <h2 class="text-2xl font-extrabold text-slate-800">Riwayat Laporan Anda</h2>
                            <p class="text-slate-500 font-medium mt-1">Total {{ $riwayatLaporan->total() }} laporan yang pernah Anda kirim</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="p-6 md:p-8">
                <div class="space-y-4">
                    @foreach($riwayatLaporan as $laporan)
                        @php
                            $kategoriBadge = match($laporan->kategori) {
                                'bug' => ['bg-red-100', 'text-red-700', 'Bug'],
                                'saran' => ['bg-blue-100', 'text-blue-700', 'Saran'],
                                'akses' => ['bg-amber-100', 'text-amber-700', 'Akses'],
                                'akademik' => ['bg-emerald-100', 'text-emerald-700', 'Akademik'],
                                default => ['bg-slate-100', 'text-slate-700', 'Lainnya'],
                            };
                            $statusBadge = match($laporan->status) {
                                'open' => ['bg-red-100', 'text-red-700', 'Open'],
                                'in_progress' => ['bg-amber-100', 'text-amber-700', 'In Progress'],
                                'resolved' => ['bg-emerald-100', 'text-emerald-700', 'Resolved'],
                                'closed' => ['bg-slate-100', 'text-slate-700', 'Closed'],
                                default => ['bg-slate-100', 'text-slate-700', ucfirst($laporan->status)],
                            };
                        @endphp
                        <div class="p-5 md:p-6 rounded-3xl border border-slate-100 hover:border-emerald-200 hover:shadow-md transition-all duration-300">
                            <div class="flex flex-wrap items-start justify-between gap-3 mb-4">
                                <div class="flex flex-wrap items-center gap-3">
                                    <span class="inline-flex items-center px-3 py-1.5 rounded-xl text-[10px] font-bold uppercase tracking-wider {{ $kategoriBadge[0] }} {{ $kategoriBadge[1] }}">
                                        <i class="fas fa-tag mr-1.5"></i>{{ $kategoriBadge[2] }}
                                    </span>
                                    <span class="inline-flex items-center px-3 py-1.5 rounded-xl text-[10px] font-bold uppercase tracking-wider {{ $statusBadge[0] }} {{ $statusBadge[1] }}">
                                        <span class="w-2 h-2 rounded-full mr-1.5" style="background-color: currentColor; opacity: 0.7;"></span>{{ $statusBadge[2] }}
                                    </span>
                                </div>
                                <span class="text-xs text-slate-400 font-medium">
                                    <i class="fas fa-clock mr-1"></i>{{ $laporan->created_at->format('d M Y') }}
                                </span>
                            </div>
                            <h3 class="font-bold text-slate-800 text-lg mb-2">{{ $laporan->subject }}</h3>
                            <p class="text-sm text-slate-600 mb-4 line-clamp-2">{{ \Illuminate\Support\Str::limit($laporan->deskripsi, 180) }}</p>
                            @if($laporan->respon_admin)
                                <div class="mt-4 p-4 rounded-2xl bg-emerald-50 border border-emerald-100">
                                    <div class="flex items-center gap-2 mb-2">
                                        <div class="w-7 h-7 rounded-lg bg-emerald-600 flex items-center justify-center">
                                            <i class="fas fa-check text-white text-xs"></i>
                                        </div>
                                        <span class="text-xs font-bold text-emerald-700 uppercase tracking-wider">Respon Admin</span>
                                    </div>
                                    <p class="text-sm text-slate-700 whitespace-pre-line leading-relaxed">{{ $laporan->respon_admin }}</p>
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>

                <div class="mt-8">
                    {{ $riwayatLaporan->links('pagination.number-123') }}
                </div>
            </div>
        </div>
        @endif
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

        const fileInput = document.getElementById('fileInput');
        const fileName = document.getElementById('fileName');
        fileInput.addEventListener('change', function(e) {
            if (e.target.files.length > 0) {
                const f = e.target.files[0];
                const sizeKB = Math.round(f.size / 1024);
                const sizeMB = (f.size / (1024 * 1024)).toFixed(2);
                let sizeText = sizeKB < 1024 ? sizeKB + ' KB' : sizeMB + ' MB';
                fileName.textContent = '📎 ' + f.name + ' (' + sizeText + ')';
                fileName.classList.remove('hidden');
            } else {
                fileName.classList.add('hidden');
            }
        });

        const deskripsiText = document.querySelector('textarea[name="deskripsi"]');
        const charCount = document.getElementById('charCount');
        if (deskripsiText) {
            charCount.textContent = deskripsiText.value.length;
            deskripsiText.addEventListener('input', function() {
                charCount.textContent = this.value.length;
            });
        }
    </script>
</body>
</html>
