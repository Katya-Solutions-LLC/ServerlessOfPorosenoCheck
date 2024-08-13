<?php

namespace Modules\Service\Http\Controllers\Backend\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Category\Models\Category;
use Modules\Service\Models\Service;
use Modules\Service\Models\ServiceBranches;
use Modules\Service\Models\ServiceEmployee;
use Modules\Service\Models\ServiceGallery;
use Modules\Service\Transformers\ServiceResource;
use Modules\Service\Http\Requests\ServiceRequest;

class ServiceController extends Controller
{  

    public function store(ServiceRequest $request)
    {
        $data = $request->except('feature_image');
        $type = $request->type;

        $data['type'] = $type;

          if(auth()->user()->hasRole('admin') && auth()->user()->hasRole('demo_admin')) {
           
             $query = Service::create($data);

           }else{

            $data['created_by'] = auth()->id();

            $query = Service::create($data);

            ServiceEmployee::create([
                'service_id' => $query->id,
                'employee_id' => auth()->id(),
            ]);

         }

         storeMediaFile($query, $request->file('feature_image'));
        
        $message = __('messages.create_form', ['form' => __('service.singular_title')]);

        return response()->json(['message' => $message, 'status' => true], 200);
    }

    public function update(ServiceRequest $request)
    {
        $id=$request->id;

        $data = Service::findOrFail($id);

        $request_data = $request->except('feature_image');

        $data->update($request_data);

        storeMediaFile($data, $request->file('feature_image'), 'feature_image');

        $message = __('messages.update_form', ['form' => __('service.singular_title')]);

        return response()->json(['message' => $message, 'status' => true], 200);
    }

    public function destroy(Request $request)
    {
        $id=$request->id;

        if(env('IS_DEMO')) {
            return response()->json(['message' => __('messages.permission_denied'), 'status' => false], 200);
        }

        $data = Service::findOrFail($id);

        $data->branches()->delete();

        $data->employee()->delete();

        $data->delete();

        $message = __('messages.delete_form', ['form' => __('service.singular_title')]);

        return response()->json(['message' => $message, 'status' => true], 200);
    }




    public function assign_employee_list($id)
    {
        $service_user = ServiceEmployee::with('staff')->where('service_id', $id)->get();

        $service_user = $service_user->each(function ($data) {
            $data['name'] = $data->staff->name;
            $data['avatar'] = $data->staff->avatar;

            return $data;
        });

        return $this->sendResponse($service_user, __('service.stff_service'));
    }

    public function assign_employee_update($id, Request $request)
    {
        ServiceEmployee::where('service_id', $id)->delete();
        foreach ($request->staffs as $key => $value) {
            ServiceEmployee::create([
                'service_id' => $id,
                'employee_id' => $value['employee_id'],
            ]);
        }

        return $this->sendResponse($id, __('service.stff_service_update'));
    }

    // =========Service Staff Assign list and Assign update ======= //

    public function assign_branch_list($id)
    {
        $service_branch = ServiceBranches::with('branch')->where('service_id', $id)->get();
        $service_branch = $service_branch->each(function ($data) {
            $data['name'] = $data->branch->name;

            return $data;
        });

        return $this->sendResponse($service_branch, __('service.branch_service'));
    }

    public function assign_branch_update($id, Request $request)
    {
        ServiceBranches::where('service_id', $id)->delete();
        foreach ($request->branches as $key => $value) {
            ServiceBranches::create([
                'service_id' => $id,
                'branch_id' => $value['branch_id'],
                'service_price' => $value['service_price'] ?? 0,
                'duration_min' => $service['duration_min'],
            ]);
        }

        return $this->sendResponse($id, __('service.branch_service_update'));
    }

    public function ServiceGallery(Request $request)
    {
        $serviceId = $request->input('service_id');

        // Retrieve service-wise gallery
        if ($serviceId) {
            $service = Service::find($serviceId);

            if (! $service) {
                return response()->json([
                    'status' => false,
                    'message' => __('service.service_notfound'),
                ], 404);
            }

            $data = ServiceGallery::where('service_id', $serviceId)->get();

            $gallery = ['gallery' => $data, 'service' => $service];

            return response()->json([
                'status' => true,
                'data' => $gallery,
                'message' => __('service.service_gal_retrived'),
            ], 200);
        }

        // Retrieve all gallery
        $allData = ServiceGallery::all();

        return response()->json([
            'status' => true,
            'data' => $allData,
            'message' => __('service.servie_gallery'),
        ], 200);
    }

    public function uploadGalleryImages(Request $request, $id)
    {
        $gallery = collect($request->gallery, true);

        $images = ServiceGallery::where('service_id', $id)->whereNotIn('id', $gallery->pluck('id'))->get();

        foreach ($images as $key => $value) {
            $value->clearMediaCollection('gallery_images');
            $value->delete();
        }

        foreach ($gallery as $key => $value) {
            if ($value['id'] == 'null') {

                $serviceGallery = ServiceGallery::create([
                    'service_id' => $id,
                ]);

                $serviceGallery->addMedia($value['file'])->toMediaCollection('gallery_images');

                $serviceGallery->full_url = $serviceGallery->getFirstMediaUrl('gallery_images');
                $serviceGallery->save();
            }
        }

        return $this->sendResponse($id, __('service.service_gallery_update'));
    }

    public function serviceList(Request $request)
    {
        $perPage = $request->input('per_page', 10);

        $service =  Service::where('status',1)->with(['category','employee']);
      
        if ($request->has('category_id') && $request->category_id != '') {
            $service = $service->Where('category_id', $request->category_id);
        }
        if ($request->has('type') && $request->type != '') {
            $type = $request->type;
            if ($request->type == 'veterinary') {
                $service = $service->where(function ($query) use ($request) {
                    $query->where('type', $request->type)
                        ->orWhere('type', 'video-consultancy');
                });
            }
             else{
                $service = $service->Where('type', $request->type);
             }
         }

        if($request->has('employee_id') && $request->employee_id !=''){

            $employee_id=$request->employee_id;

            $service = $service->whereHas('employee', function ($q) use ($employee_id) {
                $q->where('employee_id', $employee_id);
            });

            if($request->has('service_type') && $request->service_type=='assign_by_admin') {

                $service = $service->where('created_by',null);
 
                }else if($request->has('service_type') && $request->service_type=='added_by_me'){

                    $service = $service->where('created_by', $employee_id);

               }else{

                $service  =  $service ->whereHas('employee', function ($q) use ($employee_id) {
                     $q->where('employee_id', $employee_id);
                  });

               }
                               
           }

    
        if ($request->has('search')) {
            $searchTerm = $request->search; 
            $service = $service->where(function ($query) use ($searchTerm) {
                $query->where('name', 'like', "%{$searchTerm}%")
                ->orWhere('description', 'like', "%{$searchTerm}%")
                ->orWhereHas('category', function ($categoryQuery) use ($searchTerm) {
                    $categoryQuery->where('name', 'like', "%{$searchTerm}%");
                });

            });
        }

        $service = $service->orderBy('updated_at', 'desc');

        $service = $service->paginate($perPage);
        $responseData = ServiceResource::collection($service);

        return response()->json([
            'status' => true,
            'data' => $responseData,
            'message' => __('service.service_list'),
        ], 200);
    }

    public function serviceDetails(Request $request)
    {
        $services = Service::where('status', 1)->with(['category', 'sub_category', 'branches']);

        if ($request->has('service_id')) {
            $services->where('id', $request->service_id);
        }

        if ($request->has('category_id')) {
            $services->where('category_id', $request->category_id);
        }

        if ($request->has('sub_category_id')) {
            $services->where('sub_category_id', $request->sub_category_id);
        }

        if ($request->has('branch_id')) {
            $services->whereHas('branches', function ($query) use ($request) {
                $query->where('branch_id', $request->branch_id);
            });
        }
        if ($request->has('name')) {
            $keyword = $request->input('name');
            $services->where('name', 'LIKE', '%'.$keyword.'%');
        }
        $filteredServices = $services->get();
        if ($filteredServices->isEmpty()) {
            return response()->json(['status' => false, 'message' => __('service.service_notfound')]);
        } else {
            return response()->json(['status' => true, 'data' => $filteredServices, 'message' => __('service.service_detail')]);
        }
    }

    public function searchServices(Request $request)
    {
        $searchQuery = $request->query('query');

        if (! $searchQuery) {
            return response()->json(['message' => __('service.service_search')], 400);
        }

        $services = Service::where(function ($query) use ($searchQuery) {
            $query->where('name', 'like', '%'.$searchQuery.'%')
                ->orWhere('description', 'like', '%'.$searchQuery.'%')
                ->orWhere('category', 'like', '%'.$searchQuery.'%');
        })->get();

        return response()->json($services);
    }
}
