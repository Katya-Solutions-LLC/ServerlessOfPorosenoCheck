<?php

namespace Modules\Pet\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;

class PetTypeResource extends JsonResource
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
            'pettype_image' => $this->media->pluck('original_url')->first(),
            'slug' => $this->slug,
            'status' => $this->status,
            // 'image' => 
        ];
    }
}
