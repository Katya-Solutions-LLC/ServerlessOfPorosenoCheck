<?php

namespace Modules\Logistic\Http\Controllers\Backend\API;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Logistic\Models\Logistic;
use Modules\Logistic\Transformers\LogisticsResource;
use App\Models\User;
use Modules\Logistic\Http\Requests\LogisticRequest;

class LogisticsController extends Controller
{
    
    public function logisticsList(Request $request)
    {
       $employee_id = $request->input('employee_id');        
       $filter_type = $request->input('filter_type');
       $logistics = Logistic::query();
           // ->whereHas('branches', function ($query) use ($branchId) {
           //     $query->where('branch_id', $branchId);
           // });        
       $user = User::find($employee_id);
       if ($request->has('filter_type') && $request->filter_type == 'created_by_admin') {
            $adminRoles = ['admin', 'demo_admin'];

            $logistics = $logistics->where('created_by', null)
                    ->orWhereIn('created_by', User::whereHas('roles', function ($query) use ($adminRoles) {
                        $query->whereIn('name', $adminRoles);
                    })->pluck('id'));
       }else if ($request->has('filter_type') && $request->filter_type == 'added_by_me') {
            $logistics = $logistics->where('created_by', $employee_id);
       }else{
            $logistics->with('media')->where('status', 1);
       }
       $per_page = config('constant.PER_PAGE_LIMIT');

       if ($request->has('per_page') && !empty($request->per_page)) {
           if (is_numeric($request->per_page)) {
               $per_page = $request->per_page;
           }
       
           if ($request->per_page === 'all') {
               $per_page = $logistics->count();
           }
       }
       
       $logistics = $logistics->paginate($per_page);
       
       $logisticsCollection = LogisticsResource::collection($logistics);
       
       return response()->json([
           'status' => true,
           'data' => $logisticsCollection,
           'message' => __('logistics.logistics_list'),
       ], 200);
       
    }
  
}
