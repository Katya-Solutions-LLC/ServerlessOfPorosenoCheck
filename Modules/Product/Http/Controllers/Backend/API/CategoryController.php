<?php

namespace Modules\Product\Http\Controllers\Backend\API;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Product\Models\ProductCategory;
use Modules\Product\Transformers\ProductCategoryResource;
use App\Models\User;

class CategoryController extends Controller
{
  
    public function categoryList(Request $request)
    {
        $perPage = $request->input('per_page', 10); // Get the number of items per page from the request (default: 10)
        $branchId = $request->input('branch_id');
        $employee_id = $request->input('employee_id');        
        $filter_type = $request->input('filter_type');
        $category = ProductCategory::query();
            // ->whereHas('branches', function ($query) use ($branchId) {
            //     $query->where('branch_id', $branchId);
            // });

        $user = User::find($employee_id);
        if ($request->has('filter_type') && $request->filter_type == 'created_by_admin') {
            $adminRoles = ['admin', 'demo_admin'];

            $category = $category->where('created_by', null)
                    ->orWhereIn('created_by', User::whereHas('roles', function ($query) use ($adminRoles) {
                        $query->whereIn('name', $adminRoles);
                    })->pluck('id'));
        } else if ($request->has('filter_type') && $request->filter_type == 'added_by_me') {
            $category->where('created_by', $employee_id);
        } else if ($request->has('search')) { 
            $category->where('name', 'like', "%{$request->search}%");
        } else {
            $category->with('media')->where('status', 1);
        }

        if ($request->has('category_id') && $request->category_id != '') {
            $category = $category->where('parent_id', $request->category_id);
        } else {
            $category = $category->whereNull('parent_id');
        }

        $category = $category->paginate($perPage);
       // $category = $category->paginate($perPage)->appends('branch_id', $branchId);
        $categoryCollection = ProductCategoryResource::collection($category);

        return response()->json([
            'status' => true,
            'data' => $categoryCollection,
            'message' => __('category.category_list'),
        ], 200);
    }
    



}
