<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PolicyManualRequest extends FormRequest
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
            'price' => 'nullable|numeric|between:1,9999.99',
        ];

        if ($this->tax) {
            $validations['tax'] = 'numeric|lt:price|between:1,9999.99';
        }

        switch ($this->method()) {
            case 'POST':
                $validations['document'] = 'required|mimes:doc,docx,pdf,mp4,ogx,oga,ogv,ogg,webm,zip|max:20480';

            case 'PUT':
                $validations['document'] = 'nullable|mimes:doc,docx,pdf,mp4,ogx,oga,ogv,ogg,webm,zip|max:20480';
        }
        return $validations;
    }
}
