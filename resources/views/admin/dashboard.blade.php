@extends('layouts.admin')

@section('title', 'Dashboard Admin')
@section('header', 'Dashboard Overview')

@section('content')
    <!-- Welcome Banner -->
    <div class="relative bg-gradient-to-r from-blue-600 to-indigo-700 rounded-2xl p-6 md:p-10 mb-8 shadow-lg overflow-hidden">
        <div class="absolute right-0 top-0 h-full w-1/2 bg-white opacity-5 transform skew-x-12 translate-x-20"></div>
        <div class="relative z-10 text-white">
            <h1 class="text-3xl font-bold mb-2">Selamat Datang, Administrator! 👋</h1>
            <p class="text-blue-100 max-w-xl text-lg">Kelola data akademik SMA Negeri 1 Tuhemberua dengan mudah dan efisien. Cek ringkasan statistik hari ini di bawah.</p>
            <div class="mt-6 flex flex-wrap gap-3">
                <a href="{{ route('admin.pengumuman.index') }}" class="bg-white/20 hover:bg-white/30 backdrop-blur-sm border border-white/30 text-white px-4 py-2 rounded-lg text-sm font-medium transition-all">
                    <i class="fas fa-bullhorn mr-2"></i> Buat Pengumuman
                </a>
                <a href="#" class="bg-white text-blue-700 hover:bg-blue-50 px-4 py-2 rounded-lg text-sm font-bold shadow-sm transition-all">
                    <i class="fas fa-file-alt mr-2"></i> Laporan Bulanan
                </a>
            </div>
        </div>
        <!-- Decoration Circle -->
        <div class="absolute -bottom-10 -left-10 w-40 h-40 bg-white opacity-10 rounded-full blur-2xl"></div>
    </div>

    <!-- Stats Cards Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Card Siswa -->
        <div class="group bg-white rounded-2xl p-6 border border-gray-100 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300 relative overflow-hidden">
            <div class="absolute -right-4 -top-4 w-24 h-24 bg-blue-50 rounded-full opacity-0 group-hover:opacity-100 transition-all duration-500 scale-50 group-hover:scale-100"></div>
            <div class="relative z-10">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-12 h-12 bg-blue-50 text-blue-600 rounded-xl flex items-center justify-center group-hover:bg-blue-600 group-hover:text-white transition-colors duration-300">
                        <i class="fas fa-user-graduate text-xl"></i>
                    </div>
                    <div class="flex flex-col items-end">
                        <span class="text-[10px] font-bold text-blue-600 bg-blue-50 px-2 py-1 rounded-lg uppercase tracking-wider">Siswa</span>
                    </div>
                </div>
                <h3 class="text-slate-500 text-xs font-bold uppercase tracking-widest">Total Siswa</h3>
                <div class="flex items-baseline gap-2 mt-1">
                    <p class="text-3xl font-black text-slate-800 tracking-tight">{{ number_format($totalSiswa) }}</p>
                    <span class="text-xs font-bold text-emerald-500 flex items-center gap-1">
                        <i class="fas fa-caret-up"></i> 5%
                    </span>
                </div>
                <div class="mt-4 pt-4 border-t border-gray-50 flex items-center justify-between">
                    <span class="text-[10px] text-slate-400 font-medium">Aktif Semester Ini</span>
                    <a href="{{ route('admin.siswa.index') }}" class="w-6 h-6 rounded-lg bg-slate-50 text-slate-400 flex items-center justify-center hover:bg-blue-600 hover:text-white transition-all">
                        <i class="fas fa-chevron-right text-[10px]"></i>
                    </a>
                </div>
            </div>
        </div>

        <!-- Card Guru -->
        <div class="group bg-white rounded-2xl p-6 border border-gray-100 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300 relative overflow-hidden">
            <div class="absolute -right-4 -top-4 w-24 h-24 bg-indigo-50 rounded-full opacity-0 group-hover:opacity-100 transition-all duration-500 scale-50 group-hover:scale-100"></div>
            <div class="relative z-10">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-12 h-12 bg-indigo-50 text-indigo-600 rounded-xl flex items-center justify-center group-hover:bg-indigo-600 group-hover:text-white transition-colors duration-300">
                        <i class="fas fa-chalkboard-teacher text-xl"></i>
                    </div>
                    <div class="flex flex-col items-end">
                        <span class="text-[10px] font-bold text-indigo-600 bg-indigo-50 px-2 py-1 rounded-lg uppercase tracking-wider">Guru</span>
                    </div>
                </div>
                <h3 class="text-slate-500 text-xs font-bold uppercase tracking-widest">Total Guru</h3>
                <div class="flex items-baseline gap-2 mt-1">
                    <p class="text-3xl font-black text-slate-800 tracking-tight">{{ number_format($totalGuru) }}</p>
                    <span class="text-xs font-bold text-slate-400">Orang</span>
                </div>
                <div class="mt-4 pt-4 border-t border-gray-50 flex items-center justify-between">
                    <span class="text-[10px] text-slate-400 font-medium">Tenaga Pendidik</span>
                    <a href="{{ route('admin.guru.index') }}" class="w-6 h-6 rounded-lg bg-slate-50 text-slate-400 flex items-center justify-center hover:bg-indigo-600 hover:text-white transition-all">
                        <i class="fas fa-chevron-right text-[10px]"></i>
                    </a>
                </div>
            </div>
        </div>

        <!-- Card Kelas -->
        <div class="group bg-white rounded-2xl p-6 border border-gray-100 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300 relative overflow-hidden">
            <div class="absolute -right-4 -top-4 w-24 h-24 bg-purple-50 rounded-full opacity-0 group-hover:opacity-100 transition-all duration-500 scale-50 group-hover:scale-100"></div>
            <div class="relative z-10">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-12 h-12 bg-purple-50 text-purple-600 rounded-xl flex items-center justify-center group-hover:bg-purple-600 group-hover:text-white transition-colors duration-300">
                        <i class="fas fa-school text-xl"></i>
                    </div>
                    <div class="flex flex-col items-end">
                        <span class="text-[10px] font-bold text-purple-600 bg-purple-50 px-2 py-1 rounded-lg uppercase tracking-wider">Kelas</span>
                    </div>
                </div>
                <h3 class="text-slate-500 text-xs font-bold uppercase tracking-widest">Total Kelas</h3>
                <div class="flex items-baseline gap-2 mt-1">
                    <p class="text-3xl font-black text-slate-800 tracking-tight">{{ number_format($totalKelas) }}</p>
                    <span class="text-xs font-bold text-slate-400">Rombel</span>
                </div>
                <div class="mt-4 pt-4 border-t border-gray-50 flex items-center justify-between">
                    <span class="text-[10px] text-slate-400 font-medium">Tersedia Saat Ini</span>
                    <a href="{{ route('admin.kelas.index') }}" class="w-6 h-6 rounded-lg bg-slate-50 text-slate-400 flex items-center justify-center hover:bg-purple-600 hover:text-white transition-all">
                        <i class="fas fa-chevron-right text-[10px]"></i>
                    </a>
                </div>
            </div>
        </div>

        <!-- Card Mapel -->
        <div class="group bg-white rounded-2xl p-6 border border-gray-100 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300 relative overflow-hidden">
            <div class="absolute -right-4 -top-4 w-24 h-24 bg-orange-50 rounded-full opacity-0 group-hover:opacity-100 transition-all duration-500 scale-50 group-hover:scale-100"></div>
            <div class="relative z-10">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-12 h-12 bg-orange-50 text-orange-600 rounded-xl flex items-center justify-center group-hover:bg-orange-600 group-hover:text-white transition-colors duration-300">
                        <i class="fas fa-book text-xl"></i>
                    </div>
                    <div class="flex flex-col items-end">
                        <span class="text-[10px] font-bold text-orange-600 bg-orange-50 px-2 py-1 rounded-lg uppercase tracking-wider">Mapel</span>
                    </div>
                </div>
                <h3 class="text-slate-500 text-xs font-bold uppercase tracking-widest">Mata Pelajaran</h3>
                <div class="flex items-baseline gap-2 mt-1">
                    <p class="text-3xl font-black text-slate-800 tracking-tight">{{ number_format($totalMapel) }}</p>
                    <span class="text-xs font-bold text-slate-400">Subjek</span>
                </div>
                <div class="mt-4 pt-4 border-t border-gray-50 flex items-center justify-between">
                    <span class="text-[10px] text-slate-400 font-medium">Kurikulum Aktif</span>
                    <a href="{{ route('admin.mapel.index') }}" class="w-6 h-6 rounded-lg bg-slate-50 text-slate-400 flex items-center justify-center hover:bg-orange-600 hover:text-white transition-all">
                        <i class="fas fa-chevron-right text-[10px]"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Main Activity Table -->
        <div class="lg:col-span-2 bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden">
            <div class="p-6 border-b border-gray-100 flex justify-between items-center bg-gray-50/50">
                <div>
                    <h3 class="font-bold text-gray-800 text-lg">Aktivitas Terbaru</h3>
                    <p class="text-xs text-gray-500 mt-1">Monitoring kegiatan sistem real-time</p>
                </div>
                <button class="text-sm text-blue-600 hover:text-blue-800 font-medium flex items-center gap-1 transition-colors">
                    Lihat Semua <i class="fas fa-arrow-right text-xs"></i>
                </button>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-gray-50 border-b border-gray-100 text-gray-500 text-xs uppercase tracking-wider">
                            <th class="p-4 font-semibold">User</th>
                            <th class="p-4 font-semibold">Aktivitas</th>
                            <th class="p-4 font-semibold">Waktu</th>
                            <th class="p-4 font-semibold text-center">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 text-sm">
                        <tr class="hover:bg-blue-50/30 transition-colors group">
                            <td class="p-4">
                                <div class="flex items-center">
                                    <div class="relative">
                                        <img src="https://ui-avatars.com/api/?name=Budi+Santoso&background=e0e7ff&color=4f46e5" class="w-9 h-9 rounded-full border-2 border-white shadow-sm" alt="Avatar">
                                        <span class="absolute bottom-0 right-0 w-2.5 h-2.5 bg-green-500 border-2 border-white rounded-full"></span>
                                    </div>
                                    <div class="ml-3">
                                        <p class="font-semibold text-gray-800">Budi Santoso</p>
                                        <p class="text-xs text-gray-500">Guru Matematika</p>
                                    </div>
                                </div>
                            </td>
                            <td class="p-4 text-gray-600 group-hover:text-blue-600 transition-colors">Input Nilai UH1 Kelas X-A</td>
                            <td class="p-4 text-gray-500 text-xs">
                                <i class="far fa-clock mr-1"></i> 2 menit lalu
                            </td>
                            <td class="p-4 text-center">
                                <span class="bg-green-100 text-green-700 px-2.5 py-1 rounded-full text-xs font-semibold inline-flex items-center gap-1">
                                    <i class="fas fa-check-circle text-[10px]"></i> Selesai
                                </span>
                            </td>
                        </tr>
                        <tr class="hover:bg-blue-50/30 transition-colors group">
                            <td class="p-4">
                                <div class="flex items-center">
                                    <div class="relative">
                                        <img src="https://ui-avatars.com/api/?name=Siti+Aminah&background=fce7f3&color=db2777" class="w-9 h-9 rounded-full border-2 border-white shadow-sm" alt="Avatar">
                                    </div>
                                    <div class="ml-3">
                                        <p class="font-semibold text-gray-800">Siti Aminah</p>
                                        <p class="text-xs text-gray-500">Administrator</p>
                                    </div>
                                </div>
                            </td>
                            <td class="p-4 text-gray-600 group-hover:text-blue-600 transition-colors">Update Data Siswa Kelas XII</td>
                            <td class="p-4 text-gray-500 text-xs">
                                <i class="far fa-clock mr-1"></i> 15 menit lalu
                            </td>
                            <td class="p-4 text-center">
                                <span class="bg-blue-100 text-blue-700 px-2.5 py-1 rounded-full text-xs font-semibold inline-flex items-center gap-1">
                                    <i class="fas fa-spinner fa-spin text-[10px]"></i> Proses
                                </span>
                            </td>
                        </tr>
                        <tr class="hover:bg-blue-50/30 transition-colors group">
                            <td class="p-4">
                                <div class="flex items-center">
                                    <div class="relative">
                                        <img src="https://ui-avatars.com/api/?name=Ahmad+Rizky&background=ffedd5&color=c2410c" class="w-9 h-9 rounded-full border-2 border-white shadow-sm" alt="Avatar">
                                        <span class="absolute bottom-0 right-0 w-2.5 h-2.5 bg-gray-400 border-2 border-white rounded-full"></span>
                                    </div>
                                    <div class="ml-3">
                                        <p class="font-semibold text-gray-800">Ahmad Rizky</p>
                                        <p class="text-xs text-gray-500">Siswa XII IPA 1</p>
                                    </div>
                                </div>
                            </td>
                            <td class="p-4 text-gray-600 group-hover:text-blue-600 transition-colors">Login ke Portal Siswa</td>
                            <td class="p-4 text-gray-500 text-xs">
                                <i class="far fa-clock mr-1"></i> 1 jam lalu
                            </td>
                            <td class="p-4 text-center">
                                <span class="bg-gray-100 text-gray-600 px-2.5 py-1 rounded-full text-xs font-semibold">
                                    Log
                                </span>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Quick Actions & Info -->
        <div class="flex flex-col gap-6">
            <!-- Quick Actions -->
            <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-6">
                <h3 class="font-bold text-gray-800 mb-4">Aksi Cepat</h3>
                <div class="grid grid-cols-2 gap-3">
                    <a href="{{ route('admin.siswa.index') }}" class="flex flex-col items-center justify-center p-4 rounded-xl bg-blue-50 hover:bg-blue-100 text-blue-700 transition-colors group cursor-pointer">
                        <div class="w-10 h-10 bg-white rounded-full flex items-center justify-center shadow-sm mb-2 group-hover:scale-110 transition-transform">
                            <i class="fas fa-user-plus text-lg"></i>
                        </div>
                        <span class="text-xs font-bold">Tambah Siswa</span>
                    </a>
                    <a href="{{ route('admin.guru.index') }}" class="flex flex-col items-center justify-center p-4 rounded-xl bg-indigo-50 hover:bg-indigo-100 text-indigo-700 transition-colors group cursor-pointer">
                        <div class="w-10 h-10 bg-white rounded-full flex items-center justify-center shadow-sm mb-2 group-hover:scale-110 transition-transform">
                            <i class="fas fa-chalkboard-teacher text-lg"></i>
                        </div>
                        <span class="text-xs font-bold">Tambah Guru</span>
                    </a>
                    <a href="{{ route('admin.jadwal.index') }}" class="flex flex-col items-center justify-center p-4 rounded-xl bg-purple-50 hover:bg-purple-100 text-purple-700 transition-colors group cursor-pointer">
                        <div class="w-10 h-10 bg-white rounded-full flex items-center justify-center shadow-sm mb-2 group-hover:scale-110 transition-transform">
                            <i class="fas fa-calendar-plus text-lg"></i>
                        </div>
                        <span class="text-xs font-bold">Atur Jadwal</span>
                    </a>
                    <a href="{{ route('admin.pengumuman.index') }}" class="flex flex-col items-center justify-center p-4 rounded-xl bg-orange-50 hover:bg-orange-100 text-orange-700 transition-colors group cursor-pointer">
                        <div class="w-10 h-10 bg-white rounded-full flex items-center justify-center shadow-sm mb-2 group-hover:scale-110 transition-transform">
                            <i class="fas fa-bullhorn text-lg"></i>
                        </div>
                        <span class="text-xs font-bold">Pengumuman</span>
                    </a>
                </div>
            </div>

         
        </div>
    </div>
@endsection
