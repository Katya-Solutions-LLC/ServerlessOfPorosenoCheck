<?php

namespace Modules\Product\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\User;
use Modules\Product\Models\Product;
use Modules\Product\Models\Order;

class OrderVendorMapping extends Model
{
    use HasFactory;
    protected $table = 'order_vendor_mapping';

    protected $fillable = [];
    protected $casts = [
        'product_id' => 'integer',
        'product_total_amount' => 'double',
        'order_id'=> 'integer',
        'vendor_id'=> 'integer',
      ];
    protected static function newFactory()
    {
        return \Modules\Product\Database\factories\OrderVendorMappingFactory::new();
    }

    public function employee()
    {
        return $this->belongsTo(User::class, 'vendor_id');
    }

    public function products()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function orders()
    {
        return $this->belongsTo(Order::class, 'order_id')->with('orderGroup','orderItems');
    }
}
