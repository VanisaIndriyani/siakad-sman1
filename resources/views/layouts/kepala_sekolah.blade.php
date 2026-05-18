<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard Kepala Sekolah') - SIAKAD SMAN 1 Tuhemberua</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }
        .custom-scrollbar::-webkit-scrollbar {
            width: 5px;
        }
        .custom-scrollbar::-webkit-scrollbar-track {
            background: rgba(255, 255, 255, 0.05);
        }
        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, 0.2);
            border-radius: 20px;
        }
        .custom-scrollbar::-webkit-scrollbar-thumb:hover {
            background: rgba(255, 255, 255, 0.3);
        }
        .sidebar-link {
            position: relative;
            overflow: hidden;
        }
        .sidebar-link::before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            height: 100%;
            width: 4px;
            background: #3b82f6;
            border-top-right-radius: 4px;
            border-bottom-right-radius: 4px;
            transform: scaleY(0);
            transition: transform 0.2s ease;
        }
        .sidebar-link:hover::before {
            transform: scaleY(1);
        }
        .sidebar-link.active {
            background: linear-gradient(90deg, rgba(59, 130, 246, 0.1) 0%, rgba(59, 130, 246, 0) 100%);
            color: #60a5fa;
        }
        .sidebar-link.active::before {
            transform: scaleY(1);
        }
        .sidebar-link i {
            transition: transform 0.3s ease, color 0.3s ease;
        }
        .sidebar-link:hover i {
            transform: translateX(3px);
            color: #60a5fa;
        }
        .glass-header {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
            border-bottom: 1px solid rgba(229, 231, 235, 0.5);
        }
    </style>
</head>
<body class="bg-gray-50 text-gray-800 antialiased">

    <!-- Mobile Overlay -->
    <div id="sidebarOverlay" class="fixed inset-0 bg-gray-900/50 z-40 hidden transition-opacity lg:hidden backdrop-blur-sm"></div>

    <!-- Sidebar -->
    <aside id="sidebar" class="fixed inset-y-0 left-0 z-50 w-64 bg-[#0f172a] text-gray-400 transform -translate-x-full lg:translate-x-0 transition-transform duration-300 ease-in-out shadow-2xl flex flex-col border-r border-gray-800">
        <!-- Logo Area -->
        <div class="h-40 flex flex-col items-center justify-center px-6 border-b border-gray-800 bg-[#0f172a] relative z-10">
            <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-indigo-600 to-purple-600 flex items-center justify-center shadow-lg shadow-indigo-500/20 mb-3 transform hover:scale-110 transition-transform duration-300">
                <i class="fas fa-user-tie text-white text-2xl"></i>
            </div>
            <div class="text-center">
                <span class="text-2xl font-bold text-white tracking-tight block leading-none">SIAKAD</span>
                <span class="text-[10px] text-indigo-400 font-bold uppercase tracking-[0.2em] mt-1.5 block">Kepala Sekolah</span>
            </div>
        </div>

        <!-- Scrollable Container (Nav + Footer) -->
        <div class="flex-1 overflow-y-auto custom-scrollbar flex flex-col py-6">
            <!-- Navigation -->
            <nav class="flex-1 px-4 space-y-1">
                <p class="px-4 text-[10px] font-bold text-gray-500 uppercase tracking-widest mb-4 mt-2">Utama</p>
                
                <a href="{{ route('kepala_sekolah.dashboard') }}" class="sidebar-link flex items-center px-4 py-3 text-sm font-medium rounded-xl transition-all duration-200 hover:bg-gray-800/50 hover:text-white group {{ request()->routeIs('kepala_sekolah.dashboard') ? 'active' : '' }}">
                    <i class="fas fa-th-large w-6 text-center group-hover:text-blue-400"></i>
                    <span class="ml-3">Dashboard</span>
                </a>

                <p class="px-4 text-[10px] font-bold text-gray-500 uppercase tracking-widest mt-8 mb-4">Monitoring & Laporan</p>
                
                <a href="{{ route('kepala_sekolah.laporan.akademik') }}" class="sidebar-link flex items-center px-4 py-3 text-sm font-medium rounded-xl transition-all duration-200 hover:bg-gray-800/50 hover:text-white group {{ request()->routeIs('kepala_sekolah.laporan.akademik') ? 'active' : '' }}">
                    <i class="fas fa-chart-line w-6 text-center group-hover:text-blue-400"></i>
                    <span class="ml-3">Laporan Akademik</span>
                </a>
                <a href="{{ route('kepala_sekolah.monitoring.nilai') }}" class="sidebar-link flex items-center px-4 py-3 text-sm font-medium rounded-xl transition-all duration-200 hover:bg-gray-800/50 hover:text-white group {{ request()->routeIs('kepala_sekolah.monitoring.nilai') ? 'active' : '' }}">
                    <i class="fas fa-clipboard-check w-6 text-center group-hover:text-blue-400"></i>
                    <span class="ml-3">Monitoring Nilai</span>
                </a>
                <a href="{{ route('kepala_sekolah.monitoring.absensi') }}" class="sidebar-link flex items-center px-4 py-3 text-sm font-medium rounded-xl transition-all duration-200 hover:bg-gray-800/50 hover:text-white group {{ request()->routeIs('kepala_sekolah.monitoring.absensi') ? 'active' : '' }}">
                    <i class="fas fa-user-check w-6 text-center group-hover:text-blue-400"></i>
                    <span class="ml-3">Monitoring Absensi</span>
                </a>

              

               
            </nav>

            <!-- User Profile (Inside Scrollable Area) -->
            <div class="px-4 mt-6">
                <div class="p-4 rounded-2xl bg-gray-800/50 border border-gray-700/50">
                    <div class="flex items-center mb-4">
                        <img class="h-10 w-10 rounded-full object-cover border-2 border-indigo-500 shadow-md" src="https://ui-avatars.com/api/?name={{ Auth::user()->name }}&background=6366f1&color=fff" alt="Kepsek Profile">
                        <div class="ml-3 overflow-hidden">
                            <p class="text-sm font-bold text-white truncate">{{ Auth::user()->name }}</p>
                            <p class="text-[10px] text-gray-400 truncate">Kepala Sekolah</p>
                        </div>
                    </div>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="w-full flex items-center justify-center py-2.5 px-4 border border-red-500/20 bg-red-500/10 text-red-400 rounded-lg text-xs font-semibold uppercase tracking-wider hover:bg-red-500 hover:text-white transition-all duration-200 group">
                            <i class="fas fa-sign-out-alt mr-2 group-hover:animate-pulse"></i> Logout
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </aside>

    <!-- Main Content Wrapper -->
    <div class="lg:ml-64 flex flex-col min-h-screen transition-all duration-300">
        
        <!-- Top Navbar -->
        <header class="glass-header h-20 flex items-center justify-between px-6 sticky top-0 z-20">
            <div class="flex items-center">
                <button id="sidebarToggle" class="text-gray-500 hover:text-gray-700 focus:outline-none lg:hidden mr-4 p-2 rounded-lg hover:bg-gray-100 transition-colors">
                    <i class="fas fa-bars text-xl"></i>
                </button>
                <h2 class="text-xl font-bold text-gray-800 hidden sm:block">@yield('header', 'Dashboard')</h2>
            </div>

            <div class="flex items-center space-x-6">
                <div class="hidden md:flex flex-col items-end">
                    <span class="text-sm font-bold text-gray-800">SMA Negeri 1 Tuhemberua</span>
                    <span class="text-[10px] text-gray-500 font-medium">Panel Kepala Sekolah</span>
                </div>
            </div>
        </header>

        <!-- Page Content -->
        <main class="flex-1 p-6 md:p-8 overflow-y-auto">
            @if(session('success'))
                <div class="mb-6 p-4 bg-emerald-50 border border-emerald-100 text-emerald-700 rounded-xl flex items-center shadow-sm animate-fade-in-down">
                    <div class="w-8 h-8 rounded-full bg-emerald-100 flex items-center justify-center mr-3 flex-shrink-0">
                        <i class="fas fa-check text-emerald-600"></i>
                    </div>
                    <span class="font-medium">{{ session('success') }}</span>
                    <button onclick="this.parentElement.remove()" class="ml-auto text-emerald-400 hover:text-emerald-600 p-1">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            @endif

            @if($errors->any())
                <div class="mb-6 p-4 bg-red-50 border border-red-100 text-red-700 rounded-xl shadow-sm animate-fade-in-down">
                    <div class="flex items-center mb-2">
                        <div class="w-8 h-8 rounded-full bg-red-100 flex items-center justify-center mr-3 flex-shrink-0">
                            <i class="fas fa-exclamation text-red-600"></i>
                        </div>
                        <span class="font-bold">Terjadi Kesalahan!</span>
                        <button onclick="this.parentElement.parentElement.remove()" class="ml-auto text-red-400 hover:text-red-600 p-1">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                    <ul class="list-disc list-inside text-sm ml-11 space-y-1 text-red-600">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @yield('content')
        </main>

        <!-- Footer -->
        <footer class="bg-white border-t border-gray-100 py-6 text-center text-sm text-gray-500">
            <p>&copy; 2026 <span class="font-semibold text-gray-700">SMA Negeri 1 Tuhemberua</span>. All rights reserved.</p>
        </footer>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Sidebar Toggle Logic
            const sidebar = document.getElementById('sidebar');
            const sidebarOverlay = document.getElementById('sidebarOverlay');
            const sidebarToggle = document.getElementById('sidebarToggle');

            function toggleSidebar() {
                sidebar.classList.toggle('-translate-x-full');
                sidebar.classList.toggle('translate-x-0');
                sidebarOverlay.classList.toggle('hidden');
                document.body.classList.toggle('overflow-hidden');
            }

            if (sidebarToggle) {
                sidebarToggle.addEventListener('click', toggleSidebar);
            }
            if (sidebarOverlay) {
                sidebarOverlay.addEventListener('click', toggleSidebar);
            }
        });
    </script>
    @stack('scripts')
</body>
</html>
