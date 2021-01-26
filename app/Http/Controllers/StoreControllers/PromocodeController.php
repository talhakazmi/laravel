<?php

namespace App\Http\Controllers\StoreControllers;

use App\Http\Requests\Portal\PromocodeRequest;
use App\PromoCode;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;

class PromocodeController extends Controller
{
    public function index()
    {
        $promoCodes = PromoCode::sortable()->orderBy('created_at', 'desc')->paginate(10);
        return response()->json($promoCodes);
    }
    public function store(PromocodeRequest $request)
    {
        PromoCode::create($request->all());
        return response()->json(['success' => 'PromoCode was created successfully']);
    }
    public function show($promcodeID)
    {
        $promoCode = PromoCode::find($promcodeID);
        return response()->json($promoCode);
    }
    public function update(PromocodeRequest $request, $promcodeID)
    {
        PromoCode::find($promcodeID)->fill($request->all())->save();
        return response()->json(['success' => 'PromoCode was updated successfully']);
    }
    public function toggleActive($promcodeID)
    {

        $promoCode = PromoCode::find($promcodeID);
        $promoCode->status == 1 ?  $promoCode->status = 0 : $promoCode->status = 1;
        $promoCode->save();
        return response()->json(['success' => 'Status was updated successfully']);
    }
    public function destroy($promcodeID)
    {
        $promoCode = PromoCode::find($promcodeID);
        $promoCode->delete();
        return response()->json(['success' => 'Promocode was delete successfully']);
    }

}
