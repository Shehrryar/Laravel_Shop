<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubSubCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'en_name_translation',
        'ur_name_translation',
        'subcategory_id',
        'slug',
        'status'
    ];

    protected $appends = ['translated_name'];

    /**
     * Accessor for translated name.
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
     * Relationship to subcategory
     */
    public function subCategory()
    {
        return $this->belongsTo(SubCategory::class, 'subcategory_id');
    }
}
