<?php

namespace Modules\Earning\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
class EmployeeEarning extends Model
{
    use HasFactory;

    protected $fillable = ['employee_id', 'description', 'total_amount', 'payment_date', 'payment_type', 'commission_amount', 'tip_amount'];
    protected $casts = [
        'employee_id' => 'integer',
        'total_amount' => 'double',
        'commission_amount' => 'double',
        'tip_amount' => 'double',
        'created_by'=> 'integer',
        'updated_by'=> 'integer',
        'deleted_by' => 'integer',
      ];

    protected static function newFactory()
    {
        return \Modules\Earning\Database\factories\EmployeeEarningFactory::new();
    }

    public function employee()
    {
        return $this->belongsTo(User::class, 'employee_id', 'id')->with('branch');
    }
}
