<?php

namespace App\Events;

use App\User;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class NewUserCreated
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * The user object to notify.
     *
     * @var \App\User
     */
    public $user;

    /**
     * The user password.
     *
     * @var string
     */
    public $password;

    /**
     * Create a new event instance.
     *
     * @param \App\User $user The user object to notify
     * @param string $password The user password
     *
     * @return void
     */
    public function __construct(User $user, string $password)
    {
        $this->user = $user;
        $this->password = $password;
    }
}
