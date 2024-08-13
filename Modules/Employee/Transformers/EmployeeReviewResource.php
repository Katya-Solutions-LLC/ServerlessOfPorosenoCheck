<?php

namespace Modules\Employee\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;
use App\Models\Setting;

class EmployeeReviewResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $timezone = Setting::where('name', 'default_time_zone')->value('val') ?? 'UTC';
        return [
            'id' => $this->id,
            'staff_id' => $this->employee_id,
            'review_msg' => $this->review_msg,
            'rating' => $this->rating,
            'user_id' => $this->user_id,
            'created_at' => Carbon::parse($this->created_at)->timezone($timezone)->format('Y-m-d H:i:s'),
            'username' => optional($this->user)->full_name ?? default_user_name(),
            'profile_image' => optional($this->user)->media->pluck('original_url')->first(),
            'gallery' => $this->gallery ?? [],
        ];
    }
}
