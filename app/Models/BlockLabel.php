<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
/**
 * @method static where(string $string, mixed $quality)
 * @method static create(array $array)
 */
class BlockLabel extends Model
{
    protected $table='block_labels';
    protected $fillable = ['block_id','label_id','user_id','accuracy'];
  /*  protected $with = ['label'];*/

    public function label(): BelongsTo
    {
        return $this->belongsTo(Label::class);
    }
    public function scopeByAi($query)
    {
        return $query->where('user_id','=', -1);
    }
    public function scopeByUser($query)
    {
        return $query->where('user_id', '!=', -1);
    }

}
