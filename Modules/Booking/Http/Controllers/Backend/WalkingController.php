<?php

namespace Modules\Booking\Http\Controllers\Backend;

use App\Authorizable;
use App\Http\Controllers\Controller;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Query\Expression;
use Illuminate\Http\Request;
use Modules\Booking\Trait\BookingTrait;
use Modules\Booking\Trait\PaymentTrait;
use Modules\Constant\Models\Constant;
use Yajra\DataTables\DataTables;
use Modules\Booking\Models\Booking;
use Modules\Booking\Models\BookingRequestMapping;
use Modules\Booking\Models\BookingTransaction;
use Modules\Commission\Models\CommissionEarning;
use DateTime;


class WalkingController extends Controller
{
    // use Authorizable;
    use BookingTrait;
    use PaymentTrait;

    public function __construct()
    {
        // Page Title
        $this->module_title = 'menu.walking_booking';

        // module name
        $this->module_name = 'bookings';

        // module icon
        $this->module_icon = 'fa-regular fa-sun';

        view()->share([
            'module_title' => $this->module_title,
            'module_name' => $this->module_name,
            'module_icon' => $this->module_icon,
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(Request $request)
    {  

        $module_action = 'List';

        $statusList = $this->statusList();

        $booking = Booking::find(request()->booking_id);
        
        $date = $booking->start_date_time ?? date('Y-m-d');

        return view('booking::backend.walking.index', compact('module_action', 'statusList', 'date'));
    }

    /**
     * @return Response
     */
    public function index_list(Request $request)
    {
        $date = $request->date;

        $data = BookingService::with('booking', 'employee', 'service')
            ->whereHas('booking', function ($q) use ($date) {
                if (! empty($date)) {
                    $q->whereDate('start_date_time', $date);
                }
                $q->where('status', '!=', 'cancelled');
            })
            ->get();

        $updated_data = [];
        $statusList = $this->statusList();
        foreach ($data as $key => $value) {
            $duration = $value->duration_min;

            $startTime = $value->start_date_time;

            $endTime = Carbon::parse($startTime)->addMinutes($duration);

            $serviceName = $value->service->name ?? '';

            $customerName = $value->booking->user->full_name ?? 'Anonymous';

            $updated_data[$key] = [
                'id' => $value->booking_id,
                'start' => customDate($startTime, 'Y-m-d H:i'),
                'end' => customDate($endTime, 'Y-m-d H:i'),
                'resourceId' => $value->employee_id,
                'title' => $serviceName,
                'titleHTML' => view('booking::backend.bookings.calender.event', compact('serviceName', 'customerName'))->render(),
                'color' => $statusList[$value->booking->status]['color_hex'],
            ];
            $startTime = $endTime;
        }
        $employees = User::bookingEmployeesList()->get();
        $resource = [];
        foreach ($employees as $employee) {
            $resource[] = [
                'id' => $employee->id,
                'title' => $employee->full_name,
                'titleHTML' => '<div class="d-flex gap-3 justify-content-center align-items-center py-3"><img src="'.$employee->profile_image.'" class="avatar avatar-40 rounded-pill" alt="employee" />'.$employee->full_name.'</div>',
            ];
        }

        return response()->json([
            'data' => $updated_data,
            'employees' => $resource,
        ]);
    }

    public function datatable_view(Request $request)
    {
        $module_action = 'List';
        $create_title = __('booking.walking_booking');
        $type=$request->type;
    

        $filter = [
            'status' => $request->status,
        ];

        $booking_status = Constant::getAllConstant()->where('type', 'BOOKING_STATUS');

        return view('booking::backend.walking.index_datatable', compact('module_action', 'filter', 'booking_status', 'create_title','type'));
    }

    public function booking_request_datatable(Request $request)
    {
        $module_action = 'List';
     
        $type=$request->type;

        $module_title = 'booking.walking_booking_request';

        $booking_type='booking_request';
        $create_title = __('booking.walking_booking_request');

        $filter = [
            'status' => $request->status,
        ];

        $booking_status = Constant::getAllConstant()->where('type', 'BOOKING_STATUS');

        return view('booking::backend.walking.booking_request_datatable', compact('module_title','module_action', 'filter', 'booking_status', 'create_title','type','booking_type'));
    }

    public function index_data(Datatables $datatable, Request $request)
    {
        $module_name = $this->module_name;

        $booking_type='';

        $query = Booking::query()->where('booking_type','walking')->branch()->with('user', 'walking', 'pet','employee','payment','bookingRequest');

        if(auth()->user()->hasRole('admin') || auth()->user()->hasRole('demo_admin')) {

            if($request->has('booking_type') && $request->booking_type=="booking_request" ){

                $query->where('employee_id', null);
            }else{

                $query->whereNotNull('employee_id'); 
            }

        } else {

            if($request->has('booking_type') && $request->booking_type=="booking_request" ){

                $booking_type=$request->booking_type;

                $bookingRequestQuery = BookingRequestMapping::query()
                ->where('walker_id', auth()->id())
                ->where('status', 0);

                $bookingIds = $bookingRequestQuery->pluck('booking_id');

                $query->whereIn('id', $bookingIds);

        
            }else{

                $query->where('employee_id', auth()->id());

            }
        }

        $filter = $request->filter;

        if (isset($filter)) {
            if (isset($filter['column_status'])) {
                $query->where('status', $filter['column_status']);
            }
            if (isset($filter['booking_date'])) {
                try {
                    $startDate = explode(' to ', $filter['booking_date'])[0];
                    $endDate = explode(' to ', $filter['booking_date'])[1];
                    $query->whereBetween('start_date_time', [$startDate, $endDate]);
                } catch (\Exception $e) {
                    \Log::error($e->getMessage());
                }
            }
            if (isset($filter['user_id'])) {
                $query->where('user_id', $filter['user_id']);
            }
            if (isset($filter['emploee_id'])) {
                $query->whereHas('services', function ($q) use ($filter) {
                    $q->where('employee_id', $filter['emploee_id']);
                });
            }
            if (isset($filter['service_id'])) {
                $query->whereHas('services', function ($q) use ($filter) {
                    $q->whereIn('service_id', $filter['service_id']);
                });
            }

        }

        $booking_status = Constant::getAllConstant()->where('type', 'BOOKING_STATUS');
        $booking_colors = Constant::getAllConstant()->where('type', 'BOOKING_STATUS_COLOR');
        $payment_status = Constant::getAllConstant()->where('type', 'PAYMENT_STATUS')->where('status', '=', '1');

        $employee = User::where('user_type', 'walker')->get();

        return $datatable->eloquent($query)
            ->addColumn('check', function ($row) {
                return '<input type="checkbox" class="form-check-input select-table-row"  id="datatable-row-'.$row->id.'"  name="datatable_ids[]" value="'.$row->id.'" onclick="dataTableRowCheck('.$row->id.')">';
            })
            ->addColumn('action', function ($data) use ($module_name,$booking_type) {
        
                return view('booking::backend.walking.datatable.action_column', compact('module_name', 'data','booking_type'));
            })
            ->editColumn('status', function ($data) use ($booking_status, $booking_colors) {
                return view('booking::backend.walking.datatable.select_column', compact('data', 'booking_status', 'booking_colors'));
            })
            ->editColumn('id', function ($data) {
                $url = route('backend.bookings.bookingShow', ['id' => $data->id]);
                return "<a href='$url' class='text-primary'>#".$data->id."</a>";
            })
            ->editColumn('payment_status', function ($data) use ($payment_status,$booking_colors) {
                if($data->status === 'rejected' || $data->status === 'cancelled'){
                    return '--';
                }
                else{
                    return view('booking::backend.bookings.datatable.select_payment_status', compact('data','payment_status','booking_colors'));
                }
            })
            ->editColumn('user_id', function ($data) {
                return view('booking::backend.walking.datatable.user_id', compact('data'));
            })
            ->editColumn('employee_id', function ($data) {
                return view('booking::backend.walking.datatable.employee_id', compact('data'));
            })
            
            ->editColumn('start_date_time', function ($data) {
                return customDate(optional($data->walking)->date_time);
            })
            ->filterColumn('start_date_time', function ($query, $keyword) {
                if (!empty($keyword)) {
                    $query->whereHas('walking', function ($q) use ($keyword) {
                        $q->where('date_time', 'like', '%'.$keyword.'%');
                    });
                }
            })
            ->editColumn('pet_name', function ($data) {
                return $data->pet ? optional($data->pet)->name : '-';
            })
            ->filterColumn('pet_name', function ($query, $keyword) {
                if (! empty($keyword)) {
                    $query->whereHas('pet', function ($q) use ($keyword) {
                        $q->where('name', 'like', '%'.$keyword.'%');
                    });
                }
            })
            ->orderColumn('pet_name', function ($query, $order) {
                $query->orderBy(new Expression('(SELECT name FROM pets WHERE id = bookings.pet_id LIMIT 1)'), $order);
            }, 1)
            ->editColumn('pettype_id', function ($data) {
                $value =optional(optional($data->pet)->pettype)->name;
                if(isset($data->pet)){
                    if(isset($data->pet->breed)){
                        $breed = $data->pet->breed->name;
                        $value = $data->pet->pettype->name . ' ('. $data->pet->breed->name .')';
                    }
                }
                return !empty($value) ? $value : '-';
            })
            ->filterColumn('pettype_id', function ($query, $keyword) {
                // If a keyword is provided, filter the results based on the 'pettype' name
                if (!empty($keyword)) {
                    $query->whereHas('pet.pettype', function ($q) use ($keyword) {
                        $q->where('name', 'like', '%' . $keyword . '%');
                    });
                }
            })
            ->orderColumn('pettype_id', function ($query, $order) {
                $query->select('bookings.*')
                ->leftJoin('pets', 'pets.id', '=', 'bookings.pet_id')
                ->leftJoin('pets_type', 'pets.pettype_id', '=', 'pets_type.id')
                ->orderBy(new Expression('(SELECT name FROM pets_type WHERE pets_type.id = pets.pettype_id LIMIT 1)'), $order);
            }, 1)
            ->editColumn('employee_id', function ($data) use ($employee) {
                if($data->employee_id){
                    if($data->employee !=null){

                        return $data->employee->first_name.' '.$data->employee->last_name;
                    }else{

                        return '-';
                    }
                }
                else{
                    return view('booking::backend.bookings.datatable.select_employee', compact('data', 'employee'));
                }
            })
            ->editColumn('duration', function ($data) {
                return optional($data->walking)->duration ?? '-';
            })
            ->orderColumn('duration', function ($query, $order) {
                $query->orderBy(new Expression('(SELECT duration FROM booking_walking_mapping WHERE booking_id = bookings.id LIMIT 1)'), $order);
            }, 1)
            ->filterColumn('duration', function ($query, $keyword) {
                if (!empty($keyword)) {
                    $query->whereHas('walking', function ($q) use ($keyword) {
                        $q->where('duration', 'like', '%'.$keyword.'%');
                    });
                }
            })
            ->editColumn('service_amount', function ($data) {
                return '<span>'.\Currency::format($data->total_amount).'</span>';
            })
            ->orderColumn('service_amount', function ($query, $order) {
                $query->orderBy(new Expression('(SELECT total_amount FROM booking_transactions WHERE booking_id = bookings.id)'), $order);
            }, 1)
            ->filterColumn('service_amount', function ($query, $keyword) {
                if (! empty($keyword)) {
                    $query->whereHas('payment', function ($q) use ($keyword) {
                        $q->where('total_amount', 'like', '%'.$keyword.'%');
                    });
                }
            })

            ->editColumn('updated_at', function ($data) {
                $diff = timeAgoInt($data->updated_at);

                if ($diff < 25) {
                    return timeAgo($data->updated_at);
                } else {
                    return customDate($data->updated_at);
                }
            })
   
            // ->orderColumn('service_amount', function ($query, $order) {
            //     $query->orderBy(new Expression('(SELECT SUM(service_price) FROM booking_services WHERE booking_id = bookings.id)'), $order);
            // }, 1)
            ->orderColumn('employee_id', function ($query, $order) {
                $query->orderBy(new Expression('(SELECT first_name FROM users WHERE id = bookings.employee_id LIMIT 1)'), $order);
            }, 1)
            ->filterColumn('employee_id', function ($query, $keyword) {
                if (!empty($keyword)) {
                    // $query->whereHas('services', function ($q) use ($keyword) {
                        $query->whereHas('employee', function ($qn) use ($keyword) {
                            $qn->where('first_name', 'like', '%'.$keyword.'%');
                        });
                    // });
                }
            })
            ->filterColumn('user_id', function ($query, $keyword) {
                if (! empty($keyword)) {
                    $query->whereHas('user', function ($q) use ($keyword) {
                        $q->where('first_name', 'like', '%'.$keyword.'%');
                    });
                }
            })
            ->rawColumns(['check', 'action', 'status', 'services', 'service_duration', 'service_amount','start_date_time', 'id'])
            ->orderColumns(['id'], '-:column $1')
            ->make(true);
    }

    public function bulk_action(Request $request)
    {
        $ids = explode(',', $request->rowIds);

        $actionType = $request->action_type;

        $message = __('messages.bulk_update');

        switch ($actionType) {
            case 'change-status':
                $branches = Booking::whereIn('id', $ids)->update(['status' => $request->status]);
                $message = __('messages.bulk_booking_update');
                break;

            case 'delete':
                Booking::whereIn('id', $ids)->delete();
                $message = __('messages.bulk_booking_delete');
                break;

            default:
                return response()->json(['status' => false, 'message' => __('booking.booking_action_invalid')]);
                break;
        }

        return response()->json(['status' => true, 'message' => $message]);
    }
    
    public function accept_booking($id) {

      $employee_id=auth()->id();

      $booking=Booking::where('id',$id)->first();

      if($booking->employee_id ==null){

       Booking::where('id',$id)->update(['employee_id'=>$employee_id,'status'=>'confirmed']);

       $payment = BookingTransaction::where('booking_id', $id)->first();

       if($payment){

           $earning_data = $this->commissionData($payment);

           $booking->commission()->save(new CommissionEarning($earning_data['commission_data']));
   
       }
  
       BookingRequestMapping::where('booking_id', $id)->update(['status' => 1]);

       $booking=Booking::where('id',$id)->with('user','systemservice','employee')->first();

       $notify_type='accept_booking_request';

       $notification_data = [

        'id' => $booking->id,
        'user_id' => $booking->user_id,
        'user_name' => $booking->user->first_name ,
        'employee_id' => $booking->employee->id,
        'employee_name' => optional($booking->employee)->first_name,
        'booking_date' => DateTime::createFromFormat('d/m/Y', $booking->start_date_time),
        'booking_time' => DateTime::createFromFormat('h:i A', $booking->start_date_time),
        'booking_services_names' => $booking->systemservice->name,
        'booking_services_image' => $booking->systemservice->feature_image,
        'booking_date_and_time' => DateTime::createFromFormat('Y-m-d H:i', $booking->start_date_time),
        'latitude' =>  null,
        'longitude' => null,
        
     ];

        if(isset($notify_type)) {
            try {
                $this->sendNotificationOnBookingUpdate($notify_type, $notification_data);
            } catch (\Exception $e) {
                \Log::error($e->getMessage());
            }
        }
    

        $message = __('booking.booking_accepted');

        return response()->json(['message' => $message, 'status' => true], 200);

      }

      return response()->json(['status' => false, 'message' => __('booking.booking_already_accepted')]);

    }

    
}
