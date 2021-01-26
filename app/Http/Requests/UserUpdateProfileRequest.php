<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UserUpdateProfileRequest extends FormRequest
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
        return [
                'fullName' => 'required|string|max:80',
                'phone' => 'required|numeric|digits:12',
                'email' => 'required|string|email|max:100',
                'password' => 'required|string|min:4|confirmed',
                'password_confirmation' => 'required|string|min:4',
                'gender' => 'required|in:M,F',
                'DOB' => 'required|date',
        ];
    }
}
