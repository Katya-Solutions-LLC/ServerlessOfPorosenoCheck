<?php

namespace Modules\Earning\Http\Controllers\Backend;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Models\User;
use Carbon\Carbon;
use Currency;
use Modules\Commission\Models\CommissionEarning;
use Modules\Earning\Models\EmployeeEarning;
use Modules\Earning\Trait\EarningTrait;
use Modules\Tip\Models\TipEarning;
use Yajra\DataTables\DataTables;
use Spatie\Permission\Models\Role;
use Modules\Product\Models\Order;
use Modules\Product\Models\OrderItem;

class OrderEarningsController extends Controller
{
    use EarningTrait;
    
    public function __construct()
    {
        // Page Title
        $this->module_title = 'earning.title';

        // module name
        $this->module_name = 'order-earnings';

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
     * @return Renderable
     */
    public function index()
    {
        $module_action = 'List';

        $module_title = 'earning.lbl_order_earnings';

        return view('earning::backend.orderearnings.index_datatable', compact('module_action', 'module_title'));
    }

    public function index_data(DataTables $datatable)
    {
        $module_name = $this->module_name;

            $query = User::select('users.*')
              ->role('pet_store')
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
            })->orderBy('updated_at', 'desc');

        return $datatable->eloquent($query)
            ->addColumn('action', function ($data) use ($module_name) {
                $commissionData = $data->commission_earning()
                    ->whereHas('getOrderItem', function ($orderquery) {
                        $orderquery->where('delivery_status', 'delivered');
                    })
                    ->where('commission_status', 'unpaid')
                    ->where('commissionable_type', 'Modules\Product\Models\OrderItem');
                $commissionAmount = $commissionData->sum('commission_amount');
                $totalOrders = $commissionData->distinct('commissionable_id')->count();

                
                $tipAmount = $data->tip_earning->where('tip_status', 'unpaid')->sum('tip_amount');
                $data['total_pay'] = $commissionAmount + $tipAmount;
                $data['total_orders'] = $totalOrders;
                $data['commission'] = $commissionData->get();
            
                return view('earning::backend.orderearnings.action_column', compact('module_name', 'data'));
            })

            ->editColumn('user_id', function ($data) {
                return view('earning::backend.orderearnings.user_id', compact('data'));
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
            ->editColumn('total_orders', function ($data) {

                if($data->total_orders >0){

                    return "<b><a href='" . route('backend.orders.index', ['commission_employee_id' => $data->id]) . "' data-assign-module='".$data->id."'  class='text-primary text-nowrap px-1' data-bs-toggle='tooltip' title='View Employee Orders'>".$data->total_orders."</a> </b>";
                }else{

                    return "<b><span  data-assign-module='".$data->id."'  class='text-primary text-nowrap px-1' data-bs-toggle='tooltip' title='View Employee Orders'>0</span>";
                }

            })
            ->editColumn('total_order_amount', function ($data) {
                
                $totalOrderAmount = 0;
                $order_ids = [];
                if($data['commission']->isNotEmpty()){
                    foreach($data['commission'] as $commission){
                        $orderItem = OrderItem::with('order')->where('id', $commission->commissionable_id)->where('delivery_status', 'delivered')->first();
                        
                        $order_ids[] = optional($orderItem->order)->id;
                    }
                    $order_ids = array_unique($order_ids);
    
                    $totalOrderAmount = Order::whereIn('id', $order_ids)->sum('total_admin_earnings');
                }

                return Currency::format($totalOrderAmount);
            })

            ->editColumn('total_admin_earning', function ($data) {
                $admin_commission = 0;
                foreach ($data['commissions_data'] as $commission) {
                    if($commission['getCommission']['type'] == 'product'){
                        $admin_commission += 100 - $commission['getCommission']['commission_value'];
                    }
                }

                $totalAdminEarning = 0;
                
                if($data['commission']->isNotEmpty()){
                    foreach($data['commission'] as $commission){
                        $orderItem = OrderItem::with('order')->where('id', $commission->commissionable_id)
                                                ->where('delivery_status', 'delivered')->first();
                        if($orderItem){
                            $totalProductAmount = $orderItem->total_price;
                            $totalTaxAmount = $orderItem->total_tax;
                            $totalShippingCost = $orderItem->total_shipping_cost;
                            $totalAdminEarning +=  ($totalProductAmount * $admin_commission / 100) + $totalTaxAmount + $totalShippingCost;
                        }
                    }
                }

                return Currency::format($totalAdminEarning);
            })

            ->editColumn('total_commission_earn', function ($data) {

               return "<b><span data-assign-module='".$data->id."' data-assign-commission-type='product' data-assign-target='#view_commission_list' data-assign-event='assign_commssions' class='text-primary text-nowrap px-1' data-bs-toggle='tooltip' title='View Employee Commissions'> <i class='fa-regular fa-eye'></i></span>";

            //    if($data->commission->getCommission->commission_type =='percentage'){

            //     return $data->commission->getCommission->commission_value.''.'%';
                
            //    }else{
;
            //        return Currency::format($data->commission->getCommission->commission_value);
            //    }
                
            })
            ->editColumn('total_pay', function ($data) {
                return Currency::format($data->total_pay);
            })
            ->orderColumn('total_services', function ($query, $order) {
                $query->orderBy('booking_servicesdata_count', $order);
            }, 'total_services')
            ->orderColumn('total_order_amount', function ($query, $order) {
                $query->orderBy(new Expression('(SELECT total_product_amount FROM order_vendor_mapping WHERE employee_id = users.id)'), $order);
            }, 1)
            // ->orderColumn('total_commission_earn', function ($query, $order) {
            //     $query->orderBy(new Expression('(SELECT SUM(commission_amount) FROM commission_earnings WHERE employee_id = users.id)'), $order);
            // }, 1)
            ->addIndexColumn()
            ->rawColumns(['action', 'image','user_id','total_commission_earn','total_orders', 'total_admin_earning'])
            ->toJson();
    }
    

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('earning::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        return view('earning::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        return view('earning::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        //
    }
}
