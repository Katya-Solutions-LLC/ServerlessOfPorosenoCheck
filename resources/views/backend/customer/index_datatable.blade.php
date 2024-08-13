@extends('backend.layouts.app')

@section('title')
    {{ __($module_action) }} {{ __($module_title) }}
@endsection


@push('after-styles')
    <link rel="stylesheet" href="{{ mix('modules/constant/style.css') }}">
@endpush
@section('content')
    <div class="card">
        <div class="card-body">
            <x-backend.section-header>
                <i class="{{ $module_icon }}"></i> {{ $module_title }} {{ __($module_action) }}
                <x-slot name="subtitle">
                    @lang(':module_name Data For Status, List etc.', ['module_name' => Str::title($module_name)])
                </x-slot>
                <x-slot name="toolbar">
                  <x-buttons.offcanvas target='#form-offcanvas' class=" d-flex align-items-center gap-1" title="{{ __('Create') }} {{ __($module_title) }}">{{ __('messages.new') }}</x-buttons.offcanvas>
                </x-slot>
            </x-backend.section-header>
            <div class="row mt-4">
              <div class="col">
                  <div class="table-responsive">
                      <table id="datatable" class="table table-hover ">
                      </table>
                  </div>
              </div>
          </div>
        </div>
    </div>

    <div data-render="app">
        <customer-form-offcanvas
            create-title="{{ __('Create') }} {{ __($module_title) }}"
            edit-title="{{ __('Edit') }} {{ __($module_title) }}">
        </customer-form-offcanvas>
    </div>
@endsection

@push('after-styles')
    <!-- DataTables Core and Extensions -->
    <link rel="stylesheet" href="{{ asset('vendor/datatable/datatables.min.css') }}">
@endpush

@push('after-scripts')
    <script src="{{ mix('js/vue.min.js') }}"></script>
    <script src="{{ asset('js/form-offcanvas/index.js') }}" defer></script>
    <script type="text/javascript" src="{{ asset('vendor/datatable/datatables.min.js') }}"></script>

    <script type="text/javascript" defer>
      document.addEventListener('DOMContentLoaded', (event) => {
          window.renderedDataTable = $('#datatable').DataTable({
                  processing: true,
                  serverSide: true,
                  autoWidth: false,
                  responsive: true,
                  dom: '<"row align-items-center"<"col-md-6" l><"col-md-6" f>><"table-responsive my-3" rt><"row align-items-center" <"col-md-6" i><"col-md-6" p>><"clear">',
                  ajax: '{{ route("backend.users.index_data", $roleBaseList ?? "all") }}',
                  drawCallback: function() {
                      if(laravel !== undefined) {
                          window.laravel.initialize();
                      }
                  },
                  columns: [{
                          data: 'id',
                          name: 'id',
                          title: 'ID'
                      },
                      {
                          data: 'full_name',
                          name: 'full_name',
                          title: "{{__('customer.lbl_fullname')}}"
                      },
                      {
                          data: 'first_name',
                          name: 'first_name',
                          title: "{{__('customer.lbl_first_name')}}"
                      },
                      {
                          data: 'email',
                          name: 'email',
                          title: "{{__('customer.lbl_Email')}}"
                      },
                      {
                          data: 'status',
                          name: 'status',
                          orderable: false,
                          searchable: false,
                          title: "{{__('customer.lbl_status')}}"
                      },
                      {
                          data: 'action',
                          name: 'action',
                          orderable: false,
                          searchable: false,
                          title: "{{__('customer.lbl_action')}}"
                      }
                  ]
              });
      })
      </script>
@endpush
