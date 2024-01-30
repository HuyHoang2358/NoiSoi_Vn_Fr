<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use SebastianBergmann\Type\TrueType;

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
    use HasFactory;
    protected $table ='images';
    protected $fillable =['user_id','project_id','parent_id','file_name','file_path','size','top','left','width','height'];

    protected $appends = ['quality_label','sub_images', 'gastritis_label', 'is_confirmed'];


    public function deleteSubImages(): void
    {
        foreach ($this->subImages as $sub_image){
            $sub_image->delete();
        }
    }
    public function deleteLabelAnswers(): void
    {
        foreach ($this->labelAnswers as $labelAnswer){
            $labelAnswer->delete();
        }
    }

    public static function boot(): void
    {
        parent::boot();
        static::deleting(function($image){
            $image->deleteLabelAnswers();
            $image->deleteSubImages();
        });
    }

    private function confirmedLabel(){
        return LabelAnswer::where('image_id','=',$this->id)
            ->where('user_id','>',-1)
            ->whereHas('label',function ($query){
                $query->gastritis();
            })->with('label')->first();
    }

    // Relationship model

    public function project(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Project::class,'project_id','id');
    }

    public function subImages(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Image::class,'parent_id','id');
    }

    public function author(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class,'user_id','id');
    }

    public function labelAnswers(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(LabelAnswer::class,'image_id','id');
    }



    // Add attribute

    public function getSubImagesAttribute()
    {
        return Image::where('parent_id',$this->id)->get();
    }

    public function getGastritisLabelAttribute(){
        if($this->confirmedLabel()) return $this->confirmedLabel();
        return LabelAnswer::where('image_id','=',$this->id)
            ->where('user_id','=',-1)
            ->whereHas('label',function ($query){
                $query->gastritis();
            })->with('label')->first();
    }


    public function getIsConfirmedAttribute(): bool
    {
        if ($this->parent_id) return !($this->confirmedLabel() == null);

        foreach ($this->sub_images as $sub_image) {
            if ($sub_image->is_confirmed) return true;
        }
        return false;

    }

    public function AILabels(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(LabelAnswer::class,'image_id','id')
            ->where('user_id',-1)->with('label');
    }

    public function ConfirmedLabels(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(LabelAnswer::class,'image_id','id')
            ->where('user_id','>',-1)->with('label');
    }

    public function getQualityLabelAttribute(){
        return  LabelAnswer::where('image_id','=',$this->id)
            ->where('user_id','=',-1)
            ->whereHas('label',function ($query){
                $query->quality();
            })->select('label_id')->first();
    }

}
