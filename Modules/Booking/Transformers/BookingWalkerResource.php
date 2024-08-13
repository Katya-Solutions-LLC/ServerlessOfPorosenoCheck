<?php

namespace Modules\Booking\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Service\Models\Service;
use Modules\Service\Transformers\ServiceResource;
use Modules\Service\Transformers\SystemServiceResource;
use Modules\Pet\Transformers\PetDetailsResource;

class BookingWalkerResource extends JsonResource
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
            'status' => $this->status,
            'start_date_time' => $this->start_date_time,
            'pet_name' => optional($this->pet)->name,
            'breed' => optional(optional($this->pet)->breed)->name,
            'pet_image' => optional($this->pet)->getFirstMediaUrl('pet_image'),
            'service' => new SystemServiceResource($this->systemservice),
            'employee_id' => $this->employee_id,
            'employee_name' => optional($this->employee)->first_name . " ". optional($this->employee)->last_name,
            'employee_image' => optional($this->employee)->getFirstMediaUrl('profile_image'),
            'employee_email' => optional($this->employee)->email,
            'employee_contact' => optional($this->employee)->mobile,
            'price' => optional($this->walking)->price,
            'date_time' =>optional($this->walking)->date_time,
            'duration' => optional($this->walking)->duration,
            'address' => optional($this->walking)->address,
            'payment' => new PaymentResource($this->payment),
            'customer_id' => $this->user_id,
            'customer_name' => optional($this->user)->first_name . " ". optional($this->user)->last_name,
            'customer_contact' => optional($this->user)->mobile,
            'customer_image' => optional($this->user)->getFirstMediaUrl('profile_image'),
            'taxes'=> $tax_details,
            'total_amount'=>(($this->service_amount)+TaxCalculation($this->service_amount ? $this->service_amount : 0)),
            'pet_details'=> new PetDetailsResource($this->pet)
            
        ];
    }
}
