<?php

namespace Modules\Service\Models;

use App\Models\BaseModel;
use App\Models\User;
use App\Models\Traits\HasSlug;
use App\Trait\CustomFieldsTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Category\Models\Category;
use Modules\Service\Models\ServiceBranch;

class Service extends BaseModel
{
    use HasFactory;
    use SoftDeletes;
    use HasSlug;
    use CustomFieldsTrait;

    protected $table = 'services';

    protected $fillable = ['slug', 'name', 'description', 'duration_min', 'default_price', 
    'category_id', 'sub_category_id', 'feature_image', 'type', 'status'];
    protected $casts = [
        'category_id' => 'integer',
        'duration_min' => 'float',
        'default_price' => 'float',
        'sub_category_id'=> 'integer',
        'status'=> 'integer',
      ];
    const CUSTOM_FIELD_MODEL = 'Modules\Service\Models\Service';

    /**
     * Create a new factory instance for the model.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    protected static function newFactory()
    {
        return \Modules\Service\database\factories\ServiceFactory::new();
    }

    protected static function boot()
    {
        parent::boot();

        // create a event to happen on creating
        static::creating(function ($model) {
            $user = auth()->user();
            if ($user && User::where('id', $user->id)->whereIn('user_type', ['admin', 'demo_admin'])->exists()) {
                $model->created_by = null;
                $model->updated_by = null;
            }
        });

        static::saving(function ($table) {
            //
        });

        static::updating(function ($table) {
            //
        });
    }

    public function employee()
    {
        return $this->hasMany(ServiceEmployee::class, 'service_id', 'id');
    }

    public function servicePackage()
    {
        return $this->hasMany(PackageServiceMapping::class, 'service_id', 'id');
    }

    public function gallery()
    {
        return $this->hasMany(ServiceGallery::class, 'id', 'feature_image');
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function sub_category()
    {
        return $this->belongsTo(Category::class, 'sub_category_id');
    }

    public function branches()
    {
        return $this->hasMany(ServiceBranches::class, 'service_id');
    }

    public function branchies()
    {
        return $this->belongsToMany(Branch::class, 'service_branches');
    }

    protected function getFeatureImageAttribute()
    {
        $media = $this->getFirstMediaUrl('feature_image');

        return isset($media) && ! empty($media) ? $media : default_feature_image();
    }

    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }
}
