<?php

namespace Modules\Booking\Trait;

use App\Models\Setting;
use App\Models\User;
use Modules\Booking\Models\Booking;
use Modules\Booking\Models\BookingService;
use Modules\Booking\Models\BookingTransaction;
use Modules\Booking\Transformers\BookingResource;
use Modules\Commission\Models\CommissionEarning;
use Modules\Currency\Models\Currency;
use Modules\Tip\Models\TipEarning;
use Modules\Commission\Models\Commission;
use Razorpay\Api\Api;

trait PaymentTrait
{
    public function getpayment_method($data)
    {

        $data['transaction_type'] = 'cash';
        $data['tip_amount'] = $data['tip'] ?? 0;
        //$data['tax_percentage'] = $data['taxes'];

        $booking_transaction = BookingTransaction::create($data);


        $earning_data = $this->commissionData($booking_transaction);

        $booking = Booking::where('id', $data['booking_id'])->first();

      

        $booking->commission()->save(new CommissionEarning($earning_data['commission_data']));

        if ($data['tip_amount'] > 0) {

            $booking->tip()->save(new TipEarning($earning_data['tip_data']));

        }

        $total_amount = $data['total_amount'];

        $currency = Currency::where('is_primary', 1)->first();

        switch ($data['transaction_type']) {

            case 'razorpay':

                $razorpay_key = $this->getrazorpaykey();

                $responseData = [
                    'status' => true,
                    'booking_transaction_id' => $booking_transaction['id'],
                    'total_amount' => $total_amount,
                    'currency' => $currency['currency_code'],
                    'payment_method' => $data['payment_method'],
                    'public_key' => isset($razorpay_key['razorpay_publickey']) ? $razorpay_key['razorpay_publickey'] : '',

                ];

                break;

            case 'stripe':

                $stripe_key = $this->getstripekey();

                $responseData = [

                    'booking_transaction_id' => $booking_transaction['id'],
                    'total_amount' => $total_amount,
                    'currency' => $currency['currency_code'],
                    'payment_method' => $data['payment_method'],
                    'public_key' => isset($stripe_key['stripe_secretkey']) ? $stripe_key['stripe_secretkey'] : '',

                ];

                break;

            default:

                $responseData = $this->getcashpayments($data, $booking_transaction['id']);

                break;
        }

        return $responseData;

    }

    //GET TOTAL AMOUNT

    public function getTotalAmount($booking_id, $tax = [], $tip_amount = 0)
    {

        $booking_services = BookingService::where('booking_id', $booking_id)->get();
        $total_service_amount = $booking_services->sum('service_price');

        $tax_amount = 0;
        if ($tax != '') {
            foreach ($tax as $tax_value) {
                if ($tax_value['type'] == 'percent') {
                    $tax_amount = $tax_amount + ($total_service_amount * $tax_value['percent'] / 100);
                } elseif ($tax_value['type'] == 'fixed') {
                    $tax_amount = $tax_amount + $tax_value['tax_amount'];
                }
            }
        }
        $total_amount = $total_service_amount + $tax_amount + $tip_amount;

        $total_amount = number_format($total_amount, 2, '.', '');

        return $total_amount;

    }

 //CASH PAYMNET DATA

    public function getcashpayments($data, $booking_transaction_id)
    {

        BookingTransaction::where('id', $booking_transaction_id)->update(['external_transaction_id' => '', 'payment_status' => 0]);
        Booking::where('id', $data['booking_id'])->update(['status' => 'confirmed']);
        // $queryData = Booking::with('user')->findOrFail($data['booking_id']);
        // $this->sendNotificationOnBookingUpdate('complete_booking', $queryData);
        $responseData = [
            'message' => __('booking.payment_successfull'),
            'payment_method' => $data['transaction_type'],
            // 'data' => new BookingResource($queryData),
            'status' => true,
        ];

        return $responseData;

    }

    // RAZORPAY PAYMENT DATA

    public function getrazorpaypayments($data, $booking_transaction_id)
    {

        $rezorpay_key_data = $this->getrazorpaykey();

        $key_id = $rezorpay_key_data['razorpay_publickey'];
        $secret = $rezorpay_key_data['razorpay_secretkey'];

        try {

            $currency = $data['response']['currency'];

            $floatTotalAmount = floatval($data['response']['total_amount']);
            $totalamount = $floatTotalAmount * 100;
            $api = new Api($key_id, $secret);
            $api->payment->fetch($data['response']['razorpay_payment_id'])->capture(['amount' => $totalamount, 'currency' => $currency]);
            $data = BookingTransaction::where('id', $booking_transaction_id)->update(['external_transaction_id' => $data['response']['razorpay_payment_id'], 'payment_status' => 1]);

            $booking_transaction = BookingTransaction::where('id', $booking_transaction_id)->first();
            Booking::where('id', $booking_transaction['booking_id'])->update(['status' => 'completed']);

            $queryData = Booking::with('services', 'user')->findOrFail($booking_transaction['booking_id']);

            $responseData = [
                'message' => __('booking.payment_successfull'),
                'booking' => new BookingResource($queryData),
                'status' => true,
            ];

        } catch (\Exception $e) {

            $message = $e->getMessage();

            $responseData = [
                'message' => $message,
                'status' => false,
            ];

        }

         return $responseData;

    }

    //OPEN STRIPE CHECKOUT PAGE

    public function getstripepayments($data)
    {

        $baseURL = env('APP_URL');

        $stripe_key_data = $this->getstripekey();

        $stripe_secret = $stripe_key_data['stripe_secretkey'];

        try {

            $stripe = new \Stripe\StripeClient($stripe_secret);
            $checkout_session = $stripe->checkout->sessions->create([

                'success_url' => $baseURL.'/app/bookings/payment_success/'.$data['booking_transaction_id'],
                'payment_method_types' => ['card'],
                'billing_address_collection' => 'required',
                'line_items' => [
                    [
                        'price_data' => [
                            'currency' => $data['currency'],
                            'product_data' => [
                                'name' => 'T-shirt',
                            ],
                            'unit_amount' => $data['total_amount'] * 100,
                        ],
                        'quantity' => 1,
                    ],
                ],
                'mode' => 'payment',
            ]);

        } catch (\Exception $e) {

            $message = $e->getMessage();

            $checkout_session = [
                'message' => $message,
                'status' => false,
            ];

        }

    return $checkout_session;

    }

    //GET STRIPE PAYMENT DATA

    public function getstripePaymnetId($request_token)
    {

        $stripe_key_data = $this->getstripekey();

        $stripe_secret = $stripe_key_data['stripe_secretkey'];

        $stripe = new \Stripe\StripeClient($stripe_secret);
        $session_object = $stripe->checkout->sessions->retrieve($request_token, []);

        return $session_object;

    }

    //GET RAZORPAY KEY DATA FROM DB

    public function getrazorpaykey()
    {

        $rezorpay_key = Setting::where('type', 'razor_payment_method')->get();

        $rezorpay_key_data = [];

        if ($rezorpay_key != '') {

            foreach ($rezorpay_key as $rezorpay) {

                $rezorpay_key_data[$rezorpay->name] = $rezorpay->val;

            }

        }

        return $rezorpay_key_data;

    }

    //GET STRIPE KEY DATA

    public function getstripekey()
    {

        $stripe_key = Setting::where('type', 'str_payment_method')->get();

        $stripe_key_data = [];

        if ($stripe_key != '') {

            foreach ($stripe_key as $stripe) {

                $stripe_key_data[$stripe->name] = $stripe->val;

            }

        }

        return $stripe_key_data;

    }

    public function commissionData($data)
    {
        
        $booking_id = $data['booking_id'];

        $tip_amount = $data['tip_amount'];

        $booking = Booking::where('id', $booking_id)->first();
        if($booking->employee_id !== null){

            $employee_id = $booking->employee_id;

            $employee = User::where('id', $employee_id)->with('commissions_data')->first();

            $commission_amount = 0;

            $total_service_amount = $booking->service_amount;

            if($employee){

             if(isset($employee['commissions_data'])){

                foreach($employee['commissions_data'] as $commission){

                    if($commission['getCommission']['type'] == 'service'){

                        if($commission['getCommission']['commission_type'] == 'fixed'){

                            $commission_amount +=$commission['getCommission']['commission_value'];
    
                        }else{

                            $commission_amount  += $commission['getCommission']['commission_value']* $total_service_amount / 100;
    
                        }
                    }
                }  

                }else{

                    $commission = Commission::first();

                    $commission_type = $commission['commission_type'];

                    $commission_value = $commission['commission_value'];

                    if ($commission_type == 'fixed') {

                        $commission_amount = $commission_value;
    
                      } else {
    
                         $commission_amount = $commission_value * $total_service_amount / 100;
    
                    }
                 }

                $commissionStatus = 'pending';
                if($data->payment_status === 1){
                    $commissionStatus = 'unpaid';
                }
                else{
                    $commissionStatus = 'pending';
                }

                $commission_data = [

                    'employee_id' => $employee_id,
                    'commission_amount' =>$commission_amount,
                    'commission_status' => $commissionStatus,
                    'payment_date' => null,
                ];
    
                $tip_data = [
    
                    'employee_id' => $employee_id,
                    'tip_amount' => $tip_amount,
                    'tip_status' => 'pending',
                    'payment_date' => null,
    
                ];

                $data = [

                    'commission_data' => $commission_data,
                    'tip_data' => $tip_data,
        
                ];
        
                return  $data;

                }


            }
 
       }
}
