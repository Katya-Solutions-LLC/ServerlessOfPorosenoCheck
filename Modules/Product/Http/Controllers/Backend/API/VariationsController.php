<?php

namespace Modules\Product\Http\Controllers\Backend\API;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Product\Transformers\VariationsResource;
use Modules\Product\Models\Variations;
use Modules\Product\Models\VariationValue;
use App\Models\User;


class VariationsController extends Controller
{
    public function productVariation(Request $request)
    {

        $perPage = $request->input('per_page', 10); // Get the number of items per page from the request (default: 10)
        $branchId = $request->input('branch_id');
        $employee_id = $request->input('employee_id');        
        $filter_type = $request->input('filter_type');
        $variation = Variations::query()->checkMultivendor();
             
        $user = User::find($employee_id);
        if ($request->has('filter_type') && $request->filter_type == 'created_by_admin') {
            $adminRoles = ['admin', 'demo_admin'];

            $variation = $variation->where('created_by', null)
                    ->orWhereIn('created_by', User::whereHas('roles', function ($query) use ($adminRoles) {
                        $query->whereIn('name', $adminRoles);
                    })->pluck('id'));
        }else if ($request->has('filter_type') && $request->filter_type == 'added_by_me') {
            $variation = $variation->where('created_by', $employee_id);
        }else{
            $variation->with('media')->where('status', 1);
        }
        $variation = $variation->paginate($perPage);
       // $variation = $variation->paginate($perPage)->appends('branch_id', $branchId);
        $variationCollection = VariationsResource::collection($variation);

        if($request->has('variation_id') && $request->variation_id != ''){

            $variation = $variation->where('id', $request->variation_id)->first();

            $variationCollection= new VariationsResource($variation);

         }

        return response()->json([
            'status' => true,
            'data' => $variationCollection,
            'message' => __('product.variations_list'),
        ], 200);
  
           
    }
}