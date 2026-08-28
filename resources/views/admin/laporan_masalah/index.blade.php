@extends('layouts.admin')

@section('title', 'Laporan Masalah')
@section('header', 'Laporan Masalah')

@section('content')
    <div class="card-modern overflow-hidden">
        <form action="{{ route('admin.laporan-masalah.index') }}" method="GET" class="p-6 border-b border-slate-100 bg-slate-50/50">
            <div class="flex flex-col lg:flex-row gap-4">
                <div class="relative flex-1">
                    <i class="fas fa-search absolute left-4 top-1/2 -translate-y-1/2 text-slate-400"></i>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari subject, nama pelapor, email..." class="w-full pl-12 pr-4 py-3 bg-white border border-slate-200 rounded-xl focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 transition-all outline-none text-sm font-medium">
                </div>
                <div class="flex flex-col sm:flex-row gap-3">
                    <select name="status" onchange="this.form.submit()" class="border border-slate-200 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 bg-white font-medium">
                        <option value="">Semua Status</option>
                        <option value="open" {{ request('status') == 'open' ? 'selected' : '' }}>Open</option>
                        <option value="in_progress" {{ request('status') == 'in_progress' ? 'selected' : '' }}>In Progress</option>
                        <option value="resolved" {{ request('status') == 'resolved' ? 'selected' : '' }}>Resolved</option>
                        <option value="closed" {{ request('status') == 'closed' ? 'selected' : '' }}>Closed</option>
                    </select>
                    <select name="kategori" onchange="this.form.submit()" class="border border-slate-200 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 bg-white font-medium">
                        <option value="">Semua Kategori</option>
                        <option value="bug" {{ request('kategori') == 'bug' ? 'selected' : '' }}>Bug</option>
                        <option value="saran" {{ request('kategori') == 'saran' ? 'selected' : '' }}>Saran</option>
                        <option value="akses" {{ request('kategori') == 'akses' ? 'selected' : '' }}>Akses</option>
                        <option value="akademik" {{ request('kategori') == 'akademik' ? 'selected' : '' }}>Akademik</option>
                        <option value="lainnya" {{ request('kategori') == 'lainnya' ? 'selected' : '' }}>Lainnya</option>
                    </select>
                    <button type="submit" class="bg-emerald-600 hover:bg-emerald-700 text-white px-6 py-3 rounded-xl text-sm font-bold transition-colors shadow-lg shadow-emerald-500/20">
                        <i class="fas fa-filter mr-2"></i>Filter
                    </button>
                </div>
            </div>
        </form>

        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead>
                    <tr class="bg-slate-50 text-slate-600 text-xs uppercase tracking-wider">
                        <th class="px-6 py-4 font-bold">No</th>
                        <th class="px-6 py-4 font-bold">Tanggal</th>
                        <th class="px-6 py-4 font-bold">Nama Pelapor</th>
                        <th class="px-6 py-4 font-bold">Email</th>
                        <th class="px-6 py-4 font-bold">Kategori</th>
                        <th class="px-6 py-4 font-bold">Subject</th>
                        <th class="px-6 py-4 font-bold">Status</th>
                        <th class="px-6 py-4 font-bold">Admin Penanggap</th>
                        <th class="px-6 py-4 font-bold text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-sm">
                    @forelse($laporans as $index => $laporan)
                    <tr class="hover:bg-slate-50/70 transition-colors">
                        <td class="px-6 py-4 text-slate-600 font-bold">{{ $loop->iteration + ($laporans->currentPage() - 1) * $laporans->perPage() }}</td>
                        <td class="px-6 py-4 text-slate-600">{{ $laporan->created_at->format('d M Y') }}</td>
                        <td class="px-6 py-4">
                            <div class="font-bold text-slate-800">{{ $laporan->nama_pelapor }}</div>
                        </td>
                        <td class="px-6 py-4 text-slate-600">{{ $laporan->email_pelapor }}</td>
                        <td class="px-6 py-4">
                            @php
                                $kategoriBadge = match($laporan->kategori) {
                                    'bug' => ['bg-red-100', 'text-red-700', 'Bug'],
                                    'saran' => ['bg-blue-100', 'text-blue-700', 'Saran'],
                                    'akses' => ['bg-amber-100', 'text-amber-700', 'Akses'],
                                    'akademik' => ['bg-emerald-100', 'text-emerald-700', 'Akademik'],
                                    default => ['bg-slate-100', 'text-slate-700', 'Lainnya'],
                                };
                            @endphp
                            <span class="inline-flex items-center px-3 py-1 rounded-lg text-xs font-bold {{ $kategoriBadge[0] }} {{ $kategoriBadge[1] }}">
                                {{ $kategoriBadge[2] }}
                            </span>
                        </td>
                        <td class="px-6 py-4 max-w-xs">
                            <div class="font-semibold text-slate-800">{{ $laporan->subject }}</div>
                            <div class="text-xs text-slate-500 mt-1 truncate" title="{{ $laporan->deskripsi }}">
                                {{ \Illuminate\Support\Str::limit($laporan->deskripsi, 80) }}
                            </div>
                            @if($laporan->file_pendukung)
                                <a href="{{ asset('storage/' . $laporan->file_pendukung) }}" target="_blank" class="inline-flex items-center mt-2 text-xs text-emerald-600 hover:text-emerald-700 font-medium">
                                    <i class="fas fa-paperclip mr-1"></i>File pendukung
                                </a>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            @php
                                $statusBadge = match($laporan->status) {
                                    'open' => ['bg-red-100', 'text-red-700', 'Open'],
                                    'in_progress' => ['bg-amber-100', 'text-amber-700', 'In Progress'],
                                    'resolved' => ['bg-emerald-100', 'text-emerald-700', 'Resolved'],
                                    'closed' => ['bg-slate-100', 'text-slate-700', 'Closed'],
                                    default => ['bg-slate-100', 'text-slate-700', ucfirst($laporan->status)],
                                };
                            @endphp
                            <span class="inline-flex items-center px-3 py-1 rounded-lg text-xs font-bold {{ $statusBadge[0] }} {{ $statusBadge[1] }}">
                                {{ $statusBadge[2] }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            @if($laporan->admin)
                                <div class="flex items-center">
                                    <img src="https://ui-avatars.com/api/?name={{ urlencode($laporan->admin->name) }}&background=059669&color=fff" class="w-8 h-8 rounded-lg mr-2" alt="">
                                    <span class="text-slate-700 font-medium text-xs">{{ $laporan->admin->name }}</span>
                                </div>
                            @else
                                <span class="text-slate-400 text-xs">-</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-center">
                            <div class="flex items-center justify-center gap-2">
                                <button type="button" onclick="openDetailModal({{ json_encode($laporan) }})" class="inline-flex items-center px-3 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-lg text-xs font-bold transition-all">
                                    <i class="fas fa-eye mr-1.5"></i>Lihat
                                </button>
                                <button type="button" onclick="openResponModal({{ $laporan->id }}, {{ json_encode($laporan->status) }}, {{ json_encode($laporan->respon_admin) }})" class="inline-flex items-center px-3 py-2 bg-emerald-600 hover:bg-emerald-700 text-white rounded-lg text-xs font-bold transition-all shadow-sm">
                                    <i class="fas fa-reply mr-1.5"></i>Respon
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="9" class="px-6 py-16 text-center">
                            <div class="flex flex-col items-center">
                                <div class="w-20 h-20 rounded-3xl bg-slate-100 flex items-center justify-center mb-4">
                                    <i class="fas fa-headset text-slate-400 text-3xl"></i>
                                </div>
                                <p class="text-slate-500 font-semibold">Tidak ada laporan masalah</p>
                                <p class="text-xs text-slate-400 mt-1">Coba ubah filter atau pencarian</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="p-6 border-t border-slate-100">
            {{ $laporans->appends(request()->query())->links('pagination.number-123') }}
        </div>
    </div>

    <div id="detailModal" class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm z-50 hidden items-center justify-center p-4">
        <div class="bg-white rounded-3xl shadow-2xl w-full max-w-2xl max-h-[90vh] overflow-y-auto">
            <div class="p-6 border-b border-slate-100 sticky top-0 bg-white z-10">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="w-12 h-12 rounded-2xl bg-blue-100 flex items-center justify-center">
                            <i class="fas fa-file-alt text-blue-600 text-xl"></i>
                        </div>
                        <div>
                            <h3 class="text-lg font-bold text-slate-800" id="detailSubject">-</h3>
                            <p class="text-xs text-slate-500" id="detailMeta">-</p>
                        </div>
                    </div>
                    <button onclick="closeDetailModal()" class="text-slate-400 hover:text-slate-600 p-2 rounded-xl hover:bg-slate-100 transition-all">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>
            <div class="p-6 space-y-5">
                <div class="grid grid-cols-2 gap-4">
                    <div class="p-4 bg-slate-50 rounded-2xl">
                        <p class="text-xs font-bold text-slate-500 uppercase mb-1">Nama Pelapor</p>
                        <p class="font-bold text-slate-800" id="detailNama">-</p>
                    </div>
                    <div class="p-4 bg-slate-50 rounded-2xl">
                        <p class="text-xs font-bold text-slate-500 uppercase mb-1">Email</p>
                        <p class="font-semibold text-slate-700" id="detailEmail">-</p>
                    </div>
                </div>
                <div>
                    <p class="text-xs font-bold text-slate-500 uppercase mb-2">Deskripsi</p>
                    <div class="p-4 bg-slate-50 rounded-2xl text-sm text-slate-700 whitespace-pre-line" id="detailDeskripsi">-</div>
                </div>
                <div id="detailFileWrap" class="hidden">
                    <p class="text-xs font-bold text-slate-500 uppercase mb-2">File Pendukung</p>
                    <a id="detailFileLink" href="#" target="_blank" class="inline-flex items-center gap-2 px-4 py-3 bg-emerald-50 hover:bg-emerald-100 text-emerald-700 rounded-2xl font-bold text-sm transition-colors">
                        <i class="fas fa-download"></i>
                        <span>Download File</span>
                    </a>
                </div>
                <div id="detailResponWrap" class="hidden">
                    <p class="text-xs font-bold text-slate-500 uppercase mb-2">Respon Admin</p>
                    <div class="p-4 bg-emerald-50 rounded-2xl border border-emerald-100 text-sm text-slate-700 whitespace-pre-line" id="detailRespon">-</div>
                </div>
            </div>
        </div>
    </div>

    <div id="responModal" class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm z-50 hidden items-center justify-center p-4">
        <div class="bg-white rounded-3xl shadow-2xl w-full max-w-lg">
            <div class="p-6 border-b border-slate-100">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="w-12 h-12 rounded-2xl bg-emerald-100 flex items-center justify-center">
                            <i class="fas fa-reply text-emerald-600 text-xl"></i>
                        </div>
                        <div>
                            <h3 class="text-lg font-bold text-slate-800">Tanggapi Laporan</h3>
                            <p class="text-xs text-slate-500">Update status dan berikan respon</p>
                        </div>
                    </div>
                    <button onclick="closeResponModal()" class="text-slate-400 hover:text-slate-600 p-2 rounded-xl hover:bg-slate-100 transition-all">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>
            <form id="responForm" method="POST">
                @csrf
                <div class="p-6 space-y-5">
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">Status</label>
                        <select name="status" id="responStatus" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 transition-all outline-none text-sm font-medium">
                            <option value="open">Open</option>
                            <option value="in_progress">In Progress</option>
                            <option value="resolved">Resolved</option>
                            <option value="closed">Closed</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">Respon Admin</label>
                        <textarea name="respon_admin" id="responText" rows="5" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 transition-all outline-none text-sm font-medium resize-none" placeholder="Tuliskan respon Anda terhadap laporan ini..."></textarea>
                    </div>
                </div>
                <div class="p-6 pt-0 flex gap-3">
                    <button type="button" onclick="closeResponModal()" class="flex-1 px-4 py-3 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-xl font-bold text-sm transition-colors">
                        Batal
                    </button>
                    <button type="submit" class="flex-1 px-4 py-3 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl font-bold text-sm transition-colors shadow-lg shadow-emerald-500/20">
                        <i class="fas fa-paper-plane mr-2"></i>Kirim Respon
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function openDetailModal(laporan) {
            document.getElementById('detailSubject').textContent = laporan.subject;
            document.getElementById('detailMeta').textContent = new Date(laporan.created_at).toLocaleDateString('id-ID', { day: 'numeric', month: 'long', year: 'numeric' });
            document.getElementById('detailNama').textContent = laporan.nama_pelapor;
            document.getElementById('detailEmail').textContent = laporan.email_pelapor;
            document.getElementById('detailDeskripsi').textContent = laporan.deskripsi;
            const fileWrap = document.getElementById('detailFileWrap');
            const fileLink = document.getElementById('detailFileLink');
            if (laporan.file_pendukung) {
                fileWrap.classList.remove('hidden');
                fileLink.href = '/storage/' + laporan.file_pendukung;
            } else {
                fileWrap.classList.add('hidden');
            }
            const responWrap = document.getElementById('detailResponWrap');
            const responText = document.getElementById('detailRespon');
            if (laporan.respon_admin) {
                responWrap.classList.remove('hidden');
                responText.textContent = laporan.respon_admin;
            } else {
                responWrap.classList.add('hidden');
            }
            const modal = document.getElementById('detailModal');
            modal.classList.remove('hidden');
            modal.classList.add('flex');
            document.body.style.overflow = 'hidden';
        }
        function closeDetailModal() {
            const modal = document.getElementById('detailModal');
            modal.classList.add('hidden');
            modal.classList.remove('flex');
            document.body.style.overflow = '';
        }
        function openResponModal(id, status, respon) {
            const form = document.getElementById('responForm');
            const url = "{{ route('admin.laporan-masalah.respon', ':id') }}";
            form.action = url.replace(':id', id);
            document.getElementById('responStatus').value = status || 'open';
            document.getElementById('responText').value = respon || '';
            const modal = document.getElementById('responModal');
            modal.classList.remove('hidden');
            modal.classList.add('flex');
            document.body.style.overflow = 'hidden';
        }
        function closeResponModal() {
            const modal = document.getElementById('responModal');
            modal.classList.add('hidden');
            modal.classList.remove('flex');
            document.body.style.overflow = '';
        }
        document.getElementById('detailModal').addEventListener('click', function(e) { if (e.target === this) closeDetailModal(); });
        document.getElementById('responModal').addEventListener('click', function(e) { if (e.target === this) closeResponModal(); });
    </script>
@endsection
