@extends('layouts.admin')

@section('title', 'Data Siswa')
@section('header', 'Manajemen Siswa')

@section('content')
    <div class="bg-white rounded-xl border border-gray-100 card-shadow overflow-hidden">
        <div class="p-6 border-b border-gray-100 flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
            <h3 class="font-bold text-gray-800">Daftar Siswa</h3>
            <div class="flex flex-wrap gap-2 w-full md:w-auto">
                <a href="{{ route('admin.siswa.template') }}" class="flex-1 md:flex-none justify-center bg-gray-200 hover:bg-gray-300 text-gray-800 font-medium py-2 px-4 rounded-lg shadow-sm transition-colors text-xs md:text-sm flex items-center">
                    <i class="fas fa-download mr-2"></i> <span class="whitespace-nowrap">Template</span>
                </a>
                <button onclick="document.getElementById('importModal').classList.remove('hidden')" class="flex-1 md:flex-none justify-center bg-green-600 hover:bg-green-700 text-white font-medium py-2 px-4 rounded-lg shadow-sm transition-colors text-xs md:text-sm flex items-center">
                    <i class="fas fa-file-import mr-2"></i> <span class="whitespace-nowrap">Import</span>
                </button>
                <button onclick="document.getElementById('addSiswaModal').classList.remove('hidden')" class="flex-1 md:flex-none justify-center bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-lg shadow-sm transition-colors text-xs md:text-sm flex items-center">
                    <i class="fas fa-plus mr-2"></i> <span class="whitespace-nowrap">Tambah</span>
                </button>
            </div>
        </div>
        
        <!-- Filter/Search -->
        <form action="{{ route('admin.siswa.index') }}" method="GET" class="p-4 bg-gray-50 border-b border-gray-100 flex flex-col md:flex-row gap-4">
            <div class="relative flex-1">
                <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari NISN, NIS, atau Nama..." class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm">
            </div>
            <div class="grid grid-cols-2 md:flex gap-2">
                <select name="tingkat" onchange="this.form.submit()" class="border border-gray-300 rounded-lg px-4 py-2 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white">
                    <option value="">Semua Tingkat</option>
                    <option value="10" {{ request('tingkat') == '10' ? 'selected' : '' }}>Kelas X</option>
                    <option value="11" {{ request('tingkat') == '11' ? 'selected' : '' }}>Kelas XI</option>
                    <option value="12" {{ request('tingkat') == '12' ? 'selected' : '' }}>Kelas XII</option>
                </select>
                <select name="jurusan" onchange="this.form.submit()" class="border border-gray-300 rounded-lg px-4 py-2 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white">
                    <option value="">Semua Jurusan</option>
                    <option value="IPA" {{ request('jurusan') == 'IPA' ? 'selected' : '' }}>IPA</option>
                    <option value="IPS" {{ request('jurusan') == 'IPS' ? 'selected' : '' }}>IPS</option>
                    <option value="BAHASA" {{ request('jurusan') == 'BAHASA' ? 'selected' : '' }}>BAHASA</option>
                </select>
            </div>
        </form>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-50 text-gray-600 text-xs uppercase tracking-wider">
                        <th class="p-4 font-semibold">Siswa</th>
                        <th class="p-4 font-semibold">NISN / NIS</th>
                        <th class="p-4 font-semibold">Kelas</th>
                        <th class="p-4 font-semibold">Jenis Kelamin</th>
                        <th class="p-4 font-semibold text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 text-sm">
                    @forelse($siswas as $siswa)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="p-4 flex items-center">
                            <img src="https://ui-avatars.com/api/?name={{ urlencode($siswa->nama_lengkap) }}&background=random" class="w-10 h-10 rounded-full mr-3" alt="Avatar">
                            <div>
                                <div class="font-medium text-gray-800">{{ $siswa->nama_lengkap }}</div>
                                <div class="text-xs text-gray-500">{{ $siswa->alamat }}</div>
                            </div>
                        </td>
                        <td class="p-4 text-gray-600">{{ $siswa->nisn }} <br> <span class="text-xs text-gray-400">{{ $siswa->nis }}</span></td>
                        <td class="p-4"><span class="bg-blue-100 text-blue-700 px-2 py-1 rounded text-xs font-semibold">{{ $siswa->kelas ? $siswa->kelas->nama_kelas : 'Belum Masuk Kelas' }}</span></td>
                        <td class="p-4">{{ $siswa->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}</td>
                        <td class="p-4 text-center">
                            <div class="flex items-center justify-center gap-2">
                                <a href="{{ route('admin.siswa.cetak_kartu', $siswa->id) }}" target="_blank" class="text-purple-600 hover:text-purple-800 bg-purple-50 hover:bg-purple-100 px-2 py-2 rounded-lg text-sm transition-colors shadow-sm" title="Cetak Kartu">
                                    <i class="fas fa-id-card"></i>
                                </a>
                                <a href="{{ route('admin.siswa.show', $siswa->id) }}" class="text-blue-600 hover:text-blue-800 bg-blue-50 hover:bg-blue-100 px-2 py-2 rounded-lg text-sm transition-colors shadow-sm" title="Detail">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <button onclick='openEditModal(@json($siswa), @json($siswa->user))' class="text-yellow-600 hover:text-yellow-800 bg-yellow-50 hover:bg-yellow-100 px-2 py-2 rounded-lg text-sm transition-colors shadow-sm" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <form action="{{ route('admin.siswa.destroy', $siswa->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data siswa ini? Data user terkait juga akan dihapus.')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-800 bg-red-50 hover:bg-red-100 px-2 py-2 rounded-lg text-sm transition-colors shadow-sm" title="Hapus">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="p-4 text-center text-gray-500">
                            @if(request('search'))
                                Tidak ada data siswa yang cocok dengan pencarian "{{ request('search') }}".
                            @else
                                Belum ada data siswa.
                            @endif
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <!-- Pagination -->
        <div class="p-4 border-t border-gray-100">
            {{ $siswas->appends(request()->query())->links('pagination.number-123') }}
        </div>
    </div>

    <!-- Import Modal -->
    <div id="importModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-[60]">
        <div class="relative top-20 mx-auto p-5 border w-full max-w-md shadow-lg rounded-xl bg-white">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-bold text-gray-900">Import Data Siswa</h3>
                <button onclick="document.getElementById('importModal').classList.add('hidden')" class="text-gray-400 hover:text-gray-500">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <form action="{{ route('admin.siswa.import') }}" method="POST" enctype="multipart/form-data">
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

    <!-- Add Siswa Modal -->
    <div id="addSiswaModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
        <div class="relative top-5 mx-auto p-5 border w-full max-w-4xl shadow-lg rounded-md bg-white">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-xl font-bold text-gray-900">Tambah Siswa Baru</h3>
                <button onclick="document.getElementById('addSiswaModal').classList.add('hidden')" class="text-gray-400 hover:text-gray-500">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <form action="{{ route('admin.siswa.store') }}" method="POST">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <!-- Data Akademik -->
                    <div class="md:col-span-2 border-b pb-2 mb-2">
                        <h4 class="text-sm font-semibold text-gray-500 uppercase">Data Akademik & Akun</h4>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">NISN *</label>
                        <input type="text" name="nisn" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 border p-2">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">NIS</label>
                        <input type="text" name="nis" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 border p-2">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Kelas</label>
                        <select name="kelas_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 border p-2">
                            <option value="">Pilih Kelas</option>
                            @foreach($kelases as $kelas)
                                <option value="{{ $kelas->id }}">{{ $kelas->nama_kelas }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Email (Opsional)</label>
                        <input type="email" name="email" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 border p-2">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Password *</label>
                        <input type="password" name="password" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 border p-2">
                    </div>

                    <!-- Data Pribadi -->
                    <div class="md:col-span-2 border-b pb-2 mb-2 mt-2">
                        <h4 class="text-sm font-semibold text-gray-500 uppercase">Data Pribadi</h4>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Nama Lengkap *</label>
                        <input type="text" name="nama_lengkap" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 border p-2">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Jenis Kelamin *</label>
                        <select name="jenis_kelamin" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 border p-2">
                            <option value="L">Laki-laki</option>
                            <option value="P">Perempuan</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Tempat Lahir</label>
                        <input type="text" name="tempat_lahir" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 border p-2">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Tanggal Lahir</label>
                        <input type="date" name="tanggal_lahir" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 border p-2">
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700">Alamat</label>
                        <textarea name="alamat" rows="2" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 border p-2"></textarea>
                    </div>

                    <!-- Data Orang Tua -->
                    <div class="md:col-span-2 border-b pb-2 mb-2 mt-2">
                        <h4 class="text-sm font-semibold text-gray-500 uppercase">Data Orang Tua</h4>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Nama Ayah</label>
                        <input type="text" name="nama_ayah" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 border p-2">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Nama Ibu</label>
                        <input type="text" name="nama_ibu" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 border p-2">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">No HP Orang Tua</label>
                        <input type="text" name="no_hp_ortu" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 border p-2">
                    </div>
                </div>
                <div class="mt-6 flex justify-end gap-3">
                    <button type="button" onclick="document.getElementById('addSiswaModal').classList.add('hidden')" class="bg-gray-200 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-300 transition-colors">Batal</button>
                    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors">Simpan</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Edit Siswa Modal -->
    <div id="editSiswaModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
        <div class="relative top-5 mx-auto p-5 border w-full max-w-4xl shadow-lg rounded-md bg-white">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-xl font-bold text-gray-900">Edit Data Siswa</h3>
                <button onclick="document.getElementById('editSiswaModal').classList.add('hidden')" class="text-gray-400 hover:text-gray-500">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <form id="editSiswaForm" method="POST">
                @csrf
                @method('PUT')
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <!-- Data Akademik -->
                    <div class="md:col-span-2 border-b pb-2 mb-2">
                        <h4 class="text-sm font-semibold text-gray-500 uppercase">Data Akademik & Akun</h4>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">NISN *</label>
                        <input type="text" id="edit_nisn" name="nisn" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 border p-2">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">NIS</label>
                        <input type="text" id="edit_nis" name="nis" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 border p-2">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Kelas</label>
                        <select id="edit_kelas_id" name="kelas_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 border p-2">
                            <option value="">Pilih Kelas</option>
                            @foreach($kelases as $kelas)
                                <option value="{{ $kelas->id }}">{{ $kelas->nama_kelas }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Email</label>
                        <input type="email" id="edit_email" name="email" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 border p-2">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Password (Kosongkan jika tidak diubah)</label>
                        <input type="password" name="password" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 border p-2">
                    </div>

                    <!-- Data Pribadi -->
                    <div class="md:col-span-2 border-b pb-2 mb-2 mt-2">
                        <h4 class="text-sm font-semibold text-gray-500 uppercase">Data Pribadi</h4>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Nama Lengkap *</label>
                        <input type="text" id="edit_nama_lengkap" name="nama_lengkap" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 border p-2">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Jenis Kelamin *</label>
                        <select id="edit_jenis_kelamin" name="jenis_kelamin" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 border p-2">
                            <option value="L">Laki-laki</option>
                            <option value="P">Perempuan</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Tempat Lahir</label>
                        <input type="text" id="edit_tempat_lahir" name="tempat_lahir" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 border p-2">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Tanggal Lahir</label>
                        <input type="date" id="edit_tanggal_lahir" name="tanggal_lahir" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 border p-2">
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700">Alamat</label>
                        <textarea id="edit_alamat" name="alamat" rows="2" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 border p-2"></textarea>
                    </div>

                    <!-- Data Orang Tua -->
                    <div class="md:col-span-2 border-b pb-2 mb-2 mt-2">
                        <h4 class="text-sm font-semibold text-gray-500 uppercase">Data Orang Tua</h4>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Nama Ayah</label>
                        <input type="text" id="edit_nama_ayah" name="nama_ayah" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 border p-2">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Nama Ibu</label>
                        <input type="text" id="edit_nama_ibu" name="nama_ibu" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 border p-2">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">No HP Orang Tua</label>
                        <input type="text" id="edit_no_hp_ortu" name="no_hp_ortu" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 border p-2">
                    </div>
                </div>
                <div class="mt-6 flex justify-end gap-3">
                    <button type="button" onclick="document.getElementById('editSiswaModal').classList.add('hidden')" class="bg-gray-200 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-300 transition-colors">Batal</button>
                    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function openEditModal(siswa, user) {
            let url = "{{ route('admin.siswa.update', ':id') }}";
            url = url.replace(':id', siswa.id);
            document.getElementById('editSiswaForm').action = url;
            
            document.getElementById('edit_nisn').value = siswa.nisn;
            document.getElementById('edit_nis').value = siswa.nis || '';
            document.getElementById('edit_kelas_id').value = siswa.kelas_id || '';
            document.getElementById('edit_email').value = user.email;
            document.getElementById('edit_nama_lengkap').value = siswa.nama_lengkap;
            document.getElementById('edit_jenis_kelamin').value = siswa.jenis_kelamin;
            document.getElementById('edit_tempat_lahir').value = siswa.tempat_lahir || '';
            document.getElementById('edit_tanggal_lahir').value = siswa.tanggal_lahir || '';
            document.getElementById('edit_alamat').value = siswa.alamat || '';
            document.getElementById('edit_nama_ayah').value = siswa.nama_ayah || '';
            document.getElementById('edit_nama_ibu').value = siswa.nama_ibu || '';
            document.getElementById('edit_no_hp_ortu').value = siswa.no_hp_ortu || '';

            document.getElementById('editSiswaModal').classList.remove('hidden');
        }

        // Close modals on click outside
        window.onclick = function(event) {
            let addModal = document.getElementById('addSiswaModal');
            let editModal = document.getElementById('editSiswaModal');
            if (event.target == addModal) {
                addModal.classList.add('hidden');
            }
            if (event.target == editModal) {
                editModal.classList.add('hidden');
            }
        }
    </script>
@endsection
