@extends('layouts.siswa')

@section('title', 'Raport Akademik')
@section('header', 'Laporan Hasil Belajar (Raport)')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
        <div>
            <p class="text-sm text-slate-500">Halaman ini menampilkan rekap nilai akademik, absensi, dan ringkasan ketuntasan belajar Anda.</p>
        </div>
        <div class="flex gap-3 flex-wrap no-print">
            <button onclick="window.print()" class="inline-flex items-center gap-2 px-5 py-2.5 bg-white border border-slate-200 text-slate-700 font-bold rounded-xl hover:bg-slate-50 transition-all shadow-sm">
                <i class="fas fa-print"></i> Cetak
            </button>
            <a href="{{ route('siswa.raport.pdf') }}" class="inline-flex items-center gap-2 px-5 py-2.5 bg-gradient-to-r from-emerald-500 to-emerald-600 hover:from-emerald-600 hover:to-emerald-700 text-white font-bold rounded-xl transition-all shadow-lg shadow-emerald-500/30">
                <i class="fas fa-file-download"></i> Unduh Raport PDF
            </a>
        </div>
    </div>

    <div id="print-area">
        <div class="hidden print:block text-center border-b-2 border-slate-800 pb-5 mb-6">
            <h1 class="text-2xl font-extrabold uppercase tracking-wide">SMA Negeri 1 Tuhemberua</h1>
            <h2 class="text-xl font-bold mt-1">Laporan Hasil Belajar Siswa</h2>
            <p class="text-sm mt-1 text-slate-600">Tahun Ajaran {{ now()->format('Y') }}/{{ now()->format('Y') + 1 }}</p>
        </div>

        <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6 md:p-8 mb-6">
            <h3 class="font-bold text-slate-800 mb-5 flex items-center gap-2 text-lg">
                <i class="fas fa-id-card text-emerald-600"></i> Identitas Siswa
            </h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <div>
                    <table class="w-full text-sm">
                        <tr>
                            <td class="py-1.5 text-slate-500 w-36 font-medium">Nama Lengkap</td>
                            <td class="py-1.5 font-bold text-slate-800">: {{ $siswa->nama_lengkap }}</td>
                        </tr>
                        <tr>
                            <td class="py-1.5 text-slate-500 font-medium">NISN / NIS</td>
                            <td class="py-1.5 font-bold text-slate-800">: {{ $siswa->nisn ?? '-' }} / {{ $siswa->nis ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td class="py-1.5 text-slate-500 font-medium">Jenis Kelamin</td>
                            <td class="py-1.5 font-bold text-slate-800">: {{ $siswa->jenis_kelamin === 'L' ? 'Laki-laki' : 'Perempuan' }}</td>
                        </tr>
                    </table>
                </div>
                <div>
                    <table class="w-full text-sm">
                        <tr>
                            <td class="py-1.5 text-slate-500 w-36 font-medium">Kelas</td>
                            <td class="py-1.5 font-bold text-slate-800">: {{ optional($siswa->kelas)->nama_kelas ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td class="py-1.5 text-slate-500 font-medium">Wali Kelas</td>
                            <td class="py-1.5 font-bold text-slate-800">: {{ optional(optional($siswa->kelas)->waliKelas)->nama_lengkap ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td class="py-1.5 text-slate-500 font-medium">Tanggal Cetak</td>
                            <td class="py-1.5 font-bold text-slate-800">: {{ now()->format('d F Y') }}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
            <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-5">
                <div class="text-xs font-bold text-slate-500 uppercase tracking-wider mb-1">Total Mapel</div>
                <div class="text-3xl font-extrabold text-slate-800">{{ $summary['total_mapel'] }}</div>
            </div>
            <div class="bg-gradient-to-br from-emerald-500 to-emerald-600 text-white rounded-2xl shadow-lg shadow-emerald-500/30 p-5">
                <div class="text-xs font-bold text-emerald-50 uppercase tracking-wider mb-1">Rata-Rata Akhir</div>
                <div class="text-3xl font-extrabold">{{ $summary['rata_rata_akhir'] }}</div>
            </div>
            <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-5">
                <div class="text-xs font-bold text-slate-500 uppercase tracking-wider mb-1">Tuntas</div>
                <div class="text-3xl font-extrabold text-emerald-600">{{ $summary['tuntas'] }}</div>
            </div>
            <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-5">
                <div class="text-xs font-bold text-slate-500 uppercase tracking-wider mb-1">Belum Tuntas</div>
                <div class="text-3xl font-extrabold text-rose-600">{{ $summary['tidak_tuntas'] }}</div>
            </div>
        </div>

        <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden mb-6">
            <div class="p-6 border-b border-slate-100 bg-slate-50/60">
                <h3 class="font-bold text-slate-800 flex items-center gap-2 text-lg">
                    <i class="fas fa-chart-line text-emerald-600"></i> Daftar Nilai Mata Pelajaran
                </h3>
                <p class="text-xs text-slate-500 mt-1">Bobot: Tugas 30% | UTS 30% | UAS 40%</p>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left border-collapse">
                    <thead class="text-xs text-slate-700 uppercase bg-slate-50 border-b border-slate-200">
                        <tr>
                            <th class="px-5 py-3 font-semibold border-b w-12 text-center">No</th>
                            <th class="px-5 py-3 font-semibold border-b">Mata Pelajaran</th>
                            <th class="px-5 py-3 font-semibold border-b text-center">Tugas</th>
                            <th class="px-5 py-3 font-semibold border-b text-center">UTS</th>
                            <th class="px-5 py-3 font-semibold border-b text-center">UAS</th>
                            <th class="px-5 py-3 font-semibold border-b text-center">KKM</th>
                            <th class="px-5 py-3 font-semibold border-b text-center">Nilai Akhir</th>
                            <th class="px-5 py-3 font-semibold border-b text-center">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @php $no = 1; @endphp
                        @forelse($nilaiMapel as $nm)
                            <tr class="hover:bg-slate-50 transition-colors">
                                <td class="px-5 py-4 text-center text-slate-500 font-medium">{{ $no++ }}</td>
                                <td class="px-5 py-4">
                                    <div class="font-bold text-slate-800">{{ optional($nm->mapel)->nama_mapel ?? 'Mapel' }}</div>
                                    <div class="text-xs text-slate-500">Guru: {{ optional($nm->guru)->nama_lengkap ?? '-' }}</div>
                                </td>
                                <td class="px-5 py-4 text-center font-medium text-slate-700">{{ $nm->tugas ? number_format($nm->tugas, 0) : '-' }}</td>
                                <td class="px-5 py-4 text-center font-medium text-slate-700">{{ $nm->uts ? number_format($nm->uts, 0) : '-' }}</td>
                                <td class="px-5 py-4 text-center font-medium text-slate-700">{{ $nm->uas ? number_format($nm->uas, 0) : '-' }}</td>
                                <td class="px-5 py-4 text-center text-slate-500">{{ $nm->kkm }}</td>
                                <td class="px-5 py-4 text-center">
                                    <span class="font-extrabold text-lg {{ $nm->rata < $nm->kkm ? 'text-rose-600' : 'text-slate-800' }}">{{ number_format($nm->rata, 0) }}</span>
                                </td>
                                <td class="px-5 py-4 text-center">
                                    @if($nm->status === 'TUNTAS')
                                        <span class="inline-flex items-center px-3 py-1 rounded-full bg-emerald-100 text-emerald-700 text-xs font-bold"><i class="fas fa-check-circle mr-1"></i> Tuntas</span>
                                    @else
                                        <span class="inline-flex items-center px-3 py-1 rounded-full bg-rose-100 text-rose-700 text-xs font-bold"><i class="fas fa-exclamation-circle mr-1"></i> Belum</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="px-5 py-12 text-center text-slate-500">
                                    <div class="inline-flex flex-col items-center gap-2">
                                        <div class="w-14 h-14 rounded-full bg-slate-100 flex items-center justify-center"><i class="fas fa-book-open text-slate-400 text-2xl"></i></div>
                                        <p class="font-semibold">Belum ada nilai yang diinput oleh Guru.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                    @if($nilaiMapel->isNotEmpty())
                        <tfoot class="bg-slate-50 border-t-2 border-slate-200">
                            <tr>
                                <td colspan="6" class="px-5 py-4 text-right font-bold text-slate-700">Rata-Rata Keseluruhan</td>
                                <td class="px-5 py-4 text-center font-extrabold text-emerald-700 text-lg">{{ $summary['rata_rata_akhir'] }}</td>
                                <td></td>
                            </tr>
                            <tr>
                                <td colspan="6" class="px-5 py-3 text-right font-bold text-slate-700 border-t border-slate-100">Nilai Tertinggi / Terendah</td>
                                <td class="px-5 py-3 text-center font-bold text-slate-700 border-t border-slate-100">{{ $summary['nilai_tertinggi'] }} / {{ $summary['nilai_terendah'] }}</td>
                                <td></td>
                            </tr>
                        </tfoot>
                    @endif
                </table>
            </div>
        </div>

        <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6 md:p-8 mb-6">
            <h3 class="font-bold text-slate-800 mb-5 flex items-center gap-2 text-lg">
                <i class="fas fa-calendar-check text-amber-600"></i> Rekapitulasi Absensi
            </h3>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                <div class="p-4 rounded-2xl bg-emerald-50 border border-emerald-100 text-center">
                    <div class="text-xs font-bold text-emerald-700 uppercase tracking-wider mb-1">Hadir</div>
                    <div class="text-3xl font-extrabold text-emerald-700">{{ $absensiSummary['Hadir'] }}</div>
                </div>
                <div class="p-4 rounded-2xl bg-blue-50 border border-blue-100 text-center">
                    <div class="text-xs font-bold text-blue-700 uppercase tracking-wider mb-1">Sakit</div>
                    <div class="text-3xl font-extrabold text-blue-700">{{ $absensiSummary['Sakit'] }}</div>
                </div>
                <div class="p-4 rounded-2xl bg-amber-50 border border-amber-100 text-center">
                    <div class="text-xs font-bold text-amber-700 uppercase tracking-wider mb-1">Izin</div>
                    <div class="text-3xl font-extrabold text-amber-700">{{ $absensiSummary['Izin'] }}</div>
                </div>
                <div class="p-4 rounded-2xl bg-rose-50 border border-rose-100 text-center">
                    <div class="text-xs font-bold text-rose-700 uppercase tracking-wider mb-1">Alpa</div>
                    <div class="text-3xl font-extrabold text-rose-700">{{ $absensiSummary['Alpa'] }}</div>
                </div>
            </div>
        </div>

        <div class="hidden print:grid print:grid-cols-3 print:gap-10 print:mt-16 print:pt-8 print:text-center print:text-sm">
            <div>
                <p class="mb-20 text-slate-600">Mengetahui,<br>Orang Tua / Wali</p>
                <p class="font-bold underline text-slate-800">..................................</p>
            </div>
            <div>
                <p class="mb-20 text-slate-600">Tuhemberua, {{ now()->format('d F Y') }}<br>Wali Kelas</p>
                <p class="font-bold underline text-slate-800">{{ optional(optional($siswa->kelas)->waliKelas)->nama_lengkap ?? '..................................' }}</p>
                <p class="text-xs text-slate-500">NIP. {{ optional(optional($siswa->kelas)->waliKelas)->nip ?? '..............' }}</p>
            </div>
            <div>
                <p class="mb-20 text-slate-600">Kepala Sekolah</p>
                <p class="font-bold underline text-slate-800">..................................</p>
                <p class="text-xs text-slate-500">NIP. ..............</p>
            </div>
        </div>
    </div>
</div>
@endsection
