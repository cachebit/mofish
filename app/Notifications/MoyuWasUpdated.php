<?php

namespace App\Notifications;

use Illuminate\Notifications\Notification;

class MoyuWasUpdated extends Notification
{
    use Queueable;

    protected $moyu, $reply;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($moyu, $reply)
    {
        $this->moyu = $moyu;
        $this->reply = $reply;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via()
    {
        return ['database'];
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray()
    {
        return [
            'message' => $this->reply->owner->name . 'replied to' . $this->moyu->title,
            'link' => $this->reply->path(),
        ];
    }
}
