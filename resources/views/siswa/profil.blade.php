@extends('layouts.siswa')

@section('title', 'Profil Siswa')
@section('header', 'Profil Siswa')

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="bg-white rounded-2xl border border-gray-100 card-shadow overflow-hidden">
        <div class="p-6 border-b border-gray-100 flex items-center justify-between">
            <h3 class="font-bold text-gray-800">Kartu Siswa</h3>
            <div class="flex gap-3">
                <a href="{{ route('siswa.qr.png', ['download' => 1]) }}" class="bg-yellow-500 hover:bg-yellow-600 text-white font-semibold py-2 px-4 rounded-lg shadow-sm text-sm transition-colors">
                    <i class="fas fa-download mr-2"></i> Download PNG
                </a>
                <a href="{{ route('siswa.qr.pdf', ['download' => 1]) }}" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded-lg shadow-sm text-sm transition-colors">
                    <i class="fas fa-file-pdf mr-2"></i> Download PDF
                </a>
            </div>
        </div>
        <div class="p-6">
            <style>
                .card {
                    width: 85.6mm;
                    min-height: 53.98mm;
                    height: auto;
                    position: relative;
                    overflow: hidden;
                    border-radius: 12px;
                    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
                }
                @media print {
                    .card {
                        height: 53.98mm;
                    }
                    .card-header {
                        padding: 8px 10px 6px 10px !important;
                    }
                    .card-body {
                        padding: 8px 10px !important;
                    }
                    .card-footer {
                        padding: 2px 8px !important;
                    }
                    .student-name {
                        font-size: 13px !important;
                    }
                    .qr-img {
                        width: 56px !important;
                        height: 56px !important;
                    }
                    .barcode-img {
                        height: 12px !important;
                        width: 100px !important;
                    }
                }
            </style>

            <div class="flex flex-col items-center">
                <div class="card bg-white relative flex flex-col">
                    <div class="h-2 bg-yellow-400 w-full absolute top-0 z-20"></div>
                    <div class="flex-1 flex flex-col relative z-10">
                        <div class="card-header bg-blue-900 text-white p-4 pt-5 flex items-center justify-between relative overflow-hidden">
                            <div class="absolute top-0 right-0 -mt-2 -mr-2 w-16 h-16 bg-blue-800 rounded-full opacity-50 z-0 pointer-events-none"></div>
                            <div class="absolute bottom-0 left-0 -mb-2 -ml-2 w-12 h-12 bg-blue-800 rounded-full opacity-50 z-0 pointer-events-none"></div>

                            <div class="flex items-center gap-3 relative z-10">
                                <div class="w-10 h-10 bg-white rounded-full flex items-center justify-center text-blue-900 shadow-lg">
                                    <i class="fas fa-graduation-cap text-lg"></i>
                                </div>
                                <div>
                                    <h2 class="font-bold text-sm uppercase leading-tight tracking-wide">SMA Negeri 1</h2>
                                    <p class="text-[9px] text-blue-200 font-medium tracking-wider">KARTU TANDA PELAJAR</p>
                                </div>
                            </div>

                            <div class="text-right relative z-20">
                                <span class="text-[8px] font-bold bg-yellow-400 text-blue-900 px-2 py-0.5 rounded-full uppercase tracking-wider">Siswa Aktif</span>
                            </div>
                        </div>

                        <div class="card-body p-4 flex-1 flex flex-col justify-center bg-white relative">
                            <div class="absolute bottom-0 right-0 opacity-[0.03] text-blue-900 pointer-events-none">
                                <i class="fas fa-school text-9xl transform -translate-y-4 translate-x-4"></i>
                            </div>

                            <div class="grid grid-cols-1 gap-3 relative z-10">
                                <div>
                                    <span class="text-[9px] text-gray-400 uppercase font-semibold tracking-wider block mb-0.5">Nama Lengkap</span>
                                <h3 class="student-name text-lg font-bold text-gray-800 leading-tight border-b border-gray-100 pb-1">{{ $siswa->nama_lengkap }}</h3>
                                </div>

                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <span class="text-[9px] text-gray-400 uppercase font-semibold tracking-wider block mb-0.5">NISN</span>
                                        <p class="text-sm font-bold text-gray-700 font-mono">{{ $siswa->nisn ?? '-' }}</p>
                                    </div>
                                    <div>
                                        <span class="text-[9px] text-gray-400 uppercase font-semibold tracking-wider block mb-0.5">Kelas</span>
                                        <p class="text-sm font-bold text-gray-700">{{ $siswa->kelas->nama_kelas ?? '-' }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card-footer bg-gray-50 px-4 py-1 border-t border-gray-100 flex justify-between items-center">
                            <div class="text-[8px] text-gray-400 leading-tight">
                                <p>Berlaku selama menjadi siswa</p>
                                <p>SMA Negeri 1</p>
                            </div>
                            <div class="flex flex-col items-end">
                                @if(isset($qrDataUriSmall))
                                    <img src="{!! $qrDataUriSmall !!}" width="72" height="72" class="qr-img bg-white" style="image-rendering: pixelated;" alt="QR Code">
                                @else
                                    <img src="{{ route('siswa.qr.png') }}" width="72" height="72" class="qr-img bg-white" style="image-rendering: pixelated;" alt="QR Code">
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <p id="qrHint" class="text-xs text-gray-500 mt-3">QR berisi identitas siswa</p>
            </div>
        </div>
    </div>
</div>
@endsection
