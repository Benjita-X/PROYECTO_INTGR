<?php

namespace App\Http\Controllers\Asesoria;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View; // Importa View
use App\Models\Caso;      // ¡Importante! Añadir el modelo Caso
use Illuminate\Support\Facades\Auth; // ¡Importante! Añadir Auth

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
        
        $asesorId = Auth::id(); // Obtener el ID del asesor logueado

        // 1. Contar el total de casos creados por este asesor
        $totalCreadosCount = Caso::where('asesoria_id', $asesorId)->count();

        // 2. Contar los casos pendientes (Sin Revision o Pendiente)
        $pendientesCount = Caso::where('asesoria_id', $asesorId)
                               ->whereIn('estado', ['Sin Revision', 'Pendiente'])
                               ->count();
        
        // 3. Contar los casos Aceptados
        $aceptadosCount = Caso::where('asesoria_id', $asesorId)
                              ->where('estado', 'Aceptado')
                              ->count();

        // --- ¡INICIO DE LA MODIFICACIÓN! ---
        // 4. (¡NUEVO!) Contar los casos Rechazados
        $rechazadosCount = Caso::where('asesoria_id', $asesorId)
                               ->where('estado', 'Rechazado')
                               ->count();

        // 5. Agrupar las estadísticas
        $stats = [
            'creados'    => $totalCreadosCount,
            'pendientes' => $pendientesCount,
            'aceptados'  => $aceptadosCount,
            'rechazados' => $rechazadosCount, // <-- Añadido
        ];
        // --- FIN DE LA MODIFICACIÓN! ---

        // 6. Pasar las estadísticas a la vista
        return view('asesoria.dashboard', compact('stats'));
    }
}