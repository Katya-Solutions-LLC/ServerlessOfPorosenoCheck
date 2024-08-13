<?php

namespace Modules\Product\Http\Controllers\Backend;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Carbon\Carbon;
use Modules\Product\Models\Unit;
use Illuminate\Support\Str;
use Modules\CustomField\Models\CustomField;
use Modules\CustomField\Models\CustomFieldGroup;
use Yajra\DataTables\DataTables;
use Modules\Product\Http\Requests\UnitsRequest;
use Auth;

class UnitsController extends Controller
{
    // use Authorizable;

    public function __construct()
    {
        // Page Title
        $this->module_title = 'units.title';
        // module name
        $this->module_name = 'units';

        // module icon
        $this->module_icon = 'fa-solid fa-clipboard-list';

        view()->share([
            'module_title' => $this->module_title,
            'module_icon' => $this->module_icon,
            'module_name' => $this->module_name,
        ]);
    }

    public function bulk_action(Request $request)
    {
        $ids = explode(',', $request->rowIds);

        $actionType = $request->action_type;

        $message = __('messages.bulk_update');
        // dd($actionType, $ids, $request->status);
        switch ($actionType) {
            case 'change-status':
                $customer = Unit::whereIn('id', $ids)->update(['status' => $request->status]);
                $message = __('messages.bulk_customer_update');
                break;

            case 'delete':
                if (env('IS_DEMO')) {
                    return response()->json(['message' => __('messages.permission_denied'), 'status' => false], 200);
                }
                Unit::whereIn('id', $ids)->delete();
                $message = __('messages.bulk_customer_delete');
                break;

            default:
                return response()->json(['status' => false, 'message' => __('branch.invalid_action')]);
                break;
        }

        return response()->json(['status' => true, 'message' => __('messages.bulk_update')]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */

    public function index(Request $request)
    {
        $filter = [
            'status' => $request->status,
        ];

        $module_action = 'List';
        $columns = CustomFieldGroup::columnJsonValues(new Unit());
        $customefield = CustomField::exportCustomFields(new Unit());

        $export_import = true;
        $export_columns = [
            [
                'value' => 'name',
                'text' => ' Name',
            ]
        ];
        $export_url = route('backend.units.export');

        return view('product::backend.units.index_datatable', compact('module_action', 'filter', 'columns', 'customefield', 'export_import', 'export_columns', 'export_url'));
    }

    /**
     * Select Options for Select 2 Request/ Response.
     *
     * @return Response
     */
    public function index_list(Request $request)
    {
        $term = trim($request->q);

        $query_data = Unit::checkMultivendor()->get();

        $data = [];

        foreach ($query_data as $row) {
            $data[] = [
                'id' => $row->id,
                'name' => $row->name,
            ];
        }
        return response()->json($data);
    }

    public function index_data(Request $request)
    {
        $user=Auth::User();
        $usertype = $user->user_type;
        if($user->hasRole('pet_store')){
        $query = Unit::query();
        }else{
        $query = Unit::query()->checkMultivendor();
        }
        $filter = $request->filter;

        if (isset($filter)) {
            if (isset($filter['column_status'])) {
                $query->where('status', $filter['column_status']);
            }
            if (isset($filter['unit_rolewise'])) {
                if($filter['unit_rolewise'] === "my_unit"){
                    $query->where('created_by', $user->id);
                }elseif($filter['unit_rolewise'] === "added_by_vendor"){
                   
                    $query->where('created_by' , '!=' , $user->id);
                }else{
                    $query->whereHas('user', function ($q) {
                        $q->whereIn('user_type', ['admin', 'demo_admin']);
                    })
                    ->orWhereNull('created_by');
                }
                
            }
        }

        return Datatables::of($query)
                        ->addIndexColumn()
                        ->addColumn('check', function ($data) use ($user){
                            if($data->created_by === $user->id || $user->hasRole(['admin', 'demo_admin'])){
                            return '<input type="checkbox" class="form-check-input select-table-row"  id="datatable-row-'.$data->id.'"  name="datatable_ids[]" value="'.$data->id.'" onclick="dataTableRowCheck('.$data->id.')">';
                            }
                        })
                        ->addColumn('action', function ($data) use ($user){
                            return view('product::backend.units.action_column', compact('data','user'));
                        })
                        ->editColumn('status', function ($data) use ($user){
                            if($data->created_by === $user->id || $user->hasRole(['admin', 'demo_admin'])){
                          $checked = '';
                          if ($data->status) {
                              $checked = 'checked="checked"';
                          }
                          return '
                            <div class="form-check form-switch">
                                <input type="checkbox" data-url="'.route('backend.units.update_status', $data->id).'" data-token="'.csrf_token().'" class="switch-status-change form-check-input"  id="datatable-row-'.$data->id.'"  name="status" value="'.$data->id.'" '.$checked.'>
                            </div>
                          ';}
                        })
                        ->editColumn('vendor_name', function ($data) { 
                            return optional($data->user)->first_name.' '.optional($data->user)->last_name;
                        })
                        ->editColumn('updated_at', function ($data) {
                            $module_name = $this->module_name;

                            $diff = Carbon::now()->diffInHours($data->updated_at);

                            if ($diff < 25) {
                                return $data->updated_at->diffForHumans();
                            } else {
                                return $data->updated_at->isoFormat('llll');
                            }
                        })
                        ->rawColumns(['action', 'status', 'check'])
                        ->orderColumns(['id'], '-:column $1')
                        ->make(true);
    }

    public function update_status(Request $request, Unit $id)
    {
        $id->update(['status' => $request->status]);

        return response()->json(['status' => true, 'message' => "Status Updated"]);
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(UnitsRequest $request)
    {
        $data = Unit::create($request->all());

        $message = 'New Unit Added';

        return response()->json(['message' => $message, 'status' => true], 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        $data = Unit::findOrFail($id);

        return response()->json(['data' => $data, 'status' => true]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return Response
     */
    public function update(UnitsRequest $request, $id)
    {
        $data = Unit::findOrFail($id);

        $data->update($request->all());

        $message = 'Unit Updated Successfully';

        return response()->json(['message' => $message, 'status' => true], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        $data = Unit::findOrFail($id);

        $data->delete();

        $message = 'Unit Deleted Successfully';

        return response()->json(['message' => $message, 'status' => true], 200);
    }
}
