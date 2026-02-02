<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class CustomerAddress extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'firstname',
        'en_firstname_translation',
        'ur_firstname_translation',
        'lastname',
        'en_lastname_translation',
        'ur_lastname_translation',
        'email',
        'mobile',
        'country_id',
        'address',
        'en_address_translation',
        'ur_address_translation',
        'apartment',
        'state',
        'en_state_translation',
        'ur_state_translation',
        'city',
        'en_city_translation',
        'ur_city_translation',
        'zip',
        'address_type',
        'is_default',
        'landmark',
        'pin_code',
        'flat',
        'area',
    ];
    protected $appends = [
        'translated_firstname',
        'translated_lastname',
        'translated_address',
        'translated_city',
        'translated_state',
        'translated_notes',
        'translated_apartment',
    ];
    public function getTranslatedFirstnameAttribute()
    {
        $locale = app()->getLocale();
        return match ($locale) {
            'en' => $this->en_firstname_translation ?: $this->firstname,
            'ur' => $this->ur_firstname_translation ?: $this->firstname,
            default => $this->firstname,
        };
    }
    public function getTranslatedLastnameAttribute()
    {
        $locale = app()->getLocale();
        return match ($locale) {
            'en' => $this->en_lastname_translation ?: $this->lastname,
            'ur' => $this->ur_lastname_translation ?: $this->lastname,
            default => $this->lastname,
        };
    }
    public function getTranslatedAddressAttribute()
    {
        $locale = app()->getLocale();
        return match ($locale) {
            'en' => $this->en_address_translation ?: $this->address,
            'ur' => $this->ur_address_translation ?: $this->address,
            default => $this->address,
        };
    }
    public function getTranslatedCityAttribute()
    {
        $locale = app()->getLocale();
        return match ($locale) {
            'en' => $this->en_city_translation ?: $this->city,
            'ur' => $this->ur_city_translation ?: $this->city,
            default => $this->city,
        };
    }
    public function getTranslatedStateAttribute()
    {
        $locale = app()->getLocale();
        return match ($locale) {
            'en' => $this->en_state_translation ?: $this->state,
            'ur' => $this->ur_state_translation ?: $this->state,
            default => $this->state,
        };
    }
    public function getTranslatedNotesAttribute()
    {
        $locale = app()->getLocale();
        return match ($locale) {
            'en' => $this->en_notes_translation ?: $this->notes,
            'ur' => $this->ur_notes_translation ?: $this->notes,
            default => $this->notes,
        };
    }
    public function getTranslatedApartmentAttribute()
    {
        $locale = app()->getLocale();
        return match ($locale) {
            'en' => $this->en_apartment_translation ?: $this->apartment,
            'ur' => $this->ur_apartment_translation ?: $this->apartment,
            default => $this->apartment,
        };
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}