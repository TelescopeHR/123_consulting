<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CmsPages extends Model
{
	use HasFactory, SoftDeletes;

	/**
	 * @var array
	 */
	protected $fillable = [
		'name',
		'page_content',
		'meta_name',
		'meta_title',
		'meta_description'
	];

	/**
	 * @return mixed
	 */
	public function slug_relation() {
		return $this->morphOne(Slug::class, 'sluggable');
	}
}
