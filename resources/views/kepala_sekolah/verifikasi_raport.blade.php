@extends('layouts.kepala_sekolah')

@section('title', 'Verifikasi Raport')
@section('header', 'Verifikasi Raport Siswa')

@section('content')
<div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="p-6 border-b border-gray-50">
        <h3 class="text-lg font-bold text-gray-800">Daftar Siswa & Status Raport</h3>
        <p class="text-sm text-gray-500 mt-1">Silakan verifikasi raport siswa setelah semua nilai lengkap.</p>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-left">
            <thead>
                <tr class="bg-gray-50/50">
                    <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider">Siswa</th>
                    <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider">Kelas</th>
                    <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider">Nilai Rata-rata</th>
                    <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider">Status Verifikasi</th>
                    <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @foreach($siswas as $s)
                <tr class="hover:bg-gray-50/50 transition-colors">
                    <td class="px-6 py-4">
                        <div class="flex items-center">
                            <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-blue-500 to-indigo-600 text-white flex items-center justify-center mr-3 font-bold text-sm shadow-sm">
                                {{ substr($s->nama_lengkap, 0, 1) }}
                            </div>
                            <div>
                                <p class="text-sm font-bold text-gray-800">{{ $s->nama_lengkap }}</p>
                                <p class="text-[10px] text-gray-500">NISN: {{ $s->nisn }}</p>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <span class="text-sm font-semibold text-gray-700">{{ $s->kelas->nama_kelas }}</span>
                    </td>
                    <td class="px-6 py-4">
                        @php $avg = $s->nilais->avg('nilai'); @endphp
                        <span class="text-sm font-bold {{ $avg >= 75 ? 'text-emerald-600' : 'text-gray-700' }}">
                            {{ number_format($avg ?? 0, 1) }}
                        </span>
                    </td>
                    <td class="px-6 py-4">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                            <i class="far fa-clock mr-1.5"></i> Menunggu Verifikasi
                        </span>
                    </td>
                    <td class="px-6 py-4 text-right">
                        <form action="{{ route('kepala_sekolah.raport.do_verifikasi', $s->id) }}" method="POST" class="inline">
                            @csrf
                            <button type="submit" class="bg-indigo-50 hover:bg-indigo-600 text-indigo-600 hover:text-white px-4 py-2 rounded-lg text-xs font-bold transition-all border border-indigo-100">
                                Verifikasi Sekarang
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="px-6 py-4 border-t border-gray-50">
        {{ $siswas->links() }}
    </div>
</div>
@endsection
