<?php

namespace Modules\CustomField\Http\Controllers\Backend;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\CustomField\Http\Requests\CustomFieldRequest;
use Modules\CustomField\Models\CustomField;
use Modules\CustomField\Models\CustomFieldGroup;

class CustomFieldController extends Controller
{
    public function __construct()
    {
        // Page Title
        $this->module_title = 'CustomField';

        // module name
        $this->module_name = 'dustomfield';

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
     * @return Renderable
     */
    public function index()
    {
        return view('customfield::index');
    }

    public function index_list()
    {
        $data = CustomField::with('custom_fields_group')->get();

        return response()->json(['data' => $data, 'status' => true, 'message' => __('messages.customer_field_list')]);
    }

    public function index_data(Request $request)
    {
        $term = trim($request->q);

        $query_data = CustomFieldGroup::where(function ($q) {
            if (! empty($term)) {
                $q->orWhere('name', 'LIKE', "%$term%");
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
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Renderable
     */
    public function store(CustomFieldRequest $request)
    {
        $data = $request->all();

        $module_value = json_decode($data['inputFields']);

        $value_data = $module_value->_value;

        $values = [];

        foreach ($value_data as $item) {

            $values_data = $item->value;

            $values[] = $values_data;
        }

        $data['name'] = CustomField::generateUniqueSlug($data['label'], $data['Module']);

        $data['values'] = implode(',', $values);

        $data['custom_field_group_id'] = $data['Module'];
        $data['required'] = ($data['required'] === 'undefined') ? 0 : $data['required'];
        $data['is_export'] = ($data['is_export'] === 'undefined') ? 0 : $data['is_export'];
        $data['is_view'] = ($data['is_view'] === 'undefined') ? 0 : $data['is_view'];

        CustomField::create($data);

        $message = __('messages.customfield_created');

        return response()->json(['message' => $message, 'status' => true], 200);

    }

    /**
     * Show the specified resource.
     *
     * @param  int  $id
     * @return Renderable
     */
    public function show($id)
    {
        return view('customfield::show');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        $data = CustomField::findOrFail($id);

        $inputFields = [];
        if ($data['values'] != '') {

            $values = explode(',', $data['values']);

            foreach ($values as $key => $value) {
                $inputFields[$key] = $value;
            }

        }

        $data['inputFields'] = $inputFields;

        return response()->json(['data' => $data, 'status' => true]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return Response
     */
    public function update(CustomFieldRequest $request, $id)
    {
        $custome_field = CustomField::findOrFail($id);

        $data = $request->all();

        $data['values'] = json_decode($data['inputFields'], true);

        $custome_field->update($request->all());

        $message = __('messages.customfield_updated');

        return response()->json(['message' => $message, 'status' => true], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Renderable
     */
    public function destroy($id)
    {
        $data = CustomField::findOrFail($id);

        $data->delete();

        $message = __('messages.customfield_deleted');

        return response()->json(['message' => $message, 'status' => true], 200);
    }
}
