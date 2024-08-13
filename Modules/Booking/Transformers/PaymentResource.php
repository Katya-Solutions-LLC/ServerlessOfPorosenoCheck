<?php

namespace Modules\Booking\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;

class PaymentResource extends JsonResource
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
            'id'=>$this->id,
            'booking_id'=>$this->booking_id,
            'external_transaction_id'=>$this->external_transaction_id,
            'transaction_type'=>$this->transaction_type,
            'discount_percentage'=>$this->discount_percentage,
            'discount_amount'=>$this->discount_amount,
            'tip_amount'=>$this->tip_amount,
            'total_amount'=>$this->total_amount,
            'tax_percentage' => $this->tax_percentage,
            'payment_status'=>$this->payment_status,
            'taxes' => $this->booking ? calculateTaxAmounts($this->tax_percentage, $this->booking->service_amount) : 0,  
        ];
    }

    public function setColor(string $status)
    {
        return config('booking.STATUS')[$status]['color_hex'];
    }
}

