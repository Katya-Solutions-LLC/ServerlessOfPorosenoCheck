<?php

namespace App\Http\Controllers\Backend\API;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Modules\Currency\Models\Currency;
use Modules\Commission\Models\Commission;

class SettingController extends Controller
{
    public function appConfiguraton(Request $request)
    {
        $settings = Setting::all()->pluck('val', 'name');
        $currencies = Currency::all();
        $response = [];

        // Define the specific names you want to include
        $specificNames = ['app_name', 'footer_text', 'primary', 'razorpay_secretkey', 'razorpay_publickey', 'stripe_secretkey', 'stripe_publickey', 'paystack_secretkey', 'paystack_publickey', 'paypal_secretkey', 'paypal_clientid', 'flutterwave_secretkey', 'flutterwave_publickey', 'onesignal_app_id', 'onesignal_rest_api_key', 'onesignal_channel_id', 'employee_onesignal_app_id', 'employee_onesignal_rest_api_key', 'employee_onesignal_channel_id', 'customer_app_play_store', 'customer_app_app_store', 'employee_app_play_store', 'employee_app_app_store', 'google_maps_key', 'helpline_number', 'copyright', 'inquriy_email', 'site_description', 'customer_app_play_store', 'customer_app_app_store', 'isForceUpdate', 'version_code','account_id','client_id','client_secret','airtel_secretkey', 'airtel_clientid','phonepay_app_id','phonepay_merchant_id','phonepay_salt_key','phonepay_salt_index','midtrans_clientid'];
        foreach ($settings as $name => $value) {
            if (in_array($name, $specificNames)) {
                if (strpos($name, 'onesignal_') === 0 && $request->is_authenticated == 1) {
                    $nestedKey = 'onesignal_customer_app';
                    $nestedName = str_replace('', 'onesignal_', $name);
                    if (! isset($response[$nestedKey])) {
                        $response[$nestedKey] = [];
                    }
                    $response[$nestedKey][$nestedName] = $value;
                } elseif (strpos($name, 'employee_onesignal_') === 0 && $request->is_authenticated == 1 ) {
                    $nestedKey = 'onesignal_employee_app';
                    $nestedName = str_replace('', 'employee_onesignal_', $name);
                    if (! isset($response[$nestedKey])) {
                        $response[$nestedKey] = [];
                    }
                    $response[$nestedKey][$nestedName] = $value;
                } elseif (strpos($name, 'customer_app_') === 0 ) {
                    $nestedKey = 'customer_app_url';
                    $nestedName = str_replace('', 'customer_app_', $name);
                    if (! isset($response[$nestedKey])) {
                        $response[$nestedKey] = [];
                    }
                    $response[$nestedKey][$nestedName] = $value;
                } elseif (strpos($name, 'employee_app_') === 0  ) {
                    $nestedKey = 'employee_app_url';
                    $nestedName = str_replace('', 'employee_app_', $name);
                    if (! isset($response[$nestedKey])) {
                        $response[$nestedKey] = [];
                    }
                    $response[$nestedKey][$nestedName] = $value;
                }
                 elseif (strpos($name, 'razorpay_') === 0 && $request->is_authenticated == 1 && $settings['razor_payment_method'] !== Null) {
                    $nestedKey = 'razor_pay';
                    $nestedName = str_replace('', 'razorpay_', $name);
                    if (! isset($response[$nestedKey])) {
                        $response[$nestedKey] = [];
                    }
                    $response[$nestedKey][$nestedName] = $value;
                } elseif (strpos($name, 'stripe_') === 0 && $request->is_authenticated == 1 && $settings['str_payment_method'] !== Null) {
                    $nestedKey = 'stripe_pay';
                    $nestedName = str_replace('', 'stripe_', $name);
                    if (! isset($response[$nestedKey])) {
                        $response[$nestedKey] = [];
                    }
                    $response[$nestedKey][$nestedName] = $value;
                } elseif (strpos($name, 'paystack_') === 0 && $request->is_authenticated == 1 && $settings['paystack_payment_method'] !== Null) {
                    $nestedKey = 'paystack_pay';
                    $nestedName = str_replace('', 'paystack_', $name);
                    if (! isset($response[$nestedKey])) {
                        $response[$nestedKey] = [];
                    }
                    $response[$nestedKey][$nestedName] = $value;
                } elseif (strpos($name, 'paypal_') === 0 && $request->is_authenticated == 1 && $settings['paypal_payment_method'] !== Null) {
                    $nestedKey = 'paypal_pay';
                    $nestedName = str_replace('', 'paypal_', $name);
                    if (! isset($response[$nestedKey])) {
                        $response[$nestedKey] = [];
                    }
                    $response[$nestedKey][$nestedName] = $value;
                } elseif (strpos($name, 'flutterwave_') === 0 && $request->is_authenticated == 1 && $settings['flutterwave_payment_method'] !== Null) {
                    $nestedKey = 'flutterwave_pay';
                    $nestedName = str_replace('', 'flutterwave_', $name);
                    if (! isset($response[$nestedKey])) {
                        $response[$nestedKey] = [];
                    }
                    $response[$nestedKey][$nestedName] = $value;
                }elseif (strpos($name, 'airtel_') === 0 && $request->is_authenticated == 1 && $settings['airtel_payment_method'] !== Null) {
                    $nestedKey = 'airtel_pay';
                    $nestedName = str_replace('', 'airtel_', $name);
                    if (! isset($response[$nestedKey])) {
                        $response[$nestedKey] = [];
                    }
                    $response[$nestedKey][$nestedName] = $value;

                }elseif (strpos($name, 'phonepay_') === 0 && $request->is_authenticated == 1 && $settings['phonepay_payment_method'] !== Null) {
                    $nestedKey = 'phonepay_pay';
                    $nestedName = str_replace('', 'phonepay_', $name);
                    if (! isset($response[$nestedKey])) {
                        $response[$nestedKey] = [];
                    }
                    $response[$nestedKey][$nestedName] = $value;
                }elseif (strpos($name, 'midtrans_') === 0 && $request->is_authenticated == 1 && $settings['midtrans_payment_method'] !== Null) {
                    $nestedKey = 'midtrans_pay';
                    $nestedName = str_replace('', 'midtrans_', $name);
                    if (! isset($response[$nestedKey])) {
                        $response[$nestedKey] = [];
                    }
                    $response[$nestedKey][$nestedName] = $value;

                }
                if (! strpos($name, 'onesignal_') === 0) {
                    $response[$name] = $value;
                } elseif (! strpos($name, 'employee_onesignal_') === 0) {
                    $response[$name] = $value;
                } elseif (! strpos($name, 'customer_app_') === 0) {
                    $response[$name] = $value;
                } elseif (! strpos($name, 'employee_app_') === 0) {
                    $response[$name] = $value;
                } elseif (! strpos($name, 'stripe_') === 0) {
                    $response[$name] = $value;
                } elseif (! strpos($name, 'razorpay_') === 0) {
                    $response[$name] = $value;
                } elseif (! strpos($name, 'paystack_') === 0) {
                    $response[$name] = $value;
                } elseif (! strpos($name, 'paypal_') === 0) {
                    $response[$name] = $value;
                } elseif (! strpos($name, 'flutterwave_') === 0) {
                    $response[$name] = $value;
                }elseif (! strpos($name, 'airtel_') === 0) {
                    $response[$name] = $value;
                }elseif (! strpos($name, 'phonepay_') === 0) {
                    $response[$name] = $value;
                }elseif (! strpos($name, 'midtrans_') === 0) {
                    $response[$name] = $value;
                }
            }
        }
        // Fetch currency data
        $currencies = Currency::all();

        $currencyData = null;
        if ($currencies->isNotEmpty()) {
            $currency = $currencies->first();
            $currencyData = [
                'currency_name' => $currency->currency_name,
                'currency_symbol' => $currency->currency_symbol,
                'currency_code' => $currency->currency_code,
                'currency_position' => $currency->currency_position,
                'no_of_decimal' => $currency->no_of_decimal,
                'thousand_separator' => $currency->thousand_separator,
                'decimal_separator' => $currency->decimal_separator,
            ];
        }

        if($request->is_authenticated == 1 && isset($settings['is_zoom']) && isset($settings['account_id']) && isset($settings['client_id']) && isset($settings['client_secret'])){
            $zoomData = [
                'account_id' => $settings['account_id'],
                'client_id' => $settings['client_id'],
                'client_secret' => $settings['client_secret'],
            ];
            $response['zoom'] = $zoomData;
        }

        if (isset($settings['isForceUpdate']) && isset($settings['minimum_force_update_code']) && isset($settings['latest_version_update_code'])) {

            $response['isForceUpdate'] = intval($settings['isForceUpdate']);

            $response['minimum_force_update_code'] = intval($settings['minimum_force_update_code']);
            $response['latest_version_update_code'] = intval($settings['latest_version_update_code']);

        } else {

            $response['isForceUpdate'] = 0;

            $response['minimum_force_update_code'] = 0;
            $response['latest_version_update_code'] = 0;

        }

        if (isset($settings['isForceUpdateEmployee']) && isset($settings['employee_minimum_force_update_code']) && isset($settings['employee_latest_version_update_code'])) {

            $response['isForceUpdateEmployee'] = intval($settings['isForceUpdateEmployee']);

            $response['employee_minimum_force_update_code'] = intval($settings['employee_minimum_force_update_code']);
            $response['employee_latest_version_update_code'] = intval($settings['employee_latest_version_update_code']);

        } else {

            $response['isForceUpdateEmployee'] = 0;

            $response['employee_minimum_force_update_code'] = 0;
            $response['employee_latest_version_update_code'] = 0;

        }

        $commission = Commission::all();
        

        // $response['zoom'] = $zoomData;

        // $response['account_id'] = isset($settings['account_id']) ? $settings['account_id'] : null;
        // $response['client_id'] = isset($settings['client_id']) ? $settings['client_id'] : null;
        // $response['client_secret'] = isset($settings['client_secret']) ? $settings['client_secret'] : null;

        $response['currency'] = $currencyData;
        $response['google_login_status'] = 'false';
        $response['apple_login_status'] = 'false';
        $response['otp_login_status'] = 'false';
        $response['site_description'] = $settings['site_description'] ?? null;
        $response['is_event'] = isset($settings['is_event']) ? intval($settings['is_event']) : 0;
        $response['is_blog'] = isset($settings['is_blog']) ? intval($settings['is_blog']) : 0;
        $response['is_user_push_notification'] = isset($settings['is_user_push_notification']) ? intval($settings['is_user_push_notification']) : 0;
        $response['is_provider_push_notification'] = isset($settings['is_provider_push_notification']) ? intval($settings['is_provider_push_notification']) : 0;
        $response['enable_chat_gpt'] = isset($settings['enable_chat_gpt']) ? intval($settings['enable_chat_gpt']) : 0;
        $response['test_without_key'] = isset($settings['test_without_key']) ? intval($settings['test_without_key']) : 0;
        $response['chatgpt_key'] = $settings['chatgpt_key'] ?? null;
        $response['enable_multi_vendor'] = isset($settings['enable_multi_vendor']) ? intval($settings['enable_multi_vendor']) : 0;
        $response['enable_new_petstore_login'] = isset($settings['enable_new_petstore_login']) ? intval($settings['enable_new_petstore_login']) : 0;
        // Add locale language to the response
        $response['application_language'] = app()->getLocale();
        $response['status'] = true;
        $response['commission'] = $commission;

        return response()->json($response);
    }
}
