<?php

namespace Modules\Product\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;
use App\Models\Setting;

class OrderDetailsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request, $orderItemId = null)
    {
        $user = auth()->user();
        $grandTotal = $this->total_admin_earnings;
        $orderDetails = '';
        $otherOrderItems = [];

        $timezone = Setting::where('name', 'default_time_zone')->value('val') ?? 'UTC';

        $orderItem = $this->orderItems()->where('id', $orderItemId)->first();
        if(auth()->user()->hasRole('pet_store')){
            $orderItems = $this->orderItems()->whereNot('id', $orderItemId)->where('vendor_id', auth()->user()->id)->get();
        }
        else{
            $orderItems = $this->orderItems()->whereNot('id', $orderItemId)->get();
        }

        foreach($orderItems as $item){
            $itemPrice = $item->total_price;
            $totalItemPrice = $itemPrice + $item->total_tax + $item->total_shipping_cost;

            $otherOrderItems[] = [
                'id' => $this->id,
                'order_item_id' => $item->id,
                'user_id' => $this->user_id,
                'delivery_status' => $item->delivery_status,
                'payment_status' => $item->payment_status,
                'product_price' => $itemPrice,
                'total_amount' => $totalItemPrice,
                'grand_total' => $grandTotal,
                'product_details' => new OrderItemResource($item)
            ];
        }


        $totalPrice = $orderItem->total_price;
        $totalProductPrice = $totalPrice + $orderItem->total_tax + $orderItem->total_shipping_cost;

        $orderDetails = [
            'vendor_id' => $orderItem->vendor_id,
            'total_tax_amount' => optional($this->orderGroup)->total_tax_amount,
            'logistic_charge' => optional($this->orderGroup)->total_shipping_cost,
            'product_price' => $totalPrice,
            'total_amount' => $totalProductPrice,
            'grand_total' => $grandTotal,
            'product_details' => new OrderItemResource($orderItem),
            'other_order_items' => $otherOrderItems,
        ];

        $order_prefix_data = Setting::where('name', 'inv_prefix')->first();
        $order_prefix = $order_prefix_data ? $order_prefix_data->val : '';

        return [
            'id' => $this->id,
            'user_id' => $this->user_id,
            'delivery_status' => $orderItem->delivery_status,
            'payment_status' => $orderItem->payment_status,
            'order_code' => $order_prefix . optional($this->orderGroup)->order_code,
            'sub_total_amount' => $subTotalAmount ?? null,
            'total_tax_amount' => optional($this->orderGroup)->total_tax_amount,
            'logistic_charge' => optional($this->orderGroup)->total_shipping_cost,
            'total_amount' => $totalProductPrice ?? null,
            'payment_method' => optional($this->orderGroup)->payment_method,
            'order_date' => Carbon::parse($this->created_at)->timezone($timezone)->format('Y-m-d H:i:s'),
            'logistic_name' => $this->logistic_name,
            'expected_delivery_date' => optional(optional($this->logistic)->logistic_zone)->standard_delivery_time ? Carbon::parse($this->calculateExpectedDeliveryDate())->timezone($timezone)->format('Y-m-d H:i:s') : null,
            'delivery_days' => optional(optional($this->logistic)->logistic_zone)->standard_delivery_time,
            'delivery_time' => optional(optional($this->logistic)->logistic_zone)->standard_delivery_time,
            'user_name' => optional(optional($this->orderGroup)->shippingAddress)->first_name . ' ' . optional(optional($this->orderGroup)->shippingAddress)->last_name,
            'address_line_1' => optional(optional($this->orderGroup)->shippingAddress)->address_line_1,
            'address_line_2' => optional(optional($this->orderGroup)->shippingAddress)->address_line_2,
            'phone_no' => optional($this->orderGroup)->phone_no,
            'alternative_phone_no' => optional($this->orderGroup)->alternative_phone_no,
            'city' => $this->orderGroup?->shippingAddress?->city_data?->name ?? null,
            'state' => $this->orderGroup?->shippingAddress?->state_data?->name ?? null,
            'country' => $this->orderGroup?->shippingAddress?->country_data?->name ?? null,
            'postal_code' => $this->orderGroup?->shippingAddress?->postal_code ?? null,
            'order_details' => $orderDetails,
        ];
    }

    private function calculateExpectedDeliveryDate()
    {
        $orderDate = Carbon::parse($this->created_at);
        $deliveryTimeInDays = intval(optional(optional($this->logistic)->logistic_zone)->standard_delivery_time);
        return $orderDate->addDays($deliveryTimeInDays);
    }


}

