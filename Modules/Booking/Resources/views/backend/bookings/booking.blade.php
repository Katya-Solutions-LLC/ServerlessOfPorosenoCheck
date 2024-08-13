@extends('backend.layouts.app')

@section('title')
{{ __($module_title) }}
@endsection
@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="card card-block card-stretch card-height">
            <div class="card-body">
                <div class="d-flex justify-content-between flex-wrap">
                    <div class="d-flex gap-3 align-items-center">
                        <img src="{{ $booking->user->profile_image ?? default_user_avatar() }}" alt="avatar" class="avatar avatar-70 rounded-pill">
                        <div class="text-start">
                            <h5 class="m-0">{{ $booking->user->full_name ?? default_user_name() }}</h5>
                            <span>{{ $booking->user->email ?? '--' }}</span>
                        </div>
                    </div>
                    <div class="d-flex gap-5 align-items-center">
                        <div class="flex-column">
                            <span class="mb-2">{{ __('pet.pet_name') }}</span>
                            <h6 class="m-0"> <img src="{{  optional($booking->pet)->pet_image ?? default_user_avatar() }}" alt="avatar" class="avatar avatar-30 rounded-pill"> {{ $booking->pet ? optional($booking->pet)->name : '--' }}</h6>
                        </div>
                        <div class="flex-column">
                            <span class="mb-2">{{ __('pet.pet_breed') }}</span>
                            <h6 class="m-0">{{ $booking->pet ? optional(optional($booking->pet)->breed)->name : '--' }}</h6>
                        </div>
                        <div class="flex-column">
                            <span class="mb-2">{{ __('booking.lbl_status') }}</span>
                            <h6 class="m-0">{{ ucfirst($booking->status) }}</h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-12">
        <div class="card card-block card-stretch card-height">
            <div class="card-body">
                <div class="row gap-5 mb-5">
                    <div class="col-md-3">
                        <span>{{ __('booking.lbl_date') }}</span>
                        <h6 class="m-0">{{ date('d-m-Y', strtotime($booking->start_date_time)) }}</h6>
                    </div>
                    <div class="col-md-3">
                        <span>{{ __('booking.lbl_time') }}</span>
                        <h6 class="m-0">At {{ date('h:i A', strtotime($booking->start_date_time)) }}</h6>
                    </div>
                    <div class="col-md-3">
                        @if($booking->booking_type === 'boarding')
                        <span>{{ __('booking.lbl_care_taker') }} {{ __('booking.lbl_name') }}</span>

                            @if($booking->employee === Null)
                              <h6 class="m-0">--</h6>
                            @else
                              <h6 class="m-0">   <img src="{{ $booking->employee->profile_image ?? default_user_avatar() }}" alt="avatar" class="avatar avatar-50 rounded-pill"> {{ $booking->employee->first_name.' '.$booking->employee->last_name }}</h6>
                            @endif

                        @elseif($booking->booking_type === 'veterinary')
                        <span>{{ __('booking.lbl_vet') }} {{ __('booking.lbl_name') }}</span>

                            @if($booking->employee === Null)
                              <h6 class="m-0">--</h6>
                            @else
                              <h6 class="m-0">  <img src="{{ $booking->employee->profile_image ?? default_user_avatar() }}" alt="avatar" class="avatar avatar-50 rounded-pill"> {{ $booking->employee->first_name.' '.$booking->employee->last_name }}</h6>
                            @endif

                        @elseif($booking->booking_type === 'grooming')
                        <span>{{ __('booking.lbl_groomer') }} {{ __('booking.lbl_name') }}</span>

                            @if($booking->employee === Null)
                              <h6 class="m-0">--</h6>
                            @else
                              <h6 class="m-0">   <img src="{{ $booking->employee->profile_image ?? default_user_avatar() }}" alt="avatar" class="avatar avatar-50 rounded-pill"> {{ $booking->employee->first_name.' '.$booking->employee->last_name }}</h6>
                            @endif

                        @elseif($booking->booking_type === 'training')
                        <span>{{ __('booking.lbl_trainer') }} {{ __('booking.lbl_name') }}</span>
                         
                            @if($booking->employee === Null)
                              <h6 class="m-0">--</h6>
                            @else
                              <h6 class="m-0">  <img src="{{ $booking->employee->profile_image ?? default_user_avatar() }}" alt="avatar" class="avatar avatar-50 rounded-pill">  {{ $booking->employee->first_name.' '.$booking->employee->last_name }}</h6>
                            @endif 

                        @elseif($booking->booking_type === 'walking')
                        <span>{{ __('booking.lbl_walker') }} {{ __('booking.lbl_name') }}</span>

                            @if($booking->employee === Null)
                              <h6 class="m-0">--</h6>
                            @else
                              <h6 class="m-0">  <img src="{{ $booking->employee->profile_image ?? default_user_avatar() }}" alt="avatar" class="avatar avatar-50 rounded-pill">  {{ $booking->employee->first_name.' '.$booking->employee->last_name }}</h6>
                            @endif

                        @elseif($booking->booking_type === 'daycare')
                        <span>{{ __('booking.lbl_daycare_taker') }} {{ __('booking.lbl_name') }}</span>

                            @if($booking->employee === Null)
                              <h6 class="m-0">--</h6>
                            @else
                              <h6 class="m-0"> <img src="{{ $booking->employee->profile_image ?? default_user_avatar() }}" alt="avatar" class="avatar avatar-70 rounded-pill"> {{ $booking->employee->first_name.' '.$booking->employee->last_name }}</h6>
                            @endif 
                        @endif
                    </div>
                </div>
                <div class="border-top"></div>
                <div class="row gap-5 pt-5">
                    <div class="col-md-3">
                        <span>{{ __('booking.lbl_payment_status') }}</span>
                        @if(isset($booking->payment->payment_status))
                        @if($booking->payment->payment_status == 0)
                        <p class="m-0 text-secondary">{{__('booking.pending')}}</p>
                        @else
                        <h6 class="mb-4">{{__('booking.paid')}}</h6>

                        <span>{{ __('booking.lbl_payment_method') }}</span>

                        <h6 class="m-0">Paid with {{ ucfirst($booking->payment->transaction_type) }}</h6>


                        @endif
                        @else
                        <h6 class="m-0">--</h6>
                        @endif
                    </div>
                    <div class="col-md-3">
                        <span>{{ __('booking.lbl_contact_number') }}</span>
                        <h6 class="m-0">{{ $booking->user->mobile }}</h6>
                    </div>
                    <div class="col-md-3">
                        <span>{{ __('booking.lbl_reason') }}</span>
                        @if(isset($booking->veterinary->reason))
                        <h6 class="m-0">{{ $booking->veterinary->reason }}</h6>
                        @else
                        <h6 class="m-0">--</h6>
                        @endif
                    </div>
                    @if(isset($booking->veterinary))
                    <div class="col-md-3">
                    

                       @if($booking->veterinary->service->type=='video-consultancy')

                         @if($booking->veterinary->start_video_link !='' && $booking->veterinary->join_video_link !='')
                        
                          <a href={{$booking->veterinary->start_video_link}} class="badge booking-status bg-soft-success p-3" target="_blank"> {{__('booking.start_video')}} </a>
                          <a href={{$booking->veterinary->start_video_link}} class="badge booking-status bg-soft-danger p-3" target="_blank"> {{__('booking.join_video')}} </a>
                    
                        @endif

                        @endif
                       
                    </div>
                @endif
                </div>
            </div>
        </div>
    </div>
    @if($booking->booking_extra_info !='')
    <div class="col-md-3">
        <div class="card card-block card-stretch card-height">
            <div class="card-body">
                <div class="flex-column">
                    <h5>{{ __('booking.lbl_addition_information') }}</h5>
                    <span class="m-0">{{ $booking->booking_extra_info }}</span>
                </div>
            </div>
        </div>
    </div>
    @endif
    <div class="col-lg-12">
        <div class="row">
            <div class="col-md-3">
            </div>
            <div class="col-md-9">
                <div class="card card-block card-stretch card-height">
                    <div class=" card-header">
                        <h5 class="card-title mb-0">{{__('booking.your_appointment')}}</h5>
                        {{-- <span class="m-0">{{ $booking->booking_extra_info }}</span> --}}
                    </div>
                    <div class="card-body">
                        <div class="d-flex align-items-center detail-header p-4 rounded">
                            <div class="detail-box bg-white rounded">
                                <img src="{{ $booking->systemservice->feature_image ?? default_user_avatar() }}" alt="avatar" class="avatar avatar-80 rounded-pill">
                            
                            </div>



                            <div class="ms-3 w-100 d-flex align-items-center justify-content-between flex-wrap">

                                <div class="d-flex align-items-center">
                                    <span><b>{{ $booking->systemservice->name}}</b> ({{$booking->systemservice->description}})</span>
                                </div>
                                <h5 class="mb-0 w-50 text-lg-end text-sm-start">{{ Currency::format( $booking->service_amount) }}</h5>
                            </div>
                        </div>
                        <ul class="list-unstyled pt-4 mb-0">
                            <?php
                            if($booking->payment !=null){

                                $tax=json_decode($booking->payment->tax_percentage, true);

                            }
                            
                            ?>
                            @foreach($tax as $t)
                            @if($t['type'] == 'percentage')
                            <li class="d-flex align-items-center justify-content-between pb-2 border-bottom border-light">
                                <span>{{$t['title']}} ({{$t['value']}}%)</span>
                                <?php
                                $tax_amount= $booking->service_amount*$t['value']/100;
                                ?>
                                <span class="text-primary">{{Currency::format($tax_amount)}}</span>
                            </li>
                            @elseif($t['type'] == 'fixed')
                            <li class="d-flex align-items-center justify-content-between pb-2 border-bottom border-light">
                                <span>{{$t['title']}}</span>
                                <span class="text-primary">{{ Currency::format($t['value']) }}</span>
                            </li>
                            @endif
                            @endforeach
                            <li class="d-flex align-items-center justify-content-between pt-5">
                                <h5 class="mb-0">{{__('booking.total')}}</h5>
                                <h5 class="mb-0">{{ Currency::format( $booking->total_amount) }}</h5>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('after-styles')
<style>
    .detail-header {
        background-color: #FBF8FF;
    }

    .detail-box {
        padding: 0.625rem 0.813rem;
    }

</style>
<link rel="stylesheet" href="{{ asset('vendor/datatable/datatables.min.css') }}">
@endpush

@push('after-scripts')
<script src="{{ asset('vendor/datatable/datatables.min.js') }}"></script>
<script src="{{ mix('modules/booking/script.js') }}"></script>
<script src="{{ asset('js/form-offcanvas/index.js') }}" defer></script>
@endpush
