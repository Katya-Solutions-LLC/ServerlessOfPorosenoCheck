<?php

namespace Modules\Product\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\Setting;

class OrderResource extends JsonResource
{
    public function toArray($request)
    {
        $user = auth()->user();
        $grandTotal = $this->total_admin_earnings;
        $orderList = [];


        if ($user->hasRole('pet_store')) {
            $vendorId = $user->id;
            $orderItems = $this->orderItems()->where('vendor_id', $vendorId)->get();
        } else {
            $orderItems = $this->orderItems;
        }

        foreach ($orderItems as $orderItem) {

            $totalPrice = $orderItem->total_price;
            $totalProductPrice = $totalPrice + $orderItem->total_tax + $orderItem->total_shipping_cost;

            $orderList[] = [
                'id' => $this->id,
                'order_item_id' => $orderItem->id,
                'user_id' => $this->user_id,
                'delivery_status' => $orderItem->delivery_status,
                'payment_status' => $orderItem->payment_status,
                'product_price' => $totalPrice,
                'total_amount' => $totalProductPrice,
                'grand_total' => $grandTotal,
                'order_code' => $this->getOrderCode(),
                'product_details' => new OrderItemResource($orderItem),
            ];
        }
        return $orderList;
    }

    private function getOrderCode()
    {
        $order_prefix_data = Setting::where('name', 'inv_prefix')->first();
        $order_prefix = $order_prefix_data ? $order_prefix_data->val : '';
        return $order_prefix . optional($this->orderGroup)->order_code;
    }
}
