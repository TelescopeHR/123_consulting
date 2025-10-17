<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CmsPageRequest extends FormRequest
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
			'name' => ['required', 'max:100'],
			'page_content' => ['required'],
			'meta_name' => ['required', 'max:100'],
			'meta_title' => ['required', 'max:100'],
			'meta_description' => ['required']
		];

		return $validations;
	}
}
