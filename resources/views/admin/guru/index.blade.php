@extends('layouts.admin')

@section('title', 'Data Guru')
@section('header', 'Manajemen Guru')

@section('content')
    <div class="bg-white rounded-xl border border-gray-100 card-shadow overflow-hidden">
        <div class="p-6 border-b border-gray-100 flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
            <h3 class="font-bold text-gray-800">Daftar Guru</h3>
            <div class="flex flex-wrap gap-2 w-full md:w-auto">
                <a href="{{ route('admin.guru.template') }}" class="flex-1 md:flex-none justify-center bg-gray-200 hover:bg-gray-300 text-gray-800 font-medium py-2 px-4 rounded-lg shadow-sm transition-colors text-xs md:text-sm flex items-center">
                    <i class="fas fa-download mr-2"></i> <span class="whitespace-nowrap">Template</span>
                </a>
                <button onclick="document.getElementById('importModal').classList.remove('hidden')" class="flex-1 md:flex-none justify-center bg-green-600 hover:bg-green-700 text-white font-medium py-2 px-4 rounded-lg shadow-sm transition-colors text-xs md:text-sm flex items-center">
                    <i class="fas fa-file-import mr-2"></i> <span class="whitespace-nowrap">Import</span>
                </button>
                <button onclick="document.getElementById('addGuruModal').classList.remove('hidden')" class="flex-1 md:flex-none justify-center bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-lg shadow-sm transition-colors text-xs md:text-sm flex items-center">
                    <i class="fas fa-plus mr-2"></i> <span class="whitespace-nowrap">Tambah</span>
                </button>
            </div>
        </div>
        
        <!-- Filter/Search -->
        <form action="{{ route('admin.guru.index') }}" method="GET" class="p-4 bg-gray-50 border-b border-gray-100 flex flex-col md:flex-row gap-4">
            <div class="relative flex-1">
                <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari NIP atau Nama Guru..." class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm">
            </div>
            <div class="flex gap-2">
                <select name="status" onchange="this.form.submit()" class="flex-1 md:flex-none border border-gray-300 rounded-lg px-4 py-2 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white">
                    <option value="">Semua Status</option>
                    <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Aktif</option>
                    <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Non-Aktif</option>
                </select>
                <button type="submit" class="bg-blue-50 text-blue-600 px-6 py-2 rounded-lg text-sm font-bold hover:bg-blue-100 transition-colors">Cari</button>
            </div>
        </form>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-50 text-gray-600 text-xs uppercase tracking-wider">
                        <th class="p-4 font-semibold">Guru</th>
                        <th class="p-4 font-semibold">NIP</th>
                        <th class="p-4 font-semibold">Mata Pelajaran</th>
                        <th class="p-4 font-semibold">Status</th>
                        <th class="p-4 font-semibold text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 text-sm">
                    @forelse($gurus as $guru)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="p-4 flex items-center">
                            <img src="https://ui-avatars.com/api/?name={{ urlencode($guru->nama_lengkap) }}&background=random" class="w-10 h-10 rounded-full mr-3" alt="Avatar">
                            <div>
                                <div class="font-medium text-gray-800">{{ $guru->gelar_depan }} {{ $guru->nama_lengkap }} {{ $guru->gelar_belakang }}</div>
                                <div class="text-xs text-gray-500">{{ $guru->user->email }}</div>
                            </div>
                        </td>
                        <td class="p-4 text-gray-600">{{ $guru->nip }}</td>
                        <td class="p-4">
                            @php
                                $mapels = $guru->jadwals->load('mapel')->pluck('mapel.nama_mapel')->unique();
                            @endphp
                            @if($mapels->count() > 0)
                                @foreach($mapels as $mapel)
                                    <span class="bg-blue-100 text-blue-700 px-2 py-1 rounded text-xs font-semibold mr-1">{{ $mapel }}</span>
                                @endforeach
                            @else
                                <span class="text-gray-400">-</span>
                            @endif
                        </td>
                        <td class="p-4">
                            @if($guru->is_active)
                                <span class="bg-green-100 text-green-700 px-2 py-1 rounded text-xs font-semibold">Aktif</span>
                            @else
                                <span class="bg-red-100 text-red-700 px-2 py-1 rounded text-xs font-semibold">Non-Aktif</span>
                            @endif
                        </td>
                        <td class="p-4 text-center">
                            <button onclick='openEditModal(@json($guru), @json($guru->user))' class="text-blue-600 hover:text-blue-800 mx-1"><i class="fas fa-edit"></i></button>
                            <form action="{{ route('admin.guru.destroy', $guru->id) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus guru ini?')">
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
                                Tidak ada data guru yang cocok dengan pencarian "{{ request('search') }}".
                            @else
                                Belum ada data guru.
                            @endif
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <!-- Pagination -->
        <div class="p-4 border-t border-gray-100">
            {{ $gurus->appends(request()->query())->links('pagination.number-123') }}
        </div>
    </div>

    <!-- Import Modal -->
    <div id="importModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-[60]">
        <div class="relative top-20 mx-auto p-5 border w-full max-w-md shadow-lg rounded-xl bg-white">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-bold text-gray-900">Import Data Guru</h3>
                <button onclick="document.getElementById('importModal').classList.add('hidden')" class="text-gray-400 hover:text-gray-500">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <form action="{{ route('admin.guru.import') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Pilih File Excel (.xlsx, .xls, .csv)</label>
                        <input type="file" name="file" accept=".xlsx,.xls,.csv" required class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 transition-all">
                    </div>
                    <div class="flex justify-end gap-2 mt-6">
                        <button type="button" onclick="document.getElementById('importModal').classList.add('hidden')" class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-colors text-sm font-bold">Batal</button>
                        <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition-colors text-sm font-bold">Mulai Import</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Add Guru Modal -->
    <div id="addGuruModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
        <div class="relative top-10 mx-auto p-5 border w-full max-w-2xl shadow-lg rounded-md bg-white">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-xl font-bold text-gray-900">Tambah Guru Baru</h3>
                <button onclick="document.getElementById('addGuruModal').classList.add('hidden')" class="text-gray-400 hover:text-gray-500">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <form action="{{ route('admin.guru.store') }}" method="POST">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <!-- Akun Info -->
                    <div class="md:col-span-2 border-b pb-2 mb-2">
                        <h4 class="text-sm font-semibold text-gray-500 uppercase">Informasi Akun</h4>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Email</label>
                        <input type="email" name="email" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 border p-2">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Password</label>
                        <input type="password" name="password" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 border p-2">
                    </div>

                    <!-- Profil Guru -->
                    <div class="md:col-span-2 border-b pb-2 mb-2 mt-2">
                        <h4 class="text-sm font-semibold text-gray-500 uppercase">Profil Guru</h4>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">NIP</label>
                        <input type="text" name="nip" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 border p-2">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Nama Lengkap</label>
                        <input type="text" name="nama_lengkap" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 border p-2">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Gelar Depan</label>
                        <input type="text" name="gelar_depan" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 border p-2">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Gelar Belakang</label>
                        <input type="text" name="gelar_belakang" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 border p-2">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">No. HP</label>
                        <input type="text" name="no_hp" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 border p-2">
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700">Alamat</label>
                        <textarea name="alamat" rows="2" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 border p-2"></textarea>
                    </div>
                </div>
                <div class="mt-6 flex justify-end gap-3">
                    <button type="button" onclick="document.getElementById('addGuruModal').classList.add('hidden')" class="bg-gray-200 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-300 transition-colors">Batal</button>
                    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors">Simpan</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Edit Guru Modal -->
    <div id="editGuruModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
        <div class="relative top-10 mx-auto p-5 border w-full max-w-2xl shadow-lg rounded-md bg-white">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-xl font-bold text-gray-900">Edit Data Guru</h3>
                <button onclick="document.getElementById('editGuruModal').classList.add('hidden')" class="text-gray-400 hover:text-gray-500">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <form id="editGuruForm" method="POST">
                @csrf
                @method('PUT')
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <!-- Akun Info -->
                    <div class="md:col-span-2 border-b pb-2 mb-2">
                        <h4 class="text-sm font-semibold text-gray-500 uppercase">Informasi Akun</h4>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Email</label>
                        <input type="email" id="edit_email" name="email" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 border p-2">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Password (Kosongkan jika tidak diubah)</label>
                        <input type="password" name="password" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 border p-2">
                    </div>

                    <!-- Profil Guru -->
                    <div class="md:col-span-2 border-b pb-2 mb-2 mt-2">
                        <h4 class="text-sm font-semibold text-gray-500 uppercase">Profil Guru</h4>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">NIP</label>
                        <input type="text" id="edit_nip" name="nip" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 border p-2">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Nama Lengkap</label>
                        <input type="text" id="edit_nama_lengkap" name="nama_lengkap" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 border p-2">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Gelar Depan</label>
                        <input type="text" id="edit_gelar_depan" name="gelar_depan" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 border p-2">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Gelar Belakang</label>
                        <input type="text" id="edit_gelar_belakang" name="gelar_belakang" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 border p-2">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">No. HP</label>
                        <input type="text" id="edit_no_hp" name="no_hp" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 border p-2">
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700">Alamat</label>
                        <textarea id="edit_alamat" name="alamat" rows="2" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 border p-2"></textarea>
                    </div>
                    <div class="md:col-span-2">
                         <label class="inline-flex items-center cursor-pointer">
                            <input type="checkbox" id="edit_is_active" name="is_active" value="1" class="sr-only peer">
                            <div class="relative w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                            <span class="ms-3 text-sm font-medium text-gray-900">Status Aktif</span>
                        </label>
                    </div>
                </div>
                <div class="mt-6 flex justify-end gap-3">
                    <button type="button" onclick="document.getElementById('editGuruModal').classList.add('hidden')" class="bg-gray-200 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-300 transition-colors">Batal</button>
                    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function openEditModal(guru, user) {
            let url = "{{ route('admin.guru.update', ':id') }}";
            url = url.replace(':id', guru.id);
            document.getElementById('editGuruForm').action = url;
            
            document.getElementById('edit_email').value = user.email;
            document.getElementById('edit_nip').value = guru.nip;
            document.getElementById('edit_nama_lengkap').value = guru.nama_lengkap;
            document.getElementById('edit_gelar_depan').value = guru.gelar_depan || '';
            document.getElementById('edit_gelar_belakang').value = guru.gelar_belakang || '';
            document.getElementById('edit_no_hp').value = guru.no_hp || '';
            document.getElementById('edit_alamat').value = guru.alamat || '';
            document.getElementById('edit_is_active').checked = guru.is_active;

            document.getElementById('editGuruModal').classList.remove('hidden');
        }

        // Close modals on click outside
        window.onclick = function(event) {
            let addModal = document.getElementById('addGuruModal');
            let editModal = document.getElementById('editGuruModal');
            if (event.target == addModal) {
                addModal.classList.add('hidden');
            }
            if (event.target == editModal) {
                editModal.classList.add('hidden');
            }
        }
    </script>
@endsection
