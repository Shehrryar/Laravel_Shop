<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'en_name_translation',
        'ur_name_translation',
        'category_id',
        'slug',
        'status',
    ];

    protected $appends = ['translated_name'];

    /**
     * Accessor for translated subcategory name.
     * Returns the name in the current app locale if available,
     * otherwise falls back to the default name.
     */
    public function getTranslatedNameAttribute()
    {
        $locale = app()->getLocale(); // 'en' or 'ur'

        return match ($locale) {
            'en' => $this->en_name_translation ?: $this->name,
            'ur' => $this->ur_name_translation ?: $this->name,
            default => $this->name,
        };
    }

    /**
     * Relation with sub-subcategories
     */
    public function sub_sub_category()
    {
        return $this->hasMany(SubSubCategory::class, 'subcategory_id');
    }

    /**
     * Relation with parent category
     */
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }
}
