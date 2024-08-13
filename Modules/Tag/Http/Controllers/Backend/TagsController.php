<?php

namespace Modules\Tag\Http\Controllers\Backend;

use App\Authorizable;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Modules\Tag\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Modules\CustomField\Models\CustomField;
use Modules\CustomField\Models\CustomFieldGroup;
use Yajra\DataTables\DataTables;
use Auth;

class TagsController extends Controller
{
    // use Authorizable;

    public function __construct()
    {
        // Page Title
        $this->module_title = 'tags.title';
        // module name
        $this->module_name = 'tags';

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
        $columns = CustomFieldGroup::columnJsonValues(new Tag());
        $customefield = CustomField::exportCustomFields(new Tag());

        $export_import = true;
        $export_columns = [
            [
                'value' => 'name',
                'text' => ' Name',
            ]
        ];
        $export_url = route('backend.tags.export');

        return view('tag::backend.tags.index_datatable', compact('module_action', 'filter', 'columns', 'customefield', 'export_import', 'export_columns', 'export_url'));
    }

    /**
     * Select Options for Select 2 Request/ Response.
     *
     * @return Response
     */
    public function index_list(Request $request)
    {
        $term = trim($request->q);

        $query_data = Tag::checkMultivendor()->get();

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
        $user=Auth::User();
        $usertype = $user->user_type;
        if($user->hasRole('pet_store')){
            $query = Tag::query();
        }else{
            $query = Tag::query()->checkMultivendor();
        }
        $filter = $request->filter;

        if (isset($filter)) {
            if (isset($filter['column_status'])) {
                $query->where('status', $filter['column_status']);
            }
            if (isset($filter['tag_rolewise'])) {
                if($filter['tag_rolewise'] === "my_tag"){
                    $query->where('created_by', $user->id);
                }elseif($filter['tag_rolewise'] === "added_by_vendor"){
                   
                    $query->where('created_by' , '!=' , $user->id);
                }else{
                    $query->whereHas('user', function ($q) {
                        $q->whereIn('user_type', ['admin', 'demo_admin']);
                    })
                    ->orWhereNull('created_by');
                }
                
            }
        }
        $datatable = $datatable->eloquent($query)
                        ->addColumn('check', function ($row) use ($user){
                            if($row->created_by === $user->id || $user->hasRole(['admin', 'demo_admin'])){
                            return '<input type="checkbox" class="form-check-input select-table-row"  id="datatable-row-'.$row->id.'"  name="datatable_ids[]" value="'.$row->id.'" onclick="dataTableRowCheck('.$row->id.')">';
                            }
                        })
                        ->addColumn('action', function ($data) use ($user){
                            return view('tag::backend.tags.action_column', compact('data','user'));
                        })
                        ->editColumn('status', function ($row) use ($user){
                            if($row->created_by === $user->id || $user->hasRole(['admin', 'demo_admin'])){
                          $checked = '';
                          if ($row->status) {
                              $checked = 'checked="checked"';
                          }
                          return '
                              <div class="form-check form-switch ">
                                  <input type="checkbox" data-url="'.route('backend.tags.update_status', $row->id).'" data-token="'.csrf_token().'" class="switch-status-change form-check-input"  id="datatable-row-'.$row->id.'"  name="status" value="'.$row->id.'" '.$checked.'>
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
                        ->orderColumns(['id'], '-:column $1');

                        return $datatable->rawColumns(array_merge(['action', 'status', 'check']))
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
        $data = Tag::create($request->all());

        $message = 'New Tag Added';

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
        $data = Tag::findOrFail($id);

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
        $data = Tag::findOrFail($id);

        $data->update($request->all());

        $message = 'Tags Updated Successfully';

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
        $data = Tag::findOrFail($id);

        $data->delete();

        $message = 'Tags Deleted Successfully';

        return response()->json(['message' => $message, 'status' => true], 200);
    }
    public function bulk_action(Request $request)
    {
        $ids = explode(',', $request->rowIds);

        $actionType = $request->action_type;

        $message = __('messages.bulk_update');

        switch ($actionType) {
            case 'change-status':
                $customer = Tag::whereIn('id', $ids)->update(['status' => $request->status]);
                $message = __('messages.bulk_tag_update');
                break;

            case 'delete':
                if (env('IS_DEMO')) {
                    return response()->json(['message' => __('messages.permission_denied'), 'status' => false], 200);
                }
                Tag::whereIn('id', $ids)->delete();
                $message = __('messages.bulk_tag_delete');
                break;

            default:
                return response()->json(['status' => false, 'message' => __('branch.invalid_action')]);
                break;
        }

        return response()->json(['status' => true, 'message' => __('messages.bulk_update')]);
    }

    public function update_status(Request $request, Tag $id)
    {
        $id->update(['status' => $request->status]);

        return response()->json(['status' => true, 'message' => __('branch.status_update')]);
    }
}
