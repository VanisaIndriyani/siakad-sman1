@extends('layouts.guru')

@section('title', 'Jadwal Mengajar')
@section('header', 'Jadwal Mengajar')

@section('content')
@php
    // Calculate stats from the grouped collection
    $flattenedJadwals = $jadwals->flatten();
    $totalJam = $flattenedJadwals->count();
    $totalKelas = $flattenedJadwals->pluck('kelas_id')->unique()->count();
    $totalMapel = $flattenedJadwals->pluck('mapel_id')->unique()->count();
    
    $days = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
    
    // Day mapping for highlighting today
    $enToId = [
        'Monday' => 'Senin', 'Tuesday' => 'Selasa', 'Wednesday' => 'Rabu', 
        'Thursday' => 'Kamis', 'Friday' => 'Jumat', 'Saturday' => 'Sabtu', 'Sunday' => 'Minggu'
    ];
    $todayName = $enToId[date('l')] ?? '';
@endphp

<div class="space-y-6">
    <!-- Header Stats -->
    <div class="bg-gradient-to-r from-blue-600 to-indigo-700 rounded-xl p-6 text-white shadow-lg relative overflow-hidden">
        <!-- Decorative bg pattern -->
        <div class="absolute top-0 right-0 w-64 h-64 bg-white/5 rounded-full -mr-16 -mt-16 pointer-events-none"></div>
        <div class="absolute bottom-0 left-0 w-32 h-32 bg-white/5 rounded-full -ml-10 -mb-10 pointer-events-none"></div>

        <div class="relative z-10 flex flex-col md:flex-row justify-between items-start md:items-center gap-6">
            <div>
                <h2 class="text-2xl font-bold mb-1">Jadwal Mengajar</h2>
                <p class="text-blue-100 text-sm opacity-90">Semester Genap &bull; Tahun Ajaran 2025/2026</p>
            </div>
            
            <div class="flex flex-wrap gap-3 w-full md:w-auto">
                <div class="bg-white/10 backdrop-blur-md border border-white/20 rounded-xl p-3 text-center flex-1 md:flex-none min-w-[100px]">
                    <div class="text-xs text-blue-100 uppercase tracking-wider font-semibold mb-1">Total Jam</div>
                    <div class="text-2xl font-bold">{{ $totalJam }}</div>
                </div>
                <div class="bg-white/10 backdrop-blur-md border border-white/20 rounded-xl p-3 text-center flex-1 md:flex-none min-w-[100px]">
                    <div class="text-xs text-blue-100 uppercase tracking-wider font-semibold mb-1">Total Kelas</div>
                    <div class="text-2xl font-bold">{{ $totalKelas }}</div>
                </div>
                <div class="bg-white/10 backdrop-blur-md border border-white/20 rounded-xl p-3 text-center flex-1 md:flex-none min-w-[100px]">
                    <div class="text-xs text-blue-100 uppercase tracking-wider font-semibold mb-1">Mapel</div>
                    <div class="text-2xl font-bold">{{ $totalMapel }}</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Schedule Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-6 gap-5">
        @foreach($days as $day)
            @php
                $isToday = $day == $todayName;
                $dayJadwals = $jadwals[$day] ?? collect([]);
                $hasSchedule = $dayJadwals->count() > 0;
            @endphp
            
            <div class="flex flex-col h-full transition-transform duration-300 hover:-translate-y-1">
                <!-- Day Header -->
                <div class="rounded-t-xl p-4 text-center border-b-0 relative overflow-hidden {{ $isToday ? 'bg-blue-600 text-white shadow-md z-10' : 'bg-white text-gray-700 border border-gray-100 border-b-0' }}">
                    @if($isToday)
                        <div class="absolute top-0 right-0 w-12 h-12 bg-white/10 rounded-bl-full -mr-2 -mt-2"></div>
                    @endif
                    
                    <h3 class="font-bold text-lg tracking-wide">{{ $day }}</h3>
                    
                    @if($isToday)
                    <span class="inline-block mt-1 text-[10px] font-bold uppercase tracking-wider bg-white/20 px-2 py-0.5 rounded-full">Hari Ini</span>
                    @elseif($hasSchedule)
                    <span class="inline-block mt-1 text-[10px] font-medium text-gray-400">{{ $dayJadwals->count() }} Sesi</span>
                    @endif
                </div>

                <!-- Schedule List -->
                <div class="bg-white border {{ $isToday ? 'border-blue-200 ring-2 ring-blue-100 ring-opacity-50' : 'border-gray-100' }} border-t-0 rounded-b-xl p-3 flex-1 shadow-sm flex flex-col gap-3 h-full">
                    @if($hasSchedule)
                        @foreach($dayJadwals as $jadwal)
                            <div class="group relative bg-gray-50 hover:bg-white border border-gray-200 hover:border-blue-300 rounded-xl p-3 transition-all duration-200 hover:shadow-md">
                                <!-- Time Badge -->
                                <div class="flex justify-between items-start mb-2">
                                    <span class="inline-flex items-center px-2 py-1 rounded-md text-xs font-bold bg-white border border-gray-200 text-blue-600 shadow-sm group-hover:bg-blue-50 group-hover:border-blue-100 transition-colors">
                                        <i class="far fa-clock mr-1.5 text-[10px]"></i> {{ \Carbon\Carbon::parse($jadwal->jam_mulai)->format('H:i') }} - {{ \Carbon\Carbon::parse($jadwal->jam_selesai)->format('H:i') }}
                                    </span>
                                </div>
                                
                                <!-- Subject -->
                                <h4 class="font-bold text-gray-800 text-sm mb-2 line-clamp-2 leading-tight group-hover:text-blue-700 transition-colors" title="{{ $jadwal->mapel->nama_mapel }}">
                                    {{ $jadwal->mapel->nama_mapel }}
                                </h4>
                                
                                <!-- Details -->
                                <div class="space-y-1.5 border-t border-gray-100 pt-2 mt-2">
                                    <div class="flex items-center text-xs text-gray-600 group-hover:text-gray-900">
                                        <div class="w-5 flex justify-center mr-1 text-gray-400 group-hover:text-blue-500">
                                            <i class="fas fa-users text-xs"></i>
                                        </div>
                                        <span class="font-medium">{{ $jadwal->kelas->nama_kelas }}</span>
                                    </div>
                                    <div class="flex items-center text-xs text-gray-600 group-hover:text-gray-900">
                                        <div class="w-5 flex justify-center mr-1 text-gray-400 group-hover:text-red-500">
                                            <i class="fas fa-map-marker-alt text-xs"></i>
                                        </div>
                                        <span>{{ $jadwal->ruangan ?? 'R. Belum set' }}</span>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="flex-1 flex flex-col items-center justify-center text-center py-10 opacity-60">
                            <div class="w-16 h-16 bg-gray-50 rounded-full flex items-center justify-center mb-3 group-hover:bg-gray-100 transition-colors">
                                <i class="fas fa-mug-hot text-gray-300 text-2xl"></i>
                            </div>
                            <p class="text-xs font-medium text-gray-400">Tidak ada jadwal</p>
                            <p class="text-[10px] text-gray-300 mt-1">Istirahat atau kegiatan lain</p>
                        </div>
                    @endif
                </div>
            </div>
        @endforeach
    </div>
    
    <div class="text-center mt-8">
        <button onclick="window.print()" class="inline-flex items-center justify-center px-6 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-lg text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all">
            <i class="fas fa-print mr-2 text-gray-500"></i> Cetak Jadwal
        </button>
    </div>
</div>

<style>
    @media print {
        body * {
            visibility: hidden;
        }
        .space-y-6, .space-y-6 * {
            visibility: visible;
        }
        .space-y-6 {
            position: absolute;
            left: 0;
            top: 0;
            width: 100%;
        }
        /* Adjust grid for print to fit on page */
        .grid {
            display: grid !important;
            grid-template-columns: repeat(3, 1fr) !important; /* 3 columns per row for print */
            gap: 1rem !important;
        }
        button {
            display: none !important;
        }
    }
</style>
@endsection