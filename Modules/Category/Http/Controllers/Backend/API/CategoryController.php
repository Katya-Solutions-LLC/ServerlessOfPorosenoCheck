<?php

namespace Modules\Category\Http\Controllers\Backend\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Category\Models\Category;
use Modules\Category\Transformers\CategoryResource;

class CategoryController extends Controller
{
    public function __construct()
    {
    }

    public function categoryList(Request $request)
    {
        $perPage = $request->input('per_page', 10);

        $category =  Category::where('status',1);

        if ($request->has('type') && $request->type != '') {
            if ($request->type == 'veterinary') {
                $category = $category->where(function ($query) use ($request) {
                    $query->where('type', $request->type)
                        ->orWhere('type', 'video-consultancy');
                });
            } else {
                $category = $category->where('type', $request->type);
            }
        }

        if ($request->has('category_id') && $request->category_id != '') {
            $category = $category->where('parent_id', $request->category_id);
        } else {
            $category = $category->whereNull('parent_id');
        }

        if ($request->has('search')) {
            $searchTerm = $request->search; 
            $category = $category->where(function ($query) use ($searchTerm) {
                $query->where('name', 'like', "%{$searchTerm}%");
            });
        }
        
        $category = $category->orderBy('updated_at', 'DESC')->paginate($perPage);
        $categoryCollection = CategoryResource::collection($category);

        return response()->json([
            'status' => true,
            'data' => $categoryCollection,
            'message' => __('category.category_list'),
        ], 200);
    }

    public function categoryDetails(Request $request)
    {

        $categoryId = $request->category_id;

        $category = Category::find($categoryId);

        if ($category) {
            return response()->json(['status' => true, 'data' => $category, 'message' => __('category.category_detail')]);
        } else {
            return response()->json(['status' => false, 'message' => __('category.category_notfound')]);
        }
    }

    public function subCategoryList(Request $request)
    {
        $perPage = $request->input('per_page', 10);
        $subcategories = Category::whereNotNull('parent_id')->paginate($perPage);
        $subcategoryCollection = CategoryResource::collection($subcategories);
        $responseData = $subcategoryCollection->map(function ($item) {
            return $item->resource->toArray(request());
        });

        return response()->json([
            'status' => true,
            'data' => $responseData,
            'message' => __('category.subcategory_list'),
        ], 200);
    }

    public function subCategoryDetail(Request $request)
    {
        $parent_id = $request->input('parent_id');
        $category_id = $request->input('category_id');

        $subcategories = Category::where(function ($query) use ($parent_id, $category_id) {
            if ($parent_id && $category_id) {
                $query->where('parent_id', $parent_id)
                    ->where('id', $category_id);
            } elseif ($parent_id) {
                $query->where('parent_id', $parent_id);
            } elseif ($category_id) {
                $query->where('id', $category_id);
            }
        })->get();

        if ($subcategories->count() > 0) {
            return response()->json(['status' => true, 'data' => $subcategories, 'message' => __('category.category_detail')]);
        } else {
            return response()->json(['status' => false, 'message' => __('category.category_notfound')]);
        }
    }
}
