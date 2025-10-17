<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddPhoneRequest extends FormRequest
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
            'phone' => 'required|numeric|digits_between:8,15'
        ];
    }

    public function prepareForValidation()
	{
		$input = array_map('trim', $this->all());
		$input['phone'] = str_replace([' ', '(', ')', '+', '-'], '', $input['phone']);
		$this->replace($input);
		return $this->all();
	}
}
