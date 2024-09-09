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
        'product_id',
        'quantity',
        'remaining_quantity',
        'sold_quantity',
        'status',
    ];
    // A stock belongs to a product
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
