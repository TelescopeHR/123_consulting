<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserCourseQuizAnswer extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'caregiver_id',
        'user_course_id',
        'course_id',
        'quiz_id',
        'answers',
        'score'
    ];

    public function user_course()
    {
        return $this->hasOne(UserCourse::class, 'id', 'user_course_id');
    }

    public function quiz()
    {
        return $this->hasOne(Quiz::class, 'id', 'quiz_id');
    }
}
