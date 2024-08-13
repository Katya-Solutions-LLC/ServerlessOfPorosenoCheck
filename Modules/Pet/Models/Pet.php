<?php

namespace Modules\Pet\Models;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Traits\HasSlug;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\User;

class Pet extends BaseModel
{
    use HasFactory;
    use SoftDeletes;
    use HasSlug;

    protected $table = 'pets';
    protected $fillable = ['name', 'slug', 'pettype_id', 'breed_id', 'date_of_birth', 'age', 'gender', 'weight', 'height', 'weight_unit', 
    'height_unit', 'additional_info', 'user_id', 'status'];
    protected $appends = ['pet_image'];
    protected $casts = [
        'pettype_id' => 'integer',
        'breed_id' => 'integer',
        'weight' => 'double',
        'height' => 'double',
        'user_id'=> 'integer',
        'status'=> 'boolean',
      ];
    /**
     * Create a new factory instance for the model.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    protected static function newFactory()
    {
        return \Modules\Pet\database\factories\PetFactory::new();
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    
    protected function getPetImageAttribute()
    {
        $media = $this->getFirstMediaUrl('pet_image');

        return isset($media) && ! empty($media) ? $media : default_feature_image();
    }

    public function pettype()
    {
        return $this->belongsTo(PetType::class, 'pettype_id');
    }
    public function breed()
    {
        return $this->belongsTo(Breed::class, 'breed_id','id');
    }

    public function petnote()
    {
        return $this->hasMany(PetNote::class, 'pet_id')->with('createdBy');
    }
}
