<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class GlobalNotification extends Notification
{
    use Queueable;

    public $type_notification; // 'new_user_registered', 'new_offer_registered', 'new_sale_registered', etc.
    public $title;
    public $message;
    public $data;
    public $actionUrl;
    public $actionText;
    public $type; // success, info, warning, danger
    public $icon;
    public $createdAt;

    /**
     * Create a new notification instance.
     * @param string $type_notification - Type de notification ('new_user_registered', 'new_offer_registered', 'new_sale_registered', etc.)
     * @param string $title - Titre de la notification
     * @param string $message - Message principal
     * @param array $data - Données supplémentaires (model, id, etc.)
     * @param string|null $actionUrl - URL de l'action
     * @param string|null $actionText - Texte du bouton d'action
     * @param string $type - Type de notification (success, info, warning, danger)
     * @param string|null $icon - Icône (emoji ou classe CSS)
     * @param string|null $createdAt - Date de création de la notification
     */

    /**
     * Create a new notification instance.
     */
    public function __construct($type_notification, $title, $message, $data = [], $actionUrl = null, $actionText = null, $type = 'info', $icon = null, $createdAt = null)
    {
        $this->type_notification = $type_notification;
        $this->title = $title;
        $this->message = $message;
        $this->data = $data;
        $this->actionUrl = $actionUrl;
        $this->actionText = $actionText;
        $this->type = $type;
        $this->icon = $icon;
        $this->createdAt = $createdAt;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        // return ['mail', 'database'];
        return ['database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    // public function toMail(object $notifiable): MailMessage
    // {
    //     return (new MailMessage)
    //         ->line('The introduction to the notification.')
    //         ->action('Notification Action', url('/'))
    //         ->line('Thank you for using our application!');
    // }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'type_notification' => $this->type_notification,
            'title' => $this->title,
            'message' => $this->message,
            'data' => $this->data,
            'actionUrl' => $this->actionUrl,
            'actionText' => $this->actionText,
            'type' => $this->type,
            'icon' => $this->icon,
            'createdAt' => $this->createdAt,
        ];
    }
}
