<?php

namespace App\Http\Requests\Portal;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class AdminUserRequest extends FormRequest
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
        switch ($this->method()) {
            case 'POST':
                {
                    return [
                        'fullName' => 'required|max:255',
                        'email' => 'required|email|unique:users|max:255',
                        'phone' => 'required|numeric',
                        'DOB' => 'required',
                        'password' => 'required|min:4',
                        'password_confirmation' => 'required_with:password|same:password|min:4',
                        'gender' => 'required'
                    ];
                }
            case 'PUT':
                {
                    return [
                        'fullName' => 'required|max:255',
                        'phone' => 'required|numeric',
                        'DOB' => 'required',
                        'password' => 'required|min:4',
                        'password_confirmation' => 'required_with:password|same:password|min:4',
                        'gender' => 'required'
                    ];
                }
        }
    }
}
