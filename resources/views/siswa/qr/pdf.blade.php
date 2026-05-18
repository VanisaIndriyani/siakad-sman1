<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Kartu Siswa</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; margin: 0; padding: 0; }
        .header { text-align: center; margin-bottom: 16px; border-bottom: 2px solid #000; padding: 8px 0; }
        .header h1 { margin: 0; font-size: 18px; text-transform: uppercase; }
        .header p { margin: 2px 0; font-size: 11px; }
        .title { text-align: center; font-weight: bold; text-transform: uppercase; margin: 10px 0 14px; }
        .table { width: 100%; border-collapse: collapse; }
        .table td { padding: 4px 0; vertical-align: top; }
        .qr { margin-top: 12px; }
        .qr img { width: 180px; height: 180px; }
        .small { font-size: 11px; color: #444; }
    </style>
</head>
<body>
    <div class="header">
        <h1>SMA Negeri 1 Tuhemberua</h1>
        <p>Silima Banua, Kec. Tuhemberua, Kabupaten Nias Utara, Sumatera Utara 22852</p>
    </div>

    <div class="title">Kartu Siswa</div>

    <table class="table">
        <tr>
            <td width="18%">Nama</td>
            <td width="2%">:</td>
            <td width="50%">{{ $siswa->nama_lengkap }}</td>
            <td width="15%">Kelas</td>
            <td width="2%">:</td>
            <td>{{ $siswa->kelas->nama_kelas ?? '-' }}</td>
        </tr>
        <tr>
            <td>NISN / NIS</td>
            <td>:</td>
            <td>{{ $siswa->nisn ?? '-' }} / {{ $siswa->nis ?? '-' }}</td>
            <td>Identitas QR</td>
            <td>:</td>
            <td>{{ $payload }}</td>
        </tr>
        <tr>
            <td>Tanggal Cetak</td>
            <td>:</td>
            <td>{{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}</td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
    </table>

    <div class="qr">
        <img src="{{ $qrDataUri }}" alt="QR Code">
        <div class="small">Scan QR untuk melihat identitas (NISN/ID).</div>
    </div>
</body>
</html>
