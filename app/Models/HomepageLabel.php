<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HomepageLabel extends Model
{
    use HasFactory;

    protected $table = 'homepage_labels';

    protected $fillable = [
        'store_id',
        'label_key',
        'label_name',
        'en_label_name',
        'ur_label_name',
        'is_active',
        'sort_order',
    ];

    protected $appends = ['translated_name'];

    public function getTranslatedNameAttribute()
    {
        $locale = app()->getLocale();

        return match ($locale) {
            'en' => $this->en_label_name ?: $this->label_name,
            'ur' => $this->ur_label_name ?: $this->label_name,
            default => $this->label_name,
        };
    }

    public function store()
    {
        return $this->belongsTo(Store::class, 'store_id');
    }
}