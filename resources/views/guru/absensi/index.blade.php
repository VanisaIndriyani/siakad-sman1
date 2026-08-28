@extends('layouts.guru')

@section('title', 'Absensi Siswa')
@section('header', 'Absensi Siswa')

@section('content')
<div class="space-y-6">
    <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-6">
        <form action="{{ route('guru.absensi.index') }}" method="GET" class="flex flex-col md:flex-row gap-4 items-end">
            <div class="w-full md:flex-1">
                <label for="kelas_id" class="block text-sm font-medium text-gray-700 mb-1">Pilih Kelas</label>
                <select name="kelas_id" id="kelas_id" class="w-full rounded-lg border-gray-300 focus:border-green-500 focus:ring-green-500 shadow-sm" required>
                    <option value="">-- Pilih Kelas --</option>
                    @foreach($kelasDiampu as $kelas)
                        <option value="{{ $kelas->id }}" {{ $selectedKelasId == $kelas->id ? 'selected' : '' }}>
                            {{ $kelas->nama_kelas }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="w-full md:flex-1">
                <label for="mapel_id" class="block text-sm font-medium text-gray-700 mb-1">Pilih Mata Pelajaran</label>
                <select name="mapel_id" id="mapel_id" class="w-full rounded-lg border-gray-300 focus:border-green-500 focus:ring-green-500 shadow-sm" required>
                    <option value="">-- Pilih Mapel --</option>
                    @foreach($mapelDiampu as $mapel)
                        <option value="{{ $mapel->id }}" {{ $selectedMapelId == $mapel->id ? 'selected' : '' }}>
                            {{ $mapel->nama_mapel }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="w-full md:w-48">
                <label for="tanggal" class="block text-sm font-medium text-gray-700 mb-1">Tanggal</label>
                <input type="date" name="tanggal" id="tanggal" value="{{ $selectedTanggal }}" class="w-full rounded-lg border-gray-300 focus:border-green-500 focus:ring-green-500 shadow-sm" required>
            </div>
            <button type="submit" class="w-full md:w-auto bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-6 rounded-lg transition-colors shadow-sm text-sm">
                <i class="fas fa-search mr-2"></i> Tampilkan
            </button>
        </form>
    </div>

    @if($selectedKelasId && $selectedMapelId)
        <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-6">
            <div class="flex items-center justify-between flex-wrap gap-4">
                <div>
                    <h3 class="text-lg font-bold text-gray-800">Absensi via QR</h3>
                    <p class="text-sm text-gray-500">Scan QR siswa atau ketik hasil scan (contoh: NISN:123... / ID:1)</p>
                </div>
                <div class="flex items-center gap-3">
                    <button type="button" id="startCameraBtn" class="bg-gray-900 hover:bg-gray-800 text-white font-semibold py-2 px-4 rounded-lg shadow-sm text-sm transition-colors">
                        <i class="fas fa-camera mr-2"></i> Mulai Kamera
                    </button>
                    <button type="button" id="stopCameraBtn" class="bg-gray-200 hover:bg-gray-300 text-gray-800 font-semibold py-2 px-4 rounded-lg shadow-sm text-sm transition-colors hidden">
                        <i class="fas fa-stop mr-2"></i> Stop
                    </button>
                </div>
            </div>

            <div id="scanAlert" class="mt-4 hidden p-4 rounded-lg border text-sm"></div>

            <div class="mt-4 grid grid-cols-1 md:grid-cols-3 gap-4 items-start">
                <form id="scanForm" class="md:col-span-2 flex gap-3">
                    <input type="text" id="qrInput" class="flex-1 rounded-lg border-gray-300 focus:border-green-500 focus:ring-green-500 shadow-sm" placeholder="Scan/masukkan QR di sini lalu Enter" autocomplete="off">
                    <button type="submit" class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded-lg transition-colors shadow-sm text-sm">
                        <i class="fas fa-check mr-2"></i> Catat
                    </button>
                </form>
                <div class="rounded-lg border border-gray-200 bg-gray-50 p-3">
                    <div class="text-xs text-gray-500 mb-2">Preview Kamera</div>
                    <div id="qrReader" class="w-full rounded-md bg-black overflow-hidden" style="min-height: 220px;"></div>
                    <div id="cameraHint" class="text-xs text-gray-500 mt-2">Browser akan meminta izin kamera. Jika tidak tersedia, gunakan input manual di sebelah kiri.</div>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden">
            <div class="p-6 border-b border-gray-100 flex justify-between items-center bg-gray-50">
                <h3 class="text-lg font-bold text-gray-800">Daftar Siswa</h3>
                <span class="bg-blue-100 text-blue-800 text-xs font-semibold px-2.5 py-0.5 rounded">{{ count($siswas) }} Siswa</span>
            </div>

            <form action="{{ route('guru.absensi.store') }}" method="POST">
                @csrf
                <input type="hidden" name="kelas_id" value="{{ $selectedKelasId }}">
                <input type="hidden" name="mapel_id" value="{{ $selectedMapelId }}">
                <input type="hidden" name="tanggal" value="{{ $selectedTanggal }}">

                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 border-b">
                            <tr>
                                <th class="px-6 py-3 font-medium">No</th>
                                <th class="px-6 py-3 font-medium">NISN / Nama</th>
                                <th class="px-6 py-3 font-medium text-center">Status Kehadiran</th>
                                <th class="px-6 py-3 font-medium">Keterangan</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse($siswas as $index => $siswa)
                                <tr class="hover:bg-gray-50 transition-colors" data-siswa-id="{{ $siswa->id }}">
                                    <td class="px-6 py-4 font-medium text-gray-900">{{ $index + 1 }}</td>
                                    <td class="px-6 py-4">
                                        <div class="font-bold text-gray-900">{{ $siswa->nama_lengkap }}</div>
                                        <div class="text-xs text-gray-500">{{ $siswa->nisn }}</div>
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        <div class="flex justify-center gap-4">
                                            <label class="inline-flex items-center cursor-pointer">
                                                <input type="radio" name="status[{{ $siswa->id }}]" value="Hadir" class="form-radio text-green-600 focus:ring-green-500" {{ $siswa->status_absensi == 'Hadir' ? 'checked' : '' }}>
                                                <span class="ml-2">Hadir</span>
                                            </label>
                                            <label class="inline-flex items-center cursor-pointer">
                                                <input type="radio" name="status[{{ $siswa->id }}]" value="Izin" class="form-radio text-yellow-500 focus:ring-yellow-500" {{ $siswa->status_absensi == 'Izin' ? 'checked' : '' }}>
                                                <span class="ml-2">Izin</span>
                                            </label>
                                            <label class="inline-flex items-center cursor-pointer">
                                                <input type="radio" name="status[{{ $siswa->id }}]" value="Sakit" class="form-radio text-blue-500 focus:ring-blue-500" {{ $siswa->status_absensi == 'Sakit' ? 'checked' : '' }}>
                                                <span class="ml-2">Sakit</span>
                                            </label>
                                            <label class="inline-flex items-center cursor-pointer">
                                                <input type="radio" name="status[{{ $siswa->id }}]" value="Alpa" class="form-radio text-red-600 focus:ring-red-500" {{ $siswa->status_absensi == 'Alpa' ? 'checked' : '' }}>
                                                <span class="ml-2">Alpa</span>
                                            </label>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <input type="text" name="keterangan[{{ $siswa->id }}]" value="{{ $siswa->keterangan_absensi }}" class="w-full rounded-md border-gray-300 focus:border-green-500 focus:ring-green-500 text-sm shadow-sm" placeholder="Keterangan (opsional)">
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-8 text-center text-gray-500">
                                        Tidak ada siswa di kelas ini.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if(count($siswas) > 0)
                <div class="p-6 bg-gray-50 border-t border-gray-100 flex justify-end">
                    <button type="submit" class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-6 rounded-lg transition-colors shadow-sm flex items-center">
                        <i class="fas fa-save mr-2"></i> Simpan Absensi
                    </button>
                </div>
                @endif
            </form>
        </div>
    @endif
</div>

@if($selectedKelasId && $selectedMapelId)
<script>
    (function () {
        const scanUrl = @json(route('guru.absensi.scan'));
        const csrf = @json(csrf_token());
        const kelasId = @json($selectedKelasId);
        const mapelId = @json($selectedMapelId);
        const tanggal = @json($selectedTanggal);

        const alertEl = document.getElementById('scanAlert');
        const qrInput = document.getElementById('qrInput');
        const scanForm = document.getElementById('scanForm');
        const startBtn = document.getElementById('startCameraBtn');
        const stopBtn = document.getElementById('stopCameraBtn');
        const readerEl = document.getElementById('qrReader');
        const cameraHint = document.getElementById('cameraHint');

        function showAlert(type, text) {
            if (!alertEl) return;
            alertEl.classList.remove('hidden', 'border-green-200', 'bg-green-50', 'text-green-700', 'border-red-200', 'bg-red-50', 'text-red-700', 'border-blue-200', 'bg-blue-50', 'text-blue-700');
            if (type === 'success') alertEl.classList.add('border-green-200', 'bg-green-50', 'text-green-700');
            else if (type === 'error') alertEl.classList.add('border-red-200', 'bg-red-50', 'text-red-700');
            else alertEl.classList.add('border-blue-200', 'bg-blue-50', 'text-blue-700');
            alertEl.textContent = text;
        }

        async function submitQr(qrValue) {
            const qr = (qrValue || '').trim();
            if (!qr) return;

            showAlert('info', 'Menyimpan absensi...');
            let res;
            try {
                res = await fetch(scanUrl, {
                    method: 'POST',
                    credentials: 'same-origin',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrf,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        kelas_id: kelasId,
                        mapel_id: mapelId,
                        tanggal: tanggal,
                        qr: qr,
                        status: 'Hadir'
                    })
                });
            } catch (_) {
                showAlert('error', 'Gagal terhubung ke server. Cek koneksi internet.');
                return;
            }

            let data = null;
            let rawText = null;
            try {
                data = await res.json();
            } catch (_) {
                try {
                    rawText = await res.text();
                } catch (_) {
                }
                data = {};
            }

            if (!res.ok) {
                if (res.status === 419) {
                    showAlert('error', 'Session habis. Refresh halaman lalu coba scan lagi.');
                    return;
                }
                if (res.status === 401) {
                    showAlert('error', 'Anda belum login. Silakan login ulang.');
                    return;
                }
                if (res.status === 403) {
                    showAlert('error', (data && data.message) ? data.message : 'Tidak punya akses untuk kelas/mapel ini.');
                    return;
                }
                if (res.status >= 500) {
                    showAlert('error', 'Server error (' + res.status + '). Coba lagi sebentar.');
                    return;
                }
                if (data && data.message) {
                    showAlert('error', data.message);
                    return;
                }
                if (rawText) {
                    showAlert('error', 'Gagal menyimpan absensi (' + res.status + ').');
                    return;
                }
                showAlert('error', 'Gagal menyimpan absensi (' + res.status + ').');
                return;
            }

            const siswaId = data?.siswa?.id;
            if (siswaId) {
                const hadir = document.querySelector('input[name="status[' + siswaId + ']"][value="Hadir"]');
                if (hadir) hadir.checked = true;
                const row = document.querySelector('tr[data-siswa-id="' + siswaId + '"]');
                if (row) {
                    row.classList.add('bg-green-50');
                    setTimeout(() => row.classList.remove('bg-green-50'), 1500);
                }
            }

            showAlert('success', 'Tersimpan: ' + (data?.siswa?.nama_lengkap || 'Siswa') + ' (' + (data?.siswa?.nisn || '-') + ') - ' + (data?.absensi?.status || 'Hadir'));
            try {
                if (navigator.vibrate) navigator.vibrate(80);
            } catch (_) {
            }
        }

        if (scanForm) {
            scanForm.addEventListener('submit', async function (e) {
                e.preventDefault();
                if (!qrInput) return;
                const val = qrInput.value;
                qrInput.value = '';
                qrInput.focus();
                await submitQr(val);
            });
        }

        if (qrInput) {
            qrInput.focus();
        }

        let scanner = null;
        let lastValue = '';
        let lastAt = 0;
        let busyUntil = 0;
        let lastScanStatusAt = 0;
        let lastScanErrorAt = 0;

        function isHttpsOrLocalhost() {
            const host = window.location.hostname;
            if (host === 'localhost' || host === '127.0.0.1') return true;
            return window.location.protocol === 'https:';
        }

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

        async function ensureHtml5Qrcode() {
            if (window.Html5Qrcode) return true;
            try {
                await loadScript(@json(route('assets.html5qrcode')));
            } catch (_) {
                try {
                    await loadScript('https://cdn.jsdelivr.net/npm/html5-qrcode@2.3.8/html5-qrcode.min.js');
                } catch (_) {
                    try {
                        await loadScript('https://unpkg.com/html5-qrcode@2.3.8/html5-qrcode.min.js');
                    } catch (_) {
                        return false;
                    }
                }
            }
            return typeof window.Html5Qrcode === 'function';
        }

        async function startCamera() {
            if (!readerEl) {
                showAlert('error', 'Preview kamera tidak tersedia.');
                return;
            }
            if (!isHttpsOrLocalhost()) {
                showAlert('error', 'Akses kamera butuh HTTPS (SSL valid). Saat ini masih “Not secure”, jadi kamera diblok. Aktifkan SSL lalu akses lewat https://');
                return;
            }
            if (!navigator.mediaDevices || !navigator.mediaDevices.getUserMedia) {
                showAlert('error', 'Akses kamera diblok oleh browser (biasanya karena belum HTTPS). Gunakan input manual atau aktifkan SSL.');
                return;
            }

            const ok = await ensureHtml5Qrcode();
            if (!ok) {
                const isWhatsApp = /WhatsApp/i.test(navigator.userAgent || '');
                if (isWhatsApp) {
                    showAlert('error', 'Scanner tidak bisa dimuat di browser WhatsApp. Buka link ini di Safari/Chrome (Open in browser), lalu coba lagi.');
                } else {
                    showAlert('error', 'Library scanner tidak berhasil dimuat. Gunakan input manual.');
                }
                return;
            }

            if (scanner) {
                await stopCamera();
            }

            scanner = new window.Html5Qrcode(readerEl.id);

            startBtn.classList.add('hidden');
            stopBtn.classList.remove('hidden');
            if (cameraHint) cameraHint.textContent = 'Arahkan kamera ke QR siswa.';
            showAlert('info', 'Kamera aktif. Arahkan ke QR siswa.');

            try {
                await scanner.start(
                    { facingMode: 'environment' },
                    {
                        fps: 15,
                        qrbox: function (viewfinderWidth, viewfinderHeight) {
                            const minEdge = Math.min(viewfinderWidth, viewfinderHeight);
                            const size = Math.max(220, Math.floor(minEdge * 0.85));
                            return { width: size, height: size };
                        }
                    },
                    async function (decodedText) {
                        const raw = (decodedText || '').trim();
                        const now = Date.now();
                        if (!raw) return;
                        if (raw === lastValue && now - lastAt <= 1500) return;
                        if (now < busyUntil) return;
                        lastValue = raw;
                        lastAt = now;
                        busyUntil = now + 1500;
                        if (qrInput) qrInput.value = raw;
                        showAlert('info', 'QR terdeteksi. Menyimpan absensi...');
                        await submitQr(raw);
                        if (qrInput) qrInput.value = '';
                    },
                    function () {
                        const now = Date.now();
                        if (!cameraHint) return;
                        if (now - lastScanStatusAt >= 2000) {
                            lastScanStatusAt = now;
                            cameraHint.textContent = 'Sedang mencari QR... dekatkan QR dan pastikan terang & fokus.';
                        }
                    }
                );
            } catch (_) {
                showAlert('error', 'Tidak bisa mengakses kamera. Gunakan input manual.');
                startBtn.classList.remove('hidden');
                stopBtn.classList.add('hidden');
                scanner = null;
            }
        }

        async function stopCamera() {
            if (scanner) {
                try {
                    await scanner.stop();
                } catch (_) {
                }
                try {
                    scanner.clear();
                } catch (_) {
                }
                scanner = null;
            }
            startBtn.classList.remove('hidden');
            stopBtn.classList.add('hidden');
            if (cameraHint) cameraHint.textContent = 'Gunakan input manual jika kamera tidak tersedia.';
            showAlert('info', 'Kamera berhenti.');
        }

        if (startBtn) startBtn.addEventListener('click', startCamera);
        if (stopBtn) stopBtn.addEventListener('click', stopCamera);
    })();
</script>
@endif
@endsection
