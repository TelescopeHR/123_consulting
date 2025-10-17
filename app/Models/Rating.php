<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Rating extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable  = [
        'review_id',
        'review_question_id',
        'ratings',
    ];

    public function review_question()
    {
        return $this->belongsTo(ReviewQuestion::class);
    }
}
