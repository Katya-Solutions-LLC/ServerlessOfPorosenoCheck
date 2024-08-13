<?php

namespace Modules\Logistic\Http\Controllers\Backend;

use App\Authorizable;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Modules\Logistic\Models\Logistic;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Modules\CustomField\Models\CustomField;
use Modules\CustomField\Models\CustomFieldGroup;
use Yajra\DataTables\DataTables;

class LogisticsController extends Controller
{
    // use Authorizable;

    public function __construct()
    {
        // Page Title
        $this->module_title = 'logistics.title';
        // module name
        $this->module_name = 'logistics';

        // module icon
        $this->module_icon = 'fa-solid fa-clipboard-list';

        view()->share([
            'module_title' => $this->module_title,
            'module_icon' => $this->module_icon,
            'module_name' => $this->module_name,
        ]);
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
        $columns = CustomFieldGroup::columnJsonValues(new Logistic());
        $customefield = CustomField::exportCustomFields(new Logistic());

        $export_import = true;
        $export_columns = [
            [
                'value' => 'name',
                'text' => ' Name',
            ]
        ];
        $export_url = route('backend.logistics.export');

        return view('logistic::backend.logistics.index_datatable', compact('module_action', 'filter', 'columns', 'customefield', 'export_import', 'export_columns', 'export_url'));
    }

    /**
     * Select Options for Select 2 Request/ Response.
     *
     * @return Response
     */
    public function index_list(Request $request)
    {
        $term = trim($request->q);

        $query_data = Logistic::get();

        $data = [];

        foreach ($query_data as $row) {
            $data[] = [
                'id' => $row->id,
                'name' => $row->name,
            ];
        }
        return response()->json($data);
    }

    public function index_data(Datatables $datatable, Request $request)
    {
        $query = Logistic::query();
        $filter = $request->filter;

        if (isset($filter)) {
            if (isset($filter['column_status'])) {
                $query->where('status', $filter['column_status']);
            }
        }
        $datatable = $datatable->eloquent($query)
                    ->addColumn('check', function ($row) {
                        return '<input type="checkbox" class="form-check-input select-table-row"  id="datatable-row-'.$row->id.'"  name="datatable_ids[]" value="'.$row->id.'" onclick="dataTableRowCheck('.$row->id.')">';
                    })
                    ->addColumn('action', function ($data) {
                        return view('logistic::backend.logistics.action_column', compact('data'));
                    })
                    ->addColumn('image', function ($data) {
                        return "<img src='".$data->feature_image."' class='avatar avatar-50 rounded-pill'>";
                    })
                    ->editColumn('status', function ($row) {
                    $checked = '';
                    if ($row->status) {
                        $checked = 'checked="checked"';
                    }
                    return '
                        <div class="form-check form-switch ">
                            <input type="checkbox" data-url="'.route('backend.logistics.update_status', $row->id).'" data-token="'.csrf_token().'" class="switch-status-change form-check-input"  id="datatable-row-'.$row->id.'"  name="status" value="'.$row->id.'" '.$checked.'>
                        </div>
                    ';
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
                    ->orderColumns(['id'], '-:column $1');

                    return $datatable->rawColumns(array_merge(['action', 'status', 'check', 'image']))
                        ->toJson();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(Request $request)
    {
        $data = $request->except('feature_image');
        $data = Logistic::create($data);


        if ($request->hasFile('feature_image')) {
          storeMediaFile($data, $request->file('feature_image'));
        }

        $message = 'New Logistic Added';

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
        $data = Logistic::findOrFail($id);

        return response()->json(['data' => $data, 'status' => true]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        $data = Logistic::findOrFail($id); 

        $data->update($request->all());

        $isWebRequest = $request->expectsJson();

        if($isWebRequest){
            if($request->feature_image == null) {
                $data->clearMediaCollection('feature_image');
            }
        }

        if ($request->hasFile('feature_image')) {
            storeMediaFile($data, $request->file('feature_image'));
        }

        $message = 'Logistics Updated Successfully';

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
        $data = Logistic::findOrFail($id);

        $data->delete();

        $message = 'Logistics Deleted Successfully';

        return response()->json(['message' => $message, 'status' => true], 200);
    }
    public function bulk_action(Request $request)
    {
        $ids = explode(',', $request->rowIds);

        $actionType = $request->action_type;

        $message = __('messages.bulk_update');

        switch ($actionType) {
            case 'change-status':
                $customer = Logistic::whereIn('id', $ids)->update(['status' => $request->status]);
                $message = __('messages.bulk_logistic_update');
                break;

            case 'delete':
                if (env('IS_DEMO')) {
                    return response()->json(['message' => __('messages.permission_denied'), 'status' => false], 200);
                }
                Logistic::whereIn('id', $ids)->delete();
                $message = __('messages.bulk_logistic_delete');
                break;

            default:
                return response()->json(['status' => false, 'message' => __('branch.invalid_action')]);
                break;
        }

        return response()->json(['status' => true, 'message' => __('messages.bulk_update')]);
    }

    public function update_status(Request $request, Logistic $id)
    {
        $id->update(['status' => $request->status]);

        return response()->json(['status' => true, 'message' => __('branch.status_update')]);
    }
}
