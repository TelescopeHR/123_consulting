<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Resource extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'category_id',
        'title',
        'description',
        'pdf'
    ];

    function courses() {
        return $this->belongsToMany(Course::class, 'course_resources');
    }

    function category() {
        return $this->belongsTo(Category::class);
    }
}
