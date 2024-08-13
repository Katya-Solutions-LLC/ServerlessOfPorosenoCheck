@extends('backend.layouts.app', ['isBanner' => false])

@section('title')
    {{ 'Dashboard' }}
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center flex-wrap">
                        <div class="">
                            <nav class="tab-bottom-bordered border-bottom-0">
                                <div class="mb-0 nav nav-tabs" id="nav-tab" role="tablist">
                                    <button class="nav-link active d-flex align-items-center p-0" id="nav-overview-tab"
                                        data-bs-toggle="tab" data-bs-target="#nav-overview" type="button" role="tab"
                                        aria-controls="nav-overview" aria-selected="true">{{ __('dashboard.overview') }}</button>
                                    <button class="nav-link p-0 ms-5" id="nav-reports-tab" data-bs-toggle="tab"
                                        data-bs-target="#nav-reports" type="button" role="tab"
                                        aria-controls="nav-reports" aria-selected="false">{{ __('dashboard.reports') }}</button>
                                    <button class="nav-link  p-0 ms-5" id="nav-appointments-tab" data-bs-toggle="tab"
                                        data-bs-target="#nav-appointments" type="button" role="tab"
                                        aria-controls="nav-appointments" aria-selected="false">{{ __('dashboard.bookings') }}</button>
                                </div>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
            <div class="tab-content iq-tab-fade-up" id="nav-tab-content">
                <div class="tab-pane fade show active" id="nav-overview" role="tabpanel" aria-labelledby="nav-overview-tab">
                    <div class="row">
                        <div class="col-xl-8">
                            <div class="row">
                                <div class="col-sm-6 col-xxl-3 col-xl-6">
                                    <div class="card">
                                        <div class="card-body">
                                            <svg width="48" height="48" viewBox="0 0 48 48" fill="none"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <path fill-rule="evenodd" clip-rule="evenodd"
                                                    d="M31.2417 18.8096C31.8425 19.4104 31.8425 20.3845 31.2417 20.9853L23.0366 29.1904C22.4358 29.7912 21.4617 29.7912 20.8609 29.1904L16.7583 25.0879C16.1575 24.4871 16.1575 23.513 16.7583 22.9121C17.3591 22.3113 18.3332 22.3113 18.934 22.9121L21.9487 25.9269L29.066 18.8096C29.6668 18.2088 30.6409 18.2088 31.2417 18.8096Z"
                                                    fill="#9D67EF" />
                                                <path fill-rule="evenodd" clip-rule="evenodd"
                                                    d="M24 7.07692C14.6536 7.07692 7.07692 14.6536 7.07692 24C7.07692 33.3464 14.6536 40.9231 24 40.9231C33.3464 40.9231 40.9231 33.3464 40.9231 24C40.9231 14.6536 33.3464 7.07692 24 7.07692ZM4 24C4 12.9543 12.9543 4 24 4C35.0457 4 44 12.9543 44 24C44 35.0457 35.0457 44 24 44C12.9543 44 4 35.0457 4 24Z"
                                                    fill="#9D67EF" />
                                            </svg>
                                            <p class="mt-5 mb-2">{{ __('dashboard.completed_services') }}</p>
                                            <h3 class="mb-0">{{ $data['completeBookingsCount'] }}</h3>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-xxl-3 col-xl-6">
                                    <div class="card">
                                        <div class="card-body">
                                            <svg width="48" height="48" viewBox="0 0 48 48" fill="none"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <path fill-rule="evenodd" clip-rule="evenodd"
                                                    d="M24 7.07692C14.6536 7.07692 7.07692 14.6536 7.07692 24C7.07692 33.3464 14.6536 40.9231 24 40.9231C33.3464 40.9231 40.9231 33.3464 40.9231 24C40.9231 14.6536 33.3464 7.07692 24 7.07692ZM4 24C4 12.9543 12.9543 4 24 4C35.0457 4 44 12.9543 44 24C44 35.0457 35.0457 44 24 44C12.9543 44 4 35.0457 4 24Z"
                                                    fill="#9D67EF" />
                                                <path fill-rule="evenodd" clip-rule="evenodd"
                                                    d="M18.8096 18.8096C19.4104 18.2088 20.3845 18.2088 20.9853 18.8096L24 21.8243L27.0147 18.8096C27.6155 18.2088 28.5896 18.2088 29.1904 18.8096C29.7912 19.4104 29.7912 20.3845 29.1904 20.9853L26.1757 24L29.1904 27.0147C29.7912 27.6155 29.7912 28.5896 29.1904 29.1904C28.5896 29.7912 27.6155 29.7912 27.0147 29.1904L24 26.1757L20.9853 29.1904C20.3845 29.7912 19.4104 29.7912 18.8096 29.1904C18.2088 28.5896 18.2088 27.6155 18.8096 27.0147L21.8243 24L18.8096 20.9853C18.2088 20.3845 18.2088 19.4104 18.8096 18.8096Z"
                                                    fill="#9D67EF" />
                                            </svg>
                                            <p class="mt-5 mb-2">{{ __('dashboard.incomplete_services') }}</p>
                                            <h3 class="mb-0">{{ $data['pendingBookingsCount'] }}</h3>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-xxl-3 col-xl-6">
                                    <div class="card">
                                        <div class="card-body">
                                            <svg width="48" height="48" viewBox="0 0 48 48" fill="none"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M24 3C19.8466 3 15.7865 4.23163 12.333 6.53914C8.8796 8.84665 6.18798 12.1264 4.59854 15.9636C3.0091 19.8009 2.59323 24.0233 3.40352 28.0969C4.21381 32.1705 6.21386 35.9123 9.15077 38.8492C12.0877 41.7861 15.8295 43.7862 19.9031 44.5965C23.9767 45.4068 28.1991 44.9909 32.0364 43.4015C35.8736 41.812 39.1534 39.1204 41.4609 35.667C43.7684 32.2135 45 28.1534 45 24C45 18.4305 42.7875 13.089 38.8493 9.15076C34.911 5.21249 29.5696 3 24 3ZM24 42C20.4399 42 16.9598 40.9443 13.9997 38.9665C11.0397 36.9886 8.73256 34.1774 7.37018 30.8883C6.0078 27.5992 5.65134 23.98 6.34587 20.4884C7.04041 16.9967 8.75474 13.7894 11.2721 11.2721C13.7894 8.75473 16.9967 7.0404 20.4884 6.34586C23.98 5.65133 27.5992 6.00779 30.8883 7.37017C34.1774 8.73255 36.9886 11.0397 38.9665 13.9997C40.9443 16.9598 42 20.4399 42 24C42 28.7739 40.1036 33.3523 36.7279 36.7279C33.3523 40.1036 28.7739 42 24 42ZM30 27C30 28.1935 29.5259 29.3381 28.682 30.182C27.8381 31.0259 26.6935 31.5 25.5 31.5V34.5H22.5V31.5H19.5V28.5H25.5C25.8978 28.5 26.2794 28.342 26.5607 28.0607C26.842 27.7794 27 27.3978 27 27C27 26.6022 26.842 26.2206 26.5607 25.9393C26.2794 25.658 25.8978 25.5 25.5 25.5H22.5C21.3065 25.5 20.1619 25.0259 19.318 24.182C18.4741 23.3381 18 22.1935 18 21C18 19.8065 18.4741 18.6619 19.318 17.818C20.1619 16.9741 21.3065 16.5 22.5 16.5V13.5H25.5V16.5H28.5V19.5H22.5C22.1022 19.5 21.7207 19.658 21.4394 19.9393C21.158 20.2206 21 20.6022 21 21C21 21.3978 21.158 21.7794 21.4394 22.0607C21.7207 22.342 22.1022 22.5 22.5 22.5H25.5C26.6935 22.5 27.8381 22.9741 28.682 23.818C29.5259 24.6619 30 25.8065 30 27Z"
                                                    fill="#9D67EF" />
                                            </svg>
                                            <p class="mt-5 mb-2">{{ __('dashboard.revenue_of_services') }}</p>
                                            <h3 class="mb-0">{{ Currency::format($data['total_amount']) }}</h3>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-xxl-3 col-xl-6">
                                    <div class="card">
                                        <div class="card-body">
                                            <svg width="48" height="48" viewBox="0 0 48 48" fill="none"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <path fill-rule="evenodd" clip-rule="evenodd"
                                                    d="M28.6953 13.3183C28.7538 13.2622 28.8063 13.2482 28.8699 13.2567C30.9622 13.5374 32.9715 14.2925 34.7402 15.4743C37.0244 17.0005 38.8047 19.1699 39.856 21.7079C40.9073 24.246 41.1824 27.0388 40.6465 29.7332C40.1105 32.4276 38.7876 34.9025 36.8451 36.8451C34.9025 38.7876 32.4276 40.1105 29.7332 40.6464C27.0388 41.1824 24.246 40.9073 21.7079 39.856C19.1699 38.8047 17.0006 37.0244 15.4743 34.7402C14.2925 32.9715 13.5374 30.9622 13.2567 28.8699C13.2482 28.8063 13.2622 28.7538 13.3183 28.6953C13.3833 28.6276 13.4986 28.5667 13.6479 28.5667H24.9656C26.9544 28.5667 28.5667 26.9544 28.5667 24.9656L28.5667 13.6479C28.5667 13.4986 28.6275 13.3833 28.6953 13.3183ZM29.2802 10.1975C27.0888 9.90352 25.48 11.724 25.48 13.6479L25.4801 24.9656C25.4801 25.2497 25.2497 25.4801 24.9656 25.4801H13.6479C11.724 25.4801 9.90352 27.0889 10.1975 29.2803C10.5405 31.8375 11.4634 34.2933 12.9079 36.4551C14.7733 39.2469 17.4247 41.4228 20.5267 42.7077C23.6288 43.9926 27.0422 44.3288 30.3354 43.6738C33.6285 43.0187 36.6535 41.4019 39.0277 39.0276C41.4019 36.6534 43.0188 33.6285 43.6738 30.3353C44.3288 27.0422 43.9926 23.6288 42.7077 20.5267C41.4228 17.4246 39.2468 14.7732 36.4551 12.9078C34.2933 11.4634 31.8374 10.5405 29.2802 10.1975Z"
                                                    fill="#9D67EF" />
                                                <path fill-rule="evenodd" clip-rule="evenodd"
                                                    d="M7.09612 18.0712C7.09019 18.0537 7.08544 18.0293 7.0911 17.99C7.48433 15.256 8.751 12.7031 10.727 10.727C12.7031 8.751 15.256 7.48433 17.99 7.0911C18.0293 7.08544 18.0537 7.09019 18.0712 7.09612C18.0914 7.10295 18.1195 7.11751 18.1508 7.14744C18.2167 7.21047 18.2779 7.32499 18.2779 7.47457L18.2779 17.7634C18.2779 18.0475 18.0475 18.2779 17.7634 18.2779H7.47457C7.32499 18.2779 7.21047 18.2167 7.14744 18.1508C7.11751 18.1195 7.10295 18.0914 7.09612 18.0712ZM4.03588 17.5506C3.71875 19.7555 5.5562 21.3645 7.47457 21.3645H17.7634C19.7523 21.3645 21.3645 19.7523 21.3645 17.7634V7.47457C21.3645 5.5562 19.7555 3.71875 17.5506 4.03588C14.1605 4.52349 10.9948 6.09406 8.54445 8.54445C6.09406 10.9948 4.52349 14.1605 4.03588 17.5506Z"
                                                    fill="#9D67EF" />
                                            </svg>
                                            <p class="mt-5 mb-2">{{ __('dashboard.profit_of_services') }}</p>
                                            <h3 class="mb-0">{{ Currency::format($data['profit']) }}</h3>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="card card-block card-stretch card-height">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between align-items-center flex-wrap mb-4">
                                            <h5 class="card-title mb-0">{{ __('dashboard.monthly_revenue') }}</h5>
                                            {{-- <div class="dropdown">
                                                <a href="#" class="btn btn-primary dropdown-toggle monthly_revenue"
                                                    id="dropdownMenuButton3" data-bs-toggle="dropdown"
                                                    aria-expanded="false">
                                                    Year
                                                </a>
                                                <ul class="dropdown-menu dropdown-menu-end"
                                                    aria-labelledby="dropdownMenuButton3" style="">
                                                    <li><a class="dropdown-item" onclick="revanue_chart('week')">This
                                                            Week</a></li>
                                                    <li><a class="dropdown-item" onclick="revanue_chart('month')">This
                                                            Month</a></li>
                                                    <li><a class="dropdown-item" onclick="revanue_chart('year')">This
                                                            Year</a></li>
                                                </ul>
                                            </div> --}}
                                        </div>

                                        <div id="loader" style="display: none;">
                                            processing.....
                                        </div>
                                        <div id="chart-01"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-4">
                            <div class="card">
                                <div class="card-body ">
                                    <div class="d-flex justify-content-between align-items-center mb-4">
                                        <h5 class="card-title mb-0">{{ __('dashboard.recently_booking') }}</h5>
                                        <a href="{{ route('backend.booking.datatable_view') }}" class="">{{ __('dashboard.view_all') }}</a>
                                    </div>
                                    <ul class="list-unstyled mb-0">
                                        @foreach ($data['recent_booking'] as $recent_booking)
                                            <li class="d-flex align-items-center py-3 border-bottom">
                                                <img src="{{ $recent_booking->user->profile_image ?? default_user_avatar() }}"
                                                    alt="01" class="rounded-pill avatar avatar-50" loading="lazy">
                                                <div class="ms-3 w-100">
                                                    <div class="d-flex align-items-center justify-content-between">
                                                        <h6 class="mb-2"><a
                                                                href="{{ route('backend.bookings.bookingShow', ['id' => $recent_booking->id]) }}">#{{ $recent_booking->id }}</a>
                                                        </h6>
                                                        @if ($recent_booking->status == 'completed')
                                                            <small class="text-success">{{ __('dashboard.complete') }}</small>
                                                        @elseif($recent_booking->status == 'rejected')
                                                            <small class="text-danger">{{ __('dashboard.rejected') }}</small>
                                                        @elseif($recent_booking->status == 'pending')
                                                            <small class="text-warning">{{ __('dashboard.pending') }}</small>
                                                        @elseif($recent_booking->status == 'confirmed')
                                                            <small class="text-primary">{{ __('dashboard.accepted') }}</small>
                                                        @else
                                                            <small class="text-if">{{ __('dashboard.cancelled') }}</small>
                                                        @endif

                                                    </div>

                                                    <small>
                                                        {{ date('F j, Y', strtotime($recent_booking->start_date_time)) }} |
                                                        {{ date('h:i A', strtotime($recent_booking->start_date_time)) }}
                                                    </small>
                                                </div>
                                            </li>
                                        @endforeach

                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="card card-block card-stretch card-height">
                                <div class=" card-header">
                                    <h5 class="card-title mb-0">{{ __('dashboard.top_products') }} </h5>
                                </div>
                                <div class="card-body">
                                    <div class="row justify-content-between">
                                        <div id="chart-02" class="col-md-7 col-lg-7"></div>
                                        <div class="col-md-5 col-lg-5">
                                        @php
                                        $legendColors = ['#9D67EF', '#CEADFF', '#E6D6FF', '#F0F0F0','#CEADFF','#9D67EF'];
                                        $colorIndex = 0;
                                        @endphp   
                                        @foreach ($data['top_product'] as $topproduct)
                                            <div class="d-flex align-items-center mb-4">

                                                <svg width="12" height="12" viewBox="0 0 12 12" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <circle cx="6" cy="6" r="6" fill="{{ $legendColors[$colorIndex % count($legendColors)] }}" />
                                                </svg>
                                                <div class="ms-2 d-flex align-items-center">
                                                
                                                   <h6 class="mb-0">{{ number_format($topproduct->total_sale_count * 100 /$data['total_sale_product'],2) }}%</h6> <small class="ms-2"> {{$topproduct->name}}</small>
                                             
                                                </div>
                                          
                                            </div>
                                            @php

                                        $colorIndex++;
                                        @endphp
                                        @endforeach   
                                           
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="card card-block card-stretch card-height">
                                <div class="card-header">
                                    <h5 class="card-title mb-0">{{ __('dashboard.popular_employees') }} </h5>
                                </div>
                                <div class="card-body ">
                                    <ul class="list-unstyled mb-0">
                                        @foreach ($data['popular_employee'] as $employee)
                                            <li class="d-flex align-items-center mb-4">
                                                <img src="{{ $employee->profile_image ?? default_user_avatar() }}"
                                                    alt="01" class="rounded-pill avatar avatar-50" loading="lazy">
                                                <div
                                                    class="ms-3 w-100 d-flex align-items-center justify-content-between flex-wrap">
                                                    <div class="">
                                                        <h6 class="mb-1">{{ $employee->full_name }}</h6>
                                                        <small>{{ $employee->employee_booking_count }} {{ __('dashboard.comstomer_served') }}</small>
                                                    </div>
                                                    <small class="text-primary">{{ __('dashboard.since') }}
                                                        {{ date('Y', strtotime($employee->created_at)) }}</small>
                                            </li>
                                        @endforeach

                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="nav-reports" role="tabpanel" aria-labelledby="nav-reports-tab">
                    <div class="row">
                        <div class="col-xl-12">
                            <div class="card card-block card-stretch card-height">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-center flex-wrap mb-4">
                                        <h5 class="card-title mb-0">{{ __('dashboard.profit_graph') }}</h5>
                                        <div class="d-flex align-items-center mt-md-0 mt-3">
                                           
                                           <div class="dropdown">
                                            <a href="#" class="btn btn-primary dropdown-toggle monthly_booking profit_chart"
                                                id="dropdownMenuButton5" data-bs-toggle="dropdown" aria-expanded="false">
                                                {{ __('dashboard.year') }}
                                            </a>
                                            <ul class="dropdown-menu dropdown-menu-end"
                                                aria-labelledby="dropdownMenuButton5" style="">
                                                <li><a class="dropdown-item" onclick="getprofitChartData('week')">{{ __('dashboard.this') }} {{ __('dashboard.week') }}</a></li>
                                                <li><a class="dropdown-item" onclick="getprofitChartData('month')">{{ __('dashboard.this') }} {{ __('dashboard.month') }}</a></li>
                                                <li><a class="dropdown-item" onclick="getprofitChartData('year')">{{ __('dashboard.this') }} {{ __('dashboard.year') }}</a></li>
                                            </ul>
                                        </div>
                                         
                                        </div>
                                    </div>
                                    
                                    <div id="booking_loader" style="display: none;">
                                            processing.....
                                        </div>
                                    
                                    <div id="chart-03"></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-6 col-lg-12">
                            <div class="card card-block card-stretch card-height">
                                <div class="card-header d-flex justify-content-between align-items-center">
                                    <h5 class="card-title mb-0">{{ __('dashboard.customers_review') }} </h5>
                                </div>
                                <div class="card-body">
                                    <div class="d-flex  align-items-center">
                                        <div>

                                            @php
                                                
                                                $integerPart = floor($data['averageRating']);
                                                $decimalPart = $data['averageRating'] - $integerPart;
                                                
                                            @endphp

                                            @for ($i = 1; $i <= $integerPart; $i++)
                                                <svg width="14" height="15" viewBox="0 0 14 15" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <path
                                                        d="M7.68341 0.952137L9.24195 4.24897C9.35677 4.48783 9.57592 4.6537 9.82867 4.69056L13.3294 5.22726C13.5339 5.25748 13.7194 5.37102 13.8447 5.54426C13.9687 5.7153 14.0219 5.93204 13.9918 6.14509C13.9673 6.32202 13.8881 6.48569 13.767 6.61101L11.2304 9.19938C11.0448 9.38 10.9608 9.64761 11.0056 9.90932L11.6302 13.5482C11.6967 13.9876 11.4201 14.4019 11.0056 14.4852C10.8348 14.514 10.6597 14.4838 10.5057 14.4012L7.38305 12.6886C7.1513 12.5655 6.87754 12.5655 6.64579 12.6886L3.52312 14.4012C3.13944 14.6157 2.66403 14.4697 2.45049 14.0716C2.37137 13.9131 2.34336 13.7325 2.36927 13.5563L2.9938 9.91669C3.03861 9.65572 2.9539 9.38664 2.76906 9.20602L0.232412 6.61912C-0.0693531 6.31244 -0.078455 5.80745 0.212107 5.48971C0.218409 5.48307 0.22541 5.4757 0.232412 5.46833C0.352838 5.33931 0.511072 5.25748 0.681908 5.2361L4.18266 4.69867C4.43471 4.66108 4.65386 4.49668 4.76939 4.25634L6.27191 0.952137C6.40564 0.669045 6.6829 0.492851 6.98396 0.500223H7.07778C7.33894 0.533397 7.56649 0.703695 7.68341 0.952137Z"
                                                        fill="#FFD566" />
                                                </svg>
                                            @endfor

                                            @if ($decimalPart > 0)
                                                <svg width="14" height="15" viewBox="0 0 14 15" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <path
                                                        d="M7.68341 0.952137L9.24195 4.24897C9.35677 4.48783 9.57592 4.6537 9.82867 4.69056L13.3294 5.22726C13.5339 5.25748 13.7194 5.37102 13.8447 5.54426C13.9687 5.7153 14.0219 5.93204 13.9918 6.14509C13.9673 6.32202 13.8881 6.48569 13.767 6.61101L11.2304 9.19938C11.0448 9.38 10.9608 9.64761 11.0056 9.90932L11.6302 13.5482C11.6967 13.9876 11.4201 14.4019 11.0056 14.4852C10.8348 14.514 10.6597 14.4838 10.5057 14.4012L7.38305 12.6886C7.1513 12.5655 6.87754 12.5655 6.64579 12.6886L3.52312 14.4012C3.13944 14.6157 2.66403 14.4697 2.45049 14.0716C2.37137 13.9131 2.34336 13.7325 2.36927 13.5563L2.9938 9.91669C3.03861 9.65572 2.9539 9.38664 2.76906 9.20602L0.232412 6.61912C-0.0693531 6.31244 -0.078455 5.80745 0.212107 5.48971C0.218409 5.48307 0.22541 5.4757 0.232412 5.46833C0.352838 5.33931 0.511072 5.25748 0.681908 5.2361L4.18266 4.69867C4.43471 4.66108 4.65386 4.49668 4.76939 4.25634L6.27191 0.952137C6.40564 0.669045 6.6829 0.492851 6.98396 0.500223H7.07778C7.33894 0.533397 7.56649 0.703695 7.68341 0.952137Z"
                                                        fill="#C0C2D4" />
                                                </svg>
                                            @else
                                                @for ($i = 1; $i <= 5 - $integerPart; $i++)
                                                    <svg width="14" height="15" viewBox="0 0 14 15"
                                                        fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <path
                                                            d="M7.68341 0.952137L9.24195 4.24897C9.35677 4.48783 9.57592 4.6537 9.82867 4.69056L13.3294 5.22726C13.5339 5.25748 13.7194 5.37102 13.8447 5.54426C13.9687 5.7153 14.0219 5.93204 13.9918 6.14509C13.9673 6.32202 13.8881 6.48569 13.767 6.61101L11.2304 9.19938C11.0448 9.38 10.9608 9.64761 11.0056 9.90932L11.6302 13.5482C11.6967 13.9876 11.4201 14.4019 11.0056 14.4852C10.8348 14.514 10.6597 14.4838 10.5057 14.4012L7.38305 12.6886C7.1513 12.5655 6.87754 12.5655 6.64579 12.6886L3.52312 14.4012C3.13944 14.6157 2.66403 14.4697 2.45049 14.0716C2.37137 13.9131 2.34336 13.7325 2.36927 13.5563L2.9938 9.91669C3.03861 9.65572 2.9539 9.38664 2.76906 9.20602L0.232412 6.61912C-0.0693531 6.31244 -0.078455 5.80745 0.212107 5.48971C0.218409 5.48307 0.22541 5.4757 0.232412 5.46833C0.352838 5.33931 0.511072 5.25748 0.681908 5.2361L4.18266 4.69867C4.43471 4.66108 4.65386 4.49668 4.76939 4.25634L6.27191 0.952137C6.40564 0.669045 6.6829 0.492851 6.98396 0.500223H7.07778C7.33894 0.533397 7.56649 0.703695 7.68341 0.952137Z"
                                                            fill="#C0C2D4" />
                                                    </svg>
                                                @endfor
                                            @endif
                                        </div>
                                    </div>
                                    <p class="mb-5 mt-2">{{ __('dashboard.overall_rating') }} {{ $data['totalCustomer'] }} {{ __('dashboard.customers') }}</p>



                                    <div class="mb-4 row align-items-center">
                                        <div class="col-md-3 col-lg-3 col-xl-12 col-xxl-3">
                                            <h6 class="mb-0">{{ __('dashboard.excellent') }}</h6>
                                        </div>
                                        <div class="col-md-8 col-lg-8 col-xl-10 col-xxl-8">
                                            <div class="shadow-none progress bg-soft-success w-100 my-2"
                                                style="height: 12px">
                                                <div class="progress-bar bg-success"
                                                    style="width: {{ $data['reviews']->where('rating', 5.0)->count('rating') }}%"
                                                    role="progressbar" aria-valuenow="10" aria-valuemin="0"
                                                    aria-valuemax="70"></div>
                                            </div>
                                        </div>
                                        <div class="col-md-1 col-lg-1 col-xl-2 col-xxl-1">
                                            <h6 class="float-end mb-0">
                                                {{ $data['reviews']->where('rating', '5.0')->count('rating') }}</h6>
                                        </div>
                                    </div>
                                    <div class="mb-4 row align-items-center">
                                        <div class="col-md-3 col-lg-3 col-xl-12 col-xxl-3">
                                            <h6 class="mb-0">{{ __('dashboard.good') }}</h6>
                                        </div>
                                        <div class="col-md-8 col-lg-8 col-xl-10 col-xxl-8">
                                            <div class="shadow-none progress bg-soft-danger w-100 my-2"
                                                style="height: 12px">
                                                <div class="progress-bar bg-danger"
                                                    style="width:{{ $data['reviews']->where('rating', '>=', 4)->where('rating', '<', 5)->count() }}%"
                                                    role="progressbar" aria-valuenow="30" aria-valuemin="0"
                                                    aria-valuemax="100"></div>
                                            </div>
                                        </div>
                                        <div class="col-md-1 col-lg-1 col-xl-2 col-xxl-1">
                                            <h6 class="float-end mb-0">
                                                {{ $data['reviews']->where('rating', '>=', 4)->where('rating', '<', 5)->count() }}
                                            </h6>
                                        </div>
                                    </div>
                                    <div class="mb-4 row align-items-center">
                                        <div class="col-md-3 col-lg-3 col-xl-12 col-xxl-3">
                                            <h6 class="mb-0">{{ __('dashboard.average') }}</h6>
                                        </div>
                                        <div class="col-md-8 col-lg-8 col-xl-10 col-xxl-8">
                                            <div class="shadow-none progress bg-soft-warning w-100 my-2"
                                                style="height: 12px">
                                                <div class="progress-bar bg-warning"
                                                    style="width:{{ $data['reviews']->where('rating', '>=', 3)->where('rating', '<', 4)->count() }}%"
                                                    role="progressbar" aria-valuenow="30" aria-valuemin="0"
                                                    aria-valuemax="100"></div>
                                            </div>
                                        </div>
                                        <div class="col-md-1 col-lg-1 col-xl-2 col-xxl-1">
                                            <h6 class="float-end mb-0">
                                                {{ $data['reviews']->where('rating', '>=', 3)->where('rating', '<', 4)->count() }}
                                            </h6>
                                        </div>
                                    </div>
                                    <div class="mb-4 row align-items-center">
                                        <div class="col-md-3 col-lg-3 col-xl-12 col-xxl-3">
                                            <h6 class="mb-0">{{ __('dashboard.avg_below') }}</h6>
                                        </div>
                                        <div class="col-md-8 col-lg-8 col-xl-10 col-xxl-8">
                                            <div class="shadow-none progress bg-soft-info w-100 my-2"
                                                style="height: 12px">
                                                <div class="progress-bar bg-info"
                                                    style="width:{{ $data['reviews']->where('rating', '>=', 2)->where('rating', '<', 3)->count() }}%"
                                                    role="progressbar" aria-valuenow="30" aria-valuemin="0"
                                                    aria-valuemax="100"></div>
                                            </div>
                                        </div>
                                        <div class="col-md-1 col-lg-1 col-xl-2 col-xxl-1">
                                            <h6 class="float-end mb-0">
                                                {{ $data['reviews']->where('rating', '>=', 2)->where('rating', '<', 3)->count() }}
                                            </h6>
                                        </div>
                                    </div>
                                    <div class="row align-items-center">
                                        <div class="col-md-3 col-lg-3 col-xl-12 col-xxl-3">
                                            <h6 class="mb-0">{{ __('dashboard.poor') }}</h6>
                                        </div>
                                        <div class="col-md-8 col-lg-8 col-xl-10 col-xxl-8">
                                            <div class="shadow-none progress bg-soft-primary w-100 mt-2"
                                                style="height: 12px">
                                                <div class="progress-bar bg-primary"
                                                    style="width:{{ $data['reviews']->where('rating', '>=', 1)->where('rating', '<', 2)->count() }}%"
                                                    role="progressbar" aria-valuenow="4" aria-valuemin="0"
                                                    aria-valuemax="100"></div>
                                            </div>
                                        </div>
                                        <div class="col-md-1 col-lg-1 col-xl-2 col-xxl-1">
                                            <h6 class="float-end mb-0">
                                                {{ $data['reviews']->where('rating', '>=', 1)->where('rating', '<', 2)->count() }}
                                            </h6>
                                        </div>
                                    </div>



                                </div>
                            </div>
                        </div>
                        <div class="col-xl-6 col-lg-12">
                            <div class="card card-block card-stretch card-height">
                                <div class="card-header d-flex justify-content-between align-items-center">
                                    <h5 class="card-title mb-0">{{ __('dashboard.top') }} {{ __('dashboard.customers') }}</h5>
                                    <a href="{{ route('backend.pets.index') }}" class="text-primary"><u>{{ __('dashboard.view_all') }}</u></a>
                                </div>
                                <div class="card-body">
                                    <ul class="list-unstyled mb-0">
                                        @foreach ($data['popular_customers'] as $customer)
                                            <li class="d-flex align-items-center py-3 border-bottom">
                                                <img src="{{ $customer->profile_image ?? default_user_avatar() }}"
                                                    alt="01" class="rounded-pill avatar avatar-50" loading="lazy">
                                                <div class="ms-3">
                                                    <h6 class="mb-0">{{ $customer->full_name }}</h6>
                                                    <small>{{ $customer->booking_count }} {{ __('dashboard.visit_time') }}</small>
                                                </div>
                                            </li>
                                        @endforeach

                                    </ul>
                                </div>
                            </div>
                        </div>
                        {{-- <div class="col-xl-4 col-lg-6">
                            <div class="card card-block card-stretch card-height">
                                <div class="card-header d-flex justify-content-between align-items-center">
                                    <h5 class="card-title mb-0">Best Selling Products</h5>
                                    <a href="#" class="text-primary"><u>View All</u></a>
                                </div>
                                <div class="card-body">
                                    <ul class="list-unstyled mb-0">
                                        <li class="d-flex align-items-center py-3 border-bottom">
                                            <img src="{{ $booking->user->profile_image ?? default_user_avatar() }}"
                                                alt="01" class="rounded-pill avatar avatar-50" loading="lazy">
                                            <div class="ms-3">
                                                <h6 class="mb-0">Rubber Toys</h6>
                                                <small>36 Sold Till Now</small>
                                            </div>
                                        </li>
                                        <li class="d-flex align-items-center py-3 border-bottom">
                                            <img src="{{ $booking->user->profile_image ?? default_user_avatar() }}"
                                                alt="01" class="rounded-pill avatar avatar-50" loading="lazy">
                                            <div class="ms-3">
                                                <h6 class="mb-0">Toothbrush Toys</h6>
                                                <small>36 Sold Till Now</small>
                                            </div>
                                        </li>
                                        <li class="d-flex align-items-center py-3 border-bottom">
                                            <img src="{{ $booking->user->profile_image ?? default_user_avatar() }}"
                                                alt="01" class="rounded-pill avatar avatar-50" loading="lazy">
                                            <div class="ms-3">
                                                <h6 class="mb-0">Colorful Puzzle Balls</h6>
                                                <small>36 Sold Till Now</small>
                                            </div>
                                        </li>
                                        <li class="d-flex align-items-center pt-3">
                                            <img src="{{ $booking->user->profile_image ?? default_user_avatar() }}"
                                                alt="01" class="rounded-pill avatar avatar-50" loading="lazy">
                                            <div class="ms-3">
                                                <h6 class="mb-0">Rubber Bone</h6>
                                                <small>36 Sold Till Now</small>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div> --}}
                    </div>
                </div>

                <div class="tab-pane fade" id="nav-appointments" role="tabpanel" aria-labelledby="nav-appointments-tab">
                    <div class="row">
                        <div class="col-xl-12">
                            <div class="card card-block card-stretch card-height">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-center flex-wrap mb-4">
                                        <h5 class="card-title mb-0">{{ __('dashboard.total_bookings') }}</h5>
                                        <div class="dropdown">
                                            <a href="#" class="btn btn-primary dropdown-toggle monthly_booking"
                                                id="dropdownMenuButton5" data-bs-toggle="dropdown" aria-expanded="false">
                                                {{ __('dashboard.year') }}
                                            </a>
                                            <ul class="dropdown-menu dropdown-menu-end"
                                                aria-labelledby="dropdownMenuButton5" style="">
                                                <li><a class="dropdown-item" onclick="getBookingChartData('week')">{{ __('dashboard.this') }} {{ __('dashboard.week') }}</a></li>
                                                <li><a class="dropdown-item" onclick="getBookingChartData('month')">{{ __('dashboard.this') }} {{ __('dashboard.month') }}</a></li>
                                                <li><a class="dropdown-item" onclick="getBookingChartData('year')">{{ __('dashboard.this') }} {{ __('dashboard.year') }}</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                     <div id="booking_loader" style="display: none;">
                                            processing.....
                                        </div>
                                    <div id="chart-04"></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-4 col-lg-6">
                            <div class="card card-block card-stretch card-height">
                                <div class="card-header d-flex justify-content-between align-items-center">
                                    <h5 class="card-title mb-0">{{ __('dashboard.bookings') }}</h5>
                                    <div class="dropdown">
                                        <a href="#" class="btn btn-primary dropdown-toggle booking_status"
                                            id="dropdownMenuButton6" data-bs-toggle="dropdown" aria-expanded="false">
                                            {{ __('dashboard.year') }}
                                        </a>
                                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton6"
                                            style="">
                                            <li><a class="dropdown-item" onclick="getBookingstatusData('week')">{{ __('dashboard.this') }} {{ __('dashboard.week') }}</a></li>
                                            <li><a class="dropdown-item" onclick="getBookingstatusData('month')">{{ __('dashboard.this') }} {{ __('dashboard.month') }}</a></li>
                                            <li><a class="dropdown-item" onclick="getBookingstatusData('year')">{{ __('dashboard.this') }} {{ __('dashboard.year') }}</a></li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="row justify-content-between">
                                        <div id="chart-05" class="col-md-6 col-lg-12 col-xxl-6"></div>
                                        <div class="col-md-6 col-lg-12 col-xxl-6">
                                      
                                            <div class="d-flex align-items-center mb-4">
                                            
                                                <svg width="12" height="12" viewBox="0 0 12 12" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <circle cx="6" cy="6" r="6"
                                                        fill="#9D67EF" />
                                                </svg>
                                                <strong><div id="booking_count_0" class="m-1"></div></strong>
                                                <small class="mb-0 ms-2">{{ __('dashboard.pending') }} {{ __('dashboard.bookings') }} </small>
                                            </div>
                                            <div class="d-flex align-items-center mb-4">
                                            
                                                <svg width="12" height="12" viewBox="0 0 12 12" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <circle cx="6" cy="6" r="6"
                                                        fill="#CEADFF" />
                                                </svg>
                                                  <strong><div id="booking_count_1" class="m-1"></div></strong>
                                                <small class="mb-0 ms-2"> {{ __('dashboard.confirmed') }} {{ __('dashboard.bookings') }}</small>
                                            </div>
                                            <div class="d-flex align-items-center mb-4">
                                            
                                                <svg width="12" height="12" viewBox="0 0 12 12" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <circle cx="6" cy="6" r="6"
                                                        fill="#E6D6FF" />
                                                </svg>
                                                  <strong><div id="booking_count_2" class="m-1"></div></strong>
                                                <small class="mb-0 ms-2"> {{ __('dashboard.cancelled') }} {{ __('dashboard.bookings') }}</small>
                                            </div>
                                            <div class="d-flex align-items-center mb-4">
                                           
                                                <svg width="12" height="12" viewBox="0 0 12 12" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <circle cx="6" cy="6" r="6"
                                                        fill="#F0F0F0" />
                                                </svg>
                                                  <strong><div id="booking_count_3" class="m-1"></div></strong>
                                                <small class="mb-0 ms-2">{{ __('dashboard.rejected') }} {{ __('dashboard.bookings') }}</small>
                                            </div>
                                            <div class="d-flex align-items-center">
                                            
                                                <svg width="12" height="12" viewBox="0 0 12 12" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <circle cx="6" cy="6" r="6"
                                                        fill="#ECE0FF" />
                                                </svg>
                                                  <strong><div id="booking_count_4" class="m-1"></div></strong>
                                                <small class="mb-0 ms-2">{{ __('dashboard.complete') }} {{ __('dashboard.bookings') }}</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-4 col-lg-6">
                            <div class="card card-block card-stretch card-height">
                                <div class="card-header d-flex justify-content-between align-items-center">
                                    <h5 class="card-title mb-0">{{ __('dashboard.best_doctors') }}</h5>
                                    <a href="{{ route('backend.employees.index', ['employee_type' => 'vet']) }}"
                                        class="text-primary">{{ __('dashboard.view_all') }}</a>
                                </div>
                                <div class="card-body">
                                    <ul class="list-unstyled mb-0">
                                        @foreach ($data['popular_doctors'] as $doctor)
                                            <li class="d-flex align-items-center py-3 border-bottom">
                                                <img src="{{ $doctor->profile_image ?? default_user_avatar() }}"
                                                    alt="01" class="rounded-pill avatar avatar-50" loading="lazy">
                                                <div class="ms-3">
                                                    <h6 class="mb-0">{{ $doctor->full_name }}</h6>
                                                    <small>

                                                        <div class="d-flex  align-items-center">
                                                            <div>

                                                                @php
                                                                    
                                                                    $integerPart = floor($doctor['average_rating']);
                                                                    $decimalPart = $doctor['average_rating'] - $integerPart;
                                                                    
                                                                @endphp

                                                                @for ($i = 1; $i <= $integerPart; $i++)
                                                                    <svg width="14" height="15"
                                                                        viewBox="0 0 14 15" fill="none"
                                                                        xmlns="http://www.w3.org/2000/svg">
                                                                        <path
                                                                            d="M7.68341 0.952137L9.24195 4.24897C9.35677 4.48783 9.57592 4.6537 9.82867 4.69056L13.3294 5.22726C13.5339 5.25748 13.7194 5.37102 13.8447 5.54426C13.9687 5.7153 14.0219 5.93204 13.9918 6.14509C13.9673 6.32202 13.8881 6.48569 13.767 6.61101L11.2304 9.19938C11.0448 9.38 10.9608 9.64761 11.0056 9.90932L11.6302 13.5482C11.6967 13.9876 11.4201 14.4019 11.0056 14.4852C10.8348 14.514 10.6597 14.4838 10.5057 14.4012L7.38305 12.6886C7.1513 12.5655 6.87754 12.5655 6.64579 12.6886L3.52312 14.4012C3.13944 14.6157 2.66403 14.4697 2.45049 14.0716C2.37137 13.9131 2.34336 13.7325 2.36927 13.5563L2.9938 9.91669C3.03861 9.65572 2.9539 9.38664 2.76906 9.20602L0.232412 6.61912C-0.0693531 6.31244 -0.078455 5.80745 0.212107 5.48971C0.218409 5.48307 0.22541 5.4757 0.232412 5.46833C0.352838 5.33931 0.511072 5.25748 0.681908 5.2361L4.18266 4.69867C4.43471 4.66108 4.65386 4.49668 4.76939 4.25634L6.27191 0.952137C6.40564 0.669045 6.6829 0.492851 6.98396 0.500223H7.07778C7.33894 0.533397 7.56649 0.703695 7.68341 0.952137Z"
                                                                            fill="#FFD566" />
                                                                    </svg>
                                                                @endfor

                                                                @if ($decimalPart > 0)
                                                                    <svg width="14" height="15"
                                                                        viewBox="0 0 14 15" fill="none"
                                                                        xmlns="http://www.w3.org/2000/svg">
                                                                        <path
                                                                            d="M7.68341 0.952137L9.24195 4.24897C9.35677 4.48783 9.57592 4.6537 9.82867 4.69056L13.3294 5.22726C13.5339 5.25748 13.7194 5.37102 13.8447 5.54426C13.9687 5.7153 14.0219 5.93204 13.9918 6.14509C13.9673 6.32202 13.8881 6.48569 13.767 6.61101L11.2304 9.19938C11.0448 9.38 10.9608 9.64761 11.0056 9.90932L11.6302 13.5482C11.6967 13.9876 11.4201 14.4019 11.0056 14.4852C10.8348 14.514 10.6597 14.4838 10.5057 14.4012L7.38305 12.6886C7.1513 12.5655 6.87754 12.5655 6.64579 12.6886L3.52312 14.4012C3.13944 14.6157 2.66403 14.4697 2.45049 14.0716C2.37137 13.9131 2.34336 13.7325 2.36927 13.5563L2.9938 9.91669C3.03861 9.65572 2.9539 9.38664 2.76906 9.20602L0.232412 6.61912C-0.0693531 6.31244 -0.078455 5.80745 0.212107 5.48971C0.218409 5.48307 0.22541 5.4757 0.232412 5.46833C0.352838 5.33931 0.511072 5.25748 0.681908 5.2361L4.18266 4.69867C4.43471 4.66108 4.65386 4.49668 4.76939 4.25634L6.27191 0.952137C6.40564 0.669045 6.6829 0.492851 6.98396 0.500223H7.07778C7.33894 0.533397 7.56649 0.703695 7.68341 0.952137Z"
                                                                            fill="#C0C2D4" />
                                                                    </svg>
                                                                @else
                                                                    @for ($i = 1; $i <= 5 - $integerPart; $i++)
                                                                        <svg width="14" height="15"
                                                                            viewBox="0 0 14 15" fill="none"
                                                                            xmlns="http://www.w3.org/2000/svg">
                                                                            <path
                                                                                d="M7.68341 0.952137L9.24195 4.24897C9.35677 4.48783 9.57592 4.6537 9.82867 4.69056L13.3294 5.22726C13.5339 5.25748 13.7194 5.37102 13.8447 5.54426C13.9687 5.7153 14.0219 5.93204 13.9918 6.14509C13.9673 6.32202 13.8881 6.48569 13.767 6.61101L11.2304 9.19938C11.0448 9.38 10.9608 9.64761 11.0056 9.90932L11.6302 13.5482C11.6967 13.9876 11.4201 14.4019 11.0056 14.4852C10.8348 14.514 10.6597 14.4838 10.5057 14.4012L7.38305 12.6886C7.1513 12.5655 6.87754 12.5655 6.64579 12.6886L3.52312 14.4012C3.13944 14.6157 2.66403 14.4697 2.45049 14.0716C2.37137 13.9131 2.34336 13.7325 2.36927 13.5563L2.9938 9.91669C3.03861 9.65572 2.9539 9.38664 2.76906 9.20602L0.232412 6.61912C-0.0693531 6.31244 -0.078455 5.80745 0.212107 5.48971C0.218409 5.48307 0.22541 5.4757 0.232412 5.46833C0.352838 5.33931 0.511072 5.25748 0.681908 5.2361L4.18266 4.69867C4.43471 4.66108 4.65386 4.49668 4.76939 4.25634L6.27191 0.952137C6.40564 0.669045 6.6829 0.492851 6.98396 0.500223H7.07778C7.33894 0.533397 7.56649 0.703695 7.68341 0.952137Z"
                                                                                fill="#C0C2D4" />
                                                                        </svg>
                                                                    @endfor
                                                                @endif
                                                            </div>
                                                        </div>


                                                    </small>
                                                </div>
                                            </li>
                                        @endforeach

                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-4 col-lg-6">
                            <div class="card card-block card-stretch card-height">
                                <div class="card-header">
                                    <h5 class="card-title mb-0">{{ __('dashboard.top') }} {{ __('dashboard.services') }}</h5>
                                </div>
                                <div class="card-body">
                                    <div class="row justify-content-between">
                                        <div id="chart-06" class="col-md-5 col-lg-12 col-xxl-5"></div>
                                        <div class="col-md-7 col-lg-12 col-xxl-7">
                                               
                                        @php
                                        $legendColors = ['#FD866E', '#FFAA99', '#FFD5CC', '#F0F0F0'];
                                        $colorIndex = 0;
                                        @endphp

                                        @foreach ($data['topservice'] as $topservice)
                                        <div class="d-flex align-items-center mb-1">
                                            <svg width="12" height="12" viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <circle cx="6" cy="6" r="6" fill="{{ $legendColors[$colorIndex % count($legendColors)] }}" />
                                            </svg>
                                            <div class="ms-2 d-flex align-items-center">
                                                <h6 class="mb-0 ms-2">{{ number_format($topservice->count * 100 / $data['totalservice'], 2)  }}%</h6>
                                                <h6 class="ms-2 mb-0 line-count-1">{{ $topservice->service->name }}</h6>
                                            </div>
                                            
                                        </div>
                                        <div class="ms-5 mb-3 ">
                                                <small>{{ $topservice->count }} Total Service Booked Till Now</small>
                                            </div>
                                        @php
                                        $colorIndex++;
                                        @endphp
                                        
                                        @endforeach
                                         
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection

@push('after-styles')
    <style>
        #chart-01 {
            min-height: 17.4rem !important;
        }

        #chart-04 {
            min-height: 300px !important;
        }

        #chart-03 {
            min-height: 300px !important;
        }

        @media (max-width: 991.98px) {
            #chart-04 {
                min-height: 250px !important;
            }

            #chart-03 {
                min-height: 200px !important;
            }
        }
    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/apexcharts/3.40.0/apexcharts.min.css"
        integrity="sha512-tJYqW5NWrT0JEkWYxrI4IK2jvT7PAiOwElIGTjALSyr8ZrilUQf+gjw2z6woWGSZqeXASyBXUr+WbtqiQgxUYg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
@endpush
@push('after-scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/apexcharts/3.40.0/apexcharts.min.js"
        integrity="sha512-Kr1p/vGF2i84dZQTkoYZ2do8xHRaiqIa7ysnDugwoOcG0SbIx98erNekP/qms/hBDiBxj336//77d0dv53Jmew=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>



    <script>
        $(document).ready(function() {
            /*---------------------------------------------------------------------
                      Progress Bar
            -----------------------------------------------------------------------*/
            const progressBarInit = (elem) => {
                const currentValue = elem.getAttribute('aria-valuenow')
                elem.style.width = '0%'
                elem.style.transition = 'width 2s'
                if (typeof Waypoint !== typeof undefined) {
                    new Waypoint({
                        element: elem,
                        handler: function() {
                            setTimeout(() => {
                                elem.style.width = currentValue + '%'
                            }, 100);
                        },
                        offset: 'bottom-in-view',
                    })
                }
            }
            const customProgressBar = document.querySelectorAll('[data-toggle="progress-bar"]')
            Array.from(customProgressBar, (elem) => {
                progressBarInit(elem)
            })
            /*---------------------------------------------------------------------
                          Chart
            -----------------------------------------------------------------------*/
          //////////////////////////////// chart-1 //////////////////////////////////////////

            revanue_chart('year');

         //////////////////////////////// chart-2 //////////////////////////////////////////

            if (document.querySelectorAll('#chart-02').length) {
                const variableColors = IQUtils.getVariableColor();
                const colors = [variableColors.secondary, variableColors.primary];
                const top_product = <?php echo json_encode($data['top_product']); ?>;
                const name = [];
                const total_sale_count = [];

                top_product.forEach(product => {
                    name.push(product.name); 
                    total_sale_count.push(product.total_sale_count); 
                });

                const minTotalSaleCount = 1;
                if (total_sale_count.every(count => count === 0)) {
                    total_sale_count[0] = minTotalSaleCount;
                }

                var options = {
                
                    series: total_sale_count,
                    chart: {
                        type: 'donut',
                        height: 250,
                    },
                    dataLabels: {
                        enabled: false
                    },
                    legend: {
                        show: false,
                    },
                    theme: {
                        monochrome: {
                            enabled: true,
                            color: '#9D67EF',
                            shadeTo: '',
                            shadeIntensity: 0.9
                        }
                    },
                    responsive: [{
                        breakpoint: 480,
                        options: {
                            chart: {
                                width: 200
                            },
                            legend: {
                                position: 'bottom'
                            }
                        }
                    }]
                };

               


                const chart = new ApexCharts(document.querySelector("#chart-02"), options);
                chart.render();
            }

        //////////////////////////////// chart-3 //////////////////////////////////////////   


           getprofitChartData('year');

          

        //////////////////////////////// chart-4 //////////////////////////////////////////

            getBookingChartData('year');

        ///////////////////////////// chart-5 ///////////////////////////////////////////////

           getBookingstatusData('year')

         ///////////////////////////// chart-6 ///////////////////////////////////////////////   


            if (document.querySelectorAll('#chart-06').length) {
                const variableColors = IQUtils.getVariableColor();
                const colors = [variableColors.secondary, variableColors.primary];
                const topservice = <?php echo json_encode($data['topservice']); ?>;
                
                console.log(topservice);
                const counts = [];
                const service_ids = [];
                topservice.forEach(service => {
                    counts.push(service.count);
                    service_ids.push(service.service_id);
                });

                var options = {
                    series: counts,
                    chart: {
                        type: 'donut',
                        height: 200,
                    },
                    dataLabels: {
                        enabled: false
                    },
                    legend: {
                        show: false,
                    },
                    theme: {
                        monochrome: {
                            enabled: true,
                            color: '#FD866E',
                            shadeTo: 'light',
                            shadeIntensity: 0.9
                        }
                    },
                    responsive: [{
                        breakpoint: 480,
                        options: {
                            chart: {
                                width: 200
                            },
                            legend: {
                                position: 'bottom'
                            }
                        }
                    }]
                };

                const chart = new ApexCharts(document.querySelector("#chart-06"), options);
                chart.render();
            }
        })

        var chart = null;
        var booking_chart=null;
        var booking_status_chart=null;
        var profit_chart=null;

        function revanue_chart(type) {

            var Base_url="{{ url('/') }}";

            var url = Base_url+"/app/get_revnue_chart_data/" + type;

            $("#loader").show();

            $.ajax({

                url: url,
                method: "GET",
                success: function(response) {

                    $("#loader").hide();

                    $(".monthly_revenue").text(type);


                    if (document.querySelectorAll("#chart-01").length) {

                        const variableColors = IQUtils.getVariableColor();
                        const colors = [variableColors.primary, variableColors.secondary];

                        const monthlyTotals = response.data.chartData;
                        const category = response.data.category;


                        const options = {
                            series: [{
                                name: 'total',
                                data: monthlyTotals
                            }],
                            chart: {
                                fontFamily: '"Inter", sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol", "Noto Color Emoji"',
                                height: 283,
                                type: 'area',
                                toolbar: {
                                    show: false
                                },
                                sparkline: {
                                    enabled: false,
                                },
                            },
                            colors: colors,
                            dataLabels: {
                                enabled: false
                            },
                            stroke: {
                                curve: 'smooth',
                                width: 3,
                            },

                            legend: {
                                show: true,
                            },
                            yaxis: {
                                 labels: {
                                     formatter: function (value) {
                                         return formatCurrencyVue(value); 
                                     }
                                 }
                             },
                           
                            xaxis: {
                                labels: {
                                    minHeight: 22,
                                    maxHeight: 22,
                                    show: true,
                                },
                                 
                                lines: {
                                    show: false //or just here to disable only x axis grids
                                },
                                categories: category,
                                axisBorder: {
                                    show: false,

                                },
                                axisTicks: {
                                    show: false,

                                },
                            },
                            grid: {
                                show: true,
                                strokeDashArray: 3,
                            },
                            fill: {
                                type: 'gradient',
                                gradient: {
                                    shade: 'dark',
                                    type: "vertical",
                                    shadeIntensity: 0,
                                    gradientToColors: undefined, // optional, if not defined - uses the shades of same color in series
                                    inverseColors: true,
                                    opacityFrom: .4,
                                    opacityTo: .1,
                                    // stops: [0, 50, 80],
                                    colors: ["#975dee"]
                                }
                            },
                            tooltip: {
                                enabled: false,
                            },
                        };

                        if (chart != null) {
                            chart.destroy();
                        }


                        chart = new ApexCharts(
                            document.querySelector("#chart-01"), options
                        );
                        chart.render();
                    }

                }
            });

        }

        function getBookingChartData(type) {

             var Base_url="{{ url('/') }}";

            var url =Base_url+"/app/get_booking_chart_data/" + type;

            $("#booking_loader").show();

            $.ajax({

                url: url,
                method: "GET",
                success: function(response) {

                      const monthlyBookings = response.data.chartData;
                        const category = response.data.category;

                    $("#booking_loader").hide();

                    $(".monthly_booking").text(type);


                    if (jQuery("#chart-04").length) {
                        const variableColors = IQUtils.getVariableColor();
                        const colors = [variableColors.primary, variableColors.primary];
                        const options = {
                            series: [{
                                name: 'Bookings',
                                data: monthlyBookings
                            }],
                            chart: {
                                height: 300,
                                type: 'bar',
                                toolbar: {
                                    show: false
                                },
                            },
                            plotOptions: {
                                bar: {
                                    borderRadius: 5,
                                    columnWidth: '35%',
                                }
                            },
                            colors: [
                                function({
                                    value,
                                }) {
                                    if(value < 8) {
                                        return '#FD866E'
                                    } else {
                                        return '#FD866E'
                                    }
                                }
                            ],
                            states: {
                                normal: {
                                    filter: {
                                        type: 'none',
                                        value: 0,
                                    }
                                },
                                hover: {
                                    filter: {
                                        type: 'none',
                                        value: 1,
                                    }
                                },
                                active: {
                                    allowMultipleDataPointsSelection: false,
                                    filter: {
                                        type: 'none',
                                        value: 1,
                                    }
                                },
                            },
                            legend: {
                                show: false
                            },
                            dataLabels: {
                                enabled: false
                            },
                            grid: {
                                show: false,
                            },
                            tooltip: {
                                enabled: true,
                            },
                            xaxis: {
                                categories:category,
                                labels: {
                                    minHeight: 22,
                                    maxHeight: 22
                                },
                                axisTicks: {
                                    show: false
                                },
                                axisBorder: {
                                    show: false
                                },
                            },

                            yaxis: {
                                axisBorder: {
                                    show: false
                                },
                                axisTicks: {
                                    show: false,
                                },
                                
                                labels: {
                                    minWidth: 20,
                                    maxWidth: 20,
                                    offsetX: -5
                                }

                            },
                            responsive: [{
                                breakpoint: 480,
                                options: {
                                    chart: {
                                        height: 250
                                    }
                                }
                            }]
                        };

                        if (booking_chart != null) {
                            booking_chart.destroy();
                        }

                        booking_chart = new ApexCharts(document.querySelector("#chart-04"), options);
                        booking_chart.render();
                    }
                }
            });

        }

        function getBookingstatusData(type){


             var Base_url="{{ url('/') }}";

              var url =Base_url+"/app/get_booking_status_chart_data/" + type;

          //  $("#loader").show();

            $.ajax({

                url: url,
                method: "GET",
                success: function(response) {

                    $(".booking_status").text(type);


            if (document.querySelectorAll('#chart-05').length) {

                const variableColors = IQUtils.getVariableColor();
                const colors = [variableColors.secondary, variableColors.primary];

                 const total_bookings_status = response.data;
                 
                 total_bookings_status.forEach((status, index) => {
    const divId = `booking_count_${index}`;
    const statusText = status; 


    $(`#${divId}`).text(statusText);
});
                var options = {
                    series: total_bookings_status,
                    chart: {
                        width: '100%',
                        height: 233,
                        type: 'pie',
                    },
                    theme: {
                        monochrome: {
                            enabled: true,
                            color: '#9D67EF',
                            shadeTo: 'light',
                            shadeIntensity: 0.9
                        }
                    },
                    plotOptions: {
                        pie: {
                            dataLabels: {
                                offset: -5
                            }
                        }
                    },
                    legend: {
                        show: false
                    }
                };

                  if (booking_status_chart != null) {
                            booking_status_chart.destroy();
                        }
                  booking_status_chart = new ApexCharts(document.querySelector("#chart-05"), options);
                 booking_status_chart.render();
                }


                }
            });
        }

        function getprofitChartData(type){

              var Base_url="{{ url('/') }}";

            var url = Base_url+"/app/get_profit_chart_data/" + type;

            $("#loader").show();

            $.ajax({

                url: url,
                method: "GET",
                success: function(response) {

                    $("#loader").hide();

                    $(".profit_chart").text(type);

                      if (document.querySelectorAll('#chart-03').length) {
                        
                const variableColors = IQUtils.getVariableColor();
                const colors = [variableColors.secondary, variableColors.primary];
                  const monthlyTotals = response.data.chartData;
                        const category = response.data.category;

                var options = {
                    series: [{
                        name: 'Profit By Service',
                        data: monthlyTotals
                    }],
                    chart: {
                        type: 'bar',
                        height: 300,
                        toolbar: {
                            show: false
                        }
                    },
                    colors: colors,
                    plotOptions: {
                        bar: {
                            horizontal: false,
                            columnWidth: '28%',
                            borderRadius: 5,
                            endingShape: 'rounded'
                        },
                    },
                    grid: {
                        show: true,
                        strokeDashArray: 3,
                    },
                    dataLabels: {
                        enabled: false,
                    },
                    xaxis: {
                        categories:category,
                        labels: {
                            show: true,
                        }
                    },
                   
                    fill: {
                        opacity: 1
                    },
                      yaxis: {
                                 labels: {
                                     formatter: function (value) {
                                         return value.toFixed(2); 
                                     }
                                 }
                             },
                           
                    tooltip: {
                        y: {
                             formatter: function (value) {
                                return  formatCurrencyVue(value); 
                             }
                        }
                    },
                    responsive: [{
                        breakpoint: 480,
                        options: {
                            chart: {
                                height: 250
                            }
                        }
                    }]

                };


                        if (profit_chart != null) {
                            profit_chart.destroy();
                        }

                        profit_chart = new ApexCharts(document.querySelector("#chart-03"), options);
                        profit_chart.render();
                    
                  }

                }
            });
        }


        const formatCurrencyVue = (value) => {
           if (window.currencyFormat !== undefined) {
             return window.currencyFormat(value)
           }
           return value
        }

    </script>
@endpush
