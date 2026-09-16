<?php

namespace App\Notifications;

use App\Models\Task;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PullFromTask extends Notification
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
    //Wie wollen wir versenden
    public function via(object $notifiable): array
    {
        return ['mail','database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    // Inhalt der Mail
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->greeting('Hallo') // begrüßung
            ->line('Du wurdest aus der Aufgabe '.$this->task->title.' entfernt')
            ->action('Zur Aufgabe', url('/tasks/'.$this->task->id))
            ->line('Viel Spaß beim erholen!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            // Felder des Array definieren
            'title' => $this->task->title,
            'url' => url('/tasks/'.$this->task->id),
            'message' => "Neue Aufgabe",
        ];
    }
}
