<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IsAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!$request->user() || $request->user()->role == 'player') {
            if (!$request->expectsJson() && !$request->is('api/*')) {
                return redirect()
                    ->route('items.index')
                    ->with('error', 'Acceso denegado. Solo los administradores pueden gestionar items.');
            }

            return response()->json([
                'error' => 'Acceso denegado. Se requieren permisos de administrador.'
            ], 403);
        }

        return $next($request);
    }
}
