<?php

namespace Modules\Product\Models;

use App\Models\BaseModel;
use Modules\Product\Models\VariationValue;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\User;

class Variations extends BaseModel
{
    use HasFactory;

    protected $table = 'variations';

    const CUSTOM_FIELD_MODEL = 'Modules\Product\Models\Variations';

    protected $fillable = ['name', 'status', 'type', 'is_fixed'];

    protected $casts = [
        'is_fixed' => 'integer',
        'status' => 'integer',
    ];

    protected static function newFactory()
    {
        return \Modules\Product\Database\factories\VariationsFactory::new();
    }

    public function values()
    {
        return $this->hasMany(VariationValue::class, 'variation_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class,'created_by','id');
    }

    public function scopeCheckMultivendor($query)
    {
        if (enableMultivendor() == "0") {
            return $query->where(function ($query) {
                $query->whereHas('user', function ($q) {
                    $q->whereIn('user_type', ['admin', 'demo_admin']);
                })
                ->orWhereNull('created_by');
            });
        }
        return $query;
    }
}
