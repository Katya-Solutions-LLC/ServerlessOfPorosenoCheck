<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ language_direction() }}" class="theme-fs-sm">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <link rel="icon" type="image/png" href="{{ asset(setting('logo')) }}">
    <link rel="apple-touch-icon" sizes="76x76" href="{{ asset(setting('favicon')) }}">
    <meta name="keyword" content="{{ setting('meta_keyword') }}">
    <meta name="description" content="{{ setting('meta_description') }}">
    <meta name="setting_options" content="{{ setting('customization_json') }}">
    <!-- Shortcut Icon -->
    <link rel="shortcut icon" href="{{ asset(setting('favicon')) }}">
    <link rel="icon" type="image/ico" href="{{ asset(setting('favicon')) }}" />

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="app_name" content="{{ app_name() }}">

    <meta name="data_table_limit" content="{{ setting('data_table_limit') }}">

    <meta name="auth_user_roles" content="{{auth()->user()->roles->pluck('name')}}">


    <title>@yield('title') | {{ app_name() }}</title>

    <link rel="stylesheet" href="{{ mix('css/icon.min.css') }}">
    @if ($isNoUISlider ?? '')
        <!-- NoUI Slider css -->
        <link rel="stylesheet" href="{{ asset('vendor/noUiSilder/style/nouislider.min.css') }}">
    @endif

    @stack('before-styles')
    <link rel="stylesheet" href="{{ mix('css/libs.min.css') }}">
    <link rel="stylesheet" href="{{ mix('css/backend.css') }}">
    <link rel="stylesheet" href="{{ asset('css/dark.css') }}">
    <link rel="stylesheet" href="{{ asset('custom-css/dashboard.css') }}">

    @if(language_direction() == 'rtl')
        <link rel="stylesheet" href="{{ asset('css/rtl.css') }}">
    @endif

    <link rel="stylesheet" href="{{ asset('css/customizer.css') }}">

    <style>
        :root{
          <?php
            $rootColors = setting('root_colors'); // Assuming the setting() function retrieves the JSON string

            // Check if the JSON string is not empty and can be decoded
            if (!empty($rootColors) && is_string($rootColors)) {
                $colors = json_decode($rootColors, true);

                // Check if decoding was successful and the colors array is not empty
                if (json_last_error() === JSON_ERROR_NONE && is_array($colors) && count($colors) > 0) {
                    foreach ($colors as $key => $value) {
                        echo $key . ': ' . $value . '; ';
                    }
                } else {
                    echo 'Invalid JSON or empty colors array.';
                }
            }
            ?>

        }
    </style>

    <!-- Scripts -->
    @php
        $currentLang = App::currentLocale();
        $langFolderPath = base_path("lang/$currentLang");
        $filePaths = \File::files($langFolderPath);
      @endphp

    @foreach ($filePaths as $filePath)
      @php
        $fileName = pathinfo($filePath, PATHINFO_FILENAME);
      @endphp
      <script>
        window.localMessagesUpdate = {
          ...window.localMessagesUpdate,
          "{{ $fileName }}": @json(require($filePath))
        }
      </script>
    @endforeach
    @php
    $role = !empty(auth()->user()) ? auth()->user()->getRoleNames() : null;

    @endphp

     @php

     $id = auth()->user()->id ?? '';
    @endphp



    <script>
        window.auth_role = @json($role)
      
    </script>

     <script>

       window.auth_id = @json($id)

    </script>
    <script>
        window.auth_permissions = @json($permissions)
    </script>
    @if(setting('is_one_signal_notification') == 1)
      <script src="https://cdn.onesignal.com/sdks/OneSignalSDK.js" defer></script>
      <script>
        window.OneSignal = window.OneSignal || [];
        OneSignal.push(function() {
          OneSignal.init({
            appId: "{{ setting('onesignal_app_id') }}",
            safari_web_id: "web.onesignal.auto.3cbb98e8-d926-4cfe-89ae-1bc86ff7cf70",
            notifyButton: {
              enable: true,
            },
            subdomainName: "apps-Pitomec",
          });
          window.OneSignal.getUserId(function (userId) {
            if(userId !== '{{ auth()->user()->web_player_id ?? '' }}' && '{{ auth()->user()->web_player_id ?? 'undefined' }}' !== 'undefined') {
                fetch("{{ route('backend.update-player-id') }}", {
                    method: 'POST',
                    headers: {
                      'Content-Type': 'application/json',
                      'Accept': 'application/json',
                      'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ player_id: userId })
                  })
                  .then((res) => res.json())
                  .then((data) => console.log(data))
              }
            })
        });
      </script>
    @endif
    <link rel="stylesheet" href="{{ asset('icomoon/style.css') }}">
    <!-- Google Font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;700&display=swap" rel="stylesheet">
    {{-- <link href="https://fonts.googleapis.com/css2?family=Lexend+Deca&display=swap" rel="stylesheet"> --}}

    @stack('after-styles')

    <x-google-analytics />

    <style>
      {!! setting('custom_css_block') !!}
    </style>
</head>

<body class="{{ !empty(getCustomizationSetting('card_style')) ? getCustomizationSetting('card_style') : '' }} {{ auth()->user()->user_setting['theme_scheme'] ?? '' }}">
    <!-- Loader Start -->
    <div id="loading">
        <x-partials._body_loader />
    </div>
    <!-- Loader End -->
    <!-- Sidebar -->
    @include('backend.includes.sidebar')

    <!-- /Sidebar -->
    <div class="main-content wrapper">
        <div class="position-relative  {{ !isset($isBanner) ? 'iq-banner' : '' }} default ">
            <!-- Header -->
            @include('backend.includes.header')
            <!-- /Header -->
            @if (!isset($isBanner))
            <!-- Header Banner Start-->
                @include('components.partials.sub-header')
            <!-- Header Banner End-->
            @endif
        </div>

        <div class="conatiner-fluid content-inner pb-0" id="page_layout">

            {{-- @include('flash::message') --}}

            <!-- Errors block -->
            {{-- @include('backend.includes.errors') --}}
            <!-- / Errors block -->
            <!-- Main content block -->
            @yield('content')
            <!-- / Main content block -->
        </div>

        <!-- Footer block -->
        @include('backend.includes.footer')
        <!-- / Footer block -->
        @hasanyrole('admin|demo_admin')
        <div class="slideouticons pr-hide">
            <label for="togglebox" class="mainlabel"><i class="icon-pet"></i></label>
            <div class="iconswrapper">
                <ul class="list-inline m-0">
                  @hasPermission('add_boarding_booking')
                    <li><a href="{{ route('backend.bookings.datatable_view', ['type' => 'new']) }}" data-bs-toggle="tooltip" data-bs-placement="right" title="New Boarding Booking"> <i class="icon icon-Boarding"></i></a></li>
                    @endhasPermission
                    @hasPermission('add_veterinary_booking')
                    <li><a href="{{ route('backend.veterinary.datatable_view', ['type' => 'new']) }}" data-bs-toggle="tooltip" data-bs-placement="right" title="New Veterinary Booking"><i class="icon icon-Veterinary"></i></a></li>
                    @endhasPermission
                    @hasPermission('add_grooming_booking')
                    <li><a href="{{ route('backend.grooming.datatable_view', ['type' => 'new']) }}" data-bs-toggle="tooltip" data-bs-placement="right" title="New Grooming Booking"><i class="icon icon-Grooming"></i></a></li>
                    @endhasPermission
                    @hasPermission('add_training_booking')
                    <li><a href="{{ route('backend.training.datatable_view', ['type' => 'new']) }}" data-bs-toggle="tooltip" data-bs-placement="right" title="New Training Booking"><i class="icon icon-Training"></i></a></li>
                    @endhasPermission
                    @hasPermission('add_walking_booking')
                    <li><a href="{{ route('backend.walking.datatable_view', ['type' => 'new']) }}" data-bs-toggle="tooltip" data-bs-placement="right" title="New Walking Booking"><i class="icon icon-Walking"></i></a></li>
                    @endhasPermission
                    @hasPermission('add_daycare_booking')
                    <li><a href="{{ route('backend.daycare.datatable_view', ['type' => 'new']) }}" data-bs-toggle="tooltip" data-bs-placement="right" title="New DayCare Booking"><i class="icon icon-icon-day-care"></i></a></li>
                   @endhasPermission
                </ul>
            </div>
        </div>
        @endhasanyrole
    </div>

    <!-- Modal -->
    <div class="modal fade" data-iq-modal="renderer" id="renderModal" tabindex="-1" aria-labelledby="renderModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content" data-iq-modal="content">
                <div class="modal-header">
                    <h5 class="modal-title" data-iq-modal="title">Modal title</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" data-iq-modal="body">
                    <p>Modal body text goes here.</p>
                </div>
            </div>
        </div>
    </div>

    @if (!isset($global_booking))
      <div data-render="global-booking">
        <booking-form booking-type="GLOBAL_BOOKING" :booking-data="{branch_id: {{ $selected_branch->id ?? 0 }}}"></booking-form>
      </div>
    @endif

    @stack('before-scripts')
    @if ($isNoUISlider ?? '')
        <!-- NoUI Slider Script -->
        <script src="{{ asset('vendor/noUiSilder/script/nouislider.min.js') }}"></script>
    @endif
    <script src="{{ mix('js/backend.js') }}"></script>
    {{-- <script src="{{ mix('js/Pitomec-script/setting.min.js') }}"></script> --}}
    <script src="{{ asset('js/Pitomec-script/utility.js')}}"></script>
    {{-- <script src="{{ asset('js/setting-init.js') }}"></script> --}}
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="{{ asset('laravel-js/modal-view.js') }}" defer></script>
    <script>
      const currencyFormat = (amount) => {
        const DEFAULT_CURRENCY = JSON.parse(@json(json_encode(Currency::getDefaultCurrency(true))))
         const noOfDecimal = DEFAULT_CURRENCY.no_of_decimal
         const decimalSeparator = DEFAULT_CURRENCY.decimal_separator
         const thousandSeparator = DEFAULT_CURRENCY.thousand_separator
         const currencyPosition = DEFAULT_CURRENCY.currency_position
         const currencySymbol = DEFAULT_CURRENCY.currency_symbol
        return formatCurrency(amount, noOfDecimal, decimalSeparator, thousandSeparator, currencyPosition, currencySymbol)
      }
      window.currencyFormat = currencyFormat
      window.defaultCurrencySymbol = @json(Currency::defaultSymbol())

    </script>
    <script src="{{ mix('js/booking-form.min.js') }}"></script>
    @if (isset($assets) && (in_array('textarea', $assets) || in_array('editor', $assets)))
        <script src="{{ asset('vendor/tinymce/js/tinymce/tinymce.min.js') }}"></script>
        <script src="{{ asset('vendor/tinymce/js/tinymce/jquery.tinymce.min.js') }}"></script>
    @endif

    @stack('after-scripts')
    <!-- / Scripts -->
    <script>

        $('.notification_list').on('click',function(){
            notificationList();
        });

        $(document).on('click','.notification_data',function(event){
            event.stopPropagation();
        })

        function notificationList(type=''){
            var url = "{{ route('notification.list') }}";
            $.ajax({
                type: 'get',
                url: url,
                data: {'type':type},
                success: function(res){
                    $('.notification_data').html(res.data);
                    getNotificationCounts();
                    if(res.type == "markas_read"){
                        notificationList();
                    }
                    $('.notify_count').removeClass('notification_tag').text('');
                }
            });
        }

        function setNotification(count){
            if(Number(count) >= 100){
                $('.notify_count').text('99+');
            }
        }
        function getNotificationCounts(){
            var url = "{{ route('notification.counts') }}";

            $.ajax({
                type: 'get',
                url: url,
                success: function(res){
                    if(res.counts > 0){
                        $('.notify_count').addClass('notification_tag').text(res.counts);
                        setNotification(res.counts);
                        $('.notification_list span.dots').addClass('d-none')
                        $('.notify_count').removeClass('d-none')
                    }else{
                        $('.notify_count').addClass('d-none')
                        $('.notification_list span.dots').removeClass('d-none')
                    }

                    if(res.counts <= 0 && res.unread_total_count > 0){
                        $('.notification_list span.dots').removeClass('d-none')
                    }else{
                        $('.notification_list span.dots').addClass('d-none')
                    }
                }
            });
        }

        getNotificationCounts();
    </script>

    <script>
      {!! setting('custom_js_block') !!}
    </script>

</body>

</html>
