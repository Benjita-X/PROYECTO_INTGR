<?php

namespace App\Http\Controllers;

use App\Models\Caso;
use App\Models\Documento;
use Illuminate\Http\Request; // ¡Asegúrate de que 'Request' esté importado!
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use App\Models\User;
use App\Notifications\CasoCreadoNotification;
use Illuminate\Support\Facades\Notification;

class CasoController extends Controller
{
    /**
     * Muestra la lista de casos.
     */
    public function index(Request $request): View // <-- Añadir Request aquí
    {
        // --- ¡INICIO DE LA MODIFICACIÓN! ---
        $query = Caso::query();

        // Aplicar filtros de búsqueda
        $this->aplicarFiltros($query, $request);
        
        // Cargar los casos y paginar
        $casos = $query->latest()->paginate(15); 
        // --- FIN DE LA MODIFICACIÓN! ---

        return view('asesoria.casos.index', compact('casos'));
    }

    /**
     * Muestra el formulario para crear un nuevo caso.
     */
    public function create(): View
    {
        return view('asesoria.casos.create');
    }
    
    // --- ¡NUEVO MÉTODO AÑADIDO! ---
    /**
     * Método helper privado para aplicar los filtros de búsqueda comunes.
     * (Copiado desde Director/CasoController)
     */
    private function aplicarFiltros($query, Request $request)
    {
        // Filtrar por RUT de estudiante
        if ($request->filled('search_rut')) {
            $query->where('rut_estudiante', 'like', '%' . $request->input('search_rut') . '%');
        }

        // Filtrar por fecha de inicio (Desde)
        if ($request->filled('search_fecha_inicio')) {
            $query->whereDate('created_at', '>=', $request->input('search_fecha_inicio'));
        }

        // Filtrar por fecha de fin (Hasta)
        if ($request->filled('search_fecha_fin')) {
            $query->whereDate('created_at', '<=', $request->input('search_fecha_fin'));
        }
    }
    // --- FIN DEL NUEVO MÉTODO ---

    /**
     * Guarda un nuevo caso en la base de datos.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'rut_estudiante' => ['required', 'string', 'max:12'], 
            'nombre_estudiante' => 'required|string|max:255',
            'correo_estudiante' => 'required|email|max:255',
            'carrera' => 'required|string|max:255',
            'ajustes_propuestos' => 'required|string',
            'documentos' => 'nullable|array|max:5', 
            'documentos.*' => 'nullable|file|mimes:pdf,jpg,jpeg,png,doc,docx|max:5120', 
        ]);

        $rutLimpio = strtoupper(str_replace(['.', '-'], '', $validatedData['rut_estudiante']));

        $caso = Caso::create([
            'rut_estudiante' => $rutLimpio,
            'nombre_estudiante' => $validatedData['nombre_estudiante'],
            'correo_estudiante' => $validatedData['correo_estudiante'],
            'carrera' => $validatedData['carrera'],
            'ajustes_propuestos' => $validatedData['ajustes_propuestos'],
            'asesoria_id' => Auth::id(),
            'estado' => 'Sin Revision',
        ]);

        if ($request->hasFile('documentos')) {
            foreach ($request->file('documentos') as $file) {
                $path = $file->store("casos/{$caso->id}", 'public');
                Documento::create([
                    'caso_id' => $caso->id,
                    'ruta' => $path,
                    'nombre_original' => $file->getClientOriginalName(),
                    'mime_type' => $file->getClientMimeType(),
                ]);
            }
        }

        // --- ¡INICIO DE LA MODIFICACIÓN! ---
        try {
            // 1. Buscar a todos los usuarios que sean "Director de Carrera"
            $directores = User::whereHas('rol', function ($query) {
                $query->where('nombre_rol', 'Director de Carrera');
            })->get();

            // 2. Enviarles la notificación
            Notification::send($directores, new CasoCreadoNotification($caso));

        } catch (\Exception $e) {
            // Si el envío de correo falla (ej. Mailtrap está mal configurado),
            // no rompemos la aplicación. Solo lo registramos.
            \Log::error('Error al enviar notificación de nuevo caso: ' . $e->getMessage());
        }
        // --- FIN DE LA MODIFICACIÓN! ---

        return redirect()->route('casos.index')->with('success', 'Caso registrado con éxito.');
    }

    /**
     * Muestra los detalles de un caso específico.
     */
    public function show(Caso $caso): View
    {
        $caso->load('asesor', 'director', 'documentos');
        return view('asesoria.casos.show', compact('caso'));
    }

    /**
     * Muestra el formulario para editar un caso.
     */
    public function edit(Caso $caso): View
    {
        return view('asesoria.casos.edit', compact('caso'));
    }

    /**
     * Actualiza un caso existente.
     */
    public function update(Request $request, Caso $caso)
    {
        $validatedData = $request->validate([
            'rut_estudiante' => ['required', 'string', 'max:12'],
            'nombre_estudiante' => 'required|string|max:255',
            'correo_estudiante' => 'required|email|max:255',
            'carrera' => 'required|string|max:255',
            'ajustes_propuestos' => 'required|string',
        ]);
        
        $rutLimpio = strtoupper(str_replace(['.', '-'], '', $validatedData['rut_estudiante']));
        $validatedData['rut_estudiante'] = $rutLimpio;

        $caso->update($validatedData);

        return redirect()->route('casos.index')->with('success', 'Caso actualizado con éxito.');
    }

    /**
     * Elimina un caso.
     */
    public function destroy(Caso $caso)
    {
        Storage::disk('public')->deleteDirectory('casos/' . $caso->id);
        $caso->delete();
        return redirect()->route('casos.index')->with('success', 'Caso eliminado con éxito.');
    }
}