<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @method static create(array $validate)
 * @method static where(string $string, $id)
 * @method static find($id)
 */
class Project extends Model
{
    use HasFactory;
    protected $table = 'projects';
    protected $fillable = [
        'name',
        'description',
        'user_id',
    ];

    protected $with = ['user'];
    protected $appends = ['confirmed_image', "num_image"];



    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function images(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Image::class,'project_id','id');
    }

    public function getConfirmedImageAttribute(): int
    {
        return 0;
    }
    public function getNumImageAttribute(): int
    {
        return $this->images()->count();
    }

}
