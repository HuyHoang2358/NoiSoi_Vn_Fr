<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @method static where(string $string, string $string1, $id)
 * @method static create(array $array)
 */
class LabelAnswer extends Model
{
    use HasFactory;

    protected $table ='label_answers';
    protected $fillable =['image_id','label_id','user_id','accuracy'];

    public function label(): BelongsTo
    {
        return $this->belongsTo(Label::class,'label_id','id')->select(['id','name','type','class_id']);
    }
    public function image(): BelongsTo
    {
        return $this->belongsTo(Image::class);
    }
}
