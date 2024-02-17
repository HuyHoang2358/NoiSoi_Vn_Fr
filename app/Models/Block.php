<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Auth;

/**
 * @method static create(array $array)
 * @method static where(string $string, string $string1, $id)
 */
class Block extends Model
{
    protected $table ='blocks';
    protected $fillable =['image_id','no_img','size','top','left', 'width','height'];
    protected $appends = ['ai_quality_label', 'ai_gastritis_label', 'user_gastritis_label','confirmed_label'];


    protected static function boot(): void
    {
        parent::boot();
        static::deleting(function($block){
            $block->blockLabels()->delete();
        });
    }


    // Relationship model
    protected function blockLabels(): HasMany
    {
        return $this->hasMany(BlockLabel::class, 'block_id', 'id');
    }



    // Get Attributes
    protected function getAiQualityLabelAttribute()
    {
        return $this->blockLabels()->byAi()->whereHas('label', function ($query) {
            $query->blockQuality();
        })->select('label_id')->first();
    }
    protected function getAiGastritisLabelAttribute()
    {
        return $this->blockLabels()->byAi()->whereHas('label', function ($query) {
            $query->gastritis();
        })->with('label')->first();
    }
    protected function getUserGastritisLabelAttribute()
    {
        return $this->blockLabels()->byUser()->whereHas('label', function ($query) {
            $query->gastritis();
        })->with('label')->first();
    }
    protected function getAiLabelAttribute(): Model|HasMany|null
    {
        return $this->blockLabels()->where('user_id', -1)->first();
    }
    protected function getConfirmedLabelAttribute(): Model|HasMany|null
    {
        return $this->blockLabels()->where('user_id',  Auth::user()->id)->first();
    }
}
