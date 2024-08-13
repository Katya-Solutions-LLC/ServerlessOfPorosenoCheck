<?php

namespace Modules\Blog\Http\Controllers\Backend\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Blog\Models\Blog;
use Modules\Blog\Transformers\BlogResource;

class BlogController extends Controller
{
    public function __construct()
    {
    }

    public function blogList(Request $request)
    {
        $perPage = $request->input('per_page', 10); // Get the number of items per page from the request (default: 10)
        // $branchId = $request->input('branch_id');

        $blog = Blog::with('media')->where('status', 1);
        
        $blog = $blog->orderBy('updated_at','desc')->paginate($perPage);
        $items = BlogResource::collection($blog);

        return response()->json([
            'status' => true,
            'data' => $items,
            'message' => __('blog.blog_list'),
        ], 200);
    }
 
}
