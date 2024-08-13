<?php

namespace Modules\Booking\Models;

use App\Models\BaseModel;
use App\Models\Branch;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Commission\Trait\CommissionTrait;
use Modules\Service\Models\Service;
use Modules\Tip\Trait\TipTrait;
use Modules\Pet\Models\Pet;
use Modules\Service\Models\SystemService;
use Modules\Booking\Models\BookingRequestMapping;
use Modules\Commission\Models\CommissionEarning;

class Booking extends BaseModel
{
    use HasFactory;
    use SoftDeletes;
    use CommissionTrait;
    use TipTrait;

    protected $table = 'bookings';
    protected $casts = [
        'start_date_time' => 'datetime', 
        'user_id' => 'integer',
        'branch_id' => 'integer',
        'employee_id' => 'integer',
        'system_service_id' => 'integer',
        'pet_id' => 'integer',
        'total_amount' => 'double',
        'service_amount' => 'double',
        'created_by'=> 'integer',
        'updated_by'=> 'integer',
        'deleted_by' => 'integer',
    ];

    protected $appends = ['medical_report'];

    /**
     * Create a new factory instance for the model.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    protected static function newFactory()
    {
        return \Modules\Booking\database\factories\BookingFactory::new();
    }

    protected function getMedicalReportAttribute()
    {
        $media = $this->getFirstMediaUrl('medical_report');
        

        return isset($media) && ! empty($media) ? $media : default_feature_image();
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class, 'branch_id');
    }

    public function services()
    {
        return $this->hasMany(BookingService::class, 'booking_id')->with('employee')
            ->leftJoin('services', 'booking_services.service_id', 'services.id')
            ->select('services.name as service_name', 'booking_services.*');
    }

    public function service()
    {
        return $this->hasMany(BookingService::class, 'id', 'booking_id')->with('employee');
    }

    public function bookingRequest()
    {
        return $this->hasMany(BookingRequestMapping::class, 'id', 'booking_id');
    }

    public function mainServices()
    {
        return $this->hasManyThrough(Service::class, BookingService::class, 'booking_id', 'id', 'id', 'service_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id')->with('address');
    }
    public function employee()
    {
        return $this->belongsTo(User::class, 'employee_id');
    }

    public function bookingTransaction()
    {
        return $this->hasOne(BookingTransaction::class)->where('payment_status', 1);
    }

    public function payment()
    {
        return $this->hasOne(BookingTransaction::class);
    }

    public function bookingService()
    {
        return $this->hasMany(BookingService::class);
    }
    public function boarding()
    {
        return $this->belongsTo(BookingBoardingMapping::class,'id','booking_id');
    }
    public function training()
    {
        return $this->belongsTo(BookingTrainerMapping::class,'id','booking_id')->with('trainingtype','duration');
    }
    public function daycare()
    {
        return $this->belongsTo(BookingDayCareMapping::class,'id','booking_id');
    }
    public function walking()
    {
        return $this->belongsTo(BookingWalkerMapping::class,'id','booking_id')->with('duration');
    }
    public function grooming()
    {
        return $this->belongsTo(BookingGroomingMapping::class,'id','booking_id');
    }
    public function veterinary()
    {
        return $this->belongsTo(BookingVeterinaryMapping::class,'id','booking_id')->with('service');
    }
    public function pet()
    {
        return $this->belongsTo(Pet::class,'pet_id')->with('pettype','breed','petnote');
    }
    public function systemservice()
    {
        return $this->belongsTo(SystemService::class,'system_service_id','id');

    }

    public function scopeBranch($query)
    {
        $branch_id = request()->selected_session_branch_id;
        if (isset($branch_id)) {
            return $query->where('branch_id', $branch_id);
        } else {
            return $query->whereNotNull('branch_id');
        }
    }

    public function commissionsdata()
    {
        return $this->hasMany(CommissionEarning::class,'commissionable_id','id');
    }
}
