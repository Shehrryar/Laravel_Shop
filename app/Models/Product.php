<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
// use App\Models\Traits\HasJsonTranslation;

use App\Models\Discount;
class Product extends Model
{
    use HasFactory;
    protected $fillable = [
        'title',
        'en_title_translation',
        'ur_title_translation',
        'slug',
        'description',
        'en_description_translation',
        'ur_description_translation',
        'short_description',
        'shipping_returns',
        'related_products',
        'price',
        'compare_price',
        'categories_id',
        'sub_category_id',
        'brands_id',
        'is_featured',
        'sku',
        'barcode',
        'track_qty',
        'qty',
        'status',
        
    ];

    
    // protected $casts = [
    //     'title_translations' => 'array',
    //     'description_translations' => 'array',
    // ];
    protected $appends = ['avg_rating', 'translated_title', 'translated_description'];
    



    public function getTranslatedTitleAttribute()
    {
        $locale = app()->getLocale(); // get current app locale
        return match ($locale) {
            'en' => $this->en_title_translation ?: $this->title,
            'ur' => $this->ur_title_translation ?: $this->title,
            default => $this->title,
        };
    }

    public function getTranslatedDescriptionAttribute()
    {
        $locale = app()->getLocale(); // get current app locale

        return match ($locale) {
            'en' => $this->en_description_translation ?: $this->description,
            'ur' => $this->ur_description_translation ?: $this->description,
            default => $this->description,
        };

    }


    public function product_images()
    {
        return $this->hasMany(ProductImage::class);
    }
    public function product_ratings()
    {
        return $this->hasMany(ProductRating::class);
    }
    public function product_attributes()
    {
        return $this->hasMany(ProductAttribute::class, 'product_id', 'id');
    }
    public function color()
    {
        return $this->hasMany(Color::class, 'product_id')->where('status', 1);
    }
    public function size()
    {
        return $this->hasMany(Size::class, 'product_id')->where('status', 1);
    }
    public function product_recommendation()
    {
        return $this->hasMany(ProductView::class, 'product_id')->where('user_id', auth()->id());
    }
    public function applyDiscount()
    {
        $discount = Discount::where('status', 1)->get();
        $discountData = getDiscountedPrice($this->id, $discount, $this->price);
        $this->discount_value = $discountData['discount_value'];
        $this->discounted_price = $discountData['discounted_price'];
        $this->actual_price = $discountData['actual_price'];
        return $this;
    }
    public function getAvgRatingAttribute()
    {
        if ($this->product_ratings_count > 0) {
            $avg = $this->product_ratings_sum_rating / $this->product_ratings_count;
            return max(0, min(5, round($avg, 2)));
        }
        return 0;
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class, 'brands_id');
    }

}