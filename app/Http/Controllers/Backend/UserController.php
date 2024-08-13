<?php

namespace App\Http\Controllers\Backend;

use App\Authorizable;
use App\Events\Backend\UserCreated;
use App\Events\Backend\UserUpdated;
use App\Http\Controllers\Controller;
use App\Models\Branch;
use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use App\Models\UserProvider;
use App\Notifications\UserAccountCreated;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Laracasts\Flash\Flash;
use Yajra\DataTables\DataTables;
use App\DataTables\UserDataTable;
use Modules\Service\Models\ServiceEmployee;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Artisan;
use Modules\Commission\Models\Commission;
use Modules\Commission\Models\EmployeeCommission;

class UserController extends Controller
{
    // use Authorizable;

    public function __construct()
    {
        // Page Title
        $this->module_title = 'profile.title';

        // module name
        $this->module_name = 'users';

        // directory path of the module
        $this->module_path = 'users';

        // module icon
        $this->module_icon = 'fa-solid fa-users';

        // module model name, path
        $this->module_model = "App\Models\User";

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
    public function index(UserDataTable $dataTable)
    {

      return $dataTable->render('global.datatable');
        $module_title = $this->module_title;
        if (isset($roleBaseList) && $roleBaseList !== 'all') {
            $role = Role::where('name', $roleBaseList)->first();
            if (isset($role)) {
                $module_title = $role->name;
            }
        }
        $module_name = $this->module_name;
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_model = $this->module_model;
        $module_name_singular = Str::singular($module_name);

        $module_action = 'List';

        $page_heading = ucfirst($module_title);
        $title = $page_heading.' '.ucfirst($module_action);

        $$module_name = $module_model::paginate();

        return view(
            "backend.$module_path.index_datatable",
            compact('module_title', 'module_name', 'module_path', 'module_icon', 'module_action', 'module_name_singular', 'page_heading', 'title', 'roleBaseList')
        );
    }

    public function index_data($roleBaseList = null)
    {
        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_model = $this->module_model;
        $module_name_singular = Str::singular($module_name);

        $module_action = 'List';

        $$module_name = $module_model::query();
        if (isset($roleBaseList) && $roleBaseList !== 'all') {
            $role = Role::where('name', $roleBaseList)->first();
            if (isset($role)) {
                $$module_name->role($roleBaseList);
            }
        }

        return Datatables::of($$module_name)
            ->addColumn('action', function ($data) {
                $module_name = $this->module_name;

                return view('backend.includes.user_actions', compact('module_name', 'data'));
            })
            ->addColumn('user_roles', function ($data) {
                $module_name = $this->module_name;

                return view('backend.includes.user_roles', compact('module_name', 'data'));
            })

            ->editColumn('status', function ($data) {
                $return_data = $data->status_label;
                $return_data .= '<br>'.$data->confirmed_label;

                return $return_data;
            })
            ->editColumn('updated_at', function ($data) {
                $module_name = $this->module_name;

                $diff = Carbon::now()->diffInHours($data->updated_at);

                if ($diff < 25) {
                    return $data->updated_at->diffForHumans();
                } else {
                    return $data->updated_at->isoFormat('LLLL');
                }
            })
            ->rawColumns(['name', 'action', 'status', 'user_roles'])
            ->orderColumns(['id'], '-:column $1')
            ->make(true);
    }

    /**
     * Select Options for Select 2 Request/ Response.
     *
     * @return Response
     */
    public function index_list(Request $request)
    {
        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_model = $this->module_model;
        $module_name_singular = Str::singular($module_name);

        $module_action = 'List';

        $page_heading = label_case($module_title);
        $title = $page_heading.' '.label_case($module_action);

        $term = trim($request->q);

        if (empty($term)) {
            return response()->json([]);
        }

        $query_data = $module_model::where('name', 'LIKE', "%$term%")->orWhere('email', 'LIKE', "%$term%")->limit(10)->get();

        $$module_name = [];

        foreach ($query_data as $row) {
            $$module_name[] = [
                'id' => $row->id,
                'text' => $row->name.' (Email: '.$row->email.')',
            ];
        }

        return response()->json($$module_name);
    }

    public function owner_list(Request $request)
    {
        $term = trim($request->q);

        $query_data = User::where('status', 1)
            ->where('user_type', 'user')
            ->where(function ($q) {
                if (! empty($term)) {
                    $q->orWhere('first_name', 'LIKE', "%$term%");
                }
            })->get();

        $data = [];

        foreach ($query_data as $row) {
            $data[] = [
                'id' => $row->id,
                'first_name' => $row->first_name.' '.$row->last_name,
            ];
        }
        return response()->json($data);
    }

    public function organizer_list(Request $request)
    {
        $term = trim($request->q);

        $query_data = User::where('status', 1)
            ->whereNotIn('user_type', ['user'])
            ->where(function ($q) {
                if (! empty($term)) {
                    $q->orWhere('first_name', 'LIKE', "%$term%");
                }
            })->get();

        $data = [];

        foreach ($query_data as $row) {
            $userType = str_replace('day_taker', 'dayCare_taker', $row->user_type);

            $data[] = [
                'id' => $row->id,
                'first_name' => $row->first_name.' '.$row->last_name.' ('.ucwords(str_replace('_',' ',$userType)).')',
            ];
        }
        return response()->json($data);
    }

    

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_model = $this->module_model;
        $module_name_singular = Str::singular($module_name);

        $module_action = 'Create';

        $roles = Role::get();
        $permissions = Permission::select('name', 'id')->get();

        return view(
            "backend.$module_name.create",
            compact('module_title', 'module_name', 'module_path', 'module_icon', 'module_action', 'module_name_singular', 'roles', 'permissions')
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_model = $this->module_model;
        $module_name_singular = Str::singular($module_name);

        $module_action = 'Details';

        $request->validate([
            'first_name' => 'required|min:3|max:191',
            'last_name' => 'required|min:3|max:191',
            'email' => 'required|email|regex:/(.+)@(.+)\.(.+)/i|max:191|unique:users',
            'password' => 'required|confirmed|min:4',
        ]);

        $data_array = $request->except('_token', 'roles', 'permissions', 'password_confirmation');
        $data_array['name'] = $request->first_name.' '.$request->last_name;
        $data_array['password'] = Hash::make($request->password);

        if ($request->confirmed == 1) {
            $data_array = Arr::add($data_array, 'email_verified_at', Carbon::now());
        } else {
            $data_array = Arr::add($data_array, 'email_verified_at', null);
        }

        $$module_name_singular = User::create($data_array);

        $roles = $request['roles'];
        $permissions = $request['permissions'];

        // Sync Roles
        if (isset($roles)) {
            $$module_name_singular->syncRoles($roles);
        } else {
            $roles = [];
            $$module_name_singular->syncRoles($roles);
        }

        // Sync Permissions
        if (isset($permissions)) {
            $$module_name_singular->syncPermissions($permissions);
        } else {
            $permissions = [];
            $$module_name_singular->syncPermissions($permissions);
        }

        // Username
        $id = $$module_name_singular->id;
        $$module_name_singular->username = $username;
        $$module_name_singular->save();

        event(new UserCreated($$module_name_singular));

        Flash::success("<i class='fas fa-check'></i> New '".Str::singular($module_title)."' Created")->important();

        if ($request->email_credentials == 1) {
            $data = [
                'password' => $request->password,
            ];
            try {
                $$module_name_singular->notify(new UserAccountCreated($data));
            } catch (\Exception $e) {
                \Log::error($e->getMessage());
            }

            Flash::success(icon('fas fa-envelope').' Account Credentials Sent to User.')->important();
        }

        return redirect("app/$module_name");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_model = $this->module_model;
        $module_name_singular = Str::singular($module_name);

        $module_action = 'Show';

        $$module_name_singular = $module_model::findOrFail($id);

        return view(
            "backend.$module_name.show",
            compact('module_title', 'module_name', 'module_path', 'module_icon', 'module_action', 'module_name_singular', "$module_name_singular")
        );
    }

    /**
     * Display Profile Details of Logged in user.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function profile(Request $request, $id)
    {
        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_model = $this->module_model;
        $module_name_singular = Str::singular($module_name);
        $module_action = 'Profile Show';

        $$module_name_singular = $module_model::with('roles', 'permissions')->findOrFail($id);

        return view("backend.$module_name.profile", compact('module_name', 'module_name_singular', "$module_name_singular", 'module_icon', 'module_action', 'module_title'));
    }

    /**
     * Show the form for Profile Paeg Editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function profileEdit($id)
    {
        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_model = $this->module_model;
        $module_name_singular = Str::singular($module_name);

        $module_action = 'Edit Profile';

        if (! auth()->user()->can('edit_users')) {
            $id = auth()->user()->id;
        }

        $$module_name_singular = $module_model::findOrFail($id);

        return view(
            "backend.$module_name.profileEdit",
            compact('module_title', 'module_name', 'module_path', 'module_icon', 'module_action', 'module_name_singular', "$module_name_singular")
        );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function profileUpdate(Request $request, $id)
    {
        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_model = $this->module_model;
        $module_name_singular = Str::singular($module_name);

        $module_action = 'Edit Profile';

        $this->validate($request, [
            'avatar' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'first_name' => 'required|min:3|max:191',
            'last_name' => 'required|min:3|max:191',
            'email' => 'email',
        ]);

        if (! auth()->user()->can('edit_users')) {
            $id = auth()->user()->id;
        }

        $$module_name_singular = User::findOrFail($id);

        // Handle Avatar upload
        if ($request->hasFile('avatar')) {
            if ($$module_name_singular->getMedia($module_name)->first()) {
                $$module_name_singular->getMedia($module_name)->first()->delete();
            }

            $media = $$module_name_singular->addMedia($request->file('avatar'))->toMediaCollection($module_name);

            $$module_name_singular->avatar = $media->getUrl();

            $$module_name_singular->save();
        }

        $data_array = $request->except('avatar');
        $data_array['avatar'] = $$module_name_singular->avatar;
        $data_array['name'] = $request->first_name.' '.$request->last_name;

        $user_profile->update($data_array);

        Flash::success('<i class="fas fa-check"></i> '.label_case($module_name_singular).' Updated Successfully!')->important();

        return redirect(route('backend.users.profile', $$module_name_singular->id));
    }

    /**
     * Show the form for Profile Paeg Editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function changeProfilePassword($id)
    {
        if (! auth()->user()->can('edit_users')) {
            $id = auth()->user()->id;
        }

        $title = $this->module_title;
        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_name_singular = Str::singular($this->module_name);
        $module_icon = $this->module_icon;
        $module_action = 'Edit';

        $$module_name_singular = User::findOrFail($id);

        return view("backend.$module_name.changeProfilePassword", compact('module_name', 'module_title', "$module_name_singular", 'module_icon', 'module_action'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function changeProfilePasswordUpdate(Request $request, $id)
    {
        $this->validate($request, [
            'password' => 'required|confirmed|min:6',
        ]);

        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_model = $this->module_model;
        $module_name_singular = Str::singular($module_name);

        if (! auth()->user()->can('edit_users')) {
            $id = auth()->user()->id;
        }

        $$module_name_singular = User::findOrFail($id);

        $request_data = $request->only('password');
        $request_data['password'] = Hash::make($request_data['password']);

        $$module_name_singular->update($request_data);

        Flash::success(icon()." '".Str::singular($module_title)."' Updated Successfully")->important();

        return redirect("app/$module_name/profile/$id");
    }

    /**
     * Show the form for Profile Paeg Editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function changePassword($id)
    {
        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_model = $this->module_model;
        $module_name_singular = Str::singular($module_name);

        $module_action = 'Change Password';

        $page_heading = label_case($module_title);
        $title = $page_heading.' '.label_case($module_action);

        if (! auth()->user()->can('edit_users')) {
            $id = auth()->user()->id;
        }

        $$module_name_singular = $module_model::findOrFail($id);

        return view(
            "backend.$module_name.changePassword",
            compact('module_title', 'module_name', 'module_path', 'module_icon', 'module_action', 'module_name_singular', "$module_name_singular")
        );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function changePasswordUpdate(Request $request, $id)
    {
        $this->validate($request, [
            'password' => 'required|confirmed|min:6',
        ]);

        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_model = $this->module_model;
        $module_name_singular = Str::singular($module_name);

        if (! auth()->user()->can('edit_users')) {
            $id = auth()->user()->id;
        }

        $$module_name_singular = User::findOrFail($id);

        $request_data = $request->only('password');
        $request_data['password'] = Hash::make($request_data['password']);

        $$module_name_singular->update($request_data);

        Flash::success("<i class='fas fa-check'></i> '".Str::singular($module_title)."' Updated Successfully")->important();

        return redirect("app/$module_name");
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        if (! auth()->user()->can('edit_users')) {
            abort(404);
        }

        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_model = $this->module_model;
        $module_name_singular = Str::singular($module_name);

        $module_action = 'Edit';

        $$module_name_singular = $module_model::findOrFail($id);

        $userRoles = $$module_name_singular->roles->pluck('name')->all();
        $userPermissions = $$module_name_singular->permissions->pluck('name')->all();

        $roles = Role::get();
        $permissions = Permission::select('name', 'id')->get();

        $branch = Branch::get(['name', 'id']);

        return view(
            "backend.$module_name.edit",
            compact('module_title', 'module_name', 'module_path', 'module_icon', 'module_action', 'module_name_singular', "$module_name_singular", 'roles', 'permissions', 'userRoles', 'userPermissions', 'branch')
        );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if (! auth()->user()->can('edit_users')) {
            abort(404);
        }

        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_model = $this->module_model;
        $module_name_singular = Str::singular($module_name);

        $module_action = 'Update';

        // $request->validate([
        //     'first_name'    => 'required|min:3|max:191',
        //     'last_name'     => 'required|min:3|max:191',
        //     'url_website'   => 'nullable|min:3|max:191',
        //     'url_facebook'  => 'nullable|min:3|max:191',
        //     'url_twitter'   => 'nullable|min:3|max:191',
        //     'url_instagram' => 'nullable|min:3|max:191',
        //     'url_linkedin'  => 'nullable|min:3|max:191',
        // ]);

        $$module_name_singular = User::findOrFail($id);

        $$module_name_singular->update($request->except(['roles', 'permissions']));

        if ($id == 1) {
            $user->syncRoles(['admin']);

            return redirect("app/$module_name")->with('flash_success', 'Update successful!');
        }

        $roles = $request['roles'];
        $permissions = $request['permissions'];

        // Sync Roles
        if (isset($roles)) {
            $$module_name_singular->syncRoles($roles);
        } else {
            $roles = [];
            $$module_name_singular->syncRoles($roles);
        }

        // Sync Permissions
        if (isset($permissions)) {
            $$module_name_singular->syncPermissions($permissions);
        } else {
            $permissions = [];
            $$module_name_singular->syncPermissions($permissions);
        }

        event(new UserUpdated($$module_name_singular));

        Flash::success("<i class='fas fa-check'></i> '".Str::singular($module_title)."' Updated Successfully")->important();

        return redirect("app/$module_name");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_model = $this->module_model;
        $module_name_singular = Str::singular($module_name);

        $module_action = 'destroy';

        if (auth()->user()->id == $id || $id == 1) {
            Flash::warning("<i class='fas fa-exclamation-triangle'></i> You can not delete this user!")->important();


            return redirect()->back();
        }

        $$module_name_singular = $module_model::findOrFail($id);

        $$module_name_singular->delete();

        event(new UserUpdated($$module_name_singular));

        flash('<i class="fas fa-check"></i> '.$$module_name_singular->name.' User Successfully Deleted!')->success();

        return redirect("app/$module_name");
    }

    /**
     * List of trashed ertries
     * works if the softdelete is enabled.
     *
     * @return Response
     */
    public function trashed()
    {
        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_model = $this->module_model;
        $module_name_singular = Str::singular($module_name);

        $module_action = 'Deleted List';
        $page_heading = $module_title;

        $$module_name = $module_model::onlyTrashed()->orderBy('deleted_at', 'desc')->paginate();

        return view(
            "backend.$module_name.trash",
            compact('module_name', 'module_title', "$module_name", 'module_icon', 'page_heading', 'module_action')
        );
    }

    /**
     * Restore a soft deleted entry.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return Response
     */
    public function restore($id)
    {
        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_model = $this->module_model;
        $module_name_singular = Str::singular($module_name);

        $module_action = 'Restore';

        $$module_name_singular = $module_model::withTrashed()->find($id);
        $$module_name_singular->restore();

        event(new UserUpdated($$module_name_singular));

        flash('<i class="fas fa-check"></i> '.$$module_name_singular->name.' Successfully Restoreded!')->success();

        return redirect("app/$module_name");
    }

    /**
     * Block Any Specific User.
     *
     * @param  int  $id  User Id
     * @return Back To Previous Page
     */
    public function block($id)
    {
        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_model = $this->module_model;
        $module_name_singular = Str::singular($module_name);

        $module_action = 'Block';

        if (auth()->user()->id == $id || $id == 1) {
            Flash::warning("<i class='fas fa-exclamation-triangle'></i> You can not 'Block' this user!")->important();


            return redirect()->back();
        }

        $$module_name_singular = User::withTrashed()->find($id);
        // $$module_name_singular = $this->findOrThrowException($id);

        try {
            $$module_name_singular->status = 2;
            $$module_name_singular->save();

            event(new UserUpdated($$module_name_singular));

            flash('<i class="fas fa-check"></i> '.$$module_name_singular->name.' User Successfully Blocked!')->success();

            return redirect()->back();
        } catch (Exception $e) {
            throw new Exception('There was a problem updating this user. Please try again.');
        }
    }

    /**
     * Unblock Any Specific User.
     *
     * @param  int  $id  User Id
     * @return Back To Previous Page
     */
    public function unblock($id)
    {
        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_model = $this->module_model;
        $module_name_singular = Str::singular($module_name);

        $module_action = 'Unblock';

        if (auth()->user()->id == $id || $id == 1) {
            Flash::warning("<i class='fas fa-exclamation-triangle'></i> You can not 'Unblock' this user!")->important();


            return redirect()->back();
        }

        $$module_name_singular = User::withTrashed()->find($id);

        try {
            $$module_name_singular->status = 1;
            $$module_name_singular->save();

            event(new UserUpdated($$module_name_singular));

            flash('<i class="fas fa-check"></i> '.$$module_name_singular->name.' User Successfully Unblocked!')->success();


            return redirect()->back();
        } catch (Exception $e) {
            Log::error($th);
            flash('<i class="fas fa-check"></i> There was a problem updating this user. Please try again.!')->error();
        }
    }

    /**
     * Remove the Social Account attached with a User.
     *
     *
     * @return \Illuminate\Http\Response
     */
    public function userProviderDestroy(Request $request)
    {
        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_model = $this->module_model;
        $module_name_singular = Str::singular($module_name);

        $user_provider_id = $request->user_provider_id;
        $user_id = $request->user_id;

        if (! $user_provider_id > 0 || ! $user_id > 0) {
            flash('Invalid Request. Please try again.')->error();

            return redirect()->back();
        } else {
            $user_provider = UserProvider::findOrFail($user_provider_id);

            if ($user_id == $user_provider->user->id) {
                $user_provider->delete();

                flash('<i class="fas fa-exclamation-triangle"></i> Unlinked from User, "'.$user_provider->user->name.'"!')->success();

                return redirect()->back();
            } else {
                flash('<i class="fas fa-exclamation-triangle"></i> Request rejected. Please contact the Administrator!')->warning();
            }
        }

        event(new UserUpdated($$module_name_singular));

        throw new Exception('There was a problem updating this user. Please try again.');
    }

    /**
     * Resend Email Confirmation Code to User.
     *
     * @param [type] $hashid [description]
     * @return [type] [description]
     */
    public function emailConfirmationResend($id)
    {
        if ($id != auth()->user()->id) {
            if (auth()->user()->hasAnyRole(['admin'])) {
                // Log::info(auth()->user()->name.' ('.auth()->user()->id.') - User Requested for Email Verification.');
            } else {
                // Log::warning(auth()->user()->name.' ('.auth()->user()->id.') - User trying to confirm another users email.');

                abort('404');
            }
        }

        $user = User::where('id', '=', $id)->first();

        if ($user) {
            if ($user->email_verified_at == null) {
                // Send Email To Registered User
                $user->sendEmailVerificationNotification();

                flash('<i class="fas fa-check"></i> Email Sent! Please Check Your Inbox.')->success()->important();

                return redirect()->back();
            } else {
                flash($user->name.', You already confirmed your email address at '.$user->email_verified_at->isoFormat('LL'))->success()->important();

                return redirect()->back();
            }
        }
    }

    public function user_list(Request $request)
    {
        $term = trim($request->q);
        $role = $request->role;

        if($role == 'user'){
            $queryBuilder = User::query();
        }
        else{
            $queryBuilder = User::query()->whereNotNull('email_verified_at');
        }
        

        if ($role == 'user') {
            $queryBuilder->role(['user'])->active();
        } elseif ($role == 'trainer') {
            $queryBuilder->role(['trainer'])->active();
        } elseif ($role == 'vet') {
            $queryBuilder->role(['vet'])->active();
        } elseif ($role == 'groomer') {
            $queryBuilder->role(['groomer'])->active();
        } elseif ($role == 'walker') {
            $queryBuilder->role(['walker'])->active();
        } elseif ($role == 'boarder') {
            $queryBuilder->role(['boarder'])->active();
        } elseif ($role == 'day_taker') {
            $queryBuilder->role(['day_taker'])->active();
        } elseif ($role == 'pet_sitter') {
            $queryBuilder->role(['pet_sitter'])->active();
        }


        if(isset($request->service_id)){
            
           $employee_ids=ServiceEmployee::where('service_id',$request->service_id)->pluck('employee_id');

           $queryBuilder->whereIn('id', $employee_ids);

        }

        $query_data = $queryBuilder->where(function ($q) use ($term) {
            if (!empty($term)) {
                $q->orWhere('first_name', 'LIKE', "%$term%")
                    ->orWhere('last_name', 'LIKE', "%$term%");
            }
        })->with('media')->get();

        

        $data = [];

        foreach ($query_data as $row) {
            $data[] = [
                'id' => $row->id,
                'full_name' => $row->first_name . ' ' . $row->last_name,
                'email' => $row->email,
                'mobile' => $row->mobile,
                'profile_image' => $row->profile_image,
                'created_at' => $row->created_at,
            ];
        }

        return response()->json($data);
    }
    // public function user_list(Request $request)
    // {

    //     $term = trim($request->q);

    //     $role = $request->role;

    //     $query_data = [];

    //     if ($role == 'employee') {

    //         $query_data = User::role(['manager','employee'])->with('media')->where(function ($q) {
    //             if (! empty($term)) {
    //                 $q->orWhere('first_name', 'LIKE', "%$term%")->
    //                 $q->orWhere('last_name', 'LIKE', "%$term%");
    //             }
    //         })->where('is_show_calender', 1)->get();

    //     } elseif ($role == 'user') {

    //         $query_data = User::role(['user'])->where(function ($q) {
    //             if (! empty($term)) {
    //                 $q->orWhere('first_name', 'LIKE', "%$term%")->
    //                 $q->orWhere('last_name', 'LIKE', "%$term%");
    //             }
    //         })->active()->get();

    //     }
    //     elseif ($role == 'vet') {

    //         $query_data = User::role(['vet'])->where(function ($q) {
    //             if (! empty($term)) {
    //                 $q->orWhere('first_name', 'LIKE', "%$term%")->
    //                 $q->orWhere('last_name', 'LIKE', "%$term%");
    //             }
    //         })->active()->get();

    //     }

    //     $data = [];

    //     foreach ($query_data as $row) {
    //         $data[] = [
    //             'id' => $row->id,
    //             'full_name' => $row->first_name.' '.$row->last_name,
    //             'email' => $row->email,
    //             'mobile' => $row->mobile,
    //             'profile_image' => $row->profile_image,
    //             'created_at' => $row->created_at,
    //         ];
    //     }

    //     return response()->json($data);

    // }

    public function create_customer(Request $request)
    {
        $request->validate([
            'first_name' => 'required|min:3|max:191',
            'last_name' => 'required|min:3|max:191',
            'email' => 'required|email|regex:/(.+)@(.+)\.(.+)/i|max:191|unique:users',
        ]);

        $data_array = $request->except('_token', 'roles', 'permissions', 'password_confirmation');
        $data_array['name'] = $request->first_name.' '.$request->last_name;

        if ($request->confirmed == 1) {
            $data_array = Arr::add($data_array, 'email_verified_at', Carbon::now());
        } else {
            $data_array = Arr::add($data_array, 'email_verified_at', null);
        }

        $user = User::create($data_array);

        $roles = $request['roles'];
        $permissions = $request['permissions'];

        // Sync Roles
        $roles = ['user'];
        $user->syncRoles($roles);

        event(new UserCreated($user));

        $message = __('user.user_created');

        if ($request->email_credentials == 1) {
            $data = [
                'password' => $request->password,
            ];

            try {
                $user->notify(new UserAccountCreated($data));
            } catch (\Exception $e) { 
                \Log::error($e->getMessage());
            }

            $message = __('user.account_crdential');
        }

        return response()->json(['data' => $user, 'message' => $message, 'status' => true]);
    }

    // web_player_id update
    public function update_player_id(Request $request)
    {
        auth()->user()->update_player_id($request->player_id);

        return response()->json(['data' => $request->player_id, 'message' => 'Update Web Player ID', 'status' => true]);
    }

    public function myProfile()
    {
        return view('backend.profile.index');
    }

    public function authData()
    {
        return response()->json(['data' => auth()->user(), 'status' => true]);
    }

    public function updateData(Request $request)
    {
        $user = Auth::user();
        $data = User::findOrFail($user->id);
        $request_data = $request->except('profile_image');
        $commissionIds = Commission::where('type', 'product')->pluck('id');

        if ($request->enable_store == 1) {
            if(!$user->hasRole('pet_store')){
                $user->assignRole('pet_store');
                foreach($commissionIds as $commission_id){
                    $commission_data = [
                        'employee_id' => $user->id,
                        'commission_id' => $commission_id,
                    ];

                    EmployeeCommission::create($commission_data);
                }
                Artisan::call('cache:clear');
            }
        }
        else if($request->enable_store == 0 && $user->roles()->count() == 2){
            $user->removeRole('pet_store');
            EmployeeCommission::where('employee_id', $user->id)->whereIn('commission_id', $commissionIds)->delete();

            Artisan::call('cache:clear');
        }

        $data->update($request_data);

        if ($request->custom_fields_data) {

            $data->updateCustomFieldData(json_decode($request->custom_fields_data));
        }

        if($request->profile_image == null) {
            $data->clearMediaCollection('profile_image');
        }

        if ($request->hasFile('profile_image')) {
            storeMediaFile($data, $request->file('profile_image'), 'profile_image');
        }

        if($user->hasRole('user')){
            $message = __('messages.update_form', ['form' => __('customer.singular_title')]);
        }
        else{
            $message = __('messages.update_form', ['form' => __('employee.employee')]);
        }

        return response()->json(['message' => $message, 'status' => true], 200);
    }

    public function change_password(Request $request)
    {
        if (env('IS_DEMO')) {
            return response()->json(['message' => __('messages.permission_denied'), 'status' => false], 200);
        }
        $user = Auth::user(); // Get the currently authenticated user

        $user_id = $user->id; // Retrieve the user's ID

        $data = User::findOrFail($user_id);

        $request_data = $request->only('old_password', 'new_password', 'confirm_password');

        if (! Hash::check($request->old_password, $data->password)) {
            return response()->json(['message' => __('messages.old_password_mismatch'), 'status' => false], 403);
        }

        if ($request_data['new_password'] === $request_data['old_password']) {
            return response()->json(['message' => __('messages.new_password_mismatch'), 'status' => false], 403);
        }

        if ($request_data['new_password'] !== $request_data['confirm_password']) {
            return response()->json(['message' => __('messages.password_mismatch'), 'status' => false], 403);
        }

        $request_data['password'] = Hash::make($request_data['new_password']);

        $data->update($request_data);

        $message = __('messages.password_update');

        return response()->json(['message' => $message, 'status' => true], 200);

    }
    
}
