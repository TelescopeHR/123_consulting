<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ContactRequest extends FormRequest
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
            'name' => 'required|max:200',
            'email' => 'required|max:200|email',
            'phone' => 'required|regex:/^[\+\(\s\-\d\)]{5,30}$/',
            'message' => 'required',
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
