@extends('layouts.admin')

@section('title', 'Detail Siswa')
@section('header', 'Detail Siswa')

@section('content')
<div class="space-y-6">
    <div class="flex justify-between items-center">
        <a href="{{ route('admin.siswa.index') }}" class="text-gray-500 hover:text-gray-700 flex items-center gap-2 transition-colors">
            <i class="fas fa-arrow-left"></i> Kembali ke Data Siswa
        </a>
    </div>

    <div class="bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden">
        <div class="p-6 border-b border-gray-100 bg-gray-50 flex justify-between items-center">
            <div class="flex items-center gap-4">
                <div class="w-16 h-16 rounded-full bg-blue-100 flex items-center justify-center text-blue-600 text-2xl font-bold">
                    {{ substr($siswa->nama_lengkap, 0, 1) }}
                </div>
                <div>
                    <h2 class="text-xl font-bold text-gray-800">{{ $siswa->nama_lengkap }}</h2>
                    <p class="text-sm text-gray-500">{{ $siswa->nisn }} / {{ $siswa->nis }}</p>
                </div>
            </div>
            <div class="flex gap-2">
                <a href="{{ route('admin.siswa.index', ['search' => $siswa->nisn]) }}" class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors">
                    <i class="fas fa-edit mr-2"></i> Edit Data
                </a>
            </div>
        </div>
        
        <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-8">
            <!-- Informasi Pribadi -->
            <div>
                <h3 class="text-lg font-bold text-gray-800 mb-4 pb-2 border-b border-gray-100">Informasi Pribadi</h3>
                <dl class="space-y-4">
                    <div class="grid grid-cols-3 gap-4">
                        <dt class="text-sm font-medium text-gray-500">Nama Lengkap</dt>
                        <dd class="text-sm text-gray-900 col-span-2 font-semibold">{{ $siswa->nama_lengkap }}</dd>
                    </div>
                    <div class="grid grid-cols-3 gap-4">
                        <dt class="text-sm font-medium text-gray-500">NISN</dt>
                        <dd class="text-sm text-gray-900 col-span-2">{{ $siswa->nisn }}</dd>
                    </div>
                    <div class="grid grid-cols-3 gap-4">
                        <dt class="text-sm font-medium text-gray-500">NIS</dt>
                        <dd class="text-sm text-gray-900 col-span-2">{{ $siswa->nis }}</dd>
                    </div>
                    <div class="grid grid-cols-3 gap-4">
                        <dt class="text-sm font-medium text-gray-500">Jenis Kelamin</dt>
                        <dd class="text-sm text-gray-900 col-span-2">
                            @if($siswa->jenis_kelamin == 'L')
                                <span class="bg-blue-100 text-blue-800 text-xs px-2 py-1 rounded-full">Laki-laki</span>
                            @else
                                <span class="bg-pink-100 text-pink-800 text-xs px-2 py-1 rounded-full">Perempuan</span>
                            @endif
                        </dd>
                    </div>
                    <div class="grid grid-cols-3 gap-4">
                        <dt class="text-sm font-medium text-gray-500">Tempat, Tgl Lahir</dt>
                        <dd class="text-sm text-gray-900 col-span-2">
                            {{ $siswa->tempat_lahir ?? '-' }}, {{ $siswa->tanggal_lahir ? \Carbon\Carbon::parse($siswa->tanggal_lahir)->format('d F Y') : '-' }}
                        </dd>
                    </div>
                    <div class="grid grid-cols-3 gap-4">
                        <dt class="text-sm font-medium text-gray-500">Alamat</dt>
                        <dd class="text-sm text-gray-900 col-span-2">{{ $siswa->alamat ?? '-' }}</dd>
                    </div>
                    
                    <div class="pt-4 mt-4 border-t border-gray-100">
                        <h4 class="text-sm font-bold text-gray-800 mb-3">Data Orang Tua</h4>
                        <div class="space-y-4">
                            <div class="grid grid-cols-3 gap-4">
                                <dt class="text-sm font-medium text-gray-500">Nama Ayah</dt>
                                <dd class="text-sm text-gray-900 col-span-2">{{ $siswa->nama_ayah ?? '-' }}</dd>
                            </div>
                            <div class="grid grid-cols-3 gap-4">
                                <dt class="text-sm font-medium text-gray-500">Nama Ibu</dt>
                                <dd class="text-sm text-gray-900 col-span-2">{{ $siswa->nama_ibu ?? '-' }}</dd>
                            </div>
                            <div class="grid grid-cols-3 gap-4">
                                <dt class="text-sm font-medium text-gray-500">No. HP Orang Tua</dt>
                                <dd class="text-sm text-gray-900 col-span-2">{{ $siswa->no_hp_ortu ?? '-' }}</dd>
                            </div>
                        </div>
                    </div>
                </dl>
            </div>

            <!-- Informasi Akademik & Akun -->
            <div>
                <h3 class="text-lg font-bold text-gray-800 mb-4 pb-2 border-b border-gray-100">Informasi Akademik</h3>
                <dl class="space-y-4">
                    <div class="grid grid-cols-3 gap-4">
                        <dt class="text-sm font-medium text-gray-500">Kelas</dt>
                        <dd class="text-sm text-gray-900 col-span-2">
                            @if($siswa->kelas)
                                <span class="bg-green-100 text-green-800 text-xs px-2 py-1 rounded-full font-bold">
                                    {{ $siswa->kelas->nama_kelas }}
                                </span>
                            @else
                                <span class="text-red-500 text-xs italic">Belum masuk kelas</span>
                            @endif
                        </dd>
                    </div>
                    @if($siswa->kelas)
                    <div class="grid grid-cols-3 gap-4">
                        <dt class="text-sm font-medium text-gray-500">Wali Kelas</dt>
                        <dd class="text-sm text-gray-900 col-span-2">
                            {{ $siswa->kelas->waliKelas ? $siswa->kelas->waliKelas->nama_lengkap : '-' }}
                        </dd>
                    </div>
                    <div class="grid grid-cols-3 gap-4">
                        <dt class="text-sm font-medium text-gray-500">Jurusan</dt>
                        <dd class="text-sm text-gray-900 col-span-2">{{ $siswa->kelas->jurusan }}</dd>
                    </div>
                    @endif
                    <div class="grid grid-cols-3 gap-4">
                        <dt class="text-sm font-medium text-gray-500">Status Siswa</dt>
                        <dd class="text-sm text-gray-900 col-span-2">
                            <span class="bg-green-100 text-green-800 text-xs px-2 py-1 rounded-full">Aktif</span>
                        </dd>
                    </div>
                </dl>

                <h3 class="text-lg font-bold text-gray-800 mt-8 mb-4 pb-2 border-b border-gray-100">Informasi Akun</h3>
                <dl class="space-y-4">
                    <div class="grid grid-cols-3 gap-4">
                        <dt class="text-sm font-medium text-gray-500">Email</dt>
                        <dd class="text-sm text-gray-900 col-span-2">{{ $siswa->user->email }}</dd>
                    </div>
                    <div class="grid grid-cols-3 gap-4">
                        <dt class="text-sm font-medium text-gray-500">Username</dt>
                        <dd class="text-sm text-gray-900 col-span-2">{{ $siswa->user->name }}</dd>
                    </div>
                </dl>
            </div>
        </div>
    </div>
</div>

<!-- Re-use Edit Modal if needed, or link back to Index with Edit trigger -->
<!-- Since the Edit Modal is in Index, we can't easily open it here without duplicating code. -->
<!-- For simplicity, the "Edit Data" button could just redirect to Index or we duplicate the modal. -->
<!-- Given user didn't ask for Edit on Show page specifically, let's keep it simple. -->
<!-- I'll remove the Edit button or make it redirect to index for now to avoid complexity, or just remove it. -->
<!-- Actually, user just asked for "Show" action. -->
@endsection
