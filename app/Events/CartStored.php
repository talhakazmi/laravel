<?php

namespace App\Events;

use App\OrderGroup;
use App\User;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class CartStored
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

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
     * Create a new event instance.
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
}
