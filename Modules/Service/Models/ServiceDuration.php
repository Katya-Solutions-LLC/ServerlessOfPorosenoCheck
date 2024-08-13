<?php

namespace Modules\Service\Models;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class ServiceDuration extends BaseModel
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = ['duration', 'price', 'type', 'status'];
    protected $table = 'service_duration';
    protected $casts = [
        'price' => 'float',
        'status' => 'integer',
      ];
    protected static function newFactory()
    {
        return \Modules\Service\Database\factories\ServiceDurationFactory::new();
    }
}
