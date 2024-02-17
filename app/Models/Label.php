<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @method static create(array $validate)
 * @method static find($id)
 * @method static where(string $string, string $string1, mixed $AI_class_id)
 * @method static zone()
 * @method static gastritis()
 * @method static blockQuality()
 * @method static imageQuality()
 * @property mixed $category
 */
class Label extends Model
{
    protected $fillable = [
        'name',
        'class_id',
        'category_id',
        'status'
    ];
    protected $appends = ['category_name'];

    public function getCategoryNameAttribute()
    {
        return $this->category->name;
    }

    public function category(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function scopeBlockQuality($query)
    {
        return $query->where('category_id', 2);
    }

    public function scopeImageQuality($query)
    {
        return $query->where('category_id', 1);
    }

    public function scopeZone($query)
    {
        return $query->where('category_id', 4);
    }

    public function scopeGastritis($query)
    {
        return $query->where('category_id', 3);
    }

}
