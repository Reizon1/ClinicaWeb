<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRol
{
    /**
     * Verifica que el usuario autenticado tenga uno de los roles permitidos.
     *
     * Uso en rutas: middleware('rol:admin')
     *               middleware('rol:paciente,medico')   ← acepta varios roles
     */
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        // 1. Si no está autenticado → al login
        if (! auth()->check()) {
            return redirect()->route('login');
        }

        $rolUsuario = auth()->user()->rol;

        // 2. Si su rol NO está en la lista de roles permitidos → a su propio dashboard
        if (! in_array($rolUsuario, $roles)) {
            return redirect()->route('dashboard')
                ->with('error', 'No tienes permiso para acceder a esa sección.');
        }

        // 3. Todo bien → deja pasar la petición
        return $next($request);
    }
}
