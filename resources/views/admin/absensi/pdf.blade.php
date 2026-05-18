<!DOCTYPE html>
<html>
<head>
    <title>Laporan Absensi Siswa</title>
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
        /* Status Colors (Text only for PDF to save ink/ensure readability) */
        .status-hadir { color: green; }
        .status-izin { color: blue; }
        .status-sakit { color: orange; }
        .status-alpa { color: red; }
    </style>
</head>
<body>
    <div class="header">
        <h1>SMA Negeri 1 Tuhemberua</h1>
        <h2>Dinas Pendidikan dan Kebudayaan Provinsi</h2>
        <p>Silima Banua, Kec. Tuhemberua, Kabupaten Nias Utara, Sumatera Utara 22852</p>
    </div>

    <div class="title">Laporan Absensi Siswa</div>

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
            <td>Tanggal Cetak</td>
            <td>:</td>
            <td>{{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}</td>
        </tr>
    </table>

    <table class="table">
        <thead>
            <tr>
                <th width="5%">No</th>
                <th width="15%">Tanggal</th>
                <th>Nama Siswa</th>
                <th width="10%">Kelas</th>
                <th>Mata Pelajaran</th>
                <th width="10%">Status</th>
                <th width="20%">Keterangan</th>
            </tr>
        </thead>
        <tbody>
            @forelse($absensis as $index => $absensi)
            <tr>
                <td class="text-center">{{ $index + 1 }}</td>
                <td class="text-center">{{ \Carbon\Carbon::parse($absensi->tanggal)->translatedFormat('d/m/Y') }}</td>
                <td>{{ $absensi->siswa->nama_lengkap }}</td>
                <td class="text-center">{{ $absensi->kelas->nama_kelas }}</td>
                <td>{{ $absensi->mapel->nama_mapel }}</td>
                <td class="text-center">
                    <span class="status-{{ strtolower($absensi->status) }}">
                        {{ $absensi->status }}
                    </span>
                </td>
                <td>{{ $absensi->keterangan ?? '-' }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="7" class="text-center">Tidak ada data absensi.</td>
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
