<?php

namespace Modules\Pet\Http\Controllers\Backend;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Pet\Models\PetType;
use Illuminate\Support\Str;
use Yajra\DataTables\DataTables;
use Modules\Pet\Models\Breed;
use Carbon\Carbon;

class PettypeController extends Controller
{
    public function __construct()
    {
        // Page Title
        $this->module_title = 'menu.lbl_pettype';

        // module name
        $this->module_name = 'pettype';

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
        $create_title = 'pet.lbl_pettype';
        return view('pet::backend.pettype.index', compact('module_action', 'create_title'));
    }

    public function bulk_action(Request $request)
    {
        $ids = explode(',', $request->rowIds);

        $actionType = $request->action_type;

        $message = __('messages.bulk_update');

        switch ($actionType) {
            case 'change-status':
                $branches = PetType::whereIn('id', $ids)->update(['status' => $request->status]);
                $message = __('messages.bulk_pettype_update');
                break;

            case 'delete':
                PetType::whereIn('id', $ids)->delete();
                $message = __('messages.bulk_pettype_delete');
                break;

            default:
                return response()->json(['status' => false, 'message' => __('branch.invalid_action')]);
                break;
        }

        return response()->json(['status' => true, 'message' => __('messages.bulk_update')]);
    }

    public function index_list(Request $request)
    {
        $term = trim($request->q);

        $query_data = PetType::where('status', 1)
            ->where(function ($q) {
                if (! empty($term)) {
                    $q->orWhere('name', 'LIKE', "%$term%");
                }
            })->get();

        $data = [];

        foreach ($query_data as $row) {
            $data[] = [
                'id' => $row->id,
                'name' => $row->name,
                'limit' => $row->limit,
            ];
        }
        return response()->json($data);
    }

    public function index_data(Datatables $datatable, Request $request)
    {
        $query = PetType::query();


        return Datatables::of($query)
                        ->addColumn('check', function ($row) {
                            return '<input type="checkbox" class="form-check-input select-table-row"  id="datatable-row-'.$row->id.'"  name="datatable_ids[]" value="'.$row->id.'" onclick="dataTableRowCheck('.$row->id.')">';
                        })
                        ->addColumn('action', function ($data) {
                            return view('pet::backend.pettype.action_column', compact('data'));
                        })
                        ->editColumn('image', function ($data) {
                            return "<img src='" . $data->pettype_image . "'class='avatar avatar-40 img-fluid rounded-pill'>";
                        })
                        ->editColumn('pet_breed', function ($data) {

                            $pet_count=Breed::where('pettype_id',$data->id)->count();

                            return "<b><a href='".route('backend.pet.breed.index', ['pettype_id' => $data->id])."'>$pet_count</a></b>";

                            // return "<b><button type='button' data-assign-module='".$data->id."' data-assign-target='#pet-assign-form' data-assign-event='assign_pet' class='btn  btn-sm rounded text-nowrap breed_list' >$pet_count</button></b><button type='button' data-assign-module='".$data->id."' data-assign-event='add_breed' class='btn btn-primary btn-sm rounded text-nowrap' data-bs-toggle='tooltip' title='Create New breed'><a href='".route('backend.pet.breed.index', ['pettype_id' => $data->id])."'><i class='fa-solid fa-plus p-0 new_breed'></i></a></button>";

                         })
                        ->editColumn('status', function ($row) {
                            $checked = '';
                            if ($row->status) {
                                $checked = 'checked="checked"';
                            }
            
                            return '
                            <div class="form-check form-switch ">
                                <input type="checkbox" data-url="'.route('backend.pet.pettype.update_status', $row->id).'" data-token="'.csrf_token().'" class="switch-status-change form-check-input"  id="datatable-row-'.$row->id.'"  name="status" value="'.$row->id.'" '.$checked.'>
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
                        ->rawColumns(['action', 'status', 'check','pet_breed','image'])
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
        $data = $request->except('pettype_image');
        $query = PetType::create($data);

        storeMediaFile($query, $request->file('pettype_image'), 'pettype_image');
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
        $data = PetType::findOrFail($id);

        $data['pettype_image'] = $data->pettype_image;
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
        $query = PetType::findOrFail($id);

        $data = $request->except('pettype_image');
        $query->update($data);

        storeMediaFile($query, $request->file('pettype_image'), 'pettype_image');
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
        $data = PetType::findOrFail($id);

        $data->delete();

        $message = __('messages.delete_form', ['form' => __($this->module_title)]);

        return response()->json(['message' => $message, 'status' => true], 200);
    }
    public function trashed()
    {
        $module_name_singular = Str::singular($this->module_name);

        $module_action = 'Trash List';

        $data = PetType::with('user')->onlyTrashed()->orderBy('deleted_at', 'desc')->paginate();

        return view('pet::backend.pettype.trash', compact('data', 'module_name_singular', 'module_action'));
    }
    public function restore($id)
    {
        $data = PetType::withTrashed()->find($id);
        $data->restore();

        $message = Str::singular($this->module_title).' Data Restoreded Successfully';

        return redirect('app/pet/pettype');
    }

    public function update_status(Request $request, PetType $id)
    {
        $id->update(['status' => $request->status]);

        return response()->json(['status' => true, 'message' => __('branch.status_update')]);
    }
}
