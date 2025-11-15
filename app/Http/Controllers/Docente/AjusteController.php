<?php

namespace App\Http\Controllers\Docente;

use App\Http\Controllers\Controller;
use App\Models\Caso;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class AjusteController extends Controller
{
    /**
     * Muestra los casos Aceptados que el docente AÚN NO HA CONFIRMADO.
     */
    public function pendientes(): View
    {
        $docenteId = Auth::id();

        $casos = Caso::where('estado', 'Aceptado')
            // Busca casos donde el 'user_id' (nuestro docente) NO exista
            // en la tabla pivote 'confirmacion_lecturas'
            ->whereDoesntHave('docentesQueConfirmaron', function ($query) use ($docenteId) {
                $query->where('user_id', $docenteId);
            })
            ->latest()
            ->paginate(15);

        return view('docente.ajustes_pendientes', compact('casos'));
    }

    /**
     * Muestra TODOS los casos que el docente YA HA CONFIRMADO.
     */
    public function todos(): View
    {
        $docenteId = Auth::id();

        // --- ¡INICIO DE LA MODIFICACIÓN! ---
        // Ahora solo busca casos donde SÍ existe una confirmación
        $casos = Caso::where('estado', 'Aceptado')
            ->whereHas('docentesQueConfirmaron', function ($query) use ($docenteId) {
                $query->where('user_id', $docenteId);
            })
            // --- FIN DE LA MODIFICACIÓN! ---
            ->latest()
            ->paginate(15);

        return view('docente.ajustes_todos', compact('casos'));
    }

    /**
     * Muestra la página de detalle de un ajuste para confirmar.
     */
    public function show(Caso $caso): View
    {
        // Solo por seguridad, nos aseguramos de que el caso esté Aceptado
        if ($caso->estado != 'Aceptado') {
            abort(404); // O redirigir a otro lado
        }

        // Cargamos las relaciones necesarias para la vista
        $caso->load('asesor', 'director'); // Ya no cargamos 'documentos'

        // Comprobamos si el docente actual ya confirmó este caso
        $yaConfirmado = $caso->docentesQueConfirmaron()->where('user_id', Auth::id())->exists();

        return view('docente.ajuste_show', compact('caso', 'yaConfirmado'));
    }

    /**
     * Marca un caso como "leído" por el docente actual.
     */
    public function confirmar(Request $request, Caso $caso): RedirectResponse
    {
        $caso->docentesQueConfirmaron()->syncWithoutDetaching(Auth::id());

        // Redirigimos a la lista de "pendientes" con un mensaje de éxito
        return redirect()->route('docente.ajustes.pendientes')->with('success', '¡Lectura del caso #' . $caso->id . ' confirmada!');
    }
}