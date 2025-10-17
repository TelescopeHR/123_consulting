<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CouponRequest extends FormRequest
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
			'type' => ['required', 'max:100', Rule::in(['percentage', 'price'])],
			'value' => ['required', 'numeric', 'between:0,99999.99'],
		];

		if ($this->type == 'percentage') {
			$validations['value'] = ['required', 'numeric', 'between:0,100'];
		}

		if ($this->expired_at) {
			$validations['expired_at'] = ['date_format:m/d/Y'];
		}

		switch ($this->method()) {
			case 'POST':
				$validations['code'] = ['required', Rule::unique('coupons', 'code')];

				return $validations;
			case 'PUT':
				$validations['code'] = ['required', Rule::unique('coupons', 'code')->ignore($this->coupon)->whereNull('deleted_at')];

				return $validations;
		}
	}

	public function messages()
	{
		return [
			'expired_at.date_format' => 'Enter valid date.'
		];
	}

	public function prepareForValidation()
	{
		$input = array_map('trim', $this->all());
		$input['code'] = strtoupper(str_replace(['-', '(', ')', ' '], '', $input['code']));
		$this->replace($input);
		return $this->all();
	}
}
