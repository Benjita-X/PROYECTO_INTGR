<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Caso;
use App\Models\Documento;

class DocumentoSubidoNotification extends Notification
{
    use Queueable;

    protected $caso;
    protected $documento;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Caso $caso, Documento $documento)
    {
        $this->caso = $caso;
        $this->documento = $documento;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable (Este será el Asesor)
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $url = route('casos.show', $this->caso->id); // URL para Asesoría

        return (new MailMessage)
                    ->subject("Nuevo Documento Subido al Caso #{$this->caso->id}")
                    ->greeting('¡Hola!')
                    ->line("El estudiante {$this->caso->nombre_estudiante} ha subido un nuevo documento de evidencia al caso #{$this->caso->id}.")
                    ->line("**Nombre del Archivo:** " . $this->documento->nombre_original)
                    ->action('Revisar Caso', $url)
                    ->line('Por favor, revisa el caso para ver si esta nueva evidencia afecta su estado.');
    }
}