<?php

namespace App\Http\Controllers\Estudiante;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View; // Importa View

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
        // Aquí puedes agregar lógica para obtener los casos del estudiante actual
        // $misCasos = Caso::where('estudiante_id', auth()->user()->estudiante_id)->get(); // Necesitarás vincular User con Estudiante

        // Retorna la vista del dashboard del Estudiante
        return view('estudiante.dashboard'); // Asegúrate que esta vista exista
    }
}
