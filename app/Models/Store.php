<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Store extends Model
{
    use HasFactory;

    protected $fillable = [
        'store_name',
        'slug',
        'owner_name',
        'email',
        'phone',
        'logo',
        'banner',
        'address',
        'city',
        'country',
        'commission_rate',
        'status',
    ];

    /*
    |--------------------------------------------------------------------------
    | Store has many vendor users
    |--------------------------------------------------------------------------
    | role = 3 users are vendors/store owners.
    */
    public function vendors()
    {
        return $this->hasMany(User::class, 'store_id');
    }

    /*
    |--------------------------------------------------------------------------
    | Store has one main owner
    |--------------------------------------------------------------------------
    | This returns the first vendor connected with this store.
    */
    public function owner()
    {
        return $this->hasOne(User::class, 'store_id')->where('role', 3);
    }
}