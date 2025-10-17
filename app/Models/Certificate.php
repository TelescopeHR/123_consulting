<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Quiz;

class Certificate extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'title',
        'image',
        'line1',
        'line2',
        'description'
    ];

    protected $dates = ['deleted_at'];

    protected $appends = ['full_image'];

    function quizzes()
    {
        return $this->hasMany(Quiz::class);
    }

    function getFullImageAttribute()
    {
        if (!empty($this->image) && file_exists(public_path('images/certificate/' . $this->image))) {
            return url('images/certificate/' . $this->image);
        } else {
            return url('images/default.jpg');
        }
    }
}
