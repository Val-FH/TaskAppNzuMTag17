<?php

namespace App\Notifications;

use App\Models\Task;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PushToTask extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(protected Task $task)
    {
        //
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    // wie soll versendet werden
    public function via(object $notifiable): array
    {  // info via mail und datenbank versenden
        return ['mail', 'database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    // wie die mail geschrieben werden soll
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage) // inhalt der e mail
            ->greeting('Hallo') // begrüßung
            ->line('Dir wurde eine Aufgabe zugewiesen.')
            ->line('Aufgabe: '.$this->task->title) // über this teile der aufgabe übergeben
            ->action('Zur Aufgabe', url('/tasks/'.$this->task->id)) //zeigt show blade
            ->line('Viel Spaß beim deiner Aufgabe!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    // sachen die in datnebank kommen
    public function toArray(object $notifiable): array
    {
        return [
            // Felder des Array definieren (beliebig erweiterbar)
            'title' => $this->task->title,
            'url' => url('/tasks/'.$this->task->id),
            'message' => "Neue Aufgabe",
        ];
    }
}
