<?php

namespace Modules\Product\database\seeders;

use Illuminate\Database\Seeder;
use Modules\Constant\Models\Constant;
use Modules\Logistic\Models\LogisticZone;
use Modules\Product\Models\Cart;
use Modules\Product\Models\Order;
use Modules\Product\Models\OrderGroup;
use Modules\Product\Models\OrderItem;
use Modules\Product\Trait\OrderTrait;
use Modules\Commission\Models\CommissionEarning;
use Modules\Booking\Trait\CommissionCalculatorTrait;
use Modules\Product\Models\OrderVendorMapping;
use Carbon\Carbon;


class OrderTableSeeder extends Seeder
{
    use  OrderTrait;
    use CommissionCalculatorTrait;
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (env('IS_DUMMY_DATA')) {
            $this->createOrder([
                'user_id' => 3,
                'location_id' => 1,
                'shipping_address_id' => 2,
                'billing_address_id' => 2,
                'phone' => '1-4578952512',
                'alternative_phone' => '1-4578952512',
                'chosen_logistic_zone_id' => 1,
                'payment_method' => 'cash',
                'payment_status' => 'unpaid',
            ]);

            $this->createOrder([
                'user_id' => 4,
                'location_id' => 1,
                'shipping_address_id' => 2,
                'billing_address_id' => 2,
                'phone' => '1-7485961545',
                'alternative_phone' => '1-7485961545',
                'chosen_logistic_zone_id' => 1,
                'payment_method' => 'cash',
                'payment_status' => 'unpaid',
            ]);

            $this->createOrder([
                'user_id' => 5,
                'location_id' => 1,
                'shipping_address_id' => 2,
                'billing_address_id' => 2,
                'phone' => '1-2563987448',
                'alternative_phone' => '1-2563987448',
                'chosen_logistic_zone_id' => 1,
                'payment_method' => 'cash',
                'payment_status' => 'unpaid',
            ]);

            $this->createOrder([
                'user_id' => 6,
                'location_id' => 1,
                'shipping_address_id' => 2,
                'billing_address_id' => 2,
                'phone' => '1-3565478912',
                'alternative_phone' => '1-3565478912',
                'chosen_logistic_zone_id' => 1,
                'payment_method' => 'cash',
                'payment_status' => 'unpaid',
            ]);


            $this->createOrder([
                'user_id' => 2,
                'location_id' => 1,
                'shipping_address_id' => 2,
                'billing_address_id' => 2,
                'phone' => '1-3565478912',
                'alternative_phone' => '1-3565478912',
                'chosen_logistic_zone_id' => 1,
                'payment_method' => 'cash',
                'payment_status' => 'paid',
            ]);
            $this->createOrder([
                'user_id' => 2,
                'location_id' => 1,
                'shipping_address_id' => 2,
                'billing_address_id' => 2,
                'phone' => '1-3565478912',
                'alternative_phone' => '1-3565478912',
                'chosen_logistic_zone_id' => 1,
                'payment_method' => 'cash',
                'payment_status' => 'paid',
            ]);

            $this->createOrder([
                'user_id' => 7,
                'location_id' => 1,
                'shipping_address_id' => 2,
                'billing_address_id' => 2,
                'phone' => '1-3565478912',
                'alternative_phone' => '1-3565478912',
                'chosen_logistic_zone_id' => 1,
                'payment_method' => 'cash',
                'payment_status' => 'paid',
            ]);
            $this->createOrder([
                'user_id' => 7,
                'location_id' => 1,
                'shipping_address_id' => 2,
                'billing_address_id' => 2,
                'phone' => '1-3565478912',
                'alternative_phone' => '1-3565478912',
                'chosen_logistic_zone_id' => 1,
                'payment_method' => 'cash',
                'payment_status' => 'paid',
            ]);

            $this->createOrder([
                'user_id' => 8,
                'location_id' => 1,
                'shipping_address_id' => 2,
                'billing_address_id' => 2,
                'phone' => '1-3565478912',
                'alternative_phone' => '1-3565478912',
                'chosen_logistic_zone_id' => 1,
                'payment_method' => 'cash',
                'payment_status' => 'paid',
            ]);
            $this->createOrder([
                'user_id' => 8,
                'location_id' => 1,
                'shipping_address_id' => 2,
                'billing_address_id' => 2,
                'phone' => '1-3565478912',
                'alternative_phone' => '1-3565478912',
                'chosen_logistic_zone_id' => 1,
                'payment_method' => 'cash',
                'payment_status' => 'paid',
            ]);

            $this->createOrder([
                'user_id' => 9,
                'location_id' => 1,
                'shipping_address_id' => 2,
                'billing_address_id' => 2,
                'phone' => '1-3565478912',
                'alternative_phone' => '1-3565478912',
                'chosen_logistic_zone_id' => 1,
                'payment_method' => 'cash',
                'payment_status' => 'paid',
            ]);
            $this->createOrder([
                'user_id' => 9,
                'location_id' => 1,
                'shipping_address_id' => 2,
                'billing_address_id' => 2,
                'phone' => '1-3565478912',
                'alternative_phone' => '1-3565478912',
                'chosen_logistic_zone_id' => 1,
                'payment_method' => 'cash',
                'payment_status' => 'paid',
            ]);

            $this->createOrder([
                'user_id' => 10,
                'location_id' => 1,
                'shipping_address_id' => 2,
                'billing_address_id' => 2,
                'phone' => '1-3565478912',
                'alternative_phone' => '1-3565478912',
                'chosen_logistic_zone_id' => 1,
                'payment_method' => 'cash',
                'payment_status' => 'paid',
            ]);
            $this->createOrder([
                'user_id' => 10,
                'location_id' => 1,
                'shipping_address_id' => 2,
                'billing_address_id' => 2,
                'phone' => '1-3565478912',
                'alternative_phone' => '1-3565478912',
                'chosen_logistic_zone_id' => 1,
                'payment_method' => 'cash',
                'payment_status' => 'paid',
            ]);
            $this->createOrder([
                'user_id' => 10,
                'location_id' => 1,
                'shipping_address_id' => 2,
                'billing_address_id' => 2,
                'phone' => '1-3565478912',
                'alternative_phone' => '1-3565478912',
                'chosen_logistic_zone_id' => 1,
                'payment_method' => 'cash',
                'payment_status' => 'paid',
            ]);
        }

        $order_status = [
            [
                'type' => 'ORDER_STATUS',
                'name' => 'order_placed',
                'value' => 'Order Placed',
                'sequence' => 0,
            ],
            [
                'type' => 'ORDER_STATUS',
                'name' => 'accept',
                'value' => 'Accept',
                'sequence' => 1,
            ],
            [
                'type' => 'ORDER_STATUS',
                'name' => 'processing',
                'value' => 'Processing',
                'sequence' => 2,
            ],
            [
                'type' => 'ORDER_STATUS',
                'name' => 'delivered',
                'value' => 'Delivered',
                'sequence' => 3,
            ],
            [
                'type' => 'ORDER_STATUS',
                'name' => 'cancelled',
                'value' => 'Cancelled',
                'sequence' => 4,
            ],
        ];

        foreach ($order_status as $key => $val) {
            Constant::create($val);
        }
    }

    protected function createOrder($request)
    {
        $userId = $request['user_id'];

        $location_id = $request['location_id'];

        $carts = Cart::where('user_id', $userId)->where('location_id', $location_id)->get();

        if (count($carts) > 0) {
            // check carts available stock -- todo::[update version] -> run this check while storing OrderItems
            foreach ($carts as $cart) {
                $productVariationStock = $cart->product_variation->product_variation_stock ? $cart->product_variation->product_variation_stock->stock_qty : 0;
                if ($cart->qty > $productVariationStock) {
                    return false;
                }
            }

            // create new order group
            $orderGroup = new OrderGroup;
            $orderGroup->user_id = $userId;
            $orderGroup->shipping_address_id = $request['shipping_address_id'];
            $orderGroup->billing_address_id = $request['billing_address_id'];
            $orderGroup->location_id = $location_id;
            $orderGroup->phone_no = $request['phone'];
            $orderGroup->alternative_phone_no = $request['alternative_phone'];
            $orderGroup->sub_total_amount = getSubTotal($carts, false, '', false);
            $orderGroup->total_tax_amount = 0;
            $orderGroup->total_coupon_discount_amount = 0;
            $logisticZone = LogisticZone::where('id', $request['chosen_logistic_zone_id'])->first();
            // todo::[for eCommerce] handle exceptions for standard & express
            $orderGroup->total_shipping_cost = $logisticZone->standard_delivery_charge;
            $orderGroup->total_tips_amount = $request['tips'] ?? 0;

            // $orderGroup->grand_total_amount = $orderGroup->sub_total_amount + $orderGroup->total_tax_amount + $orderGroup->total_shipping_cost + $orderGroup->total_tips_amount - $orderGroup->total_coupon_discount_amount;
            $orderGroup->save();

            // order -> todo::[update version] make array for each vendor, create order in loop
            $order = new Order;
            $order->order_group_id = $orderGroup->id;
            $order->user_id = $userId;
            $order->location_id = $location_id;
            // $order->total_admin_earnings = $orderGroup->grand_total_amount;
            $order->logistic_id = $logisticZone->logistic_id;
            $order->logistic_name = optional($logisticZone->logistic)->name;

            $order->shipping_cost = $orderGroup->total_shipping_cost; // todo::[update version] calculate for each vendors
            $order->tips_amount = $orderGroup->total_tips_amount; // todo::[update version] calculate for each vendors
            $order->payment_status = $request['payment_status'];

            $order->save();

            $orderDate = Carbon::parse($order->created_at);
            $deliveryTimeInDays = intval(optional(optional($order->logistic)->logistic_zone)->standard_delivery_time);
            $expected_delivery_date = $orderDate->addDays($deliveryTimeInDays);

            // order items
            $total_points = 0;
            $grandTotal = 0;
            foreach ($carts as $cart) {
                $orderItem = new OrderItem;
                $orderItem->order_id = $order->id;
                $orderItem->product_variation_id = $cart->product_variation_id;
                $orderItem->qty = $cart->qty;
                $orderItem->location_id = $location_id;
                $orderItem->unit_price = variationDiscountedPrice($cart->product_variation->product, $cart->product_variation);
                $orderItem->total_tax = 0;
                $orderItem->total_price = $orderItem->unit_price * $orderItem->qty;
                $orderItem->vendor_id = $cart->product_variation->product->created_by;
                $orderItem->total_shipping_cost  = $logisticZone->standard_delivery_charge;
                $orderItem->payment_status       = $request['payment_status'];
                $orderItem->expected_delivery_date  =  $expected_delivery_date->format('Y-m-d');

                if($orderItem->order_id == 5){
                    $orderItem->delivery_status = 'delivered';
                    $orderItem->delivered_date = Carbon::now();
                }
                $orderItem->save();

                $product = $cart->product_variation->product;
                $product->total_sale_count += $orderItem->qty;

                $grandTotal += $orderItem->total_price + $orderItem->total_tax + $orderItem->total_shipping_cost + $orderGroup->total_tips_amount - $orderGroup->total_coupon_discount_amount;

                if($cart->product->created_by !== Null){
                    $commission_data = $this->calculateCommission($cart);
                    if ($commission_data) {
                        $orderItem->commission()->save(new CommissionEarning([
                            'employee_id' => $commission_data['employee_id'],
                            'commission_amount' => $commission_data['commission_amount'],
                            'commission_status' => $commission_data['commission_status'],
                            'payment_date' => $commission_data['payment_date'],
                        ]));
                    }
                }

                if($request['payment_status'] == 'paid'){
                    CommissionEarning::where('commissionable_id', $orderItem->id)->update(['commission_status' => 'unpaid']);
                }

                // minus stock qty
                try {
                    $productVariationStock = $cart->product_variation->product_variation_stock;
                    $productVariationStock->stock_qty -= $orderItem->qty;
                    $productVariationStock->save();
                } catch (\Throwable $th) {
                    //throw $th;
                }

                $product->stock_qty -= $orderItem->qty;
                $product->save();

                // category sales count
                if ($product->categories()->count() > 0) {
                    foreach ($product->categories as $category) {
                        $category->total_sale_count += $orderItem->qty;
                        $category->save();
                    }
                }
                $cart->delete();
            }

            // payment gateway integration & redirection
            $orderGroup->grand_total_amount = $grandTotal;
            $orderGroup->payment_method = $request['payment_method'];
            $orderGroup->payment_status = $request['payment_status'];
            $orderGroup->save();

            $order->total_admin_earnings = $orderGroup->grand_total_amount;
            $order->save();

            foreach ($carts as $cart) { 
                if($cart->product->created_by !== Null){
                    // $commission_data = $this->calculateCommission($cart);
                    // if ($commission_data) {
                    //     $order->commission()->save(new CommissionEarning([
                    //         'employee_id' => $commission_data['employee_id'],
                    //         'commission_amount' => $commission_data['commission_amount'],
                    //         'commission_status' => $commission_data['commission_status'],
                    //         'payment_date' => $commission_data['payment_date'],
                    //     ]));
                    // }

                    $product_price = $cart->qty * variationDiscountedPrice($cart->product_variation->product, $cart->product_variation);
                    $ordervendor = new OrderVendorMapping();   
                    $ordervendor->product_id = $cart->product_id;
                    $ordervendor->vendor_id = $cart->product->created_by;
                    $ordervendor->order_id = $order->id;
                    $ordervendor->product_total_amount = $product_price;
                    $ordervendor->save();
                }
            }

            // if($request['payment_status'] == 'paid'){
            //     CommissionEarning::where('commissionable_id', $order->id)->update(['commission_status' => 'unpaid']);
            // }

            return $order;
        }
    }
}
