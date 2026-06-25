<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Discount extends Model
{
    use HasFactory;
    protected $fillable = [
        'store_id',
        'name',
        'value',
        'type',
        'product_ids',
        'category_ids',
        'status',
        'start_at',
        'expires_at',
    ];

    protected $casts = [
        'product_ids' => 'array',
        'category_ids' => 'array',
    ];

    public function applyDiscount($price)
    {
        if ($this->type == 'percentage') {
            return $price - ($price * $this->value / 100);
        } else {
            return max(0, $price - $this->value);
        }
    }

    public function appliesToProduct($productId)
    {
        return in_array($productId, $this->product_ids ?? []);
    }

    public function appliesToCategory($categoryId)
    {
        return in_array($categoryId, $this->category_ids ?? []);
    }
    public function store()
    {
        return $this->belongsTo(Store::class, 'store_id');
    }

}