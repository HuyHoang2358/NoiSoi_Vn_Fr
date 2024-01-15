<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @method static create(array $validate)
 * @method static find($id)
 */
class Label extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'class_id',
        'type',
    ];
}
