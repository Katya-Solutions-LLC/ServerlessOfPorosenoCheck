<?php

namespace Modules\Product\Http\Controllers\Backend\API;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Product\Transformers\UnitResource;
use Modules\Product\Models\Unit;
use App\Models\User;


class UnitsController extends Controller
{

    public function product_unit(Request $request)
    {

        $perPage = $request->input('per_page', 10); // Get the number of items per page from the request (default: 10)
        $branchId = $request->input('branch_id');
        $employee_id = $request->input('employee_id');  
        $added_by_admin = $request->input('added_by_admin');        
        $filter_type = $request->input('filter_type');
        $unit = Unit::query()->checkMultivendor();

        $user = User::find($employee_id);
        if($added_by_admin === "1"){
            $unit->whereHas('user', function ($q) {
                $q->whereIn('user_type', ['admin', 'demo_admin']);
            })
            ->orWhereNull('created_by');
        }
        if ($request->has('employee_id')) {
            $unit = $unit->where('created_by', $employee_id);
        }
        if ($request->has('filter_type') && $request->filter_type == 'created_by_admin') {
            $adminRoles = ['admin', 'demo_admin'];

            $unit = $unit->where('created_by', null)
                    ->orWhereIn('created_by', User::whereHas('roles', function ($query) use ($adminRoles) {
                        $query->whereIn('name', $adminRoles);
                    })->pluck('id'));
        } else
         if ($request->has('filter_type') && $request->filter_type == 'added_by_me') {
            // $unit->where('created_by', $employee_id);
            $unit;
        } else 
        if ($request->has('search')) { 
            $unit->where('name', 'like', "%{$request->search}%");
        } else {
            $unit->with('media')->where('status', 1);
        }
        $unit = $unit->paginate($perPage);
       // $unit = $unit->paginate($perPage)->appends('branch_id', $branchId);
        $unitCollection = unitResource::collection($unit);

        if($request->has('unit_id') && $request->unit_id != ''){

            $unit = $unit->where('id', $request->unit_id)->first();

            $unitCollection= new unitResource($unit);

         }

        return response()->json([
            'status' => true,
            'data' => $unitCollection,
            'message' => __('product.unit_list'),
        ], 200);
  
           
    }


}
