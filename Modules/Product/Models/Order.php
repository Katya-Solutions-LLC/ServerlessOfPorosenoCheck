<?php

namespace Modules\Product\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\User;
use Modules\Logistic\Models\LogisticZone;
use Modules\Logistic\Models\Logistic;
use Modules\Commission\Trait\CommissionTrait;
class Order extends Model
{
    use HasFactory;
    // use CommissionTrait;

    protected $casts = [
        'order_group_id' => 'integer',
        'user_id' => 'integer', 
        'location_id' => 'integer',
        'coupon_discount_amount' => 'double',
        'admin_earning_percentage' => 'double',
        'total_admin_earnings' => 'double',
        'total_vendor_earnings' => 'double',
        'logistic_id' => 'integer',
        'pickup_hub_id' => 'integer',
        'shipping_cost' => 'double',
        'tips_amount' => 'double',
        'guest_user_id' => 'integer',
        'reward_points' => 'integer',
    ];

    protected static function newFactory()
    {
        return \Modules\Product\Database\factories\OrderFactory::new();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // public function logistic()
    // {
    //     return $this->belongsTo(LogisticZone::class);
    // }

    public function logistic()
    {
        return $this->belongsTo(Logistic::class)->with('logistic_zone');
    }


    public function orderGroup()
    {
        return $this->belongsTo(OrderGroup::class);
    }
    

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class)->with('review');
    }

    public function orderUpdates()
    {
        return $this->hasMany(OrderUpdate::class)->latest();
    }

    // public function location()
    // {
    //     return $this->belongsTo(Location::class);
    // }

    public function orderVendorMappings()
    {
        return $this->hasMany(OrderVendorMapping::class, 'order_id', 'id');
    }
}
