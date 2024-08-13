<?php

namespace Modules\Event\Http\Controllers\Backend\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Event\Models\Event;
use Modules\Event\Transformers\EventResource;
use Illuminate\Support\Facades\Http;
use App\Models\Setting;

class EventController extends Controller
{
    public function __construct()
    {
    }

    public function eventList(Request $request)
    {
        $perPage = $request->input('per_page', 10); // Get the number of items per page from the request (default: 10)
        // $branchId = $request->input('branch_id');

        $event = Event::with('media')->where('status', 1);

        $event = $event->orderBy('date','asc')->paginate($perPage);



        if($request->has('latitude') && !empty($request->latitude) && $request->has('longitude') && !empty($request->longitude)) {

          $setting_data=Setting::where('name','google_maps_key')->first();

         if($setting_data !='' && $setting_data->val !='' ){
        
            $key= $setting_data->val;
            $events = Event::with('media')
                ->where('status', 1)
                ->paginate($request->get('per_page', 10));
    
            // Calculate latitude and longitude for each event and calculate distance
            $events->transform(function ($event) use ($request,$key) {
                $address = $event->location;
    
                $response = Http::get('https://maps.googleapis.com/maps/api/geocode/json', [
                    'address' => $address,
                    'key' => $key,
                ]);
    
                if ($response->successful()) {
                    $data = $response->json();
    
                    $latitude = $data['results'][0]['geometry']['location']['lat'];
                    $longitude = $data['results'][0]['geometry']['location']['lng'];
    
                } else {
                    $latitude = 0.0;
                    $longitude = 0.0;
                }
    
                // Update event object with latitude and longitude
                $event->latitude = $latitude;
                $event->longitude = $longitude;
    
                // Calculate distance for each event
                $earthRadius = 6371;
                $event->distance = $earthRadius * 2 * asin(sqrt(
                    pow(sin(deg2rad($request->latitude - $event->latitude) / 2), 2) +
                    cos(deg2rad($request->latitude)) * cos(deg2rad($event->latitude)) *
                    pow(sin(deg2rad($request->longitude - $event->longitude) / 2), 2)
                ));
    
                return $event;
            });
    
            // Sort events by distance in ascending order
            $events = $events->sortBy('distance')->values();
    
            $items = EventResource::collection($events);
    
            return response()->json([
                'status' => true,
                'data' => $items,
                'message' => __('event.event_list'),
            ], 200);
         }
       }
    
        $items = EventResource::collection($event);

        return response()->json([
            'status' => true,
            'data' => $items,
            'message' => __('event.event_list'),
        ], 200);
    }
 
}
