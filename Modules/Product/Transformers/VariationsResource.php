<?php

namespace Modules\Product\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;

class VariationsResource extends JsonResource
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
            'type' => $this->type,
            'is_fixed' => $this->is_fixed,
            'variation_value_ids' => $this->values->pluck('id'),
            'variation_name' => $this->values->pluck('name'),
            'variation_value' => $this->values->pluck('value'),
            'variation_data' => $this->values,
            'status' => $this->status,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
            'deleted_by' => $this->deleted_by,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'deleted_at' => $this->deleted_at,
        ];
    }
}
