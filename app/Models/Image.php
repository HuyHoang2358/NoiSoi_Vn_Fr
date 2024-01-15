<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @method static create(array $array)
 * @method static find($id)
 */
class Image extends Model
{
    use HasFactory;
    protected $table ='images';
    protected $fillable =['user_id','project_id','parent_id','file_name','file_path','size','top','left','width','height'];

    public function project(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Project::class,'project_id','id');
    }

}
