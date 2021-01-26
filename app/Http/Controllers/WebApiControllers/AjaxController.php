<?php

namespace App\Http\Controllers\WebApiControllers;

use App\Area;
use App\Category;
use App\City;
use App\Http\Resources\Api\v1\Cities as CityResource;
use App\Specialty;
use App\SubCategory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\Api\v1\Areas as AreaResource;
use App\Http\Resources\Api\v1\SubCategory as SubCategoryResource;
use App\Http\Resources\Api\v1\Specialties as SpecialtyResource;
class AjaxController extends Controller
{
    public function getCities($ID)
    {

        $cities = City::where('countries_countryID', $ID)->get();
        return response()->json($cities);
    }

    public function getAreas($ID)
    {


        $areas = Area::where('cities_cityID', $ID)->get();
        return response()->json($areas);
    }

    public function getSubcategories($ID)
    {
        $subcategory = Category::where('parent_id', $ID)->whereStatus(1)->get();
        return response()->json($subcategory);
    }

    public function getSpecialty($ID)
    {
        $specialty = Specialty::where('brands_brandID', $ID)->whereStatus(1)->get();
        return response()->json($specialty);
    }



}
