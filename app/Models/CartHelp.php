<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CartHelp extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'order_id',
        'help'
    ];

    public function user()
	{
		return $this->belongsTo(User::class);
	}
}
