<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubCategory extends Model
{
    use HasFactory;
    public function sub_sub_category(){
        return $this->hasMany(SubSubCategory::class, 'subcategory_id');
    }
}
