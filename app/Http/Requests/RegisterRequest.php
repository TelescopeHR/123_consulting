<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
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
        return [
            'agency_name' => 'required|max:190',
            'first_name' => 'required|max:190',
            'last_name' => 'required|max:190',
            'email' => 'required|email|max:190|unique:users,email',
            'phone' => 'required|regex:/^[\+\(\s\-\d\)]{5,30}$/',
            'username' => 'required|max:190|alpha|unique:users,username',
            'password' => 'required|min:8|max:190|confirmed',
            'g-recaptcha-response' => env('APP_ENV') == 'live' ? 'required|captcha' : ''
        ];
    }

    public function messages()
    {
        return [
            'g-recaptcha-response' => [
                'required' => 'Please verify that you are not a robot.',
                'captcha' => 'Captcha error! try again later or contact site admin.',
            ],
            'phone.regex' => 'Enter valid phone number',
        ];
    }
}
