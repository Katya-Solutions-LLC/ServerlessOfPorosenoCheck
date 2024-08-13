@extends('backend.layouts.app')

@section('title') {{ __($module_title) }} @endsection

@section('content')
    <div class="card">
        <div class="card-body">
            <x-backend.section-header>
                <div class="d-flex flex-wrap gap-3">
                    <!-- <x-backend.quick-action url="{{ route('backend.products.bulk_action') }}">
                        <div class="">
                            <select name="action_type" class="form-control select2 col-12" id="quick-action-type"
                                style="width:100%">
                                <option value="">{{ __('messages.no_action') }}</option>
                                <option value="change-status">{{ __('messages.status') }}</option>
                            </select>
                        </div>
                        <div class="select-status d-none quick-action-field" id="change-status-action">
                            <select name="status" class="form-control select2" id="status" style="width:100%">
                                <option value="1" selected>{{ __('messages.active') }}</option>
                                <option value="0">{{ __('messages.inactive') }}</option>
                            </select>
                        </div>
                    </x-backend.quick-action> -->
                    <!-- <div>
                      <button type="button" class="btn btn-secondary" data-modal="export">
                        <i class="fa-solid fa-download"></i> Export
                      </button>
                    </div> -->
                </div>
                <x-slot name="toolbar">
                    <div class="flex-grow-1">
                      <div class="input-group">
                          <div class="input-group-prepend">
                              <span class="input-group-text rounded-end-0">{{setting('inv_prefix')}}</span>
                          </div>
                          <input type="text" class="form-control order-code" placeholder="{{__('product.code')}}" name="code" value="{{ isset($searchCode) ? $searchCode : '' }}">
                      </div>
                    </div>
                    <div>
                        <div class="datatable-filter" style="width: 100%; display: inline-block;">
                            <select name="payment_status" id="payment_status" class="select2 form-control" data-filter="select">
                                <option value="">{{__('product.payment_status')}}</option>
                                   <option value="pending">{{__('product.pending')}}</option>
                                <option value="paid">{{__('product.lbl_paid')}}</option>
                                <option value="unpaid">{{__('product.unpaid')}}</option>
                            </select>
                        </div>
                    </div>
                    <div>
                        <div class="datatable-filter" style="width: 100%; display: inline-block;">
                            <select name="delivery_status" id="delivery_status" class="select2 form-control" data-filter="select">
                                <option value="">{{__('product.delivery_status')}}</option>
                                <option value="order_placed">{{__('product.order_placed')}}</option>
                                <option value="pending">{{__('product.pending')}}</option>
                                <option value="processing">{{__('product.processing')}}</option>
                                <option value="delivered">{{__('product.delivered')}}</option>
                                <option value="cancelled">{{__('product.cancelled')}}</option>
                            </select>
                        </div>
                    </div>
                    <div class="input-group flex-nowrap">
                        <span class="input-group-text" id="addon-wrapping"><i class="fa-solid fa-magnifying-glass"></i></span>
                        <input type="text" name="table_search" class="form-control dt-search" placeholder="{{__('messages.search')}}">
                    </div>
                </x-slot>
            </x-backend.section-header>
            <table id="datatable" class="table table-striped border table-responsive">
            </table>
        </div>
    </div>
    {{--<x-backend.advance-filter>
        <x-slot name="title">
            <h4>{{ __('service.lbl_advanced_filter') }}</h4>
        </x-slot>
        <button type="reset" class="btn btn-danger" id="reset-filter">{{__('product.reset')}}</button>
    </x-backend.advance-filter>--}}

    <div data-render="app">
        <seller-form-offcanvas create-title="Seller List"></seller-form-offcanvas>
    </div>
@endsection

@push ('after-styles')
<link rel="stylesheet" href='{{ mix("modules/product/style.css") }}'>
<!-- DataTables Core and Extensions -->
<link rel="stylesheet" href="{{ asset('vendor/datatable/datatables.min.css') }}">
@endpush

@push ('after-scripts')
<script src='{{ mix("modules/product/script.js") }}'></script>
<script src="{{ asset('js/form-offcanvas/index.js') }}" defer></script>
<script src="{{ asset('js/form-modal/index.js') }}" defer></script>
<!-- DataTables Core and Extensions -->
<script type="text/javascript" src="{{ asset('vendor/datatable/datatables.min.js') }}"></script>

<script type="text/javascript" defer>
        const columns = [
            // {
            //     name: 'check',
            //     data: 'check',
            //     title: '<input type="checkbox" class="form-check-input" name="select_all_table" id="select-all-table" onclick="selectAllTable(this)">',
            //     width: '0%',
            //     exportable: false,
            //     orderable: false,
            //     searchable: false,
            // },
            {
                data: 'order_code',
                name: 'order_code',
                title: "{{ __('product.order_code') }}",
                orderable: false,
                searchable: false,
            },
            {
                data: 'customer_name',
                name: 'customer_name',
                title: "{{ __('product.customer') }}",
                orderable: false,
            },
            @if(enableMultivendor() == "1" && auth()->user()->hasRole('admin') || auth()->user()->hasRole('demo_admin'))
            {
                data: 'seller_name',
                name: 'seller_name',
                title: "{{ __('product.seller') }}",
                orderable: false,
            },
            @endif
            
            {
                data: 'placed_on',
                name: 'placed_on',
                title: "{{ __('product.placed_on') }}",
                orderable: false,
                searchable: false,
            },
          
             {
                data: 'total_amount',
                name: 'total_amount',
                title: "Total Amount",
                searchable: false,
                
            },
            {
                data: 'payment',
                name: 'payment',
                title: "{{ __('product.payment') }}",
                orderable: false,
                searchable: false,
            },
            {
                data: 'status',
                name: 'status',
                title: "{{ __('product.status') }}",
                orderable: false,
                searchable: false,
            },
           
            {
              data: 'updated_at',
              name: 'updated_at',
              title: "{{ __('product.lbl_update_at') }}",
              orderable: true,
              visible: false,
           },

        ]


        const actionColumn = [{
            data: 'action',
            name: 'action',
            orderable: false,
            searchable: false,
            title: "{{ __('service.lbl_action') }}",
            width: '5%'
        }]

        let finalColumns = [
            ...columns,
            ...actionColumn
        ]

        var orderColumn = [[ 6, "desc" ]];  
        @if(auth()->user()->hasRole('admin') || auth()->user()->hasRole('demo_admin'))
            orderColumn = [[ 7, "desc" ]];  
        @endif

        document.addEventListener('DOMContentLoaded', (event) => {
            initDatatable({
                url: '{{ route("backend.$module_name.index_data",["commission_employee_id" => $commission_employee_id]) }}',
                finalColumns,
                orderColumn: orderColumn,
                advanceFilter: () => {
                    return {
                    search: $('[name="table_search"]').val(),
                    code: $('[name="code"]').val(),
                    delivery_status: $('[name="delivery_status"]').val(),
                    payment_status: $('[name="payment_status"]').val(),
                    location_id: $('[name="location_id"]').val()
                  }
                }
            });
        })

        function resetQuickAction() {
          const actionValue = $('#quick-action-type').val();
          if (actionValue != '') {
              $('#quick-action-apply').removeAttr('disabled');

              if (actionValue == 'change-status') {
                  $('.quick-action-field').addClass('d-none');
                  $('#change-status-action').removeClass('d-none');
              } else {
                  $('.quick-action-field').addClass('d-none');
              }

          } else {
              $('#quick-action-apply').attr('disabled', true);
              $('.quick-action-field').addClass('d-none');
          }
      }

      $('#quick-action-type').change(function() {
          resetQuickAction()
      });

      $(document).on('input', '.order-code', function() {
        window.renderedDataTable.ajax.reload(null, false)
      })
</script>
@endpush
