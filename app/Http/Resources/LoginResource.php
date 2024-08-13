<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Auth;

class LoginResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $roles = $this->getRoleNames();
        if (enableMultivendor() == "0") {
            $roles = $roles->filter(function ($role) {
                return $role !== 'pet_store';
            });    
        }
        return [
            'id' => $this->id,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'mobile' => $this->mobile,
            'email' => $this->email,
            'user_role' => $roles ?? [],
            'api_token' => $this->api_token,
            'profile_image' => $this->avatar,
            'user_type' => $this->user_type,
            'login_type' => $this->login_type,
            'address' => $this->address,
            'player_id' => $this->player_id,
            'profile_image' => $this->media->pluck('original_url')->first(),
            'enable_store' => enableMultivendor() == "1" ? $this->enable_store : 0,

        ];
    }
}
