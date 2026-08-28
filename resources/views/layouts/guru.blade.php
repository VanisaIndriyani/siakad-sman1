<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Guru Dashboard') - SIAKAD SMAN 1 Tuhemberua</title>
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
            background: #10b981; /* Green for Guru */
            border-top-right-radius: 4px;
            border-bottom-right-radius: 4px;
            transform: scaleY(0);
            transition: transform 0.2s ease;
        }
        .sidebar-link:hover::before {
            transform: scaleY(1);
        }
        .sidebar-link.active {
            background: linear-gradient(90deg, rgba(16, 185, 129, 0.15) 0%, rgba(16, 185, 129, 0) 100%);
            color: #34d399;
            font-weight: 600;
        }
        .sidebar-link.active::before {
            transform: scaleY(1);
        }
        .sidebar-link i {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .sidebar-link:hover i {
            transform: scale(1.1) translateX(3px);
            color: #34d399;
        }
        .glass-header {
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border-bottom: 1px solid rgba(229, 231, 235, 0.5);
        }
        .card-modern {
            @apply bg-white rounded-2xl border border-gray-100 shadow-sm hover:shadow-md transition-all duration-300;
        }
    </style>
</head>
<body class="bg-[#f8fafc] text-gray-800 antialiased overflow-x-hidden">

    <!-- Mobile Overlay -->
    <div id="sidebarOverlay" class="fixed inset-0 bg-slate-900/60 z-40 hidden transition-opacity lg:hidden backdrop-blur-sm"></div>

    <!-- Sidebar -->
    <aside id="sidebar" class="fixed inset-y-0 left-0 z-50 w-72 bg-[#0f172a] text-slate-400 transform -translate-x-full lg:translate-x-0 transition-transform duration-300 ease-in-out shadow-2xl flex flex-col border-r border-slate-800">
        <!-- Logo Area -->
        <div class="h-32 flex flex-col items-center justify-center px-6 border-b border-slate-800/50 bg-[#0f172a] relative z-10">
            <div class="flex items-center gap-3">
                <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-green-500 to-emerald-600 flex items-center justify-center shadow-lg shadow-green-500/20 transform hover:rotate-6 transition-transform duration-300">
                    <i class="fas fa-chalkboard-teacher text-white text-xl"></i>
                </div>
                <div>
                    <span class="text-xl font-bold text-white tracking-tight block leading-none">SIAKAD</span>
                    <span class="text-[10px] text-green-500 font-bold uppercase tracking-[0.2em] mt-1 block">Guru Panel</span>
                </div>
            </div>
        </div>

        <!-- Scrollable Container -->
        <div class="flex-1 overflow-y-auto custom-scrollbar flex flex-col py-6">
            <!-- Navigation -->
            <nav class="flex-1 px-4 space-y-1.5">
                <p class="px-4 text-[10px] font-bold text-slate-500 uppercase tracking-widest mb-3 mt-2">Utama</p>
                
                <a href="{{ route('guru.dashboard') }}" class="sidebar-link flex items-center px-4 py-3 text-sm font-medium rounded-xl transition-all duration-200 hover:bg-slate-800/50 hover:text-white group {{ request()->routeIs('guru.dashboard') ? 'active' : '' }}">
                    <i class="fas fa-home w-6 text-center group-hover:text-green-400"></i>
                    <span class="ml-3">Dashboard</span>
                </a>

                <a href="{{ route('notifikasi.index') }}" class="sidebar-link flex items-center justify-between px-4 py-3 text-sm font-medium rounded-xl transition-all duration-200 hover:bg-slate-800/50 hover:text-white group {{ request()->routeIs('notifikasi.*') ? 'active' : '' }}">
                    <span class="flex items-center">
                        <i class="fas fa-bell w-6 text-center group-hover:text-green-400"></i>
                        <span class="ml-3">Notifikasi</span>
                    </span>
                    @php $guruUnread = auth()->user()->unread_count ?? 0; @endphp
                    @if($guruUnread > 0)
                        <span class="ml-auto inline-flex items-center justify-center min-w-[20px] h-5 px-1.5 text-[10px] font-bold text-white bg-red-500 rounded-full">{{ $guruUnread > 99 ? '99+' : $guruUnread }}</span>
                    @endif
                </a>

                <p class="px-4 text-[10px] font-bold text-slate-500 uppercase tracking-widest mt-6 mb-3">Akademik</p>
                
                <a href="{{ route('guru.nilai.index') }}" class="sidebar-link flex items-center px-4 py-3 text-sm font-medium rounded-xl transition-all duration-200 hover:bg-slate-800/50 hover:text-white group {{ request()->routeIs('guru.nilai.*') ? 'active' : '' }}">
                    <i class="fas fa-edit w-6 text-center group-hover:text-green-400"></i>
                    <span class="ml-3">Input Nilai</span>
                </a>
                <a href="{{ route('guru.jadwal.index') }}" class="sidebar-link flex items-center px-4 py-3 text-sm font-medium rounded-xl transition-all duration-200 hover:bg-slate-800/50 hover:text-white group {{ request()->routeIs('guru.jadwal.*') ? 'active' : '' }}">
                    <i class="fas fa-calendar-week w-6 text-center group-hover:text-green-400"></i>
                    <span class="ml-3">Jadwal Mengajar</span>
                </a>
                <a href="{{ route('guru.absensi.index') }}" class="sidebar-link flex items-center px-4 py-3 text-sm font-medium rounded-xl transition-all duration-200 hover:bg-slate-800/50 hover:text-white group {{ request()->routeIs('guru.absensi.*') ? 'active' : '' }}">
                    <i class="fas fa-user-check w-6 text-center group-hover:text-green-400"></i>
                    <span class="ml-3">Absensi Siswa</span>
                </a>
                <a href="{{ route('guru.raport.index') }}" class="sidebar-link flex items-center px-4 py-3 text-sm font-medium rounded-xl transition-all duration-200 hover:bg-slate-800/50 hover:text-white group {{ request()->routeIs('guru.raport.*') ? 'active' : '' }}">
                    <i class="fas fa-clipboard-check w-6 text-center group-hover:text-green-400"></i>
                    <span class="ml-3">Review Raport</span>
                </a>

                <p class="px-4 text-[10px] font-bold text-slate-500 uppercase tracking-widest mt-6 mb-3">Bantuan & Kebijakan</p>

                <a href="{{ route('bantuan.faq') }}" class="sidebar-link flex items-center px-4 py-3 text-sm font-medium rounded-xl transition-all duration-200 hover:bg-slate-800/50 hover:text-white group {{ request()->routeIs('bantuan.faq') ? 'active' : '' }}">
                    <i class="fas fa-circle-question w-6 text-center group-hover:text-green-400"></i>
                    <span class="ml-3">FAQ</span>
                </a>
                <a href="{{ route('bantuan.kebijakan') }}" class="sidebar-link flex items-center px-4 py-3 text-sm font-medium rounded-xl transition-all duration-200 hover:bg-slate-800/50 hover:text-white group {{ request()->routeIs('bantuan.kebijakan') || request()->routeIs('bantuan.kebijakan.show') ? 'active' : '' }}">
                    <i class="fas fa-shield-halved w-6 text-center group-hover:text-green-400"></i>
                    <span class="ml-3">Kebijakan Sistem</span>
                </a>
                <a href="{{ route('bantuan.lapor') }}" class="sidebar-link flex items-center px-4 py-3 text-sm font-medium rounded-xl transition-all duration-200 hover:bg-slate-800/50 hover:text-white group {{ request()->routeIs('bantuan.lapor') ? 'active' : '' }}">
                    <i class="fas fa-circle-exclamation w-6 text-center group-hover:text-green-400"></i>
                    <span class="ml-3">Laporkan Masalah</span>
                </a>

                <p class="px-4 text-[10px] font-bold text-slate-500 uppercase tracking-widest mt-6 mb-3">Pengaturan</p>

                <a href="{{ route('guru.profile.index') }}" class="sidebar-link flex items-center px-4 py-3 text-sm font-medium rounded-xl transition-all duration-200 hover:bg-slate-800/50 hover:text-white group {{ request()->routeIs('guru.profile.*') ? 'active' : '' }}">
                    <i class="fas fa-user-cog w-6 text-center group-hover:text-green-400"></i>
                    <span class="ml-3">Profil Saya</span>
                </a>
            </nav>

            <!-- User Profile -->
            <div class="px-4 mt-8 mb-4">
                <div class="p-4 rounded-2xl bg-slate-800/40 border border-slate-700/50 backdrop-blur-sm">
                    <div class="flex items-center mb-4">
                        <div class="relative">
                            <img class="h-10 w-10 rounded-full object-cover border-2 border-green-500 shadow-lg shadow-green-500/20" src="https://ui-avatars.com/api/?name={{ Auth::user()->name }}&background=10b981&color=fff" alt="Guru Profile">
                            <span class="absolute bottom-0 right-0 w-3 h-3 bg-green-500 border-2 border-[#0f172a] rounded-full"></span>
                        </div>
                        <div class="ml-3 overflow-hidden">
                            <p class="text-sm font-bold text-white truncate">{{ Auth::user()->name }}</p>
                            <p class="text-[10px] text-slate-400 truncate">{{ Auth::user()->email }}</p>
                        </div>
                    </div>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="w-full flex items-center justify-center py-2.5 px-4 bg-red-500/10 hover:bg-red-500 text-red-500 hover:text-white border border-red-500/20 rounded-xl text-xs font-bold uppercase tracking-wider transition-all duration-300 group">
                            <i class="fas fa-sign-out-alt mr-2 group-hover:translate-x-1 transition-transform"></i> Logout
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </aside>

    <!-- Main Content Wrapper -->
    <div class="lg:ml-72 flex flex-col min-h-screen transition-all duration-300">
        
        <!-- Top Navbar -->
        <header class="glass-header h-20 flex items-center justify-between px-6 md:px-10 sticky top-0 z-20">
            <div class="flex items-center">
                <button id="sidebarToggle" class="text-slate-500 hover:text-green-600 focus:outline-none lg:hidden mr-4 p-2.5 rounded-xl hover:bg-green-50 transition-all">
                    <i class="fas fa-bars-staggered text-xl"></i>
                </button>
                <div class="flex flex-col">
                    <h2 class="text-lg md:text-xl font-bold text-slate-800 leading-tight">@yield('header', 'Dashboard Guru')</h2>
                    <p class="text-[10px] md:text-xs text-slate-400 font-medium hidden sm:block">Kelola pengajaran dan nilai siswa Anda</p>
                </div>
            </div>

            <div class="flex items-center gap-3 md:gap-6">
                <!-- School Info -->
                <div class="hidden md:flex flex-col items-end">
                    <span class="text-sm font-bold text-slate-800">SMA Negeri 1 Tuhemberua</span>
                    <span class="text-[10px] text-green-600 font-bold bg-green-50 px-2 py-0.5 rounded-full uppercase tracking-wider">Tahun Ajaran 2025/2026</span>
                </div>

                <!-- Notifications -->
                @include('partials.notifikasi_dropdown')

                <!-- Profile Mobile -->
                <div class="lg:hidden">
                    <img class="h-9 w-9 rounded-full border-2 border-green-500" src="https://ui-avatars.com/api/?name={{ Auth::user()->name }}&background=10b981&color=fff" alt="">
                </div>
            </div>
        </header>

        <!-- Page Content -->
        <main class="flex-1 p-6 md:p-10">
            @if(session('success'))
                <div class="mb-8 p-4 bg-emerald-50 border border-emerald-100 text-emerald-700 rounded-2xl flex items-center shadow-sm animate-fade-in-down">
                    <div class="w-10 h-10 rounded-xl bg-emerald-100 flex items-center justify-center mr-4 flex-shrink-0">
                        <i class="fas fa-check text-emerald-600"></i>
                    </div>
                    <span class="font-semibold text-sm">{{ session('success') }}</span>
                    <button onclick="this.parentElement.remove()" class="ml-auto text-emerald-400 hover:text-emerald-600 p-2 rounded-lg hover:bg-emerald-100/50 transition-all">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            @endif

            @if($errors->any())
                <div class="mb-8 p-4 bg-red-50 border border-red-100 text-red-700 rounded-2xl shadow-sm animate-fade-in-down">
                    <div class="flex items-center mb-3">
                        <div class="w-10 h-10 rounded-xl bg-red-100 flex items-center justify-center mr-4 flex-shrink-0">
                            <i class="fas fa-exclamation-triangle text-red-600"></i>
                        </div>
                        <span class="font-bold text-sm">Terjadi Kesalahan!</span>
                        <button onclick="this.parentElement.parentElement.remove()" class="ml-auto text-red-400 hover:text-red-600 p-2 rounded-lg hover:bg-red-100/50 transition-all">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                    <ul class="list-disc list-inside text-xs ml-14 space-y-1.5 text-red-600 font-medium">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @yield('content')
        </main>

        <!-- Footer -->
        <footer class="bg-white border-t border-slate-100 py-8 px-10 flex flex-col md:flex-row items-center justify-between gap-4">
            <p class="text-sm text-slate-500">&copy; 2026 <span class="font-bold text-slate-800">SMA Negeri 1 Tuhemberua</span>. All rights reserved.</p>
            <div class="flex items-center gap-6">
                <a href="{{ route('bantuan.index') }}" class="text-xs font-bold text-slate-400 hover:text-green-600 transition-colors uppercase tracking-widest">Bantuan</a>
                <a href="{{ route('bantuan.kebijakan') }}" class="text-xs font-bold text-slate-400 hover:text-green-600 transition-colors uppercase tracking-widest">Kebijakan</a>
            </div>
        </footer>
    </div>

    <script src="{{ asset('js/app.js') }}"></script>
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
