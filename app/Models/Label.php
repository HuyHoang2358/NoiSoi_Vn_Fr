<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @method static create(array $validate)
 * @method static find($id)
 * @method static where(string $string, string $string1)
 */
class Label extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'class_id',
        'type',
    ];
    public function scopeQuality($query)
    {
        return $query->where('type', 'quality');
    }
    public function scopeGastritis($query)
    {
        return $query->where('type', 'gastritis');
    }

}
