@extends('layouts.guru')

@section('title', 'Input Nilai')
@section('header', 'Input Nilai Siswa')

@section('content')
    <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">
        
        <!-- Sidebar Selection -->
        <div class="lg:col-span-1 space-y-4">
            <div class="bg-white rounded-xl border border-gray-100 card-shadow p-5">
                <h3 class="font-bold text-gray-800 mb-4 text-sm uppercase tracking-wider">Filter Kelas</h3>
                <form action="{{ route('guru.nilai.index') }}" method="GET">
                    <div class="space-y-3">
                        <div>
                            <label class="block text-xs font-medium text-gray-500 mb-1">Pilih Kelas</label>
                            <select name="kelas_id" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500">
                                <option value="">-- Pilih Kelas --</option>
                                @foreach($kelasDiampu as $kelas)
                                    <option value="{{ $kelas->id }}" {{ $selectedKelasId == $kelas->id ? 'selected' : '' }}>{{ $kelas->nama_kelas }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-gray-500 mb-1">Mata Pelajaran</label>
                            <select name="mapel_id" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500">
                                <option value="">-- Pilih Mapel --</option>
                                @foreach($mapelDiampu as $mapel)
                                    <option value="{{ $mapel->id }}" {{ $selectedMapelId == $mapel->id ? 'selected' : '' }}>{{ $mapel->nama_mapel }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-gray-500 mb-1">Kategori Nilai</label>
                            <select name="kategori" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500">
                                <option value="UH1" {{ $selectedKategori == 'UH1' ? 'selected' : '' }}>UH1</option>
                                <option value="UH2" {{ $selectedKategori == 'UH2' ? 'selected' : '' }}>UH2</option>
                                <option value="UH3" {{ $selectedKategori == 'UH3' ? 'selected' : '' }}>UH3</option>
                                <option value="Tugas" {{ $selectedKategori == 'Tugas' ? 'selected' : '' }}>Tugas</option>
                                <option value="UTS" {{ $selectedKategori == 'UTS' ? 'selected' : '' }}>UTS</option>
                                <option value="UAS" {{ $selectedKategori == 'UAS' ? 'selected' : '' }}>UAS</option>
                            </select>
                        </div>
                        <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 rounded-lg text-sm shadow-sm transition-colors">
                            Tampilkan Data
                        </button>
                    </div>
                </form>
            </div>
            
            <div class="bg-blue-50 rounded-xl p-5 border border-blue-100">
                <h4 class="font-bold text-blue-800 text-sm mb-2"><i class="fas fa-info-circle mr-1"></i> Informasi</h4>
                <p class="text-xs text-blue-700 leading-relaxed">
                    Pastikan nilai yang diinput berada dalam rentang 0-100. Nilai di bawah KKM (75) akan otomatis ditandai merah.
                </p>
            </div>
        </div>

        <!-- Input Form -->
        <div class="lg:col-span-3">

            @if(count($siswas) > 0)
            <div class="bg-white rounded-xl border border-gray-100 card-shadow overflow-hidden">
                <form action="{{ route('guru.nilai.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="kelas_id" value="{{ $selectedKelasId }}">
                    <input type="hidden" name="mapel_id" value="{{ $selectedMapelId }}">
                    <input type="hidden" name="kategori" value="{{ $selectedKategori }}">

                    <div class="p-5 border-b border-gray-100 flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                        <div>
                            <h3 class="font-bold text-gray-800">Input Nilai: {{ $mapelDiampu->where('id', $selectedMapelId)->first()->nama_mapel ?? '-' }}</h3>
                            <p class="text-xs text-gray-500">Kelas {{ $kelasDiampu->where('id', $selectedKelasId)->first()->nama_kelas ?? '-' }} &bull; {{ $selectedKategori }}</p>
                        </div>
                        <button type="submit" class="w-full md:w-auto bg-green-600 hover:bg-green-700 text-white font-bold py-2.5 px-6 rounded-lg shadow-sm transition-colors text-sm flex items-center justify-center">
                            <i class="fas fa-save mr-2"></i> Simpan Semua Nilai
                        </button>
                    </div>
                    
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="bg-gray-50 text-gray-600 text-xs uppercase tracking-wider">
                                    <th class="p-4 w-12 text-center">No</th>
                                    <th class="p-4">Nama Siswa</th>
                                    <th class="p-4 w-32 text-center">Nilai</th>
                                    <th class="p-4 w-48">Keterangan</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100 text-sm">
                                @foreach($siswas as $index => $siswa)
                                <tr class="hover:bg-gray-50">
                                    <td class="p-4 text-center text-gray-500">{{ $index + 1 }}</td>
                                    <td class="p-4 font-medium text-gray-800">{{ $siswa->nama_lengkap }}</td>
                                    <td class="p-4">
                                        <input type="number" name="nilai[{{ $siswa->id }}]" min="0" max="100" class="w-full border border-gray-300 rounded px-2 py-1 text-center focus:ring-2 focus:ring-blue-500" value="{{ $siswa->nilai_value }}">
                                    </td>
                                    <td class="p-4">
                                        <input type="text" name="catatan[{{ $siswa->id }}]" class="w-full border border-gray-300 rounded px-2 py-1 focus:ring-2 focus:ring-blue-500" placeholder="-" value="{{ $siswa->catatan }}">
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </form>
            </div>
            @else
            <div class="bg-white rounded-xl border border-gray-100 card-shadow p-10 text-center">
                <div class="bg-gray-100 rounded-full w-16 h-16 flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-search text-gray-400 text-2xl"></i>
                </div>
                <h3 class="text-gray-800 font-bold mb-2">Belum ada data ditampilkan</h3>
                <p class="text-gray-500 text-sm">Silakan pilih Kelas dan Mata Pelajaran terlebih dahulu.</p>
            </div>
            @endif
        </div>
    </div>
@endsection
