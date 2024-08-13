<?php

namespace Modules\Pet\Http\Controllers\Backend;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Pet\Models\Breed;
use Illuminate\Support\Str;
use Yajra\DataTables\DataTables;
use Carbon\Carbon;

class BreedController extends Controller
{
    public function __construct()
    {
        // Page Title
        $this->module_title = 'menu.lbl_breed';

        // module name
        $this->module_name = 'breed';

        // directory path of the module
        // $this->module_path = 'pet::backend';

        view()->share([
          'module_title' => $this->module_title,
          'module_icon' => 'fa-regular fa-sun',
          'module_name' => $this->module_name,
        //   'module_path' => $this->module_path,
      ]);
    }
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $module_action = 'List';
        $create_title = 'pet.lbl_breed';

        $type =request()->pettype_id;

        return view('pet::backend.breed.index', compact('module_action','type','create_title'));
    }

    public function bulk_action(Request $request)
    {
        $ids = explode(',', $request->rowIds);

        $actionType = $request->action_type;

        $message = __('messages.bulk_update');

        switch ($actionType) {
            case 'change-status':
                $branches = Breed::whereIn('id', $ids)->update(['status' => $request->status]);
                $message = __('messages.bulk_breed_update');
                break;

            case 'delete':
                Breed::whereIn('id', $ids)->delete();
                $message = __('messages.bulk_breed_delete');
                break;

            default:
                return response()->json(['status' => false, 'message' => __('branch.invalid_action')]);
                break;
        }

        return response()->json(['status' => true, 'message' => __('messages.bulk_update')]);
    }

    public function index_list(Request $request)
    {
        $pettype_id = $request->pettype_id;

        $data = Breed::with('pettype');

        if(isset($pettype_id)) {

            if($pettype_id==0){

                $data=$data;

             }else{

                $data->where('pettype_id', $pettype_id);

             }


        }

        $data = $data->get();

        return response()->json($data);
    }

    public function index_data(Request $request)
    {

        if(!empty($request->type)){

            $query = Breed::where('pettype_id',$request->type);
           
          }else{
            $query = Breed::query();
        }

        return Datatables::of($query)
                        ->addColumn('check', function ($row) {
                            return '<input type="checkbox" class="form-check-input select-table-row"  id="datatable-row-'.$row->id.'"  name="datatable_ids[]" value="'.$row->id.'" onclick="dataTableRowCheck('.$row->id.')">';
                        })
                        ->addColumn('action', function ($data) {
                            return view('pet::backend.breed.action_column', compact('data'));
                        })

                      
                        ->editColumn('pettype_id', function ($data) {
                            $image = "<img src='" . optional($data->pettype)->pettype_image . "' class='avatar avatar-40 img-fluid rounded-pill'>";
                             $pettype = optional($data->pettype)->name ?? '-';
    
                             return "<div>" . $image  . "   " . $pettype . "</div>";
                        })
                        ->editColumn('description', function ($data) {
                            return $data->description ?? '-'; 
                        })
                        
                        ->editColumn('status', function ($row) {
                            $checked = '';
                            if ($row->status) {
                                $checked = 'checked="checked"';
                            }
            
                            return '
                            <div class="form-check form-switch ">
                                <input type="checkbox" data-url="'.route('backend.pet.breed.update_status', $row->id).'" data-token="'.csrf_token().'" class="switch-status-change form-check-input"  id="datatable-row-'.$row->id.'"  name="status" value="'.$row->id.'" '.$checked.'>
                            </div>
                           ';
                        })
                        ->editColumn('updated_at', function ($data) {
                            $module_name = $this->module_name;

                            $diff = Carbon::now()->diffInHours($data->updated_at);

                            if ($diff < 25) {
                                return isset($data->updated_at) ? $data->updated_at->diffForHumans() : '-';
                            } else {
                                return $data->updated_at->isoFormat('llll');
                            }
                        })
                        ->rawColumns(['action','pettype_id', 'status', 'check'])
                        ->orderColumns(['id'], '-:column $1')
                        ->make(true);
    }


    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('pet::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        $data = Breed::create($request->all());

        $message = __('messages.create_form', ['form' => __($this->module_title)]);

        return response()->json(['message' => $message, 'status' => true], 200);
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        return view('pet::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        $data = Breed::findOrFail($id);

        return response()->json(['data' => $data, 'status' => true]);
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $id)
    {
        $data = Breed::findOrFail($id);

        $data->update($request->all());

        $message = __('messages.update_form', ['form' => __($this->module_title)]);

        return response()->json(['message' => $message, 'status' => true], 200);
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        $data = Breed::findOrFail($id);

        $data->delete();

        $message = __('messages.delete_form', ['form' => __($this->module_title)]);

        return response()->json(['message' => $message, 'status' => true], 200);
    }

    public function trashed()
    {
        $module_name_singular = Str::singular($this->module_name);

        $module_action = 'Trash List';

        $data = Breed::with('user')->onlyTrashed()->orderBy('deleted_at', 'desc')->paginate();

        return view('pet::backend.breed.trash', compact('data', 'module_name_singular', 'module_action'));
    }
    public function restore($id)
    {
        $data = Breed::withTrashed()->find($id);
        $data->restore();

        $message = Str::singular($this->module_title).' Data Restoreded Successfully';

        return redirect('app/pets');
    }
    public function update_status(Request $request, Breed $id)
    {
        $id->update(['status' => $request->status]);

        return response()->json(['status' => true, 'message' => __('branch.status_update')]);
    }
}