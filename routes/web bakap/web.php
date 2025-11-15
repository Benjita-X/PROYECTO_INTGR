<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

// Controladores de Autenticación y Perfil (Breeze)
use App\Http\Controllers\ProfileController;

// Controladores de Dashboards por Rol
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Asesoria\DashboardController as AsesoriaDashboardController;
use App\Http\Controllers\Director\DashboardController as DirectorDashboardController;
use App\Http\Controllers\Docente\DashboardController as DocenteDashboardController;
use App\Http\Controllers\Estudiante\DashboardController as EstudianteDashboardController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Director\CasoController as DirectorCasoController;
use App\Http\Controllers\Docente\AjusteController as DocenteAjusteController; // <--- Este ya lo tenías, ¡perfecto!

// Tus Controladores de Lógica de Negocio
use App\Http\Controllers\CasoController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// --- Ruta Pública Principal (¡Lógica anti-bucle mejorada!) ---
Route::get('/', function () {
    
    // Primero, revisamos si el usuario está logueado
    if (auth()->check()) {
        $user = auth()->user();
        $rol = $user->rol->nombre_rol ?? null; // Obtiene el rol

        // Asigna la ruta del dashboard según el rol
        $routeName = match($rol) {
            'Administrador' => 'admin.dashboard',
            'Asesoría Pedagógica' => 'asesoria.dashboard',
            'Director de Carrera' => 'director.dashboard',
            'Docente' => 'docente.dashboard',
            'Estudiante' => 'estudiante.dashboard',
            default => null, // El rol es nulo o no coincide
        };

        // --- ESTA ES LA CORRECCIÓN ---
        // Si el rol es nulo (sesión corrupta), forzamos el cierre de sesión
        // y lo redirigimos a la misma página (ahora como invitado).
        if ($routeName === null) {
            Auth::logout(); // Cierra la sesión
            request()->session()->invalidate(); // Invalida la sesión
            request()->session()->regenerateToken(); // Regenera el token
            return redirect('/'); // Redirige a la raíz (esta vez SÍ verá 'welcome')
        }

        // Si el rol es válido, lo redirigimos a su dashboard
        return redirect()->route($routeName);
    }
    
    // Si no está logueado (auth()->check() es falso), muestra la bienvenida
     return view('welcome');
});


// --- Rutas que requieren Autenticación ---
Route::middleware(['auth', 'verified'])->group(function () {

    // Rutas de Perfil (Comunes para todos los roles logueados)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Rutas de Dashboards Específicos por Rol
    Route::get('/admin/dashboard', AdminDashboardController::class)
        ->name('admin.dashboard');

    Route::get('/asesoria/dashboard', AsesoriaDashboardController::class)
        ->name('asesoria.dashboard');

    Route::get('/director/dashboard', DirectorDashboardController::class)
        ->name('director.dashboard');

    Route::get('/docente/dashboard', DocenteDashboardController::class)
        ->name('docente.dashboard');

    Route::get('/estudiante/dashboard', EstudianteDashboardController::class)
        ->name('estudiante.dashboard');

    

    // --- RUTAS PARA LA GESTIÓN DE USUARIOS (SOLO ADMIN) ---
    Route::middleware('role:Administrador')->prefix('admin')->name('admin.')->group(function () {
        Route::resource('users', UserController::class);
    });



    // --- RUTAS PARA EL ROL DE DIRECTOR ---
    Route::middleware('role:Director de Carrera')->prefix('director')->name('director.')->group(function () {
        
        // Rutas para la gestión de casos del Director
        Route::get('/casos/pendientes', [DirectorCasoController::class, 'pendientes'])->name('casos.pendientes');
        Route::get('/casos/aceptados', [DirectorCasoController::class, 'aceptados'])->name('casos.aceptados');
        Route::get('/casos/historial', [DirectorCasoController::class, 'historial'])->name('historial'); // Esta ahora es solo para Rechazados
        Route::get('/casos/todos', [DirectorCasoController::class, 'todos'])->name('casos.todos');

        // Ruta para ver el detalle y validar
        Route::get('/casos/{caso}', [DirectorCasoController::class, 'show'])->name('casos.show');
        Route::post('/casos/{caso}/validar', [DirectorCasoController::class, 'validar'])->name('casos.validar');
    });
    
    // ======================================================
    // --- ¡NUEVO GRUPO DE RUTAS PARA DOCENTE! ---
    // ======================================================
    Route::middleware('role:Docente')->prefix('docente')->name('docente.')->group(function () {
        
        Route::get('/ajustes/pendientes', [DocenteAjusteController::class, 'pendientes'])->name('ajustes.pendientes');
        Route::get('/ajustes/todos', [DocenteAjusteController::class, 'todos'])->name('ajustes.todos');
        Route::post('/ajustes/{caso}/confirmar', [DocenteAjusteController::class, 'confirmar'])->name('ajustes.confirmar');

    });
    // ======================================================
    
    
    // Rutas para la Gestión de Casos (Asesoría)
    Route::resource('casos', CasoController::class);

    // (La ruta duplicada de 'casos' que estaba aquí abajo ha sido eliminada)

});

// --- Rutas de Autenticación de Breeze ---
require __DIR__.'/auth.php';