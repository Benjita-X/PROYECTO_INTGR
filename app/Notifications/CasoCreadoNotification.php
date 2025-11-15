<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Caso; // Importamos el modelo Caso

class CasoCreadoNotification extends Notification
{
    use Queueable;

    protected $caso;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Caso $caso)
    {
        // Pasamos el objeto Caso al constructor
        $this->caso = $caso;
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
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        // El Director debe ir a la ruta del director
        $url = route('director.casos.show', $this->caso->id);

        return (new MailMessage)
                    ->subject('Nuevo Caso Registrado: #' . $this->caso->id)
                    ->greeting('¡Hola!')
                    ->line('Se ha registrado un nuevo caso de ajuste académico que requiere tu validación.')
                    ->line('**Estudiante:** ' . $this->caso->nombre_estudiante)
                    ->line('**RUT:** ' . $this->caso->rut_estudiante)
                    ->action('Revisar Caso', $url)
                    ->line('Gracias por usar la aplicación.');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            // (Para futuras notificaciones "en-app")
        ];
    }
}