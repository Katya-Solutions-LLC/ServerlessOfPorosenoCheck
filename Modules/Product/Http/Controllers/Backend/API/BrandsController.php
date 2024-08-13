<?php

namespace Modules\Product\Http\Controllers\Backend\API;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Product\Models\Brands;
use Modules\Product\Transformers\BrandResource;
use App\Models\User;

class BrandsController extends Controller
{
    public function product_brand(Request $request)
    {

        $perPage = $request->input('per_page', 10); // Get the number of items per page from the request (default: 10)
        $branchId = $request->input('branch_id');
        $employee_id = $request->input('employee_id');     
        $status = $request->input('status');   
        $added_by_admin = $request->input('added_by_admin');  
        $brand = Brands::query()->checkMultivendor();

        $user = User::find($employee_id);

        if($request->has('status')){
            if($status == 1){
                $brand->where('status', 1);
            }
        }
        if($added_by_admin === "1"){
            $brand->whereHas('user', function ($q) {
                $q->whereIn('user_type', ['admin', 'demo_admin']);
            })
            ->orWhereNull('created_by');
        }
        if ($request->has('employee_id')) {
            $brand = $brand->where('created_by', $employee_id);
        }
        if ($request->has('search')) { 
            $brand->where('name', 'like', "%{$request->search}%");
        }else{
            $brand->with('media');
        }
        $brand = $brand->paginate($perPage);
       // $brand = $brand->paginate($perPage)->appends('branch_id', $branchId);
        $brandCollection = BrandResource::collection($brand);

        if($request->has('brand_id') && $request->brand_id != ''){

            $brand = $brand->where('id', $request->brand_id)->first();

            $brandCollection= new BrandResource($brand);

         }


        return response()->json([
            'status' => true,
            'data' => $brandCollection,
            'message' => __('brand.brand_list'),
        ], 200);
  
           
    }


}
