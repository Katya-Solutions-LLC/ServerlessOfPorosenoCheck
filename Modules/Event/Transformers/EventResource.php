<?php

namespace Modules\Event\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;

class EventResource extends JsonResource
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
            'date' => $this->date,
            'name' => $this->name,
            'organizer_id' => $this->user_id,
            'distance' => $this->when($this->distance !== null,  number_format($this->distance * 0.621371,2)),
            'organizer_name' => optional($this->user)->first_name .' '.optional($this->user)->last_name,
            'organizer_email' => optional($this->user)->email,
            'organizer_contact_no' => optional($this->user)->mobile,
            'organizer_image' =>  optional($this->user)->getFirstMediaUrl('profile_image'),
            'description' => $this->description,
            'location' => $this->location,
            'status' => $this->status,
            'image' => $this->getFirstMediaUrl('event_image'),
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
            'deleted_by' => $this->deleted_by,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'deleted_at' => $this->deleted_at,
        ];
    }
}
