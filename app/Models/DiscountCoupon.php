<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DiscountCoupon extends Model
{
    use HasFactory;

    protected $fillable = [
        'store_id',
        'code',
        'name',
        'description',
        'max_user',
        'max_user_user',
        'type',
        'discont_amount',
        'min_amount',
        'status',
        'start_at',
        'expires_at',
    ];

    public function store()
    {
        return $this->belongsTo(Store::class, 'store_id');
    }
}