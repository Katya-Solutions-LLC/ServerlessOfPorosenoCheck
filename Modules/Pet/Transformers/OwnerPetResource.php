<?php

namespace Modules\Pet\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Pet\Transformers\PetResource;

class OwnerPetResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'email' => $this->email,
            'mobile' => $this->mobile,
            'player_id' => $this->player_id,
            'full_name' => $this->full_name,
            'gender' => $this->gender,
            'date_of_birth' => $this->date_of_birth,
            'profile_image' => $this->media->pluck('original_url')->first(),
            'status' => $this->status,
            'pets'=>PetResource::collection($this->pets),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'deleted_at' => $this->deleted_at,
          
        ];
    }
}