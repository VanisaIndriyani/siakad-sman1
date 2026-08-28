<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckRole
{
    public function handle(Request $request, Closure $next, ...$roles)
    {
        if (! Auth::check()) {
            return to_route('login')->with('error', 'Silakan login terlebih dahulu.');
        }

        $user = Auth::user();

        if (! in_array($user->role, $roles, true)) {
            Auth::logout();
            $request->session()->flush();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            $request->session()->regenerate(true);

            $response = to_route('login')->with('error', 'Anda tidak memiliki hak akses ke halaman tersebut.');
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
