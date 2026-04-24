<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, string $role): Response
    {
        // Verificar si el usuario está autenticado
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        $user = auth()->user();

        // Verificar el rol
        if ($role === 'admin' && $user->rol !== 'Administrador') {
            return redirect()->route('dashboard.index')
                           ->with('error', 'No tienes permisos para acceder a esta sección');
        }

        return $next($request);
    }
}