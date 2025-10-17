<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Slug extends Model {
	use HasFactory;

	protected $fillable = [
		'slug',
		'sluggable_id',
		'sluggable_type'
	];

	public function sluggable()
	{
		return $this->morphTo();
	}
}
