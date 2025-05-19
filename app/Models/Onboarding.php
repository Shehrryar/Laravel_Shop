<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class Onboarding extends Model
{
    use HasFactory;
    // If your table name is not the plural of the model name (onboardings),
    // explicitly define it
    protected $table = 'table_onboarding';
    // If the table does not have timestamps (created_at, updated_at)
    // set this to false
    public $timestamps = true; // or false if not needed
    // If your primary key is not `id`, specify it here
    protected $primaryKey = 'id'; // change if different
    // Define which attributes are mass assignable
    protected $fillable = ['image', 'title', 'subtitle'];
}