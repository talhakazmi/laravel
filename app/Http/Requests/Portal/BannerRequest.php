<?php

namespace App\Http\Requests\Portal;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class BannerRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        switch ($this->method()) {
            case 'GET':
            case 'DELETE': {
                return [];
            }
            case 'POST': {
                return [
                    'bannerImage_ar' => 'required|max:180',
                    'bannerImage_en' => 'required|max:180',
                    'link' => 'required|max:1000',
                    'image' => 'required',
                ];
            }
            case 'PUT':
            {
	            return [
		            'bannerImage_ar' => 'required|max:180',
		            'bannerImage_en' => 'required|max:180',
		            'link' => 'required|max:1000',
	            ];
            }
        }
    }
}
