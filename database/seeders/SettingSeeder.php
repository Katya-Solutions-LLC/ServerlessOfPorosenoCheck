<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Setting;
use Carbon\Carbon;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       
        $modules = [
            [
                'name' => 'pet_daycare_amount',
                'val' => 100,
                'type' =>'booking_config', 
            ],
            [
                'name' => 'pet_boarding_amount',
                'val' => 200,
                'type' =>'booking_config', 
            ],
            [
                'name' => 'is_one_signal_notification',
                'val' => 1,
                'type' =>'integaration', 
            ],
            [
                'name' => 'onesignal_app_id',
                'val' => '39911fbe-db1f-40bf-bc3e-f08003903be5',
                'type' =>'mobile_config', 
            ],
            [
                'name' => 'onesignal_rest_api_key',
                'val' => 'NmIyNjcxMjctYjMxNi00YTEwLWI3OTMtZjhlOTMyNjEwZjlm',
                'type' =>'mobile_config', 
            ],
            [
                'name' => 'onesignal_channel_id',
                'val' => '3460faef-fe36-429d-8f18-b26953d3986f',
                'type' =>'mobile_config', 
            ],
            [
                'name' => 'employee_onesignal_app_id',
                'val' => 'd4582b0b-66ce-414a-9a6c-71cda188a6f3',
                'type' =>'mobile_config', 
            ],
            [
                'name' => 'employee_onesignal_rest_api_key',
                'val' => 'ZDI4YzY4YjEtZGI0YS00ZGRjLWIwYWItNDVmMzdkYzE2YmE3',
                'type' =>'mobile_config', 
            ],
            [
                'name' => 'employee_onesignal_channel_id',
                'val' => '7094d3a3-686a-4814-9e94-8c093b9053ac',
                'type' =>'mobile_config', 
            ],

            [
                'name' => 'is_application_link',
                'val' => 1,
                'type' =>'integaration', 
            ],
            [
                'name' => 'customer_app_play_store',
                'val' => 'https://play.google.com/store/apps/details?id=com.Porosenocheck.customer',
                'type' =>'is_application_link', 
            ],
            [
                'name' => 'customer_app_app_store',
                'val' => 'https://apps.apple.com/in/app/Porosenocheck/id6458044939',
                'type' =>'is_application_link', 
            ],
            [
                'name' => 'employee_app_play_store',
                'val' => 'https://play.google.com/store/apps/details?id=com.Porosenocheck.employee',
                'type' =>'is_application_link', 
            ],
            [
                'name' => 'employee_app_app_store',
                'val' => 'https://apps.apple.com/us/app/Porosenocheck-for-employee/id6462849036',
                'type' =>'is_application_link', 
            ],
            [
                'name' => 'is_zoom',
                'val' => 1,
                'type' =>'integaration', 
            ],
            [
                'name' => 'account_id',
                'val' => 'WJHpsUd9TKKt99vWOKqeig',
                'type' =>'is_zoom', 
            ],
            [
                'name' => 'client_id',
                'val' => 'AcILlYbFS2ajeVjFPQMdwg',
                'type' =>'is_zoom', 
            ],
            [
                'name' => 'client_secret',
                'val' => '150kB12FZyJ5W4AHoDi1EpwG9mCrxJX9',
                'type' =>'is_zoom', 
            ],

            [
                'name' => 'razor_payment_method',
                'val' => 1,
                'type' =>'razorpayPayment', 
            ],
            [
                'name' => 'razorpay_secretkey',
                'val' => 'rzp_test_CLw7tH3O3P5eQM',
                'type' =>'razor_payment_method', 
            ],
            [
                'name' => 'razorpay_publickey',
                'val' => 'rzp_test_CLw7tH3O3P5eQM',
                'type' =>'razor_payment_method', 
            ],
            [
                'name' => 'str_payment_method',
                'val' => 1,
                'type' =>'stripePayment', 
            ],
            [
                'name' => 'stripe_secretkey',
                'val' => 'sk_test_CG2JhAIXvVWDeFUFqtUizO4N00zmvm7o8J',
                'type' =>'str_payment_method', 
            ],
            [
                'name' => 'stripe_publickey',
                'val' => 'pk_test_HtQwwWoE9b43mfy5km6ThSPN00xunQv8J9',
                'type' =>'str_payment_method', 
            ],
            [
                'name' => 'paystack_payment_method',
                'val' => 1,
                'type' =>'paystackPayment', 
            ],
            [
                'name' => 'paystack_secretkey',
                'val' => 'sk_test_9b5bf65070d9773c7a2b3aa7dd8d41310c5fc03c',
                'type' =>'paystack_payment_method', 
            ],
            [
                'name' => 'paystack_publickey',
                'val' => 'pk_test_8c41a6f40d2753586db092fbe22320ac8eda874d',
                'type' =>'paystack_payment_method', 
            ],
            [
                'name' => 'paypal_payment_method',
                'val' => 1,
                'type' =>'paypalPayment', 
            ],
            [
                'name' => 'paypal_secretkey',
                'val' => 'EGvqxtKeQIK5LIPbYLuWTMLoCtqzuoNaFUEvaltLlW2Ka58OwTg5fiv_QuD_fhjguk4RsCExBGpvxu7u',
                'type' =>'paypal_payment_method', 
            ],
            [
                'name' => 'paypal_clientid',
                'val' => 'AepfSIAvfjV4DCulR7pzq2baaxjpkt0vcl0CBJt-YFKaQ6i7fwSY6LubCPtftIGXBX4elIvUL-aPyB2e',
                'type' =>'paypal_payment_method', 
            ],
            [
                'name' => 'flutterwave_payment_method',
                'val' => 1,
                'type' =>'flutterwavePayment', 
            ],
            [
                'name' => 'flutterwave_secretkey',
                'val' => 'FLWSECK_TEST-76e58fc4d85dd2c3fc01ea7ef5b9e2bb-X',
                'type' =>'flutterwave_payment_method', 
            ],
            [
                'name' => 'flutterwave_publickey',
                'val' => 'FLWPUBK_TEST-0e16d1deea10a74762ea18fd0bf5be1c-X',
                'type' =>'flutterwave_payment_method', 
            ],
            [
                'name' => 'is_event',
                'val' => 1,
                'type' =>'other_settings', 
            ],
            [
                'name' => 'is_blog',
                'val' => 1,
                'type' =>'other_settings', 
            ],
            [
                'name' => 'is_user_push_notification',
                'val' => 1,
                'type' =>'other_settings', 
            ],
            [
                'name' => 'is_provider_push_notification',
                'val' => 1,
                'type' =>'other_settings', 
            ],
            [
                'name' => 'default_time_zone',
                'val' => 'Asia/Kolkata',
                'type' =>'misc', 
            ],

            [
                'name' => 'notification',
                'val' => 'firebase_notification',
                'type' =>'other_settings', 
            ],
            [
                'name' => 'firebase_key',
                'val' => 'AAAAtKuRt0I:APA91bE_PtkhVqJZXk0R0nIdeMk83KRgqxD9Jb94FwDbIPbR1HkuyZ8rcy6d9im7qXRXcq1N5Bm204YFTvINaFdxRl671rTizWYPWmZxcCQ1GNGjatMAxijlJ-w1oSFnZ-LGUMrLX77O',
                'type' =>'firebase_notification', 
            ],
            [
                'name' => 'enable_multi_vendor',
                'val' => '0',
                'type' =>'other_settings', 
            ],

            [
                'name' => 'enable_new_petstore_login',
                'val' => '1',
                'type' =>'other_settings', 
            ],



        ];
        foreach ($modules as $key => $value) {
        
            $service = [
                'name' => $value['name'],
                'val' => $value['val'],
                'type' => $value['type']
            ];
            $service = Setting::create($service);
        }

    }
}
