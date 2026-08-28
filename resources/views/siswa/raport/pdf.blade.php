<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Raport - {{ $siswa->nama_lengkap }}</title>
    <style>
        body { font-family: 'Times New Roman', serif; color: #111; font-size: 12px; }
        .text-center { text-align: center; }
        .text-right { text-align: right; }
        .uppercase { text-transform: uppercase; }
        .border-b-2 { border-bottom: 2px solid #111; }
        .border-collapse { border-collapse: collapse; }
        .w-full { width: 100%; }
        .mt-1 { margin-top: 4px; }
        .mt-4 { margin-top: 16px; }
        .mt-8 { margin-top: 32px; }
        .mb-4 { margin-bottom: 16px; }
        .mb-6 { margin-bottom: 24px; }
        .pb-4 { padding-bottom: 16px; }
        .p-2 { padding: 8px; }
        .p-3 { padding: 12px; }
        .border { border: 1px solid #000; }
        .border-t { border-top: 1px solid #000; }
        .border-b { border-bottom: 1px solid #000; }
        .border-l { border-left: 1px solid #000; }
        .border-r { border-right: 1px solid #000; }
        .grid-2 { display: inline-block; width: 48%; vertical-align: top; }
        .bg-gray { background-color: #f3f4f6; }
        .grid-4col { display: table; width: 100%; }
        .col-25 { display: table-cell; width: 25%; padding: 10px; border: 1px solid #000; text-align: center; }
    </style>
</head>
<body>
    <div class="text-center border-b-2 pb-4 mb-6">
        <h1 class="uppercase" style="font-size: 22px; margin: 0;">SMA Negeri 1 Tuhemberua</h1>
        <h2 style="font-size: 18px; margin: 4px 0;">Laporan Hasil Belajar Siswa</h2>
        <p style="font-size: 13px; margin: 6px 0 0;">Tahun Ajaran {{ now()->format('Y') }}/{{ now()->format('Y') + 1 }} - Tanggal: {{ now()->format('d F Y') }}</p>
    </div>

    <h3 class="uppercase" style="font-size: 14px; margin-bottom: 8px;">A. Identitas Siswa</h3>
    <table class="w-full mb-6" cellpadding="4">
        <tr>
            <td style="width: 48%; vertical-align: top;">
                <table class="w-full">
                    <tr><td style="width: 150px;">Nama Lengkap</td><td>: <b>{{ $siswa->nama_lengkap }}</b></td></tr>
                    <tr><td>NISN / NIS</td><td>: <b>{{ $siswa->nisn ?? '-' }} / {{ $siswa->nis ?? '-' }}</b></td></tr>
                    <tr><td>Jenis Kelamin</td><td>: <b>{{ $siswa->jenis_kelamin === 'L' ? 'Laki-laki' : 'Perempuan' }}</b></td></tr>
                </table>
            </td>
            <td style="width: 48%; vertical-align: top;">
                <table class="w-full">
                    <tr><td style="width: 150px;">Kelas</td><td>: <b>{{ optional($siswa->kelas)->nama_kelas ?? '-' }}</b></td></tr>
                    <tr><td>Wali Kelas</td><td>: <b>{{ optional(optional($siswa->kelas)->waliKelas)->nama_lengkap ?? '-' }}</b></td></tr>
                    <tr><td>Total Mata Pelajaran</td><td>: <b>{{ $summary['total_mapel'] }} Mapel</b></td></tr>
                </table>
            </td>
        </tr>
    </table>

    <h3 class="uppercase" style="font-size: 14px; margin-bottom: 8px;">B. Ringkasan Akademik</h3>
    <div class="grid-4col mb-6">
        <div class="col-25"><div>Rata-Rata Akhir</div><div style="font-size: 20px;"><b>{{ $summary['rata_rata_akhir'] }}</b></div></div>
        <div class="col-25"><div>Mapel Tuntas</div><div style="font-size: 20px;"><b>{{ $summary['tuntas'] }}</b></div></div>
        <div class="col-25"><div>Mapel Belum Tuntas</div><div style="font-size: 20px;"><b>{{ $summary['tidak_tuntas'] }}</b></div></div>
        <div class="col-25"><div>Nilai Tertinggi</div><div style="font-size: 20px;"><b>{{ $summary['nilai_tertinggi'] }}</b></div></div>
    </div>

    <h3 class="uppercase" style="font-size: 14px; margin-bottom: 8px;">C. Daftar Nilai Mata Pelajaran</h3>
    <table class="w-full border-collapse mb-6" cellpadding="8">
        <thead>
            <tr class="bg-gray">
                <th class="border" style="width: 6%;">No</th>
                <th class="border" style="width: 32%;">Mata Pelajaran</th>
                <th class="border" style="width: 10%;">Tugas</th>
                <th class="border" style="width: 10%;">UTS</th>
                <th class="border" style="width: 10%;">UAS</th>
                <th class="border" style="width: 8%;">KKM</th>
                <th class="border" style="width: 12%;">Nilai Akhir</th>
                <th class="border" style="width: 12%;">Status</th>
            </tr>
        </thead>
        <tbody>
            @php $no = 1; @endphp
            @foreach($nilaiMapel as $nm)
                <tr>
                    <td class="border text-center">{{ $no++ }}</td>
                    <td class="border"><b>{{ optional($nm->mapel)->nama_mapel ?? 'Mapel' }}</b><br><span style="font-size: 10px; color: #555;">Guru: {{ optional($nm->guru)->nama_lengkap ?? '-' }}</span></td>
                    <td class="border text-center">{{ $nm->tugas ? number_format($nm->tugas, 0) : '-' }}</td>
                    <td class="border text-center">{{ $nm->uts ? number_format($nm->uts, 0) : '-' }}</td>
                    <td class="border text-center">{{ $nm->uas ? number_format($nm->uas, 0) : '-' }}</td>
                    <td class="border text-center">{{ $nm->kkm }}</td>
                    <td class="border text-center"><b>{{ number_format($nm->rata, 0) }}</b></td>
                    <td class="border text-center">{{ $nm->status }}</td>
                </tr>
            @endforeach
            @if($nilaiMapel->isEmpty())
                <tr><td colspan="8" class="border text-center p-3">Belum ada nilai yang diinput.</td></tr>
            @endif
        </tbody>
    </table>

    <h3 class="uppercase" style="font-size: 14px; margin-bottom: 8px;">D. Rekapitulasi Absensi</h3>
    <table class="w-full border-collapse mb-8">
        <tr>
            <td class="col-25 border text-center"><div>Hadir</div><div style="font-size: 18px;"><b>{{ $absensiSummary['Hadir'] }}</b></div></td>
            <td class="col-25 border text-center"><div>Sakit</div><div style="font-size: 18px;"><b>{{ $absensiSummary['Sakit'] }}</b></div></td>
            <td class="col-25 border text-center"><div>Izin</div><div style="font-size: 18px;"><b>{{ $absensiSummary['Izin'] }}</b></div></td>
            <td class="col-25 border text-center"><div>Alpa</div><div style="font-size: 18px;"><b>{{ $absensiSummary['Alpa'] }}</b></div></td>
        </tr>
    </table>

    <table class="w-full mt-8">
        <tr>
            <td class="text-center" style="width: 33%;">
                <div style="margin-bottom: 80px;">Mengetahui,<br>Orang Tua / Wali</div>
                <u style="font-weight: bold;">....................................</u>
            </td>
            <td class="text-center" style="width: 33%;">
                <div style="margin-bottom: 80px;">Tuhemberua, {{ now()->format('d F Y') }}<br>Wali Kelas</div>
                <u style="font-weight: bold;">{{ optional(optional($siswa->kelas)->waliKelas)->nama_lengkap ?? '....................................' }}</u>
                <div style="font-size: 10px; margin-top: 4px;">NIP. {{ optional(optional($siswa->kelas)->waliKelas)->nip ?? '..............' }}</div>
            </td>
            <td class="text-center" style="width: 33%;">
                <div style="margin-bottom: 80px;">Kepala Sekolah</div>
                <u style="font-weight: bold;">....................................</u>
                <div style="font-size: 10px; margin-top: 4px;">NIP. ..............</div>
            </td>
        </tr>
    </table>
</body>
</html>
