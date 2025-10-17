<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CertificateRequest extends FormRequest
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
            case 'POST':
                return [
                    'title' => 'required',
                    'description' => 'required|min:100|max:800',
                    'line1' => 'required',
                    'line2' => 'required',
                    'image' => 'required|mimes:jpeg,jpg,png,gif|max:10000'
                ];
            case 'PUT':
                return [
                    'title' => 'required',
                    'description' => 'required|min:100|max:800',
                    'line1' => 'required',
                    'line2' => 'required',
                    'image' => 'nullable|mimes:jpeg,jpg,png,gif|max:10000'
                ];
        }
    }
}
