<?php

namespace App\Notifications;

use App\Models\Commande;
use App\Models\DetailCommande;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class Alertadmin extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(private Commande $commande,private array $details)
    {
        //
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
        ->subject('Nouvelle commande #' . $this->commande->id)
        ->view('fac', [
            'commande' => $this->commande,
            'cart' => session()->get('cart')
        ]);
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
