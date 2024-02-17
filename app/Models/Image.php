<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

/**
 * @method static create(array $array)
 * @method static find($id)
 * @method static where(string $string, $id)
 * @property mixed $id
 * @property mixed $sub_images
 * @property mixed $parent_id
 * @property mixed $subImages
 * @property mixed $labelAnswers
 */
class Image extends Model
{
    protected $table ='images';
    protected $fillable =['user_id','project_id','file_name','file_path','size'];
    protected $appends = ['quality_label', 'is_confirmed', 'zone_label_id'];
    protected static function boot(): void
    {
        parent::boot();
        static::deleting(function($image){
            $image->project()->decrement('num_image');
            Storage::delete("public/".$image->project_id."/".$image->file_name);
            $image->imageLabels()->delete();
            $image->blocks()->delete();
        });
    }

    // relationship model
    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class,'project_id','id');
    }
    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class,'user_id','id');
    }
    public function blocks():HasMany
    {
        return $this->hasMany(Block::class, 'image_id', 'id');
    }
    public function imageLabels(): HasMany
    {
        return $this->hasMany(ImageLabel::class,'image_id','id');
    }
    public function zoneLabel(): Model|HasMany|null
    {
        return $this->imageLabels()->where('user_id','=', Auth::user()->id)
            ->whereHas('label', function($query){
                $query->zone();
            })->first();
    }

    // Attributes
    public function getQualityLabelAttribute()
    {
        $qualityLabel = $this->imageLabels()->whereHas('label',function ($query){$query->ImageQuality();})->first();
        return $qualityLabel?->label->name;
    }
    public function getIsConfirmedAttribute(): bool
    {
        if ($this->blocks()->count() == 0) return false;
        $block = $this->blocks()->first();
        if($block->confirmed_label) return true;
        return false;
    }
    public function getZoneLabelIdAttribute()
    {
        return $this->zoneLabel()?->label_id;
    }
}
