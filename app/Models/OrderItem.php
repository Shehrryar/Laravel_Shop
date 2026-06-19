<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class OrderItem extends Model
{
    use HasFactory;
    protected $table = 'orders_items';
    protected $fillable = [
        'order_id',
        'product_id',
        'cart_id',
        'name',
        'quantity',
        'price',
        'total',
        'discounted_price',
        'discounted_value',
        'additional_attributes',
    ];
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}