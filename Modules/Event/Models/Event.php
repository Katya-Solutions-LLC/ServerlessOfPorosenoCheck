<?php

namespace Modules\Event\Models;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\User;
use App\Models\Traits\HasSlug;

class Event extends BaseModel
{
    use HasFactory;
    use SoftDeletes;
    use HasSlug;
    

    protected $table = 'events';
    protected $fillable = ['name', 'date', 'user_id', 'location', 'description', 'status'];
    protected $appends = ['event_image'];
    protected $casts = [
        'user_id' => 'integer',
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
        return \Modules\Event\database\factories\EventFactory::new();
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    
    protected function getEventImageAttribute()
    {
        $media = $this->getFirstMediaUrl('event_image');

        return isset($media) && ! empty($media) ? $media : default_feature_image();
    }

    public function scopeWithDistance($query, $latitude, $longitude)
{
    $unit_value = 6371; // Earth's radius in kilometers, you can change this if you want miles

    return $query
        ->selectRaw("*, (
            {$unit_value} * acos(
                cos(radians(?)) * cos(radians(latitude)) * cos(radians(longitude) - radians(?)) +
                sin(radians(?)) * sin(radians(latitude))
            )
        ) AS distance", [$latitude, $longitude, $latitude])
        ->orderBy('distance', 'asc');
}

  
}
