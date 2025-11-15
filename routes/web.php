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
use App\Http\Controllers\Docente\AjusteController as DocenteAjusteController;
use App\Http\Controllers\Estudiante\CasoController as EstudianteCasoController;

// Tus Controladores de Lógica de Negocio
use App\Http\Controllers\CasoController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// --- Ruta Pública Principal ---
Route::get('/', function () {
    if (auth()->check()) {
        $user = auth()->user();
        $rol = $user->rol->nombre_rol ?? null; 
        $routeName = match($rol) {
            'Administrador' => 'admin.dashboard',
            'Asesoría Pedagógica' => 'asesoria.dashboard',
            'Director de Carrera' => 'director.dashboard',
            'Docente' => 'docente.dashboard',
            'Estudiante' => 'estudiante.dashboard',
            default => null, 
        };
        if ($routeName === null) {
            Auth::logout(); 
            request()->session()->invalidate(); 
            request()->session()->regenerateToken(); 
            return redirect('/'); 
        }
        return redirect()->route($routeName);
    }
     return view('welcome');
});


// --- Rutas que requieren Autenticación ---
Route::middleware(['auth', 'verified'])->group(function () {

    // (Rutas de Perfil, Dashboards, Admin...)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/admin/dashboard', AdminDashboardController::class)->name('admin.dashboard');
    Route::get('/asesoria/dashboard', AsesoriaDashboardController::class)->name('asesoria.dashboard');
    Route::get('/director/dashboard', DirectorDashboardController::class)->name('director.dashboard');
    Route::get('/docente/dashboard', DocenteDashboardController::class)->name('docente.dashboard');
    Route::get('/estudiante/dashboard', EstudianteDashboardController::class)->name('estudiante.dashboard');
    Route::middleware('role:Administrador')->prefix('admin')->name('admin.')->group(function () {
        Route::resource('users', UserController::class);
    });

    // --- RUTAS PARA EL ROL DE DIRECTOR ---
    Route::middleware('role:Director de Carrera')->prefix('director')->name('director.')->group(function () {
        
        // Vistas de Lista
        Route::get('/casos/pendientes', [DirectorCasoController::class, 'pendientes'])->name('casos.pendientes');
        Route::get('/casos/aceptados', [DirectorCasoController::class, 'aceptados'])->name('casos.aceptados');
        Route::get('/casos/historial', [DirectorCasoController::class, 'historial'])->name('historial'); 
        Route::get('/casos/todos', [DirectorCasoController::class, 'todos'])->name('casos.todos');

        // Vistas de Detalle y Acción
        Route::get('/casos/{caso}', [DirectorCasoController::class, 'show'])->name('casos.show');
        Route::post('/casos/{caso}/validar', [DirectorCasoController::class, 'validar'])->name('casos.validar');

        // --- ¡INICIO DE NUEVAS RUTAS DE EXPORTACIÓN! ---
        Route::get('/export/aceptados', [DirectorCasoController::class, 'exportAceptados'])->name('casos.aceptados.export');
        Route::get('/export/rechazados', [DirectorCasoController::class, 'exportRechazados'])->name('casos.rechazados.export');
        Route::get('/export/todos', [DirectorCasoController::class, 'exportTodos'])->name('casos.todos.export');
        // --- FIN DE NUEVAS RUTAS ---
    });
    
    // (Rutas de Docente...)
    Route::middleware('role:Docente')->prefix('docente')->name('docente.')->group(function () {
        Route::get('/ajustes/pendientes', [DocenteAjusteController::class, 'pendientes'])->name('ajustes.pendientes');
        Route::get('/ajustes/todos', [DocenteAjusteController::class, 'todos'])->name('ajustes.todos');
        Route::get('/ajustes/{caso}', [DocenteAjusteController::class, 'show'])->name('ajustes.show');
        Route::post('/ajustes/{caso}/confirmar', [DocenteAjusteController::class, 'confirmar'])->name('ajustes.confirmar');
    });

    // (Rutas de Estudiante...)
    Route::middleware('role:Estudiante')->prefix('estudiante')->name('estudiante.')->group(function () {
        Route::get('/casos', [EstudianteCasoController::class, 'index'])->name('casos.index');
        Route::get('/casos/{caso}', [EstudianteCasoController::class, 'show'])->name('casos.show');
        Route::post('/casos/{caso}/upload', [EstudianteCasoController::class, 'upload'])->name('casos.upload');
    });
    
    // Rutas para la Gestión de Casos (Asesoría)
    Route::resource('casos', CasoController::class);

});

// --- Rutas de Autenticación de Breeze ---
require __DIR__.'/auth.php';