<?php

namespace Modules\Pet\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;

class PetNoteResource extends JsonResource
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
            'title' => $this->title,
            'description' => $this->description,
            'pet_id' => $this->pet_id,
            'pet_name' => optional($this->pet)->pet_id,
            'status' => $this->status,
            'is_private' => $this->is_private,
            'created_by' => $this->created_by,
            'createdby_user' =>$this->createdBy,
            'updated_by' => $this->updated_by,
            'deleted_by' => $this->deleted_by,
        ];
    }
}
