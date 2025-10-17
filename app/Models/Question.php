<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Question extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'quiz_id',
        'answer_type',
        'title'
    ];

    function answers()
    {
        return $this->hasMany(Answer::class);
    }

    function correct_answers()
    {
        return $this->hasMany(Answer::class)->where('is_true', 1);
    }

    function quiz()
    {
        return $this->belongsTo(Quiz::class);
    }
}
