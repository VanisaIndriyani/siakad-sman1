<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - SIAKAD SMA Negeri 1 Tuhemberua</title>
    <!-- Tailwind CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Fonts -->
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
        .animate-float {
            animation: float 6s ease-in-out infinite;
        }
        @keyframes float {
            0% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
            100% { transform: translateY(0px); }
        }
    </style>
</head>
<body class="min-h-screen flex flex-col md:flex-row items-center justify-center relative overflow-y-auto bg-slate-900 py-8 md:py-0">

    <!-- Background Image with Overlay -->
    <div class="fixed inset-0 z-0">
        <img src="https://images.unsplash.com/photo-1523050854058-8df90110c9f1?ixlib=rb-1.2.1&auto=format&fit=crop&w=1950&q=80" alt="School Background" class="w-full h-full object-cover opacity-20 mix-blend-overlay">
        <div class="absolute inset-0 bg-gradient-to-b from-slate-900/90 via-slate-900/80 to-slate-900"></div>
    </div>

    <!-- Decorative blobs -->
    <div class="fixed blob bg-blue-600 w-96 h-96 rounded-full top-0 left-0 -translate-x-1/2 -translate-y-1/2 animate-pulse pointer-events-none"></div>
    <div class="fixed blob bg-purple-600 w-96 h-96 rounded-full bottom-0 right-0 translate-x-1/2 translate-y-1/2 animate-pulse pointer-events-none" style="animation-delay: 2s;"></div>

    <!-- Back to Home Button -->
    <div class="w-full max-w-md px-6 mb-6 z-20 md:absolute md:top-6 md:left-6 md:w-auto md:mb-0 md:px-0">
        <a href="{{ url('/') }}" class="inline-flex items-center gap-2 text-slate-300 hover:text-white transition-all hover:-translate-x-1 group">
            <div class="w-10 h-10 rounded-full bg-white/5 backdrop-blur-sm flex items-center justify-center border border-white/10 group-hover:bg-white/10 transition-colors">
                <i class="fas fa-arrow-left text-sm"></i>
            </div>
            <span class="text-sm font-semibold">Kembali ke Beranda</span>
        </a>
    </div>

    <div class="w-full max-w-md px-4 md:px-6 relative z-10">
        <div class="glass-card rounded-[2rem] shadow-2xl overflow-hidden transition-all duration-300 transform hover:scale-[1.01] hover:shadow-blue-500/10">
            <div class="p-6 md:p-10">
                <div class="text-center mb-8 md:mb-10">
                    <div class="inline-flex items-center justify-center w-16 h-16 md:w-20 md:h-20 rounded-2xl bg-gradient-to-tr from-blue-600 to-indigo-600 text-white mb-4 md:mb-6 shadow-lg shadow-blue-500/30 animate-float">
                        <i class="fas fa-graduation-cap text-2xl md:text-3xl"></i>
                    </div>
                    <h1 class="text-xl md:text-2xl font-bold text-slate-800 tracking-tight">Selamat Datang</h1>
                    <p class="text-slate-500 text-xs md:text-sm mt-2 font-medium">Silakan login untuk mengakses portal akademik</p>
                </div>

                @if ($errors->any())
                    <div class="bg-red-50 border-l-4 border-red-500 text-red-700 p-4 rounded-lg mb-6 shadow-sm" role="alert">
                        <div class="flex">
                            <div class="py-1"><i class="fas fa-exclamation-circle mr-3"></i></div>
                            <div>
                                <p class="font-bold text-sm">Login Gagal</p>
                                <ul class="mt-1 list-disc list-inside text-xs">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                @endif
                
                @if (session('error'))
                    <div class="bg-red-50 border-l-4 border-red-500 text-red-700 p-4 rounded-lg mb-6 shadow-sm" role="alert">
                        <div class="flex items-center">
                            <i class="fas fa-exclamation-circle mr-3"></i>
                            <span class="text-sm font-medium">{{ session('error') }}</span>
                        </div>
                    </div>
                @endif

                <form action="{{ route('login.post') }}" method="POST" class="space-y-6">
                    @csrf
                    
                    <!-- Username/Email/NIP/NISN -->
                    <div class="group">
                        <label for="username" class="block text-sm font-bold text-slate-700 mb-2">ID Pengguna</label>
                        <div class="relative transition-all duration-300 focus-within:transform focus-within:scale-[1.02]">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <i class="fas fa-user text-slate-400 group-focus-within:text-blue-500 transition-colors"></i>
                            </div>
                            <input type="text" id="username" name="username" class="w-full pl-11 pr-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all outline-none text-slate-800 font-medium placeholder:text-slate-400" placeholder="Email / NIP / NISN" required>
                        </div>
                    </div>

                    <!-- Password -->
                    <div class="group">
                        <label for="password" class="block text-sm font-bold text-slate-700 mb-2">Password</label>
                        <div class="relative transition-all duration-300 focus-within:transform focus-within:scale-[1.02]">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <i class="fas fa-lock text-slate-400 group-focus-within:text-blue-500 transition-colors"></i>
                            </div>
                            <input type="password" id="password" name="password" class="w-full pl-11 pr-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all outline-none text-slate-800 font-medium placeholder:text-slate-400" placeholder="••••••••" required>
                        </div>
                    </div>

                    <!-- Remember Me & Forgot Password -->
                    <div class="flex items-center justify-between text-sm">
                        <label class="flex items-center text-slate-600 cursor-pointer group">
                            <input type="checkbox" class="w-4 h-4 rounded border-slate-300 text-blue-600 focus:ring-blue-500 transition-colors">
                            <span class="ml-2 group-hover:text-slate-800 transition-colors">Ingat Saya</span>
                        </label>
                   
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" class="w-full bg-gradient-to-r from-blue-600 to-indigo-600 text-white font-bold py-3.5 px-4 rounded-xl shadow-lg shadow-blue-500/30 hover:shadow-blue-500/50 transition-all duration-300 hover:-translate-y-1 flex items-center justify-center gap-2 group">
                        <span>Masuk Sekarang</span>
                        <i class="fas fa-arrow-right group-hover:translate-x-1 transition-transform"></i>
                    </button>
                </form>
            </div>
            
            <div class="bg-slate-50/50 px-6 py-4 md:px-8 md:py-5 border-t border-slate-100 text-center backdrop-blur-sm">
                <p class="text-xs text-slate-500 font-medium">
                    &copy; {{ date('Y') }} SMA Negeri 1 Tuhemberua. <br class="sm:hidden">All rights reserved.
                </p>
            </div>
        </div>
    </div>

</body>
</html>
