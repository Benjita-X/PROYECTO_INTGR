<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Rol; // <-- Importa el modelo Rol
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        // --- INICIO DE LA MODIFICACIÓN ---
        // Buscamos el ID del rol "Estudiante" en la base de datos.
        // Usamos firstOrFail() para detener la ejecución si el rol no existe (algo salió mal con el Seeder).
        $rolEstudiante = Rol::where('nombre_rol', 'Estudiante')->firstOrFail();

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'rol_id' => $rolEstudiante->id, // <-- Asignamos el ID encontrado
        ]);
        // --- FIN DE LA MODIFICACIÓN ---

        event(new Registered($user));

        Auth::login($user);

        // Redirige al dashboard correspondiente (usando la lógica que ya pusimos en AuthenticatedSessionController)
        return redirect()->intended(route(match($user->rol->nombre_rol) {
            'Administrador' => 'admin.dashboard',
            'Asesoría Pedagógica' => 'asesoria.dashboard',
            'Director de Carrera' => 'director.dashboard',
            'Docente' => 'docente.dashboard',
            'Estudiante' => 'estudiante.dashboard',
            default => 'login',
        }));
        // return redirect(RouteServiceProvider::HOME); // Línea original de Breeze
    }
}

