<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Blog extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'title',
        'description',
        'image',
        'is_premium',
        'author_name',
        'publish_date',
        'status'
    ];

    protected $appends = ['full_image'];
    protected $dates = ['publish_date'];

    function getFullImageAttribute()
    {
        if (!empty($this->image) && file_exists(public_path('images/blog/' . $this->image))) {
            return url('images/blog/' . $this->image);
        } else {
            return url('images/default.jpg');
        }
    }

    function tags() {
        return $this->belongsToMany(Tag::class, 'blog_tags');
    }

    function categories() {
        return $this->belongsToMany(Category::class, 'blog_categories');
    }

    /**
	 * @return mixed
	 */
	public function slug_relation() {
		return $this->morphOne(Slug::class, 'sluggable');
	}
}
