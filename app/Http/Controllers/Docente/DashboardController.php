<?php

namespace App\Http\Controllers\Docente;

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
        // --- ¡INICIO DE LA MODIFICACIÓN! ---
        
        $docenteId = Auth::id(); // Obtener el ID del docente logueado

        // 1. Contar casos PENDIENTES DE LECTURA
        // (Son casos 'Aceptados' donde el docente aún NO ha confirmado)
        $pendientesCount = Caso::where('estado', 'Aceptado')
                               ->whereDoesntHave('docentesQueConfirmaron', function ($query) use ($docenteId) {
                                   $query->where('user_id', $docenteId);
                               })
                               ->count();

        // 2. Contar casos YA CONFIRMADOS
        // (Son casos 'Aceptados' donde el docente SÍ ha confirmado)
        $confirmadosCount = Caso::where('estado', 'Aceptado')
                              ->whereHas('docentesQueConfirmaron', function ($query) use ($docenteId) {
                                  $query->where('user_id', $docenteId);
                              })
                              ->count();

        // 3. Agrupar las estadísticas en un array
        $stats = [
            'pendientes' => $pendientesCount,
            'confirmados' => $confirmadosCount,
        ];

        // 4. Pasar las estadísticas a la vista
        return view('docente.dashboard', compact('stats'));
        // --- FIN DE LA MODIFICACIÓN! ---
    }
}