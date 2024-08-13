<?php

namespace Modules\Earning\Models;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Commission\Models\CommissionEarning;

class Earning extends BaseModel
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'earnings';
    protected $casts = [
        'status' => 'integer',
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
        return \Modules\Earning\database\factories\EarningFactory::new();
    }

    public function commission_earning()
    {
        return $this->belongsTo(CommissionEarning::class, 'employee_id');
    }
}
