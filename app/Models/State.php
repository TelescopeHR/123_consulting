<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class State extends Model {
	use HasFactory, SoftDeletes;

	/**
	 * @var array
	 */
	protected $fillable = [
		'name',
		'country_id'
	];
}
