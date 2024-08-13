<?php

namespace Modules\Product\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\User;
use App\Models\Setting;
use Carbon\Carbon;

class OrderItemResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        $user = User::find($this->vendor_id);
        $productAmount = $this->total_price;
        $totalProductPrice = $productAmount + $this->total_tax + $this->total_shipping_cost;
        $grandTotal = optional($this->order)->total_admin_earnings;

        $timezone = Setting::where('name', 'default_time_zone')->value('val') ?? 'UTC';
         
        return [

            'id' => $this->id,
            'order_id' => optional($this->order)->id,
            'order_code' => $this->getOrderCode(),
            'product_name'=>optional(optional($this->product_variation)->product)->name,
            'qty'=>$this->qty,
            'product_image'=>$this->product_variation?->product?->media->pluck('original_url')->first() ?? null,
            'product_id' =>optional($this->product_variation)->product_id,
            'product_variation_id' =>optional($this->product_variation)->id,
            'product_variation_type' =>$this->product_variation?->combination?->variation_combination_data?->name ?? null,
            'product_variation_name' => $this->product_variation?->combination?->variation_combination_value?->name ?? null,
            'product_variation_value' => $this->product_variation?->combination?->variation_combination_value?->value ?? null,
            'tax_include_product_price' =>optional($this->product_variation)->price,
            'get_product_price'=> $this->unit_price ?? 0,
            'product_amount' => $this->total_price ?? 0,
            'discount_value' => $this->discount_value,
            'discount_type'=> $this->discount_type,
            'product_review' =>$this->review,
            'employee_id' => $user->id,
            'sold_by'=>$user ? $user->first_name . ' ' . $user->last_name : 'Unknown',
            'delivery_status' => $this->delivery_status,
            'payment_status' => $this->payment_status,
            'total_amount' => $totalProductPrice,
            'tax_amount' => $this->total_tax,
            'grand_total' => $grandTotal,
            'delivered_date' => $this->delivered_date ? Carbon::parse($this->delivered_date)->timezone($timezone)->format('Y-m-d H:i:s') : null,
            'expected_delivery_date' => $this->expected_delivery_date ? $this->expected_delivery_date : null,
        ];
    }

    private function getOrderCode()
    {
        $order_prefix_data = Setting::where('name', 'inv_prefix')->first();
        $order_prefix = $order_prefix_data ? $order_prefix_data->val : '';
        return $order_prefix . optional(optional($this->order)->orderGroup)->order_code;
    }
}
