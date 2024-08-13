<?php

namespace Modules\Service\Http\Controllers\Backend;

use App\Authorizable;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Category\Models\Category;
use Modules\CustomField\Models\CustomField;
use Modules\CustomField\Models\CustomFieldGroup;
use Modules\Service\Http\Requests\ServicePackageRequest;
use Modules\Service\Models\PackageServiceMapping;
use Modules\Service\Models\ServicePackage;
use Yajra\DataTables\DataTables;

class ServicePackageController extends Controller
{
    use Authorizable;

    public function __construct()
    {
        // Page Title
        $this->module_title = 'service_package.title';

        // module name
        $this->module_name = 'servicepackage';

        // module icon
        $this->module_icon = 'fa-solid fa-building';

        view()->share([
            'module_title' => $this->module_title,
            'module_name' => $this->module_name,
            'module_icon' => $this->module_icon,
        ]);
    }

    /* list service package */
    public function index()
    {
        $module_action = 'List';

        $columns = CustomFieldGroup::columnJsonValues(new ServicePackage());

        return view('service::backend.servicepackages.index_datatable', compact('module_action', 'columns'));

    }

    public function bulk_action(Request $request)
    {
        $ids = explode(',', $request->rowIds);

        $actionType = $request->action_type;

        $message = __('messages.bulk_update');

        switch ($actionType) {
            case 'change-status':
                $services = ServicePackage::whereIn('id', $ids)->update(['status' => $request->status]);
                $message = __('messages.bulk_package_update');
                break;

            case 'delete':
                ServicePackage::whereIn('id', $ids)->delete();
                $message = __('messages.bulk_package_delete');
                break;

            default:
                return response()->json(['status' => false, 'message' => __('branch.invalid_action')]);
                break;
        }

        return response()->json(['status' => true, 'message' => __('messages.bulk_update')]);
    }

    public function category_list(Request $request)
    {
        $term = trim($request->q);

        $parentID = $request->parent_id;

        $query_data = Category::where(function ($q) use ($parentID) {
            if (! empty($term)) {
                $q->orWhere('name', 'LIKE', "%$term%");
            }
            if (isset($parentID) && $parentID != 0) {
                $q->where('parent_id', $parentID);
            } else {
                $q->whereNull('parent_id');
            }
        })->get();

        $data = [];

        foreach ($query_data as $row) {
            $data[] = [
                'id' => $row->id,
                'name' => $row->name,
            ];
        }

        return response()->json($data);
    }

     /**
      * Show the form for creating a new resource.
      *
      * @return \Illuminate\Http\Response
      */
     public function update_status(Request $request, ServicePackage $id)
     {
         $id->update(['status' => $request->status]);

         return response()->json(['status' => true, 'message' => __('branch.status_update')]);
     }

    public function index_data(DataTables $datatable, Request $request)
    {
        $module_name = $this->module_name;
        $query = ServicePackage::query()->with(['category', 'sub_category'])->orderBy('updated_at', 'desc');

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
            ->addColumn('action', function ($data) use ($module_name) {
                return view('service::backend.servicepackages.action_column', compact('module_name', 'data'));
            })
            ->filterColumn('category_id', function ($query, $keyword) {
                if (! empty($keyword)) {
                    $query->whereHas('Category', function ($q) use ($keyword) {
                        $q->where('name', 'like', '%'.$keyword.'%');
                    });
                }
            })
            ->filterColumn('sub_category_id', function ($query, $keyword) {
                if (! empty($keyword)) {
                    $query->whereHas('Category', function ($q) use ($keyword) {
                        $q->where('name', 'like', '%'.$keyword.'%');
                    });
                }
            })
            ->editColumn('status', function ($row) {
                $checked = '';
                if ($row->status) {
                    $checked = 'checked="checked"';
                }

                return '
                    <div class="form-check form-switch ">
                        <input type="checkbox" data-url="'.route('backend.service.update_status', $row->id).'" data-token="'.csrf_token().'" class="switch-status-change form-check-input"  id="datatable-row-'.$row->id.'"  name="status" value="'.$row->id.'" '.$checked.'>
                    </div>
                ';
            })
            ->editColumn('category_id', function ($data) {
                return isset($data->category->name) ? $data->category->name : '-';
            })
            ->editColumn('sub_category_id', function ($data) {
                return isset($data->sub_category->name) ? $data->sub_category->name : '-';
            })
            ->orderColumns(['id'], '-:column $1');

        // Custom Fields For export
        $customFieldColumns = CustomField::customFieldData($datatable, ServicePackage::CUSTOM_FIELD_MODEL, null);

        return $datatable->rawColumns(array_merge(['action', 'status', 'check'], $customFieldColumns))
            ->toJson();
    }

    /* create service package */
    public function store(ServicePackageRequest $request)
    {
        $data = $request->except('feature_image');
        //  $data['employee_id']=$request->employee_id;
        $query = ServicePackage::create($data);
        storeMediaFile($query, $request->file('feature_image'));
        $service = $request->service_id;
        if (is_array($service)) {
            $service = implode(',', $service);
        }
        foreach (explode(',', $service) as $key => $value) {
            $mapping_array = [
                'service_package_id' => $query->id,
                'service_id' => $value,
            ];
            $query->packageServices()->create($mapping_array);
        }
        $message = __('messages.create_form', ['form' => __('service_package.singular_title')]);

        return response()->json(['message' => $message, 'status' => true], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /* edit method */
    public function edit($id)
    {
        $data = ServicePackage::findOrFail($id);

        return response()->json(['data' => $data, 'status' => 'true']);
    }

   /* update method */
    public function update(ServicePackageRequest $request, $id)
    {
        $data = $request->except('feature_image');
        $data = ServicePackage::findOrFail($id);
        storeMediaFile($data, $request->file('feature_image'));
        $data->update([
            'name' => $request->name,
            'employee_id' => $request->employee_id,
            'price' => $request->price,
            'category_id' => $request->category_id,
            'start_at' => $request->start_at,
            'end_at' => $request->end_at,
            'status' => $request->status,
            'package_type' => $request->package_type,
            'description' => $request->description,
            'feature_image' => $request->feature_image,
        ]);

        $service = $request->service_id;
        if (is_array($service)) {
            $service = implode(',', $service);
        }
        PackageServiceMapping::where('service_package_id', $data->id)->delete();
        foreach (explode(',', $service) as $key => $value) {
            $mapping_array = [
                'service_package_id' => $data->id,
                'service_id' => $value,
            ];
            $data->packageServices()->create($mapping_array);
        }
        $message = __('messages.update_form', ['form' => __('service_package.singular_title')]);

        return response()->json(['message' => $message, 'status' => true, $service], 200);
    }

   /* delete function */
    public function destroy($id)
    {
        $data = ServicePackage::findOrFail($id);
        $data->delete();
        $message = __('messages.delete_form', ['form' => __('service_package.singular_title')]);

        return response()->json(['message' => $message, 'status' => true], 200);
    }
}
