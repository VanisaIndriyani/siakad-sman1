<?php

namespace App\Http\Controllers;

use App\Models\Faq;
use App\Models\Kebijakan;
use App\Models\LaporanMasalah;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class BantuanController extends Controller
{
    public function index(Request $request)
    {
        $role = $this->getCurrentRole();
        $faqs = Faq::active()->forRole($role)->orderBy('sort_order')->get();
        $kebijakans = Kebijakan::active()->forRole($role)->latest()->get();

        return view('bantuan.index', compact('faqs', 'kebijakans', 'role'));
    }

    public function faq(Request $request)
    {
        $role = $this->getCurrentRole();
        $query = Faq::active()->forRole($role);

        if ($request->filled('for_role') && in_array($request->for_role, ['all','admin','guru','siswa','kepala_sekolah'])) {
            $forRole = $request->for_role;
            $query->where(function ($q) use ($forRole) {
                $q->where('for_role', 'all')->orWhere('for_role', $forRole);
            });
        }

        if ($request->filled('search')) {
            $search = trim($request->search);
            $kw = "%{$search}%";
            $query->where(function ($q) use ($kw) {
                $q->where('question', 'like', $kw)
                    ->orWhere('answer', 'like', $kw);
            });
        }

        $faqs = $query->orderBy('sort_order')->orderBy('id')->paginate(15);

        return view('bantuan.faq', compact('faqs'));
    }

    public function kebijakan(Request $request)
    {
        $role = $this->getCurrentRole();
        $query = Kebijakan::active()->forRole($role);

        if ($request->filled('for_role') && in_array($request->for_role, ['all','admin','guru','siswa','kepala_sekolah'])) {
            $forRole = $request->for_role;
            $query->where(function ($q) use ($forRole) {
                $q->where('for_role', 'all')->orWhere('for_role', $forRole);
            });
        }

        if ($request->filled('search')) {
            $search = trim($request->search);
            $kw = "%{$search}%";
            $query->where(function ($q) use ($kw) {
                $q->where('title', 'like', $kw)
                    ->orWhere('content', 'like', $kw);
            });
        }

        $kebijakans = $query->latest()->paginate(10);

        return view('bantuan.kebijakan', compact('kebijakans'));
    }

    public function showKebijakan($slug)
    {
        $role = $this->getCurrentRole();
        $kebijakan = Kebijakan::active()->forRole($role)->where('slug', $slug)->firstOrFail();

        return view('bantuan.kebijakan_detail', compact('kebijakan'));
    }

    public function panduan(Request $request)
    {
        $role = $this->getCurrentRole();
        return view('bantuan.panduan', compact('role'));
    }

    public function lapor()
    {
        $role = $this->getCurrentRole();
        $user = Auth::user();
        $riwayatLaporan = collect([]);

        if ($user) {
            $riwayatLaporan = LaporanMasalah::where('user_id', $user->id)->latest()->paginate(5);
        }

        return view('bantuan.lapor', compact('role', 'riwayatLaporan'));
    }

    public function kirimLaporan(Request $request)
    {
        $request->validate([
            'nama_pelapor' => 'required|string|max:255',
            'email_pelapor' => 'required|email|max:255',
            'subject' => 'required|string|max:255',
            'kategori' => 'required|in:bug,saran,akses,akademik,lainnya',
            'deskripsi' => 'required|string|max:5000',
            'file_pendukung' => 'nullable|file|mimes:pdf,jpg,jpeg,png,txt,doc,docx,xls,xlsx|max:5120',
        ]);

        $filePath = null;
        if ($request->hasFile('file_pendukung')) {
            $filePath = $request->file('file_pendukung')->store('laporan_masalah', 'public');
        }

        $laporan = LaporanMasalah::create([
            'user_id' => Auth::check() ? Auth::id() : null,
            'nama_pelapor' => $request->nama_pelapor,
            'email_pelapor' => $request->email_pelapor,
            'subject' => $request->subject,
            'kategori' => $request->kategori,
            'deskripsi' => $request->deskripsi,
            'file_path' => $filePath,
            'status' => 'open',
        ]);

        $admins = User::where('role', 'admin')->where('status', 'active')->get();
        $kategoriLabel = [
            'bug' => 'Bug/Kesalahan',
            'saran' => 'Saran',
            'akses' => 'Masalah Akses',
            'akademik' => 'Akademik',
            'lainnya' => 'Lainnya',
        ];

        foreach ($admins as $admin) {
            $admin->addNotification(
                "Laporan Baru: {$kategoriLabel[$request->kategori]}",
                "Laporan baru dari {$request->nama_pelapor}: {$request->subject}. Segera ditindaklanjuti.",
                'warning',
                'fa-exclamation-triangle',
                route('admin.laporan-masalah.index')
            );
        }

        return back()->with('success', 'Laporan Anda telah dikirim. Admin akan segera menindaklanjuti. Nomor laporan: #' . $laporan->id . '.');
    }

    private function getCurrentRole(): string
    {
        if (Auth::check()) {
            return Auth::user()->role;
        }
        return 'all';
    }
}
