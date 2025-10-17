<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class ProfileRequest extends FormRequest
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
            'first_name' => 'required|max:190',
            'last_name' => 'required|max:190',
            'email' => 'required|email|max:190|unique:users,email,' . $this->id,
            'phone' => 'required|regex:/^[\+\(\s\-\d\)]{5,30}$/',
            'address' => 'nullable|max:190',
            'city' => 'nullable|max:190',
            'state' => 'nullable|max:190',
            'zipcode' => ['nullable', 'numeric'],
            'username' => ['nullable', 'max:150', Rule::unique('users', 'username')->ignore($this->id)->whereNull('deleted_at')]
        ];
    }

    public function messages()
    {
        return [
            'phone.regex' => 'Enter valid phone number',
        ];
    }
}
