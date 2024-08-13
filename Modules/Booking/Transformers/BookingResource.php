<?php

namespace Modules\Booking\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;

class BookingResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        $tax_details =calculateTaxAmounts($this->payment?$this->payment->tax_percentage:null, ($this->service_amount));
        return [
            'id' => $this->id,
            'note' => $this->note,
            'start_date_time' => $this->start_date_time,
            'branch_id' => $this->branch_id,
            'branch_name' => optional($this->branch)->name,
            'employee_id' => optional($this->services)->first()->employee_id,
            'employee_name' => optional(optional($this->services)->first()->employee)->full_name ?? default_user_name(),
            'services_id' => optional($this->services)->pluck('service_id'),
            'services' => $this->services,
            'user_id' => $this->user_id,
            'total_amount'=>$this->total_amount,
            'user_name' => optional($this->user)->full_name ?? default_user_name(),
            'user_profile_image' => optional($this->user)->profile_image ?? default_user_avatar(),
            'user_created' => optional($this->user)->created_at ?? '-',
            'status' => $this->status,
            'is_paid' => $this->payment->payment_status ?? 0,
            'created_by_name' => optional($this->createdUser)->full_name ?? default_user_name(),
            'updated_by_name' => optional($this->updatedUser)->full_name ?? default_user_name(),
            'created_at' => date('d, M Y', strtotime($this->created_at)),
            'updated_at' => date('d, M Y', strtotime($this->updated_at)),
            'payment' => $this->payment,
            'taxes'=> $tax_details,
            'total_amount'=>(($this->service_amount)+TaxCalculation($this->service_amount ? $this->service_amount : 0))
        ];
    }
}
