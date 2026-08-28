@php
    $user = Auth::user();
    $unreadCount = $user ? $user->unread_count : 0;
@endphp

<div class="relative notification-dropdown-container">
    <button class="notification-toggle w-10 h-10 flex items-center justify-center rounded-xl bg-slate-50 text-slate-400 hover:bg-emerald-50 hover:text-emerald-600 transition-all border border-slate-100 relative focus:outline-none">
        <i class="fas fa-bell text-lg"></i>
        @if($unreadCount > 0)
            <span class="absolute -top-1 -right-1 min-w-[20px] h-5 flex items-center justify-center px-1 text-[10px] font-bold text-white bg-red-500 border-2 border-white rounded-full shadow-md">
                {{ $unreadCount > 9 ? '9+' : $unreadCount }}
            </span>
        @endif
    </button>

    <div class="notification-panel hidden absolute right-0 mt-2 w-80 md:w-96 bg-white rounded-2xl shadow-2xl border border-slate-100 z-50 overflow-hidden">
        <div class="bg-gradient-to-r from-emerald-600 to-blue-600 px-4 py-3 flex items-center justify-between">
            <div>
                <h3 class="font-bold text-white text-sm">Notifikasi</h3>
                <p class="text-[10px] text-emerald-50 font-medium">{{ $unreadCount }} belum dibaca</p>
            </div>
            @if($unreadCount > 0)
            <form action="{{ route('notifikasi.mark_all_read') }}" method="POST" class="inline">
                @csrf
                <button type="submit" class="text-[10px] font-bold text-white/90 hover:text-white bg-white/10 hover:bg-white/20 px-2 py-1 rounded-lg transition-all">
                    Tandai Semua
                </button>
            </form>
            @endif
        </div>

        <div class="notification-list max-h-80 overflow-y-auto custom-scrollbar">
            <div class="py-8 text-center text-slate-400 text-sm">
                <i class="fas fa-spinner fa-spin text-lg mb-2"></i>
                <p>Memuat notifikasi...</p>
            </div>
        </div>

        <div class="border-t border-slate-100 px-4 py-2.5 bg-slate-50/50">
            <a href="{{ route('notifikasi.index') }}" class="block text-center text-xs font-bold text-emerald-600 hover:text-emerald-700 transition-colors py-1.5 hover:bg-emerald-50 rounded-lg">
                Lihat Semua Notifikasi <i class="fas fa-arrow-right ml-1 text-[10px]"></i>
            </a>
        </div>
    </div>
</div>

<script>
    (function() {
        const containers = document.querySelectorAll('.notification-dropdown-container');
        let loaded = false;

        const readRouteTpl = "{{ str_replace('__ID__', ':id', route('notifikasi.read', '__ID__')) }}";
        const latestJsonUrl = "{{ route('notifikasi.latest.json') }}";

        function csrfToken() {
            const meta = document.querySelector('meta[name="csrf-token"]');
            if (meta) return meta.getAttribute('content');
            const inp = document.querySelector('input[name="_token"]');
            return inp ? inp.value : '';
        }

        function updateBadge(unreadCount) {
            containers.forEach(container => {
                const badge = container.querySelector('.notification-toggle > span');
                if (badge) {
                    if (unreadCount > 0) {
                        badge.textContent = unreadCount > 9 ? '9+' : String(unreadCount);
                        badge.style.display = 'flex';
                    } else {
                        badge.style.display = 'none';
                    }
                }
                const headerCount = container.querySelector('.notification-panel > div:first-child > div > p');
                if (headerCount) {
                    headerCount.textContent = unreadCount + ' belum dibaca';
                }
                const globalMarkBtn = container.querySelector('form button[type="submit"]');
                if (globalMarkBtn) {
                    globalMarkBtn.closest('form').style.display = unreadCount > 0 ? '' : 'none';
                }
            });
        }

        containers.forEach(container => {
            const toggle = container.querySelector('.notification-toggle');
            const panel = container.querySelector('.notification-panel');
            const listEl = container.querySelector('.notification-list');

            function closeAll(exclude) {
                document.querySelectorAll('.notification-dropdown-container').forEach(c => {
                    if (c !== exclude) {
                        c.querySelector('.notification-panel').classList.add('hidden');
                    }
                });
            }

            toggle.addEventListener('click', function(e) {
                e.stopPropagation();
                closeAll(container);
                panel.classList.toggle('hidden');

                if (!panel.classList.contains('hidden') && !loaded) {
                    loadNotif(listEl);
                    loaded = true;
                }
            });
        });

        document.addEventListener('click', function(e) {
            if (!e.target.closest('.notification-dropdown-container')) {
                document.querySelectorAll('.notification-panel').forEach(p => p.classList.add('hidden'));
            }
        });

        function markReadThenGo(notifId, url) {
            const payload = new URLSearchParams();
            payload.append('_token', csrfToken());
            fetch(readRouteTpl.replace(':id', notifId), {
                method: 'POST',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json',
                    'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8',
                },
                credentials: 'same-origin',
                body: payload.toString(),
            }).then(() => {
                fetch(latestJsonUrl + '?_=' + Date.now(), {
                    headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' },
                    credentials: 'same-origin',
                }).then(r => r.json()).then(data => {
                    updateBadge(data.unread_count || 0);
                }).finally(() => {
                    if (url && url !== '#') {
                        window.location.href = url;
                    } else {
                        window.location.reload();
                    }
                });
            }).catch(() => {
                if (url && url !== '#') {
                    window.location.href = url;
                }
            });
        }

        function loadNotif(listEl) {
            fetch(latestJsonUrl, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json',
                },
                credentials: 'same-origin',
            })
            .then(r => r.json())
            .then(data => {
                const notifs = data.notifications || [];
                updateBadge(data.unread_count || 0);
                if (notifs.length === 0) {
                    listEl.innerHTML = `
                        <div class="py-12 text-center text-slate-400">
                            <i class="fas fa-inbox text-3xl mb-3 opacity-50"></i>
                            <p class="text-sm font-medium">Belum ada notifikasi</p>
                        </div>
                    `;
                } else {
                    const typeColors = {
                        success: 'bg-emerald-100 text-emerald-600',
                        danger: 'bg-red-100 text-red-600',
                        warning: 'bg-amber-100 text-amber-600',
                        info: 'bg-blue-100 text-blue-600',
                    };
                    listEl.innerHTML = notifs.map(n => {
                        const color = typeColors[n.type] || typeColors.info;
                        const icon = n.icon || 'fa-bell';
                        const url = n.url ? n.url : '';
                        const clickHandler = url
                            ? `event.preventDefault(); markReadThenGo(${n.id}, ${JSON.stringify(url)});`
                            : `event.preventDefault(); markReadThenGo(${n.id}, '');`;
                        return `
                            <a href="${url || '#'}" data-notif-id="${n.id}" data-is-read="${n.is_read ? '1' : '0'}" class="notif-item flex items-start gap-3 px-4 py-3 hover:bg-slate-50 transition-colors border-b border-slate-50 ${!n.is_read ? 'bg-emerald-50/40' : ''}" onclick="${clickHandler}">
                                <div class="w-9 h-9 rounded-xl ${color} flex items-center justify-center flex-shrink-0">
                                    <i class="fas ${icon} text-sm"></i>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <div class="flex items-start justify-between gap-2">
                                        <p class="text-xs font-bold text-slate-800 leading-tight">${n.title}</p>
                                        ${!n.is_read ? '<span class="w-2 h-2 rounded-full bg-emerald-500 flex-shrink-0 mt-1"></span>' : ''}
                                    </div>
                                    <p class="text-[11px] text-slate-500 mt-0.5 line-clamp-2">${n.message}</p>
                                    <p class="text-[10px] text-slate-400 mt-1 font-medium">${n.time_ago}</p>
                                </div>
                            </a>
                        `;
                    }).join('');
                }
            })
            .catch(() => {
                listEl.innerHTML = `
                    <div class="py-8 text-center text-red-400 text-sm">
                        <i class="fas fa-exclamation-circle mb-2"></i>
                        <p>Gagal memuat notifikasi</p>
                    </div>
                `;
            });
        }

        window.__markReadThenGoNotif = markReadThenGo;
        window.__updateNotifBadge = updateBadge;
    })();
</script>
