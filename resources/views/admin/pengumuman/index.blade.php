@extends('layouts.admin')

@section('title', 'Pengumuman')
@section('header', 'Manajemen Pengumuman')

@section('content')
    <div class="space-y-6">
        <!-- Form Tambah Pengumuman -->
        <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-6">
            <h3 class="text-lg font-bold text-gray-800 mb-4">Buat Pengumuman Baru</h3>
            <form action="{{ route('admin.pengumuman.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="space-y-4">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="md:col-span-1">
                            <label for="judul" class="block text-sm font-medium text-gray-700 mb-1">Judul Pengumuman</label>
                            <input type="text" name="judul" id="judul" required class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500 shadow-sm" placeholder="Contoh: Libur Semester Genap">
                        </div>
                        <div class="md:col-span-1">
                            <label for="file_pdf" class="block text-sm font-medium text-gray-700 mb-1">Lampiran PDF (Opsional)</label>
                            <input type="file" name="file_pdf" id="file_pdf" accept=".pdf" class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 transition-all">
                            <p class="text-[10px] text-gray-400 mt-1">Maksimal 5MB. Hanya file PDF.</p>
                        </div>
                    </div>
                    <div>
                        <label for="isi" class="block text-sm font-medium text-gray-700 mb-1">Isi Pengumuman</label>
                        <textarea name="isi" id="isi" rows="3" required class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500 shadow-sm" placeholder="Tulis isi pengumuman di sini..."></textarea>
                    </div>
                    <div class="flex justify-end">
                        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors font-medium text-sm flex items-center">
                            <i class="fas fa-paper-plane mr-2"></i> Terbitkan
                        </button>
                    </div>
                </div>
            </form>
        </div>

        <!-- Daftar Pengumuman -->
        <div class="bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden">
            <div class="p-6 border-b border-gray-100 flex justify-between items-center">
                <h3 class="text-lg font-bold text-gray-800">Daftar Pengumuman</h3>
                <span class="bg-blue-100 text-blue-800 text-xs font-semibold px-2.5 py-0.5 rounded">{{ $pengumumans->total() }} Pengumuman</span>
            </div>
            
            @if(session('success'))
                <div class="mx-6 mt-6 p-4 bg-green-50 border border-green-200 text-green-700 rounded-lg flex items-center">
                    <i class="fas fa-check-circle mr-2"></i>
                    {{ session('success') }}
                </div>
            @endif

            <div class="divide-y divide-gray-100">
                @forelse($pengumumans as $pengumuman)
                    <div class="p-6 hover:bg-gray-50 transition-colors group">
                        <div class="flex justify-between items-start">
                            <div class="flex-1 pr-4">
                                <div class="flex items-center gap-2 mb-2">
                                    <h4 class="text-base font-bold text-gray-900 group-hover:text-blue-600 transition-colors">{{ $pengumuman->judul }}</h4>
                                    <span class="text-xs text-gray-500 bg-gray-100 px-2 py-0.5 rounded-full border border-gray-200">
                                        {{ $pengumuman->created_at->format('d M Y H:i') }}
                                    </span>
                                </div>
                                <p class="text-gray-600 text-sm leading-relaxed mb-3">{{ $pengumuman->isi }}</p>
                                @if($pengumuman->file_path)
                                    <div class="mb-3">
                                        <a href="{{ route('pengumuman.lampiran', $pengumuman->id) }}" target="_blank" class="inline-flex items-center text-xs font-bold text-blue-600 bg-blue-50 px-3 py-1.5 rounded-lg border border-blue-100 hover:bg-blue-100 transition-all">
                                            <i class="fas fa-file-pdf mr-2"></i> Lihat Lampiran
                                        </a>
                                    </div>
                                @endif
                                <div class="flex items-center gap-4 text-xs text-gray-500">
                                    <span class="flex items-center gap-1">
                                        <i class="far fa-user"></i> Admin
                                    </span>
                                    <span class="flex items-center gap-1 {{ $pengumuman->is_active ? 'text-green-600' : 'text-red-600' }}">
                                        <i class="fas fa-circle text-[8px]"></i> {{ $pengumuman->is_active ? 'Aktif' : 'Non-aktif' }}
                                    </span>
                                </div>
                            </div>
                            <form action="{{ route('admin.pengumuman.destroy', $pengumuman->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus pengumuman ini?');">
                            @csrf
                            @method('DELETE')
                            <button type="button" onclick='openEditModal(@json($pengumuman))' class="text-gray-400 hover:text-yellow-500 p-2 rounded-lg hover:bg-yellow-50 transition-all mr-1" title="Edit">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button type="submit" class="text-gray-400 hover:text-red-500 p-2 rounded-lg hover:bg-red-50 transition-all" title="Hapus">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                        </form>
                    </div>
                </div>
            @empty
                <div class="p-12 text-center">
                    <div class="inline-flex items-center justify-center w-16 h-16 bg-gray-100 rounded-full mb-4">
                        <i class="far fa-newspaper text-gray-400 text-2xl"></i>
                    </div>
                    <p class="text-gray-500 font-medium">Belum ada pengumuman.</p>
                </div>
            @endforelse
        </div>
        
        @if($pengumumans->hasPages())
            <div class="p-4 border-t border-gray-100">
                {{ $pengumumans->links() }}
            </div>
        @endif
    </div>
</div>

<!-- Edit Modal -->
<div id="editModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden flex items-center justify-center p-4">
    <div class="bg-white rounded-xl shadow-xl w-full max-w-lg overflow-hidden transform transition-all">
        <div class="p-6 border-b border-gray-100 flex justify-between items-center bg-gray-50">
            <h3 class="text-lg font-bold text-gray-800">Edit Pengumuman</h3>
            <button onclick="closeEditModal()" class="text-gray-400 hover:text-gray-600 transition-colors">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <form id="editForm" action="" method="POST" class="p-6" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="space-y-4">
                <div>
                    <label for="edit_judul" class="block text-sm font-medium text-gray-700 mb-1">Judul Pengumuman</label>
                    <input type="text" name="judul" id="edit_judul" required class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500 shadow-sm">
                </div>
                <div>
                    <label for="edit_file_pdf" class="block text-sm font-medium text-gray-700 mb-1">Ganti Lampiran PDF (Opsional)</label>
                    <input type="file" name="file_pdf" id="edit_file_pdf" accept=".pdf" class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 transition-all">
                    <p id="edit_file_info" class="text-[10px] text-gray-400 mt-1">Hanya file PDF. Maksimal 5MB.</p>
                </div>
                <div>
                    <label for="edit_isi" class="block text-sm font-medium text-gray-700 mb-1">Isi Pengumuman</label>
                    <textarea name="isi" id="edit_isi" rows="3" required class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500 shadow-sm"></textarea>
                </div>
                <div class="flex items-center">
                    <input type="checkbox" name="is_active" id="edit_is_active" value="1" class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                    <label for="edit_is_active" class="ml-2 text-sm text-gray-700">Tampilkan Pengumuman (Aktif)</label>
                </div>
                <div class="flex justify-end gap-3 mt-6">
                    <button type="button" onclick="closeEditModal()" class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-colors font-medium text-sm">Batal</button>
                    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors font-medium text-sm">
                        Simpan Perubahan
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    function openEditModal(pengumuman) {
        document.getElementById('editModal').classList.remove('hidden');
        document.getElementById('editForm').action = "{{ route('admin.pengumuman.index') }}/" + pengumuman.id;
        document.getElementById('edit_judul').value = pengumuman.judul;
        document.getElementById('edit_isi').value = pengumuman.isi;
        document.getElementById('edit_is_active').checked = pengumuman.is_active == 1;
        
        const fileInfo = document.getElementById('edit_file_info');
        if (pengumuman.file_path) {
            fileInfo.innerHTML = `<span class="text-blue-600 font-bold"><i class="fas fa-paperclip"></i> File saat ini tersedia.</span> Ganti jika ingin memperbarui.`;
        } else {
            fileInfo.innerHTML = `Hanya file PDF. Maksimal 5MB.`;
        }
    }

    function closeEditModal() {
        document.getElementById('editModal').classList.add('hidden');
    }
</script>
@endsection
