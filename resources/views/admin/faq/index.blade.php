@extends('layouts.admin')

@section('title', 'Kelola FAQ')
@section('header', 'Kelola FAQ')

@section('content')
    <div class="space-y-6">
        <div class="card-modern overflow-hidden">
            <div class="p-6 border-b border-slate-100">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                    <div class="flex items-center gap-3">
                        <div class="w-11 h-11 rounded-2xl bg-amber-100 flex items-center justify-center">
                            <i class="fas fa-question text-amber-600"></i>
                        </div>
                        <div>
                            <h3 class="font-bold text-slate-800">Daftar FAQ</h3>
                            <p class="text-xs text-slate-500">Total {{ $faqs->total() }} FAQ tersimpan</p>
                        </div>
                    </div>
                    <button type="button" onclick="openCreateFaq()" class="inline-flex items-center px-5 py-3 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl font-bold text-sm transition-all shadow-lg shadow-emerald-500/20">
                        <i class="fas fa-plus mr-2"></i>Tambah FAQ Baru
                    </button>
                </div>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead>
                        <tr class="bg-slate-50 text-slate-600 text-xs uppercase tracking-wider">
                            <th class="px-6 py-4 font-bold">No</th>
                            <th class="px-6 py-4 font-bold">Pertanyaan</th>
                            <th class="px-6 py-4 font-bold">For Role</th>
                            <th class="px-6 py-4 font-bold">Urutan</th>
                            <th class="px-6 py-4 font-bold">Status</th>
                            <th class="px-6 py-4 font-bold text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-sm">
                        @forelse($faqs as $faq)
                        <tr class="hover:bg-slate-50/70 transition-colors">
                            <td class="px-6 py-4 text-slate-500 font-bold">{{ $loop->iteration + ($faqs->currentPage() - 1) * $faqs->perPage() }}</td>
                            <td class="px-6 py-4 max-w-xs">
                                <div class="font-bold text-slate-800 line-clamp-2">{{ $faq->question }}</div>
                            </td>
                            <td class="px-6 py-4">
                                @php
                                    $roleBadge = match($faq->for_role) {
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
                                <span class="inline-flex items-center justify-center w-8 h-8 bg-slate-100 rounded-lg font-bold text-slate-700 text-xs">{{ $faq->sort_order }}</span>
                            </td>
                            <td class="px-6 py-4">
                                @if($faq->is_active)
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-bold bg-emerald-100 text-emerald-700">Active</span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-bold bg-slate-100 text-slate-700">Inactive</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-center">
                                <div class="flex items-center justify-center gap-2">
                                    <button type="button" onclick="openEditFaq({{ json_encode($faq) }})" class="inline-flex items-center px-3 py-2 bg-blue-100 hover:bg-blue-200 text-blue-700 rounded-lg text-xs font-bold transition-all">
                                        <i class="fas fa-edit mr-1.5"></i>Edit
                                    </button>
                                    <button type="button" onclick="openDeleteFaq({{ $faq->id }})" class="inline-flex items-center px-3 py-2 bg-red-100 hover:bg-red-200 text-red-700 rounded-lg text-xs font-bold transition-all">
                                        <i class="fas fa-trash mr-1.5"></i>Hapus
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="px-6 py-16 text-center">
                                <div class="flex flex-col items-center">
                                    <div class="w-20 h-20 rounded-3xl bg-slate-100 flex items-center justify-center mb-4">
                                        <i class="fas fa-question-circle text-slate-400 text-3xl"></i>
                                    </div>
                                    <p class="text-slate-500 font-semibold">Belum ada FAQ</p>
                                    <p class="text-xs text-slate-400 mt-1">Klik tombol "Tambah FAQ Baru" di atas untuk membuat</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="p-6 border-t border-slate-100">
                {{ $faqs->appends(request()->query())->links('pagination.number-123') }}
            </div>
        </div>
    </div>

    {{-- CREATE MODAL --}}
    <div id="createFaqModal" class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm z-50 hidden items-center justify-center p-4">
        <div class="bg-white rounded-3xl shadow-2xl w-full max-w-xl max-h-[90vh] overflow-y-auto">
            <div class="p-6 border-b border-slate-100 sticky top-0 bg-white z-10">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="w-12 h-12 rounded-2xl bg-emerald-100 flex items-center justify-center">
                            <i class="fas fa-plus text-emerald-600 text-xl"></i>
                        </div>
                        <div>
                            <h3 class="text-lg font-bold text-slate-800">Tambah FAQ Baru</h3>
                            <p class="text-xs text-slate-500">Isi form untuk menambah FAQ</p>
                        </div>
                    </div>
                    <button onclick="closeCreateFaq()" class="text-slate-400 hover:text-slate-600 p-2 rounded-xl hover:bg-slate-100 transition-all">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>
            <form action="{{ route('admin.faq.store') }}" method="POST">
                @csrf
                <div class="p-6 space-y-5">
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">Pertanyaan <span class="text-red-500">*</span></label>
                        <input type="text" name="question" required value="{{ old('question') }}" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 transition-all outline-none text-sm font-medium" placeholder="Masukkan pertanyaan...">
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">Jawaban <span class="text-red-500">*</span></label>
                        <textarea name="answer" rows="5" required class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 transition-all outline-none text-sm font-medium resize-none" placeholder="Masukkan jawaban...">{{ old('answer') }}</textarea>
                    </div>
                    <div class="grid grid-cols-2 gap-4">
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
                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-2">Urutan</label>
                            <input type="number" name="sort_order" value="1" min="1" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 transition-all outline-none text-sm font-medium">
                        </div>
                    </div>
                    <div class="flex items-center justify-between p-4 bg-slate-50 rounded-2xl">
                        <div>
                            <p class="text-sm font-bold text-slate-700">Aktifkan FAQ</p>
                            <p class="text-xs text-slate-500">Tampilkan FAQ di halaman bantuan</p>
                        </div>
                        <label class="inline-flex items-center cursor-pointer">
                            <input type="checkbox" name="is_active" value="1" checked class="sr-only peer">
                            <div class="relative w-12 h-6 bg-slate-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-emerald-200 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-slate-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-emerald-600"></div>
                        </label>
                    </div>
                </div>
                <div class="p-6 pt-0 flex gap-3">
                    <button type="button" onclick="closeCreateFaq()" class="flex-1 px-4 py-3 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-xl font-bold text-sm transition-colors">
                        Batal
                    </button>
                    <button type="submit" class="flex-1 px-4 py-3 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl font-bold text-sm transition-colors shadow-lg shadow-emerald-500/20">
                        <i class="fas fa-save mr-2"></i>Simpan FAQ
                    </button>
                </div>
            </form>
        </div>
    </div>

    <div id="editFaqModal" class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm z-50 hidden items-center justify-center p-4">
        <div class="bg-white rounded-3xl shadow-2xl w-full max-w-xl max-h-[90vh] overflow-y-auto">
            <div class="p-6 border-b border-slate-100 sticky top-0 bg-white z-10">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="w-12 h-12 rounded-2xl bg-blue-100 flex items-center justify-center">
                            <i class="fas fa-edit text-blue-600 text-xl"></i>
                        </div>
                        <div>
                            <h3 class="text-lg font-bold text-slate-800">Edit FAQ</h3>
                            <p class="text-xs text-slate-500">Perbarui konten FAQ</p>
                        </div>
                    </div>
                    <button onclick="closeEditFaq()" class="text-slate-400 hover:text-slate-600 p-2 rounded-xl hover:bg-slate-100 transition-all">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>
            <form id="editFaqForm" method="POST">
                @csrf
                @method('PUT')
                <div class="p-6 space-y-5">
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">Pertanyaan <span class="text-red-500">*</span></label>
                        <input type="text" name="question" id="editQuestion" required class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 transition-all outline-none text-sm font-medium">
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">Jawaban <span class="text-red-500">*</span></label>
                        <textarea name="answer" id="editAnswer" rows="5" required class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 transition-all outline-none text-sm font-medium resize-none"></textarea>
                    </div>
                    <div class="grid grid-cols-2 gap-4">
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
                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-2">Urutan</label>
                            <input type="number" name="sort_order" id="editSortOrder" min="1" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 transition-all outline-none text-sm font-medium">
                        </div>
                    </div>
                    <div class="flex items-center justify-between p-4 bg-slate-50 rounded-2xl">
                        <div>
                            <p class="text-sm font-bold text-slate-700">Aktifkan FAQ</p>
                        </div>
                        <label class="inline-flex items-center cursor-pointer">
                            <input type="checkbox" name="is_active" id="editIsActive" value="1" class="sr-only peer">
                            <div class="relative w-12 h-6 bg-slate-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-emerald-200 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-slate-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-emerald-600"></div>
                        </label>
                    </div>
                </div>
                <div class="p-6 pt-0 flex gap-3">
                    <button type="button" onclick="closeEditFaq()" class="flex-1 px-4 py-3 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-xl font-bold text-sm transition-colors">
                        Batal
                    </button>
                    <button type="submit" class="flex-1 px-4 py-3 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl font-bold text-sm transition-colors shadow-lg shadow-emerald-500/20">
                        <i class="fas fa-save mr-2"></i>Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>

    <div id="deleteFaqModal" class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm z-50 hidden items-center justify-center p-4">
        <div class="bg-white rounded-3xl shadow-2xl w-full max-w-md">
            <div class="p-6">
                <div class="flex flex-col items-center text-center mb-6">
                    <div class="w-16 h-16 rounded-3xl bg-red-100 flex items-center justify-center mb-4">
                        <i class="fas fa-exclamation-triangle text-red-600 text-2xl"></i>
                    </div>
                    <h3 class="text-lg font-bold text-slate-800 mb-2">Hapus FAQ?</h3>
                    <p class="text-sm text-slate-500">Tindakan ini tidak dapat dibatalkan. FAQ akan dihapus secara permanen.</p>
                </div>
                <form id="deleteFaqForm" method="POST">
                    @csrf
                    @method('DELETE')
                    <div class="flex gap-3">
                        <button type="button" onclick="closeDeleteFaq()" class="flex-1 px-4 py-3 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-xl font-bold text-sm transition-colors">
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
        function openCreateFaq() {
            const modal = document.getElementById('createFaqModal');
            modal.classList.remove('hidden');
            modal.classList.add('flex');
            document.body.style.overflow = 'hidden';
        }
        function closeCreateFaq() {
            const modal = document.getElementById('createFaqModal');
            modal.classList.add('hidden');
            modal.classList.remove('flex');
            document.body.style.overflow = '';
            const form = modal.querySelector('form');
            if (form) form.reset();
        }
        function openEditFaq(faq) {
            const url = "{{ route('admin.faq.update', ':id') }}";
            document.getElementById('editFaqForm').action = url.replace(':id', faq.id);
            document.getElementById('editQuestion').value = faq.question;
            document.getElementById('editAnswer').value = faq.answer;
            document.getElementById('editForRole').value = faq.for_role;
            document.getElementById('editSortOrder').value = faq.sort_order;
            document.getElementById('editIsActive').checked = faq.is_active == 1 || faq.is_active;
            const modal = document.getElementById('editFaqModal');
            modal.classList.remove('hidden');
            modal.classList.add('flex');
            document.body.style.overflow = 'hidden';
        }
        function closeEditFaq() {
            const modal = document.getElementById('editFaqModal');
            modal.classList.add('hidden');
            modal.classList.remove('flex');
            document.body.style.overflow = '';
        }
        function openDeleteFaq(id) {
            const url = "{{ route('admin.faq.destroy', ':id') }}";
            document.getElementById('deleteFaqForm').action = url.replace(':id', id);
            const modal = document.getElementById('deleteFaqModal');
            modal.classList.remove('hidden');
            modal.classList.add('flex');
            document.body.style.overflow = 'hidden';
        }
        function closeDeleteFaq() {
            const modal = document.getElementById('deleteFaqModal');
            modal.classList.add('hidden');
            modal.classList.remove('flex');
            document.body.style.overflow = '';
        }
        document.getElementById('createFaqModal').addEventListener('click', function(e) { if (e.target === this) closeCreateFaq(); });
        document.getElementById('editFaqModal').addEventListener('click', function(e) { if (e.target === this) closeEditFaq(); });
        document.getElementById('deleteFaqModal').addEventListener('click', function(e) { if (e.target === this) closeDeleteFaq(); });
    </script>
@endsection
