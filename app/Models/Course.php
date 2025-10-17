<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Course extends Model
{
	use HasFactory, SoftDeletes;

	protected $fillable = [
		'title',
		'description',
		'image',
		'price',
		'tax',
		'is_in_fbt',
		'test_product_id',
		'test_plan_id',
		'live_product_id',
		'live_plan_id',
		'seo_title',
		'seo_description',
		'is_active',
		'order'
	];

	protected $appends = ['full_image'];

	protected function getTaxAttribute($value)
	{
		return $value == NULL ? 0 : $value;
	}

	function getFullImageAttribute()
	{
		if (!empty($this->image) && file_exists(public_path('images/course/' . $this->image))) {
			return url('images/course/' . $this->image);
		} else {
			return url('images/default.jpg');
		}
	}

	function tags()
	{
		return $this->belongsToMany(Tag::class, 'course_tags');
	}

	function categories()
	{
		return $this->belongsToMany(Category::class, 'course_categories');
	}

	function quizzes()
	{
		return $this->belongsToMany(Quiz::class, 'course_quizzes');
	}

	function lessons()
	{
		return $this->hasMany(Lesson::class, 'course_id');
	}

	/**
	 * @return mixed
	 */
	public function slug_relation()
	{
		return $this->morphOne(Slug::class, 'sluggable');
	}

	public function reviews()
	{
		return $this->hasMany(Review::class, 'course_id');
	}

	public function ratings()
	{
		return $this->hasManyThrough(Rating::class, Review::class, 'course_id', 'review_id');
	}

	public function user_courses()
	{
		return $this->hasMany(UserCourse::class, 'course_id');
	}

	public function user_subscription_courses()
	{
		return $this->hasMany(UserSubscription::class, 'course_id');
	}

	public function policy_manuals()
	{
		return $this->hasMany(PolicyManual::class, 'course_id');
	}
}
