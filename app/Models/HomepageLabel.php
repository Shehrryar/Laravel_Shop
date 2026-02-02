<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class HomepageLabel extends Model
{
    use HasFactory;
    protected $table = 'homepage_labels';
    protected $fillable = [
        'label_key',
        'label_name',        // fallback/default
        'en_label_name',
        'ur_label_name',
        'is_active',
        'sort_order',
    ];
    protected $appends = ['translated_name'];
    /**
     * Get translated label name based on app locale.
     */
    public function getTranslatedNameAttribute()
    {
        $locale = app()->getLocale(); // en | ur
        return match ($locale) {
            'en' => $this->en_label_name ?: $this->label_name,
            'ur' => $this->ur_label_name ?: $this->label_name,
            default => $this->label_name,
        };
    }
}