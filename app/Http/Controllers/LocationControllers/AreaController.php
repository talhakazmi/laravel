<?php

namespace App\Http\Controllers\LocationControllers;

use App\Area;
use App\City;
use App\Country;
use App\Http\Requests\Portal\AreaRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;

class AreaController extends Controller
{
    public function index()
    {
        if(request()->page){
            $areas = Area::sortable()->orderBy('created_at', 'desc')->paginate(10);
        }else if(request()->has('status')){
            $status = request()->input('status');

            if($status == 0 || $status == 1)
                $areas = Area::whereStatus($status)->get();
            else
                $areas = Area::all();
        }else{
            $areas = Area::all();
        }
        return response()->json($areas);
    }
    public function store(AreaRequest $request)
    {
        Area::create($request->all());
        return response()->json(['success' => 'Area was created successfully']);
    }
    public function show(Area $area)
    {
        return response()->json($area);
    }
    public function update(AreaRequest $request, Area $area){
        $area->fill($request->all());
        $area->save();
        return response()->json(['success' => 'Area was updated successfully']);
    }
    public function destroy(Area $area)
    {
        $area->delete();
        return response()->json(['success' => 'Area was deleted successfully']);
    }

    public function toggleActive(Area $area)
    {
        $area->status == 1 ?  $area->status = 0 : $area->status = 1;
        $area->save();
        return response()->json(['message' => 'Status was successfully updated']);
    }

    public function getAreasForCountry($city)
    {
        $areas = Area::where('cities_cityID', $city)->whereStatus(1)->get();
        return response()->json($areas);
    }

}
