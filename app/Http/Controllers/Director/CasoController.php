<?php

namespace App\Http\Controllers\Director;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Caso; 
use App\Models\User; // <-- ¡ESTA ES LA LÍNEA QUE FALTABA Y CORRIGE EL ERROR!
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth; 
use Illuminate\Http\RedirectResponse; 
use Symfony\Component\HttpFoundation\StreamedResponse; // Importante
use App\Notifications\CasoValidadoNotification;
use Illuminate\Support\Facades\Notification;

class CasoController extends Controller
{
    /**
     * Muestra la lista de casos pendientes de validación.
     */
    public function pendientes(Request $request): View
    {
        $query = Caso::query();
        $query->whereIn('estado', ['Sin Revision', 'Pendiente']);
        $this->aplicarFiltros($query, $request);
        $casos = $query->orderBy('created_at', 'desc')->paginate(15);
        
        // (Uso tu nombre de vista con guion bajo)
        return view('director.casos_pendientes', compact('casos'));
    }

    /**
     * Muestra el historial de casos ACEPTADOS.
     */
    public function aceptados(Request $request): View
    {
        $query = Caso::query();
        $query->where('estado', 'Aceptado');
        $this->aplicarFiltros($query, $request);
        $casos = $query->orderBy('created_at', 'desc')->paginate(15);
        return view('director.casos_aceptados', compact('casos'));
    }

    /**
     * Muestra el historial de casos RECHAZADOS.
     */
    public function historial(Request $request): View
    {
        $query = Caso::query();
        $query->where('estado', 'Rechazado'); 
        $this->aplicarFiltros($query, $request);
        $casos = $query->orderBy('created_at', 'desc')->paginate(15);
        return view('director.casos_historial', compact('casos'));
    }

    /**
     * Muestra TODOS los casos (sin filtro de estado) para el Director.
     */
    public function todos(Request $request): View
    {
        $query = Caso::query(); 
        $this->aplicarFiltros($query, $request);
        $casos = $query->orderBy('created_at', 'desc')->paginate(15);
        return view('director.casos_todos', compact('casos'));
    }

    /**
     * Método helper privado para aplicar los filtros de búsqueda comunes.
     */
    private function aplicarFiltros($query, Request $request)
    {
        if ($request->filled('search_rut')) {
            $query->where('rut_estudiante', 'like', '%' . $request->input('search_rut') . '%');
        }
        if ($request->filled('search_fecha_inicio')) {
            $query->whereDate('created_at', '>=', $request->input('search_fecha_inicio'));
        }
        if ($request->filled('search_fecha_fin')) {
            $query->whereDate('created_at', '<=', $request->input('search_fecha_fin'));
        }
    }
    
    /**
     * Muestra la página de detalle para validar un caso.
     */
    public function show(Caso $caso): View
    {
        $caso->load('asesor', 'documentos');
        return view('director.caso_show', compact('caso'));
    }

    /**
     * Procesa la decisión de validación del Director.
     */
    public function validar(Request $request, Caso $caso): RedirectResponse
    {
        $request->validate([
            'decision' => 'required|string|in:Aceptado,Rechazado,Pendiente',
            'motivo_decision' => 'nullable|string|max:1000',
        ]);
        
        $decision = $request->input('decision');
        $motivo = $request->input('motivo_decision');
        
        $caso->estado = $decision; 
        $caso->motivo_decision = $motivo;
        $caso->director_id = Auth::id();
        $caso->save(); 


        // --- ¡INICIO DE LA MODIFICACIÓN! ---
        try {
            // 1. Encontrar al Asesor que creó el caso
            $asesor = $caso->asesor; // (Gracias a la relación que definimos)

            // 2. Enviar la notificación al Asesor
            if ($asesor) {
                Notification::send($asesor, new CasoValidadoNotification($caso));
            }

            // 3. (Lógica para notificar al Docente)
            if ($decision == 'Aceptado') {
                // Buscamos a todos los docentes de esa carrera
                // (¡OJO! Esta lógica asume que los docentes tienen el campo 'carrera' en su perfil)
                $docentes = User::whereHas('rol', function ($query) { // <-- Esta es la línea que daba error
                                    $query->where('nombre_rol', 'Docente');
                                })
                                ->where('carrera', $caso->carrera) // <-- Lógica clave
                                ->get();
                
                if($docentes->isNotEmpty()) { // Comprobamos si se encontraron docentes
                    Notification::send($docentes, new CasoValidadoNotification($caso));
                }
            }

        } catch (\Exception $e) {
            \Log::error('Error al enviar notificación de caso validado: ' . $e->getMessage());
        }
        // --- FIN DE LA MODIFICACIÓN! ---


        return redirect()->route('director.casos.pendientes')->with('success', "El caso #{$caso->id} ha sido actualizado a '{$decision}'.");
    }

    // --- MÉTODOS DE EXPORTACIÓN ---

    /**
     * Exporta la lista de casos ACEPTADOS a CSV.
     */
    public function exportAceptados(Request $request): StreamedResponse
    {
        $query = Caso::query()->where('estado', 'Aceptado');
        $this->aplicarFiltros($query, $request);
        $casos = $query->with('director')->get(); 

        return $this->streamCsv('casos_aceptados.csv', $casos);
    }

    /**
     * Exporta la lista de casos RECHAZADOS a CSV.
     */
    public function exportRechazados(Request $request): StreamedResponse
    {
        $query = Caso::query()->where('estado', 'Rechazado');
        $this->aplicarFiltros($query, $request);
        $casos = $query->with('director')->get();

        return $this->streamCsv('casos_rechazados.csv', $casos);
    }

    /**
     * Exporta TODOS los casos a CSV.
     */
    public function exportTodos(Request $request): StreamedResponse
    {
        $query = Caso::query();
        $this->aplicarFiltros($query, $request);
        $casos = $query->with('director')->get();

        return $this->streamCsv('todos_los_casos.csv', $casos);
    }

    /**
     * Método helper para generar el archivo CSV.
     */
    private function streamCsv($fileName, $casos): StreamedResponse
    {
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $fileName . '"',
        ];

        $callback = function() use ($casos) {
            $handle = fopen('php://output', 'w');
            
            // Le decimos a fputcsv que use PUNTO Y COMA (;) como separador
            fputcsv($handle, [
                'ID Caso',
                'RUT Estudiante',
                'Nombre Estudiante',
                'Carrera',
                'Estado',
                'Fecha Creacion',
                'Ajustes Propuestos',
                'Decision Tomada por',
                'Comentarios Decision',
            ], ';'); // <-- Separador ;

            // Llenar los datos
            foreach ($casos as $caso) {
                fputcsv($handle, [
                    $caso->id,
                    $caso->rut_estudiante,
                    $caso->nombre_estudiante,
                    $caso->carrera,
                    $caso->estado,
                    $caso->created_at->format('Y-m-d H:i:s'),
                    $caso->ajustes_propuestos,
                    $caso->director?->name ?? 'N/A',
                    $caso->motivo_decision ?? '',
                ], ';'); // <-- Separador ;
            }

            fclose($handle);
        };

        return new StreamedResponse($callback, 200, $headers);
    }
}