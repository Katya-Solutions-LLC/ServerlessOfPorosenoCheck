<?php

namespace Modules\Booking\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\Service\Models\Service;

class BookingGroomingMapping extends Model
{
    use HasFactory;
    protected $table = 'booking_grooming_mapping';
    
    protected $fillable = ['booking_id', 'date_time', 'duration', 'service_id', 'price','service_name'];
    protected $casts = [
        'booking_id' => 'integer',
        'service_id' => 'integer',
        'price' => 'double',
        'duration' => 'integer',
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
        return $this->belongsTo(Service::class);
    }

    public function employee()
    {
        return $this->belongsTo(User::class);
    }
}
