<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserCourse extends Model
{
	use HasFactory, SoftDeletes;

	/**
	 * @var array
	 */
	protected $fillable = [
		'user_id',
		'order_id',
		'caregiver_id',
		'course_id',
		'completed_lessons',
		'completed_lesson_ids',
		'last_active',
		'certificate',
		'purchase_date',
		'start_date',
		'end_date',
		'certificate_name',
		'is_completed'
	];

	protected $dates = [
		'purchase_date',
		'start_date',
		'end_date'
	];

	public function course()
	{
		return $this->belongsTo(Course::class);
	}

	public function user()
	{
		return $this->belongsTo(User::class);
	}

	public function caregiver()
	{
		return $this->belongsTo(User::class, 'caregiver_id');
	}

	public function user_course_quiz_answer()
	{
		return $this->hasMany(UserCourseQuizAnswer::class, 'user_course_id')->latest();
	}

	public function order()
	{
		return $this->hasOne(StripeResponse::class, 'id', 'order_id');
	}
}
