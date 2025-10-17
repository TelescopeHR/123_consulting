<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'type',
        'name'
    ];

    function courses() {
        return $this->belongsToMany(Course::class, 'course_categories')->orderBy('order');
    }

    function blogs() {
        return $this->belongsToMany(Blog::class, 'blog_categories')->latest();
    }
    
    /**
	 * @return mixed
	 */
	public function slug_relation() {
		return $this->morphOne(Slug::class, 'sluggable');
	}
}
