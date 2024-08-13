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

    @if(auth()->check())
    <meta name="auth_user_roles" content="{{auth()->user()->roles->pluck('name')}}">
    @endif


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

    <!-- /Sidebar -->
    <div class="main-content wrapper">
        <div class="position-relative  {{ !isset($isBanner) ? 'iq-banner' : '' }} default ">
            <!-- Header -->
            <nav class="nav navbar navbar-expand-xl navbar-light iq-navbar header-hover-menu left-border {{ !empty(getCustomizationSetting('navbar_show')) ? getCustomizationSetting('navbar_show') : '' }} {{ getCustomizationSetting('header_navbar') }}">
                <div class="container-fluid navbar-inner">
                        <a href="{{route('backend.dashboard')}}" class="navbar-brand pr-hide">
                            <div class="logo-main">
                                <div class="logo-mini d-none">
                                    <img src="{{asset(setting('mini_logo'))}}" height="30" alt="{{ app_name() }}">
                                </div>
                                <div class="logo-normal">
                                    <img src="{{asset(setting('logo'))}}" height="30" alt="{{ app_name() }}">
                                    {{-- <h4 class="logo-title d-none d-sm-block">{{app_name()}}</h4> --}}
                                </div>
                            </div>
                        </a>
                        @php
                        $get_pages = \Modules\Page\Models\Page::get();
                        @endphp
                        <!-- <div class="menu">
                            <ul class="list-inline d-flex align-items-center m-0">
                                @foreach($get_pages as $page)
                                <li>{{ $page->name}}</li>
                                @endforeach
                            </ul>
                        </div> -->

                        <div class="right-data">
                            <div class="d-flex align-items-center">
                                <button id="navbar-toggle" class="navbar-toggler" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                                    aria-label="Toggle navigation">
                                    <span class="navbar-toggler-icon">
                                        <span class="navbar-toggler-bar bar1 mt-1"></span>
                                        <span class="navbar-toggler-bar bar2"></span>
                                        <span class="navbar-toggler-bar bar3"></span>
                                    </span>
                                </button>
                            </div>
                            <div class="collapse navbar-collapse header-right-panel" id="navbarSupportedContent">
                                <ul class="iq-nav-menu list-unstyled">
                                    <!-- @include(('vendor.laravel-menu.custom-menu-items'), ['items' => $horizontal_menu->roots()]) -->
                                    @foreach($get_pages as $page)
                                    <li class="nav-item"><a class="nav-link" href="{{route('pages', $page->slug)}}">{{ $page->name}}</a></li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    
                </div>
            </nav>
            <!-- /Header -->
            @if (!isset($isBanner))
            <!-- Header Banner Start-->
          
            <div class="iq-navbar-header navs-bg-color" style="height: 120px;">
                <div class="container-fluid iq-container">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="d-flex justify-content-center align-items-center flex-wrap">
                                <div class="px-4">
                                    <h2>{{ __($module_title ?? '') }}</h2>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="iq-header-img">
                </div>
            </div>

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

       
      
    </div>

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
