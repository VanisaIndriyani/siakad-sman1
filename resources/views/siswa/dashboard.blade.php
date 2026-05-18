@extends('layouts.siswa')

@section('title', 'Dashboard Siswa')
@section('header', 'Ruang Siswa')

@section('content')
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Left Column -->
        <div class="lg:col-span-2 space-y-6">
            
            <!-- Welcome Card -->
            <div class="relative bg-gradient-to-br from-blue-600 via-indigo-700 to-indigo-900 rounded-3xl p-8 md:p-10 shadow-2xl text-white overflow-hidden group">
                <!-- Background Decorations -->
                <div class="absolute top-0 right-0 -mr-20 -mt-20 w-80 h-80 rounded-full bg-white/10 blur-3xl group-hover:scale-110 transition-transform duration-700"></div>
                <div class="absolute bottom-0 left-0 -ml-20 -mb-20 w-60 h-60 rounded-full bg-blue-400/20 blur-3xl group-hover:scale-110 transition-transform duration-700"></div>
                
                <div class="relative z-10">
                    <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
                        <div class="flex-1">
                            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-white/20 backdrop-blur-md border border-white/30 text-[10px] font-bold uppercase tracking-wider mb-4 animate-pulse">
                                <span class="w-1.5 h-1.5 rounded-full bg-green-400"></span>
                                @php
                                    $hour = date('H');
                                    if ($hour >= 5 && $hour < 12) echo "Selamat Pagi";
                                    elseif ($hour >= 12 && $hour < 15) echo "Selamat Siang";
                                    elseif ($hour >= 15 && $hour < 18) echo "Selamat Sore";
                                    else echo "Selamat Malam";
                                @endphp
                            </div>
                            <h2 class="text-3xl md:text-4xl font-black mb-3 tracking-tight">{{ $siswa->nama_lengkap }}</h2>
                            <p class="text-blue-100 text-sm md:text-base max-w-md leading-relaxed opacity-90 italic">
                                "Pendidikan adalah senjata paling mematikan di dunia, karena dengan pendidikan, kamu bisa mengubah dunia."
                            </p>
                            <div class="mt-8 flex flex-wrap gap-3">
                                <div class="flex items-center gap-2 px-4 py-2 rounded-2xl bg-white text-indigo-900 shadow-xl shadow-indigo-900/20 transition-transform hover:scale-105">
                                    <i class="fas fa-school text-indigo-500"></i>
                                    <span class="text-sm font-black">{{ $siswa->kelas->nama_kelas }}</span>
                                </div>
                                <div class="flex items-center gap-2 px-4 py-2 rounded-2xl bg-white/10 backdrop-blur-md border border-white/20 text-white transition-transform hover:scale-105">
                                    <i class="fas fa-id-card text-blue-300"></i>
                                    <span class="text-sm font-bold tracking-wider">{{ $siswa->nisn }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="hidden md:block">
                            <div class="w-32 h-32 rounded-3xl bg-gradient-to-br from-white/20 to-white/5 backdrop-blur-xl border border-white/30 flex items-center justify-center rotate-6 shadow-2xl transition-transform hover:rotate-0 duration-500">
                                <i class="fas fa-graduation-cap text-6xl text-white"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Academic Stats -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <div class="group bg-white rounded-2xl p-6 border border-gray-100 shadow-sm hover:shadow-xl transition-all duration-300">
                    <div class="flex items-center justify-between mb-4">
                        <div class="w-12 h-12 bg-blue-50 text-blue-600 rounded-xl flex items-center justify-center group-hover:bg-blue-600 group-hover:text-white transition-all">
                            <i class="fas fa-star text-xl"></i>
                        </div>
                        <span class="text-[10px] font-black text-blue-600 bg-blue-50 px-2 py-1 rounded-lg uppercase tracking-wider">Akademik</span>
                    </div>
                    <h3 class="text-slate-500 text-xs font-bold uppercase tracking-widest">Rata-rata Nilai</h3>
                    <div class="flex items-baseline gap-2 mt-1">
                        <p class="text-3xl font-black text-slate-800 tracking-tight">{{ number_format($rataRataNilai, 1) }}</p>
                        <span class="text-xs font-bold text-emerald-500 flex items-center gap-1">
                            <i class="fas fa-arrow-up"></i> Naik
                        </span>
                    </div>
                </div>
                <div class="group bg-white rounded-2xl p-6 border border-gray-100 shadow-sm hover:shadow-xl transition-all duration-300">
                    <div class="flex items-center justify-between mb-4">
                        <div class="w-12 h-12 bg-emerald-50 text-emerald-600 rounded-xl flex items-center justify-center group-hover:bg-emerald-600 group-hover:text-white transition-all">
                            <i class="fas fa-user-check text-xl"></i>
                        </div>
                        <span class="text-[10px] font-black text-emerald-600 bg-emerald-50 px-2 py-1 rounded-lg uppercase tracking-wider">Kehadiran</span>
                    </div>
                    <h3 class="text-slate-500 text-xs font-bold uppercase tracking-widest">Persentase Hadir</h3>
                    <div class="flex items-baseline gap-2 mt-1">
                        <p class="text-3xl font-black text-slate-800 tracking-tight">{{ number_format($kehadiranPercentage, 0) }}%</p>
                        <span class="text-xs font-bold text-slate-400">Semester Ini</span>
                    </div>
                </div>
            </div>

            <!-- Recent Grades -->
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
                <div class="p-6 border-b border-gray-50 flex justify-between items-center bg-white">
                    <h3 class="font-bold text-slate-800">Nilai Terbaru</h3>
                    <a href="{{ route('siswa.nilai.index') }}" class="text-xs font-bold text-blue-600 hover:text-blue-800 uppercase tracking-wider">Lihat Semua</a>
                </div>
                <div class="divide-y divide-gray-50">
                    @forelse($nilaiTerbaru as $nilai)
                    <div class="p-5 flex justify-between items-center hover:bg-slate-50 transition-colors">
                        <div class="flex items-center gap-4">
                            <div class="w-10 h-10 bg-slate-100 rounded-xl flex items-center justify-center text-slate-500">
                                <i class="fas fa-book"></i>
                            </div>
                            <div>
                                <p class="font-bold text-slate-800">{{ $nilai->mapel->nama_mapel }}</p>
                                <p class="text-[10px] text-slate-400 font-bold uppercase tracking-widest">{{ $nilai->kategori }}</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-3">
                            <span class="text-lg font-black {{ $nilai->nilai >= 75 ? 'text-emerald-600' : 'text-orange-600' }}">{{ $nilai->nilai }}</span>
                            <div class="w-1.5 h-1.5 rounded-full {{ $nilai->nilai >= 75 ? 'bg-emerald-500' : 'bg-orange-500' }}"></div>
                        </div>
                    </div>
                    @empty
                    <div class="p-10 text-center">
                        <i class="fas fa-inbox text-slate-200 text-4xl mb-4"></i>
                        <p class="text-slate-400 font-medium text-sm">Belum ada data nilai terbaru.</p>
                    </div>
                    @endforelse
                </div>
            </div>

        </div>

        <!-- Right Column -->
        <div class="space-y-6">
            


            <!-- Announcements -->
            <div class="bg-white rounded-xl border border-gray-100 card-shadow p-5">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="font-bold text-gray-800">Pengumuman Sekolah</h3>
                    <a href="{{ route('siswa.pengumuman.index') }}" class="text-xs text-blue-600 hover:underline">Lihat Semua</a>
                </div>
                <div class="space-y-4">
                    @forelse($pengumumans as $pengumuman)
                        <div class="border-l-4 border-blue-500 pl-3">
                            <p class="text-xs text-gray-500">{{ $pengumuman->created_at->format('d M Y') }}</p>
                            <h4 class="font-semibold text-sm text-gray-800">{{ $pengumuman->judul }}</h4>
                            <p class="text-xs text-gray-600 mt-1 line-clamp-2">{{ Str::limit($pengumuman->isi, 100) }}</p>
                        </div>
                    @empty
                        <p class="text-sm text-gray-500 text-center py-4">Tidak ada pengumuman terbaru.</p>
                    @endforelse
                </div>
            </div>

        </div>
    </div>
@endsection
