<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Modules\Booking\Models\Booking;
use Modules\Product\Models\Product;
use Modules\Product\Models\OrderItem;
use Modules\Product\Models\ProductVariation;
use Modules\Booking\Models\BookingService;
use Modules\Booking\Models\BookingTransaction;
use Modules\Employee\Models\EmployeeRating;
use Modules\Product\Models\ProductCategory;
use Modules\Booking\Models\BookingGroomingMapping;
use Modules\Booking\Models\BookingVeterinaryMapping;
use Modules\Product\Models\Order;
use Modules\Commission\Models\CommissionEarning;
use DB;
use DateTimeZone;
use Auth;

class BackendController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $recent_booking=Booking::with('user')->orderBy('id','desc')->take(6)->get();
        // $complete_service=Booking::where('status','completed')->count();

        $query = Booking::with(['user','pet','employee','payment'])->get();

        $completeBookingsCount = $query->where('status', 'completed')->count(); 
        $pendingBookingsCount = $query->where('status', 'pending')->count();

        $revenue_data=getRevenueData();

        $popular_employee= User::withCount(['employeeBooking' => function ($query) {
            $query->where('status', 'completed');
        }])
        ->where('user_type', '!=', 'user')
        ->orderByDesc('employee_booking_count')
        ->take(4)
        ->get();

        $popular_customers = User::withCount(['booking' => function ($query) {
            $query->where('status', 'completed');
        }])
        ->where('user_type','user')
        ->orderByDesc('booking_count')
        ->take(4)
        ->get();
        $popular_doctors = User::where('user_type','vet')->withCount(['rating as average_rating' => function($query) {
            $query->select(DB::raw('coalesce(avg(rating),0)'));
        }])->orderByDesc('average_rating')->take(4)->get();
        
        $reviews=EmployeeRating::with('user')->get();
        $totalCustomer=$reviews->pluck('user.id')->unique()->count();
        $averageRating = number_format($reviews->avg('rating'),1, '.', '');


        $topServices = Booking::where('booking_type', 'veterinary')
        ->with(['veterinary'])->get();

        $topproduct = ProductCategory::orderByDesc('total_sale_count')->limit(6)->get();
        $totalsale = ProductCategory::sum('total_sale_count');

        $veterinarybooking = BookingVeterinaryMapping::with('service')->select(DB::raw("(COUNT(*)) as count"),'service_id')
        ->groupBy('service_id');

        $groomingbooking = BookingGroomingMapping::with('service')->select(DB::raw("(COUNT(*)) as count"),'service_id')
        ->groupBy('service_id');
        $vetgroom = $veterinarybooking->union($groomingbooking);
        $totalservice = $vetgroom->count();
        $topservice = $vetgroom->orderByDesc('count')->take(4)->get();
       

        $data = [
            'recent_booking' => $recent_booking,
            'completeBookingsCount'=>$completeBookingsCount,
            'pendingBookingsCount'=>$pendingBookingsCount,
            'total_amount'=> $revenue_data['total_amount'],
            'total_commission'=>$revenue_data['total_commission'],
            'profit'=>$revenue_data['admin_earnings'],
            'popular_employee'=>$popular_employee,
            'reviews'=> $reviews,
            'totalCustomer'=> $totalCustomer,
            'averageRating'=> $averageRating,
            'popular_customers'=>$popular_customers,
            'popular_doctors'=>$popular_doctors,
            'top_product' =>  $topproduct,
            'total_sale_product' =>  ($totalsale == 0) ? 1 : $totalsale,
            'topservice' => $topservice,
            'totalservice' =>($totalservice == 0) ? 1 : $totalservice,
           // 'monthlyData'=>$monthlyData,

        ];  
     
        return view('backend.index', compact('data'));
    }

    //petstore dashboard
    public function employeeDashboard()
    {
        $user = Auth::user();
        $userId = $user->id;

        $query = Booking::with(['user','pet','employee','payment'])->get();

        $completeBookingsCount = $query->where('status', 'completed')->count(); 

        $revenue_data=getRevenueData();

        $topServices = Booking::where('booking_type', 'veterinary')
        ->with(['veterinary'])->get();

        $topproduct = ProductCategory::orderByDesc('total_sale_count')->limit(6)->get();
        $totalsale = ProductCategory::sum('total_sale_count');

        $veterinarybooking = BookingVeterinaryMapping::with('service')->select(DB::raw("(COUNT(*)) as count"),'service_id')
        ->groupBy('service_id');

        $groomingbooking = BookingGroomingMapping::with('service')->select(DB::raw("(COUNT(*)) as count"),'service_id')
        ->groupBy('service_id');
        $vetgroom = $veterinarybooking->union($groomingbooking);
        $totalservice = $vetgroom->count();
        $topservice = $vetgroom->orderByDesc('count')->take(4)->get();



        $bookings = Booking::with('user','pet','employee','payment')->where('employee_id', $user->id);
        $bookingCount = $bookings->count();
        $allBookings = $bookings->orderBy('id', 'desc')->take(10)->get();
        $pendingServicePayout = CommissionEarning::where('employee_id',$user->id)->where('commission_status','unpaid')->where('commissionable_type', 'Modules\Booking\Models\Booking')->sum('commission_amount');

        $productsCount = Product::where('created_by', $user->id)->count();
        $orders = Order::with('orderVendorMappings')
                ->whereHas('orderVendorMappings', function ($query) use ($userId) {
                    $query->where('vendor_id', $userId);
                });
        $orderCount = $orders->count();
        // $allOrder = $orders->orderBy('id', 'desc')->take(10)->get();
        $allOrder = OrderItem::with('order')->where('vendor_id', $userId)->orderBy('id', 'desc')->take(10)->get();
        $pendingOrderPayout = CommissionEarning::where('employee_id',$user->id)
                                ->whereHas('getOrderItem', function ($orderquery) {
                                    $orderquery->where('delivery_status', 'delivered');
                                })
                                ->where('commission_status','unpaid')
                                ->where('commissionable_type', 'Modules\Product\Models\OrderItem')
                                ->sum('commission_amount');
        $totalRevenue = CommissionEarning::where('employee_id',$user->id)->where('commission_status','paid')->sum('commission_amount');


        $data = [
            'all_bookings' => $allBookings,
            'bookingCount' => $bookingCount,
            'pending_service_payout' => $pendingServicePayout,
            'all_order' => $allOrder,
            'orderCount'=>$orderCount,
            'total_revenue'=> $totalRevenue,
            'top_product' =>  $productsCount,
            'pending_order_payout' => $pendingOrderPayout,
            'total_sale_product' =>  ($totalsale == 0) ? 1 : $totalsale,
            'topservice' => $topservice,
            'totalservice' =>($totalservice == 0) ? 1 : $totalservice,
        ];  
        return view('backend.petstore_index',compact('data'));

    }

    public function getRevenuechartData($type){

        $currentMonth = Carbon::now()->month;
        if($type =='year'){

            $monthlyTotals = DB::table('bookings')
            ->select(DB::raw('YEAR(start_date_time) as year, MONTH(start_date_time) as month, SUM(total_amount) as total_amount'))
            ->where('status', 'completed') 
            ->groupBy(DB::raw('YEAR(start_date_time), MONTH(start_date_time)'))
            ->orderBy(DB::raw('YEAR(start_date_time), MONTH(start_date_time)'))
            ->get();

              $chartData = [];
      
              for ($month = 1; $month <= 12; $month++) {
                  $found = false;
                  foreach ($monthlyTotals as $total) {
                      if ((int)$total->month === $month) {
                          $chartData[] = (float)$total->total_amount;
                          $found = true;
                          break;
                      }
                  }
                  if (!$found) {
                      $chartData[] = 0;
                  }
              };

           $category =["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct",
              "Nov", "Dec"];

           }else if($type =='month'){

            $firstWeek = Carbon::now()->startOfMonth()->week;

            $monthlyWeekTotals = DB::table('bookings')
                ->select(DB::raw('YEAR(start_date_time) as year, MONTH(start_date_time) as month, WEEK(start_date_time) as week, COALESCE(SUM(total_amount), 0) as total_amount'))
                ->where('status', 'completed') 
                ->where(DB::raw('YEAR(start_date_time)'), '=', Carbon::now()->year)
                ->where(DB::raw('MONTH(start_date_time)'), '=', $currentMonth)
                ->groupBy(DB::raw('YEAR(start_date_time), MONTH(start_date_time), WEEK(start_date_time)'))
                ->orderBy(DB::raw('YEAR(start_date_time), MONTH(start_date_time), WEEK(start_date_time)'))
                ->get();
        
            $chartData = [];
         

            for ($i = $firstWeek; $i <= $firstWeek+4; $i++) {
                $found = false;

                foreach ($monthlyWeekTotals as $total) {

                    if ((int)$total->month === $currentMonth && (int)$total->week === $i) {
                        $chartData[] = (float)$total->total_amount;
                        $found = true;
                        break;
                    }
                }
                if (!$found) {
                    $chartData[] = 0;
                }
             }
  
             $category =["Week 1", "Week 2", "Week 3", "Week 4",'Week 5'];

          }else{

            $currentWeekStartDate = Carbon::now()->startOfWeek();
            $lastDayOfWeek = Carbon::now()->endOfWeek();

            $weeklyDayTotals = DB::table('bookings')
             ->select(DB::raw('DAY(start_date_time) as day, COALESCE(SUM(total_amount), 0) as total_amount'))
             ->where('status', 'completed') 
             ->where(DB::raw('YEAR(start_date_time)'), '=', Carbon::now()->year)
             ->where(DB::raw('MONTH(start_date_time)'), '=', $currentMonth)
             ->whereBetween('start_date_time', [$currentWeekStartDate, $currentWeekStartDate->copy()->addDays(6)])
             ->groupBy(DB::raw('DAY(start_date_time)'))
             ->orderBy(DB::raw('DAY(start_date_time)'))
             ->get();

             $chartData = [];
             
             for($day =  $currentWeekStartDate; $day <= $lastDayOfWeek; $day->addDay()) {
                 $found = false;
             
                 foreach ($weeklyDayTotals as $total) {
                     if ((int)$total->day === $day->day) {
                         $chartData[] = (float)$total->total_amount;
                         $found = true;
                         break;
                     }
                 }
             
                 if (!$found) {
                     $chartData[] = 0;
                 }
             };

             $category =['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday','Sunday'];
             
          }

        $data=[

            'chartData'=>$chartData ,
            'category'=>$category

        ];

        return response()->json(['data' => $data, 'status' => true]);
        
    }

    public function getEmployeeRevenuechartData($type){

        $currentMonth = Carbon::now()->month;
        $user = Auth::user();
        $products = Product::where('created_by', $user->id);
        $productIds = $products->pluck('id');
        $productVarianceIds = ProductVariation::whereIn('product_id', $productIds)->pluck('id');
        if($type =='year'){

            $monthlyTotals = DB::table('orders')
                ->join('order_items', 'orders.id', '=', 'order_items.order_id')
                ->select(
                    DB::raw('YEAR(orders.created_at) as year'),
                    DB::raw('MONTH(orders.created_at) as month'),
                    DB::raw('SUM(order_items.total_price) as total_price')
                )
                ->whereIn('order_items.product_variation_id', $productVarianceIds)
                ->where('orders.payment_status', 'paid')
                ->groupBy(DB::raw('YEAR(orders.created_at), MONTH(orders.created_at)'))
                ->orderBy(DB::raw('YEAR(orders.created_at), MONTH(orders.created_at)'))
                ->get();
              $chartData = [];
      
              for ($month = 1; $month <= 12; $month++) {
                  $found = false;
                  foreach ($monthlyTotals as $total) {
                      if ((int)$total->month === $month) {
                          $chartData[] = (float)$total->total_price;
                          $found = true;
                          break;
                      }
                  }
                  if (!$found) {
                      $chartData[] = 0;
                  }
              };

           $category =["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct",
              "Nov", "Dec"];

           }else if($type =='month'){

            $firstWeek = Carbon::now()->startOfMonth()->week;

            $monthlyWeekTotals = DB::table('orders')
            ->join('order_items', 'orders.id', '=', 'order_items.order_id')
            ->select(
                DB::raw('YEAR(orders.created_at) as year'),
                DB::raw('MONTH(orders.created_at) as month'),
                DB::raw('WEEK(orders.created_at) as week'),
                DB::raw('COALESCE(SUM(order_items.total_price), 0) as total_price')
            )
            ->whereIn('order_items.product_variation_id', $productVarianceIds)
            ->where('orders.payment_status', 'paid')
            ->whereYear('orders.created_at', Carbon::now()->year)
            ->whereMonth('orders.created_at', $currentMonth)
            ->groupBy(DB::raw('YEAR(orders.created_at), MONTH(orders.created_at), WEEK(orders.created_at)'))
            ->orderBy(DB::raw('YEAR(orders.created_at), MONTH(orders.created_at), WEEK(orders.created_at)'))
            ->get();

            
        
            $chartData = [];
         

            for ($i = $firstWeek; $i <= $firstWeek+4; $i++) {
                $found = false;

                foreach ($monthlyWeekTotals as $total) {

                    if ((int)$total->month === $currentMonth && (int)$total->week === $i) {
                        $chartData[] = (float)$total->total_price;
                        $found = true;
                        break;
                    }
                }
                if (!$found) {
                    $chartData[] = 0;
                }
             }
  
             $category =["Week 1", "Week 2", "Week 3", "Week 4",'Week 5'];

          }else{

            $currentWeekStartDate = Carbon::now()->startOfWeek();
            $lastDayOfWeek = Carbon::now()->endOfWeek();

            $weeklyDayTotals = DB::table('orders')
            ->join('order_items', 'orders.id', '=', 'order_items.order_id')
            ->select(
                DB::raw('DAY(orders.created_at) as day'),
                DB::raw('COALESCE(SUM(order_items.total_price), 0) as total_price')
            )
            ->where('orders.payment_status', 'paid')
            ->whereYear('orders.created_at', Carbon::now()->year)
            ->whereMonth('orders.created_at', $currentMonth)
            ->whereBetween('orders.created_at', [$currentWeekStartDate, $currentWeekStartDate->copy()->addDays(6)])
            ->whereIn('order_items.product_variation_id', $productVarianceIds)
            ->groupBy(DB::raw('DAY(orders.created_at)'))
            ->orderBy(DB::raw('DAY(orders.created_at)'))
            ->get();

             $chartData = [];
             
             for($day =  $currentWeekStartDate; $day <= $lastDayOfWeek; $day->addDay()) {
                 $found = false;
             
                 foreach ($weeklyDayTotals as $total) {
                     if ((int)$total->day === $day->day) {
                         $chartData[] = (float)$total->total_price;
                         $found = true;
                         break;
                     }
                 }
             
                 if (!$found) {
                     $chartData[] = 0;
                 }
             };

             $category =['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday','Sunday'];
             
          }

        $data=[

            'chartData'=>$chartData ,
            'category'=>$category

        ];

        return response()->json(['data' => $data, 'status' => true]);
        
    }

    public function getProfitchartData($type){

        $currentMonth = Carbon::now()->month;
       
        if($type =='year'){

            $monthlyTotals = DB::table('commission_earnings')
            ->select(DB::raw('YEAR(created_at) as year, MONTH(created_at) as month, SUM(commission_amount) as commission_amount'))
            ->where('commission_status' , '!=', 'pending') 
            ->groupBy(DB::raw('YEAR(created_at), MONTH(created_at)'))
            ->orderBy(DB::raw('YEAR(created_at), MONTH(created_at)'))
            ->get();

              $chartData = [];
      
              for ($month = 1; $month <= 12; $month++) {
                  $found = false;
                  foreach ($monthlyTotals as $total) {
                      if ((int)$total->month === $month) {
                          $chartData[] = (float)$total->commission_amount;
                          $found = true;
                          break;
                      }
                  }
                  if (!$found) {
                      $chartData[] = 0;
                  }
              };

           $category =["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct",
              "Nov", "Dec"];

           }else if($type =='month'){

            $firstWeek = Carbon::now()->startOfMonth()->week;

            $monthlyWeekTotals = DB::table('commission_earnings')
                ->select(DB::raw('YEAR(created_at) as year, MONTH(created_at) as month, WEEK(created_at) as week, COALESCE(SUM(commission_amount), 0) as commission_amount'))
                ->where('commission_status' , '!=', 'pending')  
                ->where(DB::raw('YEAR(created_at)'), '=', Carbon::now()->year)
                ->where(DB::raw('MONTH(created_at)'), '=', $currentMonth)
                ->groupBy(DB::raw('YEAR(created_at), MONTH(created_at), WEEK(created_at)'))
                ->orderBy(DB::raw('YEAR(created_at), MONTH(created_at), WEEK(created_at)'))
                ->get();
        
            $chartData = [];
         

            for ($i = $firstWeek; $i <= $firstWeek+4; $i++) {
                $found = false;

                foreach ($monthlyWeekTotals as $total) {

                    if ((int)$total->month === $currentMonth && (int)$total->week === $i) {
                        $chartData[] = (float)$total->commission_amount;
                        $found = true;
                        break;
                    }
                }
                if (!$found) {
                    $chartData[] = 0;
                }
             }
  
             $category =["Week 1", "Week 2", "Week 3", "Week 4","Week 5"];

          }else{

            $currentWeekStartDate = Carbon::now()->startOfWeek();
            $lastDayOfWeek = Carbon::now()->endOfWeek();

            $weeklyDayTotals = DB::table('commission_earnings')
             ->select(DB::raw('DAY(created_at) as day, COALESCE(SUM(commission_amount), 0) as commission_amount'))
             ->where('commission_status' , '!=', 'pending') 
             ->where(DB::raw('YEAR(created_at)'), '=', Carbon::now()->year)
             ->where(DB::raw('MONTH(created_at)'), '=', $currentMonth)
             ->whereBetween('created_at', [$currentWeekStartDate, $currentWeekStartDate->copy()->addDays(6)])
             ->groupBy(DB::raw('DAY(created_at)'))
             ->orderBy(DB::raw('DAY(created_at)'))
             ->get();

             $chartData = [];
             
             for($day =  $currentWeekStartDate; $day <= $lastDayOfWeek; $day->addDay()) {
                 $found = false;
             
                 foreach ($weeklyDayTotals as $total) {
                     if ((int)$total->day === $day->day) {
                         $chartData[] = (float)$total->commission_amount;
                         $found = true;
                         break;
                     }
                 }
             
                 if (!$found) {
                     $chartData[] = 0;
                 }
             };

             $category =['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday','Sunday'];
             
          }

        $data=[

            'chartData'=>$chartData ,
            'category'=>$category

        ];

        return response()->json(['data' => $data, 'status' => true]);
        
    }

    public function getBookingchartData($type) {

        $currentMonth = Carbon::now()->month;

        if($type =='year'){

            $monthlyTotals = DB::table('bookings')
            ->select(DB::raw('YEAR(start_date_time) as year, MONTH(start_date_time) as month, COUNT(*) as total_bookings'))
            ->groupBy(DB::raw('YEAR(start_date_time), MONTH(start_date_time)'))
            ->orderBy(DB::raw('YEAR(start_date_time), MONTH(start_date_time)'))
            ->get();

              $chartData = [];
      
              for ($month = 1; $month <= 12; $month++) {
                  $found = false;
                  foreach ($monthlyTotals as $total) {
                      if ((int)$total->month === $month) {
                          $chartData[] = (float)$total->total_bookings;
                          $found = true;
                          break;
                      }
                  }
                  if (!$found) {
                      $chartData[] = 0;
                  }
              };

           $category =["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct",
              "Nov", "Dec"];

           }else if($type =='month'){

            $firstWeek = Carbon::now()->startOfMonth()->week;

            $monthlyWeekTotals = DB::table('bookings')
            ->select(DB::raw('YEAR(start_date_time) as year, MONTH(start_date_time) as month, WEEK(start_date_time) as week, COUNT(*) as total_bookings'))
            ->where(DB::raw('YEAR(start_date_time)'), '=', Carbon::now()->year)
            ->where(DB::raw('MONTH(start_date_time)'), '=', $currentMonth)
            ->groupBy(DB::raw('YEAR(start_date_time), MONTH(start_date_time), WEEK(start_date_time)'))
            ->orderBy(DB::raw('YEAR(start_date_time), MONTH(start_date_time), WEEK(start_date_time)'))
            ->get();
        
            $chartData = [];
         

            for ($i = $firstWeek; $i <= $firstWeek+4; $i++) {
                $found = false;

                foreach ($monthlyWeekTotals as $total) {

                    if ((int)$total->month === $currentMonth && (int)$total->week === $i) {
                        $chartData[] = (float)$total->total_bookings;
                        $found = true;
                        break;
                    }
                }
                if (!$found) {
                    $chartData[] = 0;
                }
             }
  
             $category =["Week 1", "Week 2", "Week 3", "Week 4",'Week5'];

           }else{

            $currentWeekStartDate = Carbon::now()->startOfWeek();
            $lastDayOfWeek = Carbon::now()->endOfWeek();
            
            $weeklyDayTotals = DB::table('bookings')
                ->select(DB::raw('DAYOFWEEK(start_date_time) - 1 as day, COUNT(*) as total_bookings')) // Subtract 1 to align with Carbon
                ->where(DB::raw('YEAR(start_date_time)'), '=', Carbon::now()->year)
                ->where(DB::raw('MONTH(start_date_time)'), '=', $currentMonth)
                ->whereBetween('start_date_time', [$currentWeekStartDate, $currentWeekStartDate->copy()->addDays(6)])
                ->groupBy(DB::raw('DAYOFWEEK(start_date_time) - 1')) // Subtract 1 to align with Carbon
                ->orderBy(DB::raw('DAYOFWEEK(start_date_time) - 1')) // Subtract 1 to align with Carbon
                ->get();
            
            $chartData = [];
            
            for ($day = $currentWeekStartDate->copy(); $day <= $lastDayOfWeek; $day->addDay()) { // Use a copy of the start date
                $found = false;
            
                foreach ($weeklyDayTotals as $total) {
                    if ((int)$total->day === $day->dayOfWeek) {
                        $chartData[] = (float)$total->total_bookings;
                        $found = true;
                        break;
                    }
                }
            
                if (!$found) {
                    $chartData[] = 0;
                }
            };

             $category =['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday','Sunday'];

           }

            
        $data=[

            'chartData'=>$chartData ,
            'category'=>$category

        ];


         return response()->json(['data' => $data, 'status' => true]);
    }

    
    public function getStatusBookingChartData($type) {
        $currentYear = Carbon::now()->year;
        $currentMonth = Carbon::now()->month;
        $yearlyTotalsQuery = DB::table('bookings')
            ->select('status')
            ->addSelect(DB::raw('
                SUM(CASE WHEN status = "pending" THEN 1 ELSE 0 END) as pending_bookings,
                SUM(CASE WHEN status = "confirmed" THEN 1 ELSE 0 END) as confirmed_bookings,
                SUM(CASE WHEN status = "cancelled" THEN 1 ELSE 0 END) as cancelled_bookings,
                SUM(CASE WHEN status = "rejected" THEN 1 ELSE 0 END) as rejected_bookings,
                SUM(CASE WHEN status = "completed" THEN 1 ELSE 0 END) as completed_bookings'))
            ->whereYear('start_date_time', $currentYear);
    
        if ($type == 'month') {
            $yearlyTotalsQuery->whereMonth('start_date_time', $currentMonth);
        } elseif ($type == 'week') {
            $currentWeekStartDate = Carbon::now()->startOfWeek();
            $currentWeekEndDate = Carbon::now()->endOfWeek();
            $yearlyTotalsQuery->whereBetween('start_date_time', [$currentWeekStartDate, $currentWeekEndDate]);
        }
    
        $yearlyTotals = $yearlyTotalsQuery->groupBy('status')->get();
    
        $statusCounts = [];
        foreach ($yearlyTotals as $total) {
            $status = $total->status;
            $statusCounts[] = (int) $total->{$status . '_bookings'};
        }
    
        return response()->json(['data' => $statusCounts, 'status' => true]);
    }
    



    public function setCurrentBranch($branch_id)
    {
        request()->session()->forget('selected_branch');

        request()->session()->put('selected_branch', $branch_id);

        return redirect()->back()->with('success', 'Current Branch Has Been Changes')->withInput();
    }

    public function resetBranch()
    {
        request()->session()->forget('selected_branch');

        return redirect()->back()->with('success', 'Show All Branch Content')->withInput();
    }

    public function setUserSetting(Request $request)
    {
      auth()->user()->update(['user_setting' => $request->settings]);

      return response()->json(['status'=>true]);
    }
}