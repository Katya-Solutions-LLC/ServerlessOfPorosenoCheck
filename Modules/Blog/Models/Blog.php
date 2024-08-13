<?php

namespace Modules\Blog\Models;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Blog extends BaseModel
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'blogs';
    protected $appends = ['blog_image'];
    protected $fillable = ['name', 'tags', 'description', 'status'];
    protected $casts = [
        'created_by'=> 'integer',
        'updated_by'=> 'integer',
        'deleted_by' => 'integer',
      ];
    /**
     * Create a new factory instance for the model.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    protected static function newFactory()
    {
        return \Modules\Blog\database\factories\BlogFactory::new();
    }

    protected function getBlogImageAttribute()
    {
        $media = $this->getFirstMediaUrl('blog_image');

        return isset($media) && ! empty($media) ? $media : default_feature_image();
    }
}
