<?php

namespace App\Http\Controllers\Estudiante;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Caso;
use App\Models\Documento;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
// --- ¡AÑADE ESTAS LÍNEAS! ---
use App\Notifications\DocumentoSubidoNotification;
use Illuminate\Support\Facades\Notification;
// --- FIN DE LÍNEAS AÑADIDAS ---

class CasoController extends Controller
{
    // ... (Tus métodos index() y show() quedan igual) ...
    public function index(): View
    {
        $casos = Caso::where('correo_estudiante', Auth::user()->email)
            ->latest()
            ->paginate(15);
            
        return view('estudiante.casos_index', compact('casos'));
    }

    public function show(Caso $caso): View
    {
        if ($caso->correo_estudiante !== Auth::user()->email) {
            abort(403, 'Acción no autorizada.');
        }
        $caso->load('asesor', 'director', 'documentos');
        return view('estudiante.caso_show', compact('caso'));
    }

    /**
     * Procesa la subida de un nuevo documento por parte del estudiante.
     */
    public function upload(Request $request, Caso $caso): RedirectResponse
    {
        if ($caso->correo_estudiante !== Auth::user()->email) {
            abort(403, 'Acción no autorizada.');
        }

        $request->validate([
            'documento' => 'required|file|mimes:pdf,jpg,jpeg,png,doc,docx|max:5120',
        ]);

        if ($request->hasFile('documento')) {
            $file = $request->file('documento');
            $path = $file->store("casos/{$caso->id}", 'public');
            
            // --- ¡INICIO DE LA MODIFICACIÓN! ---
            // 1. Guardar el documento
            $documento = Documento::create([
                'caso_id' => $caso->id,
                'ruta' => $path,
                'nombre_original' => $file->getClientOriginalName(),
                'mime_type' => $file->getClientMimeType(),
            ]);

            // 2. Notificar al Asesor
            try {
                $asesor = $caso->asesor;
                if ($asesor) {
                    Notification::send($asesor, new DocumentoSubidoNotification($caso, $documento));
                }
            } catch (\Exception $e) {
                \Log::error('Error al enviar notificación de documento subido: ' . $e->getMessage());
            }
            // --- FIN DE LA MODIFICACIÓN! ---
        }

        return redirect()->back()->with('success', '¡Documento subido con éxito!');
    }
}