@extends('layouts.kepala_sekolah')

@section('title', 'Laporan Akademik')
@section('header', 'Laporan Akademik')

@section('content')
<div class="mb-8">
    <h3 class="text-lg font-bold text-gray-800 mb-4">Statistik Sekolah</h3>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm">
            <div class="flex items-center justify-between mb-4">
                <span class="text-sm font-medium text-gray-500">Kapasitas Kelas</span>
                <i class="fas fa-school text-blue-500"></i>
            </div>
            <div class="flex items-baseline">
                <h4 class="text-3xl font-bold text-gray-800">{{ $totalKelas }}</h4>
                <span class="ml-2 text-sm text-gray-500">Kelas Aktif</span>
            </div>
        </div>
        <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm">
            <div class="flex items-center justify-between mb-4">
                <span class="text-sm font-medium text-gray-500">Rasio Guru:Siswa</span>
                <i class="fas fa-users text-indigo-500"></i>
            </div>
            <div class="flex items-baseline">
                <h4 class="text-3xl font-bold text-gray-800">1:{{ $totalGuru > 0 ? round($totalSiswa / $totalGuru) : 0 }}</h4>
                <span class="ml-2 text-sm text-gray-500">Rata-rata</span>
            </div>
        </div>
        <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm">
            <div class="flex items-center justify-between mb-4">
                <span class="text-sm font-medium text-gray-500">Total Siswa</span>
                <i class="fas fa-user-graduate text-emerald-500"></i>
            </div>
            <div class="flex items-baseline">
                <h4 class="text-3xl font-bold text-gray-800">{{ $totalSiswa }}</h4>
                <span class="ml-2 text-sm text-gray-500">Siswa Terdaftar</span>
            </div>
        </div>
    </div>
</div>

<div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="p-6 border-b border-gray-50 flex justify-between items-center">
        <h3 class="text-lg font-bold text-gray-800">Statistik per Kelas</h3>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-left">
            <thead>
                <tr class="bg-gray-50/50">
                    <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider">Nama Kelas</th>
                    <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider">Jurusan</th>
                    <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider">Jumlah Siswa</th>
                    <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @foreach($kelasStats as $k)
                <tr class="hover:bg-gray-50/50 transition-colors">
                    <td class="px-6 py-4">
                        <span class="font-semibold text-gray-700">{{ $k->nama_kelas }}</span>
                    </td>
                    <td class="px-6 py-4 text-sm text-gray-600">
                        {{ $k->jurusan }}
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex items-center">
                            <span class="text-sm font-medium text-gray-700 mr-3">{{ $k->siswas_count }} Siswa</span>
                            <div class="w-24 bg-gray-100 rounded-full h-1.5">
                                <div class="bg-blue-500 h-1.5 rounded-full" style="width: {{ $totalSiswa > 0 ? ($k->siswas_count / $totalSiswa) * 100 : 0 }}%"></div>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <a href="{{ route('kepala_sekolah.monitoring.nilai', ['kelas_id' => $k->id]) }}" class="text-blue-600 hover:text-blue-800 text-sm font-semibold">
                            Lihat Nilai
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
