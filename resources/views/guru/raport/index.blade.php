@extends('layouts.guru')

@section('title', 'Review Raport')
@section('header', 'Review Raport Siswa')

@section('content')
<div class="space-y-6">
    <div class="bg-white rounded-xl border border-gray-100 card-shadow p-6">
        @if($kelas)
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-6">
                <div>
                    <h3 class="text-lg font-bold text-gray-800">Kelas {{ $kelas->nama_kelas }}</h3>
                    <p class="text-sm text-gray-500">Wali Kelas: {{ Auth::user()->guru->nama_lengkap }}</p>
                </div>
                <span class="bg-blue-100 text-blue-800 text-xs font-bold px-4 py-1.5 rounded-full">
                    {{ $siswas->count() }} Siswa Terdaftar
                </span>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 border-b">
                        <tr>
                            <th class="px-6 py-3 font-medium">No</th>
                            <th class="px-6 py-3 font-medium">NIS / NISN</th>
                            <th class="px-6 py-3 font-medium">Nama Lengkap</th>
                            <th class="px-6 py-3 font-medium text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($siswas as $index => $siswa)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-6 py-4 text-gray-500">{{ $index + 1 }}</td>
                                <td class="px-6 py-4">
                                    <div class="font-bold text-gray-800">{{ $siswa->nis }}</div>
                                    <div class="text-xs text-gray-500">{{ $siswa->nisn }}</div>
                                </td>
                                <td class="px-6 py-4 font-medium text-gray-800">{{ $siswa->nama_lengkap }}</td>
                                <td class="px-6 py-4 text-center">
                                    <a href="{{ route('guru.raport.show', $siswa->id) }}" class="inline-flex items-center px-3 py-1.5 bg-blue-600 hover:bg-blue-700 text-white text-xs font-medium rounded-md transition-colors">
                                        <i class="fas fa-eye mr-1.5"></i> Review Raport
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-8 text-center text-gray-500">
                                    Tidak ada siswa di kelas ini.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        @else
            <div class="text-center py-12">
                <div class="bg-yellow-50 rounded-full w-16 h-16 flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-exclamation-triangle text-yellow-500 text-2xl"></i>
                </div>
                <h3 class="text-lg font-bold text-gray-800 mb-2">Anda Bukan Wali Kelas</h3>
                <p class="text-gray-500">Menu ini hanya tersedia untuk Guru yang menjabat sebagai Wali Kelas.</p>
            </div>
        @endif
    </div>
</div>
@endsection
