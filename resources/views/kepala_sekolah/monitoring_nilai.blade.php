@extends('layouts.kepala_sekolah')

@section('title', 'Monitoring Nilai')
@section('header', 'Monitoring Nilai Siswa')

@section('content')
<div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 mb-8">
    <form action="{{ route('kepala_sekolah.monitoring.nilai') }}" method="GET" class="flex flex-col md:flex-row gap-4 items-end">
        <div class="w-full md:flex-1">
            <label class="block text-xs font-bold text-gray-500 uppercase tracking-widest mb-2">Filter Kelas</label>
            <select name="kelas_id" class="w-full bg-gray-50 border border-gray-200 text-gray-700 text-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 block p-3">
                <option value="">Semua Kelas</option>
                @foreach($kelases as $k)
                    <option value="{{ $k->id }}" {{ request('kelas_id') == $k->id ? 'selected' : '' }}>{{ $k->nama_kelas }}</option>
                @endforeach
            </select>
        </div>
        <div class="w-full md:w-auto flex gap-2">
            <button type="submit" class="flex-1 md:flex-none bg-blue-600 hover:bg-blue-700 text-white px-8 py-3 rounded-xl text-sm font-bold transition-all shadow-lg shadow-blue-200">
                <i class="fas fa-filter mr-2"></i> Filter
            </button>
            @if(request()->has('kelas_id'))
                <a href="{{ route('kepala_sekolah.monitoring.nilai') }}" class="flex-1 md:flex-none text-center bg-gray-100 hover:bg-gray-200 text-gray-600 px-6 py-3 rounded-xl text-sm font-bold transition-all">
                    Reset
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
                    <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider">Guru</th>
                    <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider text-center">Nilai</th>
                    <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider">Status</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($nilais as $n)
                <tr class="hover:bg-gray-50/50 transition-colors">
                    <td class="px-6 py-4">
                        <div class="flex items-center">
                            <div class="w-8 h-8 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center mr-3 font-bold text-xs">
                                {{ substr($n->siswa->nama_lengkap, 0, 1) }}
                            </div>
                            <div>
                                <p class="text-sm font-bold text-gray-800">{{ $n->siswa->nama_lengkap }}</p>
                                <p class="text-[10px] text-gray-500">{{ $n->siswa->nisn }}</p>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <span class="text-sm font-medium text-gray-700">{{ $n->mapel->nama_mapel }}</span>
                    </td>
                    <td class="px-6 py-4 text-sm text-gray-600">
                        {{ $n->guru->nama_lengkap }}
                    </td>
                    <td class="px-6 py-4 text-center">
                        <span class="inline-block px-3 py-1 rounded-lg text-sm font-bold {{ $n->nilai >= 75 ? 'bg-emerald-50 text-emerald-600' : 'bg-red-50 text-red-600' }}">
                            {{ $n->nilai }}
                        </span>
                    </td>
                    <td class="px-6 py-4">
                        @if($n->nilai >= 75)
                            <span class="flex items-center text-xs font-bold text-emerald-600">
                                <i class="fas fa-check-circle mr-1.5"></i> Tuntas
                            </span>
                        @else
                            <span class="flex items-center text-xs font-bold text-red-600">
                                <i class="fas fa-times-circle mr-1.5"></i> Remedial
                            </span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-6 py-12 text-center">
                        <div class="flex flex-col items-center">
                            <i class="fas fa-inbox text-4xl text-gray-200 mb-4"></i>
                            <p class="text-gray-500">Belum ada data nilai yang tersedia.</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="px-6 py-4 border-t border-gray-50">
        {{ $nilais->links() }}
    </div>
</div>
@endsection
