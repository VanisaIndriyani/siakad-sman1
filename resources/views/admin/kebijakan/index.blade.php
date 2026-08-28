@extends('layouts.admin')

@section('title', 'Kelola Kebijakan')
@section('header', 'Kelola Kebijakan')

@section('content')
    <div class="space-y-6">
        <div class="card-modern overflow-hidden">
            <div class="p-6 border-b border-slate-100">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                    <div class="flex items-center gap-3">
                        <div class="w-11 h-11 rounded-2xl bg-blue-100 flex items-center justify-center">
                            <i class="fas fa-file-contract text-blue-600"></i>
                        </div>
                        <div>
                            <h3 class="font-bold text-slate-800">Daftar Kebijakan</h3>
                            <p class="text-xs text-slate-500">Total {{ $kebijakans->total() }} kebijakan tersimpan</p>
                        </div>
                    </div>
                    <button type="button" onclick="openCreateKebijakan()" class="inline-flex items-center px-5 py-3 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl font-bold text-sm transition-all shadow-lg shadow-emerald-500/20">
                        <i class="fas fa-plus mr-2"></i>Tambah Kebijakan Baru
                    </button>
                </div>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead>
                        <tr class="bg-slate-50 text-slate-600 text-xs uppercase tracking-wider">
                            <th class="px-6 py-4 font-bold">No</th>
                            <th class="px-6 py-4 font-bold">Judul</th>
                            <th class="px-6 py-4 font-bold">Slug</th>
                            <th class="px-6 py-4 font-bold">For Role</th>
                            <th class="px-6 py-4 font-bold">Status</th>
                            <th class="px-6 py-4 font-bold">Updated At</th>
                            <th class="px-6 py-4 font-bold text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-sm">
                        @forelse($kebijakans as $kb)
                        <tr class="hover:bg-slate-50/70 transition-colors">
                            <td class="px-6 py-4 text-slate-500 font-bold">{{ $loop->iteration + ($kebijakans->currentPage() - 1) * $kebijakans->perPage() }}</td>
                            <td class="px-6 py-4 max-w-xs">
                                <div class="font-bold text-slate-800 line-clamp-2">{{ $kb->title }}</div>
                            </td>
                            <td class="px-6 py-4">
                                <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-mono font-bold bg-slate-100 text-slate-700">{{ $kb->slug }}</span>
                            </td>
                            <td class="px-6 py-4">
                                @php
                                    $roleBadge = match($kb->for_role) {
                                        'admin' => ['bg-red-100', 'text-red-700', 'Admin'],
                                        'guru' => ['bg-blue-100', 'text-blue-700', 'Guru'],
                                        'siswa' => ['bg-purple-100', 'text-purple-700', 'Siswa'],
                                        'kepala_sekolah' => ['bg-amber-100', 'text-amber-700', 'Kepala Sekolah'],
                                        'tendik' => ['bg-cyan-100', 'text-cyan-700', 'Tendik'],
                                        default => ['bg-slate-100', 'text-slate-700', 'Semua'],
                                    };
                                @endphp
                                <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-bold {{ $roleBadge[0] }} {{ $roleBadge[1] }}">{{ $roleBadge[2] }}</span>
                            </td>
                            <td class="px-6 py-4">
                                @if($kb->is_active)
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-bold bg-emerald-100 text-emerald-700">Active</span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-bold bg-slate-100 text-slate-700">Inactive</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-slate-600 text-xs">{{ $kb->updated_at->format('d M Y') }}</td>
                            <td class="px-6 py-4 text-center">
                                <div class="flex items-center justify-center gap-2">
                                    <button type="button" onclick='openEditKebijakan(@json($kb))' class="inline-flex items-center px-3 py-2 bg-blue-100 hover:bg-blue-200 text-blue-700 rounded-lg text-xs font-bold transition-all">
                                        <i class="fas fa-edit mr-1.5"></i>Edit
                                    </button>
                                    <button type="button" onclick="openDeleteKebijakan({{ $kb->id }})" class="inline-flex items-center px-3 py-2 bg-red-100 hover:bg-red-200 text-red-700 rounded-lg text-xs font-bold transition-all">
                                        <i class="fas fa-trash mr-1.5"></i>Hapus
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="px-6 py-16 text-center">
                                <div class="flex flex-col items-center">
                                    <div class="w-20 h-20 rounded-3xl bg-slate-100 flex items-center justify-center mb-4">
                                        <i class="fas fa-file-alt text-slate-400 text-3xl"></i>
                                    </div>
                                    <p class="text-slate-500 font-semibold">Belum ada kebijakan</p>
                                    <p class="text-xs text-slate-400 mt-1">Klik tombol "Tambah Kebijakan Baru" di atas untuk membuat</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="p-6 border-t border-slate-100">
                {{ $kebijakans->appends(request()->query())->links('pagination.number-123') }}
            </div>
        </div>
    </div>

    {{-- CREATE MODAL --}}
    <div id="createKebijakanModal" class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm z-50 hidden items-center justify-center p-4">
        <div class="bg-white rounded-3xl shadow-2xl w-full max-w-2xl max-h-[90vh] overflow-y-auto">
            <div class="p-6 border-b border-slate-100 sticky top-0 bg-white z-10">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="w-12 h-12 rounded-2xl bg-emerald-100 flex items-center justify-center">
                            <i class="fas fa-plus text-emerald-600 text-xl"></i>
                        </div>
                        <div>
                            <h3 class="text-lg font-bold text-slate-800">Tambah Kebijakan Baru</h3>
                            <p class="text-xs text-slate-500">Isi form untuk menambah kebijakan</p>
                        </div>
                    </div>
                    <button onclick="closeCreateKebijakan()" class="text-slate-400 hover:text-slate-600 p-2 rounded-xl hover:bg-slate-100 transition-all">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>
            <form action="{{ route('admin.kebijakan.store') }}" method="POST">
                @csrf
                <div class="p-6 space-y-5">
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">Judul Kebijakan <span class="text-red-500">*</span></label>
                        <input type="text" name="title" required value="{{ old('title') }}" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 transition-all outline-none text-sm font-medium" placeholder="Masukkan judul kebijakan...">
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">Slug URL <span class="text-red-500">*</span></label>
                        <input type="text" name="slug" required value="{{ old('slug') }}" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 transition-all outline-none text-sm font-medium" placeholder="contoh: kebijakan-privasi">
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">Isi Kebijakan <span class="text-red-500">*</span></label>
                        <textarea name="content" rows="12" required class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 transition-all outline-none text-sm font-medium resize-y" placeholder="Masukkan isi kebijakan secara lengkap...">{{ old('content') }}</textarea>
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">Untuk Role</label>
                        <select name="for_role" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 transition-all outline-none text-sm font-medium">
                            <option value="all">Semua Role</option>
                            <option value="admin">Admin</option>
                            <option value="guru">Guru</option>
                            <option value="siswa">Siswa</option>
                            <option value="kepala_sekolah">Kepala Sekolah</option>
                            <option value="tendik">Tendik</option>
                        </select>
                    </div>
                    <div class="flex items-center justify-between p-4 bg-slate-50 rounded-2xl">
                        <div>
                            <p class="text-sm font-bold text-slate-700">Aktifkan Kebijakan</p>
                            <p class="text-xs text-slate-500">Tampilkan di halaman bantuan publik</p>
                        </div>
                        <label class="inline-flex items-center cursor-pointer">
                            <input type="checkbox" name="is_active" value="1" checked class="sr-only peer">
                            <div class="relative w-12 h-6 bg-slate-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-emerald-200 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-slate-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-emerald-600"></div>
                        </label>
                    </div>
                </div>
                <div class="p-6 pt-0 flex gap-3">
                    <button type="button" onclick="closeCreateKebijakan()" class="flex-1 px-4 py-3 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-xl font-bold text-sm transition-colors">
                        Batal
                    </button>
                    <button type="submit" class="flex-1 px-4 py-3 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl font-bold text-sm transition-colors shadow-lg shadow-emerald-500/20">
                        <i class="fas fa-save mr-2"></i>Simpan Kebijakan
                    </button>
                </div>
            </form>
        </div>
    </div>

    <div id="editKebijakanModal" class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm z-50 hidden items-center justify-center p-4">
        <div class="bg-white rounded-3xl shadow-2xl w-full max-w-2xl max-h-[90vh] overflow-y-auto">
            <div class="p-6 border-b border-slate-100 sticky top-0 bg-white z-10">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="w-12 h-12 rounded-2xl bg-blue-100 flex items-center justify-center">
                            <i class="fas fa-edit text-blue-600 text-xl"></i>
                        </div>
                        <div>
                            <h3 class="text-lg font-bold text-slate-800">Edit Kebijakan</h3>
                            <p class="text-xs text-slate-500">Perbarui konten kebijakan</p>
                        </div>
                    </div>
                    <button onclick="closeEditKebijakan()" class="text-slate-400 hover:text-slate-600 p-2 rounded-xl hover:bg-slate-100 transition-all">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>
            <form id="editKebijakanForm" method="POST">
                @csrf
                @method('PUT')
                <div class="p-6 space-y-5">
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">Judul Kebijakan <span class="text-red-500">*</span></label>
                        <input type="text" name="title" id="editTitle" required class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 transition-all outline-none text-sm font-medium">
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">Slug URL <span class="text-red-500">*</span></label>
                        <input type="text" name="slug" id="editSlug" required class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 transition-all outline-none text-sm font-medium">
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">Isi Kebijakan <span class="text-red-500">*</span></label>
                        <textarea name="content" id="editContent" rows="12" required class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 transition-all outline-none text-sm font-medium resize-y"></textarea>
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">Untuk Role</label>
                        <select name="for_role" id="editForRole" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 transition-all outline-none text-sm font-medium">
                            <option value="all">Semua Role</option>
                            <option value="admin">Admin</option>
                            <option value="guru">Guru</option>
                            <option value="siswa">Siswa</option>
                            <option value="kepala_sekolah">Kepala Sekolah</option>
                            <option value="tendik">Tendik</option>
                        </select>
                    </div>
                    <div class="flex items-center justify-between p-4 bg-slate-50 rounded-2xl">
                        <div>
                            <p class="text-sm font-bold text-slate-700">Aktifkan Kebijakan</p>
                        </div>
                        <label class="inline-flex items-center cursor-pointer">
                            <input type="checkbox" name="is_active" id="editIsActive" value="1" class="sr-only peer">
                            <div class="relative w-12 h-6 bg-slate-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-emerald-200 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-slate-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-emerald-600"></div>
                        </label>
                    </div>
                </div>
                <div class="p-6 pt-0 flex gap-3">
                    <button type="button" onclick="closeEditKebijakan()" class="flex-1 px-4 py-3 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-xl font-bold text-sm transition-colors">
                        Batal
                    </button>
                    <button type="submit" class="flex-1 px-4 py-3 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl font-bold text-sm transition-colors shadow-lg shadow-emerald-500/20">
                        <i class="fas fa-save mr-2"></i>Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>

    <div id="deleteKebijakanModal" class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm z-50 hidden items-center justify-center p-4">
        <div class="bg-white rounded-3xl shadow-2xl w-full max-w-md">
            <div class="p-6">
                <div class="flex flex-col items-center text-center mb-6">
                    <div class="w-16 h-16 rounded-3xl bg-red-100 flex items-center justify-center mb-4">
                        <i class="fas fa-exclamation-triangle text-red-600 text-2xl"></i>
                    </div>
                    <h3 class="text-lg font-bold text-slate-800 mb-2">Hapus Kebijakan?</h3>
                    <p class="text-sm text-slate-500">Tindakan ini tidak dapat dibatalkan. Kebijakan akan dihapus secara permanen.</p>
                </div>
                <form id="deleteKebijakanForm" method="POST">
                    @csrf
                    @method('DELETE')
                    <div class="flex gap-3">
                        <button type="button" onclick="closeDeleteKebijakan()" class="flex-1 px-4 py-3 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-xl font-bold text-sm transition-colors">
                            Batal
                        </button>
                        <button type="submit" class="flex-1 px-4 py-3 bg-red-600 hover:bg-red-700 text-white rounded-xl font-bold text-sm transition-colors shadow-lg shadow-red-500/20">
                            <i class="fas fa-trash mr-2"></i>Hapus
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function openCreateKebijakan() {
            const modal = document.getElementById('createKebijakanModal');
            modal.classList.remove('hidden');
            modal.classList.add('flex');
            document.body.style.overflow = 'hidden';
        }
        function closeCreateKebijakan() {
            const modal = document.getElementById('createKebijakanModal');
            modal.classList.add('hidden');
            modal.classList.remove('flex');
            document.body.style.overflow = '';
            const form = modal.querySelector('form');
            if (form) form.reset();
        }
        function openEditKebijakan(kb) {
            const url = "{{ route('admin.kebijakan.update', ':id') }}";
            document.getElementById('editKebijakanForm').action = url.replace(':id', kb.id);
            document.getElementById('editTitle').value = kb.title;
            document.getElementById('editSlug').value = kb.slug;
            document.getElementById('editContent').value = kb.content;
            document.getElementById('editForRole').value = kb.for_role;
            document.getElementById('editIsActive').checked = kb.is_active == 1 || kb.is_active;
            const modal = document.getElementById('editKebijakanModal');
            modal.classList.remove('hidden');
            modal.classList.add('flex');
            document.body.style.overflow = 'hidden';
        }
        function closeEditKebijakan() {
            const modal = document.getElementById('editKebijakanModal');
            modal.classList.add('hidden');
            modal.classList.remove('flex');
            document.body.style.overflow = '';
        }
        function openDeleteKebijakan(id) {
            const url = "{{ route('admin.kebijakan.destroy', ':id') }}";
            document.getElementById('deleteKebijakanForm').action = url.replace(':id', id);
            const modal = document.getElementById('deleteKebijakanModal');
            modal.classList.remove('hidden');
            modal.classList.add('flex');
            document.body.style.overflow = 'hidden';
        }
        function closeDeleteKebijakan() {
            const modal = document.getElementById('deleteKebijakanModal');
            modal.classList.add('hidden');
            modal.classList.remove('flex');
            document.body.style.overflow = '';
        }
        document.getElementById('createKebijakanModal').addEventListener('click', function(e) { if (e.target === this) closeCreateKebijakan(); });
        document.getElementById('editKebijakanModal').addEventListener('click', function(e) { if (e.target === this) closeEditKebijakan(); });
        document.getElementById('deleteKebijakanModal').addEventListener('click', function(e) { if (e.target === this) closeDeleteKebijakan(); });
    </script>
@endsection
