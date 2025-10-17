<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Lesson extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'course_id',
        'title',
        'description',
        'video',
        'order'
    ];

    function course()
    {
        return $this->belongsTo(Course::class);
    }

    function quizzes()
    {
        return $this->belongsToMany(Quiz::class, 'lesson_quizzes');
    }
    
    /**
	 * @return mixed
	 */
	public function slug_relation() {
		return $this->morphOne(Slug::class, 'sluggable');
	}
}
