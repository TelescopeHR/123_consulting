<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CartRequest extends FormRequest
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
		$rules = [];

		if (!empty($this->course)) {
			foreach ($this->course as $key_courses => $course) {
				foreach ($course as $key_user => $user) {
					$rules['course.' . $key_courses . '.' . $key_user . '.first_name'] = 'required|max:255';
					$rules['course.' . $key_courses . '.' . $key_user . '.last_name'] = 'required|max:255';
					$rules['course.' . $key_courses . '.' . $key_user . '.email'] = 'nullable|email|max:255';
				}
			}
		}

		return $rules;
	}

	public function messages()
	{
		return [
			'course.*.*.first_name.required' => 'First name is required.',
			'course.*.*.last_name.required' => 'Last name is required.',
			'course.*.*.email.email' => 'Enter valid email.'
		];
	}
}
