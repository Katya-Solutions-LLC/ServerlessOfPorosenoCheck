<?php

namespace Modules\Commission\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\Booking\Models\Booking;
use Modules\Earning\Models\Earning;
use Modules\Product\Models\OrderItem;


class CommissionEarning extends Model
{
    use HasFactory;

    protected $fillable = ['employee_id', 'commissionable', 'model_id', 'commission_amount', 'commission_status', 'payment_date'];
    protected $casts = [
        'employee_id' => 'integer',
        'commission_amount' => 'double',
        'created_by'=> 'integer',
        'updated_by'=> 'integer',
        'deleted_by' => 'integer',
      ];

    protected static function newFactory()
    {
        return \Modules\Commission\Database\factories\CommissionEarningFactory::new();
    }

    public function getbooking()
    {
        return $this->belongsTo(Booking::class, 'commissionable_id');
    }

    public function earning()
    {
        return $this->hasMany(Earning::class, 'employee_id');
    }


    public function getOrderItem()
    {
        return $this->belongsTo(OrderItem::class, 'commissionable_id');
    }
}
