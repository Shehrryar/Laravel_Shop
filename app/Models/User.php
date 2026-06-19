<?php
namespace App\Models;
// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Models\Traits\HasJsonTranslation;
class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasJsonTranslation;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'en_name_translation',
        'ur_name_translation',
        'first_name',
        'en_first_name_translation',
        'ur_first_name_translation',
        'last_name',
        'en_last_name_translation',
        'ur_last_name_translation',
        'gender',
        'en_gender_translation',
        'ur_gender_translation',
        'email',
        'phone',
        'password',
        'github_id',
        'facebook_id',
        'googel_id',
        'fcm_token',
        'date_of_birth',
    ];
    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];
    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'name_translations' => 'array',
        'first_name_translations' => 'array',
        'last_name_translations' => 'array',
        'gender_translations' => 'array',
    ];
    protected $appends = [
        'translated_name',
        'translated_first_name',
        'translated_last_name',
        'translated_gender',
    ];
    /**
     * Translated full name
     */
    public function getTranslatedNameAttribute()
    {
        $locale = app()->getLocale();
        return match ($locale) {
            'en' => $this->en_name_translation ?: $this->name,
            'ur' => $this->ur_name_translation ?: $this->name,
            default => $this->name,
        };
    }
    /**
     * Translated first name
     */
    public function getTranslatedFirstNameAttribute()
    {
        $locale = app()->getLocale();
        return match ($locale) {
            'en' => $this->en_first_name_translation ?: $this->first_name,
            'ur' => $this->ur_first_name_translation ?: $this->first_name,
            default => $this->first_name,
        };
    }
    /**
     * Translated last name
     */
    public function getTranslatedLastNameAttribute()
    {
        $locale = app()->getLocale();
        return match ($locale) {
            'en' => $this->en_last_name_translation ?: $this->last_name,
            'ur' => $this->ur_last_name_translation ?: $this->last_name,
            default => $this->last_name,
        };
    }
    /**
     * Translated gender
     */
    public function getTranslatedGenderAttribute()
    {
        $locale = app()->getLocale();
        return match ($locale) {
            'en' => $this->en_gender_translation ?: $this->gender,
            'ur' => $this->ur_gender_translation ?: $this->gender,
            default => $this->gender,
        };
    }
}