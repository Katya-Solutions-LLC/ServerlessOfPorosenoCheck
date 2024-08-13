<?php

namespace Modules\Booking\Http\Controllers\Backend\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Booking\Models\Booking;
use Modules\Booking\Models\BookingTransaction;
use Modules\Booking\Trait\PaymentTrait;
use Modules\Tip\Models\TipEarning;
use Modules\Commission\Models\CommissionEarning;

class PaymentController extends Controller
{
    use PaymentTrait;

    public function __construct()
    {
        // Page Title
        $this->module_title = 'Payment';
    }

    public function savePayment(Request $request)
    {
    
        $data = $request->all();
        $data['tip_amount'] = $data['tip'] ?? 0;

        $booking = Booking::where('id', $data['booking_id'])->first();
  
        $payment = BookingTransaction::updateOrCreate(['id' => $data['id'] ],$data);

        if($booking['employee_id'] !=''){

            $earning_data = $this->commissionData($payment);

            $booking->commission()->save(new CommissionEarning($earning_data['commission_data']));
    
            if ($data['tip_amount'] > 0) {
    
                $booking->tip()->save(new TipEarning($earning_data['tip_data']));
    
            }
    
        }

       
        $message = __('booking.payment_done');

        return response()->json(['message' => $message, 'status' => true], 200);
    }
}
