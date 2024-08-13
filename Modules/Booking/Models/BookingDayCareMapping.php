<?php

namespace Modules\Booking\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\Service\Models\Service;

class BookingDayCareMapping extends Model
{
    use HasFactory;
    protected $table = 'booking_daycare_mapping';
    
    protected $fillable = ['booking_id', 'date', 'dropoff_time', 'pickup_time', 'food','activity','address','price'];

    protected $casts = [
        'booking_id' => 'integer',
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
        return $this->belongsTo(Service::class);
    }

    public function employee()
    {
        return $this->belongsTo(User::class);
    }
}
