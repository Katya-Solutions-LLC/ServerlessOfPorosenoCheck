<?php

namespace Modules\Pet\Models;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\HasSlug;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class PetType extends BaseModel
{
    use HasFactory;
    use HasSlug;
    use SoftDeletes;
    
    protected $table = "pets_type";
    protected $fillable = ['name', 'slug', 'status'];
    protected $appends = ['pettype_image'];
    protected $casts = [
        'status' => 'boolean',
      ];
    protected static function newFactory()
    {
        return \Modules\Pet\Database\factories\PetTypeFactory::new();
    }
    
    protected function getPettypeImageAttribute()
    {
        $media = $this->getFirstMediaUrl('pettype_image');

        return isset($media) && ! empty($media) ? $media : default_feature_image();
    }

    public function pets()
    {
        return $this->hasMany(Pet::class, 'pettype_id');
    }

    public function breed()
    {
        return $this->hasMany(Breed::class, 'pettype_id');
    }
}
