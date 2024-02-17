<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @method static create(array $validate)
 * @method static find($id)
 * @method static where(string $string, $category_slug)
 */
class Category extends Model
{
    protected $table = 'categories';
    protected $fillable = ['name', 'slug'];
}
