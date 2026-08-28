<?php

namespace App\Http\Controllers;

use App\Models\Notifikasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotifikasiController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();

        $layoutMap = [
            'admin' => 'layouts.admin',
            'guru' => 'layouts.guru',
            'siswa' => 'layouts.siswa',
            'kepala_sekolah' => 'layouts.kepala_sekolah',
        ];
        $layout = $layoutMap[$user->role] ?? 'layouts.admin';

        $query = $user->notifikasis();

        if ($request->filled('search')) {
            $keyword = '%' . trim($request->search) . '%';
            $query->where(function ($q) use ($keyword) {
                $q->where('title', 'LIKE', $keyword)
                    ->orWhere('message', 'LIKE', $keyword);
            });
        }

        if ($request->has('type') && $request->type != '') {
            $query->where('type', $request->type);
        }

        if ($request->has('read') && $request->read != '') {
            if ($request->read === 'unread') {
                $query->where('is_read', false);
            } elseif ($request->read === 'read') {
                $query->where('is_read', true);
            }
        }

        $notifikasis = $query->latest()->paginate(20)->withQueryString();
        $unreadCount = $user->unread_count;

        return view('notifikasi.index', compact('notifikasis', 'unreadCount', 'layout'));
    }

    public function show($id)
    {
        $user = Auth::user();
        $notifikasi = $user->notifikasis()->findOrFail($id);

        if (! $notifikasi->is_read) {
            $notifikasi->update(['is_read' => true]);
        }

        if ($notifikasi->url) {
            return redirect()->to($notifikasi->url);
        }

        return back()->with('info', $notifikasi->message);
    }

    public function markAllAsRead()
    {
        $user = Auth::user();
        $user->markAllNotificationsAsRead();

        return back()->with('success', 'Semua notifikasi telah ditandai sebagai dibaca.');
    }

    public function markAsRead($id)
    {
        $user = Auth::user();
        $notifikasi = $user->notifikasis()->findOrFail($id);
        $notifikasi->update(['is_read' => true]);

        return back()->with('success', 'Notifikasi ditandai sebagai dibaca.');
    }

    public function destroy($id)
    {
        $user = Auth::user();
        $notifikasi = $user->notifikasis()->findOrFail($id);
        $notifikasi->delete();

        return back()->with('success', 'Notifikasi berhasil dihapus.');
    }

    public function destroyAll()
    {
        $user = Auth::user();
        $user->notifikasis()->delete();

        return back()->with('success', 'Semua notifikasi berhasil dihapus.');
    }

    public function getLatestJson()
    {
        $user = Auth::user();

        if (! $user) {
            return response()->json([
                'unread_count' => 0,
                'notifications' => [],
            ]);
        }

        $notifikasis = $user->notifikasis()
            ->latest()
            ->take(10)
            ->get()
            ->map(function ($n) {
                return [
                    'id' => $n->id,
                    'title' => $n->title,
                    'message' => $n->message,
                    'type' => $n->type,
                    'icon' => $n->icon,
                    'url' => $n->url,
                    'is_read' => $n->is_read,
                    'time_ago' => $n->created_at->diffForHumans(),
                ];
            });

        return response()->json([
            'unread_count' => $user->unread_count,
            'notifications' => $notifikasis,
        ]);
    }
}
