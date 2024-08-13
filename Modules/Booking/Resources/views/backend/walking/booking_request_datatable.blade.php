@extends('backend.layouts.app')

@section('title')
  {{ __($module_title) }}
@endsection
@section('content')
<div class="card">
  <div class="card-header">
    <x-backend.section-header>
      <div>
        <x-backend.quick-action url="{{route('backend.bookings.bulk_action')}}">
          <div class="">
            <select name="action_type" class="form-control select2 col-12" id="quick-action-type" style="width:100%">
              <option value="">{{ __('messages.no_action') }}</option>
              {{-- <option value="change-status">{{ __('messages.status') }}</option> --}}
              <option value="delete">{{ __('messages.delete') }}</option>
            </select>
          </div>
          <div class="select-status d-none quick-action-field" id="change-status-action">
            <select name="status" class="form-control select2" id="status" style="width:100%">
              @foreach ($booking_status as $key => $value)
              <option value="{{ $value->name }}" {{$filter['status'] == $value->name ? "selected" : ''}}>{{ $value->value }}</option>
              @endforeach
            </select>
          </div>
        </x-backend.quick-action>
      </div>
      <x-slot name="toolbar">
        <div>
          <div class="datatable-filter">
            {{-- <select name="column_status" id="column_status" class="select2 form-control p-10" data-filter="select" style="width: 100%">
              <option value="">{{__('booking.all_status')}}</option>
              @foreach ($booking_status as $key => $value)
              <option value="{{ $value->name }}" {{$filter['status'] == $value->name ? "selected" : ''}}>{{ $value->value }}</option>
              @endforeach
            </select> --}}
          </div>
        </div>
        <div class="input-group flex-nowrap">
          <span class="input-group-text" id="addon-wrapping"><i class="icon-Search"></i></span>
          <input type="text" class="form-control form-control-sm dt-search" placeholder="Search..." aria-label="Search" aria-describedby="addon-wrapping">
          
        </div>
    
      </x-slot>
    </x-backend.section-header>
  </div>
  <div class="card-body p-0" id="booking-datatable">
    <table id="datatable" class="table table-striped border table-responsive">
    </table>
  </div>
  <x-backend.advance-filter>
    <x-slot name="title">
      <h4> {{ __('booking.lbl_advanced_filter') }}</h4>
    </x-slot>
    <form action="javascript:void(0)" class="datatable-filter">
      <div class="form-group">
        <label for="form-label"> {{ __('booking.lbl_booking_date') }}</label>
        <input type="text" name="booking_date" id="booking_date" class="booking-date-range form-control" readonly />
      </div>
      <div class="form-group">
        <label for="form-label"> {{ __('booking.lbl_customer_name') }} </label>
        <select name="filter_user_id" id="column_user_id" name="column_user_id" data-filter="select" class="select2 form-control" data-ajax--url="{{ route('backend.get_search_data', ['type' => 'customers']) }}" data-ajax--cache="true">
        </select>
      </div>
      <div class="form-group">
        <label for="form-label"> {{ __('booking.lbl_staff_name') }} </label>
        <select name="filter_employee_id" id="column_employee_id" name="column_employee_id" data-filter="select" class="select2 form-control" data-ajax--url="{{ route('backend.get_search_data', ['type' => 'employees']) }}" data-ajax--cache="true">
        </select>
      </div>
      <div class="form-group">
        <label for="form-label"> {{ __('booking.lbl_services') }} </label>
        <select name="filter_service_id" id="column_service_id" name="column_service_id[]" data-filter="select" class="select2 form-control" multiple data-ajax--url="{{ route('backend.get_search_data', ['type' => 'services']) }}" data-ajax--cache="true">
        </select>
      </div>
      <button type="reset" class="btn btn-danger" id="reset-filter">Reset</button>
    </form>
  </x-backend.advance-filter>
  <div data-render="app">
    <walker-form create-title="{{ __('messages.create') }} {{ __($create_title) }}"
            edit-title="{{ __('messages.edit') }} {{ __('booking.lbl_walking') }} {{ __('booking.singular_title') }} "></walker-form>
</div>
</div>
@endsection

@push('after-styles')
<!-- DataTables Core and Extensions -->
<link rel="stylesheet" href="{{ asset('vendor/datatable/datatables.min.css') }}">
@endpush

@push('after-scripts')
<script src="{{ asset('vendor/datatable/datatables.min.js') }}"></script>
<script src="{{ mix('modules/booking/script.js') }}"></script>
<script src="{{ asset('js/form-offcanvas/index.js') }}" defer></script>
<!-- DataTables Core and Extensions -->

<script type="text/javascript">
  const range_flatpicker = document.querySelectorAll('.booking-date-range')
  Array.from(range_flatpicker, (elem) => {
    if (typeof flatpickr !== typeof undefined) {
      flatpickr(elem, {
        mode: "range",
        dateFormat: "Y-m-d",
      })
    }
  })
  const columns = [{
      name: 'check',
      data: 'check',
      title: '<input type="checkbox" class="form-check-input" name="select_all_table" id="select-all-table" onclick="selectAllTable(this)">',
      width: '0%',
      exportable: false,
      orderable: false,
      searchable: false,
    },
    {
      data: 'id',
      name: 'id',
      title: "{{ __('booking.lbl_id') }}",
      searchable: false,
      orderable: true,
    },
    {
      data: 'user_id',
      name: 'user_id',
      title: "{{ __('booking.lbl_customer_name') }}",
    },
    {
      data: 'start_date_time',
      name: 'start_date_time',
      title: "{{ __('booking.lbl_date') }}",
    },
    {
      data: 'pet_name',
      name: 'pet_name',
      title: "{{ __('booking.pet_name') }}",
      orderable: true,
      searchable: true,
    },
    {
      data: 'pettype_id',
      name: 'pettype_id',
      title: "{{ __('booking.petdetail') }}",
      orderable: true,
      searchable: true,
    },
    @if(auth()->user()->hasRole('admin')|| auth()->user()->hasRole('demo_admin') )
    {
      data: 'employee_id',
      name: 'employee_id',
      title: "{{ __('booking.lbl_walker') }}"
    },
    @endif
   
    {
      data: 'duration',
      name: 'duration',
      title: "{{ __('booking.lbl_service_time') }}",
      orderable: true,
      searchable: true,
    },
    {
      data: 'service_amount',
      name: 'service_amount',
      title: "{{ __('booking.price') }}",
      orderable: true,
      searchable: true,
    },
    {
      data: 'updated_at',
      name: 'updated_at',
      title: "{{ __('booking.lbl_update_at') }}"
    },
    {
      data: 'status',
      name: 'status',
      orderable: true,
      searchable: true,
      title: "{{ __('booking.lbl_status') }}",
      width: '10%',
    },
    {
      data: 'payment_status',
      name: 'payment_status',
      orderable: false,
      searchable: false,
      title: "{{ __('booking.lbl_payment_status') }}",
      width: '10%',
    },
  ]

  const actionColumn = [{
    data: 'action',
    name: 'action',
    orderable: false,
    searchable: false,
    title: "{{ __('booking.lbl_action') }}",
    width: '10%'
  }]

  let finalColumns = [
    ...columns,
    ...actionColumn
  ]

  document.addEventListener('DOMContentLoaded', (event) => {
    initDatatable({
      url: '{{ route("backend.walking.index_data",["booking_type" => $booking_type]) }}',
      finalColumns,
      orderColumn: [[ 9, 'desc' ]],
      advanceFilter: () => {
        return {
          booking_date: $('#booking_date').val(),
          user_id: $('#column_user_id').val(),
          emploee_id: $('#column_employee_id').val(),
          service_id: $('#column_service_id').val(),
        }
      }
    })
  })
  const offcanvasElem = document.querySelector('#offcanvasExample')
  offcanvasElem.addEventListener('shown.bs.offcanvas', function() {
    $('form.datatable-filter .select2').select2({
      dropdownParent: $('#offcanvasExample')
    });
  })

  $('#reset-filter').on('click', function(e) {
    $('#column_status').val('')
    $('#booking_date').val('')
    $('#column_user_id').val('')
    $('#column_employee_id').val('')
    $('#column_service_id').val('')
    $('form.datatable-filter .select2').empty()
    $('form.datatable-filter .select2').select2()
    window.renderedDataTable.ajax.reload(null, false)
  })

  $('#booking_date').on('change', function() {
    window.renderedDataTable.ajax.reload(null, false)
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
  
  document.addEventListener('DOMContentLoaded', function() {
    var type = '<?php echo $type; ?>';
   
    if (type === 'new') {

      var myOffcanvas = document.getElementById('form-offcanvas')
      var bsOffcanvas = new bootstrap.Offcanvas(myOffcanvas)
          bsOffcanvas.show()
      
    } else {
    
    }
  });
</script>
@endpush
