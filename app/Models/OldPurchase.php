<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OldPurchase extends Model
{
    use HasFactory;

    protected $fillable = [
        'old_user_id',
        'user_id',
        'email',
        'course',
        'completed_date'
    ];

    protected $dates = ['completed_date'];

    public function user()
	{
		return $this->belongsTo(User::class);
	}
}
