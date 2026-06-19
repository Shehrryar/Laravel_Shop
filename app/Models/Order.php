<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class Order extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'subtotal',
        'shipping',
        'coupon_code',
        'discount',
        'grandtotal',
        'firstname',
        'en_firstname_translation',
        'ur_firstname_translation',
        'lastname',
        'en_lastname_translation',
        'ur_lastname_translation',
        'email',
        'country_id',
        'apartment',
        'en_apartment_translation',
        'ur_apartment_translation',
        'address',
        'en_address_translation',
        'ur_address_translation',
        'city',
        'en_city_translation',
        'ur_city_translation',
        'state',
        'en_state_translation',
        'ur_state_translation',
        'zip',
        'notes',
        'en_notes_translation',
        'ur_notes_translation',
    ];
    protected $appends = [
        'translated_firstname',
        'translated_lastname',
        'translated_address',
        'translated_city',
        'translated_state',
        'translated_notes',
    ];
    public function getTranslatedFirstnameAttribute()
    {
        return $this->getTranslation('firstname');
    }
    public function getTranslatedLastnameAttribute()
    {
        return $this->getTranslation('lastname');
    }
    public function getTranslatedAddressAttribute()
    {
        return $this->getTranslation('address');
    }
    public function getTranslatedCityAttribute()
    {
        return $this->getTranslation('city');
    }
    public function getTranslatedStateAttribute()
    {
        return $this->getTranslation('state');
    }
    public function getTranslatedNotesAttribute()
    {
        return $this->getTranslation('notes');
    }




    protected function getTranslation($field)
    {
        $locale = app()->getLocale(); // en / ur
        if ($locale === 'en' && !empty($this->{'en_' . $field . '_translation'})) {
            return $this->{'en_' . $field . '_translation'};
        }
        if ($locale === 'ur' && !empty($this->{'ur_' . $field . '_translation'})) {
            return $this->{'ur_' . $field . '_translation'};
        }
        return $this->$field; 
    }
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}