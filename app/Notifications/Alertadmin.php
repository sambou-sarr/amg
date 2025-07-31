<?php

namespace App\Notifications;

use App\Models\Commande;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class Alertadmin extends Notification implements ShouldQueue
{
    use Queueable;

    protected Commande $commande;
    protected array $details;

    /**
     * Create a new notification instance.
     */
    public function __construct(Commande $commande, array $details)
    {
        $this->commande = $commande;
        $this->details = $details;
    }

    /**
     * Get the notification's delivery channels.
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
            ->markdown('emails.commande.alertadmin', [
                'commande' => $this->commande,
                'details' => $this->details
            ]);
    }

    /**
     * Get the array representation of the notification.
     */
    public function toArray(object $notifiable): array
    {
        return [
            'commande_id' => $this->commande->id,
            'client_id' => $this->commande->client_id,
            'montant_total' => $this->commande->montant_total,
        ];
    }
}
