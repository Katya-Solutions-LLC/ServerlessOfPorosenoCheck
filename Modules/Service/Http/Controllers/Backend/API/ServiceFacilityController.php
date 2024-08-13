<?php

namespace Modules\Service\Http\Controllers\Backend\API;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Service\Models\ServiceFacility;
use Modules\Service\Transformers\ServiceFacilityResource;

class ServiceFacilityController extends Controller
{
    public function facilityList(Request $request)
    {
        $perPage = $request->input('per_page', 10);

        $servicefacility =  ServiceFacility::where('status',1);
      
        if ($request->has('search')) {
            $servicefacility->where('name', 'like', "%{$request->search}%")
                            ->orWhere('description', 'like', "%{$request->search}%");
        }

        $servicefacility = $servicefacility->paginate($perPage);
        $items = ServiceFacilityResource::collection($servicefacility);
      

        return response()->json([
            'status' => true,
            'data' => $items,
            'message' => __('service.facility_list'),
        ], 200);
    }
}
