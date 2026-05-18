<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Jadwal Pelajaran - {{ $siswa->kelas->nama_kelas }}</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; margin: 0; padding: 0; }
        .header { text-align: center; margin-bottom: 16px; border-bottom: 2px solid #000; padding: 8px 0; }
        .header h1 { margin: 0; font-size: 18px; text-transform: uppercase; }
        .header p { margin: 2px 0; font-size: 11px; }
        .title { text-align: center; font-weight: bold; text-transform: uppercase; margin: 10px 0 14px; }
        .info-table { width: 100%; margin-bottom: 10px; }
        .info-table td { padding: 3px 0; font-size: 12px; vertical-align: top; }
        .day-title { background: #f0f0f0; padding: 6px 8px; font-weight: bold; text-transform: uppercase; border: 1px solid #000; border-bottom: none; }
        .table { width: 100%; border-collapse: collapse; margin-bottom: 14px; }
        .table th, .table td { border: 1px solid #000; padding: 6px; }
        .table th { background: #fafafa; text-align: center; }
        .text-center { text-align: center; }
        .small { font-size: 11px; color: #444; }
        .footer { margin-top: 24px; width: 100%; }
        .signature { float: right; width: 220px; text-align: center; }
        .signature .name { margin-top: 60px; font-weight: bold; text-decoration: underline; }
    </style>
</head>
<body>
    <div class="header">
        <h1>SMA Negeri 1 Tuhemberua</h1>
        <p>Silima Banua, Kec. Tuhemberua, Kabupaten Nias Utara, Sumatera Utara 22852</p>
    </div>

    <div class="title">Jadwal Pelajaran Kelas {{ $siswa->kelas->nama_kelas }}</div>

    <table class="info-table">
        <tr>
            <td width="18%">Nama Siswa</td>
            <td width="1%">:</td>
            <td width="46%">{{ $siswa->nama_lengkap }}</td>
            <td width="15%">Tanggal Cetak</td>
            <td width="1%">:</td>
            <td>{{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}</td>
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

    @php
        $order = ['Senin','Selasa','Rabu','Kamis','Jumat','Sabtu'];
        $hasAny = isset($jadwalsByDay) && $jadwalsByDay->flatten()->count() > 0;
    @endphp

    @if($hasAny)
        @foreach($order as $hari)
            @if(isset($jadwalsByDay[$hari]) && $jadwalsByDay[$hari]->count())
                <div class="day-title">{{ $hari }}</div>
                <table class="table">
                    <thead>
                        <tr>
                            <th width="8%">No</th>
                            <th width="18%">Jam</th>
                            <th>Mata Pelajaran</th>
                            <th width="28%">Guru</th>
                            <th width="12%">Ruang</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($jadwalsByDay[$hari] as $i => $item)
                            <tr>
                                <td class="text-center">{{ $i + 1 }}</td>
                                <td class="text-center">
                                    {{ \Carbon\Carbon::parse($item->jam_mulai)->format('H:i') }} - {{ \Carbon\Carbon::parse($item->jam_selesai)->format('H:i') }}
                                </td>
                                <td>{{ $item->mapel->nama_mapel }}</td>
                                <td>{{ $item->guru->nama_lengkap }}</td>
                                <td class="text-center">{{ $item->kelas->nama_kelas }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        @endforeach
    @else
        <p>Tidak ada jadwal.</p>
    @endif

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
