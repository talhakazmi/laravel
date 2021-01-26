<?php

namespace App\Http\Requests\Portal;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class AreaRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
//        return Auth::user()->hasRole('admin');
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'countries_countryID'=>'required|exists:countries,countryID',
            'cities_cityID'=>'required|exists:cities,cityID',
            'name_en'=>'required|max:255',
            'name_ar'=>'required|max:255',
        ];
    }
}
