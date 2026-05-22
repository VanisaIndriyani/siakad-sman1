@extends('layouts.siswa')

@section('title', 'Pengumuman')
@section('header', 'Pengumuman Sekolah')

@section('content')
<div class="space-y-6">
    <div class="bg-white rounded-xl border border-gray-100 card-shadow p-6">
        <h3 class="font-bold text-gray-800 text-lg mb-6">Informasi & Pengumuman Terbaru</h3>
        
        <div class="space-y-6">
            @forelse($pengumumans as $pengumuman)
                <div class="border-l-4 border-blue-500 pl-4 py-1 hover:bg-gray-50 transition-colors rounded-r-lg">
                    <div class="flex justify-between items-start">
                        <h4 class="font-bold text-gray-800 text-lg">{{ $pengumuman->judul }}</h4>
                        <span class="text-xs text-gray-500 bg-gray-100 px-2 py-1 rounded">{{ $pengumuman->created_at->format('d M Y') }}</span>
                    </div>
                    <p class="text-gray-600 mt-2">{{ $pengumuman->isi }}</p>
                    @if($pengumuman->file_path)
                        <div class="mt-4 pt-4 border-t border-gray-100 flex items-center justify-between">
                            <a href="{{ route('pengumuman.lampiran', $pengumuman->id) }}" target="_blank" class="inline-flex items-center text-sm font-bold text-blue-600 hover:text-blue-800 group/link">
                                <div class="w-8 h-8 rounded-lg bg-blue-50 flex items-center justify-center mr-3 group-hover/link:bg-blue-100 transition-colors">
                                    <i class="fas fa-file-pdf"></i>
                                </div>
                                <span>Lampiran Pengumuman (PDF)</span>
                            </a>
                            <a href="{{ route('pengumuman.lampiran.download', $pengumuman->id) }}" class="text-xs font-bold text-gray-400 hover:text-blue-600 transition-colors uppercase tracking-widest flex items-center gap-2">
                                <i class="fas fa-download"></i> Unduh
                            </a>
                        </div>
                    @endif
                </div>
            @empty
                <div class="text-center py-12">
                    <div class="bg-gray-50 rounded-full w-16 h-16 flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-bullhorn text-gray-400 text-2xl"></i>
                    </div>
                    <p class="text-gray-500">Tidak ada pengumuman saat ini.</p>
                </div>
            @endforelse
        </div>

        <div class="mt-6">
            {{ $pengumumans->links() }}
        </div>
    </div>
</div>
@endsection
