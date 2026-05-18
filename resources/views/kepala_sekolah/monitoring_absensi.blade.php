@extends('layouts.kepala_sekolah')

@section('title', 'Monitoring Absensi')
@section('header', 'Monitoring Absensi Siswa')

@section('content')
<div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 mb-8">
    <form action="{{ route('kepala_sekolah.monitoring.absensi') }}" method="GET" class="flex flex-col md:flex-row gap-4 items-end">
        <div class="w-full md:flex-1">
            <label class="block text-xs font-bold text-gray-500 uppercase tracking-widest mb-2">Pilih Tanggal</label>
            <input type="date" name="tanggal" value="{{ request('tanggal', date('Y-m-d')) }}" class="w-full bg-gray-50 border border-gray-200 text-gray-700 text-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 block p-3">
        </div>
        <div class="w-full md:w-auto flex gap-2">
            <button type="submit" class="flex-1 md:flex-none bg-blue-600 hover:bg-blue-700 text-white px-8 py-3 rounded-xl text-sm font-bold transition-all shadow-lg shadow-blue-200">
                <i class="fas fa-search mr-2"></i> Cari
            </button>
            @if(request()->has('tanggal'))
                <a href="{{ route('kepala_sekolah.monitoring.absensi') }}" class="flex-1 md:flex-none text-center bg-gray-100 hover:bg-gray-200 text-gray-600 px-6 py-3 rounded-xl text-sm font-bold transition-all">
                    Hari Ini
                </a>
            @endif
        </div>
    </form>
</div>

<div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left">
            <thead>
                <tr class="bg-gray-50/50">
                    <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider">Siswa</th>
                    <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider">Mata Pelajaran</th>
                    <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider">Kelas</th>
                    <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider">Waktu</th>
                    <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider">Status</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($absensis as $a)
                <tr class="hover:bg-gray-50/50 transition-colors">
                    <td class="px-6 py-4">
                        <div class="flex items-center">
                            <div class="w-8 h-8 rounded-full bg-amber-100 text-amber-600 flex items-center justify-center mr-3 font-bold text-xs">
                                {{ substr($a->siswa->nama_lengkap, 0, 1) }}
                            </div>
                            <div>
                                <p class="text-sm font-bold text-gray-800">{{ $a->siswa->nama_lengkap }}</p>
                                <p class="text-[10px] text-gray-500">{{ $a->siswa->nisn }}</p>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <span class="text-sm font-medium text-gray-700">{{ $a->jadwal->mapel->nama_mapel }}</span>
                    </td>
                    <td class="px-6 py-4 text-sm text-gray-600">
                        {{ $a->jadwal->kelas->nama_kelas }}
                    </td>
                    <td class="px-6 py-4 text-sm text-gray-500">
                        {{ $a->created_at->format('H:i') }} WIB
                    </td>
                    <td class="px-6 py-4">
                        @php
                            $statusClasses = [
                                'Hadir' => 'bg-emerald-50 text-emerald-600',
                                'Sakit' => 'bg-blue-50 text-blue-600',
                                'Izin' => 'bg-amber-50 text-amber-600',
                                'Alpa' => 'bg-red-50 text-red-600',
                            ];
                        @endphp
                        <span class="px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider {{ $statusClasses[$a->status] ?? 'bg-gray-50 text-gray-600' }}">
                            {{ $a->status }}
                        </span>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-6 py-12 text-center">
                        <div class="flex flex-col items-center">
                            <i class="fas fa-calendar-times text-4xl text-gray-200 mb-4"></i>
                            <p class="text-gray-500">Tidak ada data absensi untuk tanggal ini.</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="px-6 py-4 border-t border-gray-50">
        {{ $absensis->links() }}
    </div>
</div>
@endsection
