@extends('backend.layouts.app')

@section('title')
    {{ __($module_title) }}
@endsection

@section('content')
    <style>
        .alternate-list {
            display: flex;
            flex-direction: column;
            margin-bottom: 0;
        }
        .alternate-list li:not(:last-child){
            padding-bottom: 1rem;
            margin-bottom: 1rem;
            border-bottom: 1px solid var(--bs-border-color);
        }
    </style>

<style type="text/css" media="print">
      @page :footer {
        display: none !important;
      }

      @page :header {
        display: none !important;
      }
      @page { size: landscape; }
      /* @page { margin: 0; } */

      .pr-hide {
        display: none;
        }

        	
    .order_table tr td div{
           white-space: normal;
        }

      button {
        display: none !important;
      }
      * {
        -webkit-print-color-adjust: none !important;   /* Chrome, Safari 6 – 15.3, Edge */
        color-adjust: none !important;                 /* Firefox 48 – 96 */
        print-color-adjust: none !important;           /* Firefox 97+, Safari 15.4+ */
      }
    </style>

    <div class="row pr-hide">
        <div class="col-12">
            <div class="card ">
                <div class="card-header border-bottom-0">
                    <div class="row pr-hide">
                        @php
                            $expected_delivery_date = \Carbon\Carbon::parse($orderItem->expected_delivery_date)->format('d-m-Y');
                        @endphp

                        @if($checkVendor)
                            <div class="col-auto col-lg-4 mb-4">
                                <div class="d-flex">
                                    <span class="w-75 mt-2">Expected Delivery Date:</span>
                                    <input type="text" name="expected_delivery_date" value="{{ $expected_delivery_date }}" id="expected_delivery_date" placeholder="Select Date" class="expected_delivery_date form-control" readonly />
                                </div>
                            </div>

                            @if($orderItem->payment_status !== 'paid')
                            <div class="col-auto col-lg-3 mb-4">
                                <div class="input-group">
                                    <select class="form-select select2" name="payment_status"
                                        data-minimum-results-for-search="Infinity" id="update_payment_status">
                                        <option value="" disabled>
                                        {{__('product.payment_status')}}
                                        </option>

                                        <option value="pending" {{ $orderItem->payment_status == 'pending' ? 'selected' : '' }}>
                                            Pending
                                        </option>

                                        @if($orderItem->delivery_status == 'delivered')
                                        <option value="paid" {{ $orderItem->payment_status == 'paid' ? 'selected' : '' }}>
                                        {{__('product.lbl_paid')}}
                                        </option>
                                        @endif
                                        
                                        <option value="unpaid" {{ $orderItem->payment_status == 'unpaid' ? 'selected' : '' }}>
                                        {{__('product.unpaid')}}
                                        </option>
                                    </select>
                                </div>
                            </div>
                            @endif
                            @if($orderItem->delivery_status !== 'delivered' && $orderItem->delivery_status !== 'cancelled')
                            <div class="col-auto col-lg-3 mb-4">
                                <div class="input-group">
                                    <select name="delivery_status" class="form-control select2"
                                        data-ajax--url="{{ route('backend.get_order_status_data', ['type' => 'constant', 'sub_type' => 'ORDER_STATUS', 'delivery_status' => $orderItem->delivery_status]) }}"
                                        data-ajax--cache="true">
                                        <option value="" disabled>{{__('product.delivery_status')}}</option>
                                        @if (isset($orderItem->delivery_status))
                                            <option value="{{ $orderItem->delivery_status }}" selected>
                                                {{ Str::title(Str::replace('_', ' ', $orderItem->delivery_status)) }}
                                            </option>
                                        @endif
                                    </select>
                                </div>
                            </div>
                            @endif
                        @endif


                        <div class="col-auto col-lg-2 mb-4">
                            <a class="btn btn-primary" onclick="invoicePrint(this)">
                                <i class="fa-solid fa-download"></i>
                                {{__('product.download_invoice')}}
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <!--Main Invoice-->
        <div class="col-xl-9 order-2 order-md-2 order-lg-2 order-xl-1">
            <div class="card mb-4" id="section-1">
                <div class="card-body">
                    <!--Order Detail-->
                    <div class="row justify-content-between align-items-center g-3 mb-4">
                        <div class="col-auto flex-grow-1">
                            {{-- <img src="{{ asset(setting('logo')) }}" alt="logo" class="img-fluid" width="200"> --}}
                            <div class="welcome-message">
                                <h5 class="mb-2">Customer Info</h6>
                                    <p class="mb-0">Name: <strong>{{ optional(optional($orderItem->order)->user)->full_name }}</strong></p>
                                    <p class="mb-0">Email: <strong>{{ optional(optional($orderItem->order)->user)->email }}</strong></p>
                                    <p class="mb-0">Phone: <strong>{{ optional(optional($orderItem->order)->user)->mobile }}</strong></p>
                            </div>
                        </div>
                        <div class="col-auto text-end">
                            <h5 class="mb-0">{{__('product.invoice')}}
                                <span
                                    class="text-accent">{{ setting('inv_prefix') }}{{ optional(optional($orderItem->order)->orderGroup)->order_code }}
                                </span>
                            </h5>
                            <span class="text-muted">{{__('product.order_date')}}:
                                {{ date('d M, Y', strtotime($orderItem->created_at)) }}
                            </span>
                            @if ($orderItem->order->location_id != null)
                                <div>
                                    <span class="text-muted">
                                        <i class="las la-map-marker"></i> {{ optional(optional($orderItem->order)->location)->name }}
                                    </span>
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="d-flex justify-content-md-between justify-content-center g-3">
                        <div class="col-auto">
                            <!--Customer Detail-->
                            {{-- <div class="welcome-message">
                                <h5 class="mb-2">Customer Info</h6>
                                    <p class="mb-0">Name: <strong>{{ optional(optional($orderItem->order)->user)->full_name }}</strong></p>
                                    <p class="mb-0">Email: <strong>{{ optional(optional($orderItem->order)->user)->email }}</strong></p>
                                    <p class="mb-0">Phone: <strong>{{ optional(optional($orderItem->order)->user)->mobile }}</strong></p>
                            </div> --}}
                            <div class="col-auto mt-3">
                                <h6 class="d-inline-block">{{__('product.payment_method')}} </h6>
                                <span class="badge bg-primary">{{ ucwords(str_replace('_', ' ', optional(optional($orderItem->order)->orderGroup)->payment_method)) }}</span>
                            </div>
                            <h6 class="col-auto d-inline-block">{{__('product.logistic')}} </h6> <span class="badge bg-primary">{{ $orderItem->order->logistic_name }}</span>
                        </div>
                        <div class="col-auto">
                            <div class="shipping-address d-flex justify-content-md-end gap-3 mb-3">
                                <div class="border-end w-25">
                                    @php
                                        $shippingAddress = optional(optional($orderItem->order)->orderGroup)->shippingAddress;
                                    @endphp

                                    @if($shippingAddress)
                                        <h5 class="mb-2">{{__('product.shipping_address')}}</h5>
                                        
                                        <p class="mb-0 text-wrap">
                                            {{ optional($shippingAddress)->address_line_1 }},
                                            {{ optional($shippingAddress->city_data)->name }},
                                            {{ optional($shippingAddress->state_data)->name }},
                                            {{ optional($shippingAddress->country_data)->name }}
                                        </p>
                                    @endif
                                </div>
                                @if (!$orderItem->order->orderGroup->is_pos_order)
                                    <div class="w-25">
                                        @php
                                            $billingAddress = optional(optional($orderItem->order)->orderGroup)->billingAddress;
                                        @endphp
                                        
                                        @if($billingAddress)
                                        <h5 class="mb-2">{{__('product.billing_address')}}</h5>
                                        
                                        <p class="mb-0 text-wrap">
                                            {{ optional($billingAddress)->address_line_1 }},
                                            {{ optional($billingAddress->city_data)->name }},
                                            {{ optional($billingAddress->state_data)->name }},
                                            {{ optional($billingAddress->country_data)->name }}
                                        </p>
                                        @endif
                                    </div>
                                @endif
                            </div>
                            <!-- <div class="shipping-address d-flex justify-content-md-end gap-3">
                                <div class="w-25"></div>
                                <div class="w-25">

                                </div>
                            </div> -->
                        </div>
                    </div>
                </div>

                <!--order details-->
                <table class="table table-bordered border-top order_table" data-use-parent-width="true">
                    <thead>
                        <tr>
                            <th class="text-center" width="7%">{{__('product.s_l')}}</th>
                            <th>{{__('product.title')}}</th>
                            <th>{{__('product.unit_price')}}</th>
                            <th>{{__('product.qty')}}</th>
                            <th class="text-end">{{__('product.total_price')}}</th>
                        </tr>
                    </thead>

                    <tbody>
                            @php
                                $user = auth()->user();
                                $product = optional($orderItem->product_variation)->product;
                                $totalprice = $orderItem->total_price;
                                $totalTaxAmount = $orderItem->total_tax;
                                $totalShippingCost = $orderItem->total_shipping_cost;
                                $totalOrderPrice = $totalprice + $totalTaxAmount + $totalShippingCost;
                            @endphp
                            <tr>
                                <td> 1 </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                    <div>
                                        <img src="{{ optional($product)->feature_image ?? default_user_avatar() }}" alt="{{ optional($product)->name }}"
                                            class="avatar avatar-50 rounded-pill">
                                    </div>

                                        <div class="ms-2">
                                            <h6 class="fs-sm mb-0">
                                                {{ optional($product)->name ? optional($product)->name : '--' }}
                                            </h6>
                                            @if(!empty($orderItem->product_variation))
                                            <div class="text-muted">
                                                @foreach (generateVariationOptions($orderItem->product_variation->combinations) as $variation)
                                                    <span class="fs-xs">
                                                        {{ $variation['name'] }}:
                                                        @foreach ($variation['values'] as $value)
                                                            {{ $value['name'] }}
                                                        @endforeach
                                                        @if (!$loop->last)
                                                            ,
                                                        @endif
                                                    </span>
                                                @endforeach
                                            </div>
                                            @endif
                                        </div>
                                    </div>
                                </td>

                                <td class="">
                                    <span class="fw-bold">{{ \Currency::format($orderItem->unit_price) }}
                                    </span>
                                </td>
                                <td class="fw-bold">{{ $orderItem->qty }}</td>

                                <td class=" text-end">
                                    @if ($orderItem->refundRequest && $orderItem->refundRequest->refund_status == 'refunded')
                                        <span
                                            class="badge bg-soft-info rounded-pill text-capitalize">{{ $orderItem->refundRequest->refund_status }}</span>
                                    @endif
                                    <span class="text-accent fw-bold">{{ \Currency::format($orderItem->total_price) }}
                                    </span>

                                </td>

                            </tr>
                    </tbody>
                    <tfoot class="text-end">
                       
                         
                        <tr>
                            <td colspan="4">
                                <h6 class="d-inline-block me-3">Tax : </h6>
                            </td>
                            <td width="10%" class="text-end">
                                <strong>{{ \Currency::format($orderItem->total_tax) }}</strong></td>
                        </tr>
                        
                        <tr>
                            <td colspan="4">
                                <h6 class="d-inline-block me-3">{{__('product.shipping_cost')}} </h6>
                            </td>
                            <td width="10%" class="text-end">
                                <strong>{{ \Currency::format($orderItem->total_shipping_cost) }}</strong></td>
                        </tr>
                        <tr>
                            <td colspan="4">
                                <h6 class="d-inline-block me-3">{{__('product.total')}} </h6>
                            </td>
                        
                            <td width="10%"><strong>{{ \Currency::format($totalOrderPrice) }}</strong></td>
                            
                        </tr>
                        @if (optional(optional($orderItem->order)->orderGroup)->total_coupon_discount_amount > 0)
                            <tr>
                                <td colspan="4">
                                    <h6 class="d-inline-block me-3">{{__('product.coupon_discount')}} </h6>
                                </td>
                                <td width="10%" class="text-end">
                                    <strong>{{ \Currency::format(optional(optional($orderItem->order)->orderGroup)->total_coupon_discount_amount) }}</strong>
                                </td>
                            </tr>
                        @endif
                       
                         
                    </tfoot>
                </table>

                <!-- other items in this order -->
                @if($otherItems->isNotEmpty())
                <h5 class="my-5 mx-4">{{__('product.other_item_lbl')}}</h5>

                @foreach($otherItems as $key => $item)
                    <table class="table table-bordered border-top order_table" data-use-parent-width="true">
                        <thead>
                            <tr>
                                <th class="text-center" width="7%">{{__('product.s_l')}}</th>
                                <th>{{__('product.title')}}</th>
                                <th>{{__('product.unit_price')}}</th>
                                <th>{{__('product.qty')}}</th>
                                <th class="text-end">{{__('product.total_price')}}</th>
                            </tr>
                        </thead>

                        <tbody>
                            @php
                                $product = optional($item->product_variation)->product;
                                $totalprice = $item->total_price;
                                $totalTaxAmount = $item->total_tax;
                                $totalShippingCost = $item->total_shipping_cost;
                                $totalOrderPrice = $totalprice + $totalTaxAmount + $totalShippingCost;
                            @endphp
                            <tr>
                                <td> {{ $key + 1 }} </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                    <div>
                                        <img src="{{ optional($product)->feature_image ?? default_user_avatar() }}" alt="{{ optional($product)->name }}"
                                            class="avatar avatar-50 rounded-pill">
                                    </div>

                                        <div class="ms-2">
                                            <h6 class="fs-sm mb-0">
                                                {{ optional($product)->name ? optional($product)->name : '--' }}
                                            </h6>
                                            @if(!empty($orderItem->product_variation))
                                            <div class="text-muted">
                                                @foreach (generateVariationOptions($item->product_variation->combinations) as $variation)
                                                    <span class="fs-xs">
                                                        {{ $variation['name'] }}:
                                                        @foreach ($variation['values'] as $value)
                                                            {{ $value['name'] }}
                                                        @endforeach
                                                        @if (!$loop->last)
                                                            ,
                                                        @endif
                                                    </span>
                                                @endforeach
                                            </div>
                                            @endif
                                        </div>
                                    </div>
                                </td>

                                <td class="">
                                    <span class="fw-bold">{{ \Currency::format($item->unit_price) }}
                                    </span>
                                </td>
                                <td class="fw-bold">{{ $item->qty }}</td>

                                <td class=" text-end">
                                    @if ($item->refundRequest && $item->refundRequest->refund_status == 'refunded')
                                        <span
                                            class="badge bg-soft-info rounded-pill text-capitalize">{{ $item->refundRequest->refund_status }}</span>
                                    @endif
                                    <span class="text-accent fw-bold">{{ \Currency::format($item->total_price) }}
                                    </span>

                                </td>

                            </tr>
                        </tbody>
                        <tfoot class="text-end">
                            
                            
                            <tr>
                                <td colspan="4">
                                    <h6 class="d-inline-block me-3">Tax : </h6>
                                </td>
                                <td width="10%" class="text-end">
                                    <strong>{{ \Currency::format($item->total_tax) }}</strong></td>
                            </tr>
                            
                            <tr>
                                <td colspan="4">
                                    <h6 class="d-inline-block me-3">{{__('product.shipping_cost')}} </h6>
                                </td>
                                <td width="10%" class="text-end">
                                    <strong>{{ \Currency::format($orderItem->total_shipping_cost) }}</strong></td>
                            </tr>
                            <tr>
                                <td colspan="4">
                                    <h6 class="d-inline-block me-3">{{__('product.total')}} </h6>
                                </td>
                            
                                <td width="10%"><strong>{{ \Currency::format($totalOrderPrice) }}</strong></td>
                                
                            </tr>
                            @if (optional(optional($orderItem->order)->orderGroup)->total_coupon_discount_amount > 0)
                                <tr>
                                    <td colspan="4">
                                        <h6 class="d-inline-block me-3">{{__('product.coupon_discount')}} </h6>
                                    </td>
                                    <td width="10%" class="text-end">
                                        <strong>{{ \Currency::format(optional(optional($orderItem->order)->orderGroup)->total_coupon_discount_amount) }}</strong>
                                    </td>
                                </tr>
                            @endif
                            
                        </tfoot>
                    </table>
                @endforeach
                @endif
                <table class="table order_table" data-use-parent-width="true">
                    <tfoot class="text-end">
                    @if(!auth()->user()->hasRole('pet_store'))
                        <tr>
                            <td colspan="4" style="border-style: none;">
                                <h6 class="d-inline-block me-3">{{__('product.grand_total')}} </h6>
                            </td>
                           
                            <td width="10%" class="text-end" style="border-style: none;">
                                <strong class="text-accent">{{ \Currency::format(optional(optional($orderItem->order)->orderGroup)->grand_total_amount) }}</strong>
                            </td>
                             
                        </tr>
                        @endif
                    </tfoot>
                </table>
                <!--Note-->
                <div class="card-body">
                    <div class="card-footer border-top-0 px-4 py-4 rounded bg-soft-gray border border-2">
                        <p class="mb-0">{{ setting('spacial_note') }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!--Order Status-->
        <div class="col-xl-3 order-1 order-md-1 order-lg-1 order-xl-2 pr-hide">
            <div class="sticky-sidebar">
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="card-title">{{__('product.order_status')}}</h5>
                    </div>
                    <div class="card-body">
                        <ul class="alternate-list list-unstyled">
                            @forelse ($orderUpdates as $orderUpdate)
                                <li>
                                    <a class="{{ $loop->first ? 'active' : '' }}">
                                        {{ $orderUpdate->note }} <br> {{__('product.by')}}
                                        <span class="text-capitalize">{{ optional($orderUpdate->user)->first_name }}</span>
                                        at
                                        {{ date('d M, Y', strtotime($orderUpdate->created_at)) }}.</a>
                                </li>
                            @empty
                                <li>
                                    <a class="active">{{__('product.no_logs_found')}}</a>
                                </li>
                            @endforelse
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('after-scripts')
    <script>
        function invoicePrint() {
            window.print()
        }

        const range_flatpicker = document.querySelectorAll('.expected_delivery_date')

        Array.from(range_flatpicker, (elem) => {
            if (typeof flatpickr !== typeof undefined) {
                flatpickr(elem, {
                    dateFormat: "d-m-Y",
                })
            }
        })

        function updateStatusAjax(__this, url) {
            $.ajax({
                url: url,
                type: 'POST',
                dataType: 'json',
                data: {
                    order_item_id: {{ $orderItem->id }},
                    status: __this.val(),
                    _token: '{{ csrf_token() }}'
                },
                success: function(res) {
                    if (res.status) {
                        window.successSnackbar(res.message)
                        setTimeout(() => {
                            location.reload()
                        }, 100);
                    }
                }
            });
        }
        $('[name="payment_status"]').on('change', function() {
            if ($(this).val() !== '') {
                updateStatusAjax($(this), "{{ route('backend.orders.update_payment_status') }}")
            }
        })

        $('[name="delivery_status"]').on('change', function() {
            if ($(this).val() !== '') {
                updateStatusAjax($(this), "{{ route('backend.orders.update_delivery_status') }}")
            }
        })


        $('#expected_delivery_date').on('change', function () {
            var item_id = {{ $orderItem->id }};
            var expected_delivery_date = $(this).val();

            $.ajax({
                url: "{{ route('backend.orders.update_delivery_date') }}",
                type: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    item_id: item_id,
                    expected_delivery_date: expected_delivery_date
                },
                success: function (response) {
                    if (response.status) {
                        window.successSnackbar(response.message)
                    } 
                }
            });
        });
    </script>
@endpush