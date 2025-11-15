<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
// Borra la importación de RouteServiceProvider si ya no la usas aquí
// use App\Providers\RouteServiceProvider; 
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        // --- INICIO DE LA MODIFICACIÓN ---
        $user = Auth::user();
        
        // Usamos el operador null safe (?->) por si acaso la relación 'rol' falla o el rol_id es NULL
        $rolNombre = $user->rol?->nombre_rol; 

        // Si $rolNombre es null (usuario sin rol), lo mandamos a una ruta segura (ej: login o '/')
        if ($rolNombre === null) {
             Auth::guard('web')->logout(); // Mejor desloguearlo si no tiene rol
             $request->session()->invalidate();
             $request->session()->regenerateToken();
             return redirect('/login')->withErrors(['email' => 'Usuario no tiene un rol asignado. Contacte al administrador.']);
        }

        // Usamos la variable $rolNombre que ya verificamos
        $url = match($rolNombre) {
            'Administrador' => route('admin.dashboard'),
            'Asesoría Pedagógica' => route('asesoria.dashboard'),
            'Director de Carrera' => route('director.dashboard'),
            'Docente' => route('docente.dashboard'),
            'Estudiante' => route('estudiante.dashboard'),
            default => '/login', // Fallback: si el rol existe pero no está en el match, mandarlo al login
        };

        return redirect()->intended($url);
        // --- FIN DE LA MODIFICACIÓN ---
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}

