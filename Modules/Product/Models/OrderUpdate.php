<?php

namespace Modules\Product\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class OrderUpdate extends Model
{
    use HasFactory;

    protected $fillable = ['order_id', 'user_id', 'note'];

    protected $casts = [
        'order_id' => 'integer',
        'user_id' => 'integer'
    ];

    protected static function newFactory()
    {
        return \Modules\Product\Database\factories\OrderUpdateFactory::new();
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function orderItem()
    {
        return $this->belongsTo(OrderItem::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
