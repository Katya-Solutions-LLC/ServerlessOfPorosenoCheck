<?php

namespace Modules\Earning\Http\Controllers\Backend;

use App\Authorizable;
use App\Http\Controllers\Controller;
use App\Models\User;
use Carbon\Carbon;
use Currency;
use Illuminate\Http\Request;
use Modules\Commission\Models\CommissionEarning;
use Modules\Earning\Models\EmployeeEarning;
use Modules\Earning\Trait\EarningTrait;
use Modules\Tip\Models\TipEarning;
use Yajra\DataTables\DataTables;
use Modules\Booking\Models\Booking;

class EarningsController extends Controller
{
    // use Authorizable;
    use EarningTrait;

    public function __construct()
    {
        // Page Title
        $this->module_title = 'earning.title';

        // module name
        $this->module_name = 'earnings';

        // directory path of the module
        $this->module_path = 'earning::backend';

        view()->share([
            'module_title' => $this->module_title,
            'module_icon' => 'fa-regular fa-sun',
            'module_name' => $this->module_name,
            'module_path' => $this->module_path,
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $module_action = 'List';

        $module_title = 'earning.lbl_staff_earning';

        return view('earning::backend.earnings.index_datatable', compact('module_action', 'module_title'));
    }

    /**
     * Select Options for Select 2 Request/ Response.
     *
     * @return Response
     */
    public function index_list(Request $request)
    {
        $term = trim($request->q);

        if (empty($term)) {
            return response()->json([]);
        }

        $query_data = Earning::where('name', 'LIKE', "%$term%")->orWhere('slug', 'LIKE', "%$term%")->limit(7)->get();

        $data = [];

        foreach ($query_data as $row) {
            $data[] = [
                'id' => $row->id,
                'text' => $row->name.' (Slug: '.$row->slug.')',
            ];
        }

        return response()->json($data);
    }

    public function update_status(Request $request, Earning $id)
    {
        $id->update(['status' => $request->status]);

        return response()->json(['status' => true, 'message' => __('branch.status_update')]);
    }

    public function index_data(DataTables $datatable)
    {
        $module_name = $this->module_name;

              $query = User::select('users.*')
              ->withCount(['employeeBooking as totalBookings' => function ($q) {
                  $q->whereHas('payment', function ($paymentQuery) {
                      $paymentQuery->where('payment_status', 1);
                  })
                  ->groupBy('employee_id')
                  ->where('status', 'completed');
              }])
    
            ->with(['employeeBooking' => function ($q) {
                $q->select('employee_id')
                    ->selectRaw('COUNT(DISTINCT id) as totalBookings')
                    ->selectRaw('SUM(total_amount) as total_service_amount')
                    ->groupBy('employee_id')
                    ->where('status', 'completed')
                    ->whereHas('payment', function ($paymentQuery) {
                        $paymentQuery->where('payment_status', 1);
                    });
            }])
            ->with('commission_earning')
            ->with('tip_earning')
            ->with('employeeEarnings')
            ->whereHas('commission_earning', function ($q) {
                $q->where('commission_status', 'unpaid')
                ->where('commissionable_type', 'Modules\Booking\Models\Booking');
            })->orderBy('updated_at', 'desc');

        return $datatable->eloquent($query)
            ->addColumn('action', function ($data) use ($module_name) {
                $commissionData = $data->commission_earning()
                    ->whereHas('getbooking', function ($query) {
                        $query->where('status', 'completed');
                    })
                    ->where('commission_status', 'unpaid')
                    ->where('commissionable_type', 'Modules\Booking\Models\Booking');
                $commissionAmount = $commissionData->sum('commission_amount');
                $totalBookings = $commissionData->distinct('commissionable_id')->count();
                
                $tipAmount = $data->tip_earning->where('tip_status', 'unpaid')->sum('tip_amount');
                $data['total_pay'] = $commissionAmount + $tipAmount;
                $data['commission'] = $commissionData->get();
                $data['total_bookings'] = $totalBookings;
            
                return view('earning::backend.orderearnings.action_column', compact('module_name', 'data'));
            })

            ->editColumn('user_id', function ($data) {
                return view('earning::backend.earnings.user_id', compact('data'));
            })
            ->filterColumn('user_id', function ($query, $keyword) {
                if (!empty($keyword)) {
                    $query->where('first_name', 'like', '%'.$keyword.'%')->orWhere('last_name', 'like', '%'.$keyword.'%')->orWhere('email', 'like', '%'.$keyword.'%');
                }
            })
            ->orderColumn('user_id', function ($query, $order) {
                $query->orderByRaw("CONCAT(first_name, ' ', last_name) $order");
            }, 1)  

            // ->editColumn('image', function ($data) {
            //     return "<img src='" . $data->profile_image . "'class='avatar avatar-50 rounded-pill'>";
            // })
            // ->editColumn('first_name', function ($data) {
            //     return $data->full_name;
            // })
            ->editColumn('total_booking', function ($data) {

                if($data->total_bookings >0){

                    return "<b><a href='" . route('backend.booking.datatable_view', ['commission_employee_id' => $data->id]) . "' data-assign-module='".$data->id."'  class='text-primary text-nowrap px-1' data-bs-toggle='tooltip' title='View Employee Bookings'>".$data->total_bookings."</a> </b>";
                }else{

                    return "<b><span  data-assign-module='".$data->id."'  class='text-primary text-nowrap px-1' data-bs-toggle='tooltip' title='View Employee Bookings'>0</span>";
                }

            })
            ->editColumn('total_service_amount', function ($data) {
                // $totalServiceAmount = $data->employeeBooking->isEmpty() ? 0 : $data->employeeBooking->first()->total_service_amount;
                $totalServiceAmount = 0;
                foreach($data['commission'] as $commission){
                    $bookingData = Booking::where('id', $commission->commissionable_id)->first();

                    $totalServiceAmount += $bookingData->total_amount;
                }

                return Currency::format($totalServiceAmount);
            })

            ->editColumn('total_admin_earning', function ($data) {
                $admin_commission = 0;
                foreach ($data['commissions_data'] as $commission) {
                    if($commission['getCommission']['type'] == 'service'){
                        $admin_commission += 100 - $commission['getCommission']['commission_value'];
                    }
                }
                
                $totalAdminEarning = 0;
                foreach($data['commission'] as $commission){
                    $bookingData = Booking::with('payment')->where('id', $commission->commissionable_id)->first();

                    if($bookingData){
                        $totalServiceAmount = $bookingData->service_amount;
                        
                        $taxData = optional($bookingData->payment)->tax_percentage;
                        $taxData = json_decode($taxData, true);

                        $totalTaxAmount=0;
                        if(!empty($taxData)){
                            foreach($taxData as $tax){
                                if ($tax['type'] === 'percentage') {

                                    $percentageAmount = ($tax['value'] / 100) * $totalServiceAmount;
                                    $totalTaxAmount += $percentageAmount;
                        
                                } elseif ($tax['type'] === 'fixed') {
                        
                                    $totalTaxAmount += $tax['value'];
                                }
                            }
                        }
                        $totalAdminEarning +=  ($totalServiceAmount * $admin_commission / 100) + $totalTaxAmount;
                    }
                }

                return Currency::format($totalAdminEarning);
            })


            ->editColumn('total_commission_earn', function ($data) {

               return "<b><span  data-assign-module='".$data->id."' data-assign-commission-type='service' data-assign-target='#view_commission_list' data-assign-event='assign_commssions' class='text-primary text-nowrap px-1' data-bs-toggle='tooltip' title='View Employee Commissions'> <i class='fa-regular fa-eye'></i></span>";

            //    if($data->commission->getCommission->commission_type =='percentage'){

            //     return $data->commission->getCommission->commission_value.''.'%';
                
            //    }else{

            //        return Currency::format($data->commission->getCommission->commission_value);
            //    }
                
            })
            ->editColumn('total_pay', function ($data) {
                return Currency::format($data->total_pay);
                // return Currency::format($this->getUnpaidAmount($data)->total_pay);
            })
            ->orderColumn('total_services', function ($query, $order) {
                $query->orderBy('booking_servicesdata_count', $order);
            }, 'total_services')
            ->orderColumn('total_service_amount', function ($query, $order) {
                $query->orderBy(new Expression('(SELECT SUM(service_price) FROM booking_services WHERE employee_id = users.id)'), $order);
            }, 1)
            // ->orderColumn('total_commission_earn', function ($query, $order) {
            //     $query->orderBy(new Expression('(SELECT SUM(commission_amount) FROM commission_earnings WHERE employee_id = users.id)'), $order);
            // }, 1)
            ->addIndexColumn()
            ->rawColumns(['action', 'image','user_id','total_commission_earn','total_booking'])
            ->toJson();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        $module_action = 'Show';

        $data = Earning::findOrFail($id);

        return view('earning::backend.earning.show', compact('module_action', "$data"));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */


      public function edit($id, Request $request)
    {
        if($request->commission_type == 'order'){
            $query = User::where('id', $id)->select('users.id', 'users.first_name', 'users.last_name', 'users.email', 'users.mobile')
                    ->withCount(['employeeOrder as totalOrders' => function ($q) {
                        $q->select(\DB::raw('COUNT(DISTINCT order_id)'))
                                ->whereHas('orders', function ($orderQuery) {
                                    $orderQuery->whereHas('orderItems', function($q){
                                        $q->where('payment_status', 'paid')->where('delivery_status', 'delivered');
                                    });
                                })->groupBy('vendor_id');
                    }])

                    ->with(['employeeOrder' => function ($q) {
                        $q->select('vendor_id')
                            ->selectRaw('COUNT(DISTINCT order_id) as totalOrders')
                            ->selectRaw('SUM(product_total_amount) as total_order_amount')
                            ->groupBy('vendor_id')
                            ->whereHas('orders', function ($orderQuery) {
                                $orderQuery->whereHas('orderItems', function($q){
                                    $q->where('payment_status', 'paid')->where('delivery_status', 'delivered');
                                });
                            });
                    }])
                    ->with('commission_earning')
                    ->with('tip_earning')
                    ->with('employeeEarnings')
                    ->with('commissions_data')
                    ->whereHas('commission_earning', function ($q) {
                        $q->where('commission_status', 'unpaid')
                        ->where('commissionable_type', 'Modules\Product\Models\OrderItem');
                    })->orderBy('updated_at', 'desc')->first();

                $commissionData = $query->commission_earning()
                                    ->whereHas('getOrderItem', function ($orderquery) {
                                        $orderquery->where('delivery_status', 'delivered');
                                    })
                                    ->where('commission_status', 'unpaid');

                $commissionAmount = $commissionData->sum('commission_amount');

                // $commissionAmount = $query->commission_earning->where('commission_status', 'unpaid')->where('commissionable_type', 'Modules\Product\Models\Order')->sum('commission_amount');
                $tipAmount = $query->tip_earning->where('tip_status', 'unpaid')->sum('tip_amount');
                $total_commission_earn = $commissionAmount + $tipAmount;
                $total_pay = $total_commission_earn;
        }
        else{
            $query = User::where('id', $id)->select('users.id', 'users.first_name', 'users.last_name', 'users.email', 'users.mobile')
                ->withCount(['employeeBooking as totalBookings' => function ($q) {
                    $q->whereHas('payment', function ($paymentQuery) {
                        $paymentQuery->where('payment_status', 1);
                    })
                    ->groupBy('employee_id')
                    ->where('status', 'completed');
                }])
    
                ->with(['employeeBooking' => function ($q) {
                    $q->select('employee_id')
                        ->selectRaw('COUNT(DISTINCT id) as totalBookings')
                        ->selectRaw('SUM(total_amount) as total_service_amount')
                        ->groupBy('employee_id')
                        ->where('status', 'completed')
                        ->whereHas('payment', function ($paymentQuery) {
                            $paymentQuery->where('payment_status', 1);
                        });
                }])
                ->with('commission_earning')
                ->with('tip_earning')
                ->with('employeeEarnings')
                ->whereHas('commission_earning', function ($q) {
                    $q->where('commission_status', 'unpaid')
                    ->where('commissionable_type', 'Modules\Booking\Models\Booking');
                })->orderBy('updated_at', 'desc')->first();

                $commissionData = $query->commission_earning()
                    ->whereHas('getbooking', function ($query) {
                        $query->where('status', 'completed');
                    })
                    ->where('commission_status', 'unpaid');

                $commissionAmount = $commissionData->sum('commission_amount');

                // $commissionAmount = $query->commission_earning->where('commission_status', 'unpaid')->where('commissionable_type', 'Modules\Booking\Models\Booking')->sum('commission_amount');
                $tipAmount = $query->tip_earning->where('tip_status', 'unpaid')->sum('tip_amount');
                $total_commission_earn = $commissionAmount + $tipAmount;
                $total_pay = $total_commission_earn;
        }

        // $unpaidAmount = $this->getUnpaidAmount($query);
        $data = [
            'id' => $query->id,
            'full_name' => $query->full_name,
            'email' => $query->email,
            'mobile' => $query->mobile,
            'profile_image' => $query->profile_image,
            'description' => '',
            'commission_earn' => Currency::format($total_commission_earn),
            'amount' => Currency::format($total_pay),
            'payment_method' => '',
        ];

        return response()->json(['data' => $data, 'status' => true]);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request, $id)
    {

        $data = $request->all();
        // $query = User::with('commission_earning', 'tip_earning')->find($id);

        // $unpaidAmount = $this->getUnpaidAmount($query);

        if($request->commission_type == 'order'){
            $query = User::where('id', $id)->select('users.id', 'users.first_name', 'users.last_name', 'users.email', 'users.mobile')
                    ->withCount(['employeeOrder as totalOrders' => function ($q) {
                        $q->select(\DB::raw('COUNT(DISTINCT order_id)'))
                                ->whereHas('orders', function ($orderQuery) {
                                    $orderQuery->whereHas('orderItems', function($q){
                                        $q->where('payment_status', 'paid')->where('delivery_status', 'delivered');
                                    });
                                })->groupBy('vendor_id');
                    }])

                    ->with(['employeeOrder' => function ($q) {
                        $q->select('vendor_id')
                            ->selectRaw('COUNT(DISTINCT order_id) as totalOrders')
                            ->selectRaw('SUM(product_total_amount) as total_order_amount')
                            ->groupBy('vendor_id')
                            ->whereHas('orders', function ($orderQuery) {
                                $orderQuery->whereHas('orderItems', function($q){
                                    $q->where('payment_status', 'paid')->where('delivery_status', 'delivered');
                                });
                            });
                    }])
                    ->with('commission_earning')
                    ->with('tip_earning')
                    ->with('employeeEarnings')
                    ->with('commissions_data')
                    ->whereHas('commission_earning', function ($q) {
                        $q->where('commission_status', 'unpaid')
                        ->where('commissionable_type', 'Modules\Product\Models\OrderItem');
                    })->orderBy('updated_at', 'desc')->first();

                $commissionData = $query->commission_earning()
                                    ->whereHas('getOrderItem', function ($orderquery) {
                                        $orderquery->where('delivery_status', 'delivered');
                                    })
                                    ->where('commission_status', 'unpaid');

                $commissionAmount = $commissionData->sum('commission_amount');

                $tipAmount = $query->tip_earning->where('tip_status', 'unpaid')->sum('tip_amount');
                $total_commission_earn = $commissionAmount + $tipAmount;
                $total_pay = $total_commission_earn;
        }
        else{
            $query = User::where('id', $id)->select('users.id', 'users.first_name', 'users.last_name', 'users.email', 'users.mobile')
                ->withCount(['employeeBooking as totalBookings' => function ($q) {
                    $q->whereHas('payment', function ($paymentQuery) {
                        $paymentQuery->where('payment_status', 1);
                    })
                    ->groupBy('employee_id')
                    ->where('status', 'completed');
                }])
    
                ->with(['employeeBooking' => function ($q) {
                    $q->select('employee_id')
                        ->selectRaw('COUNT(DISTINCT id) as totalBookings')
                        ->selectRaw('SUM(total_amount) as total_service_amount')
                        ->groupBy('employee_id')
                        ->where('status', 'completed')
                        ->whereHas('payment', function ($paymentQuery) {
                            $paymentQuery->where('payment_status', 1);
                        });
                }])
                ->with('commission_earning')
                ->with('tip_earning')
                ->with('employeeEarnings')
                ->whereHas('commission_earning', function ($q) {
                    $q->where('commission_status', 'unpaid')
                    ->where('commissionable_type', 'Modules\Booking\Models\Booking');
                })->orderBy('updated_at', 'desc')->first();

                $commissionData = $query->commission_earning()
                    ->whereHas('getbooking', function ($query) {
                        $query->where('status', 'completed');
                    })
                    ->where('commission_status', 'unpaid');

                $commissionAmount = $commissionData->sum('commission_amount');

                $tipAmount = $query->tip_earning->where('tip_status', 'unpaid')->sum('tip_amount');
                $total_commission_earn = $commissionAmount + $tipAmount;
                $total_pay = $total_commission_earn;
        }

        $earning_data = [
            'employee_id' => $id,
            // 'total_amount' => $unpaidAmount->total_pay,
            'total_amount' => $total_pay,
            'payment_date' => Carbon::now(),
            'payment_type' => $data['payment_method'],
            'description' => $data['description'],
            // 'commission_amount' => $unpaidAmount->total_commission_earn,
            'commission_amount' => $total_commission_earn,
        ];

        $earning_data = EmployeeEarning::create($earning_data);

        CommissionEarning::where('employee_id', $id)->where('commission_status','unpaid')->update(['commission_status' => 'paid']);
        TipEarning::where('employee_id', $id)->update(['tip_status' => 'paid']);

        $message = __('messages.payment_done');

        return response()->json(['message' => $message, 'status' => true], 200);
    }

    public function get_employee_commissions(Request $request){

       if($request->has('type') && $request->type !='' && $request->has('id') && $request->id !='' ){

        $type = $request->type;
        $data =  User::where('id', $request->id)->with(['commissions_data' => function($query) use ($type) {
                    $query->whereHas('getCommission', function($subQuery) use ($type) {
                        $subQuery->where('type', $type);
                    });
                }])->first();
       }   

        return response()->json(['data' => $data, 'status' => true]);
    
        
    }
}
