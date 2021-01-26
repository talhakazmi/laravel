<?php

namespace App\Policies;

use App\Order;
use App\Traveller;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Facades\Auth;

class OrderPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the order.
     *
     * @param \App\Traveller $traveller
     * @param \App\Order $order
     * @return mixed
     */
    public function view($traveller, Order $order)
    {
        if (Auth::guard('admins')->check()) {
            return true;
        }

        if (Auth::guard('planner')->check()) {
            return Auth::id() === $order->planner_id;
        }

        return $traveller->id === $order->traveller_id;
    }

    /**
     * Determine whether the user can create orders.
     *
     * @param \App\Traveller $traveller
     * @return mixed
     */
    public function create(Traveller $traveller)
    {
        return true;
    }

    /**
     * Determine whether the user can update the order.
     *
     * @param \App\Traveller $traveller
     * @param \App\Order $order
     * @return mixed
     */
    public function update(Traveller $traveller, Order $order)
    {
        return $traveller->id === $order->traveller_id;
    }

    /**
     * Determine whether the user can delete the order.
     *
     * @param \App\Traveller $traveller
     * @param \App\Order $order
     * @return mixed
     */
    public function delete(Traveller $traveller, Order $order)
    {
        return $traveller->id === $order->traveller_id;
    }

    /**
     * Determine whether the user can restore the order.
     *
     * @param \App\Traveller $traveller
     * @param \App\Order $order
     * @return mixed
     */
    public function restore(Traveller $traveller, Order $order)
    {
        return $traveller->id === $order->traveller_id;
    }

    /**
     * Determine whether the user can permanently delete the order.
     *
     * @param \App\Traveller $traveller
     * @param \App\Order $order
     * @return mixed
     */
    public function forceDelete(Traveller $traveller, Order $order)
    {
        return $traveller->id === $order->traveller_id;
    }

    /**
     * Determine whether the admin can attach any theme to order.
     *
     */
    public function attachAnyTheme()
    {
        return false;
    }

    /**
     * Determine whether the admin can attach theme to order.
     *
     */
    public function attachTheme()
    {
        return false;
    }

    /**
     * Determine whether the admin can  detach theme to order.
     *
     */
    public function detachTheme()
    {
        return false;
    }

    /**
     * Determine whether the admin can attach any country to order.
     *
     */
    public function attachAnyCountry()
    {
        return false;
    }

    /**
     * Determine whether the admin can attach country to order.
     *
     */
    public function attachCountry()
    {
        return false;
    }

    /**
     * Determine whether the admin can  detach country to order.
     *
     */
    public function detachCountry()
    {
        return false;
    }

}
