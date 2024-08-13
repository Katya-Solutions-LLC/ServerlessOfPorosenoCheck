<?php

namespace Modules\Tag\Http\Controllers\Backend\API;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Tag\Models\Tag;
use Modules\Tag\Transformers\TagResource;
use App\Models\User;

class TagsController extends Controller
{
    public function productTag(Request $request)
    {

        $perPage = $request->input('per_page', 10); // Get the number of items per page from the request (default: 10)
        $branchId = $request->input('branch_id');
        $employee_id = $request->input('employee_id'); 
        $added_by_admin = $request->input('added_by_admin');         
        $filter_type = $request->input('filter_type');
        $tag = Tag::query()->checkMultivendor();
        if($added_by_admin === "1"){
            $tag->whereHas('user', function ($q) {
                $q->whereIn('user_type', ['admin', 'demo_admin']);
            })
            ->orWhereNull('created_by');
        }
        if ($request->has('employee_id')) {
            $tag = $tag->where('created_by', $employee_id);
        } 
        if ($request->has('filter_type') && $request->filter_type == 'created_by_admin') {
            $adminRoles = ['admin', 'demo_admin'];

            $tag = $tag->where('created_by', null)
                    ->orWhereIn('created_by', User::whereHas('roles', function ($query) use ($adminRoles) {
                        $query->whereIn('name', $adminRoles);
                    })->pluck('id'));
        } else if ($request->has('filter_type') && $request->filter_type == 'added_by_me') {
            // $tag->where('created_by', $employee_id);
            $tag;
        } else if ($request->has('search')) { 
            $tag->where('name', 'like', "%{$request->search}%");
        } else {
            $tag->with('media')->where('status', 1);
        }
        $tag = $tag->orderBy('updated_at', 'desc')->paginate($perPage);
       // $tag = $tag->paginate($perPage)->appends('branch_id', $branchId);
        $tagCollection = TagResource::collection($tag);

        if($request->has('tag_id') && $request->tag_id != ''){

            $tag = $tag->where('id', $request->tag_id)->first();

            $tagCollection= new TagResource($tag);

         }


        return response()->json([
            'status' => true,
            'data' => $tagCollection,
            'message' => __('tags.tag_list'),
        ], 200);
  
           
    }
}