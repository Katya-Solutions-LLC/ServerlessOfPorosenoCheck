<?php

namespace Modules\Service\Http\Controllers\Backend\API;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Service\Models\ServiceTraining;
use Modules\Service\Transformers\ServiceTrainingResource;

class ServiceTrainingController extends Controller
{
    public function trainingList(Request $request)
    {
        $perPage = $request->input('per_page', 10);

        $servicetraining =  ServiceTraining::where('status',1);
      
        if ($request->has('search')) {
            $servicetraining->where('name', 'like', "%{$request->search}%")
                            ->orWhere('description', 'like', "%{$request->search}%");
        }

        $servicetraining = $servicetraining->paginate($perPage);
        $items = ServiceTrainingResource::collection($servicetraining);
      

        return response()->json([
            'status' => true,
            'data' => $items,
            'message' => __('service.training_list'),
        ], 200);
    }


    public function store(Request $request)
    {
        $data = ServiceTraining::create($request->all());

        $message = __('messages.create_form', ['form' => __('service.singular_title')]);

        return response()->json(['message' => $message, 'status' => true], 200);
    }

}
