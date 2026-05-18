@extends('layouts.admin')

@section('title', 'Data Kelas')
@section('header', 'Manajemen Kelas')

@section('content')
    <div class="bg-white rounded-xl border border-gray-100 card-shadow overflow-hidden">
        <div class="p-6 border-b border-gray-100 flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
            <h3 class="font-bold text-gray-800">Daftar Kelas</h3>
            <button onclick="document.getElementById('addKelasModal').classList.remove('hidden')" class="w-full md:w-auto bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-lg shadow-sm transition-colors text-sm flex items-center justify-center">
                <i class="fas fa-plus mr-2"></i> Tambah Kelas
            </button>
        </div>
        
        <!-- Filter/Search -->
        <form action="{{ route('admin.kelas.index') }}" method="GET" class="p-4 bg-gray-50 border-b border-gray-100 flex flex-col md:flex-row gap-4">
            <div class="relative flex-1">
                <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari Nama Kelas..." class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm">
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
                        <th class="p-4 font-semibold">Nama Kelas</th>
                        <th class="p-4 font-semibold">Tingkat / Jurusan</th>
                        <th class="p-4 font-semibold">Wali Kelas</th>
                        <th class="p-4 font-semibold">Jumlah Siswa</th>
                        <th class="p-4 font-semibold text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 text-sm">
                    @forelse($kelases as $kelas)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="p-4 font-bold text-gray-800">{{ $kelas->nama_kelas }}</td>
                        <td class="p-4">
                            <span class="bg-gray-100 text-gray-800 px-2 py-1 rounded text-xs font-semibold mr-1">Kelas {{ $kelas->tingkat }}</span>
                            <span class="bg-blue-100 text-blue-800 px-2 py-1 rounded text-xs font-semibold">{{ $kelas->jurusan }}</span>
                        </td>
                        <td class="p-4">
                            @if($kelas->waliKelas)
                                {{ $kelas->waliKelas->gelar_depan }} {{ $kelas->waliKelas->nama_lengkap }} {{ $kelas->waliKelas->gelar_belakang }}
                            @else
                                <span class="text-gray-400 italic">Belum ada wali kelas</span>
                            @endif
                        </td>
                        <td class="p-4"><span class="bg-green-100 text-green-700 px-2 py-1 rounded-full text-xs">{{ $kelas->siswas_count }} Siswa</span></td>
                        <td class="p-4 text-center">
                            <a href="{{ route('admin.kelas.show', $kelas->id) }}" class="text-blue-600 hover:text-blue-800 mx-1"><i class="fas fa-eye"></i></a>
                            <button onclick='openEditModal(@json($kelas))' class="text-yellow-500 hover:text-yellow-700 mx-1"><i class="fas fa-edit"></i></button>
                            <form action="{{ route('admin.kelas.destroy', $kelas->id) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus kelas ini?')">
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
                                Tidak ada data kelas yang cocok dengan pencarian "{{ request('search') }}".
                            @else
                                Belum ada data kelas.
                            @endif
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <!-- Pagination -->
        <div class="p-4 border-t border-gray-100">
            {{ $kelases->appends(request()->query())->links() }}
        </div>
    </div>

    <!-- Add Kelas Modal -->
    <div id="addKelasModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
        <div class="relative top-20 mx-auto p-5 border w-full max-w-lg shadow-lg rounded-md bg-white">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-xl font-bold text-gray-900">Tambah Kelas Baru</h3>
                <button onclick="document.getElementById('addKelasModal').classList.add('hidden')" class="text-gray-400 hover:text-gray-500">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <form action="{{ route('admin.kelas.store') }}" method="POST">
                @csrf
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Nama Kelas *</label>
                        <input type="text" name="nama_kelas" required placeholder="Contoh: X IPA 1" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 border p-2">
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Tingkat *</label>
                            <select name="tingkat" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 border p-2">
                                <option value="10">Kelas X</option>
                                <option value="11">Kelas XI</option>
                                <option value="12">Kelas XII</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Jurusan *</label>
                            <select name="jurusan" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 border p-2">
                                <option value="IPA">IPA</option>
                                <option value="IPS">IPS</option>
                                <option value="BAHASA">BAHASA</option>
                            </select>
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Wali Kelas</label>
                        <select name="wali_kelas_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 border p-2">
                            <option value="">Pilih Wali Kelas...</option>
                            @foreach($gurus as $guru)
                                <option value="{{ $guru->id }}">{{ $guru->gelar_depan }} {{ $guru->nama_lengkap }} {{ $guru->gelar_belakang }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="mt-6 flex justify-end gap-3">
                    <button type="button" onclick="document.getElementById('addKelasModal').classList.add('hidden')" class="bg-gray-200 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-300 transition-colors">Batal</button>
                    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors">Simpan</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Edit Kelas Modal -->
    <div id="editKelasModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
        <div class="relative top-20 mx-auto p-5 border w-full max-w-lg shadow-lg rounded-md bg-white">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-xl font-bold text-gray-900">Edit Data Kelas</h3>
                <button onclick="document.getElementById('editKelasModal').classList.add('hidden')" class="text-gray-400 hover:text-gray-500">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <form id="editKelasForm" method="POST">
                @csrf
                @method('PUT')
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Nama Kelas *</label>
                        <input type="text" id="edit_nama_kelas" name="nama_kelas" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 border p-2">
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Tingkat *</label>
                            <select id="edit_tingkat" name="tingkat" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 border p-2">
                                <option value="10">Kelas X</option>
                                <option value="11">Kelas XI</option>
                                <option value="12">Kelas XII</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Jurusan *</label>
                            <select id="edit_jurusan" name="jurusan" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 border p-2">
                                <option value="IPA">IPA</option>
                                <option value="IPS">IPS</option>
                                <option value="BAHASA">BAHASA</option>
                            </select>
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Wali Kelas</label>
                        <select id="edit_wali_kelas_id" name="wali_kelas_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 border p-2">
                            <option value="">Pilih Wali Kelas...</option>
                            @foreach($gurus as $guru)
                                <option value="{{ $guru->id }}">{{ $guru->gelar_depan }} {{ $guru->nama_lengkap }} {{ $guru->gelar_belakang }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="mt-6 flex justify-end gap-3">
                    <button type="button" onclick="document.getElementById('editKelasModal').classList.add('hidden')" class="bg-gray-200 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-300 transition-colors">Batal</button>
                    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function openEditModal(kelas) {
            let url = "{{ route('admin.kelas.update', ':id') }}";
            url = url.replace(':id', kelas.id);
            document.getElementById('editKelasForm').action = url;
            
            document.getElementById('edit_nama_kelas').value = kelas.nama_kelas;
            document.getElementById('edit_tingkat').value = kelas.tingkat;
            document.getElementById('edit_jurusan').value = kelas.jurusan;
            document.getElementById('edit_wali_kelas_id').value = kelas.wali_kelas_id || '';
            
            document.getElementById('editKelasModal').classList.remove('hidden');
        }
    </script>
@endsection