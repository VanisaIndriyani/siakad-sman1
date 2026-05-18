@extends('layouts.admin')

@section('title', 'Data Mata Pelajaran')
@section('header', 'Manajemen Mata Pelajaran')

@section('content')
    <div class="bg-white rounded-xl border border-gray-100 card-shadow overflow-hidden">
        <div class="p-6 border-b border-gray-100 flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
            <h3 class="font-bold text-gray-800">Daftar Mata Pelajaran</h3>
            <button onclick="document.getElementById('addMapelModal').classList.remove('hidden')" class="w-full md:w-auto bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-lg shadow-sm transition-colors text-sm flex items-center justify-center">
                <i class="fas fa-plus mr-2"></i> Tambah Mapel
            </button>
        </div>
        
        <!-- Filter/Search -->
        <form action="{{ route('admin.mapel.index') }}" method="GET" class="p-4 bg-gray-50 border-b border-gray-100 flex flex-col md:flex-row gap-4">
            <div class="relative flex-1">
                <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari Kode atau Nama Mapel..." class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm">
            </div>
            <div class="flex gap-2">
                <select name="kelompok" onchange="this.form.submit()" class="flex-1 md:flex-none border border-gray-300 rounded-lg px-4 py-2 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white">
                    <option value="">Semua Kelompok</option>
                    <option value="A" {{ request('kelompok') == 'A' ? 'selected' : '' }}>Kelompok A (Wajib)</option>
                    <option value="B" {{ request('kelompok') == 'B' ? 'selected' : '' }}>Kelompok B (Wajib)</option>
                    <option value="C" {{ request('kelompok') == 'C' ? 'selected' : '' }}>Kelompok C (Peminatan)</option>
                </select>
                <button type="submit" class="bg-blue-50 text-blue-600 px-6 py-2 rounded-lg text-sm font-bold hover:bg-blue-100 transition-colors">Cari</button>
            </div>
        </form>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-50 text-gray-600 text-xs uppercase tracking-wider">
                        <th class="p-4 font-semibold">Kode</th>
                        <th class="p-4 font-semibold">Nama Mapel</th>
                        <th class="p-4 font-semibold">Kelompok</th>
                        <th class="p-4 font-semibold">KKM</th>
                        <th class="p-4 font-semibold text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 text-sm">
                    @forelse($mapels as $mapel)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="p-4 font-mono text-gray-600">{{ $mapel->kode_mapel }}</td>
                        <td class="p-4 font-bold text-gray-800">{{ $mapel->nama_mapel }}</td>
                        <td class="p-4">
                            @if($mapel->kelompok)
                                <span class="bg-blue-100 text-blue-700 px-2 py-1 rounded-full text-xs">Kelompok {{ $mapel->kelompok }}</span>
                            @else
                                <span class="text-gray-400">-</span>
                            @endif
                        </td>
                        <td class="p-4">{{ $mapel->kkm }}</td>
                        <td class="p-4 text-center">
                            <button onclick='openEditModal(@json($mapel))' class="text-yellow-500 hover:text-yellow-700 mx-1"><i class="fas fa-edit"></i></button>
                            <form action="{{ route('admin.mapel.destroy', $mapel->id) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus mapel ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-800 mx-1"><i class="fas fa-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="p-4 text-center text-gray-500">
                            @if(request('search'))
                                Tidak ada data mapel yang cocok dengan pencarian "{{ request('search') }}".
                            @else
                                Belum ada data mata pelajaran.
                            @endif
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <!-- Pagination -->
        <div class="p-4 border-t border-gray-100">
            {{ $mapels->appends(request()->query())->links() }}
        </div>
    </div>

    <!-- Add Mapel Modal -->
    <div id="addMapelModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
        <div class="relative top-20 mx-auto p-5 border w-full max-w-lg shadow-lg rounded-md bg-white">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-xl font-bold text-gray-900">Tambah Mata Pelajaran</h3>
                <button onclick="document.getElementById('addMapelModal').classList.add('hidden')" class="text-gray-400 hover:text-gray-500">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <form action="{{ route('admin.mapel.store') }}" method="POST">
                @csrf
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Kode Mapel *</label>
                        <input type="text" name="kode_mapel" required placeholder="Contoh: MAT-W-X" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 border p-2">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Nama Mata Pelajaran *</label>
                        <input type="text" name="nama_mapel" required placeholder="Contoh: Matematika Wajib" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 border p-2">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Kelompok *</label>
                        <select name="kelompok" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 border p-2">
                            <option value="A">Kelompok A (Wajib)</option>
                            <option value="B">Kelompok B (Wajib)</option>
                            <option value="C">Kelompok C (Peminatan)</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">KKM *</label>
                        <input type="number" name="kkm" required value="75" min="0" max="100" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 border p-2">
                    </div>
                </div>
                <div class="mt-6 flex justify-end gap-3">
                    <button type="button" onclick="document.getElementById('addMapelModal').classList.add('hidden')" class="bg-gray-200 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-300 transition-colors">Batal</button>
                    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors">Simpan</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Edit Mapel Modal -->
    <div id="editMapelModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
        <div class="relative top-20 mx-auto p-5 border w-full max-w-lg shadow-lg rounded-md bg-white">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-xl font-bold text-gray-900">Edit Mata Pelajaran</h3>
                <button onclick="document.getElementById('editMapelModal').classList.add('hidden')" class="text-gray-400 hover:text-gray-500">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <form id="editMapelForm" method="POST">
                @csrf
                @method('PUT')
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Kode Mapel *</label>
                        <input type="text" id="edit_kode_mapel" name="kode_mapel" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 border p-2">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Nama Mata Pelajaran *</label>
                        <input type="text" id="edit_nama_mapel" name="nama_mapel" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 border p-2">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Kelompok *</label>
                        <select id="edit_kelompok" name="kelompok" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 border p-2">
                            <option value="A">Kelompok A (Wajib)</option>
                            <option value="B">Kelompok B (Wajib)</option>
                            <option value="C">Kelompok C (Peminatan)</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">KKM *</label>
                        <input type="number" id="edit_kkm" name="kkm" required min="0" max="100" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 border p-2">
                    </div>
                </div>
                <div class="mt-6 flex justify-end gap-3">
                    <button type="button" onclick="document.getElementById('editMapelModal').classList.add('hidden')" class="bg-gray-200 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-300 transition-colors">Batal</button>
                    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function openEditModal(mapel) {
            let url = "{{ route('admin.mapel.update', ':id') }}";
            url = url.replace(':id', mapel.id);
            document.getElementById('editMapelForm').action = url;
            
            document.getElementById('edit_kode_mapel').value = mapel.kode_mapel;
            document.getElementById('edit_nama_mapel').value = mapel.nama_mapel;
            document.getElementById('edit_kelompok').value = mapel.kelompok || 'A';
            document.getElementById('edit_kkm').value = mapel.kkm;
            
            document.getElementById('editMapelModal').classList.remove('hidden');
        }
    </script>
@endsection