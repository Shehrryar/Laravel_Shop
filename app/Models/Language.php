<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Language extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'en_name_translation',
        'ur_name_translation',
        'code',      // e.g., 'en', 'ur'
        'status'
    ];

    protected $appends = ['translated_name'];

    /**
     * Accessor for translated language name.
     * Returns the name based on current app locale ('en' or 'ur').
     * Falls back to default name if translation is missing.
     */
    public function getTranslatedNameAttribute()
    {
        $locale = app()->getLocale(); // Current locale

        return match ($locale) {
            'en' => $this->en_name_translation ?: $this->name,
            'ur' => $this->ur_name_translation ?: $this->name,
            default => $this->name,
        };
    }
}
