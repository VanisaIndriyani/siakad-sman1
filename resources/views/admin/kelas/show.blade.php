@extends('layouts.admin')

@section('title', 'Detail Kelas')
@section('header', 'Detail Kelas')

@section('content')
    <div class="mb-6">
        <a href="{{ route('admin.kelas.index') }}" class="text-gray-500 hover:text-gray-700 transition-colors flex items-center gap-2">
            <i class="fas fa-arrow-left"></i> Kembali ke Daftar Kelas
        </a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- Class Info Card -->
        <div class="md:col-span-1">
            <div class="bg-white rounded-xl border border-gray-100 card-shadow overflow-hidden">
                <div class="p-6 border-b border-gray-100">
                    <h3 class="font-bold text-gray-800">Informasi Kelas</h3>
                </div>
                <div class="p-6 space-y-4">
                    <div>
                        <label class="block text-xs font-medium text-gray-500 uppercase tracking-wider mb-1">Nama Kelas</label>
                        <p class="text-lg font-bold text-gray-800">{{ $kelas->nama_kelas }}</p>
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-500 uppercase tracking-wider mb-1">Tingkat</label>
                        <p class="text-gray-800">Kelas {{ $kelas->tingkat }}</p>
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-500 uppercase tracking-wider mb-1">Jurusan</label>
                        <p class="text-gray-800">{{ $kelas->jurusan }}</p>
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-500 uppercase tracking-wider mb-1">Wali Kelas</label>
                        <p class="text-gray-800 font-medium">
                            @if($kelas->waliKelas)
                                {{ $kelas->waliKelas->gelar_depan }} {{ $kelas->waliKelas->nama_lengkap }} {{ $kelas->waliKelas->gelar_belakang }}
                            @else
                                <span class="text-gray-400 italic">Belum ditentukan</span>
                            @endif
                        </p>
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-500 uppercase tracking-wider mb-1">Jumlah Siswa</label>
                        <p class="text-blue-600 font-bold text-xl">{{ $kelas->siswas->count() }} <span class="text-sm font-normal text-gray-500">Siswa</span></p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Student List -->
        <div class="md:col-span-2">
            <div class="bg-white rounded-xl border border-gray-100 card-shadow overflow-hidden">
                <div class="p-6 border-b border-gray-100 flex justify-between items-center">
                    <h3 class="font-bold text-gray-800">Daftar Siswa</h3>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-gray-50 text-gray-600 text-xs uppercase tracking-wider">
                                <th class="p-4 w-10 text-center">No</th>
                                <th class="p-4">NISN / NIS</th>
                                <th class="p-4">Nama Lengkap</th>
                                <th class="p-4 text-center">L/P</th>
                                <th class="p-4 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 text-sm">
                            @forelse($kelas->siswas as $index => $siswa)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="p-4 text-center text-gray-500">{{ $index + 1 }}</td>
                                <td class="p-4 font-mono text-gray-600">{{ $siswa->nisn }} / {{ $siswa->nis }}</td>
                                <td class="p-4 font-medium text-gray-800">{{ $siswa->nama_lengkap }}</td>
                                <td class="p-4 text-center">
                                    <span class="px-2 py-1 rounded text-xs font-bold {{ $siswa->jenis_kelamin == 'L' ? 'bg-blue-100 text-blue-800' : 'bg-pink-100 text-pink-800' }}">
                                        {{ $siswa->jenis_kelamin }}
                                    </span>
                                </td>
                                <td class="p-4 text-center">
                                    <a href="{{ route('admin.siswa.show', $siswa->id) }}" class="text-blue-600 hover:text-blue-800" title="Lihat Detail Siswa">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="p-8 text-center text-gray-500">
                                    <div class="flex flex-col items-center justify-center">
                                        <i class="fas fa-users-slash text-4xl mb-3 text-gray-300"></i>
                                        <p>Belum ada siswa di kelas ini.</p>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection