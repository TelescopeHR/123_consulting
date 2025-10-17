<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PolicyManual extends Model
{
	use HasFactory, SoftDeletes;

	protected $fillable = [
		'course_id',
		'title',
		'price',
		'tax',
		'document',
		'description',
		'is_in_fbt'
	];

	protected function getTaxAttribute($value)
	{
		return $value == NULL ? 0 : $value;
	}

	/**
	 * @return mixed
	 */
	public function slug_relation()
	{
		return $this->morphOne(Slug::class, 'sluggable');
	}

	public function course()
	{
		return $this->belongsTo(Course::class);
	}
}
