<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @method static create(array $array)
 * @method static find($zone_label_id)
 */
class ImageLabel extends Model
{
    protected $table='image_labels';
    protected $fillable = ['image_id','label_id','user_id','accuracy'];
    protected $with = ['label'];

    public function label(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Label::class,'label_id','id');
    }

    public function scopeByUser($query)
    {
        return $query->where('user_id', '!=', -1);
    }



}
