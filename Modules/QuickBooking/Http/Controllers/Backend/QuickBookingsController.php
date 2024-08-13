<?php

namespace Modules\QuickBooking\Http\Controllers\Backend;

use App\Events\Backend\UserCreated;
use App\Http\Controllers\Controller;
use App\Models\Branch;
// Traits
use App\Models\User;
// Listing Models
use App\Notifications\UserAccountCreated;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Modules\Booking\Models\Booking;
use Modules\Booking\Trait\BookingTrait;
// Events
use Modules\Service\Models\Service;
use Modules\Service\Transformers\ServiceResource;
use App\Models\Address;
use Modules\Tax\Models\Tax;
use Modules\Customer\Http\Requests\CustomerRequest;
use Modules\Pet\Models\Pet;
use Modules\Pet\Models\PetType;
use Modules\Pet\Models\Breed;

use Modules\Service\Models\SystemService;

class QuickBookingsController extends Controller
{
    use BookingTrait;

    public function index()
    {
        if(!setting('is_quick_booking')) {
            return abort(404);
        }
        return view('quickbooking::backend.quickbookings.index');
    }

    // API Methods for listing api
    public function branch_list()
    {
        $list = Branch::active()->with('address')->select('id', 'name', 'branch_for', 'contact_number', 'contact_email')->get();

        return $this->sendResponse($list, __('booking.booking_branch'));
    }

    public function  verify_customer(Request $request){

       $data['user']=User::Where('email',$request->email)->first();

       $data['pet']=Pet::where('user_id',  $data['user']['id'])->get();

       return response()->json(['data' => $data, 'status' => true]);
        
    }

   

    public function slot_time_list(Request $request)
    {
        $day = date('l', strtotime($request->date));

        $data = $this->requestData($request);

        $slots = $this->getSlots($data['date'], $day, $data['branch_id'], $data['employee_id']);

        return $this->sendResponse($slots, __('booking.booking_timeslot'));
    }

    public function services_list(Request $request)
    {
        $data = SystemService::where('status',1)->where('slug','veterinary')->orwhere('slug','grooming');

        $data = $data->get();
    
        return response()->json(['data' => $data, 'status' => true]);
    }

    public function employee_list(Request $request)
    {
        $data = $this->requestData($request);

        $list = User::whereHas('services', function ($query) use ($data) {
                $query->where('service_id', $data['service_id']);
            })
            ->whereHas('branches', function ($query) use ($data) {
                $query->where('branch_id', $data['branch_id']);
            })
            ->get();

        return $this->sendResponse($list, __('booking.booking_employee'));
    }

    // Create Method for Booking API
    public function create_booking(Request $request)
    {

        $userRequest = $request->user;
        $user = User::where('email', $userRequest['email'])->first();

        if (! isset($user)) {
            $userRequest['password'] = Hash::make('12345678');
            $user = User::create($userRequest);
            // Sync Roles
            $roles = ['user'];
            $user->syncRoles($roles);

            event(new UserCreated($user));

            $data = [
                'password' => '12345678',
            ];

            try {
                $user->notify(new UserAccountCreated($data));
            } catch (\Exception $e) {
                \Log::error($e->getMessage());
            }
        }

        $bookingData = $request->booking;
        $bookingData['user_id'] = $user->id;
        $bookingData['created_by'] = $user->id;
        $bookingData['updated_by'] = $user->id;
        $booking = Booking::create($bookingData);
        
        $this->updateBookingService($bookingData['services'], $booking->id);

        $booking['user'] = $booking->user;

        $booking['services'] =  $booking->services;

        $booking['branch'] = $booking->branch;

        $branchAddress = Address::where('addressable_id', $booking['branch']->id)
                        ->where('addressable_type', get_class($booking['branch']))
                        ->first();

        $booking['branch_address'] = $branchAddress;

        $booking->latitude = null;
        $booking->longitude = null;

        
        try {
            $this->sendNotificationOnBookingUpdate('quick_booking', $booking);
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
        }

        $booking['tax'] = Tax::active()->whereNull('module_type')->orWhere('module_type', 'services')->get();

        return $this->sendResponse($booking, __('booking.booking_create'));
    }

    public function requestData($request)
    {
        return [
            'branch_id' => $request->branch_id,
            'service_id' => $request->service_id,
            'date' => $request->date,
            'employee_id' => $request->employee_id,
            'start_date_time' => $request->start_date_time
        ];
    }

    public function store_customer(CustomerRequest $request)
    {

        $data = $request->all();

        $data = User::create($data);

        $data->assignRole('user');

        if ($request->custom_fields_data) {

            $data->updateCustomFieldData(json_decode($request->custom_fields_data));
        }

        if ($request->has('profile_image')) {

            $request->file('profile_image');

            storeMediaFile($data, $request->file('profile_image'), 'profile_image');
        }



        $res_data['pet']=Pet::where('user_id',  $data['id'])->get();
        $res_data['user']=$data;



        $message = __('messages.create_form', ['form' => __('customer.singular_title')]);


        return response()->json(['data' => $res_data ,'message' =>$message,'status' => true], 200);
    }

    public function  pettype_list(Request $request){

        $term = trim($request->q);

        $query_data = PetType::where('status', 1)
            ->where(function ($q) {
                if (! empty($term)) {
                    $q->orWhere('name', 'LIKE', "%$term%");
                }
            })->get();

        $data = [];

        foreach ($query_data as $row) {
            $data[] = [
                'id' => $row->id,
                'name' => $row->name,
                'limit' => $row->limit,
            ];
        }
        return response()->json($data);
        
    }

    public function breed_list(Request $request)
    {
        $pettype_id = $request->pettype_id;

        $data = Breed::with('pettype');

        if(isset($pettype_id)) {

            if($pettype_id==0){

                $data=$data;

             }else{

                $data->where('pettype_id', $pettype_id);

             }


        }

        $data = $data->get();

        return response()->json($data);
    }

    public function store_pet(Request $request){

        $request_data=$request->all();

        $request_data['breed_id']=$request->breed;

        $data['pet_data']=PET::create($request_data);

        $data['user_pet']=PET::where('user_id',$request->user_id)->get();

        $message = __('messages.create_form', ['form' => __('pet.singular_title')]);

        return response()->json(['data' => $data ,'message' =>$message,'status' => true], 200);

    }
}
