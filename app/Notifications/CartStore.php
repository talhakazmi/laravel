<?php

namespace App\Notifications;

use App\OrderGroup;
use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class CartStore extends Notification
{
    use Queueable;

    /**
     * The user object to notify.
     *
     * @var \App\User
     */
    public $user;

    /**
     * The order object to send.
     *
     * @var \App\OrderGroup
     */
    public $orderGroup;

    /**
     * Products list to send.
     *
     * @var mixed
     */
    public $products;

    /**
     * Create a new notification instance.
     *
     * @param \App\User $user The user object to notify
     * @param \App\OrderGroup $orderGroup The order object to send
     * @param mixed $products Products list to send
     *
     * @return void
     */
    public function __construct(User $user, OrderGroup $orderGroup, $products)
    {
        $this->user = $user;
        $this->orderGroup = $orderGroup;
        $this->products = $products;
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
        return (new MailMessage)
                    ->from('support@fitely.com', 'Purchase')
                    ->subject('Thank you for using fitely')
                    ->markdown('emails.shop-purchase', [
                        'user' => $this->user,
                        'order' => $this->orderGroup,
                        'products' => $this->products
                    ]);
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
            //
        ];
    }
}
