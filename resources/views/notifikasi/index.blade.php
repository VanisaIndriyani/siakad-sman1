@extends($layout)

@section('title', 'Notifikasi')
@section('header', 'Pusat Notifikasi')

@section('content')
    <div class="card-modern overflow-hidden mb-6">
        <div class="p-6 border-b border-slate-100 bg-gradient-to-r from-emerald-50 to-amber-50/50">
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                <div class="flex items-center gap-4">
                    <div class="relative">
                        <div class="w-14 h-14 rounded-2xl bg-white flex items-center justify-center shadow-sm">
                            <i class="fas fa-bell text-emerald-600 text-xl"></i>
                        </div>
                        @if($unreadCount > 0)
                            <span class="absolute -top-1 -right-1 w-6 h-6 rounded-full bg-red-500 text-white text-xs font-bold flex items-center justify-center border-2 border-white">{{ $unreadCount }}</span>
                        @endif
                    </div>
                    <div>
                        <h2 class="text-xl font-bold text-slate-800">Notifikasi Saya</h2>
                        <p class="text-sm text-slate-500">{{ $unreadCount }} belum dibaca dari total {{ $notifikasis->total() }} notifikasi</p>
                    </div>
                </div>
                <div class="flex flex-wrap gap-2">
                    @if($unreadCount > 0)
                        <form action="{{ route('notifikasi.mark_all_read') }}" method="POST" class="inline">
                            @csrf
                            <button type="submit" class="inline-flex items-center px-4 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl text-xs font-bold transition-all shadow-sm">
                                <i class="fas fa-check-double mr-2"></i>Tandai Semua Dibaca
                            </button>
                        </form>
                    @endif
                    @if($notifikasis->total() > 0)
                        <form action="{{ route('notifikasi.destroy_all') }}" method="POST" class="inline" onsubmit="return confirm('Yakin ingin menghapus semua notifikasi?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="inline-flex items-center px-4 py-2.5 bg-red-50 hover:bg-red-100 text-red-600 rounded-xl text-xs font-bold transition-all border border-red-100">
                                <i class="fas fa-trash mr-2"></i>Hapus Semua
                            </button>
                        </form>
                    @endif
                </div>
            </div>
        </div>

        <form action="{{ route('notifikasi.index') }}" method="GET" class="p-6 border-b border-slate-100 bg-slate-50/50 flex flex-col md:flex-row gap-4">
            <div class="relative flex-1">
                <i class="fas fa-search absolute left-4 top-1/2 -translate-y-1/2 text-slate-400"></i>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari notifikasi..." class="w-full pl-12 pr-4 py-3 bg-white border border-slate-200 rounded-xl focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 transition-all outline-none text-sm font-medium">
            </div>
            <div class="flex flex-col sm:flex-row gap-3">
                <select name="type" onchange="this.form.submit()" class="border border-slate-200 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 bg-white font-medium">
                    <option value="">Semua Tipe</option>
                    <option value="info" {{ request('type') == 'info' ? 'selected' : '' }}>Info</option>
                    <option value="success" {{ request('type') == 'success' ? 'selected' : '' }}>Success</option>
                    <option value="warning" {{ request('type') == 'warning' ? 'selected' : '' }}>Warning</option>
                    <option value="danger" {{ request('type') == 'danger' ? 'selected' : '' }}>Danger</option>
                </select>
                <select name="read" onchange="this.form.submit()" class="border border-slate-200 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 bg-white font-medium">
                    <option value="">Semua Status</option>
                    <option value="unread" {{ request('read') == 'unread' ? 'selected' : '' }}>Belum Dibaca</option>
                    <option value="read" {{ request('read') == 'read' ? 'selected' : '' }}>Sudah Dibaca</option>
                </select>
                <button type="submit" class="bg-emerald-600 hover:bg-emerald-700 text-white px-6 py-3 rounded-xl text-sm font-bold transition-colors shadow-lg shadow-emerald-500/20">
                    <i class="fas fa-filter mr-2"></i>Filter
                </button>
            </div>
        </form>
    </div>

    <div class="space-y-4">
        @forelse($notifikasis as $notif)
            @php
                $typeColors = match($notif->type) {
                    'success' => ['bg-emerald-100', 'text-emerald-700', 'border-emerald-200', 'fa-check-circle'],
                    'warning' => ['bg-amber-100', 'text-amber-700', 'border-amber-200', 'fa-exclamation-triangle'],
                    'danger' => ['bg-red-100', 'text-red-700', 'border-red-200', 'fa-times-circle'],
                    default => ['bg-blue-100', 'text-blue-700', 'border-blue-200', 'fa-info-circle'],
                };
                $isUnread = !$notif->is_read;
            @endphp
            <div class="card-modern p-5 relative transition-all {{ $isUnread ? 'bg-emerald-50/50 border-emerald-100' : '' }}">
                @if($isUnread)
                    <span class="absolute top-5 right-5 w-3 h-3 rounded-full bg-emerald-500 shadow-sm shadow-emerald-300"></span>
                @endif
                <div class="flex gap-4">
                    <div class="flex-shrink-0">
                        <div class="w-12 h-12 rounded-2xl {{ $typeColors[0] }} flex items-center justify-center border {{ $typeColors[2] }}">
                            <i class="fas {{ $typeColors[3] }} {{ $typeColors[1] }} text-lg"></i>
                        </div>
                    </div>
                    <div class="flex-1 min-w-0">
                        <div class="flex flex-wrap items-start justify-between gap-2 mb-2">
                            <div class="flex items-center gap-2 flex-wrap">
                                <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-[10px] font-bold uppercase tracking-wider {{ $typeColors[0] }} {{ $typeColors[1] }}">
                                    {{ $notif->type }}
                                </span>
                                <span class="text-xs text-slate-500 font-medium">
                                    <i class="fas fa-clock mr-1"></i>{{ $notif->created_at->diffForHumans() }}
                                </span>
                            </div>
                            <form action="{{ route('notifikasi.destroy', $notif->id) }}" method="POST" class="inline" onsubmit="return confirm('Hapus notifikasi ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-slate-400 hover:text-red-500 p-1.5 rounded-lg hover:bg-red-50 transition-all">
                                    <i class="fas fa-trash-alt text-xs"></i>
                                </button>
                            </form>
                        </div>
                        @if($notif->url)
                            <a href="{{ route('notifikasi.show', $notif->id) }}" class="block group">
                                <h4 class="font-bold text-slate-800 mb-1 group-hover:text-emerald-600 transition-colors">{{ $notif->title }}</h4>
                                <p class="text-sm text-slate-600 line-clamp-2">{{ $notif->message }}</p>
                                <span class="inline-flex items-center mt-2 text-xs font-bold text-emerald-600 group-hover:translate-x-1 transition-transform">
                                    Buka detail <i class="fas fa-arrow-right ml-1.5"></i>
                                </span>
                            </a>
                        @else
                            <h4 class="font-bold text-slate-800 mb-1">{{ $notif->title }}</h4>
                            <p class="text-sm text-slate-600">{{ $notif->message }}</p>
                            @if($isUnread)
                                <form action="{{ route('notifikasi.read', $notif->id) }}" method="POST" class="inline mt-2">
                                    @csrf
                                    <button type="submit" class="inline-flex items-center text-xs font-bold text-emerald-600 hover:text-emerald-700">
                                        <i class="fas fa-check mr-1"></i>Tandai dibaca
                                    </button>
                                </form>
                            @endif
                        @endif
                    </div>
                </div>
            </div>
        @empty
            <div class="card-modern p-16 text-center">
                <div class="w-24 h-24 rounded-3xl bg-slate-100 flex items-center justify-center mx-auto mb-6">
                    <i class="fas fa-bell-slash text-slate-400 text-4xl"></i>
                </div>
                <h3 class="text-lg font-bold text-slate-800 mb-2">Belum ada notifikasi</h3>
                <p class="text-sm text-slate-500">Tidak ada notifikasi yang ditemukan untuk filter Anda.</p>
            </div>
        @endforelse
    </div>

    <div class="mt-8">
        {{ $notifikasis->appends(request()->query())->links('pagination.number-123') }}
    </div>
@endsection
