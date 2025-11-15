<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Caso;

class CasoValidadoNotification extends Notification
{
    use Queueable;

    protected $caso;
    protected $decision;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Caso $caso)
    {
        $this->caso = $caso;
        $this->decision = ucfirst(strtolower(trim($caso->estado))); // "Aceptado", "Rechazado", "Pendiente"
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
     * @param  mixed  $notifiable (Este será el Asesor o el Docente)
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $url = $this->getUrlPorRol($notifiable); // Obtenemos la URL correcta
        $subject = "Respuesta de Caso: #{$this->caso->id} ha sido '{$this->decision}'";

        return (new MailMessage)
                    ->subject($subject)
                    ->greeting("¡Hola, {$notifiable->name}!")
                    ->line("El caso #{$this->caso->id} del estudiante {$this->caso->nombre_estudiante} ha sido actualizado.")
                    ->line("**Nueva decisión:** {$this->decision}")
                    ->line("**Comentario del Director:** *\"{$this->caso->motivo_decision}\"*")
                    ->action('Ver Detalles del Caso', $url)
                    ->line('Gracias por usar la aplicación.');
    }

    /**
     * Determina a qué URL debe ir el botón, dependiendo del rol del notificado.
     */
    private function getUrlPorRol($notifiable): string
    {
        $rol = $notifiable->rol->nombre_rol;

        if ($rol == 'Asesoría Pedagógica') {
            return route('casos.show', $this->caso->id);
        }
        
        if ($rol == 'Docente') {
            return route('docente.ajustes.show', $this->caso->id);
        }

        // URL por defecto si no es ninguno (ej. Admin)
        return route('director.casos.show', $this->caso->id); 
    }
}