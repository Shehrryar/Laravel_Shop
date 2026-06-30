<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Onboarding extends Model
{
    use HasFactory;

    protected $table = 'table_onboarding';

    protected $fillable = [
        'store_id',
        'image',
        'title',
        'subtitle',
    ];

    public function store()
    {
        return $this->belongsTo(Store::class, 'store_id');
    }
}