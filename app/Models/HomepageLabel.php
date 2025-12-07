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
        'label_name',
        'is_active',
        'sort_order',
    ];
}