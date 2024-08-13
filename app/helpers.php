<?php

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Carbon\Carbon;


function fcm($fields)
{

    $headers = [
        'Authorization: key=' .setting('firebase_key'),
        'Content-Type: application/json',
    ];

    $ch = curl_init('https://fcm.googleapis.com/fcm/send');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
    
    $response = curl_exec($ch);

    curl_close($ch);
}


function mail_footer($type)
{
    return [
        'notification_type' => $type,
        'logged_in_user_fullname' => auth()->user() ? auth()->user()->full_name ?? default_user_name() : '',
        'logged_in_user_role' => auth()->user() ? auth()->user()->getRoleNames()->first()->name ?? '-' : '',
        'company_name' => setting('app_name'),
        'company_contact_info' => implode('', [
            setting('helpline_number').PHP_EOL,
            setting('inquriy_email'),
        ]),
    ];
}
function sendNotification($data)
{

    $mailable = \Modules\NotificationTemplate\Models\NotificationTemplate::where('type', $data['notification_type'])->with('defaultNotificationTemplateMap')->first();
    if ($mailable != null && $mailable->to != null) {
        $mails = json_decode($mailable->to);

      

        foreach ($mails as $key => $mailTo) {

            $data['type'] = $data['notification_type'];

            $booking = isset($data['booking']) ? $data['booking'] : null;

            $order = isset($data['order']) ? $data['order'] : null;

            if (isset($booking) && $booking != null) {
               
                $data['id'] = $booking['id'];
                $data['user_id'] = $booking['user_id'];
                $data['user_name'] = $booking['user_name'];
                $data['employee_id'] = $booking['employee_id'];
                $data['employee_name'] = $booking['employee_name'];
                $data['booking_date'] = $booking['booking_date'];
                $data['booking_time'] = $booking['booking_time'];
                $data['booking_services_names'] = $booking['booking_services_names'];
                $data['booking_date_and_time'] = $booking['booking_date_and_time']; 
                $data['booking_services_image'] = $booking['booking_services_image'];
                $data['latitude'] = $booking['latitude'];
                $data['longitude'] = $booking['longitude'];
                $data['notification_group'] = 'booking';
                $data['site_url'] = env('APP_URL');
              
                unset($data['booking']);

            }else if(isset($order) && $order != null){
                $data['notification_group'] = 'shop';
                $data['id'] = $order['id'];
                $data['user_id'] = $order['user_id'];
                $data['order_code'] = $order['order_code'];
                $data['user_name'] = $order['user_name'];
                $data['order_date'] = $order['order_date'];
                $data['order_time'] = $order['order_time'];
                $data['item_id'] = json_encode($order['item_id']);
                $data['site_url'] = env('APP_URL');
                unset($data['order']);

            }

            switch($mailTo) {

                case 'admin':

                    $admin = \App\Models\User::role('admin')->first();

                    if (isset($admin->email)) {
                        try {
                            $admin->notify(new \App\Notifications\CommonNotification($data['notification_type'], $data));
                        } catch (\Exception $e) {
                            Log::error($e);
                        }
                    }

                 break;

                    case 'demo_admin':

                        $demo_admin = \App\Models\User::role('demo_admin')->first();
    
                        if (isset($demo_admin->email)) {
                            try {
                                $demo_admin->notify(new \App\Notifications\CommonNotification($data['notification_type'], $data));
                            } catch (\Exception $e) {
                                Log::error($e);
                            }
                        }
    
                        break;

                case 'employee':

                    if($data['notification_type']=='accept_booking_request'){

                        $walkerIds = Modules\Booking\Models\BookingRequestMapping::where('booking_id', $data['id'] )
                        ->pluck('walker_id')
                        ->toArray();
            
                        $users =\App\Models\User::whereIn('id', $walkerIds)->get();

                        foreach($users as $user) {
                                        
                            try{
                                  $user->notify(new \App\Notifications\CommonNotification($data['notification_type'], $data));

                                }catch (\Exception $e) {
                                   Log::error($e);
                                }
                           }

                      }else{

                        if (isset($data['employee_id']) && $data['employee_id'] != null) {

                            $employee = \App\Models\User::find($data['employee_id']);
                            if (isset($employee->email)) {
                                try {
                                    $employee->notify(new \App\Notifications\CommonNotification($data['notification_type'], $data));
                                } catch (\Exception $e) {
                                    Log::error($e);
                                }
                            }
                        }else{
    
                            if (isset($data['booking_services_names']) && $data['booking_services_names'] == "Walking") {
                                $nearestWalkers = null;
                                

                                if (isset($data['latitude'], $data['longitude']) && $data['latitude'] !== null && $data['longitude'] !== null) {
                                    $nearestWalkers = getNearestWalker($data['latitude'], $data['longitude'], 'walker');
                                }

                                if($nearestWalkers == null || $nearestWalkers->isEmpty()) {
                                    $nearestWalkers = \App\Models\User::where('status', 1)
                                        ->where('user_type', 'walker')
                                        ->get();
                                }
                            
                                if (!empty($nearestWalkers)) {
                                    foreach ($nearestWalkers as $nearestWalker) {
                                        try {
                                            $nearestWalker->notify(new \App\Notifications\CommonNotification($data['notification_type'], $data));
                            
                                            Modules\Booking\Models\BookingRequestMapping::create([
                                                'booking_id' => $data['id'],
                                                'walker_id' => $nearestWalker->id,
                                            ]);
                                        } catch (\Exception $e) {
                                            Log::error($e);
                                        }
                                    }
                                }
                            }
                        }

                    }

                    if($data['notification_type'] == 'order_placed'){
                        
                        $petstoreIds = Modules\Product\Models\OrderItem::where('order_id', $data['id'] )
                        ->pluck('vendor_id')
                        ->toArray();
            
                        $users =\App\Models\User::whereIn('id', $petstoreIds)->get();

                        foreach($users as $user) {

                            try {
                                $user->notify(new \App\Notifications\CommonNotification($data['notification_type'], $data));
                            } catch (\Exception $e) {
                                Log::error($e);
                            }
                        }
                    }

                break;
               
                case 'user':
                    if (isset($data['user_id'])) {
                        $user = \App\Models\User::find($data['user_id']);

                        if(isset($data['item_id'])){
                            $item_ids = json_decode($data['item_id']);
                            
                            if (is_array($item_ids)) {
                                $data['item_id'] = $item_ids[0];
                            }
                        }
                        
                        try {
                            $user->notify(new \App\Notifications\CommonNotification($data['notification_type'], $data));
                        } catch (\Exception $e) {
                            Log::error($e);
                        }
                    }
                    break;
            }
        }
    }
}
function timeAgoInt($date)
{
    if ($date == null) {
        return '-';
    }
    $datetime = new \DateTime($date);
    $datetime->setTimezone(new \DateTimeZone(setting('time_zone') ?? 'UTC'));
    $diff_time = \Carbon\Carbon::parse($datetime)->diffInHours();

    return $diff_time;
}
function timeAgo($date)
{
    if ($date == null) {
        return '-';
    }
    $datetime = new \DateTime($date);
    $datetime->setTimezone(new \DateTimeZone(setting('time_zone') ?? 'UTC'));
    $diff_time = \Carbon\Carbon::parse($datetime)->diffForHumans();

    return $diff_time;
}
function dateAgo($date, $type2 = '')
{
    if ($date == null || $date == '0000-00-00 00:00:00') {
        return '-';
    }
    $diff_time1 = \Carbon\Carbon::createFromTimeStamp(strtotime($date))->diffForHumans();
    $datetime = new \DateTime($date);
    $datetime->setTimezone(new \DateTimeZone(setting('time_zone') ?? 'UTC'));
    $diff_time = \Carbon\Carbon::parse($datetime->format('Y-m-d H:i:s'))->isoFormat('LLL');
    if ($type2 != '') {
        return $diff_time;
    }

    return $diff_time1.' on '.$diff_time;
}

function customDate($date, $format = 'd-m-Y h:i A')
{
    if ($date == null || $date == '0000-00-00 00:00:00') {
        return '-';
    }
    $datetime = new \DateTime($date);
    // $la_time = new \DateTimeZone(\Auth::check() ? \Auth::user()->time_zone ?? 'UTC' : 'UTC');
    $la_time = new \DateTimeZone(setting('time_zone') ?? 'UTC');
    $datetime->setTimezone($la_time);
    $newDate = $datetime->format('Y-m-d H:i:s');
    $diff_time = \Carbon\Carbon::createFromTimeStamp(strtotime($newDate))->format($format);

    return $diff_time;
}

function saveDate($date)
{
    if ($date == null || $date == '0000-00-00 00:00:00') {
        return null;
    }
    $datetime = new \DateTime($date);
    // $la_time = new \DateTimeZone(\Auth::check() ? \Auth::user()->time_zone ?? 'UTC' : 'UTC');
    $la_time = new \DateTimeZone(setting('time_zone') ?? 'UTC');
    $datetime->setTimezone($la_time);
    $newDate = $datetime->format('Y-m-d H:i:s');
    $diff_time = \Carbon\Carbon::createFromTimeStamp(strtotime($newDate));

    return $diff_time;
}
function strtotimeToDate($date)
{
    if ($date == null || $date == '0000-00-00 00:00:00') {
        return '-';
    }
    $datetime = new \DateTime($date);
    $datetime->setTimezone(new \DateTimeZone(setting('time_zone') ?? 'UTC'));
    $diff_time = \Carbon\Carbon::createFromTimeStamp($datetime);

    return $diff_time;
}
function formatOffset($offset)
{
    $hours = $offset / 3600;
    $remainder = $offset % 3600;
    $sign = $hours > 0 ? '+' : '-';
    $hour = (int) abs($hours);
    $minutes = (int) abs($remainder / 60);

    if ($hour == 0 and $minutes == 0) {
        $sign = ' ';
    }

    return 'GMT'.$sign.str_pad($hour, 2, '0', STR_PAD_LEFT)
        .':'.str_pad($minutes, 2, '0');
}

function timeZoneList()
{
    $list = \DateTimeZone::listAbbreviations();
    $idents = \DateTimeZone::listIdentifiers();

    $data = $offset = $added = [];
    foreach ($list as $abbr => $info) {
        foreach ($info as $zone) {
            if (! empty($zone['timezone_id']) and ! in_array($zone['timezone_id'], $added) and in_array($zone['timezone_id'], $idents)) {

                $z = new \DateTimeZone($zone['timezone_id']);
                $c = new \DateTime(null, $z);
                $zone['time'] = $c->format('H:i a');
                $offset[] = $zone['offset'] = $z->getOffset($c);
                $data[] = $zone;
                $added[] = $zone['timezone_id'];
            }
        }
    }

    array_multisort($offset, SORT_ASC, $data);
    $options = [];
    foreach ($data as $key => $row) {

        $options[$row['timezone_id']] = $row['time'].' - '.formatOffset($row['offset']).' '.$row['timezone_id'];
    }

    return $options;
}

/*
 * Global helpers file with misc functions.
 */
if (! function_exists('app_name')) {
    /**
     * Helper to grab the application name.
     *
     * @return mixed
     */
    function app_name()
    {
        return setting('app_name') ?? config('app.name');
    }
}
/**
 * Avatar Find By Gender
 */
if (! function_exists('default_user_avatar')) {
    function default_user_avatar()
    {
        return asset(config('app.avatar_base_path').'avatar.png');
    }
    function default_user_name()
    {
        return __('messages.unknown_user');
    }
}
if (! function_exists('user_avatar')) {
    function user_avatar()
    {
        if (auth()->user()->profile_image ?? null) {
            return auth()->user()->profile_image;
        } else {
            return asset(config('app.avatar_base_path').'avatar.png');
        }
    }
}

if (! function_exists('default_feature_image')) {
    function default_feature_image()
    {
        return asset(config('app.image_path').'default.png');
    }
}

/*
 * Global helpers file with misc functions.
 */
if (! function_exists('user_registration')) {
    /**
     * Helper to grab the application name.
     *
     * @return mixed
     */
    function user_registration()
    {
        $user_registration = false;

        if (env('USER_REGISTRATION') == 'true') {
            $user_registration = true;
        }

        return $user_registration;
    }
}

/**
 * Global Json DD
 * !USAGE
 * return jdd($id);
 */
if (! function_exists('jdd')) {
    function jdd($data)
    {
        return response()->json($data, 500);
        exit();
    }
}

/*
 *
 * label_case
 *
 * ------------------------------------------------------------------------
 */
if (! function_exists('label_case')) {
    /**
     * Prepare the Column Name for Lables.
     */
    function label_case($text)
    {
        $order = ['_', '-'];
        $replace = ' ';

        $new_text = trim(\Illuminate\Support\Str::title(str_replace('"', '', $text)));
        $new_text = trim(\Illuminate\Support\Str::title(str_replace($order, $replace, $text)));
        $new_text = preg_replace('!\s+!', ' ', $new_text);

        return $new_text;
    }
}

/*
 *
 * show_column_value
 *
 * ------------------------------------------------------------------------
 */
if (! function_exists('show_column_value')) {
    /**
     * Return Column values as Raw and formatted.
     *
     * @param  string  $valueObject  Model Object
     * @param  string  $column  Column Name
     * @param  string  $return_format  Return Type
     * @return string Raw/Formatted Column Value
     */
    function show_column_value($valueObject, $column, $return_format = '')
    {
        $column_name = $column->Field;
        $column_type = $column->Type;

        $value = $valueObject->$column_name;

        if ($return_format == 'raw') {
            return $value;
        }

        if (($column_type == 'date') && $value != '') {
            $datetime = \Carbon\Carbon::parse($value);

            return $datetime->isoFormat('LL');
        } elseif (($column_type == 'datetime' || $column_type == 'timestamp') && $value != '') {
            $datetime = \Carbon\Carbon::parse($value);

            return $datetime->isoFormat('LLLL');
        } elseif ($column_type == 'json') {
            $return_text = json_encode($value);
        } elseif ($column_type != 'json' && \Illuminate\Support\Str::endsWith(strtolower($value), ['png', 'jpg', 'jpeg', 'gif', 'svg'])) {
            $img_path = asset($value);

            $return_text = '<figure class="figure">
                                <a href="'.$img_path.'" data-lightbox="image-set" data-title="Path: '.$value.'">
                                    <img src="'.$img_path.'" style="max-width:200px;" class="figure-img img-fluid rounded img-thumbnail" alt="">
                                </a>
                                <figcaption class="figure-caption">Path: '.$value.'</figcaption>
                            </figure>';
        } else {
            $return_text = $value;
        }

        return $return_text;
    }
}

/*
 *
 * fielf_required
 * Show a * if field is required
 *
 * ------------------------------------------------------------------------
 */
if (! function_exists('fielf_required')) {
    /**
     * Prepare the Column Name for Lables.
     */
    function fielf_required($required)
    {
        $return_text = '';

        if ($required != '') {
            $return_text = '<span class="text-danger">*</span>';
        }

        return $return_text;
    }
}

/*
 * Get or Set the Settings Values
 *
 * @var [type]
 */
if (! function_exists('setting')) {
    function setting($key, $default = null)
    {
        if (is_null($key)) {
            return new App\Models\Setting();
        }

        if (is_array($key)) {
            return App\Models\Setting::set($key[0], $key[1]);
        }

        $value = App\Models\Setting::get($key);

        return is_null($value) ? value($default) : $value;
    }
}

/*
 * Show Human readable file size
 *
 * @var [type]
 */
if (! function_exists('humanFilesize')) {
    function humanFilesize($size, $precision = 2)
    {
        $units = ['B', 'kB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB'];
        $step = 1024;
        $i = 0;

        while (($size / $step) > 0.9) {
            $size = $size / $step;
            $i++;
        }

        return round($size, $precision).$units[$i];
    }
}

/*
 *
 * Encode Id to a Hashids\Hashids
 *
 * ------------------------------------------------------------------------
 */
if (! function_exists('encode_id')) {
    /**
     * Prepare the Column Name for Lables.
     */
    function encode_id($id)
    {
        $hashids = new Hashids\Hashids(config('app.salt'), 3, 'abcdefghijklmnopqrstuvwxyz1234567890');
        $hashid = $hashids->encode($id);

        return $hashid;
    }
}

/*
 *
 * Decode Id to a Hashids\Hashids
 *
 * ------------------------------------------------------------------------
 */
if (! function_exists('decode_id')) {
    /**
     * Prepare the Column Name for Lables.
     */
    function decode_id($hashid)
    {
        $hashids = new Hashids\Hashids(config('app.salt'), 3, 'abcdefghijklmnopqrstuvwxyz1234567890');
        $id = $hashids->decode($hashid);

        if (count($id)) {
            return $id[0];
        } else {
            abort(404);
        }
    }
}

/*
 *
 * Prepare a Slug for a given string
 * Laravel default str_slug does not work for Unicode
 *
 * ------------------------------------------------------------------------
 */
if (! function_exists('slug_format')) {
    /**
     * Format a string to Slug.
     */
    function slug_format($string)
    {
        $base_string = $string;

        $string = preg_replace('/\s+/u', '-', trim($string));
        $string = str_replace('/', '-', $string);
        $string = str_replace('\\', '-', $string);
        $string = strtolower($string);

        $slug_string = $string;

        return $slug_string;
    }
}

/*
 *
 * icon
 * A short and easy way to show icon fornts
 * Default value will be check icon from FontAwesome
 *
 * ------------------------------------------------------------------------
 */
if (! function_exists('icon')) {
    /**
     * Format a string to Slug.
     */
    function icon($string = 'fas fa-check')
    {
        $return_string = "<i class='".$string."'></i>";

        return $return_string;
    }
}

/*
 *
 * Decode Id to a Hashids\Hashids
 *
 * ------------------------------------------------------------------------
 */
if (! function_exists('generate_rgb_code')) {
    /**
     * Prepare the Column Name for Lables.
     */
    function generate_rgb_code($opacity = '0.9')
    {
        $str = '';
        for ($i = 1; $i <= 3; $i++) {
            $num = mt_rand(0, 255);
            $str .= "$num,";
        }
        $str .= "$opacity,";
        $str = substr($str, 0, -1);

        return $str;
    }
}

/*
 *
 * Return Date with weekday
 *
 * ------------------------------------------------------------------------
 */
if (! function_exists('date_today')) {
    /**
     * Return Date with weekday.
     *
     * Carbon Locale will be considered here
     * Example:
     * Friday, July 24, 2020
     */
    function date_today()
    {
        $str = \Carbon\Carbon::now()->isoFormat('dddd, LL');

        return $str;
    }
}

if (! function_exists('language_direction')) {
    /**
     * return direction of languages.
     *
     * @return string
     */
    function language_direction($language = null)
    {
        if (empty($language)) {
            $language = app()->getLocale();
        }
        $language = strtolower(substr($language, 0, 2));
        $rtlLanguages = [
            'ar', //  'العربية', Arabic
            'arc', //  'ܐܪܡܝܐ', Aramaic
            'bcc', //  'بلوچی مکرانی', Southern Balochi
            'bqi', //  'بختياري', Bakthiari
            'ckb', //  'Soranî / کوردی', Sorani Kurdish
            'dv', //  'ދިވެހިބަސް', Dhivehi
            'fa', //  'فارسی', Persian
            'glk', //  'گیلکی', Gilaki
            'he', //  'עברית', Hebrew
            'lrc', //- 'لوری', Northern Luri
            'mzn', //  'مازِرونی', Mazanderani
            'pnb', //  'پنجابی', Western Punjabi
            'ps', //  'پښتو', Pashto
            'sd', //  'سنڌي', Sindhi
            'ug', //  'Uyghurche / ئۇيغۇرچە', Uyghur
            'ur', //  'اردو', Urdu
            'yi', //  'ייִדיש', Yiddish
        ];
        if (in_array($language, $rtlLanguages)) {
            return 'rtl';
        }

        return 'ltr';
    }
}

if (! function_exists('module_exist')) {
    /**
     * return value for module exist or not.
     *
     * @return bool
     */
    function module_exist($module_name)
    {
        return \Module::find($module_name)?->isEnabled() ?? false;
    }
}

function storeMediaFile($module, $file, $key = 'feature_image')
{
    if (isset($module) && isset($file)) {
        $module->clearMediaCollection($key);
        $mediaItems = $module->addMedia($file)->toMediaCollection($key);
    }

    if ($key == 'profile_image' && $file == '') {

        $module->clearMediaCollection($key);

    }
}
function getCustomizationSetting($name, $key = 'customization_json')
{
    $settingObject = setting($key);
    if (isset($settingObject) && $key == 'customization_json') {
        try {
            $settings = (array) json_decode(html_entity_decode(stripslashes($settingObject)))->setting;

            return collect($settings[$name])['value'];
        } catch (\Exception $e) {
            return '';
        }

        return '';
    } elseif ($key == 'root_color') {
        //
    }

    return '';
}
// Usage: getCustomizationSetting('app_name') it will return value of this json
// getCustomizationSetting('footer')
// getCustomizationSetting('menu_style)

function str_slug($title, $separator = '-', $language = 'en')
{
    return Str::slug($title, $separator, $language);
}

function formatCurrency($number, $noOfDecimal, $decimalSeparator, $thousandSeparator, $currencyPosition, $currencySymbol) {
    // Convert the number to a string with the desired decimal places
    $formattedNumber = number_format($number, $noOfDecimal, '.', '');

    // Split the number into integer and decimal parts
    $parts = explode('.', $formattedNumber);
    $integerPart = $parts[0];
    $decimalPart = isset($parts[1]) ? $parts[1] : '';

    // Add thousand separators to the integer part
    $integerPart = number_format($integerPart, 0, '', $thousandSeparator);

    // Construct the final formatted currency string
    $currencyString = '';

    if ($currencyPosition == 'left' || $currencyPosition == 'left_with_space') {
        $currencyString .= $currencySymbol;
        if ($currencyPosition == 'left_with_space') {
            $currencyString .= ' ';
        }
        $currencyString .= $integerPart;
        // Add decimal part and decimal separator if applicable
        if ($noOfDecimal > 0) {
            $currencyString .= $decimalSeparator . $decimalPart;
        }
    }

    if ($currencyPosition == 'right' || $currencyPosition == 'right_with_space') {
        // Add decimal part and decimal separator if applicable
        if ($noOfDecimal > 0) {
            $currencyString .= $integerPart . $decimalSeparator . $decimalPart;
        }
        if ($currencyPosition == 'right_with_space') {
            $currencyString .= ' ';
        }
        $currencyString .= $currencySymbol;
    }

    return $currencyString;
}


function timeAgoFormate($date)
{
    if ($date == null) {
        return '-';
    }

    // date_default_timezone_set('UTC');

    $diff_time = \Carbon\Carbon::createFromTimeStamp(strtotime($date))->diffForHumans();

    return $diff_time;
}

function get_pet_center_id(){

    $pet_center = \App\Models\Branch::first();
    return $pet_center->id;

}

function geTotalAmount($start_date='', $end_date='', $type='', $service_amount=0){

    $amount_data=[];

    switch ($type) {
        case 'boarding':

          $setting_data=\App\Models\Setting::where('name','pet_boarding_amount')->first();

          $service_amount=$setting_data->val;

          $amount_arr=CountAmount($start_date,$end_date,$service_amount);

          break;

        default:

         $service_amount=0;
         $total_amount=0;
        break;
     }



    return $amount_arr;

}

function geServiceAmount($type='', $service_id='',$price=0){

   $amount_data=[];
    switch ($type) {
        case 'veterinary':
        case 'grooming':

            $service_data = Modules\Service\Models\Service::where('id', $service_id)->first();
            $service_amount = $service_data->default_price;
            $tax_amount = TaxCalculation($service_amount);
            $total_amount= $service_amount + $tax_amount;
            $duration ='';


            break;

            case 'training':
            case 'walking':

             $duration_data = Modules\Service\Models\ServiceDuration::where('id',$service_id)->first();
             $service_amount = $duration_data->price;
             $tax_amount = TaxCalculation($service_amount);
             $total_amount = $service_amount + $tax_amount;
             $duration = $duration_data->duration;


             break;

        default:

           $service_amount = 0;
           $total_amount =0;
           $duration = '';

            break;

    }

    $amount_arr=[

        'service_amount'=> $service_amount,
        'total_amount'=>  $total_amount,
        'duration'=>  $duration
    ];

return  $amount_arr;


}

function geDaycareAmount($type=''){

    $amount_data=[];

    switch ($type) {
        case 'daycare':

          $setting_data=\App\Models\Setting::where('name','pet_daycare_amount')->first();

          $service_amount=$setting_data->val;

          $tax_amount = TaxCalculation($service_amount);
          $total_amount = $service_amount + $tax_amount;

          break;

        default:

        $service_amount = 0;
        $total_amount =0;

        break;
    }

     $amount_data=[

        'service_amount'=> $service_amount,
        'total_amount'=>  $total_amount,

    ];

    return  $amount_data;

}

 function CountAmount($start_date='', $end_date='',$service_amount=0){

    if (empty($start_date) || empty($end_date) || $service_amount < 0) {

        return 0;
    }

    $startDateTime = new DateTime($start_date);
    $endDateTime = new DateTime($end_date);

    $interval = $startDateTime->diff($endDateTime);
    $totalDays = $interval->days+1;

    $amount = $service_amount * $totalDays;

    $tax_amount=TaxCalculation($amount);

    $totalAmount= $amount+ $tax_amount;

    $amount=[

        'service_amount'=>$service_amount,
        'total_service_amount'=>$amount,
        'total_amount'=> $totalAmount,


    ];

    return $amount;

 }


 function TaxCalculation($amount){

    // $taxes=Modules\Tax\Models\Tax::active()->whereNull('module_type')->orWhere('module_type', 'services')->get();
    $taxes = Modules\Tax\Models\Tax::active()
            ->where(function ($query) {
                $query->whereNull('module_type')
                    ->orWhere('module_type', 'services');
            })
            ->get();

    $totalTaxAmount=0;

    foreach ($taxes as $tax) {
        if ($tax->type === 'percentage') {

            $percentageAmount = ($tax->value / 100) * $amount;
            $totalTaxAmount += $percentageAmount;

        } elseif ($tax->type === 'fixed') {

            $totalTaxAmount += $tax->value;
        }
    }

    return $totalTaxAmount;

}

function getServiceDetails($service_id){

    $service_data=Modules\Service\Models\Service::where('id',$service_id)->first();

    return $service_data;

}
function formatTime($time)
{
    // Create a new Carbon instance from the provided time string
    $parsedTime = Carbon::parse($time);

    // Get the hours and minutes from the Carbon instance
    $hours = $parsedTime->format('H');
    $minutes = $parsedTime->format('i');

    // Initialize an empty array to store the parts of the formatted string
    $formattedParts = [];

    // Format hours
    if ($hours > 0) {
        $formattedParts[] = $hours . ' ' . ($hours == 1 ? 'hour' : 'hours');
    }

    // Format minutes
    if ($minutes > 0) {
        $formattedParts[] = $minutes . ' ' . ($minutes == 1 ? 'minute' : 'minutes');
    }

    // Combine the formatted parts into a single string
    $formattedTime = implode(' ', $formattedParts);

    return $formattedTime;
}
function get_booking_date($id,$booking_type){
    $booking_data=Modules\Booking\Models\Booking::with(['boarding','training','daycare','walking','grooming','veterinary'])
    ->where('id',$id)->where('booking_type',$booking_type)->first();
    switch ($booking_data->booking_type) {
        case 'boarding':
            $date= optional($booking_data->boarding)->dropoff_date_time;
            break;
        case 'training':
            $date= optional($booking_data->training)->date_time;
            break;
        case 'daycare':
            $date= optional($booking_data->daycare)->date;
            break;
        case 'walking':
            $date= optional($booking_data->walking)->date_time;
            break;
        case 'grooming':
            $date= optional($booking_data->grooming)->date_time;
            break;
        case 'veterinary':
            $date= optional($booking_data->veterinary)->date_time;
            break;
        default:
            # code...
            break;
    }
    return $date;
}
function calculateTaxAmounts( $taxData,  $totalAmount)
{

    $result = [];

    if( $taxData != null){

        $taxes = json_decode($taxData);

    }else{

        $taxes = Modules\Tax\Models\Tax::active()->whereNull('module_type')->orWhere('module_type', 'services')->get();
    }

    foreach ($taxes as $tax) {
        $amount = 0;
        if ($tax->type == 'percentage') {
            $amount = ($tax->value / 100) * $totalAmount;
        }else {
            $amount = $tax->value??0;
        }
        $result[] = [
            'title' => $tax->title??0,
            'amount' => (float)number_format($amount, 2), // Optional: Format amount to two decimal places
        ];
    }

    return $result;
}
function check_system_service($service){
    $status = 0;
    $system_service = Modules\Service\Models\SystemService::where('slug',$service)->first();
    if($system_service){
        $status = $system_service->status;
    }
    return $status;
}

function getRevenueData(){

    $bookings = Modules\Booking\Models\Booking::with('payment')
    ->whereHas('payment', function ($query) {
        $query->where('payment_status', 1);
    })
    ->get();

    $TotalAmount = $bookings->sum('total_amount');

    $commissionData = Modules\Commission\Models\CommissionEarning::where('commission_status', '!=', 'pending')->get();

    $commissionAmount = $commissionData->sum('commission_amount');

    $admin_earnings= $TotalAmount-$commissionAmount;

    $result = [
        'total_amount' =>number_format($TotalAmount, 2, '.', ''),
        'total_commission' => (float)number_format($commissionAmount , 2),
        'admin_earnings' => number_format($admin_earnings, 2, '.', ''),
    ];

    return $result;
}


function getzoomVideoUrl($data){

    $setting_data=\App\Models\Setting::where('type','is_zoom')->get();

    $account_id='';
    $client_id='';
    $client_secret='';

    if($setting_data->isNotEmpty()){

        foreach ($setting_data as $setting) {
            if ($setting->name === 'account_id') {
                $account_id = $setting->val;
            } elseif ($setting->name === 'client_id') {
                $client_id = $setting->val;
            } elseif ($setting->name === 'client_secret') {
                $client_secret = $setting->val;
            }
        }

      }else{

        return  $zoom_url='';
      }
    // $account_id = 'WJHpsUd9TKKt99vWOKqeig';
    // $client_id = 'AcILlYbFS2ajeVjFPQMdwg';
    // $client_secret = '150kB12FZyJ5W4AHoDi1EpwG9mCrxJX9';

    $authorization = base64_encode($client_id . ':' . $client_secret);

    $curl = curl_init();

    $url = "https://zoom.us/oauth/token?grant_type=account_credentials&account_id=$account_id";

    curl_setopt_array($curl, array(
      CURLOPT_URL => $url,
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => '',
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 0,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => 'POST',
      CURLOPT_HTTPHEADER => array(
        'Host: zoom.us',
        'Authorization: Basic ' . $authorization,
        'Cookie: TS018dd1ba=01a4bf7a43d12da00e647623dc86cc762d126ecbc8d05da8041a487f2d9af5f795dbc94ddaff0e57c96c75394da34ba688b274d027; TS01f92dc5=01a4bf7a43d12da00e647623dc86cc762d126ecbc8d05da8041a487f2d9af5f795dbc94ddaff0e57c96c75394da34ba688b274d027; __cf_bm=2zLDWSFRt_rnknkjf0bFIFxuJIu1ZSd48NLBQiH7ByU-1691735997-0-AfSs0V8YmXQE0t25v+BewBtQQlqkCxAOHQI9pbUANYn5bxIi09JPmaKA/LM7IUsjd3iHRFhgr8BttQMgSkzlOdk=; _zm_chtaid=528; _zm_ctaid=T-ladtb9RQy5jtqpoyz5Ew.1691735997275.ec80d36ec41d720bf03b5c8cdc81edaa; _zm_mtk_guid=0bab4993560a483fb93c8926f1220417; _zm_page_auth=us05_c_9QH5C_6TQJS-eycodFJaSg; _zm_ssid=us05_c_jooeGe7USU6A4k5JXX5Psg; cred=7CB892515BDA6C68C6344C62AB3336E3'
      ),
    ));

    $response = curl_exec($curl);

    curl_close($curl);

    $response_data = json_decode($response, true);

    if (isset($response_data['access_token'])) {
        $access_token = $response_data['access_token'];

        // Now you can use $access_token to create your Zoom join URL
        $zoom_url = getjoinUrl($access_token, $data);

    } else {
        $zoom_url=[];
    }

    return  $zoom_url;


}

function getjoinUrl($access_token, $data) {

    $curl = curl_init();

    $service_name = isset($data['service_name']) ? $data['service_name'] : '';
    $service_duration = isset($data['service_duration']) ? $data['service_duration'] : '30'; // Default duration
    $date_time = new DateTime($data['date'] . ' ' . $data['time']);
    $formatted_date_time = $date_time->format('Y-m-d\TH:i:s\Z'); // Format the date-time as required
    curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://api.zoom.us/v2/users/me/meetings',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS => '{
            "topic": "' . $service_name . '",
            "type": 2,
            "start_time": "' . $formatted_date_time . '",
            "duration": "' . $service_duration . '",
            "settings": {
                "host_video": true,
                "participant_video": true,
                "join_before_host": true,
                "mute_upon_entry": "true",
                "watermark": "true",
                "audio": "voip",
                "auto_recording": "cloud"
            }
        }',
        CURLOPT_HTTPHEADER => array(
            'Content-Type: application/json',
            'Authorization: Bearer ' . $access_token
        ),
    ));

    $response = curl_exec($curl);


    if ($response) {
        $response_data = json_decode($response, true);

        if (isset($response_data['start_url']) && isset($response_data['join_url'])) {
            $start_url = $response_data['start_url'];
            $join_url = $response_data['join_url'];

        } else {
            $start_url = '';
            $join_url = '';

     }
    } else {
            $start_url = '';
            $join_url = '';
    }

    curl_close($curl);

   $zoom_url=[

      'start_url'=>$start_url,
      'join_url'=>$join_url,

   ];

    return $zoom_url;
}

function getDiscountedProductPrice($product_price, $product_id)
{
    $product = \Modules\Product\Models\Product::where('id', $product_id)->first();

    if($product){

 

    $discount_type = $product['discount_type'];
    $discount_value = $product['discount_value'];

    $discount_amount = 0;

    if ($discount_type == 'percent') {
        $discount_amount += $product_price * $discount_value / 100;
    } elseif ($discount_type == 'fixed') {
        $discount_amount += $discount_value;
    }

    return $product_price - $discount_amount;
   }

   return 0;
}

function checkInWishList($product_id, $user_id)
{
    $product = \Modules\Product\Models\WishList::where('product_id', $product_id)->where('user_id', $user_id)->first();

    if (! $product) {
        return 0;
    } else {
        return 1;
    }
}

function checkInCart($product_variation_id, $user_id)
{
    $cart = \Modules\Product\Models\Cart::where('user_id', $user_id)->where('product_variation_id', $product_variation_id)->first();

    if (! $cart) {
        return 0;
    } else {
        return 1;
    }
}

function checkIsLike($review_id, $user_id)
{
    $review = \Modules\Product\Models\Review::find($review_id);

    if (! $review) {
        return 0; // Review not found
    }

    $isLiked = $review->likes()
    ->where('user_id', $user_id)
    ->where('is_like', 1)
    ->exists();

    return $isLiked ? 1 : 0;
}

function checkIsdisLike($review_id, $user_id)
{
    $review = \Modules\Product\Models\Review::find($review_id);

    if (! $review) {
        return 0; // Review not found
    }

    $isLiked = $review->likes()
    ->where('user_id', $user_id)
    ->where('dislike_like', 1)
    ->exists();

    return $isLiked ? 1 : 0;
}

function getDiscountedPrice($data)
{
    $sumOfDiscountedPrices = 0;

    if ($data) {
        foreach ($data as $cart) {
            $price = $cart->product_variation->price;

            $discount_applicable = false;

            if (
                $cart->product->discount_start_date !== null &&
                $cart->product->discount_end_date !== null &&
                strtotime(date('d-m-Y H:i:s')) >= $cart->product->discount_start_date &&
                strtotime(date('d-m-Y H:i:s')) <= $cart->product->discount_end_date
            ) {
                $discount_applicable = true;
            }

            if ($discount_applicable) {
                if ($cart->product->discount_type === 'percent') {
                    $discountedPrice = ($price * $cart->product->discount_value) / 100;
                } elseif ($cart->product->discount_type === 'fixed') {
                    $discountedPrice = $cart->product->discount_value;
                }

                $sumOfDiscountedPrices += $discountedPrice;
            }
        }
    }

    return $sumOfDiscountedPrices;
}

if (! function_exists('variationDiscountedPrice')) {
    // return discounted price of a variation
    function variationDiscountedPrice($product, $variation, $addTax = false)
    {
        $price = $variation->price;

        $discount_applicable = false;

        if ($product->discount_start_date == null || $product->discount_end_date == null) {
            $discount_applicable = false;
        } elseif (
            strtotime(date('d-m-Y ')) >= $product->discount_start_date &&
            strtotime(date('d-m-Y')) <= $product->discount_end_date
        ) {
            $discount_applicable = true;
        }

        if ($discount_applicable) {
            if ($product->discount_type == 'percent') {
                $price -= ($price * $product->discount_value) / 100;
            } elseif ($product->discount_type == 'fixed') {
                $price -= $product->discount_value;
            }
        }

        if ($addTax) {
            foreach ($product->taxes as $product_tax) {
                if ($product_tax->tax_type == 'percent') {
                    $price += ($price * $product_tax->tax_value) / 100;
                } elseif ($product_tax->tax_type == 'fixed') {
                    $price += $product_tax->tax_value;
                }
            }
        }

        return $price;
    }
}

    function getDiscountAmount($data)
    {
        $sumOfDiscountedPrices = 0;

        if ($data) {
            foreach ($data as $cart) {
                $price = optional($cart->product_variation)->price *$cart->qty;

                $discount_applicable = false;


                if ($cart->product->discount_start_date == null ||$cart->product->discount_end_date == null) {
                    $discount_applicable = false;
                } elseif (
                    strtotime(date('d-m-Y')) >= $cart->product->discount_start_date &&
                    strtotime(date('d-m-Y')) <= $cart->product->discount_end_date
                ) {
                    $discount_applicable = true;
                }


                if ($discount_applicable) {

                    if ($cart->product->discount_type === 'percent') {
                        $discountedPrice = ($price * $cart->product->discount_value) / 100;
                    } elseif ($cart->product->discount_type === 'fixed') {
                        $discountedPrice = $cart->product->discount_value * $cart->qty;
                    }

                    $sumOfDiscountedPrices += $discountedPrice;
                }
            }
        }

        return $sumOfDiscountedPrices;
    }


if (! function_exists('getSubTotal')) {
    // return sub total price
    function getSubTotal($carts, $couponDiscount = true, $couponCode = '', $addTax = true)
    {
        $price = 0;
        $amount = 0;
        if (count($carts) > 0) {
            foreach ($carts as $cart) {
                $product = $cart->product_variation->product;
                $variation = $cart->product_variation;

                $discountedVariationPriceWithTax = variationDiscountedPrice($product, $variation, $addTax);
                $price += (float) $discountedVariationPriceWithTax * $cart->qty;
            }
        }

        return $price - $amount;
    }
}

if (! function_exists('generateVariationOptions')) {
    //  generate combinations based on variations
    function generateVariationOptions($options)
    {
        if (count($options) == 0) {
            return $options;
        }
        $variation_ids = [];
        foreach ($options as $option) {
            $value_ids = [];
            if (isset($variation_ids[$option->variation_id])) {
                $value_ids = $variation_ids[$option->variation_id];
            }
            if (! in_array($option->variation_value_id, $value_ids)) {
                array_push($value_ids, $option->variation_value_id);
            }
            $variation_ids[$option->variation_id] = $value_ids;
        }
        $options = [];
        foreach ($variation_ids as $id => $values) {
            $variationValues = [];
            foreach ($values as $value) {
                $variationValue = \Modules\Product\Models\VariationValue::find($value);
                if($variationValue !== null){
                    $val = [
                        'id' => $value,
                        'name' => $variationValue->name,
                    ];
                    array_push($variationValues, $val);
                }
            }
            $data['id'] = $id;
            $data['name'] = \Modules\Product\Models\Variations::find($id)->name;
            $data['values'] = $variationValues;

            array_push($options, $data);
        }

        return $options;
    }
}

function getTaxamount($amount)
{
    $tax_list = \Modules\Tax\Models\Tax::where('status',1)->where('module_type','products')->get();

    $total_tax_amount = 0;
    $tax_details = [];
    $tax_amount = 0;

    foreach ($tax_list as $tax) {
        if ($tax->type == 'percentage') {
            $tax_amount = $amount * $tax->value / 100;
        } elseif ($tax->type == 'fixed') {
            $tax_amount = $tax->value;
        }

        $tax_details[] = [
            'tax_name' => $tax->title,
            'tax_type' => $tax->type,
            'tax_value' => $tax->value,
            'tax_amount' => $tax_amount,
        ];

        $total_tax_amount += $tax_amount;
    }

    return [
        'total_tax_amount' => $total_tax_amount,
        'tax_details' => $tax_details,
    ];
}

function haversineDistance($lat1, $lon1, $lat2, $lon2) {
    $radius = 6371; // Earth's radius in kilometers

    $dlat = deg2rad($lat2 - $lat1);
    $dlon = deg2rad($lon2 - $lon1);

    $a = sin($dlat / 2) * sin($dlat / 2) + cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * sin($dlon / 2) * sin($dlon / 2);
    $c = 2 * atan2(sqrt($a), sqrt(1 - $a));

    return $radius * $c;
}

function SendPushNotification($data){


    $heading = array(
        "en" => $data['title']
    );
    
    $content = array(
        "en" => $data['description']
    );

    if(isset($data['employee_id'])) {

    $user_id=$data['employee_id'];

    }else{

    $user_id=$data['user_id'];
    }

    return fcm([

        'to'=>'/topics/user_'.$user_id,
        'collapse_key' => 'type_a',
        'notification' => [
            'body' =>  $content,
            'title' => $heading ,
        ],
        
    ]);
     
}



function getNearestWalker($latitude , $longitude, $user_type){

    $Walker = \App\Models\User::select('users.*')
    ->branch()
    ->with('media', 'mainBranch')
    ->where('status', 1)
    ->where('user_type', $user_type);

     $Walker = \App\Models\User::selectRaw("id, email, latitude, longitude,user_type,
     ( 6371 * acos( cos( radians($latitude) ) *
     cos( radians( latitude ) )
     * cos( radians( longitude ) - radians($longitude)
     ) + sin( radians($latitude) ) *
     sin( radians( latitude ) ) )
     ) AS distance")
  
   ->where('latitude', '!=', null)
   ->where('longitude', '!=', null)
   ->where('user_type','walker')
   ->having("distance", "<=", 16)
   ->orderBy("distance",'asc')
   ->get();

  return $Walker ;

}


function generateCombinations($arrays, $currentIndex = 0, $currentCombination = [])
{
    if ($currentIndex == count($arrays)) {
        return [$currentCombination];
    }

    $result = [];
    foreach ($arrays[$currentIndex] as $value) {
        $nextCombination = array_merge($currentCombination, [$value]);
        $result = array_merge($result, generateCombinations($arrays, $currentIndex + 1, $nextCombination));
    }

    return $result;
}



function countUnitvalue($unit){
    switch ($unit) {
        case 'mile':
            return 3956;
            break;
        default:
            return 6371;
            break;
    }
 }

function enableMultivendor(){

    $setting_data=\App\Models\Setting::where('name','enable_multi_vendor')->first();

    return $setting_data->val ?? 0;

}
