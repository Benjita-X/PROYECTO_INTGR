<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // Necesitamos Auth

class CheckRole
{
    /**
     * Handle an incoming request.
     * Verifica si el usuario tiene el rol requerido.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string  $role  // El nombre del rol que pasamos en la ruta (ej: 'Administrador')
     * @return mixed
     */
    public function handle(Request $request, Closure $next, string $role)
    {
        // Verifica si el usuario está logueado Y si su rol coincide con el requerido
        if (!Auth::check() || Auth::user()->rol?->nombre_rol !== $role) {
            // Si no cumple, lo redirige a su dashboard o a donde quieras (con un mensaje de error opcional)
             // abort(403, 'Acceso no autorizado.'); // Opción 1: Mostrar error 403
             return redirect(route(match(Auth::user()?->rol?->nombre_rol) { // Opción 2: Redirigir a su dashboard
                    'Asesoría Pedagógica' => 'asesoria.dashboard',
                    'Director de Carrera' => 'director.dashboard',
                    'Docente' => 'docente.dashboard',
                    'Estudiante' => 'estudiante.dashboard',
                    default => 'login' // Si no está logueado o no tiene rol
             }))->with('error', 'No tienes permiso para acceder a esta sección.');
        }

        // Si tiene el rol correcto, permite que la petición continúe
        return $next($request);
    }
}
