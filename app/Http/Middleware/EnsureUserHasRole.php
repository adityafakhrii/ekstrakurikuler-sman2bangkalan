<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserHasRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        if (! $request->user()) {
            return redirect()->route('login');
        }

        if (! $request->user()->hasRole($roles)) {
            $user = $request->user();
            if ($user->isSiswa()) {
                return redirect()->route('siswa.home')->with('error', 'Silakan logout terlebih dahulu untuk mengakses halaman tersebut.');
            } elseif ($user->isAdmin()) {
                return redirect()->route('dashboard')->with('error', 'Silakan logout terlebih dahulu untuk mengakses halaman tersebut.');
            } elseif ($user->isKetua()) {
                return redirect()->route('ketua.dashboard')->with('error', 'Silakan logout terlebih dahulu untuk mengakses halaman tersebut.');
            }

            abort(403, 'Anda tidak memiliki akses ke halaman ini.');
        }

        return $next($request);
    }
}