<?php

namespace App\Listeners;

use App\Events\PasswordResetSucceeded;
use App\Notifications\PasswordResetSuccess;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendEmailPasswordResetSucceededNotification
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
     * @param PasswordResetSucceeded $event
     *
     * @return void
     */
    public function handle(PasswordResetSucceeded $event)
    {
        $event->user->notify(new PasswordResetSuccess());
    }
}
