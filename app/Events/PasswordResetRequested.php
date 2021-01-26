<?php

namespace App\Events;

use App\User;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class PasswordResetRequested
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * The user object to notify.
     *
     * @var \App\User
     */
    public $user;

    /**
     * The password token.
     *
     * @var string
     */
    public $token;

    /**
     * Create a new event instance.
     *
     * @param \App\User $user The user object to notify
     * @param string $token The password token
     *
     * @return void
     */
    public function __construct(User $user, string $token)
    {
        $this->user = $user;
        $this->token = $token;
    }
}
