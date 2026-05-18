@extends('layouts.kepala_sekolah')

@section('title', 'Dashboard Kepala Sekolah')
@section('header', 'Dashboard Utama')

@section('content')
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <!-- Stats Cards -->
    <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex items-center">
        <div class="w-12 h-12 rounded-xl bg-blue-50 flex items-center justify-center text-blue-600 mr-4">
            <i class="fas fa-user-graduate text-xl"></i>
        </div>
        <div>
            <p class="text-sm text-gray-500 font-medium">Total Siswa</p>
            <h3 class="text-2xl font-bold text-gray-800">{{ $totalSiswa }}</h3>
        </div>
    </div>

    <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex items-center">
        <div class="w-12 h-12 rounded-xl bg-indigo-50 flex items-center justify-center text-indigo-600 mr-4">
            <i class="fas fa-chalkboard-teacher text-xl"></i>
        </div>
        <div>
            <p class="text-sm text-gray-500 font-medium">Total Guru</p>
            <h3 class="text-2xl font-bold text-gray-800">{{ $totalGuru }}</h3>
        </div>
    </div>

    <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex items-center">
        <div class="w-12 h-12 rounded-xl bg-emerald-50 flex items-center justify-center text-emerald-600 mr-4">
            <i class="fas fa-star text-xl"></i>
        </div>
        <div>
            <p class="text-sm text-gray-500 font-medium">Rata-rata Nilai</p>
            <h3 class="text-2xl font-bold text-gray-800">{{ number_format($rataRataNilaiSekolah, 1) }}</h3>
        </div>
    </div>

    <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex items-center">
        <div class="w-12 h-12 rounded-xl bg-amber-50 flex items-center justify-center text-amber-600 mr-4">
            <i class="fas fa-user-check text-xl"></i>
        </div>
        <div>
            <p class="text-sm text-gray-500 font-medium">Absensi Hari Ini</p>
            <h3 class="text-2xl font-bold text-gray-800">{{ $totalAbsensiHariIni }}</h3>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
    <!-- Quick Actions -->
    <div class="bg-white p-8 rounded-2xl shadow-sm border border-gray-100">
        <h3 class="text-lg font-bold text-gray-800 mb-6">Akses Cepat Monitoring</h3>
        <div class="grid grid-cols-2 gap-4">
            <a href="{{ route('kepala_sekolah.laporan.akademik') }}" class="p-4 rounded-xl border border-gray-100 hover:border-blue-200 hover:bg-blue-50 transition-all group">
                <div class="w-10 h-10 rounded-lg bg-blue-100 text-blue-600 flex items-center justify-center mb-3 group-hover:scale-110 transition-transform">
                    <i class="fas fa-chart-bar"></i>
                </div>
                <span class="text-sm font-semibold text-gray-700">Laporan Akademik</span>
            </a>
            <a href="{{ route('kepala_sekolah.monitoring.nilai') }}" class="p-4 rounded-xl border border-gray-100 hover:border-indigo-200 hover:bg-indigo-50 transition-all group">
                <div class="w-10 h-10 rounded-lg bg-indigo-100 text-indigo-600 flex items-center justify-center mb-3 group-hover:scale-110 transition-transform">
                    <i class="fas fa-clipboard-list"></i>
                </div>
                <span class="text-sm font-semibold text-gray-700">Monitoring Nilai</span>
            </a>
            <a href="{{ route('kepala_sekolah.monitoring.absensi') }}" class="p-4 rounded-xl border border-gray-100 hover:border-amber-200 hover:bg-amber-50 transition-all group">
                <div class="w-10 h-10 rounded-lg bg-amber-100 text-amber-600 flex items-center justify-center mb-3 group-hover:scale-110 transition-transform">
                    <i class="fas fa-user-clock"></i>
                </div>
                <span class="text-sm font-semibold text-gray-700">Monitoring Absensi</span>
            </a>
            <a href="{{ route('kepala_sekolah.raport.verifikasi') }}" class="p-4 rounded-xl border border-gray-100 hover:border-emerald-200 hover:bg-emerald-50 transition-all group">
                <div class="w-10 h-10 rounded-lg bg-emerald-100 text-emerald-600 flex items-center justify-center mb-3 group-hover:scale-110 transition-transform">
                    <i class="fas fa-file-signature"></i>
                </div>
                <span class="text-sm font-semibold text-gray-700">Verifikasi Raport</span>
            </a>
        </div>
    </div>

    <!-- Info Card -->
    <div class="bg-gradient-to-br from-indigo-600 to-purple-700 p-8 rounded-2xl shadow-lg text-white relative overflow-hidden">
        <div class="relative z-10">
            <h3 class="text-xl font-bold mb-4">Selamat Datang, Bapak/Ibu Kepala Sekolah</h3>
            <p class="text-indigo-100 mb-6 leading-relaxed">
                Panel ini dirancang khusus untuk memudahkan Anda dalam memantau seluruh aktivitas akademik di SMA Negeri 1 Tuhemberua secara real-time.
            </p>
            <div class="flex items-center space-x-4">
                <div class="flex -space-x-2">
                    <img class="w-8 h-8 rounded-full border-2 border-indigo-400" src="https://ui-avatars.com/api/?name=G&background=random" alt="">
                    <img class="w-8 h-8 rounded-full border-2 border-indigo-400" src="https://ui-avatars.com/api/?name=S&background=random" alt="">
                    <img class="w-8 h-8 rounded-full border-2 border-indigo-400" src="https://ui-avatars.com/api/?name=K&background=random" alt="">
                </div>
                <span class="text-xs font-medium text-indigo-200">Terhubung dengan {{ $totalGuru }} Guru & {{ $totalSiswa }} Siswa</span>
            </div>
        </div>
        <i class="fas fa-quote-right absolute -bottom-4 -right-4 text-white/10 text-9xl"></i>
    </div>
</div>
@endsection
