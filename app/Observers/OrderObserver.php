<?php

namespace App\Observers;

use App\Order;

class OrderObserver
{
    public function deleted(Order $order)
    {
        Order::withTrashed()->find($order->id)
            ->forceFill([
                'status' => -1
            ])->save();
    }

}
