<?php

namespace Modules\Product\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\BaseModel;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductGallery extends BaseModel
{
    use HasFactory;
    use SoftDeletes;


    protected $fillable = ['product_id', 'full_url', 'status'];

    protected $casts = [
        'status' => 'integer',
        'product_id' => 'integer',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }


}
