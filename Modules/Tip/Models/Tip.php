<?php

namespace Modules\Tip\Models;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tip extends BaseModel
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'tips';

    /**
     * Create a new factory instance for the model.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    protected static function newFactory()
    {
        return \Modules\Tip\database\factories\TipFactory::new();
    }
}
