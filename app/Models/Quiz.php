<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Certificate;

class Quiz extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'title',
        'passing_score',
        'certificate_id',
        'description'
    ];

    function questions()
    {
        return $this->hasMany(Question::class, 'quiz_id');
    }

    function certificate()
    {
        return $this->belongsTo(Certificate::class);
    }

    public function slug_relation()
    {
        return $this->morphOne(Slug::class, 'sluggable');
    }

    public function courses()
    {
        return $this->belongsToMany(Course::class, 'course_quizzes');
    }
}
