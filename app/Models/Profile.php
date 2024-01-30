<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @method static create(array $array)
 */
class Profile extends Model
{
    use HasFactory;
    protected $table = 'profiles';
    protected $fillable = ['user_id', 'phone', 'address'];
}
