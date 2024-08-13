<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Role;
use App\Models\Setting;
use Illuminate\Http\Request;
use Modules\Constant\Models\Constant;
use Modules\Service\Models\Service;

class SearchController extends Controller
{
    public function get_search_data(Request $request)
    {

        $is_multiple = isset($request->multiple) ? explode(',', $request->multiple) : null;
        if (isset($is_multiple) && count($is_multiple)) {
            $multiplItems = [];
            foreach ($is_multiple as $key => $value) {
                $multiplItems[$key] = $this->getData(collect($request[$value]));
            }

            return response()->json(['status' => 'true', 'results' => $multiplItems]);
        } else {
            return response()->json(['status' => 'true', 'results' => $this->getData($request->all())]);
        }
    }

    public function get_order_status_data(Request $request)
    {
        $items = [];
        $itemsVal = [];
        $type = $request['type'];
        $sub_type = $request['sub_type'] ?? null;

        $keyword = $request['q'] ?? null;
        $delivery_status = $request['delivery_status'] ?? null;

        $is_multiple = isset($request->multiple) ? explode(',', $request->multiple) : null;
        if (isset($is_multiple) && count($is_multiple)) {
            $multiplItems = [];
            foreach ($is_multiple as $key => $value) {
                $multiplItems[$key] = $this->getData(collect($request[$value]));
            }

            return response()->json(['status' => 'true', 'results' => $multiplItems]);
        } else {

            $query = Constant::getAllConstant()->where('type', $sub_type);
            foreach ($query as $key => $data) {
                if ($keyword != '') {
                    if (strpos($data->name, str_replace(' ', '_', strtolower($keyword))) !== false) {
                        $itemsVal[] = [
                            'id' => $data->name,
                            'text' => $data->value,
                        ];
                    }
                } else {
                    $itemsVal[] = [
                        'id' => $data->name,
                        'text' => $data->value,
                    ];
                }
            }
            if($delivery_status === 'order_placed') {
                $items = array_values(array_filter($itemsVal, function($item) {
                    return $item['id'] === 'accept';
                }));
            } 
            if($delivery_status === 'accepted') {
                $items = array_values(array_filter($itemsVal, function($item) {
                    return $item['id'] === 'processing';
                }));
            } 
            if($delivery_status === 'processing') {
                $items = array_values(array_filter($itemsVal, function($item) {
                    return $item['id'] === 'delivered';
                }));
            } 

            return response()->json(['status' => 'true', 'results' => $items]);
        }
    }

    // case 'users':
    // select('id as $key','name as $value')
    // select(\DB::raw("value $key,label $value"))
    // if($keyword != ''){
    //   $items->where('category_name', 'LIKE', $keyword.'%');
    // }
    //   break;
    protected function getData($request)
    {

        $items = [];

        $type = $request['type'];
        $sub_type = $request['sub_type'] ?? null;

        $keyword = $request['q'] ?? null;

        switch ($type) {
            case 'employees':
                // Need To Add Role Base
                $items = User::select('id', \DB::raw("CONCAT(first_name,' ',last_name) AS text"));
                if ($keyword != '') {
                    $items->where(\DB::raw("CONCAT(first_name, ' ', last_name)"), 'LIKE', '%'.$keyword.'%');
                }
                $items = $items->limit(50)->get();
                break;
                case 'boarder':
                    // Need To Add Role Base
                    $items = User::role('boarder')->select('id', \DB::raw("CONCAT(first_name,' ',last_name) AS text"));
                    if ($keyword != '') {
                        $items->where(\DB::raw("CONCAT(first_name, ' ', last_name)"), 'LIKE', '%'.$keyword.'%');
                    }
                    $items = $items->limit(50)->get();
                  break;  
                  case 'groomer':
                    // Need To Add Role Base
                    $items = User::role('groomer')->select('id', \DB::raw("CONCAT(first_name,' ',last_name) AS text"));
                    if ($keyword != '') {
                        $items->where(\DB::raw("CONCAT(first_name, ' ', last_name)"), 'LIKE', '%'.$keyword.'%');
                    }
                    $items = $items->limit(50)->get();
                  break;    
            case 'customers':
                $items = User::role('user')->select('id', \DB::raw("CONCAT(first_name,' ',last_name) AS text"));
                if ($keyword != '') {
                    $items->where(\DB::raw("CONCAT(first_name, ' ', last_name)"), 'LIKE', '%'.$keyword.'%');
                }
                $items = $items->limit(50)->get();
                break;
            case 'services':
                $items = Service::select('id', 'name as text');
                if ($keyword != '') {
                    $items->where('name', 'LIKE', '%'.$keyword.'%');
                }

                $items = $items->limit(50)->get();
                break;
            case 'earning_payment_method':
                $query = Constant::getAllConstant()
                    ->where('type', 'EARNING_PAYMENT_TYPE');
                foreach ($query as $key => $data) {
                    if ($keyword != '') {
                        if (strpos($data->name, str_replace(' ', '_', strtolower($keyword))) !== false) {
                            $items[] = [
                                'id' => $data->name,
                                'text' => $data->value,
                            ];
                        }
                    } else {
                        $items[] = [
                            'id' => $data->name,
                            'text' => $data->value,
                        ];
                    }
                }
                break;

            case 'booking_status':
                $query = Constant::getAllConstant()
                    ->where('type', 'BOOKING_STATUS');
                foreach ($query as $key => $data) {
                    if ($keyword != '') {
                        if (strpos($data->name, str_replace(' ', '_', strtolower($keyword))) !== false) {
                            $items[] = [
                                'id' => $data->name,
                                'text' => $data->value,
                            ];
                        }
                    } else {
                        $items[] = [
                            'id' => $data->name,
                            'text' => $data->value,
                        ];
                    }
                }
                break;

            case 'time_zone':
                $items = timeZoneList();

                // foreach ($items as $k => $v) {

                //    if($value !=''){
                //         if (strpos($v, $value) !== false) {

                //         }else{
                //              unset($items[$k]);
                //         }
                //    }
                // }

                $data = [];
                $i = 0;
                foreach ($items as $key => $row) {
                    $data[$i] = [
                        'id' => $key,
                        'text' => $row,
                    ];

                    $i++;
                }

                $items = $data;

                break;

            case 'additional_permissions':
                $query = Constant::getAllConstant()
                    ->where('type', 'additional_permissions');
                foreach ($query as $key => $data) {
                    if ($keyword != '') {
                        if (strpos($data->name, str_replace(' ', '_', strtolower($keyword))) !== false) {
                            $items[] = [
                                'id' => $data->name,
                                'text' => $data->value,
                            ];
                        }
                    } else {
                        $items[] = [
                            'id' => $data->name,
                            'text' => $data->value,
                        ];
                    }
                }

                break;

                case 'constant':
                    $query = Constant::getAllConstant()->where('type', $sub_type);
                    foreach ($query as $key => $data) {
                        if ($keyword != '') {
                            if (strpos($data->name, str_replace(' ', '_', strtolower($keyword))) !== false) {
                                $items[] = [
                                    'id' => $data->name,
                                    'text' => $data->value,
                                ];
                            }
                        } else {
                            $items[] = [
                                'id' => $data->name,
                                'text' => $data->value,
                            ];
                        }
                    }
    
                    break;

            case 'role':
                $query = Role::all();
                foreach ($query as $key => $data) {
                    if ($keyword != '') {
                        if (strpos($data->name, str_replace(' ', '_', strtolower($keyword))) !== false) {
                            $items[] = [
                                'id' => $data->id,
                                'text' => $data->name,
                            ];
                        }
                    } else {
                        $items[] = [
                            'id' => $data->id,
                            'text' => $data->name,
                        ];
                    }
                }

                break;
           }

        return $items;
    }
}
