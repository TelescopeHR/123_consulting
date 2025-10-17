<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class StripeResponse extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'cart_items',
        'user_id',
        'coupon_id',
        'order_id',
        'qty',
        'sub_total',
        'tax',
        'discount',
        'total_amount',
        'invoice',
        'session_data',
        'response_id',
        'type',
        'stripe_response',
        'payment_status',
        'status'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function user_courses()
    {
        return $this->hasMany(UserCourse::class, 'order_id');
    }

    public function user_policies()
    {
        return $this->hasMany(UserPolicy::class, 'order_id');
    }

    public function coupon()
    {
        return $this->belongsTo(Coupon::class);
    }
}
