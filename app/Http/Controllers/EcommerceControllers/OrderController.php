<?php

namespace App\Http\Controllers\EcommerceControllers;

use App\Filters\OrderFilter;
use App\Http\Controllers\Api\APIController;
use App\Http\Controllers\Controller;
use App\Order;
use Illuminate\Http\Request;
use App\Http\Resources\Api\v1\Orders as OrderResource;
use App\Http\Resources\Api\v1\OrderDetails as OrderDetailsResource;
class OrderController extends APIController
{
    public function index(OrderFilter $filter)
    {
        if(request()->page) {
            $orders = Order::sortable()->filter($filter)->orderBy('created_at', 'desc')->paginate(10);
        }else{
            $orders = Order::all();
        }
        return [ 'data' => $this->resource('collection','Api\Orders', OrderResource::collection($orders)), 'count' => count($orders)];

    }

    public function show(Order $order)
    {
        return $this->resource('object','Api\OrderDetails', new OrderDetailsResource($order));
    }

}
