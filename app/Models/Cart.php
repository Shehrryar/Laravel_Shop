<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class Cart extends Model
{
    use HasFactory;
    protected $table = 'cart';
    protected $fillable = [
        'user_id',
        'product_id',
        'product_attribute_id',
        'title',
        'color_id',
        'size_id',
        'quantity',
        'price',
        'product_image'
    ];
}
