<?php

namespace App\Http\Controllers\Director;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Models\Caso; // ¡Importante! Añadir el modelo Caso

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
        // 1. Contar los casos pendientes
        $pendientesCount = Caso::whereIn('estado', ['Sin Revision', 'Pendiente'])->count();
        
        // 2. Contar los casos aceptados
        $aceptadosCount = Caso::where('estado', 'Aceptado')->count();

        // 3. Contar los casos rechazados
        $rechazadosCount = Caso::where('estado', 'Rechazado')->count();

        // 4. Agrupar las estadísticas en un array
        $stats = [
            'pendientes' => $pendientesCount,
            'aceptados' => $aceptadosCount,
            'rechazados' => $rechazadosCount,
        ];

        // 5. Pasar las estadísticas a la vista
        return view('director.dashboard', compact('stats'));
        // --- FIN DE LA MODIFICACIÓN! ---
    }
}