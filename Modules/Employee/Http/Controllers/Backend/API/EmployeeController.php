<?php

namespace Modules\Employee\Http\Controllers\Backend\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Modules\Employee\Models\BranchEmployee;
use Modules\Employee\Models\EmployeeRating;
use Modules\Employee\Transformers\EmployeeDetailResource;
use Modules\Employee\Transformers\EmployeeResource;
use Modules\Employee\Transformers\EmployeeReviewResource;
use Modules\Service\Models\ServiceEmployee;
use DB;
use Modules\Product\Models\Review;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class EmployeeController extends Controller
{

    public function employeeList(Request $request)
    {
        // $branchId = $request->input('branch_id');
        $perPage = $request->input('per_page', 10);

    $employee = User::select('users.*')->branch()->with('media', 'mainBranch')->where('status', 1)->whereNotNull('email_verified_at');
    if(!empty($request->type)){
        $employee =$employee->role($request->type);
    }
    $latitude = $request->input('latitude');
    $longitude = $request->input('longitude');
    if (!empty($latitude) && !empty($longitude)) {
        $earthRadius = 6371; // Radius of the Earth in kilometers
    
        $employee = $employee->selectRaw(
            "users.*, 
            (
                6371 * 2 * ASIN(SQRT(
                    POW(SIN(RADIANS($latitude - users.latitude) / 2), 2) +
                    COS(RADIANS($latitude)) * COS(RADIANS(users.latitude)) *
                    POW(SIN(RADIANS($longitude - users.longitude) / 2), 2)
                ))
            ) AS distance"
        );
        
        $employee = $employee->orderByRaw('ISNULL(distance), distance ASC');
    }

    if (! empty($request->service_ids)) {
        $ids = ServiceEmployee::whereIn('service_id', explode(' ', $request->service_ids))->pluck('employee_id');
        $employee = $employee->whereIn('id', $ids);
    }
    if (! empty($request->order_by) && $request->order_by == 'top') {
        $employee = $employee->withCount('services')
            ->orderByDesc('services_count');
    }
    if ($request->has('search')) {
        $searchTerm = $request->search; 
        $employee = $employee->where(function ($query) use ($searchTerm) {
            $query->where('first_name', 'like', "%{$searchTerm}%")
            ->orWhere('last_name', 'like', "%{$searchTerm}%")
            ->orWhere('email', 'like', "%{$searchTerm}%")
            ->orWhere('mobile', 'like', "%{$searchTerm}%")
            ->orWhere('gender', 'like', "%{$searchTerm}%")
            ->orWhere(function ($subQuery) use ($searchTerm) {
                $subQuery->whereRaw("CONCAT(first_name, ' ', last_name) LIKE ?", ["%$searchTerm%"]);
            });;
        });
    }
    $employee = $employee->paginate($perPage);
    $responseData = EmployeeResource::collection($employee);

    return response()->json([
        'status' => true,
        'data' => $responseData,
        'message' => __('employee.employee_list'),
    ], 200);
}
    

    // public function employeeList(Request $request)
    // {
    //     // $branchId = $request->input('branch_id');
    //     $perPage = $request->input('per_page', 10);

    //     $employee = User::select('users.*')->branch()->with('media', 'mainBranch')->orderBy('updated_at', 'desc')->where('status', 1);
    //     if(!empty($request->type)){
    //         $employee =$employee->role($request->type);
    //     }
    
    //     if (! empty($request->service_ids)) {
    //         $ids = ServiceEmployee::whereIn('service_id', explode(' ', $request->service_ids))->pluck('employee_id');
    //         $employee = $employee->whereIn('id', $ids);
    //     }
    //     if (! empty($request->order_by) && $request->order_by == 'top') {
    //         $employee = $employee->withCount('services')
    //             ->orderByDesc('services_count');
    //     }
    //     $employee = $employee->paginate($perPage);
    //     $responseData = EmployeeResource::collection($employee);

    //     return response()->json([
    //         'status' => true,
    //         'data' => $responseData,
    //         'message' => __('employee.employee_list'),
    //     ], 200);
    // }

    public function employeeDetail(Request $request)
    {
        $branchId = $request->input('branch_id');
        $employeeId = $request->input('employee_id');

        if ($branchId && $employeeId) {
            // Fetch employee details based on both branch_id and employee_id
            $employee = User::role('employee')->with('media')->whereHas('branches', function ($query) use ($branchId) {
                $query->where('branch_id', $branchId);
            })->find($employeeId);
        } elseif ($branchId) {
            // Fetch employee details based on branch_id
            $employee = User::role('employee')->with('media')->whereHas('branches', function ($query) use ($branchId) {
                $query->where('branch_id', $branchId);
            })->first();
        } elseif ($employeeId) {
            // Fetch employee details based on employee_id
            $employee = User::role('employee')->with('media')->find($employeeId);
        } else {
            return response()->json(['status' => false, 'message' => __('employee.branch_employee_id')]);
        }

        if ($employee) {
            return response()->json(['status' => true, 'data' => new EmployeeDetailResource($employee), 'message' => __('employee.employee_detail')]);
        } else {
            return response()->json(['status' => false, 'message' => __('employee.employee_notfound')]);
        }
    }

    public function saveRating(Request $request)
    {
        $user = auth()->user();
        $rating_data = $request->all();
        $rating_data['user_id'] = $user->id;
        $result = EmployeeRating::updateOrCreate(['id' => $request->id], $rating_data);

        $message = __('employee.rating_update');
        if ($result->wasRecentlyCreated) {
            $message = __('employee.rating_add');
        }

        return response()->json(['status' => true, 'message' => $message]);
    }

    public function deleteRating(Request $request)
    {
        $user = auth()->user();
        $rating = EmployeeRating::where('id', $request->id)->where('user_id', $user->id)->first();
        if ($rating == null) {
            $message = __('employee.rating_notfound');

            return response()->json(['status' => false, 'message' => $message]);

        }
        $message = __('employee.rating_delete');
        $rating->delete();

        return response()->json(['status' => true, 'message' => $message]);
    }

    public function getRating(Request $request)
    {
        $employee_id = $request->employee_id;

        $perPage = $request->input('per_page', 10); // Get the number of items per page from the request (default: 10)

        if (! empty($request->branch_id)) {
            $branch_employee = BranchEmployee::where('branch_id', $request->branch_id)->pluck('employee_id');
            $reviews = EmployeeRating::whereIn('employee_id', $branch_employee)->get();

        } 

        if(auth()->user()->roles()->count() == 1 && auth()->user()->hasRole('pet_store')){
            $reviews = Review::select('id', 'employee_id', 'user_id', 'review_msg', 'rating', 'created_at', 'updated_at')->with('gallery')->where('employee_id', $employee_id)->get();
        }
        else if(auth()->user()->roles()->count() == 2 && auth()->user()->hasRole('pet_store')){
            $reviews = EmployeeRating::orderBy('updated_at', 'desc')->where('employee_id', $employee_id)->get();
            if(auth()->user()->hasRole('pet_store')){
                $productReview = Review::select('id', 'employee_id', 'user_id', 'review_msg', 'rating', 'created_at', 'updated_at')->with('gallery')->orderBy('updated_at', 'desc')->where('employee_id', $employee_id)->get();
                $reviews = $reviews->merge($productReview);
            }
        }
        else{
            $reviews = EmployeeRating::where('employee_id', $employee_id)->get();
        }

        if(isset($request->filter)){
            if($request->filter == 'by_service'){
                $reviews = EmployeeRating::where('employee_id', $employee_id)->get();
            }
            if($request->filter == 'by_order'){
                $reviews = Review::select('id', 'employee_id', 'user_id', 'review_msg', 'rating', 'created_at', 'updated_at')->with('gallery')->where('employee_id', $employee_id)->get();
            }
        }

        $reviews = new LengthAwarePaginator(
            $reviews->forPage($request->page, $perPage),  
            $reviews->count(),  
            $perPage,  
            $request->page,  
        );
        // $reviews = $reviews->orderBy('updated_at', 'desc')->paginate($perPage);

        $review = EmployeeReviewResource::collection($reviews);

        return response()->json([
            'status' => true,
            'data' => $review,
            'message' => __('employee.review_list'),
        ], 200);
    }
}
