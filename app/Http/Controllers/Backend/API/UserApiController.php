<?php

namespace App\Http\Controllers\Backend\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;

class UserApiController extends Controller
{
    public function index()
    {
        return $this->sendResponse(UserResource::collection(User::get()), __('messages.user_list'));
    }

    public function store(UserRequest $request)
    {
        $user = User::create($request->all());

        return $this->sendResponse(new UserResource($user), __('messages.user_create'));
    }

    public function show(User $user)
    {
        return $this->sendResponse(new userResource($user), __('messages.user_detail'));
    }

    public function update(UserRequest $request, User $user)
    {
        $user->update($request->all());

        return $this->sendResponse(new UserResource($user), __('messages.user_update'));
    }

    public function destroy(User $user)
    {
        $id = $user->id;
        $user->delete();

        return $this->sendResponse($id, __('messages.user_delete'));
    }

    public function user_list(Request $request)
    {
        $term = trim($request->q);
        $role = $request->role;

        $queryBuilder = User::query();

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
        return response()->json([
            'status' => true,
            'data' => $data,
            'message' => __('user.user_list'),
        ], 200);
    }


}
