<?php

namespace App\Notifications\Monitor;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use App\Models\Notation;

/**
 * Class NotationNotification 
 * 
 * @package App\Notifications\Monitor
 */
class NotationNotification extends Notification
{
    use Queueable;

    /**
     * The resource entity from the city that is attached to the notation.
     * 
     * @var Notation $notation
     */
    public $notation;

    /**
     * Create a new notification instance.
     *
     * @param  
     * @return void
     */
    public function __construct(Notation $notation)
    {
        $this->notation = $notation;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable): array
    {
        return ['database'];
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed $notifiable
     * @return array
     */
    public function toArray($notifiable): array
    {
        return ['message' => "I added a notation for the city {$this->notation->city->name}"];
    }
}
