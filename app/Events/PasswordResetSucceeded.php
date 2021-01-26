<?php

namespace App\Events;

use App\User;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class PasswordResetSucceeded
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * The user object to notify.
     *
     * @var \App\User
     */
    public $user;

    /**
     * Create a new event instance.
     *
     * @param \App\User $user The user object to notify
     *
     * @return void
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }
}
