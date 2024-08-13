<?php

namespace Modules\Service\Http\Controllers\Backend\API;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Service\Models\ServiceDuration;
use Modules\Service\Transformers\ServiceDurationResource;

class ServiceDurationController extends Controller
{
    public function durationList(Request $request)
    {
        $perPage = $request->input('per_page', 10);

        $serviceduration =  ServiceDuration::where('status',1);
      
        if ($request->has('search')) {
            $serviceduration->where('type', 'like', "%{$request->search}%");
        }

        if ($request->has('type') && $request->type != '') {
            $serviceduration = $serviceduration->Where('type', $request->type);
        }

        $serviceduration = $serviceduration->paginate($perPage);
        $items = ServiceDurationResource::collection($serviceduration);
      

        return response()->json([
            'status' => true,
            'data' => $items,
            'message' => __('service.duration_list'),
        ], 200);
    }
}
