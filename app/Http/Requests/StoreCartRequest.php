<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StoreCartRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        if ($this->input('addresses') != null) {
            return [
                'addresses' => 'required',
            ];
        } else {
         return [
                'countries_countryID' => 'required',
                'cities_cityID' => 'required',
                'area_areaID' => 'required',
                'streetName' => 'max:100',
                'nearBy' => 'max:150',
                'buildingNumber' => 'max:255',
            ];

        }

    }
}
