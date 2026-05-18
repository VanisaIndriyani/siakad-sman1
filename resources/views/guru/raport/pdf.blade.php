<!DOCTYPE html>
<html>
<head>
    <title>Laporan Hasil Belajar Siswa</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            margin: 0;
            padding: 0;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
            border-bottom: 2px solid #000;
            padding-bottom: 10px;
        }
        .header h1 {
            margin: 0;
            font-size: 18px;
            text-transform: uppercase;
        }
        .header h2 {
            margin: 5px 0;
            font-size: 14px;
            font-weight: normal;
        }
        .header p {
            margin: 0;
            font-size: 11px;
            font-style: italic;
        }
        .title {
            text-align: center;
            margin-bottom: 20px;
            font-size: 14px;
            font-weight: bold;
            text-transform: uppercase;
        }
        .info-table {
            width: 100%;
            margin-bottom: 15px;
        }
        .info-table td {
            padding: 3px 0;
            font-size: 12px;
            vertical-align: top;
        }
        .table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        .table th, .table td {
            border: 1px solid #000;
            padding: 6px;
            text-align: left;
        }
        .table th {
            background-color: #f0f0f0;
            font-weight: bold;
            text-align: center;
        }
        .text-center {
            text-align: center;
        }
        .footer {
            margin-top: 30px;
            width: 100%;
        }
        .signature-table {
            width: 100%;
            margin-top: 30px;
        }
        .signature-table td {
            text-align: center;
            vertical-align: top;
        }
        .signature-name {
            margin-top: 60px;
            font-weight: bold;
            text-decoration: underline;
        }
        .signature-nip {
            font-size: 11px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>SMA Negeri 1 Tuhemberua</h1>
        <h2>Dinas Pendidikan dan Kebudayaan Provinsi</h2>
        <p>Silima Banua, Kec. Tuhemberua, Kabupaten Nias Utara, Sumatera Utara 22852</p>
    </div>

    <div class="title">
        LAPORAN HASIL BELAJAR SISWA<br>
        SEMESTER GENAP TAHUN AJARAN 2025/2026
    </div>

    <table class="info-table">
        <tr>
            <td width="15%">Nama Lengkap</td>
            <td width="1%">:</td>
            <td width="34%">{{ $siswa->nama_lengkap }}</td>
            <td width="15%">Kelas</td>
            <td width="1%">:</td>
            <td>{{ $siswa->kelas->nama_kelas }}</td>
        </tr>
        <tr>
            <td>NISN / NIS</td>
            <td>:</td>
            <td>{{ $siswa->nisn }} / {{ $siswa->nis }}</td>
            <td>Wali Kelas</td>
            <td>:</td>
            <td>{{ $siswa->kelas->waliKelas->nama_lengkap ?? '-' }}</td>
        </tr>
    </table>

    <table class="table">
        <thead>
            <tr>
                <th width="5%">No</th>
                <th>Mata Pelajaran</th>
                <th width="10%">KKM</th>
                <th width="10%">Nilai Akhir</th>
                <th width="10%">Predikat</th>
                <th width="20%">Keterangan</th>
            </tr>
        </thead>
        <tbody>
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
                    
                    // KKM
                    $kkm = 75; 
                @endphp
                <tr>
                    <td class="text-center">{{ $no++ }}</td>
                    <td>
                        {{ $mapel->nama_mapel }}<br>
                        <small style="font-size: 10px; color: #555;">Guru: {{ $mapelNilais->first()->guru->nama_lengkap }}</small>
                    </td>
                    <td class="text-center">{{ $kkm }}</td>
                    <td class="text-center">{{ number_format($average, 0) }}</td>
                    <td class="text-center">{{ $predikat }}</td>
                    <td class="text-center">{{ $average >= $kkm ? 'Tuntas' : 'Belum Tuntas' }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center">Belum ada nilai yang diinput.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <table class="signature-table">
        <tr>
            <td width="33%">
                <p>Orang Tua / Wali</p>
                <div class="signature-name">.............................</div>
            </td>
            <td width="33%">
                <p>Wali Kelas</p>
                <div class="signature-name">{{ $siswa->kelas->waliKelas->nama_lengkap ?? '.............................' }}</div>
                @if(isset($siswa->kelas->waliKelas->nip))
                    <div class="signature-nip">NIP. {{ $siswa->kelas->waliKelas->nip }}</div>
                @endif
            </td>
            <td width="33%">
                <p>Kepala Sekolah</p>
                <div class="signature-name">Dr. H. Kepala Sekolah, M.Pd</div>
                <div class="signature-nip">NIP. 19800101 200001 1 001</div>
            </td>
        </tr>
    </table>
</body>
</html>