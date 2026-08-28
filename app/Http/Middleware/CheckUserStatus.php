<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckUserStatus
{
    public function handle(Request $request, Closure $next)
    {
        if (! Auth::check()) {
            return to_route('login');
        }

        $user = Auth::user();
        $message = null;

        if ($user->status === 'pending') {
            $message = 'Akun Anda masih menunggu verifikasi Admin. Silakan tunggu atau hubungi Admin.';
        } elseif ($user->status === 'rejected') {
            $note = $user->rejection_note ? ' Alasan: ' . $user->rejection_note : '';
            $message = 'Akun Anda ditolak oleh Admin.' . $note;
        } elseif ($user->status === 'inactive') {
            $message = 'Akun Anda dinonaktifkan. Silakan hubungi Admin untuk informasi lebih lanjut.';
        }

        if ($message !== null) {
            Auth::logout();
            $request->session()->flush();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            $request->session()->regenerate(true);

            $response = to_route('login')->with('error', $message);
            if (method_exists($response, 'header')) {
                $response->headers->set('Cache-Control', 'no-store, no-cache, must-revalidate, max-age=0');
                $response->headers->set('Pragma', 'no-cache');
                $response->headers->set('Expires', 'Thu, 01 Jan 1970 00:00:00 GMT');
            }

            return $response;
        }

        return $next($request);
    }
}
