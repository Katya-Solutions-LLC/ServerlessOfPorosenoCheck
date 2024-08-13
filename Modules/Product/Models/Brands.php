<?php

namespace Modules\Product\Models;

use App\Models\BaseModel;
use App\Models\Traits\HasSlug;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\User;
// use App\Trait\CustomFieldsTrait;


class Brands extends BaseModel
{
    use HasFactory;
    use HasSlug;
    use SoftDeletes;
    // use CustomFieldsTrait;

    protected $table = 'brands';

    const CUSTOM_FIELD_MODEL = 'Modules\Product\Models\Brands';

    protected $appends = ['feature_image'];

    protected $fillable = ['name', 'slug', 'status'];

    protected $casts = [
        'status' => 'integer',
    ];

    protected function getFeatureImageAttribute()
    {
        $media = $this->getFirstMediaUrl('feature_image');

        return isset($media) && ! empty($media) ? $media : default_feature_image();
    }

    protected static function newFactory()
    {
        return \Modules\Product\Database\factories\BrandsFactory::new();
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
