<?php

namespace Modules\Booking\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\Service\Models\Service;
use Modules\Service\Models\ServiceTraining;
use Modules\Service\Models\ServiceDuration;

class BookingTrainerMapping extends Model
{
    use HasFactory;
    protected $table = 'booking_training_mapping';
    
    protected $fillable = ['booking_id', 'date_time', 'training_id', 'price', 'duration'];

    protected $casts = [
        'booking_id' => 'integer',
        'training_id' => 'integer',
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
    public function trainingtype()
    {
        return $this->belongsTo(ServiceTraining::class, 'training_id','id');
    }
    public function duration()
    {
        return $this->belongsTo(ServiceDuration::class,'duration','id');
    }
}
