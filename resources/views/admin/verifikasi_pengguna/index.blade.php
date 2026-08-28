@extends('layouts.admin')

@section('title', 'Verifikasi Pengguna')
@section('header', 'Verifikasi Pengguna')

@section('content')
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="card-modern p-6 border-l-4 border-emerald-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Pengguna Aktif</p>
                    <p class="text-3xl font-bold text-slate-800">{{ $activeCount ?? 0 }}</p>
                </div>
                <div class="w-14 h-14 rounded-2xl bg-emerald-100 flex items-center justify-center">
                    <i class="fas fa-user-check text-emerald-600 text-xl"></i>
                </div>
            </div>
        </div>
        <div class="card-modern p-6 border-l-4 border-amber-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Menunggu Verifikasi</p>
                    <p class="text-3xl font-bold text-slate-800">{{ $pendingCount ?? 0 }}</p>
                </div>
                <div class="w-14 h-14 rounded-2xl bg-amber-100 flex items-center justify-center">
                    <i class="fas fa-user-clock text-amber-600 text-xl"></i>
                </div>
            </div>
        </div>
        <div class="card-modern p-6 border-l-4 border-red-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Ditolak</p>
                    <p class="text-3xl font-bold text-slate-800">{{ $rejectedCount ?? 0 }}</p>
                </div>
                <div class="w-14 h-14 rounded-2xl bg-red-100 flex items-center justify-center">
                    <i class="fas fa-user-times text-red-600 text-xl"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="card-modern overflow-hidden">
        <form action="{{ route('admin.verifikasi-pengguna.index') }}" method="GET" class="p-6 border-b border-slate-100 bg-slate-50/50">
            <div class="flex flex-col lg:flex-row gap-4">
                <div class="relative flex-1">
                    <i class="fas fa-search absolute left-4 top-1/2 -translate-y-1/2 text-slate-400"></i>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama, username, email..." class="w-full pl-12 pr-4 py-3 bg-white border border-slate-200 rounded-xl focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 transition-all outline-none text-sm font-medium">
                </div>
                <div class="flex flex-col sm:flex-row gap-3">
                    <select name="status" onchange="this.form.submit()" class="border border-slate-200 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 bg-white font-medium">
                        <option value="">Semua Status</option>
                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Rejected</option>
                        <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                    </select>
                    <select name="role" onchange="this.form.submit()" class="border border-slate-200 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 bg-white font-medium">
                        <option value="">Semua Role</option>
                        <option value="guru" {{ request('role') == 'guru' ? 'selected' : '' }}>Guru</option>
                        <option value="siswa" {{ request('role') == 'siswa' ? 'selected' : '' }}>Siswa</option>
                        <option value="kepala_sekolah" {{ request('role') == 'kepala_sekolah' ? 'selected' : '' }}>Kepala Sekolah</option>
                        <option value="tendik" {{ request('role') == 'tendik' ? 'selected' : '' }}>Tendik</option>
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
                        <th class="px-6 py-4 font-bold">Nama</th>
                        <th class="px-6 py-4 font-bold">Username</th>
                        <th class="px-6 py-4 font-bold">Email</th>
                        <th class="px-6 py-4 font-bold">Role</th>
                        <th class="px-6 py-4 font-bold">Detail</th>
                        <th class="px-6 py-4 font-bold">Status</th>
                        <th class="px-6 py-4 font-bold">Tanggal Daftar</th>
                        <th class="px-6 py-4 font-bold text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-sm">
                    @forelse($users as $user)
                    <tr class="hover:bg-slate-50/70 transition-colors">
                        <td class="px-6 py-4">
                            <div class="flex items-center">
                                <img src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background=059669&color=fff" class="w-10 h-10 rounded-xl mr-3 shadow-sm" alt="Avatar">
                                <div>
                                    <div class="font-bold text-slate-800">{{ $user->name }}</div>
                                    <div class="text-xs text-slate-500">
                                        @if($user->guru && !empty($user->guru->no_hp))
                                            HP: {{ $user->guru->no_hp }}
                                        @elseif($user->siswa && !empty($user->siswa->no_hp_ortu))
                                            HP Ortu: {{ $user->siswa->no_hp_ortu }}
                                        @elseif(!empty($user->email))
                                            {{ $user->email }}
                                        @else
                                            <span class="text-slate-300">—</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-slate-600 font-medium">{{ $user->username }}</td>
                        <td class="px-6 py-4 text-slate-600">
                            @if(!empty($user->email))
                                {{ $user->email }}
                            @else
                                <span class="inline-flex items-center px-2 py-1 rounded-md text-[10px] font-bold bg-slate-100 text-slate-500">Tidak ada email</span>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            @php
                                $roleBadge = match($user->role) {
                                    'guru' => ['bg-blue-100', 'text-blue-700', 'Guru'],
                                    'siswa' => ['bg-purple-100', 'text-purple-700', 'Siswa'],
                                    'kepala_sekolah' => ['bg-amber-100', 'text-amber-700', 'Kepala Sekolah'],
                                    'tendik' => ['bg-cyan-100', 'text-cyan-700', 'Tendik'],
                                    default => ['bg-slate-100', 'text-slate-700', ucfirst($user->role)],
                                };
                            @endphp
                            <span class="inline-flex items-center px-3 py-1 rounded-lg text-xs font-bold {{ $roleBadge[0] }} {{ $roleBadge[1] }}">
                                {{ $roleBadge[2] }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-slate-600">
                            @if($user->role === 'siswa' && $user->siswa)
                                @if($user->siswa->kelas)
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-bold bg-purple-50 text-purple-700 border border-purple-100">
                                        <i class="fas fa-door-open text-[10px] mr-1.5"></i>{{ $user->siswa->kelas->nama_kelas }}
                                    </span>
                                @else
                                    <span class="text-xs text-amber-600 font-medium"><i class="fas fa-exclamation-triangle mr-1 text-[10px]"></i>Kelas belum diatur</span>
                                @endif
                            @elseif($user->role === 'guru' && $user->guru)
                                @if(!empty($user->guru->mapel_id) && isset($user->guru->mapel_id))
                                    @php
                                        $mapelGuru = \App\Models\Mapel::find($user->guru->mapel_id);
                                    @endphp
                                    @if($mapelGuru)
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-bold bg-blue-50 text-blue-700 border border-blue-100">
                                            <i class="fas fa-book text-[10px] mr-1.5"></i>{{ $mapelGuru->nama_mapel }}
                                        </span>
                                    @else
                                        <span class="text-xs text-slate-400">Mapel belum diatur</span>
                                    @endif
                                @else
                                    <span class="text-xs text-slate-400">Mapel opsional</span>
                                @endif
                            @elseif($user->role === 'kepala_sekolah')
                                <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-bold bg-amber-50 text-amber-700 border border-amber-100">
                                    <i class="fas fa-school text-[10px] mr-1.5"></i>Pimpinan Sekolah
                                </span>
                            @else
                                <span class="text-xs text-slate-400">—</span>
                            @endif
                            @if($user->role === 'siswa' && $user->siswa && !empty($user->siswa->jenis_kelamin))
                                <div class="text-[10px] mt-1 text-slate-400 font-medium">
                                    JK: {{ $user->siswa->jenis_kelamin === 'L' ? 'Laki-laki' : 'Perempuan' }}
                                </div>
                            @elseif($user->role === 'guru' && $user->guru && !empty($user->guru->jenis_kelamin))
                                <div class="text-[10px] mt-1 text-slate-400 font-medium">
                                    JK: {{ $user->guru->jenis_kelamin === 'L' ? 'Laki-laki' : 'Perempuan' }}
                                </div>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            @php
                                $statusBadge = match($user->status) {
                                    'pending' => ['bg-amber-100', 'text-amber-700', 'Pending'],
                                    'active' => ['bg-emerald-100', 'text-emerald-700', 'Active'],
                                    'rejected' => ['bg-red-100', 'text-red-700', 'Rejected'],
                                    'inactive' => ['bg-slate-100', 'text-slate-700', 'Inactive'],
                                    default => ['bg-slate-100', 'text-slate-700', ucfirst($user->status)],
                                };
                            @endphp
                            <span class="inline-flex items-center px-3 py-1 rounded-lg text-xs font-bold {{ $statusBadge[0] }} {{ $statusBadge[1] }}">
                                <span class="w-2 h-2 rounded-full mr-2 bg-current" style="opacity: 0.7;"></span>
                                {{ $statusBadge[2] }}
                            </span>
                            @if($user->status === 'rejected' && !empty($user->rejection_note))
                                <div class="mt-1.5 text-[10px] text-red-600 font-medium max-w-[180px] truncate" title="{{ $user->rejection_note }}">
                                    <i class="fas fa-comment-slash mr-1"></i>{{ $user->rejection_note }}
                                </div>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-slate-600">{{ $user->created_at->format('d M Y') }}</td>
                        <td class="px-6 py-4">
                            <div class="flex items-center justify-center gap-2 flex-wrap">
                                @if($user->status == 'pending')
                                    <form action="{{ route('admin.verifikasi-pengguna.approve', $user->id) }}" method="POST" class="inline" onsubmit="return confirm('Yakin menyetujui pengguna {{ $user->name }}?')">
                                        @csrf
                                        <button type="submit" class="inline-flex items-center px-3 py-2 bg-emerald-600 hover:bg-emerald-700 text-white rounded-lg text-xs font-bold transition-all shadow-sm hover:shadow-md" title="Setujui akun">
                                            <i class="fas fa-check mr-1.5"></i>Approve
                                        </button>
                                    </form>
                                    <button type="button" onclick="openRejectModal({{ $user->id }})" class="inline-flex items-center px-3 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg text-xs font-bold transition-all shadow-sm hover:shadow-md" title="Tolak akun">
                                        <i class="fas fa-times mr-1.5"></i>Reject
                                    </button>
                                @elseif($user->status == 'rejected')
                                    <form action="{{ route('admin.verifikasi-pengguna.approve', $user->id) }}" method="POST" class="inline" onsubmit="return confirm('Pengguna ini sebelumnya ditolak. Yakin ingin menyetujuinya sekarang?')">
                                        @csrf
                                        <button type="submit" class="inline-flex items-center px-3 py-2 bg-emerald-600 hover:bg-emerald-700 text-white rounded-lg text-xs font-bold transition-all shadow-sm hover:shadow-md" title="Terima setelah ditolak">
                                            <i class="fas fa-undo mr-1.5"></i>Approve Ulang
                                        </button>
                                    </form>
                                @elseif($user->status == 'active')
                                    <form action="{{ route('admin.verifikasi-pengguna.deactivate', $user->id) }}" method="POST" class="inline" onsubmit="return confirm('Yakin ingin menonaktifkan pengguna {{ $user->name }}?')">
                                        @csrf
                                        <button type="submit" class="inline-flex items-center px-3 py-2 bg-orange-500 hover:bg-orange-600 text-white rounded-lg text-xs font-bold transition-all shadow-sm hover:shadow-md" title="Nonaktifkan akun">
                                            <i class="fas fa-ban mr-1.5"></i>Deactivate
                                        </button>
                                    </form>
                                @elseif($user->status == 'inactive')
                                    <form action="{{ route('admin.verifikasi-pengguna.approve', $user->id) }}" method="POST" class="inline" onsubmit="return confirm('Yakin mengaktifkan kembali pengguna {{ $user->name }}?')">
                                        @csrf
                                        <button type="submit" class="inline-flex items-center px-3 py-2 bg-emerald-600 hover:bg-emerald-700 text-white rounded-lg text-xs font-bold transition-all shadow-sm hover:shadow-md" title="Aktifkan kembali">
                                            <i class="fas fa-user-check mr-1.5"></i>Aktifkan
                                        </button>
                                    </form>
                                @endif

                                <button type="button" onclick="openResetModal({{ $user->id }}, '{{ addslashes($user->name) }}')" class="inline-flex items-center px-3 py-2 bg-indigo-500 hover:bg-indigo-600 text-white rounded-lg text-xs font-bold transition-all shadow-sm hover:shadow-md" title="Reset password pengguna">
                                    <i class="fas fa-key mr-1.5"></i>Reset PW
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="px-6 py-16 text-center">
                            <div class="flex flex-col items-center">
                                <div class="w-20 h-20 rounded-3xl bg-slate-100 flex items-center justify-center mb-4">
                                    <i class="fas fa-inbox text-slate-400 text-3xl"></i>
                                </div>
                                <p class="text-slate-500 font-semibold">Tidak ada data pengguna</p>
                                <p class="text-xs text-slate-400 mt-1">Coba ubah filter atau pencarian</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="p-6 border-t border-slate-100">
            {{ $users->appends(request()->query())->links('pagination.number-123') }}
        </div>
    </div>

    <div id="rejectModal" class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm z-50 hidden items-center justify-center p-4">
        <div class="bg-white rounded-3xl shadow-2xl w-full max-w-md transform transition-all">
            <div class="p-6 border-b border-slate-100">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="w-12 h-12 rounded-2xl bg-red-100 flex items-center justify-center">
                            <i class="fas fa-times-circle text-red-600 text-xl"></i>
                        </div>
                        <div>
                            <h3 class="text-lg font-bold text-slate-800">Tolak Pengguna</h3>
                            <p class="text-xs text-slate-500">Berikan alasan penolakan</p>
                        </div>
                    </div>
                    <button onclick="closeRejectModal()" class="text-slate-400 hover:text-slate-600 p-2 rounded-xl hover:bg-slate-100 transition-all">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>
            <form id="rejectForm" method="POST">
                @csrf
                <div class="p-6">
                    <label class="block text-sm font-bold text-slate-700 mb-2">Alasan Penolakan <span class="text-red-500">*</span></label>
                    <textarea name="rejection_note" rows="4" required class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-red-500/20 focus:border-red-500 transition-all outline-none text-sm font-medium resize-none" placeholder="Masukkan alasan mengapa pengguna ini ditolak..."></textarea>
                </div>
                <div class="p-6 pt-0 flex gap-3">
                    <button type="button" onclick="closeRejectModal()" class="flex-1 px-4 py-3 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-xl font-bold text-sm transition-colors">
                        Batal
                    </button>
                    <button type="submit" class="flex-1 px-4 py-3 bg-red-600 hover:bg-red-700 text-white rounded-xl font-bold text-sm transition-colors shadow-lg shadow-red-500/20">
                        <i class="fas fa-times mr-2"></i>Konfirmasi Tolak
                    </button>
                </div>
            </form>
        </div>
    </div>

    <div id="resetModal" class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm z-50 hidden items-center justify-center p-4">
        <div class="bg-white rounded-3xl shadow-2xl w-full max-w-md transform transition-all">
            <div class="p-6 border-b border-slate-100">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="w-12 h-12 rounded-2xl bg-indigo-100 flex items-center justify-center">
                            <i class="fas fa-key text-indigo-600 text-xl"></i>
                        </div>
                        <div>
                            <h3 class="text-lg font-bold text-slate-800">Reset Password</h3>
                            <p class="text-xs text-slate-500" id="resetModalSubtitle">Atur password baru untuk pengguna</p>
                        </div>
                    </div>
                    <button onclick="closeResetModal()" class="text-slate-400 hover:text-slate-600 p-2 rounded-xl hover:bg-slate-100 transition-all">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>
            <form id="resetForm" method="POST">
                @csrf
                <div class="p-6 space-y-4">
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">Password Baru <span class="text-red-500">*</span></label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <i class="fas fa-lock text-slate-400"></i>
                            </div>
                            <input type="password" id="reset_password" name="password" minlength="6" required class="w-full pl-11 pr-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all outline-none text-sm font-medium" placeholder="Min. 6 karakter">
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">Konfirmasi Password <span class="text-red-500">*</span></label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <i class="fas fa-lock text-slate-400"></i>
                            </div>
                            <input type="password" id="reset_password_confirmation" name="password_confirmation" minlength="6" required class="w-full pl-11 pr-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all outline-none text-sm font-medium" placeholder="Ulangi password baru">
                        </div>
                    </div>
                </div>
                <div class="p-6 pt-0 flex gap-3">
                    <button type="button" onclick="closeResetModal()" class="flex-1 px-4 py-3 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-xl font-bold text-sm transition-colors">
                        Batal
                    </button>
                    <button type="submit" class="flex-1 px-4 py-3 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl font-bold text-sm transition-colors shadow-lg shadow-indigo-500/20">
                        <i class="fas fa-key mr-2"></i>Simpan Password Baru
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function openRejectModal(userId) {
            const modal = document.getElementById('rejectModal');
            const form = document.getElementById('rejectForm');
            const url = "{{ route('admin.verifikasi-pengguna.reject', ':id') }}";
            form.action = url.replace(':id', userId);
            form.querySelector('textarea[name="rejection_note"]').value = '';
            modal.classList.remove('hidden');
            modal.classList.add('flex');
            document.body.style.overflow = 'hidden';
        }
        function closeRejectModal() {
            const modal = document.getElementById('rejectModal');
            modal.classList.add('hidden');
            modal.classList.remove('flex');
            document.body.style.overflow = '';
        }
        document.getElementById('rejectModal').addEventListener('click', function(e) {
            if (e.target === this) closeRejectModal();
        });

        function openResetModal(userId, userName) {
            const modal = document.getElementById('resetModal');
            const form = document.getElementById('resetForm');
            const url = "{{ route('admin.verifikasi-pengguna.reset-password', ':id') }}";
            form.action = url.replace(':id', userId);
            document.getElementById('resetModalSubtitle').textContent = userName ? 'Atur password baru untuk ' + userName : 'Atur password baru untuk pengguna';
            document.getElementById('reset_password').value = '';
            document.getElementById('reset_password_confirmation').value = '';
            modal.classList.remove('hidden');
            modal.classList.add('flex');
            document.body.style.overflow = 'hidden';
        }
        function closeResetModal() {
            const modal = document.getElementById('resetModal');
            modal.classList.add('hidden');
            modal.classList.remove('flex');
            document.body.style.overflow = '';
        }
        document.getElementById('resetModal').addEventListener('click', function(e) {
            if (e.target === this) closeResetModal();
        });
    </script>
@endsection
