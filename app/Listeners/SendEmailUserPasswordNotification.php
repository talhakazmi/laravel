<?php

namespace App\Listeners;

use App\Events\NewUserCreated;
use App\Notifications\NewUserPassword;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendEmailUserPasswordNotification
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param NewUserCreated $event
     *
     * @return void
     */
    public function handle(NewUserCreated $event)
    {
        $user = $event->user;

        $user->notify(new NewUserPassword($user->email, $event->password));
    }
}
