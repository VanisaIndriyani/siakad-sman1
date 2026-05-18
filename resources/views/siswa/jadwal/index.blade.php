@extends('layouts.siswa')

@section('title', 'Jadwal Pelajaran')
@section('header', 'Jadwal Pelajaran ' . (Auth::user()->siswa->kelas->nama_kelas ?? 'Kelas'))

@section('content')
    <div class="flex justify-end mb-4">
        <a href="{{ route('siswa.jadwal.pdf') }}" class="inline-flex items-center bg-yellow-500 hover:bg-yellow-600 text-white font-semibold py-2 px-4 rounded-lg shadow-sm text-sm transition-colors" target="_blank" rel="noopener">
            <i class="fas fa-file-pdf mr-2"></i> Download PDF
        </a>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @php
            $days = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
            $dayColors = [
                'Senin' => 'bg-blue-600',
                'Selasa' => 'bg-indigo-600',
                'Rabu' => 'bg-teal-600',
                'Kamis' => 'bg-purple-600',
                'Jumat' => 'bg-pink-600',
                'Sabtu' => 'bg-orange-600',
            ];
            
            // Item border colors to cycle through
            $itemColors = ['border-blue-500', 'border-green-500', 'border-purple-500', 'border-yellow-500', 'border-red-500', 'border-teal-500'];
        @endphp

        @foreach($days as $day)
            @if(isset($jadwals[$day]))
                <div class="bg-white rounded-xl border border-gray-100 card-shadow p-4">
                    <h3 class="font-bold text-center text-white {{ $dayColors[$day] }} py-2 rounded-lg mb-4 shadow-md">{{ $day }}</h3>
                    <div class="space-y-3">
                        @foreach($jadwals[$day] as $index => $jadwal)
                            @php
                                $itemColor = $itemColors[$index % count($itemColors)];
                                $bgColor = str_replace('border-', 'bg-', $itemColor);
                                $bgColor = str_replace('-500', '-50', $bgColor);
                                $textColor = str_replace('border-', 'text-', $itemColor);
                                $textColor = str_replace('-500', '-700', $textColor);
                            @endphp
                            <div class="flex items-center p-3 bg-white rounded-lg border-l-4 {{ $itemColor }} shadow-sm hover:shadow-md transition-shadow">
                                <div class="{{ $bgColor }} p-2 rounded text-center min-w-[60px]">
                                    <span class="block text-xs font-bold {{ $textColor }}">{{ \Carbon\Carbon::parse($jadwal->jam_mulai)->format('H:i') }}</span>
                                    <span class="block text-xs font-bold {{ $textColor }}">{{ \Carbon\Carbon::parse($jadwal->jam_selesai)->format('H:i') }}</span>
                                </div>
                                <div class="ml-3">
                                    <h4 class="font-bold text-gray-800 text-sm">{{ $jadwal->mapel->nama_mapel }}</h4>
                                    <p class="text-xs text-gray-500">{{ $jadwal->guru->nama_lengkap }}</p>
                                    <p class="text-[10px] text-gray-400 mt-1"><i class="fas fa-map-marker-alt mr-1"></i> Ruang {{ $jadwal->kelas->nama_kelas }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        @endforeach
        
        @if($jadwals->isEmpty())
             <div class="col-span-full text-center p-10 bg-white rounded-xl border border-gray-100">
                <p class="text-gray-500">Belum ada jadwal pelajaran.</p>
             </div>
        @endif
    </div>
@endsection
