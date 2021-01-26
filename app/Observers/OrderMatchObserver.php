<?php

namespace App\Observers;

use App\OrderMatch;

class OrderMatchObserver
{
    /**
     * Handle the order match "created" event.
     *
     * @param  \App\OrderMatch  $orderMatch
     * @return void
     */
    public function saving(OrderMatch $orderMatch)
    {
        $orderMatch->calculateMatchRate();
    }

}
