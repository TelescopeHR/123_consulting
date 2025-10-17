<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CourseRequest extends FormRequest
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
        $validations =  [
            'title' => 'required|max:200',
            'description' => 'required',
            'category_id' => 'required',
            'quiz_id' => 'required',
            'price' => 'required|numeric|between:1,9999.99',
			'image' => 'nullable|mimes:jpeg,jpg,png,gif|max:10000'
        ];

        if ($this->tax) {
            $validations['tax'] = 'nullable|numeric|lt:price|between:1,9999.99';
        }

        return $validations;
    }

    public function messages()
    {
        return [
            'tax.lt'  => 'Tax should be less than price.',
        ];
    }
}
