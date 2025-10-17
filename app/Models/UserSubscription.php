<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserSubscription extends Model
{
	use HasFactory, SoftDeletes;

	/**
	 * @var array
	 */
	protected $fillable = [
		'order_id',
		'user_id',
		'course_id',
		'purchase_date'
	];

	public function course()
	{
		return $this->belongsTo(Course::class);
	}

	public function user()
	{
		return $this->belongsTo(User::class);
	}
}