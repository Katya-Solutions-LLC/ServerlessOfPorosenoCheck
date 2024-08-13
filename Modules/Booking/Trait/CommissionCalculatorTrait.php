<?php

namespace Modules\Booking\Trait;

use Modules\Commission\Models\Commission;
use App\Models\User;
trait CommissionCalculatorTrait
{
    public function calculateCommission($cart)
    {
        $employee_id = $cart->product->created_by;
        $employee = User::where('id', $employee_id)->with('commissions_data')->first();
        if($employee->hasRole('pet_store')){
            $commission_amount = 0;
            $total_order_amount = 0;

            $total_order_amount += $cart->qty * variationDiscountedPrice($cart->product_variation->product, $cart->product_variation);

            if ($employee && isset($employee['commissions_data'])) {
                foreach ($employee['commissions_data'] as $commission) {
                    if($commission['getCommission']['type'] == 'product'){
                        if ($commission['getCommission']['commission_type'] == 'fixed') {
                            $commission_amount += $commission['getCommission']['commission_value'];
                        } else {
                            $commission_amount += $commission['getCommission']['commission_value'] * $total_order_amount / 100;
                        }
                    }
                }
            } else {
                $commission = Commission::first();
                $commission_type = $commission['commission_type'];
                $commission_value = $commission['commission_value'];

                if ($commission_type == 'fixed') {
                    $commission_amount = $commission_value;
                } else {
                    $commission_amount = $commission_value * $total_order_amount / 100;
                }
            }
            return [
                'employee_id' => $employee->id,
                'commission_amount' => $commission_amount,
                'commission_status' => 'pending',
                'payment_date' => null,
            ];
        }
        else{
            return null;
        }
    }
}