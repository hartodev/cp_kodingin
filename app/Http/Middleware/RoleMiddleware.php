<?php

namespace App\Http\Middleware;

// php artisan make:middleware RoleMiddleware

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Cara pakai di route:
     *   Web : Route::middleware(['auth', 'role:admin'])->group(...)
     *   API : Route::middleware(['auth:sanctum', 'role:admin'])->group(...)
     *
     * Role yang tersedia (sesuai kolom role di tabel users):
     *   'admin' → owner / admin
     *   'user'  → user biasa
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $role): Response
    {
        // ── 1. BELUM LOGIN ─────────────────────────────────────────
        if (! Auth::check()) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Unauthenticated. Silakan login terlebih dahulu.',
                ], 401);
            }

            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
        }

        // ── 2. CEK ROLE dari kolom database ───────────────────────
        if (Auth::user()->role !== $role) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Forbidden. Kamu tidak memiliki akses ke halaman ini.',
                ], 403);
            }

            abort(403, 'Akses ditolak.');
        }

        return $next($request);
    }
}