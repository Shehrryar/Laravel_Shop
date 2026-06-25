<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'store_id',
        'name',
        'en_name_translation',
        'ur_name_translation',
        'slug',
        'image',
        'status',
    ];

    protected $appends = ['translated_name'];

    /**
     * Accessor for translated category name.
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
     * Relationship: A category has many sub-categories
     */
    public function sub_category()
    {
        return $this->hasMany(SubCategory::class, 'category_id', 'id');
    }
}
