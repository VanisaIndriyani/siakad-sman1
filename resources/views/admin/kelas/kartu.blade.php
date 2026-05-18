<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Kartu Siswa - {{ $kelas->nama_kelas }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }
        @media print {
            @page {
                margin: 0.5cm;
                size: A4;
            }
            .no-print {
                display: none !important;
            }
            body {
                print-color-adjust: exact;
                -webkit-print-color-adjust: exact;
                background: white !important;
            }
            .card-container {
                break-inside: avoid;
                page-break-inside: avoid;
            }
        }
        .card {
            width: 85.6mm;
            min-height: 53.98mm;
            height: auto;
            position: relative;
            overflow: hidden;
            border-radius: 12px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        }
        .bg-pattern {
            background-color: #1e3a8a;
            background-image: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%232563eb' fill-opacity='0.1'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
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
</head>
<body class="bg-gray-100 min-h-screen p-8 print:p-0">
    <!-- Controls -->
    <div class="max-w-5xl mx-auto mb-8 flex justify-between items-center no-print">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Cetak Kartu Pelajar</h1>
            <p class="text-gray-600">Kelas: {{ $kelas->nama_kelas }} | Total: {{ $kelas->siswas->count() }} Siswa</p>
        </div>
        <div class="flex gap-4">
            <a href="{{ route('admin.siswa.index') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-700 font-bold py-2 px-4 rounded-lg transition-colors flex items-center shadow-sm">
                <i class="fas fa-arrow-left mr-2"></i> Kembali
            </a>
            @if($kelas->siswas->count() === 1)
                <button type="button" id="downloadPngBtn" class="bg-yellow-500 hover:bg-yellow-600 text-white font-bold py-2 px-4 rounded-lg shadow-sm transition-colors flex items-center">
                    <i class="fas fa-image mr-2"></i> Download PNG
                </button>
            @endif
            <button onclick="window.print()" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg shadow-sm transition-colors flex items-center">
                <i class="fas fa-print mr-2"></i> Cetak Sekarang
            </button>
        </div>
    </div>

    <!-- Cards Grid -->
    <div class="max-w-5xl mx-auto grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 gap-8 print:grid-cols-2 print:gap-6 print:w-full">
        @foreach($kelas->siswas as $siswa)
        <div class="card-container flex justify-center">
            <div id="card-{{ $siswa->id }}" class="card bg-white relative flex flex-col" data-filename="kartu-{{ $siswa->nisn ?: $siswa->id }}.png">
                <!-- Decorative Top Bar -->
                <div class="h-2 bg-yellow-400 w-full absolute top-0 z-20"></div>
                
                <!-- Main Content -->
                <div class="flex-1 flex flex-col relative z-10">
                    <!-- Header -->
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

                    <!-- Body Info -->
                    <div class="card-body p-4 flex-1 flex flex-col justify-center bg-white relative">
                        <!-- Watermark -->
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
                                    <p class="text-sm font-bold text-gray-700 font-mono">{{ $siswa->nisn }}</p>
                                </div>
                                <div>
                                    <span class="text-[9px] text-gray-400 uppercase font-semibold tracking-wider block mb-0.5">Kelas</span>
                                    <p class="text-sm font-bold text-gray-700">{{ $kelas->nama_kelas }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Footer -->
                    <div class="card-footer bg-gray-50 px-4 py-1 border-t border-gray-100 flex justify-between items-center">
                        <div class="text-[8px] text-gray-400 leading-tight">
                            <p>Berlaku selama menjadi siswa</p>
                            <p>SMA Negeri 1</p>
                        </div>
                        <div class="flex flex-col items-end">
                            @if(isset($qrDataUris) && isset($qrDataUris[$siswa->id]))
                                <img src="{!! $qrDataUris[$siswa->id] !!}" width="72" height="72" class="qr-img bg-white" style="image-rendering: pixelated;" alt="QR Code">
                            @else
                                <img src="{{ route('admin.siswa.qr.png', $siswa->id) }}" width="72" height="72" class="qr-img bg-white" style="image-rendering: pixelated;" alt="QR Code">
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    @if($kelas->siswas->count() === 1)
        <script>
            (function () {
                const button = document.getElementById('downloadPngBtn');
                const card = document.querySelector('[id^="card-"]');
                if (!button || !card) return;

                function loadScript(src) {
                    return new Promise(function (resolve, reject) {
                        const s = document.createElement('script');
                        s.src = src;
                        s.async = true;
                        s.onload = resolve;
                        s.onerror = reject;
                        document.head.appendChild(s);
                    });
                }

                async function ensureHtml2Canvas() {
                    if (window.html2canvas) return true;
                    try {
                        await loadScript('https://cdn.jsdelivr.net/npm/html2canvas@1.4.1/dist/html2canvas.min.js');
                    } catch (_) {
                        await loadScript('https://unpkg.com/html2canvas@1.4.1/dist/html2canvas.min.js');
                    }
                    return typeof window.html2canvas === 'function';
                }

                async function waitForFonts() {
                    if (document.fonts && document.fonts.ready) {
                        try {
                            await document.fonts.ready;
                        } catch (_) {}
                    }
                }

                async function waitForImages(root) {
                    const images = Array.from(root.querySelectorAll('img'));
                    const tasks = images.map(function (img) {
                        if (img.complete && img.naturalWidth > 0) return Promise.resolve();
                        if (img.decode) return img.decode().catch(function () {});
                        return new Promise(function (resolve) {
                            img.onload = function () { resolve(); };
                            img.onerror = function () { resolve(); };
                        });
                    });
                    await Promise.all(tasks);
                }

                async function downloadPng() {
                    button.disabled = true;
                    const originalText = button.innerText;
                    button.innerText = 'Memproses...';

                    try {
                        const ok = await ensureHtml2Canvas();
                        if (!ok) throw new Error('html2canvas tidak tersedia');

                        await waitForFonts();
                        await waitForImages(card);

                        const canvas = await window.html2canvas(card, {
                            backgroundColor: null,
                            scale: 2,
                            useCORS: true,
                            allowTaint: true
                        });

                        canvas.toBlob(function (blob) {
                            if (!blob) {
                                button.disabled = false;
                                button.innerText = originalText;
                                return;
                            }
                            const url = URL.createObjectURL(blob);
                            const a = document.createElement('a');
                            a.href = url;
                            a.download = card.getAttribute('data-filename') || 'kartu-siswa.png';
                            document.body.appendChild(a);
                            a.click();
                            a.remove();
                            URL.revokeObjectURL(url);

                            button.disabled = false;
                            button.innerText = originalText;
                        }, 'image/png');
                    } catch (_) {
                        button.disabled = false;
                        button.innerText = originalText;
                        alert('Gagal membuat PNG. Pastikan koneksi tidak memblokir library browser, lalu coba refresh.');
                    }
                }

                button.addEventListener('click', downloadPng);
            })();
        </script>
    @endif
</body>
</html>
