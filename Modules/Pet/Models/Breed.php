<?php

namespace Modules\Pet\Models;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Traits\HasSlug;

class Breed extends BaseModel
{
    use HasFactory;
    use SoftDeletes;
    use HasSlug;


    protected $fillable = ['name', 'pettype_id', 'description', 'status','slug'];
    protected $casts = [
        'pettype_id' => 'integer',
        'status' => 'boolean',
      ];
    protected static function newFactory()
    {
        return \Modules\Pet\Database\factories\BreedFactory::new();
    }
    
    public function pettype()
    {
        return $this->belongsTo(PetType::class, 'pettype_id');
    }
}
