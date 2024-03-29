<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewOrder extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database'];
    }

    // make notification to be stored in database for a new order

    public function toDatabase($notifiable)
    {
        // title, body

        return [
            'title' => 'لديك طلب جديد',
            'body' => 'تم اضافة طلب جديد',
            'url' => route('admin.orders.index'),
        ];
    }
}
