<?php

namespace Modules\Location\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class StockLog extends Model
{
    use HasFactory;

    protected $fillable = [];
    protected $casts = [
        'quantity' => 'integer',
        'location_id'=> 'integer',
        'product_id'=> 'integer',
        'product_variation_id' => 'integer',
      ];
    protected static function newFactory()
    {
        return \Modules\Location\Database\factories\StockLogFactory::new();
    }
}
