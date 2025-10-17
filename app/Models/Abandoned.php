<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Abandoned extends Model
{
    use HasFactory;

    protected $fillable = [
        'ip',
        'user_id',
        'course_id',
        'policy_manual_id',
        'status'
    ];

    function user()
    {
        return $this->belongsTo(User::class);
    }

    function course()
    {
        return $this->belongsTo(Course::class);
    }

    function policy()
    {
        return $this->belongsTo(PolicyManual::class, 'policy_manual_id');
    }
}
