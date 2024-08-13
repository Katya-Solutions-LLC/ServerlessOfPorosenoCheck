<?php

namespace Modules\Service\Models;

use App\Models\BaseModel;
use App\Models\Traits\HasHashedMediaTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Category\Models\Category;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class ServicePackage extends BaseModel implements HasMedia
{
    use HasFactory;
    use SoftDeletes;
    use HasHashedMediaTrait;

    const CUSTOM_FIELD_MODEL = 'Modules\Service\Models\ServicePackage';

    protected $fillable = ['name', 'package_type', 'price', 'description', 'status', 'employee_id', 'category_id', 'start_at', 'end_at'];
    protected $casts = [
        'employee_id' => 'integer',
        'price' => 'float',
        'category_id'=> 'integer',
        'subcategory_id'=> 'integer',
        'is_featured' => 'integer',
        'status' => 'integer',
        
      ];
    protected function getFeatureImageAttribute()
    {
        $media = $this->getFirstMediaUrl('feature_image');

        return $media !== '' ? $media : default_feature_image();
    }

    /**
     * Create Converted copies of uploaded images.
     */
    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('thumb')
            ->width(250)
            ->height(250)
            ->quality(70);

        $this->addMediaConversion('thumb300')
            ->width(300)
            ->height(300)
            ->quality(70);
    }

    public function packageServices()
    {
        return $this->hasMany(PackageServiceMapping::class, 'service_package_id', 'id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function sub_category()
    {
        return $this->belongsTo(Category::class, 'sub_category_id');
    }
}
