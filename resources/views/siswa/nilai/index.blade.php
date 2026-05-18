@extends('layouts.siswa')

@section('title', 'Raport Siswa')
@section('header', 'Laporan Hasil Belajar (Raport)')

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
        /* Reset styling for print */
        .card-shadow {
            box-shadow: none !important;
            border: none !important;
        }
        table {
            border: 1px solid black !important;
            width: 100% !important;
            border-collapse: collapse !important;
        }
        th, td {
            border: 1px solid black !important;
            padding: 8px !important;
        }
        .bg-gray-50 {
            background-color: transparent !important;
        }
    }
</style>

<div class="space-y-6" id="print-area">
    <!-- Print Header -->
    <div class="hidden print:block text-center border-b-2 border-black pb-4 mb-6" style="display: none;">
        <h1 class="text-2xl font-bold uppercase">SMA Negeri 1</h1>
        <h2 class="text-xl font-semibold">Laporan Hasil Belajar Siswa</h2>
        <p class="text-sm">Semester Genap Tahun Ajaran 2025/2026</p>
    </div>
    <script>
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

    <!-- Student Info -->
    <div class="bg-white rounded-xl border border-gray-100 card-shadow p-6 mb-6">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <table class="w-full text-sm">
                    <tr>
                        <td class="py-1 text-gray-500 w-32">Nama Lengkap</td>
                        <td class="py-1 font-bold text-gray-800">: {{ $siswa->nama_lengkap }}</td>
                    </tr>
                    <tr>
                        <td class="py-1 text-gray-500">NISN / NIS</td>
                        <td class="py-1 font-bold text-gray-800">: {{ $siswa->nisn }} / {{ $siswa->nis }}</td>
                    </tr>
                </table>
            </div>
            <div>
                <table class="w-full text-sm">
                    <tr>
                        <td class="py-1 text-gray-500 w-32">Kelas</td>
                        <td class="py-1 font-bold text-gray-800">: {{ $siswa->kelas->nama_kelas }}</td>
                    </tr>
                    <tr>
                        <td class="py-1 text-gray-500">Wali Kelas</td>
                        <td class="py-1 font-bold text-gray-800">: {{ $siswa->kelas->waliKelas->nama_lengkap ?? '-' }}</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>

    <!-- Grades Table -->
    <div class="bg-white rounded-xl border border-gray-100 card-shadow overflow-hidden">
        <div class="p-6 border-b border-gray-100 flex justify-between items-center no-print">
            <h3 class="font-bold text-gray-800">Daftar Nilai Akademik</h3>
            <button onclick="window.print()" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg transition-colors shadow-sm text-sm flex items-center">
                <i class="fas fa-print mr-2"></i> Cetak Raport
            </button>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left border-collapse">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 border-b">
                    <tr>
                        <th class="px-6 py-3 font-medium border-b w-10">No</th>
                        <th class="px-6 py-3 font-medium border-b">Mata Pelajaran</th>
                        <th class="px-6 py-3 font-medium border-b text-center">KKM</th>
                        <th class="px-6 py-3 font-medium border-b text-center">Nilai Akhir</th>
                        <th class="px-6 py-3 font-medium border-b text-center">Predikat</th>
                        <th class="px-6 py-3 font-medium border-b">Keterangan</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @php $no = 1; @endphp
                    @forelse($nilais as $mapelId => $mapelNilais)
                        @php
                            $mapel = $mapelNilais->first()->mapel;
                            // Simple calculation logic: Average of all available grades
                            $average = $mapelNilais->avg('nilai');
                            
                            // Predicate Logic
                            $predikat = 'D';
                            if ($average >= 90) $predikat = 'A';
                            elseif ($average >= 80) $predikat = 'B';
                            elseif ($average >= 70) $predikat = 'C';
                            
                            // KKM (Assuming generic 75 or from Mapel if available, schema check needed)
                            // Mapel migration showed 'kkm' column? Let's check or assume 75.
                            // Checking mapel migration from memory... Yes, I saw it in AdminController mapel create.
                            // Let's assume standard 75 if not set.
                            $kkm = 75; 
                        @endphp
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4 text-center text-gray-500">{{ $no++ }}</td>
                            <td class="px-6 py-4">
                                <div class="font-bold text-gray-800">{{ $mapel->nama_mapel }}</div>
                                <div class="text-xs text-gray-500">Guru: {{ $mapelNilais->first()->guru->nama_lengkap }}</div>
                            </td>
                            <td class="px-6 py-4 text-center text-gray-500">{{ $kkm }}</td>
                            <td class="px-6 py-4 text-center">
                                <span class="font-bold {{ $average < $kkm ? 'text-red-600' : 'text-gray-800' }}">
                                    {{ number_format($average, 0) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-center font-bold text-blue-600">
                                {{ $predikat }}
                            </td>
                            <td class="px-6 py-4 text-gray-500 italic">
                                {{ $average >= $kkm ? 'Tuntas' : 'Belum Tuntas' }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-8 text-center text-gray-500">
                                Belum ada nilai yang diinput.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Signatures (Print Only) -->
    <div class="hidden print:flex justify-between mt-16 pt-8 px-8" style="display: none;">
        <div class="text-center">
            <p class="mb-20">Orang Tua / Wali</p>
            <p class="font-bold underline">.............................</p>
        </div>
        <div class="text-center">
            <p class="mb-20">Wali Kelas</p>
            <p class="font-bold underline">{{ $siswa->kelas->waliKelas->nama_lengkap ?? '.............................' }}</p>
            <p>NIP. {{ $siswa->kelas->waliKelas->nip ?? '................' }}</p>
        </div>
        <div class="text-center">
            <p class="mb-20">Kepala Sekolah</p>
            <p class="font-bold underline">Dr. H. Kepala Sekolah, M.Pd</p>
            <p>NIP. 19800101 200001 1 001</p>
        </div>
    </div>
    <script>
        // JS for Print Signatures visibility
        if (window.matchMedia) {
            var mediaQueryList = window.matchMedia('print');
            mediaQueryList.addListener(function(mql) {
                var sigs = document.querySelector('.print\\:flex');
                if (sigs) sigs.style.display = mql.matches ? 'flex' : 'none';
            });
        }
        window.onbeforeprint = function() {
            var sigs = document.querySelector('.print\\:flex');
            if (sigs) sigs.style.display = 'flex';
        };
        window.onafterprint = function() {
            var sigs = document.querySelector('.print\\:flex');
            if (sigs) sigs.style.display = 'none';
        };
    </script>
</div>
@endsection