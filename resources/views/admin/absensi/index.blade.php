@extends('layouts.admin')

@section('title', 'Laporan Absensi')
@section('header', 'Laporan Absensi Siswa')

@section('content')
    <div class="bg-white rounded-xl border border-gray-100 card-shadow overflow-hidden">
        <div class="p-6 border-b border-gray-100 flex justify-between items-center">
            <h3 class="font-bold text-gray-800">Data Absensi</h3>
            <div class="flex gap-2">
                <a href="{{ route('admin.absensi.pdf', request()->query()) }}" target="_blank" class="bg-red-600 hover:bg-red-700 text-white font-medium py-2 px-4 rounded-lg shadow-sm transition-colors text-sm flex items-center">
                    <i class="fas fa-file-pdf mr-2"></i> Preview & Cetak PDF
                </a>
            </div>
        </div>
        
        <!-- Filter/Search -->
        <form action="{{ route('admin.absensi.index') }}" method="GET" class="p-4 bg-gray-50 border-b border-gray-100 flex gap-4 flex-wrap">
            <div class="relative flex-1 min-w-[200px]">
                <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari Nama Siswa..." class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm">
            </div>
            <select name="kelas_id" onchange="this.form.submit()" class="border border-gray-300 rounded-lg px-4 py-2 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white">
                <option value="">Semua Kelas</option>
                @foreach($kelases as $kelas)
                    <option value="{{ $kelas->id }}" {{ request('kelas_id') == $kelas->id ? 'selected' : '' }}>{{ $kelas->nama_kelas }}</option>
                @endforeach
            </select>
            <select name="mapel_id" onchange="this.form.submit()" class="border border-gray-300 rounded-lg px-4 py-2 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white">
                <option value="">Semua Mapel</option>
                @foreach($mapels as $mapel)
                    <option value="{{ $mapel->id }}" {{ request('mapel_id') == $mapel->id ? 'selected' : '' }}>{{ $mapel->nama_mapel }}</option>
                @endforeach
            </select>
        </form>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-50 text-gray-600 text-xs uppercase tracking-wider">
                        <th class="p-4 font-semibold">Tanggal</th>
                        <th class="p-4 font-semibold">Siswa</th>
                        <th class="p-4 font-semibold">Kelas</th>
                        <th class="p-4 font-semibold">Mata Pelajaran</th>
                        <th class="p-4 font-semibold">Guru</th>
                        <th class="p-4 font-semibold text-center">Status</th>
                        <th class="p-4 font-semibold">Keterangan</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 text-sm">
                    @forelse($absensis as $absensi)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="p-4 whitespace-nowrap text-gray-600">
                            {{ \Carbon\Carbon::parse($absensi->tanggal)->translatedFormat('d F Y') }}
                        </td>
                        <td class="p-4">
                            <div class="font-medium text-gray-800">{{ $absensi->siswa->nama_lengkap }}</div>
                            <div class="text-xs text-gray-500">{{ $absensi->siswa->nisn }}</div>
                        </td>
                        <td class="p-4 text-gray-600">{{ $absensi->kelas->nama_kelas }}</td>
                        <td class="p-4 text-gray-600">{{ $absensi->mapel->nama_mapel }}</td>
                        <td class="p-4 text-gray-600">{{ $absensi->guru->nama_lengkap }}</td>
                        <td class="p-4 text-center">
                            @php
                                $statusColors = [
                                    'Hadir' => 'bg-green-100 text-green-700',
                                    'Izin' => 'bg-blue-100 text-blue-700',
                                    'Sakit' => 'bg-yellow-100 text-yellow-700',
                                    'Alpa' => 'bg-red-100 text-red-700',
                                ];
                                $colorClass = $statusColors[$absensi->status] ?? 'bg-gray-100 text-gray-700';
                            @endphp
                            <span class="{{ $colorClass }} px-2 py-1 rounded text-xs font-semibold">{{ $absensi->status }}</span>
                        </td>
                        <td class="p-4 text-gray-500 italic">{{ $absensi->keterangan ?? '-' }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="p-4 text-center text-gray-500">
                            @if(request('search') || request('kelas_id') || request('mapel_id'))
                                Tidak ada data absensi yang cocok dengan filter.
                            @else
                                Belum ada data absensi.
                            @endif
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <!-- Pagination -->
        <div class="p-4 border-t border-gray-100">
            {{ $absensis->appends(request()->query())->links('pagination.number-123') }}
        </div>
    </div>
    
    <style>
        @media print {
            body * {
                visibility: hidden;
            }
            .card-shadow, .card-shadow * {
                visibility: visible;
            }
            .card-shadow {
                position: absolute;
                left: 0;
                top: 0;
                width: 100%;
                border: none;
                box-shadow: none;
            }
            form, button, .pagination {
                display: none !important;
            }
        }
    </style>
@endsection
