@extends('layouts.admin')

@section('title', 'Data Nilai & Raport')
@section('header', 'Manajemen Nilai Siswa')

@section('content')
    <style>
        @media print {
            body * {
                visibility: hidden;
            }
            #print-area, #print-area * {
                visibility: visible;
            }
            #print-area {
                position: absolute;
                left: 0;
                top: 0;
                width: 100%;
                background: white;
                padding: 20px;
            }
            .no-print {
                display: none !important;
            }
            /* Reset card styles for print */
            .card-shadow {
                box-shadow: none !important;
                border: none !important;
            }
        }
    </style>

    <div id="print-area" class="bg-white rounded-xl border border-gray-100 card-shadow overflow-hidden mb-6">
        <!-- Print Header (Hidden on Screen) -->
        <div class="hidden print:block mb-8 text-center border-b-2 border-gray-800 pb-4" style="display: none;">
            <h1 class="text-2xl font-bold uppercase">SMA Negeri 1</h1>
            <h2 class="text-xl font-semibold">Laporan Data Nilai Siswa</h2>
            <p class="text-sm text-gray-600">Dicetak pada: {{ date('d/m/Y H:i') }}</p>
        </div>
        <script>
            // Force display block for print header when printing
            if (window.matchMedia) {
                var mediaQueryList = window.matchMedia('print');
                mediaQueryList.addListener(function(mql) {
                    var printHeader = document.querySelector('.print\\:block');
                    if (printHeader) {
                        printHeader.style.display = mql.matches ? 'block' : 'none';
                    }
                });
            }
            window.onbeforeprint = function() {
                var printHeader = document.querySelector('.print\\:block');
                if (printHeader) printHeader.style.display = 'block';
            };
            window.onafterprint = function() {
                var printHeader = document.querySelector('.print\\:block');
                if (printHeader) printHeader.style.display = 'none';
            };
        </script>

        <div class="p-6 border-b border-gray-100 flex justify-between items-center flex-wrap gap-4 no-print">
            <h3 class="font-bold text-gray-800">Riwayat Input Nilai</h3>
            <a href="{{ route('admin.nilai.pdf', request()->all()) }}" target="_blank" class="bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-4 rounded-lg transition-colors shadow-sm text-sm flex items-center gap-2">
                <i class="fas fa-file-pdf"></i> Export PDF / Cetak
            </a>
        </div>

        <!-- Search & Filter (No Print) -->
        <form action="{{ route('admin.nilai.index') }}" method="GET" class="p-4 bg-gray-50 border-b border-gray-100 flex gap-4 flex-wrap no-print">
            <div class="relative flex-1 min-w-[200px]">
                <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari Siswa atau Mapel..." class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm">
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

            <select name="kategori" onchange="this.form.submit()" class="border border-gray-300 rounded-lg px-4 py-2 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white">
                <option value="">Semua Kategori</option>
                @foreach(['UH1', 'UH2', 'UH3', 'UTS', 'UAS', 'Tugas'] as $kat)
                    <option value="{{ $kat }}" {{ request('kategori') == $kat ? 'selected' : '' }}>{{ $kat }}</option>
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
                        <th class="p-4 font-semibold">Kategori</th>
                        <th class="p-4 font-semibold text-center">Nilai</th>
                        <th class="p-4 font-semibold">Guru</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 text-sm">
                    @forelse($nilais as $nilai)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="p-4 text-gray-500">{{ $nilai->created_at->format('d/m/Y') }}</td>
                        <td class="p-4 font-medium text-gray-800">
                            {{ $nilai->siswa->nama_lengkap }}<br>
                            <span class="text-xs text-gray-500">{{ $nilai->siswa->nisn }}</span>
                        </td>
                        <td class="p-4 text-gray-600">{{ $nilai->siswa->kelas ? $nilai->siswa->kelas->nama_kelas : '-' }}</td>
                        <td class="p-4">{{ $nilai->mapel->nama_mapel }}</td>
                        <td class="p-4"><span class="bg-blue-100 text-blue-700 px-2 py-1 rounded-full text-xs font-semibold">{{ $nilai->kategori }}</span></td>
                        <td class="p-4 text-center">
                            <span class="font-bold text-lg {{ $nilai->nilai < 75 ? 'text-red-600' : 'text-green-600' }}">{{ $nilai->nilai }}</span>
                        </td>
                        <td class="p-4 text-gray-600 text-xs">{{ $nilai->guru->nama_lengkap }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="p-4 text-center text-gray-500">Belum ada data nilai yang diinput.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <div class="p-4 border-t border-gray-100 no-print">
            {{ $nilais->withQueryString()->links() }}
        </div>
    </div>
@endsection
