<?php

namespace Modules\Logistic\Http\Controllers\Backend\API;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Models\Address;
use Modules\Logistic\Models\LogisticZone;
use Modules\Logistic\Transformers\LogisticZoneResource;
use App\Models\User;

class LogisticZoneController extends Controller
{
    
    public function logisticzoneList(Request $request)
    {
      $perPage = $request->input('per_page', 10); 
      $employee_id = $request->input('employee_id');        
      $filter_type = $request->input('filter_type');

      $query_data = LogisticZone::query();

      $user = User::find($employee_id);
      if ($request->has('filter_type') && $request->filter_type == 'created_by_admin') {
          $adminRoles = ['admin', 'demo_admin'];

            $query_data = $query_data->where('created_by', null)
                    ->orWhereIn('created_by', User::whereHas('roles', function ($query) use ($adminRoles) {
                        $query->whereIn('name', $adminRoles);
                    })->pluck('id'))->with('cities','logistic');
      }else if ($request->has('filter_type') && $request->filter_type == 'added_by_me') {
          $query_data = $query_data->where('created_by', $employee_id)->with('cities','logistic');
      }else{
          $query_data->with('cities','logistic');
      }

      if($request->has('address_id') && $request->address_id != '') {

          $user_address=Address::where('id',$request->address_id)->first();

          if($user_address){

            $query_data->whereHas('cities', function ($query) use ($user_address) {
                $query->where('city_id', $user_address->city);
            });
    
          }else{

              return response()->json([
                 'status' => true,
                 'message' => __('product.user_address_not_found'),
              ], 200);
          }

      }

       $logisticZone = $query_data->paginate($perPage);
    
       $logisticZoneCollection = LogisticZoneResource::collection($logisticZone);

       return response()->json([
           'status' => true,
           'data' => $logisticZoneCollection,
           'message' => __('product.logistic_zone_list'),
       ], 200);

      
    }

  
}
