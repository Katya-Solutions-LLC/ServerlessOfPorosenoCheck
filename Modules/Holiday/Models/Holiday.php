<?php

namespace Modules\Holiday\Models;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Holiday extends BaseModel
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'holidays';
    protected $casts = [
        'branch_id' => 'integer',
        'created_by'=> 'integer',
        'updated_by'=> 'integer',
        'deleted_by' => 'integer',
      ];
    /**
     * Create a new factory instance for the model.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    protected static function newFactory()
    {
        return \Modules\Holiday\database\factories\HolidayFactory::new();
    }
}
