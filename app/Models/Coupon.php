<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Coupon extends Model {
	use HasFactory;

	/**
	 * @var array
	 */
	protected $fillable = [
		'code',
		'type',
		'value',
		'expired_at'
	];

	/**
	 * @var array
	 */
	protected $dates = ['expired_at'];

}
