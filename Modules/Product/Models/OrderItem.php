<?php

namespace Modules\Product\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\User;
use Modules\Commission\Trait\CommissionTrait;

class OrderItem extends Model
{
    use HasFactory;
    use CommissionTrait;

    protected $casts = [
        'order_id' => 'integer', 
        'product_variation_id' => 'integer',
        'qty' => 'integer',
        'location_id' => 'integer',
        'unit_price' => 'double',
        'total_tax' => 'double',
        'total_price' => 'double',
        'reward_points' => 'integer',
        'is_refunded' => 'integer',
      
    ];

    protected static function newFactory()
    {
        return \Modules\Product\Database\factories\OrderItemFactory::new();
    }

    public function product_variation()
    {
        return $this->belongsTo(ProductVariation::class)->with('combination','product');
    }

    // public function location()
    // {
    //     return $this->belongsTo(Location::class);
    // }

    public function order()
    {
        return $this->belongsTo(Order::class)->with('orderGroup');
    }
   public function review()
    {
        return $this->hasOne(Review::class, 'product_variation_id', 'product_variation_id')
                    ->where('user_id', auth()->id())->with('gallery');
    }


    // public function refundRequest()
    // {
    //     return $this->hasOne(Refund::class);
    // }

    public function ordervendor_mapping()
    {
        return $this->hasMany(OrderVendorMapping::class, 'order_id', 'order_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'vendor_id');
    }

    public function orderUpdates()
    {
        return $this->hasMany(OrderUpdate::class, 'order_id')->latest();
    }
}
