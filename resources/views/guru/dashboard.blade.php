@extends('layouts.guru')

@section('title', 'Dashboard Guru')
@section('header', 'Overview Mengajar')

@section('content')
    <!-- Welcome Banner -->
    <div class="relative bg-gradient-to-r from-emerald-600 to-teal-700 rounded-2xl p-6 md:p-10 mb-8 shadow-lg overflow-hidden">
        <div class="absolute right-0 top-0 h-full w-1/2 bg-white opacity-5 transform skew-x-12 translate-x-20"></div>
        <div class="relative z-10 text-white">
            <h1 class="text-3xl font-bold mb-2">Selamat Datang, {{ $guru->nama_lengkap }}! 👋</h1>
            <p class="text-emerald-100 max-w-xl text-lg">Kelola pengajaran dan pantau perkembangan akademik siswa Anda dengan mudah.</p>
            <div class="mt-6 flex flex-wrap gap-3">
                <a href="{{ route('guru.nilai.index') }}" class="bg-white text-emerald-700 hover:bg-emerald-50 px-4 py-2 rounded-lg text-sm font-bold shadow-sm transition-all">
                    <i class="fas fa-plus-circle mr-2"></i> Input Nilai
                </a>
                <a href="{{ route('guru.absensi.index') }}" class="bg-white/20 hover:bg-white/30 backdrop-blur-sm border border-white/30 text-white px-4 py-2 rounded-lg text-sm font-medium transition-all">
                    <i class="fas fa-user-check mr-2"></i> Absensi Hari Ini
                </a>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <!-- Classes Card -->
        <div class="group bg-white rounded-2xl p-6 border border-gray-100 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300 relative overflow-hidden">
            <div class="relative z-10">
                <div class="flex justify-between items-start mb-4">
                    <div class="w-12 h-12 bg-emerald-50 text-emerald-600 rounded-xl flex items-center justify-center group-hover:bg-emerald-600 group-hover:text-white transition-colors duration-300">
                        <i class="fas fa-users text-xl"></i>
                    </div>
                    <span class="text-[10px] font-bold text-emerald-600 bg-emerald-50 px-2 py-1 rounded-lg uppercase tracking-wider">Kelas</span>
                </div>
                <h3 class="text-slate-500 text-xs font-bold uppercase tracking-widest">Kelas Diampu</h3>
                <p class="text-3xl font-black text-slate-800 mt-1 tracking-tight">{{ $kelasDiampuCount }}</p>
                <div class="mt-4 pt-4 border-t border-gray-50">
                    <p class="text-[10px] text-slate-400 font-medium truncate">{{ $kelasDiampuList }}</p>
                </div>
            </div>
        </div>

        <!-- Pending Grades -->
        <div class="group bg-white rounded-2xl p-6 border border-gray-100 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300 relative overflow-hidden">
            <div class="relative z-10">
                <div class="flex justify-between items-start mb-4">
                    <div class="w-12 h-12 bg-orange-50 text-orange-600 rounded-xl flex items-center justify-center group-hover:bg-orange-600 group-hover:text-white transition-colors duration-300">
                        <i class="fas fa-exclamation-circle text-xl"></i>
                    </div>
                    <span class="text-[10px] font-bold text-orange-600 bg-orange-50 px-2 py-1 rounded-lg uppercase tracking-wider">Status</span>
                </div>
                <h3 class="text-slate-500 text-xs font-bold uppercase tracking-widest">Nilai Belum Input</h3>
                <p class="text-3xl font-black text-slate-800 mt-1 tracking-tight">2</p>
                <div class="mt-4 pt-4 border-t border-gray-50 flex items-center justify-between">
                    <a href="{{ route('guru.nilai.index') }}" class="text-[10px] text-orange-600 font-bold hover:underline uppercase tracking-wider">Lengkapi Sekarang &rarr;</a>
                </div>
            </div>
        </div>

         <!-- Schedule Today -->
        <div class="group bg-white rounded-2xl p-6 border border-gray-100 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300 relative overflow-hidden">
            <div class="relative z-10">
                <div class="flex justify-between items-start mb-4">
                    <div class="w-12 h-12 bg-blue-50 text-blue-600 rounded-xl flex items-center justify-center group-hover:bg-blue-600 group-hover:text-white transition-colors duration-300">
                        <i class="fas fa-clock text-xl"></i>
                    </div>
                    <span class="text-[10px] font-bold text-blue-600 bg-blue-50 px-2 py-1 rounded-lg uppercase tracking-wider">Waktu</span>
                </div>
                <h3 class="text-slate-500 text-xs font-bold uppercase tracking-widest">Jadwal Hari Ini</h3>
                <p class="text-3xl font-black text-slate-800 mt-1 tracking-tight">{{ $jadwalHariIniCount }}</p>
                <div class="mt-4 pt-4 border-t border-gray-50">
                    <p class="text-[10px] text-slate-400 font-medium truncate">
                        @if($jadwalHariIni->isNotEmpty())
                            {{ $jadwalHariIni->first()->jam_mulai }} - {{ $jadwalHariIni->last()->jam_selesai }}
                        @else
                            Tidak ada jadwal aktif
                        @endif
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Jadwal Mengajar Table -->
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
        <div class="p-6 border-b border-gray-50 flex justify-between items-center bg-white">
            <h3 class="font-bold text-slate-800">Jadwal Mengajar Hari Ini</h3>
            <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">{{ date('l, d F Y') }}</span>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead>
                    <tr class="bg-slate-50/50 text-slate-500 text-[10px] font-bold uppercase tracking-widest">
                        <th class="px-6 py-4">Waktu</th>
                        <th class="px-6 py-4">Kelas</th>
                        <th class="px-6 py-4">Mata Pelajaran</th>
                        <th class="px-6 py-4">Ruangan</th>
                        <th class="px-6 py-4">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50 text-sm">
                    @forelse($jadwalHariIni as $jadwal)
                    <tr class="hover:bg-slate-50/50 transition-colors group">
                        <td class="px-6 py-4 font-bold text-slate-700">
                            <div class="flex items-center gap-2">
                                <i class="far fa-clock text-emerald-500"></i>
                                {{ $jadwal->jam_mulai }} - {{ $jadwal->jam_selesai }}
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <span class="bg-slate-100 text-slate-700 px-3 py-1 rounded-lg font-bold text-xs">{{ $jadwal->kelas->nama_kelas }}</span>
                        </td>
                        <td class="px-6 py-4 font-medium text-slate-600">{{ $jadwal->mapel->nama_mapel }}</td>
                        <td class="px-6 py-4 text-slate-500 text-xs">{{ $jadwal->ruangan ?? 'R. Belajar' }}</td>
                        <td class="px-6 py-4">
                            <a href="{{ route('guru.absensi.index') }}" class="bg-emerald-50 text-emerald-600 hover:bg-emerald-600 hover:text-white px-3 py-1.5 rounded-lg font-bold text-[10px] transition-all uppercase tracking-wider">
                                Absen Siswa
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-12 text-center">
                            <div class="flex flex-col items-center">
                                <div class="w-16 h-16 bg-slate-50 rounded-full flex items-center justify-center mb-4">
                                    <i class="fas fa-calendar-day text-slate-200 text-2xl"></i>
                                </div>
                                <p class="text-slate-400 font-medium">Tidak ada jadwal mengajar untuk hari ini.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
