<?php

namespace App\Http\Controllers\ServiceControllers;

use App\Shop;
use App\ShopPayments;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;

class ShopPaymentController extends Controller
{
    protected function validation()
    {
        return $this->validate(request(),[
            'amount' => 'required|numeric|between:1,5000',
            'note' => 'required|max:100',
            'shops_shopID' => 'required'
        ]);

    }
    public function index()
    {
        $payments =ShopPayments::sortable()->orderBy('created_at', 'desc')->paginate(10);
        return response()->json($payments);
    }
    public function store(request $request)
    {
        $this->validation();
        ShopPayments::create($request->all());
        return response()->json(['success' => 'Payment was created successfully']);
    }
    public function show($paymentID)
    {
        $payment =  ShopPayments::find($paymentID);
        return response()->json($payment);
    }
    public function update(request $request, $shopPaymentID)
    {
        $this->validation();
        $shopPayments = ShopPayments::find($shopPaymentID);
        $shopPayments->fill($request->all());
        $shopPayments->save();
        return response()->json(['success' => 'Payment was updated successfully']);

    }
    public function destroy($shopPaymentID)
    {
        $shopPayment = ShopPayments::find($shopPaymentID);
        $shopPayment->delete();
        return response()->json(['success' => 'Payment was deleted successfully']);
    }
}
