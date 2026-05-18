@extends('layouts.admin')

@section('title', 'Konfigurasi Akun')
@section('header', 'Konfigurasi Akun')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-white rounded-2xl shadow-xl overflow-hidden border border-gray-100">
        <div class="p-8 md:p-12">
            <div class="flex items-center gap-6 mb-8">
                <div class="w-20 h-20 rounded-2xl bg-gradient-to-br from-blue-500 to-indigo-600 flex items-center justify-center shadow-lg shadow-blue-500/30">
                    <i class="fas fa-user-cog text-3xl text-white"></i>
                </div>
                <div>
                    <h2 class="text-2xl font-bold text-gray-800">Profil Admin</h2>
                    <p class="text-gray-500 mt-1">Kelola informasi akun dan keamanan Anda</p>
                </div>
            </div>

            <form action="{{ route('admin.profile.update') }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="grid gap-8 md:grid-cols-2">
                    <!-- Informasi Akun -->
                    <div class="space-y-6">
                        <h3 class="text-lg font-semibold text-gray-700 border-b pb-2">Informasi Login</h3>
                        
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Nama Pengguna</label>
                            <input type="text" value="{{ Auth::user()->name }}" disabled class="w-full px-4 py-3 rounded-xl border-gray-200 bg-gray-50 text-gray-500 cursor-not-allowed">
                            <p class="text-xs text-gray-400 mt-1">*Nama pengguna tidak dapat diubah</p>
                        </div>

                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Alamat Email</label>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 pl-4 flex items-center text-gray-400">
                                    <i class="fas fa-envelope"></i>
                                </span>
                                <input type="email" name="email" id="email" value="{{ Auth::user()->email }}" required 
                                    class="w-full pl-11 pr-4 py-3 rounded-xl border-gray-200 focus:border-blue-500 focus:ring-blue-500 transition-colors shadow-sm"
                                    placeholder="nama@sekolah.sch.id">
                            </div>
                        </div>
                    </div>

                    <!-- Keamanan -->
                    <div class="space-y-6">
                        <h3 class="text-lg font-semibold text-gray-700 border-b pb-2">Keamanan</h3>
                        
                        <div>
                            <label for="password" class="block text-sm font-medium text-gray-700 mb-2">Password Baru</label>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 pl-4 flex items-center text-gray-400">
                                    <i class="fas fa-lock"></i>
                                </span>
                                <input type="password" name="password" id="password" 
                                    class="w-full pl-11 pr-4 py-3 rounded-xl border-gray-200 focus:border-blue-500 focus:ring-blue-500 transition-colors shadow-sm"
                                    placeholder="Kosongkan jika tidak diubah">
                            </div>
                        </div>

                        <div>
                            <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">Konfirmasi Password</label>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 pl-4 flex items-center text-gray-400">
                                    <i class="fas fa-check-circle"></i>
                                </span>
                                <input type="password" name="password_confirmation" id="password_confirmation" 
                                    class="w-full pl-11 pr-4 py-3 rounded-xl border-gray-200 focus:border-blue-500 focus:ring-blue-500 transition-colors shadow-sm"
                                    placeholder="Ulangi password baru">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mt-10 flex items-center justify-end gap-4 border-t border-gray-100 pt-6">
                    <button type="button" onclick="window.history.back()" class="px-6 py-2.5 rounded-xl text-gray-600 hover:bg-gray-100 font-medium transition-colors">
                        Batal
                    </button>
                    <button type="submit" class="px-6 py-2.5 rounded-xl bg-gradient-to-r from-blue-600 to-indigo-600 text-white font-semibold shadow-lg shadow-blue-500/30 hover:shadow-blue-500/50 transform hover:-translate-y-0.5 transition-all">
                        <i class="fas fa-save mr-2"></i> Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
