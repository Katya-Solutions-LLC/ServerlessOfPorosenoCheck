<?php

namespace Modules\Pet\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;

class PetResource extends JsonResource
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
            'name' => $this->name,
            'slug' => $this->slug,
            'pettype' => optional($this->pettype)->name,
            'breed' => optional($this->breed)->name,
            'breed_id' => $this->breed_id,
            'size' => $this->size,
            'pet_image' => $this->media->pluck('original_url')->first(),
            'date_of_birth' => $this->date_of_birth,
            'age' => $this->age,
            'gender' => $this->gender,
            'weight' => $this->weight,
            'weight_unit' => $this->weight_unit,
            'height' => $this->height,
            'height_unit' => $this->height_unit,
            'user_id' => $this->user_id,
            'status' => $this->status,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
            'deleted_by' => $this->deleted_by,
        ];
    }
}
