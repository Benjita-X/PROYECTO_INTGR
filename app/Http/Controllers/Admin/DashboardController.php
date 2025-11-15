<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Models\User; // ¡Importante! Añadir el modelo User

class DashboardController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */
    public function __invoke(Request $request): View
    {
        // --- ¡INICIO DE LA MODIFICACIÓN! ---

        // 1. Contar el total de usuarios registrados
        $totalUsuarios = User::count();
        
        // 2. Pasar el conteo a la vista
        return view('admin.dashboard', compact('totalUsuarios'));
        
        // --- FIN DE LA MODIFICACIÓN! ---
    }
}