<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CartCouponAmount extends Model
{
    use HasFactory;

    protected $table = 'cart_coupon_amounts';


    protected $fillable = [
        'user_id',
        'cart_id',
        'original_total',
        'discounted_total',
        'coupon_amount',
        'coupon_code',
    ];


}
