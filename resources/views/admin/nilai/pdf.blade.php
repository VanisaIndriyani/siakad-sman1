<!DOCTYPE html>
<html>
<head>
    <title>Laporan Nilai Siswa</title>
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
        .signature {
            float: right;
            width: 200px;
            text-align: center;
        }
        .signature p {
            margin: 5px 0;
        }
        .signature .name {
            margin-top: 60px;
            font-weight: bold;
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>SMA Negeri 1 Tuhemberua</h1>
        <h2>Dinas Pendidikan dan Kebudayaan Provinsi</h2>
        <p>Silima Banua, Kec. Tuhemberua, Kabupaten Nias Utara, Sumatera Utara 22852</p>
    </div>

    <div class="title">Laporan Nilai Siswa</div>

    <table class="info-table">
        <tr>
            <td width="15%">Kelas</td>
            <td width="1%">:</td>
            <td>{{ $kelas ? $kelas->nama_kelas : 'Semua Kelas' }}</td>
        </tr>
        <tr>
            <td>Mata Pelajaran</td>
            <td>:</td>
            <td>{{ $mapel ? $mapel->nama_mapel : 'Semua Mata Pelajaran' }}</td>
        </tr>
        <tr>
            <td>Kategori Nilai</td>
            <td>:</td>
            <td>{{ $kategori ? $kategori : 'Semua Kategori' }}</td>
        </tr>
        <tr>
            <td>Tanggal Cetak</td>
            <td>:</td>
            <td>{{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}</td>
        </tr>
    </table>

    <table class="table">
        <thead>
            <tr>
                <th width="5%">No</th>
                <th width="20%">Nama Siswa</th>
                <th width="10%">Kelas</th>
                <th>Mata Pelajaran</th>
                <th width="10%">Kategori</th>
                <th width="10%">Nilai</th>
                <th width="20%">Keterangan</th>
            </tr>
        </thead>
        <tbody>
            @forelse($nilais as $index => $nilai)
            <tr>
                <td class="text-center">{{ $index + 1 }}</td>
                <td>{{ $nilai->siswa->nama_lengkap }}</td>
                <td class="text-center">{{ $nilai->siswa->kelas->nama_kelas ?? '-' }}</td>
                <td>{{ $nilai->mapel->nama_mapel }}</td>
                <td class="text-center">{{ $nilai->kategori }}</td>
                <td class="text-center">{{ $nilai->nilai }}</td>
                <td>{{ $nilai->catatan ?? '-' }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="7" class="text-center">Tidak ada data nilai.</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        <div class="signature">
            <p>Mengetahui,</p>
            <p>Kepala Sekolah</p>
            <div class="name">Nama Kepala Sekolah</div>
            <p>NIP. .......................</p>
        </div>
    </div>
</body>
</html>
