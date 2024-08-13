<?php

namespace Modules\Product\Http\Controllers\Backend;

use Carbon\Carbon;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Location\Models\Location;
use Modules\Product\Models\Cart;
use Modules\Product\Models\Order;
use Modules\Product\Models\OrderGroup;
use Modules\Product\Models\OrderItem;
use Modules\Product\Models\OrderUpdate;
use Yajra\DataTables\DataTables;
use Modules\Product\Http\Requests\OrderRequest;
use App\Models\Setting;
use Modules\Product\Trait\OrderTrait;
use Modules\Product\Models\Product;
use Modules\Product\Models\ProductVariation;
use Auth;
use Modules\Commission\Models\CommissionEarning;
use DB;
use App\Models\Notification;

class OrdersController extends Controller
{

    use  OrderTrait;

    public function __construct()
    {
        // Page Title
        $this->module_title = 'orders.title';
        // module name
        $this->module_name = 'orders';

        // module icon
        $this->module_icon = 'fa-solid fa-clipboard-list';

        view()->share([
            'module_title' => $this->module_title,
            'module_icon' => $this->module_icon,
            'module_name' => $this->module_name,
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return Renderable
     */
    public function index(Request $request)
    {
        $export_import = false;

        $locations = Location::where('status', 1)->latest()->get();

        $commission_employee_id='';

        if($request->has('commission_employee_id') && $request->commission_employee_id !=''){

           $commission_employee_id= $request->commission_employee_id;
        };

        return view('product::backend.order.index_datatable', compact('export_import', 'locations', 'commission_employee_id'));
    }

    public function index_data(DataTables $datatable, Request $request)
    {
        $user = Auth::user();
        $vendorId = $user->id;

        if($user->hasRole('pet_store')){
            $orders = OrderItem::with('order')->where('vendor_id', $vendorId);
        }
        else{
            $orders = OrderItem::with('order');
        }

        $filter = $request->filter;

        $posOrder = [];

        if($request->has('commission_employee_id') && $request->commission_employee_id != '') {
            $vendor_id = $request->commission_employee_id;

            $order_ids = CommissionEarning::where('employee_id', $vendor_id)->where('commission_status', 'unpaid')->pluck('commissionable_id')->toArray();
            $orders = OrderItem::with('order')->whereIn('id', $order_ids)->where('delivery_status', 'delivered');
        }

        if (isset($filter)) {
            if (isset($filter['code'])) {
                $orders = $orders->whereHas('order', function ($query) use ($filter) {
                            $query->where(function ($q) use ($filter) {
                                $orderGroup = OrderGroup::where('order_code', $filter['code'])->pluck('id');
                                $q->orWhereIn('order_group_id', $orderGroup);
                            });
                        });
            }

            if (isset($filter['delivery_status'])) {
                $orders = $orders->where('delivery_status', $filter['delivery_status']);
            }

            if (isset($filter['payment_status'])) {
                $orders = $orders->where('payment_status', $filter['payment_status']);
            }

            if (isset($filter['location_id'])) {
                $orders = $orders->where('location_id', $filter['location_id']);
            }
        }

        $orders = $orders->whereHas('order', function ($query) {
                        $query->where(function ($q){
                            $orderGroup = OrderGroup::pluck('id');
                            $q->orWhereIn('order_group_id', $orderGroup);
                        });
                 });

        return $datatable->eloquent($orders)
            //   ->addColumn('check', function ($row) {
            //       return '<input type="checkbox" class="form-check-input select-table-row "  id="datatable-row-'.$row->id.'"  name="datatable_ids[]" value="'.$row->id.'" onclick="dataTableRowCheck('.$row->id.')">';
            //   })
              ->addColumn('action', function ($data) {
                  return view('product::backend.order.columns.action_column', compact('data'));
              })
              ->editColumn('order_code', function ($data) {
                  return setting('inv_prefix').optional(optional($data->order)->orderGroup)->order_code;
              })
              ->editColumn('customer_name', function ($data) {
                  $data = $data->order;
                  return view('product::backend.order.columns.customer_column', compact('data'));
              })
              ->editColumn('placed_on', function ($data) {
                  return customDate(optional($data->order)->created_at);
              })
          

              ->editColumn('total_amount', function ($data) {
                
                    $totalprice = $data->total_price;
                    $totalTaxAmount = $data->total_tax;
                    $totalShippingCost = $data->total_shipping_cost;
                    $totalAmount = $totalprice + $totalTaxAmount + $totalShippingCost;

                    return \Currency::format($totalAmount);
            })  

            ->orderColumn('total_amount', function ($query, $order) {
                if($query->count() > 0){
                    $query->select('orders.*')
                        ->leftJoin('order_groups', 'order_groups.id', '=', 'orders.id')
                        ->orderBy('order_groups.grand_total_amount', $order);
                }
            }, 1)
              ->editColumn('payment', function ($data) {
                  return view('product::backend.order.columns.payment_column', compact('data'));
              })
              ->editColumn('status', function ($data) {
                  return view('product::backend.order.columns.status_column', compact('data'));
              })
              ->editColumn('location', function ($data) {
                  return $data->order->location ? optional(optional($data->order)->location)->name : 'N/A';
              })

              ->editColumn('seller_name', function ($data) {

                    // $sellercount = $data->order->orderVendorMappings->unique('vendor_id')->count();
                    // $viewButton = '';

                    // $viewButton = "<b><button type='button' data-assign-module='{$data->order->id}' data-assign-target='#seller-form' data-assign-event='seller_list' class='btn btn-secondary btn-sm rounded text-nowrap px-1' data-bs-toggle='tooltip' title='View all Seller'> {$sellercount}</button></b>";

                    return optional($data->user)->first_name.' '.optional($data->user)->last_name;
              })

              ->filterColumn('seller_name', function ($query, $keyword) {
                if (! empty($keyword)) {
                    $query->whereHas('user', function ($q) use ($keyword) {
                        $q->where('first_name', 'like', '%'.$keyword.'%');
                        $q->orWhere('last_name', 'like', '%'.$keyword.'%');
                    });
                }
              })
              ->filterColumn('customer_name', function ($query, $keyword) {
                  if (! empty($keyword)) {
                      $query->whereHas('user', function ($q) use ($keyword) {
                          $q->where('first_name', 'like', '%'.$keyword.'%');
                          $q->orWhere('last_name', 'like', '%'.$keyword.'%');
                      });
                  }
              })
              ->editColumn('updated_at', function ($data) {
                  $diff = Carbon::now()->diffInHours($data->updated_at);
                  if ($diff < 25) {
                      return $data->updated_at->diffForHumans();
                  } else {
                      return $data->updated_at->isoFormat('llll');
                  }
              })
              ->orderColumns(['id'], '-:column $1')
              ->rawColumns(['action', 'seller_name'])
              ->toJson();
    }

    /**
     * Show the specified resource.
     *
     * @param  int  $id
     * @return Renderable
     */
    public function show(Request $request)
    {
        $orderItem = OrderItem::with('order')->find($request->id);
        $order_id = optional($orderItem->order)->id;
        $otherItems = OrderItem::with('order')->whereNot('id', $request->id)
                        ->whereHas('order', function($q) use($order_id){
                            $q->where('id', $order_id);
                        })->get();

        if ($orderItem == null) {
            return abort(500);
        }
        $user_id = auth()->user()->id;

        if(auth()->user()->hasRole('pet_store')){
            $orderUpdates = $orderItem->orderUpdates()->where('user_id', $user_id)->get();

            $otherItems = OrderItem::with('order')->where('vendor_id', $user_id)->whereNot('id', $request->id)
                            ->whereHas('order', function($q) use($order_id){
                                $q->where('id', $order_id);
                            })->get();
        }else{
            $orderUpdates = $orderItem->orderUpdates;
        }

        if($request->has('notification_id')){
            $notification = Notification::where('id', $request->notification_id)->first();
            $notification->read_at = Carbon::now();
            $notification->save();
        }

        $checkVendor = $orderItem->vendor_id == $user_id;

        return view('product::backend.order.show', compact('orderItem', 'user_id', 'orderUpdates', 'otherItems', 'checkVendor'));
    }

    // update payment status
    public function updatePaymentStatus(Request $request)
    {
        $orderItem = OrderItem::with('order')->findOrFail((int) $request->order_item_id);
        $orderItem->payment_status = $request->status;
        $orderItem->save();

        if($orderItem->payment_status === 'paid'){
            CommissionEarning::where('commissionable_id', $orderItem->id)->where('employee_id', $orderItem->vendor_id)->update(['commission_status' => 'unpaid']);
        }

        // $order = Order::with('orderGroup')->findOrFail((int) $request->order_id);
        // $order->payment_status = $request->status;
        // $order->save();

        if(optional($orderItem->order)->orderGroup) {
            $orderGroup = optional($orderItem->order)->orderGroup;
            $orderGroup->payment_status = $request->status;
            $orderGroup->save();
        }

        OrderUpdate::create([
            'order_id' => $orderItem->id,
            'user_id' => auth()->user()->id,
            'note' => 'Payment status updated to '.ucwords(str_replace('_', ' ', $request->status)).'.',
        ]);

        // todo::['mail notification']
        return response()->json(['status' => true, 'message' => 'Payment Status Has Been Updated']);
    }

    // update delivery status
    public function updateDeliveryStatus(Request $request)
    {
        $orderItem = OrderItem::with('order')->findOrFail((int) $request->order_item_id);
        $orderItem->delivery_status = $request->status;
        $order_itemids = [];

        if($request->status == 'accept'){
            $orderItem->delivery_status = 'accepted';
        }
        if($request->status == 'delivered'){
            $orderItem->delivered_date = Carbon::now();
        }
        $orderItem->save();


        // if ($order->delivery_status != 'cancelled' && $request->status == 'cancelled') {
        //     $this->addQtyToStock($order);
        // }

        // if ($order->delivery_status == 'cancelled' && $request->status != 'cancelled') {
        //     $this->removeQtyFromStock($order);
        // }

        OrderUpdate::create([
            'order_id' => $orderItem->id,
            'user_id' => auth()->user()->id,
            'note' => 'Delivery status updated to '.ucwords(str_replace('_', ' ', $request->status)).'.',
        ]);

        $order_prefix_data=Setting::where('name','inv_prefix')->first();
        $order_prefix = $order_prefix_data ? $order_prefix_data->val : '';

        $notify_type = null;

        $status=$request->status;

        switch ($status) {
            case 'accept':
                $notify_type = 'order_accepted';
                break;
            case 'processing':
                $notify_type = 'order_proccessing';
                break;
            case 'delivered':
                $notify_type = 'order_delivered';
                break;    
            case 'cancelled':
                $notify_type = 'order_cancelled';
                break;
        };

        $order_itemids [] = $orderItem->id;
        try {
            $notification_data = [
              
                'id' => optional($orderItem->order)->id,
                'order_code'=> $order_prefix . optional(optional($orderItem->order)->orderGroup)->order_code,
                'user_id' => optional($orderItem->order)->user_id,
                'user_name' => optional(optional($orderItem->order)->user)->first_name.' '.optional(optional($orderItem->order)->user)->last_name  ?? default_user_name(),
                'order_date' => $orderItem->updated_at->format('d/m/Y'),
                'order_time' => $orderItem->updated_at->format('h:i A'),
                'item_id' => $order_itemids,
            ];   
               
            $this->sendNotificationOnOrderUpdate($notify_type, $notification_data);
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
        }


        return response()->json(['status' => true, 'message' => 'Order delivery status has been updated']);
    }

    // add qty to stock
    private function addQtyToStock($order)
    {
        $orderItems = OrderItem::where('order_id', $order->id)->get();
        foreach ($orderItems as $orderItem) {
            $stock = $orderItem->product_variation->product_variation_stock;
            $stock->stock_qty += $orderItem->qty;
            $stock->save();

            $product = $orderItem->product_variation->product;
            $product->total_sale_count += $orderItem->qty;
            $product->save();

            if ($product->categories()->count() > 0) {
                foreach ($product->categories as $category) {
                    $category->total_sale_count += $orderItem->qty;
                    $category->save();
                }
            }
        }
    }

    // remove qty from stock
    private function removeQtyFromStock($order)
    {
        $orderItems = OrderItem::where('order_id', $order->id)->get();
        foreach ($orderItems as $orderItem) {
            $stock = $orderItem->product_variation->product_variation_stock;
            $stock->stock_qty -= $orderItem->qty;
            $stock->save();

            $product = $orderItem->product_variation->product;
            $product->total_sale_count -= $orderItem->qty;
            $product->save();

            if ($product->categories()->count() > 0) {
                foreach ($product->categories as $category) {
                    $category->total_sale_count -= $orderItem->qty;
                    $category->save();
                }
            }
        }
    }

    // Order Creation
    public function complete(Request $request)
    {
        $user = auth()->user();

        $userId = $user->id;

        $location_id = $request->location_id;

        $carts = Cart::where('user_id', $userId)->where('location_id', $location_id)->get();

        if (count($carts) > 0) {
            // check carts available stock -- todo::[update version] -> run this check while storing OrderItems
            foreach ($carts as $cart) {
                $productVariationStock = $cart->product_variation->product_variation_stock ? $cart->product_variation->product_variation_stock->stock_qty : 0;
                if ($cart->qty > $productVariationStock) {
                    $message = $cart->product_variation->product->name.' is out of stock';

                    return response()->json(['message' => $message, 'status' => false]);
                }
            }

            // create new order group
            $orderGroup = new OrderGroup;
            $orderGroup->user_id = $userId;
            $orderGroup->shipping_address_id = $request->shipping_address_id;
            $orderGroup->billing_address_id = $request->billing_address_id;
            $orderGroup->location_id = $location_id;
            $orderGroup->phone_no = $request->phone;
            $orderGroup->alternative_phone_no = $request->alternative_phone;
            $orderGroup->sub_total_amount = getSubTotal($carts, false, '', false);
            $orderGroup->total_tax_amount = 0;
            $orderGroup->total_coupon_discount_amount = 0;
            $logisticZone = LogisticZone::where('id', $request->chosen_logistic_zone_id)->first();
            // todo::[for eCommerce] handle exceptions for standard & express
            $orderGroup->total_shipping_cost = $logisticZone->standard_delivery_charge;
            $orderGroup->total_tips_amount = $request->tips;

            $orderGroup->grand_total_amount = $orderGroup->sub_total_amount + $orderGroup->total_tax_amount + $orderGroup->total_shipping_cost + $orderGroup->total_tips_amount - $orderGroup->total_coupon_discount_amount;
            $orderGroup->save();

            // order -> todo::[update version] make array for each vendor, create order in loop
            $order = new Order;
            $order->order_group_id = $orderGroup->id;
            $order->user_id = $userId;
            $order->location_id = $location_id;
            $order->total_admin_earnings = $orderGroup->grand_total_amount;
            $order->logistic_id = $logisticZone->logistic_id;
            $order->logistic_name = optional($logisticZone->logistic)->name;

            $order->shipping_cost = $orderGroup->total_shipping_cost; // todo::[update version] calculate for each vendors
            $order->tips_amount = $orderGroup->total_tips_amount; // todo::[update version] calculate for each vendors

            $order->save();

            // order items
            $total_points = 0;
            foreach ($carts as $cart) {
                $orderItem = new OrderItem;
                $orderItem->order_id = $order->id;
                $orderItem->product_variation_id = $cart->product_variation_id;
                $orderItem->qty = $cart->qty;
                $orderItem->location_id = $location_id;
                $orderItem->unit_price = variationDiscountedPrice($cart->product_variation->product, $cart->product_variation);
                $orderItem->total_tax = 0;
                $orderItem->total_price = $orderItem->unit_price * $orderItem->qty;
                $orderItem->save();

                $product = $cart->product_variation->product;
                $product->total_sale_count += $orderItem->qty;

                // minus stock qty
                try {
                    $productVariationStock = $cart->product_variation->product_variation_stock;
                    $productVariationStock->stock_qty -= $orderItem->qty;
                    $productVariationStock->save();
                } catch (\Throwable $th) {
                    //throw $th;
                }

                $product->stock_qty -= $orderItem->qty;
                $product->save();

                // category sales count
                if ($product->categories()->count() > 0) {
                    foreach ($product->categories as $category) {
                        $category->total_sale_count += $orderItem->qty;
                        $category->save();
                    }
                }
                $cart->delete();
            }

            $order->save();
            // payment gateway integration & redirection
            $orderGroup->payment_method = $request->payment_method;
            $orderGroup->save();


            $order_prefix_data=Setting::where('name','inv_prefix')->first();
            $order_prefix = $order_prefix_data ? $order_prefix_data->val : '';


            try {
                $notification_data = [

                    'id' => $order->id,
                    'order_code'=> $order_prefix . optional($order->orderGroup)->order_code,
                    'user_id' => $order->user_id,
                    'user_name' => optional($order->user)->first_name.' '.optional($order->user)->last_name  ?? default_user_name(),
            
                ];

            $this->sendNotificationOnOrderUpdate('order_placed', $notification_data);

            } catch (\Exception $e) {
                \Log::error($e->getMessage());
            }

            return true;
        }
    }

    # download invoice
    public function downloadInvoice($id)
    {
        if (session()->has('locale')) {
            $language_code = session()->get('locale', config('app.locale'));
        } else {
            $language_code = env('DEFAULT_LANGUAGE');
        }

        $font_family = "'Roboto','sans-serif'";

        $order = Order::findOrFail((int)$id);

        return PDF::loadView('product::backend.order.invoice', [
            'order' => $order,
            'font_family' => $font_family
        ], [], [])->stream(setting('order_code_prefix') . $order->orderGroup->order_code . '.pdf');
    }

    public function updateExpectedDeliveryDate(Request $request){
        $expected_delivery_date = $request->expected_delivery_date;

        $order_item = OrderItem::where('id', $request->item_id)->first();
        $expected_delivery_date = Carbon::parse($expected_delivery_date);
        $order_item->expected_delivery_date = $expected_delivery_date->toDateString();
        $order_item->save();

        return response()->json(['status' => true, 'message' => 'Expected delivery date updated']);
    }
}
