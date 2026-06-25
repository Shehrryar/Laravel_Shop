<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class Stock extends Model
{
    use HasFactory;
    // Specify the associated table name
    protected $table = 'stocks';  // This is not necessary if the table name follows the convention, but explicitly setting it can help
    // Specify the fields that are mass assignable
    protected $fillable = [
        'store_id',
        'product_id',
        'quantity',
        'remaining_quantity',
        'sold_quantity',
        'color_id',
        'size_id',
        'status',
    ];
    // A stock belongs to a product
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function color()
    {
        return $this->hasMany(Color::class, 'product_id');
    }
    public function size()
    {
        return $this->hasMany(Size::class, 'product_id');
    }
    public function store()
    {
        return $this->belongsTo(Store::class, 'store_id');
    }

}
