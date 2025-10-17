<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserRequest extends FormRequest
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
		$validations = [
			'first_name' => ['required', 'max:150'],
			'last_name' => ['required', 'max:150'],
			'address' => ['max:150'],
			'city' => ['max:150'],
			'state' => ['max:150'],
			'zipcode' => ['nullable', 'numeric'],
		];

		if ($this->type == 'percentage') {
			$validations['value'] = ['required', 'numeric', 'between:0,100'];
		}

		switch ($this->method()) {
			case 'POST':
				$validations['email'] = ['required', 'email', 'max:150', Rule::unique('users', 'email')];
				$validations['phone'] = ['required', Rule::unique('users', 'phone')];
				$validations['username'] = ['nullable', 'alpha_num', 'max:150', Rule::unique('users', 'username')];

				return $validations;
			case 'PUT':
				$validations['email'] = ['required', 'email', 'max:150', Rule::unique('users', 'email')->ignore($this->user)->whereNull('deleted_at')];
				$validations['phone'] = ['required', Rule::unique('users', 'phone')->ignore($this->user)->whereNull('deleted_at')];
				$validations['username'] = ['nullable', 'alpha_num', 'max:150', Rule::unique('users', 'username')->ignore($this->user)->whereNull('deleted_at')];

				return $validations;
		}
	}

	public function messages()
	{
		return [];
	}
}
