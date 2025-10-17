<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FrontProfileRequest extends FormRequest
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
            'first_name' => 'required',
            'last_name' => 'required',
            'address' => 'required',
            'city' => 'required',
            'state' => 'required',
            'country_id' => 'required',
            'zipcode' => 'required',
            'email' => 'required|email|max:190|unique:users,email,' . $this->id,
            'phone' => 'required|regex:/^[\+\(\s\-\d\)]{5,30}$/'
        ];
    }

    public function messages()
    {
        return [
            'phone.regex' => 'Enter valid phone number',
        ];
    }
}
