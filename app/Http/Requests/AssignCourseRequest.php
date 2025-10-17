<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AssignCourseRequest extends FormRequest
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
        $rules['name.*.first_name'] = 'required|max:255';
        $rules['name.*.last_name'] = 'required|max:255';
        $rules['name.*.email'] = 'nullable|email|max:255';

        return $rules;
    }

    public function messages()
    {
        return [
            'name.*.first_name.required' => 'First name is required.',
            'name.*.last_name.required'  => 'Last name is required.',
            'name.*.email.email'  => 'Please enter valid email.',
        ];
    }
}
