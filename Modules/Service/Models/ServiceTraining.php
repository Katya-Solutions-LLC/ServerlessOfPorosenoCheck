<?php

namespace Modules\Service\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\HasSlug;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ServiceTraining extends Model
{
    use HasFactory;
    use HasSlug;

    protected $table = 'service_training';
    protected $fillable = ['name', 'slug', 'status', 'description'];
    
    protected static function newFactory()
    {
        return \Modules\Service\Database\factories\ServiceTrainingFactory::new();
    }
}
