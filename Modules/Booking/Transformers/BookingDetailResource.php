<?php
namespace Modules\Booking\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Employee\Models\EmployeeRating;
use Modules\Employee\Transformers\EmployeeReviewResource;
use Modules\Service\Models\Service;
use Modules\Service\Transformers\ServiceResource;

class BookingDetailResource extends JsonResource
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
            'address_line_1' => optional(optional($this->branch)->address)->address_line_1,
            'address_line_2' => optional(optional($this->branch)->address)->address_line_2,
            'phone' => optional($this->branch)->contact_number,
            'employee_id' => optional($this->services)->first()->employee_id,
            'employee_name' => optional(optional($this->services)->first()->employee)->full_name ?? default_user_name(),
            'employee_email' => optional($this->employee)->email,
            'employee_contact' => optional($this->employee)->mobile,
            'employee_image' => optional(optional($this->services)->first()->employee)->profile_image ?? default_user_avatar(),
            'services' => $this->services->filter(function($service) {
                unset($service['employee']);
                return $service;
            }),
            'user_id' => $this->user_id,
            'user_name' => optional($this->user)->full_name ?? default_user_name(),
            'user_profile_image' => optional($this->user)->profile_image ?? default_user_avatar(),
            'user_created' => optional($this->user)->created_at ?? '-',
            'status' => $this->status,
            'created_by_name' => optional($this->createdUser)->full_name ?? default_user_name(),
            'updated_by_name' => optional($this->updatedUser)->full_name ?? default_user_name(),
            'created_at' => date('D, M Y', strtotime($this->created_at)),
            'updated_at' => date('D, M Y', strtotime($this->updated_at)),
            'customer_review' => new EmployeeReviewResource(EmployeeRating::where('user_id', auth()->user()->id)->where('employee_id', optional($this->services)->first()->employee_id)->first()),
            'discount' => $this->discount_percentage,
            'tip' => ! empty($this->tip) ? $this->tip->top_amount : 0,
            'payment' => $this->payment,
            'taxes'=> $tax_details,
            'total_amount'=>(($this->service_amount)+TaxCalculation($this->service_amount ? $this->service_amount : 0))
        ];
    }
}
