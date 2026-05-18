@extends('layouts.siswa')

@section('title', 'Laporan Absensi')
@section('header', 'Laporan Kehadiran')

@section('content')
<div class="space-y-6">
    <!-- Summary Cards -->
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
        <div class="bg-green-100 p-4 rounded-xl border border-green-200 text-center">
            <h3 class="text-green-800 font-bold text-sm uppercase tracking-wider">Hadir</h3>
            <p class="text-3xl font-bold text-green-600 mt-2">{{ $summary['Hadir'] }}</p>
        </div>
        <div class="bg-blue-100 p-4 rounded-xl border border-blue-200 text-center">
            <h3 class="text-blue-800 font-bold text-sm uppercase tracking-wider">Izin</h3>
            <p class="text-3xl font-bold text-blue-600 mt-2">{{ $summary['Izin'] }}</p>
        </div>
        <div class="bg-yellow-100 p-4 rounded-xl border border-yellow-200 text-center">
            <h3 class="text-yellow-800 font-bold text-sm uppercase tracking-wider">Sakit</h3>
            <p class="text-3xl font-bold text-yellow-600 mt-2">{{ $summary['Sakit'] }}</p>
        </div>
        <div class="bg-red-100 p-4 rounded-xl border border-red-200 text-center">
            <h3 class="text-red-800 font-bold text-sm uppercase tracking-wider">Alpa</h3>
            <p class="text-3xl font-bold text-red-600 mt-2">{{ $summary['Alpa'] }}</p>
        </div>
    </div>

    <!-- Attendance List -->
    <div class="bg-white rounded-xl border border-gray-100 card-shadow overflow-hidden">
        <div class="p-6 border-b border-gray-100 flex justify-between items-center">
            <h3 class="font-bold text-gray-800">Riwayat Kehadiran</h3>
            <span class="text-xs text-gray-500">Semester Genap 2025/2026</span>
        </div>
        
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 border-b">
                    <tr>
                        <th class="px-6 py-3 font-medium">Tanggal</th>
                        <th class="px-6 py-3 font-medium">Mata Pelajaran</th>
                        <th class="px-6 py-3 font-medium text-center">Status</th>
                        <th class="px-6 py-3 font-medium">Keterangan</th>
                        <th class="px-6 py-3 font-medium">Guru</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($absensis as $absensi)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4 text-gray-900 font-medium">
                                {{ \Carbon\Carbon::parse($absensi->tanggal)->translatedFormat('d F Y') }}
                            </td>
                            <td class="px-6 py-4">
                                <div class="font-bold text-gray-800">{{ $absensi->mapel->nama_mapel }}</div>
                            </td>
                            <td class="px-6 py-4 text-center">
                                @if($absensi->status == 'Hadir')
                                    <span class="px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">Hadir</span>
                                @elseif($absensi->status == 'Izin')
                                    <span class="px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">Izin</span>
                                @elseif($absensi->status == 'Sakit')
                                    <span class="px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">Sakit</span>
                                @else
                                    <span class="px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">Alpa</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-gray-500">
                                {{ $absensi->keterangan ?? '-' }}
                            </td>
                            <td class="px-6 py-4 text-gray-500 text-xs">
                                {{ $absensi->guru->nama_lengkap }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-8 text-center text-gray-500">
                                Belum ada data absensi.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <div class="p-4 border-t border-gray-100">
            {{ $absensis->links() }}
        </div>
    </div>
</div>
@endsection