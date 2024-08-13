<?php

namespace Modules\Booking\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\Service\Models\Service;

class BookingVeterinaryMapping extends Model
{
    use HasFactory;
    protected $table = 'booking_veterinary_mapping';
    
    protected $fillable = ['booking_id', 'date_time', 'duration', 'reason', 'price','service_id','service_name','start_video_link','join_video_link'];
    protected $casts = [
        'booking_id' => 'integer',
        'service_id' => 'integer',
        'duration' => 'integer',
        'price' => 'double',
        'created_by'=> 'integer',
        'updated_by'=> 'integer',
        'deleted_by' => 'integer',
      ];
    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }

    public function service()
    {
        return $this->belongsTo(Service::class)->with('category');
    }

    public function employee()
    {
        return $this->belongsTo(User::class);
    }
}
