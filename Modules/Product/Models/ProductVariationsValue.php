<?php

namespace Modules\Product\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProductVariationsValue extends Model
{
    use HasFactory;

    protected $fillable = [];

    protected $casts = [
    
        'product_id' => 'integer',
        'variation_value_id' => 'integer',
    ];
    
    protected static function newFactory()
    {
        return \Modules\Product\Database\factories\ProductVariationsValueFactory::new();
    }
}
